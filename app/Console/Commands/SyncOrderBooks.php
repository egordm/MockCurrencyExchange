<?php

namespace App\Console\Commands;

use App\External\BinanceAPI;
use App\Models\Order;
use App\Models\ValutaPair;
use App\Repositories\OrderRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SyncOrderBooks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orderbook:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize Order Book';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

	/**
	 * Execute the console command.
	 *
	 * @throws \Exception
	 * @throws \Illuminate\Support\Facades\ContainerExceptionInterface
	 * @throws \Illuminate\Support\Facades\NotFoundExceptionInterface
	 * @throws \Throwable
	 */
    public function handle()
    {
	    foreach (ValutaPair::all() as $pair) {
		    $this->doMerge($pair);
	    }
    }

	/**
	 * Shares orders between multiple bots
	 * @param ValutaPair $pair
	 * @param User[] $bots
	 * @param array $data
	 * @param bool $buy
	 * @return array
	 */
	private function shareOrders(ValutaPair $pair, $bots, $data, $buy)
	{
		$n_bots = count($bots); // TODO: how about we split into orders instead of bots :P
		$weight = weighted_average_max(array_values($data));
		$ret = [];
		foreach ($data as $price => $quantity) {
			$distribution = random_distribution($n_bots, 0.95 - $quantity / $weight);
			for ($i = 0; $i < count($bots); $i++) {
				if ($distribution[$i] == 0) continue;
				$order = new Order([
					'valuta_pair_id' => $pair->id,
					'price' => floatval($price),
					'quantity' => $quantity * $distribution[$i],
					'buy' => $buy,
					'fee' => 0,
					'type' => 0
				]);
				$order->user_id = $bots[$i]->id;

				$ret[] = $order;
			}
		}
		return $ret;
	}

	/**
	 * @param ValutaPair $market
	 * @throws \Exception
	 * @throws \Illuminate\Support\Facades\ContainerExceptionInterface
	 * @throws \Illuminate\Support\Facades\NotFoundExceptionInterface
	 * @throws \Throwable
	 */
	public function doMerge(ValutaPair $market)
	{
		$this->info('Syncing Orderbook for ' . $market->external_symbol->symbol . ' #'.$market->id);
		$depth = \App::get(BinanceAPI::class)->depth($market->external_symbol->symbol);
		$bots = User::bots(['open_orders']);
		$orderRespository = \App::get(OrderRepository::class);

		/** @noinspection PhpUnhandledExceptionInspection */
		\DB::transaction(function () use ($bots, $market, $orderRespository) {
			// Cancel partially filled orders
			foreach ($bots as $bot) {
				foreach ($bot->open_orders as $order) {
					if ($order->getFilledQuantity() > 0) $orderRespository->closeOrder($order);
				}
			}
			// Kill the rest
			Order::where('status', Order::STATUS_OPEN)
				->whereIn('user_id', $bots->pluck("id")->toArray())
				->where('valuta_pair_id', $market->id)->delete();
		});

		$orders_sell = $this->shareOrders($market, $bots, $depth['asks'], false);
		$orders_buy = $this->shareOrders($market, $bots, $depth['bids'], true);
		$this->info('Creating ' . count($orders_sell) . ' sell orders and ' . count($orders_buy) . ' buy orders');
		$orders = array_merge($orders_sell, $orders_buy);

		/** @noinspection PhpUnhandledExceptionInspection */
		\DB::transaction(function () use ($orders) {
			foreach ($orders as $order) $order->save();
		});

		$market->updated_external_at = Carbon::now();
		$market->save();
	}
}
