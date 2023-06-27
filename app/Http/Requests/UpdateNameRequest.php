<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNameRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
	 */
	public function rules(): array
	{
		return [
			'username' => ['required', 'min:3', 'max:15', 'unique:users', 'regex:/^[a-z0-9]*$/'],
		];
	}

	public function messages()
	{
		return [
			'name.unique' => [
				'ka' => __('validation.unique', ['attribute' => 'სახელი'], 'ka'),
				'en' => __('validation.unique', ['attribute' => 'name'], 'en'),
			],
		];
	}
}
