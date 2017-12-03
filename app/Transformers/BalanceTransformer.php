<?php

namespace App\Transformers;

use App\Models\Valuta;
use League\Fractal\TransformerAbstract;
use App\Models\Balance;

/**
 * Class BalanceTransformer
 * @package namespace App\Transformers;
 */
class BalanceTransformer extends TransformerAbstract
{
	protected $availableIncludes = ['valuta'];
	protected $defaultIncludes = ['valuta'];

	/**
	 * Transform the Balance entity
	 * @param Balance $model
	 *
	 * @return array
	 */
    public function transform(Balance $model)
    {
    	\Log::debug($model);
        return [
	        'quantity' => $model->quantity,
        ];
    }

    public function includeValuta(Balance $model) {
    	return $this->item($model->valuta, new ValutaTransformer());
    }
}
