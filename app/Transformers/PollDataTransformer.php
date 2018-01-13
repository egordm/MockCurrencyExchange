<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 13-1-2018
 * Time: 23:03
 */

namespace App\Transformers;


use App\Repositories\Presenters\CandleNodePresenter;
use League\Fractal\TransformerAbstract;

class PollDataTransformer extends TransformerAbstract
{
	protected $defaultIncludes = ['depth', 'candles', 'history'];

	/**
	 * Transform the polled data
	 * @param $model
	 *
	 * @return array
	 * @throws \Exception
	 */
	public function transform($model)
	{
		return [];
	}

	public function includeCandles($model)
	{
		return $this->collection($model['candles'], new CandleNodeTransformer());
	}

	public function includeDepth($model)
	{
		return $this->item($model['depth'], new DepthTransformer());
	}

	public function includeHistory($model)
	{
		return $this->collection($model['history'], new HistoryTransformer());
	}
}