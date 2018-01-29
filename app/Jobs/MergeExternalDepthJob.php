<?php

namespace App\Jobs;

use App\External\BinanceAPI;
use App\Models\Order;
use App\Models\ValutaPair;
use App\Repositories\OrderRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MergeExternalDepthJob implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	private $market;

	/**
	 * Create a new job instance.
	 *
	 * @param ValutaPair $market
	 */
	public function __construct(ValutaPair $market)
	{
		$this->market = $market;
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
	 * Execute the job.
	 *
	 * @return void
	 * @throws \Exception
	 * @throws \Illuminate\Support\Facades\ContainerExceptionInterface
	 * @throws \Illuminate\Support\Facades\NotFoundExceptionInterface
	 * @throws \Throwable
	 */
	public function handle()
	{
		$depth = \App::get(BinanceAPI::class)->depth($this->market->external_symbol->symbol);
		$bots = User::bots(['open_orders']);
		$orderRespository = \App::get(OrderRepository::class);

		/** @noinspection PhpUnhandledExceptionInspection */
		\DB::transaction(function () use ($bots, $orderRespository) {
			// Cancel partially filled orders
			foreach ($bots as $bot) {
				foreach ($bot->open_orders as $order) {
					if ($order->getFilledQuantity() > 0) $orderRespository->closeOrder($order);
				}
			}
			// Kill the rest
			Order::where('status', Order::STATUS_OPEN)->delete();
		});

		$orders = $this->shareOrders($this->market, $bots, $depth['asks'], false);
		$orders += $this->shareOrders($this->market, $bots, $depth['bids'], true);

		/** @noinspection PhpUnhandledExceptionInspection */
		\DB::transaction(function () use ($orders) {
			foreach ($orders as $order) $order->save();
		});

		$this->market->updated_external_at = Carbon::now();
		$this->market->save();
	}
}
