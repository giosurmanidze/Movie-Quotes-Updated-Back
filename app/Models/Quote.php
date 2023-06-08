<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
	protected $fillable = [
		'body_en',
		'body_ka',
	];

	use HasFactory;
}
