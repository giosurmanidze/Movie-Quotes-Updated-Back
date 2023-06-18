<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddQuotesRequest;
use App\Http\Resources\QuotePostResource;
use App\Http\Resources\QuoteResource;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;

class QuoteController extends Controller
{
	public function index(): JsonResponse
	{
		$quote = QuoteResource::collection(Quote::orderByDesc('id')->get());

		return response()->json($quote, 200);
	}

	public function store(AddQuotesRequest $request): JsonResponse
	{
		$attributes = [
			'quote' => [
				'en' => $request['body_en'],
				'ka' => $request['body_ka'],
			],
			'movie_id'     => $request['movie_id'],
			'thumbnail'    => $request['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public'),
			'user_id'      => auth()->user()->id,
		];

		$quote = Quote::create($attributes);
		if (!$quote) {
			return response()->json('Something went wrong', 422);
		}

		return response()->json($quote->load('user')->load('movie'), 200);
	}

	public function show(Quote $quote): JsonResponse
	{
		if ($quote->user_id !== auth()->id()) {
			return response()->json(['message' => 'Not Authorized'], 401);
		}

		return response()->json(QuotePostResource::make($quote), 200);
	}
}
