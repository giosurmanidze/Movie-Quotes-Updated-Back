<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quote extends Model
{
	use HasFactory;

	protected $fillable = ['user_id', 'body', 'movie_id', 'thumbnail'];

	public function movie(): BelongsTo
	{
		return $this->belongsTo(Movie::class);
	}

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	protected function body(): Attribute
	{
		return Attribute::make(
			get: fn ($value) => json_decode($value, true),
			set: fn ($value) => json_encode($value),
		);
	}
}
