<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 4-12-2017
 * Time: 13:23
 */

namespace App\Repositories\Presenters;


use Prettus\Repository\Presenter\FractalPresenter;

abstract class FractalRelationshipsPresenter extends FractalPresenter
{
	public function parseIncludes($includes = [])
	{
		$request = app('Illuminate\Http\Request');
		$paramIncludes = config('repository.fractal.params.include', 'include');

		if ($request->has($paramIncludes)) {
			$includes = array_merge($includes, explode(',', $request->get($paramIncludes)));

		}
		$this->fractal->parseIncludes($includes);

		return $this;
	}
}