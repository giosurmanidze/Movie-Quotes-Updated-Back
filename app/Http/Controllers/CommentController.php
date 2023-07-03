<?php

namespace App\Http\Controllers;

use App\Events\CommentedQuote;
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

		$attributes['user_id'] = auth()->user()->id;
		$attributes['username'] = auth()->user()->username;
		$attributes['thumbnail'] = auth()->user()->thumbnail;

		$comment = Comment::create($attributes);

		$quote = Quote::where('id', $request['quote_id'])->first();

		$quoteAuthorId = $quote->user_id;

		if (auth()->user()->id !== $quoteAuthorId)
		{
			$notification = new Notification();
			$notification->from = auth()->user()->id;
			$notification->to = $quoteAuthorId;
			$notification->type = 'comment';
			$notification->save();
			event((new CommentedQuote($notification->load('sender'))));
		}

		return response()->json($comment);
	}
}
