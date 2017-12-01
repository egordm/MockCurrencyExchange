<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 1-12-2017
 * Time: 22:16
 */

namespace Infrastructure\Requests;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class APIRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}

	protected function failedValidation(Validator $validator)
	{
		throw new UnprocessableEntityHttpException($validator->errors()->toJson());
	}

	protected function failedAuthorization()
	{
		/** @noinspection PhpUnhandledExceptionInspection */
		throw new \Exception("", 403);
	}

	public function rules()
	{
		return [];
	}
}