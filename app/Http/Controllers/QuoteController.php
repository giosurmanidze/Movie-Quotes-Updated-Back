<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddQuotesRequest;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;

class QuoteController extends Controller
{
	public function store(AddQuotesRequest $request): JsonResponse
{
    if (!auth()->check()) {
        return response()->json('Unauthorized', 401);
    }

    $attributes = [
        'body' => [
            'en' => $request['body_en'],
            'ka' => $request['body_ka'],
        ],
        'movie_id' => $request['movie_id'],
        'thumbnail' => $request->file('thumbnail')->store('thumbnails'),
        'user_id' => auth()->user()->id,
    ];

    $quote = Quote::create($attributes);

    if (!$quote) {
        return response()->json('Something went wrong', 422);
    }

    return response()->json($quote, 200);
}
}
