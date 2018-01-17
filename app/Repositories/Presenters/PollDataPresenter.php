<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 11-12-2017
 * Time: 14:28
 */

namespace App\Repositories\Presenters;


use App\Transformers\CandleNodeTransformer;
use App\Transformers\PollDataTransformer;
use Exception;

class PollDataPresenter extends FractalRelationshipsPresenter
{

	/**
	 * Transformer
	 *
	 * @return \League\Fractal\TransformerAbstract
	 */
	public function getTransformer()
	{
		return new PollDataTransformer();
	}
}