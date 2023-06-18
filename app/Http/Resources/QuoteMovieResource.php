<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuoteMovieResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request)
	{
		return [
			'id'          => $this->id,
			'quote'       => $this->getTranslations('quote'),
			'thumbnail'   => $this->thumbnail,
			'user_id'     => $this->user_id,
		];
	}
}
