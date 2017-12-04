<?php

namespace App\Repositories;

use App\Repositories\Presenters\OrderPresenter;
use App\User;
use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Order;
use App\Validators\OrderValidator;

/**
 * Class OrderRepositoryEloquent
 * @package namespace App\Repositories;
 */
class OrderRepository extends PresentableRepository
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

	public function presenter()
	{
		return OrderPresenter::class;
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
	 * @return mixed
	 */
	public function getOrders(User $user)
	{
		return $this->with(['valuta_pair'])->findWhere(['user_id' => $user->id]);
	}

	//public function filledRatio
}
