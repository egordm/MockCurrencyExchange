<?php

namespace App\Repositories;

use App\Models\Balance;
use App\Models\Order;
use App\Models\OrderFill;
use App\Repositories\Criteria\AvailableFillOrdersCriteria;
use App\Repositories\Presenters\OrderPresenter;
use App\User;
use App\Validators\OrderValidator;
use Illuminate\Database\Eloquent\Collection;
use Infrastructure\Exceptions\InsufficientFundsException;
use Mockery\Exception;
use Prettus\Repository\Criteria\RequestCriteria;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;


/**
 * Class OrderRepositoryEloquent
 * @package namespace App\Repositories;
 */
class OrderRepository extends AdvancedRepository
{
	/**
	 * Specify Model class name
	 *
	 * @return string
	 */
	public function model()
	{
		return Order::class;
	}

	/**
	 * Specify Validator class name
	 *
	 * @return mixed
	 */
	public function validator()
	{
		return OrderValidator::class;
	}

	/**
	 * Boot up the repository, pushing criteria
	 * @throws \Prettus\Repository\Exceptions\RepositoryException
	 */
	public function boot()
	{
		$this->pushCriteria(app(RequestCriteria::class));
	}

	/**
	 * @param User $user
	 * @param array $attributes
	 * @return Order
	 * @throws InsufficientFundsException
	 * @throws \Exception
	 * @throws \Illuminate\Support\Facades\ContainerExceptionInterface
	 * @throws \Illuminate\Support\Facades\NotFoundExceptionInterface
	 * @throws \Prettus\Repository\Exceptions\RepositoryException
	 * @throws \Prettus\Validator\Exceptions\ValidatorException
	 * @throws \Throwable
	 */
	public function createOrder(User $user, array $attributes) // TODO fill order
	{
		$fee = 0; // TODO: calculate fee. For now..  we are free
		$order = $this->createInstance($attributes, ['user_id' => $user->id, 'fee' => $fee]);

		if ($order->sellQuantity() > $user->getBalance($order->sellValuta()) - $user->getHaltedBalance($order->sellValuta()))
			throw new InsufficientFundsException();

		$order = $this->saveInstance($order);
		return $this->fillOrder($order)->presenter();
	}

	/**
	 * @param Order $order
	 * @return Order
	 * @throws \Exception
	 * @throws \Illuminate\Support\Facades\ContainerExceptionInterface
	 * @throws \Illuminate\Support\Facades\NotFoundExceptionInterface
	 * @throws \Prettus\Repository\Exceptions\RepositoryException
	 * @throws \Throwable
	 */
	public function fillOrder(Order $order)
	{
		// TODO: we could split this for the sake of simplicity. But, oin the other side we probably will only use it like this
		$this->pushCriteria(new AvailableFillOrdersCriteria($order));
		$available_fills = $this->with('valuta_pair')->skipPresenter()->all();
		$this->clearCriteria();

		$filled_qty = $order->getFilledQuantity();
		\DB::transaction(function () use (&$available_fills, &$order, &$filled_qty) {
			foreach ($available_fills as $available_fill) {
				$available_qty = $available_fill->quantity - $available_fill->getFilledQuantity(); // Calculate quantity left to fill for the filler
				$quantity_to_fill = $order->quantity - $filled_qty; // Calculate quantity left to fill for the order
				$fill_qty = max(0, min($available_qty, $quantity_to_fill)); // Calculate quantity we will fill. Smallest of the upper 2
				if($fill_qty <= 0) continue;

				OrderFill::create([
					'order_primary_id' => $order->buy ? $available_fill->id : $order->id, // Seller fills buyer
					'order_secondary_id' => $order->buy ? $order->id : $available_fill->id,
					'quantity' => $fill_qty
				]);

				$available_fill->setFilledQuantity($available_fill->getFilledQuantity() + $fill_qty);
				$this->updateStatus($available_fill);
				$filled_qty += $fill_qty;
			}
		});

		$order->setFilledQuantity($filled_qty);
		$this->updateStatus($order);
		return $order;
	}

	private function updateStatus(Order $order) {
		if($order->status == Order::STATUS_OPEN && $order->quantity <= $order->getFilledQuantity()) {
			$this->closeOrder($order);
		}
	}

	/**
	 * @param Order $order
	 * @throws \Illuminate\Support\Facades\ContainerExceptionInterface
	 * @throws \Illuminate\Support\Facades\NotFoundExceptionInterface
	 * @throws \Exception
	 */
	public function closeOrder(Order $order)
	{
		if($order->status != Order::STATUS_OPEN) throw new \Exception('Order is already closed');
		$cancel = $order->quantity > $order->getFilledQuantity();
		$order->status = $cancel ? Order::STATUS_CANCELLED : Order::STATUS_FILLED;
		$order->save();

		(new Balance(['user_id' => $order->user_id, 'valuta_id' => $order->valuta_pair->valuta_primary_id]))
			->mutate($order->buy ? -$order->sellQuantity() : $order->buyQuantity());
		(new Balance(['user_id' => $order->user_id, 'valuta_id' => $order->valuta_pair->valuta_secondary_id]))
			->mutate($order->buy ? $order->buyQuantity() : -$order->sellQuantity());
	}

	/**
	 * @param User $user
	 * @param array $where
	 * @return Order[]|Collection
	 */
	public function getOrders(User $user, $where = [])
	{
		return $this->with(['valuta_pair'])->findWhere(array_merge(['orders.user_id' => $user->id], $where));
	}

	/**
	 * @param User $user
	 * @param int $id
	 * @return Order
	 */
	public function getOrder(User $user, int $id)
	{
		$ret = $this->with(['valuta_pair'])->findWhere(['orders.user_id' => $user->id, 'orders.id' => $id])->first();
		if(empty($ret)) throw new ResourceNotFoundException();
		return $ret;
	}
}
