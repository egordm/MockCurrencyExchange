<?php

namespace App\Repositories;

use App\Constants\CacheConstants;
use App\Events\OrderClosed;
use App\Models\Order;
use App\Models\OrderFill;
use App\Models\ValutaPair;
use App\Repositories\Criteria\ActiveOrderCriteria;
use App\Repositories\Criteria\AvailableFillOrdersCriteria;
use App\Repositories\Criteria\FilledQuantityCriteria;
use App\User;
use App\Validators\OrderValidator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Infrastructure\Exceptions\InsufficientFundsException;
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
		return $order->presenter(); //$this->fillOrder($order)->presenter();
	}

	/**
	 * TODO: moar events?
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
				if ($fill_qty <= 0) continue;

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

	private function updateStatus(Order $order)
	{
		if ($order->status == Order::STATUS_OPEN && $order->quantity <= $order->getFilledQuantity()) {
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
		if ($order->status != Order::STATUS_OPEN) throw new \Exception('Order is already closed');
		$cancel = $order->quantity > $order->getFilledQuantity();
		$order->status = $cancel ? Order::STATUS_CANCELLED : Order::STATUS_FILLED;
		$order->save();

		event(new OrderClosed($order));
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
		if (empty($ret)) throw new ResourceNotFoundException();
		return $ret;
	}

	/**
	 * @param ValutaPair $market
	 * @return Order[]
	 * @throws \Prettus\Repository\Exceptions\RepositoryException
	 */
	public function getOpenOrders($market)
	{
		// TODO: this code screams like kill me. Its a custom query though. Not sure how to optimize

		$ret = \Cache::rememberForever(CacheConstants::ORDER_BOOK($market->id), function () use ($market) {
			return collect(\DB::select("
			SELECT corders.price, corders.buy,  SUM(corders.quantity - corders.filled_qty) AS quantity
			FROM (
			  SELECT
			    orders.*,
			    COALESCE(SUM(order_fills.quantity), 0) AS filled_qty
			  FROM `orders`
			    LEFT JOIN `order_fills`
			      ON `orders`.`id` = `order_fills`.`order_primary_id` OR (`orders`.`id` = `order_fills`.`order_secondary_id`)
			    LEFT JOIN `orders` AS `fillers` ON `orders`.`id` <> `fillers`.`id`
			                                       AND (`fillers`.`id` = `order_fills`.`order_primary_id`
			                                            OR (`fillers`.`id` = `order_fills`.`order_secondary_id`))
			  WHERE `orders`.`status` = 0 AND `orders`.`valuta_pair_id` = ?
			  GROUP BY `orders`.`id`
			) AS corders GROUP BY buy, price ORDER BY price ASC", [$market->id]))->groupBy('buy');
		});
		return $ret;
	}

	/**
	 * @param $market
	 * @param int $limit
	 * @param null $start_time
	 * @param null $end_time
	 * @return mixed
	 */
	public function getHistory($market, $limit = 60, $start_time = null, $end_time = null)
	{
		$start_time = is_numeric($start_time) ? Carbon::createFromTimestamp($start_time) : $start_time;
		$end_time = is_numeric($end_time) ? Carbon::createFromTimestamp($end_time) : $end_time;

		//$this->pushCriteria(new LimitWindowCriteria($limit, $start_time, $end_time));
		//$this->findWhere(['orders.valuta_pair_id' => $market->id, 'orders.status' => Order::STATUS_FILLED])
		return $this->model->where(['orders.valuta_pair_id' => $market->id, 'orders.status' => Order::STATUS_FILLED])
			->when(!empty($start_time), function ($query) use ($start_time) {
				return $query->where('updated_at', '>=', $start_time);
			})->when(!empty($end_time), function ($query) use ($end_time) {
				return $query->where('updated_at', '<=', $end_time);
			})
			->orderBy('updated_at', 'DESC')->limit($limit)->get();
	}

	/**
	 * @param ValutaPair $market
	 * @return Order[]
	 * @throws \Illuminate\Support\Facades\ContainerExceptionInterface
	 * @throws \Illuminate\Support\Facades\NotFoundExceptionInterface
	 * @throws \Prettus\Repository\Exceptions\RepositoryException
	 */
	public function getOrderBook(ValutaPair $market)
	{
		return $this->getOpenOrders($market);
	}
}
