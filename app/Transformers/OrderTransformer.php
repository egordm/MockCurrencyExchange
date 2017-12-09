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
	        'type' => (int) $model->type,
	        'status' => (int) $model->status,
	        'settled' => (int) $model->settled,
	        'filled_quantity' => $model->getFilledQuantity(),
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at,
        ];
    }

    public function includeValutaPair(Order $model) {
	    return $this->item($model->valuta_pair, new ValutaPairTransformer());
    }
}
