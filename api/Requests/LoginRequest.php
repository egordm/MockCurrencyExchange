<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 1-12-2017
 * Time: 22:18
 */

namespace API\Requests;


use Infrastructure\Requests\APIRequest;

class LoginRequest extends APIRequest
{
	public function rules()
	{
		return [
			'email' => 'required|email',
			'password' => 'required'
		];
	}
}