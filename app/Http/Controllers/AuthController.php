<?php


namespace App\Http\Controllers;

use API\Requests\RegisterRequest;
use App\Repositories\UserRepository;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 2-12-2017
 * Time: 00:22
 */
class AuthController extends Controller
{
	use RegistersUsers, AuthenticatesUsers{
		AuthenticatesUsers::guard insteadof RegistersUsers;
		AuthenticatesUsers::redirectPath insteadof RegistersUsers;
	}

	public function postLogin(Request $request)
	{
		$request->session()->regenerate();
		$this->clearLoginAttempts($request);

		if ($request->acceptsJson()) return ['success' => true];
		else  return $this->authenticated($request, $this->guard()->user()) ?: redirect()->intended($this->redirectPath());
	}

	public function register(RegisterRequest $request, UserRepository $userRepository)
	{
		event(new Registered($user = $userRepository->create($request->all())));

		$this->guard()->login($user);

		if ($request->acceptsJson()) return ['success' => true];
		return $this->registered($request, $user) ?: redirect($this->redirectPath());
	}

	public function logout(Request $request)
	{
		$this->guard()->logout();

		// $request->session()->invalidate(); TODO: this fuckign bullshit kills my csrf token.

		if ($request->acceptsJson()) return ['success' => true];
		return redirect('/');
	}
}