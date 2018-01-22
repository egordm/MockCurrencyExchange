<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountUpdateRequest extends FormRequest
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
        	'name' => 'required',
        	'password' => 'nullable|required_with:new_password|old_password',
            'new_password' => 'nullable|required_with:password|confirmed|string|max:255|min:8',
            'new_password_confirmation' => 'nullable|required_with:password'
        ];
    }
}
