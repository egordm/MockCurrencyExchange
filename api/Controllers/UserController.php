<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 18-1-2018
 * Time: 18:39
 */

namespace API\Controllers;

use App\Models\Balance;
use App\Models\Order;
use App\Repositories\BalanceRepository;
use App\Repositories\Criteria\FilledQuantityCriteria;
use App\Repositories\Criteria\LimitWindowCriteria;
use App\Repositories\Criteria\OrderByNewestCriteria;
use App\Repositories\OrderRepository;
use App\Repositories\Presenters\PollUserDataPresenter;
use Illuminate\Support\Facades\Input;
use Infrastructure\Controllers\APIController;

class UserController extends APIController
{
	/**
	 * @param OrderRepository $orderRepository
	 * @param BalanceRepository $balanceRepository
	 * @return
	 * @throws \Illuminate\Support\Facades\ContainerExceptionInterface
	 * @throws \Illuminate\Support\Facades\NotFoundExceptionInterface
	 * @throws \Prettus\Repository\Exceptions\RepositoryException
	 * @throws \Exception
	 */
	public function poll(OrderRepository $orderRepository, BalanceRepository $balanceRepository)
	{
		$start_time = Input::get('start_time', null);
		$end_time = Input::get('end_time', null);
		$limit = Input::get('limit', 30);
		$ret = [];

		$orderRepository->pushCriteria(new LimitWindowCriteria(Order::getTableName(), $limit, $start_time, $end_time));
		$orderRepository->pushCriteria(FilledQuantityCriteria::class);
		$orderRepository->pushCriteria(new OrderByNewestCriteria(Order::getTableName()));
		$ret['orders'] = $orderRepository->getOrders(\Auth::user());

		$balanceRepository->pushCriteria(new LimitWindowCriteria(Balance::getTableName(), $limit, $start_time, $end_time));
		$ret['balance'] = $balanceRepository->getBalances(\Auth::user());

		return (new PollUserDataPresenter())->present($ret);
	}
}