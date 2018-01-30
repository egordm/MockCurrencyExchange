<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 3-12-2017
 * Time: 11:48
 */

namespace App\Repositories;


use App\Models\Balance;
use App\Models\CandlestickNode;
use App\Models\Order;
use App\Models\Valuta;
use App\Models\ValutaPair;
use App\Repositories\Criteria\ActiveOrderCriteria;
use App\Repositories\Criteria\BySymbolCriteria;
use App\Repositories\Criteria\HoldQuantityCriteria;
use App\Repositories\Criteria\OrderValutaCriteria;
use App\Repositories\Criteria\WithBalanceCriteria;
use App\Repositories\Presenters\BalanceValutaPresenter;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class BalanceRepository extends PresentableRepository
{
	/**
	 * Specify Model class name
	 *
	 * @return mixed
	 */
	public function model()
	{
		return Balance::class;
	}

	/**
	 * @param User $user
	 * @param null $symbols
	 * @return mixed
	 * @throws \Illuminate\Support\Facades\ContainerExceptionInterface
	 * @throws \Illuminate\Support\Facades\NotFoundExceptionInterface
	 * @throws \Prettus\Repository\Exceptions\RepositoryException
	 */
	public function getBalances(User $user, $symbols = null)
	{
		$useValuta = !empty($symbols);
		$repo = $useValuta ? \App::get(ValutaRepository::class) : $this;
		$repo->pushCriteria(new HoldQuantityCriteria(\Auth::user(), $useValuta ? 'valuta.id' : 'balances.valuta_id'));
		if (!$useValuta) return $this->with(['valuta'])->findWhere(['balances.user_id' => $user->id]);

		$repo->pushCriteria(new BySymbolCriteria($symbols, !$useValuta));
		$repo->pushCriteria(new WithBalanceCriteria(\Auth::user()));
		$repo->setPresenter(BalanceValutaPresenter::class);
		return $repo->all();
	}

	public function getBalance(User $user, Valuta $valuta)
	{
		return $this->findWhere(['user_id' => $user->id, 'valuta_id' => $valuta->id]);
	}

	/**
	 * Get balance for given valuta that is not useable. Not usable means it has been reserved for an order.
	 * @param User $user
	 * @param Valuta $valuta
	 * @return int
	 * @throws \Illuminate\Support\Facades\ContainerExceptionInterface
	 * @throws \Illuminate\Support\Facades\NotFoundExceptionInterface
	 */
	public function getHaltedBalance(User $user, Valuta $valuta)
	{
		/** @noinspection PhpUnhandledExceptionInspection */
		$orderRepository = \App::get(OrderRepository::class);
		$orderRepository->pushCriteria(new OrderValutaCriteria($valuta));
		$orderRepository->pushCriteria(new ActiveOrderCriteria());
		$orders = $orderRepository->skipPresenter()->getOrders($user);
		$orderRepository->clearCriteria();

		$ret = 0;
		foreach ($orders as $order) $ret += $order->sellQuantity();
		return $ret;
	}

	const CANDLE_SELECTOR = 'SELECT *, ABS(CAST(open_time as SIGNED) - ?) AS distance FROM candlestick_nodes WHERE valuta_pair_id = ? ORDER BY distance ASC LIMIT 1';

	/**
	 * @param Balance[]|array $balances
	 * @param Carbon|null $date
	 * @return float|int
	 */
	public function getConvertedBalance($balances, $date = null)
	{
		if (empty($date)) $date = Carbon::now();

		$ret = 0;
		$usdId = Valuta::where('name', 'US Dollar')->first()->id;
		$btcId = Valuta::where('name', 'Bitcoin')->first()->id;
		$btcUsdPair = ValutaPair::where('valuta_primary_id', $usdId)->where('valuta_secondary_id', $btcId)->first()->id;
		foreach ($balances as $valuta_id => $quantity) {
			$quantity = $quantity instanceof Balance ? $quantity->quantity : $quantity;

			if ($valuta_id != $usdId) {
				$pair = ValutaPair::where('valuta_secondary_id', $valuta_id)->first();
				$order = \DB::select(self::CANDLE_SELECTOR, [$date->timestamp, $pair->id])[0];
				if ($pair->valuta_primary_id == $usdId) {
					$conversion = ($order->high + $order->low) / 2;
					$ret = $ret + $conversion * $quantity;
				} else {
					$order2 = \DB::select(self::CANDLE_SELECTOR, [$date->timestamp, $btcUsdPair])[0];
					$conversion = ($order->high + $order->low) / 2;
					$conversion2 = ($order2->high + $order2->low) / 2;
					$ret = $ret + $conversion2 * $conversion * $quantity;
				}
			} else {
				$ret = $ret + $quantity;
			}
		}
		return $ret;
	}

	/**
	 * @param Balance[]|Collection $balances
	 * @param int $days
	 * @return float|int|mixed
	 */
	public function balanceHistory($balances, int $days)
	{
		$date = Carbon::now()->subDays($days);
		$finalBalances = [];
		foreach ($balances as $balance) $finalBalances[$balance->valuta_id] = $balance->quantity;
		$orders = Order::with('valuta_pair')->where('user_id', \Auth::user()->id)->where('created_at', '>=', $date)->get();
		foreach ($orders as $order) {
			$primary_id = $order->valuta_pair->valuta_primary_id;
			$secondary_id = $order->valuta_pair->valuta_secondary_id;
			if (!isset($finalBalances[$primary_id])) $finalBalances[$primary_id] = 0;
			if (!isset($finalBalances[$secondary_id])) $finalBalances[$secondary_id] = 0;
			$finalBalances[$primary_id] += $order->buy ? $order->price * $order->quantity : -$order->price * $order->quantity;
			$finalBalances[$secondary_id] += $order->buy ? -$order->quantity : $order->quantity;
		}

		return $this->getConvertedBalance($finalBalances, $date);
	}
}