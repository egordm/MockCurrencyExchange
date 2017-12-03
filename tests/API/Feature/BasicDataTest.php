<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 3-12-2017
 * Time: 13:30
 */

namespace Tests\API\Feature;


use App\User;
use Tests\TestCase;

class BasicDataTest extends TestCase
{
	public function testBalance()
	{
		$user = User::where(['email' => 'gopnik@adidas.ru'])->first();
		$response = $this->actingAs($user)->getJson(route('api.balance'));
		$response->assertStatus(200);
	}
}