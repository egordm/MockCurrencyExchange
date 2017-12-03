<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 3-12-2017
 * Time: 11:48
 */

namespace App\Repositories;


use App\Models\Balance;
use App\Repositories\Presenters\BalancePresenter;
use App\User;
use Prettus\Repository\Eloquent\BaseRepository;

class BalanceRepository extends BaseRepository
{
	/**
	 * Specify Model class name
	 *
	 * @return mixed
	 */
	public function model()
	{
		return Balance::class;
	}

	/**
	 * @param User $user
	 * @return mixed
	 */
	public function getBalance(User $user)
	{
		return $this->findWhere(['user_id' => $user->id]);
	}

	public function presenter()
	{
		return BalancePresenter::class;
	}
}