<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Order;

/**
 * Class OrderTransformer
 * @package namespace App\Transformers;
 */
class OrderTransformer extends TransformerAbstract
{
	public $defaultIncludes = ['valuta_pair'];
	public $availableIncludes = ['valuta_pair', 'order_fills'];

    /**
     * Transform the Order entity
     * @param Order $model
     *
     * @return array
     */
    public function transform(Order $model)
    {
        return [
            'id'         => (int) $model->id,
	        'price' => $model->price,
	        'quantity' => $model->quantity,
	        'fee' => $model->fee,
	        'buy' => (bool)$model->buy,
	        'type' => $model->type,
	        'status' => $model->status,
	        'settled' => $model->settled,
	        'filled_percentage' => $model->filled_percentage(),
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at,
        ];
    }

    public function includeValutaPair(Order $model) {
	    return $this->item($model->valuta_pair, new ValutaPairTransformer());
    }

	public function includeOrderFills(Order $model) {
		return $this->collection($model->order_fills(), new FillOrderTransformer($model));
	}
}
