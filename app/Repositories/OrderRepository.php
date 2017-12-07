<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Presenters\OrderPresenter;
use App\User;
use App\Validators\OrderValidator;
use Infrastructure\Exceptions\InsufficientFundsException;
use Prettus\Repository\Criteria\RequestCriteria;


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
	 * @param array $where
	 * @return mixed
	 */
	public function getOrders(User $user, $where = [])
	{
		return $this->with(['valuta_pair'])->findWhere(array_merge(['user_id' => $user->id], $where));
	}

	/**
	 * @param User $user
	 * @param array $attributes
	 * @return mixed
	 * @throws \Prettus\Repository\Exceptions\RepositoryException
	 * @throws \Prettus\Validator\Exceptions\ValidatorException
	 * @throws InsufficientFundsException
	 */
	public function createForUser(User $user, array $attributes)
	{

		$fee = 0; // TODO: calculate fee. For now..  we are free
		$order = $this->createInstance($attributes, ['user_id' => $user->id, 'fee' => $fee]);

		if ($order->buyQuantity() > $user->getBalance($order->sellValuta()) - $user->getHaltedBalance($order->sellValuta()))
			throw new InsufficientFundsException();
		return $this->saveInstance($order);
	}
}
