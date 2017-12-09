<?php

namespace App\Repositories\Criteria;

use App\Models\Order;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class AvailableFillOrdersCriteria
 * @package namespace App\Repositories\Criteria;
 */
class AvailableFillOrdersCriteria implements CriteriaInterface
{
	/**
	 * @var Order
	 */
	protected $order;

	/**
	 * AvailableFillOrdersCriteria constructor.
	 * @param Order $order
	 */
	public function __construct(Order $order)
	{
		$this->order = $order;
	}


	/**
	 * Apply criteria in query repository
	 *
	 * @param                     $model
	 * @param RepositoryInterface $repository
	 *
	 * @return mixed
	 */
	public function apply($model, RepositoryInterface $repository)
	{
		return $model->leftJoin('order_fills', function ($join) {
			$join->whereColumn('orders.id', 'order_fills.order_primary_id');
			$join->orWhere(function ($query) {
				$query->whereColumn('orders.id', 'order_fills.order_secondary_id');
			});
		})->where('orders.settled',false)
			->addSelect(\DB::raw('orders.*, COALESCE(SUM(order_fills.quantity),0) as filled_qty'))
			->groupBy('orders.id')
			->orderBy('orders.price', $this->order->buy ? 'asc' : 'desc')
			->where('orders.price', $this->order->buy ? '<=' : '>=', $this->order->price)
			->where('orders.buy', !$this->order->buy);
	}
}
