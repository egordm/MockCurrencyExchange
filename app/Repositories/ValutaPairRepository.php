<?php

namespace App\Repositories;

use App\Models\ValutaPair;
use App\Repositories\Criteria\ValutaMarketCriteria;
use App\Validators\ValutaPairValidator;
use Prettus\Repository\Criteria\RequestCriteria;

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

	/**
	 * Boot up the repository, pushing criteria
	 * @throws \Prettus\Repository\Exceptions\RepositoryException
	 */
	public function boot()
	{
		$this->pushCriteria(app(RequestCriteria::class));
	}

	public function allDisplay()
	{
		return $this->with(['valuta_primary', 'valuta_secondary'])->all();
	}

	public function findByMarket($market)
	{
		/** @noinspection PhpUnhandledExceptionInspection */
		$this->pushCriteria(new ValutaMarketCriteria($market));
		$ret = $this->first();
		$this->resetCriteria();
		return $ret;
	}
}
