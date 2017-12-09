<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 7-12-2017
 * Time: 20:32
 */

namespace App\Repositories;


use App\Models\Valuta;
use App\Repositories\Presenters\ValutaPresenter;

class ValutaRepository extends PresentableRepository
{

	/**
	 * Specify Model class name
	 *
	 * @return string
	 */
	public function model()
	{
		return Valuta::class;
	}

	public function presenter()
	{
		return ValutaPresenter::class;
	}

}