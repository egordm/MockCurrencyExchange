<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 3-12-2017
 * Time: 21:46
 */

namespace API\Controllers;


use API\Requests\OrderCreateRequest;
use App\Models\Valuta;
use App\Repositories\OrderRepository;
use App\Validators\OrderFillValidator;
use Infrastructure\Controllers\APIController;
use Prettus\Validator\Exceptions\ValidatorException;

class OrdersController extends APIController
{
	/**
	 * @var OrderRepository
	 */
	public $repository;

	/**
	 * @var OrderFillValidator
	 */
	protected $validator;

	/**
	 * OrdersController constructor.
	 * @param OrderRepository $orderRepository
	 * @param OrderFillValidator $validator
	 */
	public function __construct(OrderRepository $orderRepository, OrderFillValidator $validator)
	{
		$this->repository = $orderRepository;
		$this->validator = $validator;
	}


	public function index()
	{
		return $this->repository->getOrders(\Auth::user());
	}

	public function view($id)
	{
		return $this->repository->with(['orders_filling', 'orders_filled', 'valuta_pair'])->present(['order_fills'])->find($id);
	}

	public function create(OrderCreateRequest $request)
	{
		try {
			return $this->repository->createForUser(\Auth::user(), $request->all()); // TODO fill order
		} catch (ValidatorException $e) {
			return \Response::json(['error' => true, 'message' => $e->getMessageBag()]);
		} catch (\Throwable $e) {
			return \Response::json(['error' => true, 'message' => $e->getMessage()]);
		}
	}
}