<?php

namespace App\Repositories;

use App\Repositories\Presenters\OrderFillPresenter;
use App\Repositories\Presenters\OrderPresenter;
use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\OrderFill;
use App\Validators\OrderFillValidator;

/**
 * Class OrderFillRepositoryEloquent
 * @package namespace App\Repositories;
 */
class OrderFillRepository extends PresentableRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OrderFill::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {
        return OrderFillValidator::class;
    }

	public function presenter()
	{
		return OrderFillPresenter::class;
	}

	/**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

	public function findById($id_primary, $id_secondary, $columns = ['*'])
	{
		return $this->findWhere(['order_primary_id' => $id_primary, 'order_secondary_id' => $id_secondary], $columns);
	}
}
