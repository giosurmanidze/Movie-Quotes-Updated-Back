<?php

namespace App\Http\Controllers;

use App\Http\Requests\LikeQuoteRequest;
use App\Models\Like;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class LikeController extends Controller
{
	public function store(LikeQuoteRequest $request): JsonResponse
	{
		$like = DB::transaction(function () use ($request) {
			return Like::create([
				'user_id'  => auth()->id(),
				'quote_id' => $request->quote_id,
			]);
		});

		return response()->json(['message' => 'Post liked successfully', 'like_id' => $like->id], 201);
	}

	public function destroy(Like $like): JsonResponse
	{
		$like->delete();
		return response()->json(['message' => 'Successfully unliked'], 200);
	}
}
