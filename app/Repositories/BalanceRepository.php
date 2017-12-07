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
use App\Repositories\Criteria\OrderValutaCriteria;
use App\Repositories\Presenters\BalancePresenter;
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

	/**
	 * @param User $user
	 * @return mixed
	 */
	public function getBalances(User $user)
	{
		return $this->with(['valuta'])->findWhere(['user_id' => $user->id]);
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

	public function presenter()
	{
		return BalancePresenter::class;
	}
}