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
		return [
			'id' => (int)$model->id,
		];
	}

	public function includeValutaPrimary(ValutaPair $model) {
		return $this->item($model->valuta_primary, new ValutaTransformer());
	}

	public function includeValutaSecondary(ValutaPair $model) {
		return $this->item($model->valuta_secondary, new ValutaTransformer());
	}
}
