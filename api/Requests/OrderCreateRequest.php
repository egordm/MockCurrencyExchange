<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 6-12-2017
 * Time: 19:50
 */

namespace API\Requests;


use Infrastructure\Requests\APIRequest;

class OrderCreateRequest extends APIRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			//
		];
	}
}