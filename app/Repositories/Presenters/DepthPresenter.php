<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 10-12-2017
 * Time: 00:37
 */

namespace App\Repositories\Presenters;


use App\Transformers\DepthTransformer;
use Exception;

class DepthPresenter extends FractalRelationshipsPresenter
{
	/**
	 * Transformer
	 *
	 * @return \League\Fractal\TransformerAbstract
	 */
	public function getTransformer()
	{
		return new DepthTransformer();
	}

	public function present($data)
	{
		if (!class_exists('League\Fractal\Manager')) {
			throw new Exception(trans('repository::packages.league_fractal_required'));
		}

		$this->resource = $this->transformItem($data);

		return $this->fractal->createData($this->resource)->toArray();
	}


}