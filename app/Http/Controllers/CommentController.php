<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCommentRequest;
use App\Models\Comment;
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
		return response()->json($comment);
	}
}
