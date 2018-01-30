<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountUpdateRequest;
use App\Repositories\BalanceRepository;
use App\Repositories\Criteria\OrderByNewestCriteria;
use App\Repositories\Criteria\UserOwnedCriteria;
use App\Repositories\OrderRepository;
use Auth;

class AccountController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function edit()
	{
		return view('account');
	}

	public function update(AccountUpdateRequest $request)
	{
		$user = Auth::user();
		if (!empty($request->get('name'))) $user->name = $request->get('name');
		if (!empty($request->get('new_password'))) $user->password = $request->get('new_password');
		$user->save();

		return redirect()->back()->with("success", "Account has been updated succesfully");
	}

	const GAIN_PERIODS = ['30 day' => 30, '7 day' => 7, '24 hour' => 1];

	/**
	 * @param OrderRepository $orderRepository
	 * @param BalanceRepository $balanceRepository
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 * @throws \Illuminate\Support\Facades\ContainerExceptionInterface
	 * @throws \Illuminate\Support\Facades\NotFoundExceptionInterface
	 * @throws \Prettus\Repository\Exceptions\RepositoryException
	 */
	public function portfolio(OrderRepository $orderRepository, BalanceRepository $balanceRepository)
	{
		$balances = $balanceRepository->getBalances(Auth::user());

		$orderRepository->pushCriteria(UserOwnedCriteria::class);
		$orderRepository->pushCriteria(new OrderByNewestCriteria('orders', 'id'));
		$orders = $orderRepository->paginate();
		$totalBalance = $balanceRepository->getConvertedBalance($balances->keyBy('valuta_id'));
		$gains = [];
		if($totalBalance > 0) {
			foreach (self::GAIN_PERIODS as $period => $days) {
				$gains[$period] = ($balanceRepository->balanceHistory($balances, $days) - $totalBalance) / $totalBalance;
			}
		}

		return view('portfolio', compact('orders', 'balances', 'totalBalance', 'gains'));
	}

}
