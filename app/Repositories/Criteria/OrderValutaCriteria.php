<?php

namespace App\Repositories\Criteria;

use App\Models\Valuta;
use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OrderValutaCriteria
 * @package namespace App\Repositories\Criteria;
 */
class OrderValutaCriteria implements CriteriaInterface
{
	/**
	 * @var Valuta
	 */
	protected $valuta;

	/**
	 * OrderValutaCriteria constructor.
	 * @param Valuta $valuta
	 */
	public function __construct(Valuta $valuta)
	{
		$this->valuta = $valuta;
	}

	/**
	 * This basically filters for orders where a certain valuta is locked. It can only be locked when
	 * the user is holding it. Thus only buy orders.
	 * A buy order is defined:
	 * - primary valuta -> secondary valuta (buy)
	 * - secondary valuta -> primary valuta (sell)
	 * In both cases first parameter needs to be the chosen valuta
	 *
	 * @param Model|QueryBuilder $model
	 * @param RepositoryInterface $repository
	 *
	 * @return mixed
	 */
	public function apply($model, RepositoryInterface $repository)
	{
		$valuta_id = $this->valuta->id;
		$ret = $model->join('valuta_pairs', 'valuta_pair_id', '=', 'valuta_pairs.id')
			->where(function($query) use ($valuta_id) {
				$query->where(['valuta_secondary_id' => $valuta_id, 'buy' => false]);
			})->orWhere(function ($query) use ($valuta_id) {
				$query->where(['valuta_primary_id' => $valuta_id, 'buy' => true]);
			});
		return $ret;
	}
}
