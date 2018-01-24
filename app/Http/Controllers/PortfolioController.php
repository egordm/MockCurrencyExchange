<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\BalanceRepository;
use App\Repositories\OrderRepository;


class PortfolioController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showbalance()
    {
        return view('/portfolio');
    }
}
