<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditQuoteRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
	 */
	public function rules(): array
	{
		return [
			'body_en'        => ['required'],
			'body_ka'        => ['required'],
			'thumbnail'      => 'image|mimes:jpeg,png,jpg|max:2048',
		];
	}
}
