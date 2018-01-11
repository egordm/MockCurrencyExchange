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
			'open' => (double)$model->open,
			'high' => (double)$model->high,
			'low' => (double)$model->low,
			'close' => (double)$model->close,
			'volume' => (double)$model->volume,
			'open_time' => (int)$model->open_time,
			'close_time' => (int)$model->close_time,
		];
	}
}