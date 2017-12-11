<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 11-12-2017
 * Time: 14:24
 */

namespace App\Transformers;


use App\Models\CandlestickNode;
use League\Fractal\TransformerAbstract;

class CandleNodeTransformer extends TransformerAbstract
{
	/**
	 * @param CandlestickNode $model
	 * @return array
	 */
	public function transform($model)
	{
		return [
			'open' => $model->open,
			'high' => $model->high,
			'low' => $model->low,
			'close' => $model->close,
			'volume' => $model->volume,
			'open_time' => $model->open_time,
			'close_time' => $model->close_time,
		];
	}
}