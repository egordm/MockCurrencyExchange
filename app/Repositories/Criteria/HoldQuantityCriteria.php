<?php

namespace App\Repositories\Criteria;

use App\User;
use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class BalanceHoldCriteria
 * @package namespace App\Repositories\Criteria;
 */
class HoldQuantityCriteria implements CriteriaInterface
{
	public $valutaIdColumn;
	/**
	 * @var User
	 */
	public $user;

	/**
	 * BalanceHoldCriteria constructor.
	 * @param string $valutaIdColumn
	 * @param User $user
	 */
	public function __construct(User $user, string $valutaIdColumn = 'balances.valuta_id')
	{
		$this->user = $user;
		$this->valutaIdColumn = $valutaIdColumn;
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
		/** @noinspection PhpParamsInspection */
		$ret = $model->leftJoin('valuta_pairs', function ($join) { // Find corresponding valuta pairs to filter orders
			$join->whereColumn($this->valutaIdColumn, '=', 'valuta_pairs.valuta_primary_id')
				->orWhereColumn($this->valutaIdColumn, '=', 'valuta_pairs.valuta_secondary_id');
		})->leftJoin('orders', function ($join) { // Find active orders that are selling corresponding currency
			$join->whereColumn('valuta_pairs.id', '=', 'orders.valuta_pair_id');
			$join->where('orders.status', 0);
			$join->where('orders.user_id', $this->user->id);
			$join->where(function ($query) {
				$query->where(function ($query) {
					$query->whereColumn('valuta_pairs.valuta_primary_id', '=', $this->valutaIdColumn);
					$query->where('orders.buy', true);
				});
				$query->orWhere(function ($query) {
					$query->whereColumn('valuta_pairs.valuta_secondary_id', '=', $this->valutaIdColumn);
					$query->where('orders.buy', false);
				});
			});
		})
			->addSelect(\DB::raw(explode('.',$this->valutaIdColumn)[0].'.*, COALESCE(SUM(CASE WHEN orders.buy = TRUE THEN orders.quantity * orders.price ELSE orders.quantity END),0) as halted_quantity'))
			->groupBy($this->valutaIdColumn);
		return $ret;
	}
}
