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

		$attributes['user_id'] = auth()->id();
		$attributes['username'] = auth()->user()->username;
		$attributes['thumbnail'] = auth()->user()->thumbnail;

		$comment = Comment::create($attributes);

		$quote = Quote::where('id', $request['quote_id'])->first();

		$quoteAuthorId = $quote->user_id;

		if (auth()->id() !== $quoteAuthorId) {
			$notification = new Notification();
			$notification->from = auth()->id();
			$notification->to = $quoteAuthorId;
			$notification->type = 'comment';
			$notification->save();
			event(new NotificationEvent($request->all()));
		}

		event(new CommentEvent($request->body));
		$comment->save();

		return response()->json(['message' => 'Post commented successfully'], 201);
	}
}
