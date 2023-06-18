<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuotePostResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id'           => $this->id,
			'quote'        => $this->getTranslations('quote'),
			'quote_ka'     => $this->getTranslation('quote', 'ka'),
			'quote_en'     => $this->getTranslation('quote', 'en'),
			'movie'        => MovieResource::make($this->movie)->getTranslations('name'),
			'year'         => MovieResource::make($this->movie)->release_date,
			'movie_id'     => MovieResource::make($this->movie)->id,
			'thumbnail'    => $this->thumbnail,
			'user'         => UserResource::make($this->user),
		];
	}
}
