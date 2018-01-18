<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 18-1-2018
 * Time: 18:50
 */

namespace App\Transformers;


use League\Fractal\TransformerAbstract;

class PollUserDataTransformer extends TransformerAbstract
{
	protected $defaultIncludes = ['balance', 'orders'];

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

	public function includeBalance($model)
	{
		return $this->collection($model['balance'], new BalanceTransformer());
	}

	public function includeOrders($model)
	{
		return $this->collection($model['orders'], new OrderTransformer());
	}
}