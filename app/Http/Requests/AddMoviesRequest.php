<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddMoviesRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
	 */
	public function rules(): array
	{
		return [
			'name_en'        => ['required', Rule::unique('movies', 'name')],
			'name_ka'        => ['required',  Rule::unique('movies', 'name')],
			'director_en'    => ['required'],
			'director_ka'    => ['required'],
			'description_en' => ['required'],
			'description_ka' => ['required'],
			'budget'         => 'required',
			'release_date'   => 'required',
			'thumbnail'      => 'required|image|mimes:jpeg,png,jpg|max:2048',
		];
	}
}
