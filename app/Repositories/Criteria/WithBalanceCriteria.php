<?php

namespace App\Repositories\Criteria;

use App\User;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class WithBalanceCriteria
 * @package namespace App\Repositories\Criteria;
 */
class WithBalanceCriteria implements CriteriaInterface
{
	/**
	 * @var User
	 */
	public $user;

	/**
	 * WithBalanceCriteria constructor.
	 * @param User $user
	 */
	public function __construct(User $user)
	{
		$this->user = $user;
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
		return $model->leftJoin('balances', function ($query) {
			$query->where('balances.user_id', $this->user->id);
			$query->whereRaw('balances.valuta_id=valuta.id');
		})->addSelect(['balances.*', \DB::raw('COALESCE(balances.quantity, 0) as quantity')]);
	}
}
