<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 1-12-2017
 * Time: 22:02
 */

namespace Infrastructure\Auth;


use App\Repositories\UserRepository;
use Illuminate\Cookie\CookieJar;
use Illuminate\Foundation\Application;
use Infrastructure\Exceptions\InvalidCredentialsException;
use Optimus\ApiConsumer\Facade\ApiConsumer;

class LoginProxy
{
	const REFRESH_TOKEN = 'refreshToken';

	/**
	 * @var ApiConsumer
	 */
	private $apiConsumer;

	/**
	 * @var \Auth
	 */
	private $auth;

	/**
	 * @var \DB
	 */
	private $db;

	/**
	 * @var \Request
	 */
	private $request;

	/**
	 * @var UserRepository
	 */
	private $userRepository;

	/**
	 * LoginProxy constructor.
	 * @param Application $app
	 * @param CookieJar $cookieJar
	 * @param UserRepository $userRepository
	 */
	public function __construct(Application $app, UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;

		$this->apiConsumer = $app->make('apiconsumer');
		$this->auth = $app->make('auth');
		$this->db = $app->make('db');
		$this->request = $app->make('request');
	}

	/**
	 * Attempt to create an access token using user credentials
	 *
	 * @param string $email
	 * @param string $password
	 * @return array
	 */
	public function attemptLogin($email, $password)
	{
		$user = $this->userRepository->findWhere(['email' => $email])->first(); // TODO: do we need first?

		if (!is_null($user)) {
			return $this->proxy('password', [
				'username' => $email,
				'password' => $password
			]);
		}

		throw new InvalidCredentialsException();
	}

	/**
	 * Attempt to refresh the access token used a refresh token that
	 * has been saved in a cookie
	 * @param string $refreshToken
	 * @return array
	 */
	public function attemptRefresh($refreshToken)
	{
		return $this->proxy('refresh_token', [
			'refresh_token' => $refreshToken
		]);
	}

	/**
	 * Proxy a request to the OAuth server.
	 *
	 * @param string $grantType what type of grant type should be proxied
	 * @param array $data the data to send to the server
	 * @return array
	 */
	public function proxy($grantType, array $data = [])
	{
		$data = array_merge($data, [
			'client_id' => env('PASSWORD_CLIENT_ID'),
			'client_secret' => env('PASSWORD_CLIENT_SECRET'),
			'grant_type' => $grantType
		]);

		$response = $this->apiConsumer->post('/oauth/token', $data);

		if (!$response->isSuccessful()) {
			throw new InvalidCredentialsException();
		}

		$data = json_decode($response->getContent());

		return [
			'access_token' => $data->access_token,
			'refresh_token' => $data->refresh_token,
			'expires_in' => $data->expires_in
		];
	}

	/**
	 * Logs out the user. We revoke access token and refresh token.
	 * Also instruct the client to forget the refresh cookie.
	 */
	public function logout()
	{
		$accessToken = $this->auth->user()->token();

		$refreshToken = $this->db
			->table('oauth_refresh_tokens')
			->where('access_token_id', $accessToken->id)
			->update([
				'revoked' => true
			]);

		$accessToken->revoke();
	}
}