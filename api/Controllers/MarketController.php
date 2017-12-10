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
use App\Repositories\Presenters\DepthPresenter;
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
		return $this->present($this->repository->all_display());
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

	public function depth($market)
	{
		$orderRepository = \App::get(OrderRepository::class);
		$orderRepository->pushCriteria(FilledQuantityCriteria::class);
		$orderRepository->pushCriteria(ActiveOrderCriteria::class);
		$orders = $orderRepository->findWhere(['orders.valuta_pair_id' => $this->getMarket()->id], ['id', 'quantity', 'price', 'buy'])->groupBy('buy');
		return (new DepthPresenter())->present($orders->all());
	}

	public function candlesticks($market, BinanceAPI $bac)
	{
		return $bac->candlesticks('BTCUSDT', Input::get('interval', '15m'));
	}
}