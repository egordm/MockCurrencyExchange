<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 4-12-2017
 * Time: 13:55
 */

namespace App\Repositories;


use Prettus\Repository\Eloquent\BaseRepository;

abstract class PresentableRepository extends BaseRepository
{
	public function present($relations)
	{
		$this->presenter->parseIncludes($relations);
		return $this;
	}
}