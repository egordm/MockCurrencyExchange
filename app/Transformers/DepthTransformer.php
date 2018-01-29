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
	const MAX_DISPLAY = 60;
	protected $defaultIncludes = ['bids', 'asks'];

	/**
	 * @param array $model
	 *
	 * @return array
	 */
	public function transform($model)
	{
		return [];
	}

	public function includeBids($model)
	{
		$bids = array_slice($model[0]->toArray(), 0, self::MAX_DISPLAY);
		return $this->collection($bids, new DepthOrderTransformer());
	}

	public function includeAsks($model)
	{
		$asks = array_slice($model[1]->toArray(), -self::MAX_DISPLAY, self::MAX_DISPLAY, true);
		return $this->collection($asks, new DepthOrderTransformer());
	}
}