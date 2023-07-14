<?php

namespace App\Http\Controllers;

use App\Events\CommentEvent;
use App\Events\NotificationEvent;
use App\Http\Requests\AddCommentRequest;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
	public function store(AddCommentRequest $request): JsonResponse
	{
		$attributes = [
			'quote_id' => $request['quote_id'],
			'body'     => $request['body'],
		];

		$user = auth()->user();

		$comment = new Comment($attributes);
		$comment->user()->associate($user);
		$comment->save();

		$quote = Quote::where('id', $request['quote_id'])->first();
		$quoteAuthorId = $quote->user_id;

		if ($user->id !== $quoteAuthorId) {
			$notification = new Notification();
			$notification->from = $user->id;
			$notification->to = $quoteAuthorId;
			$notification->type = 'comment';
			$notification->save();
			event(new NotificationEvent($request->all()));
		}

		event(new CommentEvent($request->body));

		return response()->json(['message' => 'Post commented successfully'], 201);
	}
}
