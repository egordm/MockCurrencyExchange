<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 3-12-2017
 * Time: 11:57
 */

namespace API\Controllers;


use App\Repositories\BalanceRepository;
use App\Repositories\Presenters\BalancePresenter;
use Infrastructure\Controllers\APIController;
use Prettus\Repository\Contracts\PresenterInterface;

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
		$this->balanceRepository->setPresenter($this->presenter());
	}

	/**
	 * Get a list of balances for currencies user owns
	 * @param null|string $symbols
	 * @return mixed
	 * @throws \Illuminate\Support\Facades\ContainerExceptionInterface
	 * @throws \Illuminate\Support\Facades\NotFoundExceptionInterface
	 * @throws \Prettus\Repository\Exceptions\RepositoryException
	 */
	public function index($symbols = null)
	{
		/** @noinspection PhpUnhandledExceptionInspection */
		return $this->balanceRepository->getBalances(\Auth::user(), $symbols);
	}

	/**
	 * @return PresenterInterface
	 */
	public function presenter()
	{
		return new BalancePresenter();
	}
}