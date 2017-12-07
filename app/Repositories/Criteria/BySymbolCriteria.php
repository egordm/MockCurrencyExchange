<?php

namespace App\Repositories\Criteria;

use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class BalanceBySymbolCriteria
 * @package namespace App\Repositories\Criteria;
 */
class BySymbolCriteria implements CriteriaInterface
{
	/**
	 * @var array
	 */
	protected $symbols;

	/**
	 * @var bool
	 */
	protected $joinValuta;

	/**
	 * BalanceBySymbolCriteria constructor.
	 * @param array $symbols
	 * @param bool $joinValuta
	 */
	public function __construct($symbols, $joinValuta= true)
	{
		$this->symbols = is_string($symbols) ? explode(',', $symbols) : $symbols;
		$this->joinValuta = $joinValuta;
	}


	/**
	 * Apply criteria in query repository
	 *
	 * @param QueryBuilder|Model $model
	 * @param RepositoryInterface $repository
	 *
	 * @return mixed
	 */
	public function apply($model, RepositoryInterface $repository)
	{
		$symbols = $this->symbols;
		if($this->joinValuta) {
			return $model->join('valuta', 'valuta_id', '=', 'valuta.id')
				->when(!empty($symbols), function ($query) use ($symbols) {
					$query->whereIn('valuta.symbol', $symbols);
				});
		} else {
			return $model->whereIn('valuta.symbol', $symbols);
		}
	}
}
