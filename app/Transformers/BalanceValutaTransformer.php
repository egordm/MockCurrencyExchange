<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 7-12-2017
 * Time: 22:43
 */

namespace App\Transformers;


use App\Models\Valuta;
use League\Fractal\TransformerAbstract;

class BalanceValutaTransformer extends TransformerAbstract // TODO: merge with balance transformer
{
	protected $defaultIncludes = ['valuta'];

	public function transform(Valuta $model)
	{
		$ret =  [
			'quantity' => $model->quantity,
			'halted' => $model->halted_quantity,
		];
		return $ret;
	}

	public function includeValuta(Valuta $model) {
		return $this->item($model, new ValutaTransformer());
	}
}