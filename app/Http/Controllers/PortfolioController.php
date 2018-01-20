<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\BalanceRepository;
use App\Repositories\OrderRepository;


class PortfolioController extends Controller
{
    public function showbalance(BalanceRepository $balancerepository, OrderRepository $orderrepository)
    {
        $balances = $balancerepository->getBalances(\Auth::user());

        $orders = $orderrepository->getOrders(\Auth::user());

        $convertedbalance = $balancerepository->getConvertedBalance($balances);

        return view('/portfolio', compact('balances', 'orders', 'convertedbalance'));
    }
}
