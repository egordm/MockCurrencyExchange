<?php

namespace App\Transformers;

use App\Models\ValutaPair;
use League\Fractal\TransformerAbstract;

/**
 * Class ValutaPairTransformer
 * @package namespace App\Transformers;
 */
class ValutaPairTransformer extends TransformerAbstract
{
	protected $defaultIncludes = ['valuta_primary', 'valuta_secondary'];

	/**
	 * Transform the ValutaPair entity
	 * @param ValutaPair $model
	 *
	 * @return array
	 */
	public function transform(ValutaPair $model)
	{
		$last_order = $model->history()->limit(1)->get()->first();
		$price = !empty($last_order) ? (int)$last_order->price : null;
		return [
			'id' => (int)$model->id,
			'price' => $price
		];
	}

	public function includeValutaPrimary(ValutaPair $model) {
		return $this->item($model->valuta_primary, new ValutaTransformer());
	}

	public function includeValutaSecondary(ValutaPair $model) {
		return $this->item($model->valuta_secondary, new ValutaTransformer());
	}
}
