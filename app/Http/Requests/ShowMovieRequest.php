<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowMovieRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize()
	{
		$movie = $this->route('movie');

		return $movie->user_id === auth()->id();
	}
}
