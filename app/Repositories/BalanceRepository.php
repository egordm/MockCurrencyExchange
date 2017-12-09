<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 3-12-2017
 * Time: 11:48
 */

namespace App\Repositories;


use App\Models\Balance;
use App\Models\Valuta;
use App\Repositories\Criteria\ActiveOrderCriteria;
use App\Repositories\Criteria\BySymbolCriteria;
use App\Repositories\Criteria\HoldQuantityCriteria;
use App\Repositories\Criteria\OrderValutaCriteria;
use App\Repositories\Criteria\WithBalanceCriteria;
use App\Repositories\Presenters\BalancePresenter;
use App\Repositories\Presenters\BalanceValutaPresenter;
use App\User;

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

	public function presenter()
	{
		return BalancePresenter::class;
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

	public function mutateBalances(array $mutations) // TODO: use models
	{
		$values = [];
		foreach ($mutations as $mutation) {
			$values = array_merge($values, [$mutation['user_id'], $mutation['valuta_id'], $mutation['quantity']]);
		}
		$query = 'INSERT INTO balances (user_id, valuta_id, quantity, created_at, updated_at) VALUES ' .
			implode(',', array_fill(0, count($mutations), '(?,?,?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)')) .
			' ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)';
		\DB::insert($query, $values);
	}
}