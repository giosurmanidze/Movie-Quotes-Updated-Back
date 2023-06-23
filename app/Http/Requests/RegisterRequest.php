<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string,
	 */
	public function rules(): array
	{
		return [
			'username'                  => ['required', 'min:3', 'max:15', 'unique:users'],
			'email'                     => ['required', 'email', 'unique:users'],
			'password'                  => ['required', 'min:8', 'max:15', 'confirmed'],
			'password_confirmation'     => ['required'],
		];
	}

	public function messages()
	{
		return [
			'username.unique' => [
				'ka' => __('validation.unique', ['attribute' => 'სახელი'], 'ka'),
				'en' => __('validation.unique', ['attribute' => 'username'], 'en'),
			],
			'email.unique' => [
				'en' => __('validation.unique', ['attribute' => 'email'], 'en'),
				'ka' => __('validation.unique', ['attribute' => 'იმეილი'], 'ka'),
			],
		];
	}
}
