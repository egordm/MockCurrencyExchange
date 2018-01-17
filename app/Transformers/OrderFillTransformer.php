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
        return [];
    }
}
