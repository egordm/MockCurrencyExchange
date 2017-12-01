<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 2-12-2017
 * Time: 00:36
 */

namespace Tests\APP\Feature;


use Tests\TestCase;

class AuthenticationTest extends TestCase
{
	public function testLogin()
	{
		$response = $this->withSession(['_token'=>'test'])->postJson(route('login'), [
			'email' => 'gopnik@adidas.ru',
			'password' => 'no_nsa',
			'_token'=>'test'
		]);

		$response->assertStatus(200);
		$response->assertJsonFragment(['success' => true]);
	}

	public function testRegister() {
		$user = \DB::table('users')->where(['email' => 'test@test.test'])->first();
		if($user) \DB::table('users')->delete($user->id);

		$response = $this->withSession(['_token'=>'test'])->postJson(route('register'), [
			'name' => 'Jonny Test',
			'email' => 'test@test.test',
			'password' => 'test_test',
			'_token'=>'test'
		]);
		$response->assertStatus(200);
		$response->assertJsonFragment(['success' => true]);
	}
}