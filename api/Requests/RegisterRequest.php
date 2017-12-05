<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 1-12-2017
 * Time: 23:44
 */

namespace API\Requests;


use Infrastructure\Requests\APIRequest;

class RegisterRequest extends APIRequest
{
	public function rules()
	{
		return [
			'name' => 'required|string|max:255',
			'email' => 'required|string|email|unique:users|max:255',
			'password' => 'required|string|max:255|min:8'
		];
	}


}