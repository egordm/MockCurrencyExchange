<?php

namespace App\Repositories;

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
		return OrderPresenter::class;
	}

	/**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
