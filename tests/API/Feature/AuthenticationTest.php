<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 1-12-2017
 * Time: 23:11
 */

namespace Tests\API\Feature;


use App\Repositories\UserRepository;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
	public function testLogin()
	{
		$response = $this->postJson(route('api.login'), [
			'email' => 'gopnik@adidas.ru',
			'password' => 'no_nsa'
		]);

		$response->assertStatus(200);
		$response->assertJsonStructure(['access_token', 'refresh_token', 'expires_in']);
	}

	public function testRefresh() {
		$responseLogin = $this->postJson(route('api.login'), [
			'email' => 'gopnik@adidas.ru',
			'password' => 'no_nsa'
		]);
		$responseLogin->assertStatus(200);
		$responseLogin->assertJsonStructure(['access_token', 'refresh_token', 'expires_in']);

		$response = $this->postJson(route('api.refresh'), [
			'refresh_token' => $responseLogin->json()['refresh_token']
		]);
		$response->assertStatus(200);
		$response->assertJsonStructure(['access_token', 'refresh_token', 'expires_in']);
	}

	public function testRegister() {
		$user = \DB::table('users')->where(['email' => 'test@test.test'])->first();
		if($user) \DB::table('users')->delete($user->id);

		$response = $this->postJson(route('api.register'), [
			'name' => 'Jonny Test',
			'email' => 'test@test.test',
			'password' => 'test_test'
		]);
		$response->assertStatus(200);
		$response->assertJsonFragment(['success' => true]);
	}
}