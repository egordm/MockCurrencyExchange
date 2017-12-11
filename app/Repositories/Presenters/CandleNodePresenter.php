<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 11-12-2017
 * Time: 14:28
 */

namespace App\Repositories\Presenters;


use App\Transformers\CandleNodeTransformer;
use Exception;

class CandleNodePresenter extends FractalRelationshipsPresenter
{

	/**
	 * Transformer
	 *
	 * @return \League\Fractal\TransformerAbstract
	 */
	public function getTransformer()
	{
		return new CandleNodeTransformer();
	}

	public function present($data)
	{
		if (!class_exists('League\Fractal\Manager')) {
			throw new Exception(trans('repository::packages.league_fractal_required'));
		}

		$this->resource = $this->transformCollection($data);

		return $this->fractal->createData($this->resource)->toArray();
	}
}