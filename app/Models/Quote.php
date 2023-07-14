<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Quote extends Model
{
	use HasFactory;

	use HasTranslations;

	protected $guarded = ['id'];

	public $translatable = ['quote'];

	public function movie(): BelongsTo
	{
		return $this->belongsTo(Movie::class);
	}

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	public function comments(): HasMany
	{
		return $this->hasMany(Comment::class);
	}

	public function likes(): HasMany
	{
		return $this->hasMany(Like::class);
	}

	protected function body(): Attribute
	{
		return Attribute::make(
			get: fn ($value) => json_decode($value, true),
			set: fn ($value) => json_encode($value),
		);
	}

	public function scopeFilter($query, $search)
	{
		return $query->where(function ($query) use ($search) {
			if (strpos($search, '@') === 0) {
				$search = ltrim($search, $search[0]);
				$query->whereHas('movie', function ($movie) use ($search) {
					$movie->where(DB::raw('lower(name)'), 'LIKE', '%' . strtolower($search) . '%')
						->orWhere('name->ka', 'LIKE', "%{$search}%");
				});
			} elseif (strpos($search, '#') === 0) {
				$search = ltrim($search, $search[0]);
				$query->where(DB::raw('lower(quote)'), 'LIKE', '%' . strtolower($search) . '%')
					->orWhere('quote->ka', 'LIKE', "%{$search}%");
			} else {
				$query->whereHas('movie', function ($movie) use ($search) {
					$movie->where(DB::raw('lower(name)'), 'LIKE', '%' . strtolower($search) . '%')
						->orWhere('name->ka', 'LIKE', "%{$search}%");
				})
				->orWhere(DB::raw('lower(quote)'), 'LIKE', '%' . strtolower($search) . '%')
				->orWhere('quote->ka', 'LIKE', "%{$search}%");
			}
		})
		->orderByDesc('id');
	}
}
