<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 3-12-2017
 * Time: 11:57
 */

namespace API\Controllers;


use App\Repositories\BalanceRepository;
use App\Repositories\OrderRepository;
use Illuminate\Auth\AuthenticationException;
use Infrastructure\Controllers\APIController;

class BalanceController extends APIController
{
	/**
	 * @var BalanceRepository
	 */
	private $balanceRepository;

	/**
	 * BalanceController constructor.
	 * @param BalanceRepository $balanceRepository
	 */
	public function __construct(BalanceRepository $balanceRepository)
	{
		$this->balanceRepository = $balanceRepository;
	}

	public function index() {
        /** @noinspection PhpUnhandledExceptionInspection */
        $orders = \App::get(OrderRepository::class)->skipPresenter()->getOrders(\Auth::user(), ['status' => 0]);
        // TODO: sum the order balances and display
		return $this->balanceRepository->getBalances(\Auth::user());
	}


}