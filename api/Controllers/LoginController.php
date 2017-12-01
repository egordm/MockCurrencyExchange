<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 1-12-2017
 * Time: 22:14
 */

namespace API\Controllers;


use API\Requests\LoginRequest;
use Illuminate\Validation\ValidationException;
use Infrastructure\Auth\LoginProxy;
use Infrastructure\Requests\APIRequest;

class LoginController extends APIController
{
	/**
	 * @var LoginProxy
	 */
	private $loginProxy;

	/**
	 * LoginController constructor.
	 * @param LoginProxy $loginProxy
	 */
	public function __construct(LoginProxy $loginProxy)
	{
		$this->loginProxy = $loginProxy;
	}

	public function login(LoginRequest $request)
	{
		$email = $request->get('email');
		$password = $request->get('password');

		return \Response::make($this->loginProxy->attemptLogin($email, $password));
	}

	public function refresh(APIRequest $request)
	{
		/** @noinspection PhpUnhandledExceptionInspection */
		\Validator::validate($request->all(), ['refresh_token' => 'required']);
		$refreshToken = $request->get('refresh_token');

		return \Response::make($this->loginProxy->attemptRefresh($refreshToken));
	}

	public function logout()
	{
		$this->loginProxy->logout();

		return \Response::make(null, 204);
	}
}