<?php

namespace App\Transformers;

use App\Models\Valuta;
use League\Fractal\TransformerAbstract;

/**
 * Class ValutaTransformer
 * @package namespace App\Transformers;
 */
class ValutaTransformer extends TransformerAbstract
{

	/**
	 * Transform the Valuta entity
	 * @param Valuta $model
	 *
	 * @return array
	 */
	public function transform(Valuta $model)
	{
		return [
			'id' => (int)$model->id,
			'symbol' => $model->symbol,
			'name' => $model->name
		];
	}
}
