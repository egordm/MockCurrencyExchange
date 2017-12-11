<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 10-12-2017
 * Time: 00:33
 */

namespace App\Transformers;


use League\Fractal\TransformerAbstract;

class DepthTransformer extends TransformerAbstract
{
	protected $defaultIncludes = ['demand', 'supply'];

	/**
	 * @param array $model
	 *
	 * @return array
	 */
	public function transform($model)
	{
		return [
		];
	}

	public function includeDemand($model) {
		return  $this->collection(isset($model[0]) ? $model[0] : [], new DepthOrderTransformer());
	}

	public function includeSupply($model) {
		return  $this->collection(isset($model[1]) ? $model[1] : [], new DepthOrderTransformer());
	}
}