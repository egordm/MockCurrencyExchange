<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 10-12-2017
 * Time: 00:25
 */

namespace App\Transformers;


use App\Models\Order;
use League\Fractal\TransformerAbstract;

class DepthOrderTransformer extends TransformerAbstract
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
			'price' => (double)$model->price,
			'quantity' => (double)$model->quantity
		];
	}
}