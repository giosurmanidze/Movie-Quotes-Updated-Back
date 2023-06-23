<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
	 */
	public function rules()
	{
		return [
			'email' => ['required', 'email', 'exists:users'],
		];
	}

	public function messages()
	{
		return [
			'email.exists' => [
				'ka' => __('validation.exists', ['attribute' => 'მეილით'], 'ka'),
				'en' => __('validation.exists', ['attribute' => 'email'], 'en'),
			],
		];
	}
}
