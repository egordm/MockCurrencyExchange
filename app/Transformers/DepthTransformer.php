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
	//protected $defaultIncludes = ['bid', 'ask'];

	private function clean($orders)
	{
		$ret = [];
		foreach ($orders as $order) {
			if(empty($ret[$order->price])) $ret[$order->price] = ['price' => $order->price, 'quantity' => 0];
			$ret[$order->price]['quantity'] += $order->quantity;
		}
		return array_values($ret);
	}

	/**
	 * @param array $model
	 *
	 * @return array
	 */
	public function transform($model)
	{
		return [
			'bids' => !empty($model[0]) ? $this->collection($this->clean($model[0]), new DepthOrderTransformer())->getData() : [],
			'asks' => !empty($model[1]) ? $this->collection($this->clean($model[1]), new DepthOrderTransformer())->getData() : []
		];
	}
}