<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuoteResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id'        => $this->id,
			'quote'     => $this->getTranslations('quote'),
			'thumbnail' => $this->thumbnail,
			'movie'     => [
				'name' => $this->movie->getTranslations('name'),
				'year' => $this->movie->release_date,
			],
		];
	}
}
