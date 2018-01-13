<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 13-1-2018
 * Time: 23:38
 */

namespace App\Repositories\Presenters;


use App\Transformers\HistoryTransformer;

class HistoryPresenter extends FractalRelationshipsPresenter
{
	/**
	 * Transformer
	 *
	 * @return \League\Fractal\TransformerAbstract
	 */
	public function getTransformer()
	{
		return new HistoryTransformer();
	}
}