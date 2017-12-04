<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 3-12-2017
 * Time: 21:46
 */

namespace API\Controllers;


use App\Models\Order;
use App\Repositories\OrderRepository;
use Infrastructure\Controllers\APIController;

class OrdersController extends APIController
{
	/**
	 * @var OrderRepository
	 */
	public $orderRepository;

	/**
	 * OrdersController constructor.
	 * @param OrderRepository $orderRepository
	 */
	public function __construct(OrderRepository $orderRepository)
	{
		$this->orderRepository = $orderRepository;
	}

	public function index()
	{
		return $this->orderRepository->getOrders(\Auth::user());
	}

	public function view($id)
	{
		return Order::find(1)->fill_percentage(Order::find(2));
		return $this->orderRepository->with(['orders_filling', 'orders_filled', 'valuta_pair'])->present(['order_fills'])->find($id);
	}

	public function create()
	{

	}
}