<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 6-12-2017
 * Time: 22:27
 */

namespace App\Repositories\Criteria;


use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ActiveOrderCriteria implements CriteriaInterface
{

	/**
	 * Apply criteria in query repository
	 *
	 * @param Model|QueryBuilder $model
	 * @param RepositoryInterface $repository
	 *
	 * @return mixed
	 */
	public function apply($model, RepositoryInterface $repository)
	{
		return $model->where('orders.status', 0);
	}
}