<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 3-12-2017
 * Time: 11:57
 */

namespace API\Controllers;


use App\Repositories\BalanceRepository;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

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

	/**
	 * @throws AuthenticationException
	 */
	public function index() {
		$user = \Auth::user();
		if(!$user) throw new AuthenticationException();

		return $this->balanceRepository->getBalance($user);
	}


}