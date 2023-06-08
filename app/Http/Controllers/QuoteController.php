<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddQuotesRequest;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;

class QuoteController extends Controller
{
	public function index(): JsonResponse
	{
		$quotes = Quote::latest()->with(['movie', 'user'])->paginate(2);

		return response()->json($quotes);
	}

	public function store(AddQuotesRequest $request): JsonResponse
	{
		$attributes = [
			'body' => [
				'en' => $request['body_en'],
				'ka' => $request['body_ka'],
			],
			'movie_id'  => $request['movie_id'],
			'thumbnail' => $request['thumbnail'] = $request->file('thumbnail')->store('thumbnails'),
		];

		$attributes['user_id'] = auth()->user()->id;

		$quote = Quote::create($attributes);

		if (!$quote) {
			return response()->json('Something went wrong', 422);
		}

		return response()->json($quote->load('user')->load('movie'), 200);
	}
}
