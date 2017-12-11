<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 1-12-2017
 * Time: 21:18
 */

namespace Infrastructure\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use Prettus\Repository\Contracts\PresenterInterface;
use Prettus\Validator\Exceptions\ValidatorException;

abstract class APIController extends Controller
{
	/**
	 * @return PresenterInterface
	 */
	public function presenter()
	{
		return null;
	}

	public function present($data)
	{
		return $this->presenter()->present($data);
	}
}