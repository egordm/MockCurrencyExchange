<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 3-12-2017
 * Time: 11:57
 */

namespace API\Controllers;


use App\Repositories\BalanceRepository;
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

	public function index($symbols = null)
	{
		/** @noinspection PhpUnhandledExceptionInspection */
		// TODO: sum the order balances and display
		return $this->balanceRepository->getBalances(\Auth::user(), $symbols);
	}

}