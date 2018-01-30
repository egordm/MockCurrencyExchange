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
		if (!empty($request->get('new_password'))) $user->password = $request->get('new-password');
		$user->save();

		return redirect()->back()->with("success", "Account has been updated succesfully");
	}

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

        $convertedbalance = $balanceRepository->getConvertedBalance($balances);

		return view('portfolio', compact('orders', 'balances', 'convertedbalance'));
	}

}
