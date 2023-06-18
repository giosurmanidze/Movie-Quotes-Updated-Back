<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id'                          => $this->id,
			'name'                        => $this->getTranslations('name'),
			'name_ka'                     => $this->getTranslation('name', 'ka'),
			'name_en'                     => $this->getTranslation('name', 'en'),
			'director'                    => $this->getTranslations('director'),
			'director_en'                 => $this->getTranslation('director', 'en'),
			'director_ka'                 => $this->getTranslation('director', 'ka'),
			'description'                 => $this->getTranslations('description'),
			'description_ka'              => $this->getTranslation('description', 'ka'),
			'description_en'              => $this->getTranslation('description', 'en'),
			'release_date'                => $this->release_date,
			'budget'                      => $this->budget,
			'thumbnail'                   => $this->thumbnail,
			'user_id'                     => $this->user_id,
			'genres'                      => GenreResource::collection($this->genres),
			'quotes'                      => QuoteMovieResource::collection($this->quotes),
		];
	}
}
