<?php

namespace App\Http\Controllers;

use App\Http\Requests\LikeQuoteRequest;
use App\Models\Like;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class LikeController extends Controller
{
	public function like(LikeQuoteRequest $request): JsonResponse
	{
		$attributes = [
			'quote_id' => $request['quote_id'],
			'like'     => $request['like'],
		];

		$userId = auth()->user()->id;

		$attributes['user_id'] = $userId;
		$attributes['username'] = auth()->user()->username;

		$user = User::where('id', $userId)->first();

		$isLiked = $user->likes()->where('quote_id', $attributes['quote_id'])->first();

		if (!$isLiked) {
			Like::create($attributes);
			return response()->json('liked');
		} else {
			$isLiked->delete();
			return response()->json('like deleted');
		}
	}
}
