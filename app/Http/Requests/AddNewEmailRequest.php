<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddNewEmailRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
	 */
	public function rules(): array
	{
		return [
			'email'    => ['required', 'email', 'unique:users'],
		];
	}

	public function messages()
	{
		return [
			'email.unique' => [
				'en' => __('validation.unique', ['attribute' => 'email'], 'en'),
				'ka' => __('validation.unique', ['attribute' => 'იმეილი'], 'ka'),
			],
		];
	}
}
