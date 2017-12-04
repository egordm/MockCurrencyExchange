<?php

namespace App\Repositories;

use App\Repositories\Presenters\ValutaPairPresenter;
use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\ValutaPair;
use App\Validators\ValutaPairValidator;

/**
 * Class ValutaPairRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ValutaPairRepository extends PresentableRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ValutaPair::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ValutaPairValidator::class;
    }

	public function presenter()
	{
		return ValutaPairPresenter::class;
	}

	/**
	 * Boot up the repository, pushing criteria
	 * @throws \Prettus\Repository\Exceptions\RepositoryException
	 */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function all_display() {
    	return $this->with(['valuta_primary', 'valuta_secondary'])->all();
    }
}
