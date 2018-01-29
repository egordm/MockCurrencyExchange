<?php

namespace App\Repositories\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FilledQuantityCriteria
 * @package namespace App\Repositories\Criteria;
 */
class FilledQuantityCriteria implements CriteriaInterface
{
	public function applyJoins($model, RepositoryInterface $repository) {
		return $model->leftJoin('order_fills', function ($join) {
			$join->whereColumn('orders.id', 'order_fills.order_primary_id');
			$join->orWhere(function ($query) {
				$query->whereColumn('orders.id', 'order_fills.order_secondary_id');
			});
		})->leftJoin('orders as fillers', function ($join) {
			$join->whereColumn('orders.id', '<>', 'fillers.id');
			$join->where(function ($query) {
				$query->whereColumn('fillers.id', 'order_fills.order_primary_id');
				$query->orWhere(function ($query) {
					$query->whereColumn('fillers.id', 'order_fills.order_secondary_id');
				});
			});
		});
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

		return $this->applyJoins($model, $repository)
			->addSelect(\DB::raw('orders.*, COALESCE(SUM(order_fills.quantity),0) as filled_qty'))
			->groupBy('orders.id');
	}
}
