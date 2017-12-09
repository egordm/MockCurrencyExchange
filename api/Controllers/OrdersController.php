<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 3-12-2017
 * Time: 21:46
 */

namespace API\Controllers;


use API\Requests\OrderCreateRequest;
use App\Models\Order;
use App\Repositories\Criteria\FilledQuantityCriteria;
use App\Repositories\OrderRepository;
use App\Repositories\Presenters\OrderPresenter;
use Infrastructure\Controllers\APIController;
use Prettus\Validator\Exceptions\ValidatorException;

class OrdersController extends APIController
{
	/**
	 * @var Order
	 */
	public $repository;

	/**
	 * OrdersController constructor.
	 * @param OrderRepository $orderRepository
	 */
	public function __construct(OrderRepository $orderRepository)
	{
		$this->repository = $orderRepository;
	}

	/**
	 * Show all users orders
	 * @return mixed
	 * @throws \Prettus\Repository\Exceptions\RepositoryException
	 */
	public function index()
	{
		/** @noinspection PhpUnhandledExceptionInspection */
		$this->repository->pushCriteria(FilledQuantityCriteria::class);
		return $this->present($this->repository->getOrders(\Auth::user()));
	}

	/**
	 * Show a specific order
	 * @param $id
	 * @return mixed
	 * @throws \Prettus\Repository\Exceptions\RepositoryException
	 */
	public function view($id)
	{
		/** @noinspection PhpUnhandledExceptionInspection */
		$this->repository->pushCriteria(FilledQuantityCriteria::class);
		/** @noinspection PhpUnhandledExceptionInspection */
		return $this->present($this->repository->with(['valuta_pair'])->getOrder(\Auth::user(), $id));
	}

	public function create(OrderCreateRequest $request)
	{
		try {
			/** @noinspection PhpUnhandledExceptionInspection */
			return $this->present($this->repository->createOrder(\Auth::user(), $request->all()));
		} catch (ValidatorException $e) {
			return \Response::json(['error' => true, 'message' => $e->getMessageBag()]);
		}
	}

	public function cancel(int $id)
	{
		$order = $this->repository->getOrder(\Auth::user(), $id);
		$this->repository->closeOrder($order);
		return $this->present($order);
	}

	public function presenter()
	{
		return new OrderPresenter();
	}
}