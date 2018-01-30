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
use App\Repositories\Criteria\BySymbolCriteria;
use App\Repositories\Criteria\HoldQuantityCriteria;
use App\Repositories\Criteria\OrderValutaCriteria;
use App\Repositories\Criteria\WithBalanceCriteria;
use App\Repositories\Presenters\BalancePresenter;
use App\Repositories\Presenters\BalanceValutaPresenter;
use App\User;
use \Illuminate\Database\Eloquent\Collection;
use DB;
use \Carbon\Carbon;


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
     * @param null $symbols
     * @return mixed
     * @throws \Illuminate\Support\Facades\ContainerExceptionInterface
     * @throws \Illuminate\Support\Facades\NotFoundExceptionInterface
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function getBalances(User $user, $symbols = null)
    {
        $useValuta = !empty($symbols);
        $repo = $useValuta ? \App::get(ValutaRepository::class) : $this;
        $repo->pushCriteria(new HoldQuantityCriteria(\Auth::user(), $useValuta ? 'valuta.id' : 'balances.valuta_id'));
        if (!$useValuta) return $this->with(['valuta'])->findWhere(['balances.user_id' => $user->id]);

        $repo->pushCriteria(new BySymbolCriteria($symbols, !$useValuta));
        $repo->pushCriteria(new WithBalanceCriteria(\Auth::user()));
        $repo->setPresenter(BalanceValutaPresenter::class);
        return $repo->all();
    }

    public function getBalance(User $user, Valuta $valuta)
    {
        return $this->findWhere(['user_id' => $user->id, 'valuta_id' => $valuta->id]);
    }


    public function getConvertedBalance(Collection $balances)
    {
        $convertedbalance = 0;
        $USDollarid = DB::table('valuta')->where('name', 'US Dollar')->first()->id;
        $Bitcoinid = DB::table('valuta')->where('name', 'Bitcoin')->first()->id;
        $valutapairUSDBTCid = DB::table('valuta_pairs')->where('valuta_primary_id', $USDollarid)->where('valuta_secondary_id', $Bitcoinid)->first()->id;

        foreach ($balances as $balance):
            if (!($balance->valuta->name == 'US Dollar')) {
                $valutapair = DB::table('valuta_pairs')->where('valuta_secondary_id', $balance->valuta->id)->first();
                $order = DB::table('candlestick_nodes')->where('valuta_pair_id', $valutapair->id)->Orderby('close_time', 'desc')->first();
                if ($valutapair->valuta_primary->id == $USDollarid) {
                    $conversion = ($order->high + $order->low) / 2;
                    $convertedbalance = $convertedbalance + $conversion * $balance->quantity;
                } else {
                    $order2 = DB::table('candlestick_nodes')->where('valuta_pair_id', $valutapairUSDBTCid)->Orderby('close_time', 'desc')->first();
                    $conversion = ($order->high + $order->low) / 2;
                    $conversion2 = ($order2->high + $order2->low) / 2;
                    $convertedbalance = $convertedbalance + $conversion2 * $conversion * $balance->quantity;
                }
            } else {
                $convertedbalance = $convertedbalance + $balance->quantity;
            }
        endforeach;

        return $convertedbalance;
    }


    public function getDifference(Collection $balances, Collection $orders, int $days)
    {
        $balancearray = array();
        $orders = $orders->where('created_at', '>=', Carbon::now()->subDays($days));

        $valutas = DB::table('valuta')->get();

        foreach($valutas as $valuta):
            $balancearray[$valuta->id] = 0;
        endforeach;

        foreach ($balances as $balance):
            $balancearray[$balance->valuta_id] = $balance->quantity;
        endforeach;


        foreach ($orders as $order):
            if ($order->buy = 1) {
                $balancearray[$order->valuta_pair->valuta_primary->id] = $balancearray[$order->valuta_pair->valuta_primary->id] - $order->quantity;
                $balancearray[$order->valuta_pair->valuta_secondary->id] = $balancearray[$order->valuta_pair->valuta_secondary->id] + $order->price*$order->quantity;
            } else {
                $balancearray[$order->valuta_pair->valuta_primary->id] = +$order->quantity;
                $balancearray[$order->valuta_pair->valuta_secondary->id] = -$order->price*$order->quantity;
            }
        endforeach;

        $convertedbalance = 0;
        $USDollarid = DB::table('valuta')->where('name', 'US Dollar')->first()->id;
        $Bitcoinid = DB::table('valuta')->where('name', 'Bitcoin')->first()->id;
        $valutapairUSDBTCid = DB::table('valuta_pairs')->where('valuta_primary_id', $USDollarid)->where('valuta_secondary_id', $Bitcoinid)->first()->id;

        $balancearray[$USDollarid] = 1000;

        $id = 1;
        foreach ($balancearray as $balance):
            if (!($id == $USDollarid)) {
                $valutapair = DB::table('valuta_pairs')->where('valuta_secondary_id', $id)->first();
                $order = DB::table('candlestick_nodes')->where('valuta_pair_id', $valutapair->id)->Orderby('close_time', 'desc')->first();
                if ($valutapair->valuta_primary_id == $USDollarid) {
                    $conversion = ($order->high + $order->low) / 2;
                    $convertedbalance = $convertedbalance + $conversion * $balance;
                } else {
                    $order2 = DB::table('candlestick_nodes')->where('valuta_pair_id', $valutapairUSDBTCid)->Orderby('close_time', 'desc')->first();
                    $conversion = ($order->high + $order->low) / 2;
                    $conversion2 = ($order2->high + $order2->low) / 2;
                    $convertedbalance = $convertedbalance + $conversion2 * $conversion * $balance;
                }
            }else {
                $convertedbalance = $convertedbalance + $balance;
            }
            $id ++;
        endforeach;

        return $convertedbalance;
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
}