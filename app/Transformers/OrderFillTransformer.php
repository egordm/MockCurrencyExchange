<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\OrderFill;

/**
 * Class OrderFillTransformer
 * @package namespace App\Transformers;
 */
class OrderFillTransformer extends TransformerAbstract
{

    /**
     * Transform the OrderFill entity
     * @param OrderFill $model
     *
     * @return array
     */
    public function transform(OrderFill $model)
    {
        return [
        	'hello' => 'world'
            //'id'         => (int) $model->,

            /* place your other model properties here */

            //'created_at' => $model->created_at,
            //'updated_at' => $model->updated_at
        ];
    }
}
