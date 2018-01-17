<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 3-12-2017
 * Time: 22:03
 */

namespace API\Controllers;


use App\External\BinanceAPI;
use App\Repositories\Criteria\ActiveOrderCriteria;
use App\Repositories\Criteria\FilledQuantityCriteria;
use App\Repositories\OrderRepository;
use App\Repositories\Presenters\CandleNodePresenter;
use App\Repositories\Presenters\DepthPresenter;
use App\Repositories\Presenters\HistoryPresenter;
use App\Repositories\Presenters\PollDataPresenter;
use App\Repositories\Presenters\ValutaPairPresenter;
use App\Repositories\ValutaPairRepository;
use Illuminate\Support\Facades\Input;
use Infrastructure\Controllers\APIController;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class MarketController extends APIController
{
	/**
	 * @var ValutaPairRepository
	 */
	private $repository;

	/**
	 * MarketController constructor.
	 * @param ValutaPairRepository $valutaPairRepository
	 */
	public function __construct(ValutaPairRepository $valutaPairRepository)
	{
		$this->repository = $valutaPairRepository;
	}

	public function presenter()
	{
		return new ValutaPairPresenter();
	}

	public function index()
	{
		return $this->present($this->repository->allDisplay());
	}

	protected function getMarket($with = []) {
		$market = $this->repository->with($with)->findByMarket(\Request::route('market'));
		if (!$market) throw new NotFoundResourceException();
		return $market;
	}

	public function view($market)
	{
		// TODO: Get daily percentages
		return $this->present($this->getMarket(['valuta_primary', 'valuta_secondary']));
	}

	/**
	 * @param $market
	 * @return mixed
	 * @throws \Exception
	 * @throws \Illuminate\Support\Facades\ContainerExceptionInterface
	 * @throws \Illuminate\Support\Facades\NotFoundExceptionInterface
	 */
	public function history($market)
	{
		$start_time = Input::get('start_time', null);
		$end_time = Input::get('end_time', null);
		$orderRepository = \App::get(OrderRepository::class);
		$orders = $orderRepository->getHistory($this->getMarket(), 60, $start_time, $end_time);
		return (new HistoryPresenter())->present($orders);
	}

	/**
	 * Get depth of the market. Basically current open orders
	 * @link https://www.investopedia.com/terms/d/depth.asp
	 * @param $market
	 * @return array|mixed
	 * @throws \Exception
	 * @throws \Illuminate\Support\Facades\ContainerExceptionInterface
	 * @throws \Illuminate\Support\Facades\NotFoundExceptionInterface
	 */
	public function depth($market)
	{
		$orderRepository = \App::get(OrderRepository::class);
		$orders = $orderRepository->getOpenOrders($this->getMarket());
		return (new DepthPresenter())->present($orders->all());
	}

	/**
	 * Get candleticks data.
	 * @link https://www.investopedia.com/terms/c/candlestick.asp
	 * @param $market
	 * @param BinanceAPI $bac
	 * @return array|mixed
	 * @throws \Exception
	 */
	public function candlesticks($market, BinanceAPI $bac)
	{
		$market = $this->getMarket(['external_symbol']);
		$interval = Input::get('interval', '15m');
		$start_time = Input::get('start_time', null);
		$end_time = Input::get('end_time', null);
		$nodes = $bac->candlesticks($market, $interval, $start_time, $end_time);
		return (new CandleNodePresenter())->present($nodes);
	}

	/**
	 * @param $market
	 * @param BinanceAPI $bac
	 * @return mixed
	 * @throws \Exception
	 * @throws \Illuminate\Support\Facades\ContainerExceptionInterface
	 * @throws \Illuminate\Support\Facades\NotFoundExceptionInterface
	 */
	public function poll($market, BinanceAPI $bac)
	{
		$market = $this->getMarket(['external_symbol']);
		$interval = Input::get('interval', '15m');
		$start_time = Input::get('start_time', null);
		$end_time = Input::get('end_time', null);
		//$include = Input::get('include', ['depth', 'candles', 'history']);
		//if(is_string($include)) $include = explode(',', $include);
		$ret = [];
		$orderRepository = \App::get(OrderRepository::class);

		/*if(in_array('depth', $include))*/
		/*if(in_array('history', $include)) */
		/*if(in_array('candles', $include))*/

		$ret['depth'] = $orders = $orderRepository->getOpenOrders($market);
		$ret['candles'] = $bac->candlesticks($market, $interval, $start_time, $end_time);
		$ret['history'] = $orderRepository->getHistory($market, 60, $start_time, $end_time);

		return (new PollDataPresenter())->present($ret);
	}
}