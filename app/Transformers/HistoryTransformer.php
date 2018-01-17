<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 13-1-2018
 * Time: 23:38
 */

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class HistoryTransformer extends TransformerAbstract
{
	/**
	 * Transform the Order entity
	 * @param $model
	 *
	 * @return array
	 */
	public function transform($model)
	{
		return [
			'buy' => (bool)$model['buy'],
			'price' => (double)$model['price'],
			'quantity' => (double)$model['quantity'],
			'time' => $model['updated_at']->timestamp
		];
	}
}