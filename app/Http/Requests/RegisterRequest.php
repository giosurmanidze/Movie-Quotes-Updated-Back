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
			'name'                  => 'required|min:3|max:15|unique:users',
			'email'                 => 'required|email|unique:users',
			'password'              => 'required|min:8|max:15|confirmed',
			'password_confirmation' => 'required',
		];
	}
}
