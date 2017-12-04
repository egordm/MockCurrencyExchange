<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 4-12-2017
 * Time: 15:25
 */

namespace App\Transformers;


use App\Models\Order;
use App\Utils\OrderCalculations;
use League\Fractal\TransformerAbstract;

class FillOrderTransformer extends TransformerAbstract
{
	/**
	 * @var Order
	 */
	public $parent;

	/**
	 * FillOrderTransformer constructor.
	 * @param Order $parent
	 */
	public function __construct(Order $parent)
	{
		$this->parent = $parent;
	}

	/**
	 * Transform the Order entity
	 * @param Order $model
	 *
	 * @return array
	 */
	public function transform(Order $model)
	{
		return [
			'id' => (int)$model->id,
			'price' => $model->price,
			'quantity' => $model->quantity,
			'buy' => (bool)$model->buy,
			'type' => $model->type,
			'status' => $model->status,
			'settled' => $model->settled,
			'created_at' => $model->created_at,
			'updated_at' => $model->updated_at,
			'fill_percentage' => $model->fill_percentage($this->parent)
		];
	}
}