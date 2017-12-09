<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 1-12-2017
 * Time: 21:18
 */

namespace Infrastructure\Controllers;

use Illuminate\Routing\Controller;
use Prettus\Repository\Contracts\PresenterInterface;

abstract class APIController extends Controller
{
	/**
	 * @return PresenterInterface
	 */
	public abstract function presenter();

	public function present($data)
	{
		return $this->presenter()->present($data);
	}

}