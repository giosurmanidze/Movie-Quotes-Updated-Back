<?php

namespace App\Http\Controllers;

use App\Events\LikeEvent;
use App\Events\NotificationEvent;
use App\Http\Requests\LikeQuoteRequest;
use App\Models\Like;
use App\Models\Notification;
use App\Models\Quote;
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
		$quote = Quote::where('id', $request['quote_id'])->first();
		$quoteAuthorId = $quote->user_id;

		if (auth()->id() !== $quoteAuthorId) {
			$notification = new Notification();
			$notification->from = auth()->id();
			$notification->to = $quoteAuthorId;
			$notification->type = 'like';
			$notification->save();
			event(new NotificationEvent($request->all()));
		}
		event(new LikeEvent($request->all()));

		return response()->json(['message' => 'Post liked successfully', 'like_id' => $like->id], 201);
	}

	public function destroy(Like $like): JsonResponse
	{
		$like->delete();
		return response()->json(['message' => 'Successfully unliked'], 200);
	}
}
