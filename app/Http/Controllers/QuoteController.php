<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddQuotesRequest;
use App\Http\Requests\EditQuoteRequest;
use App\Http\Requests\SearchQuoteRequest;
use App\Http\Resources\QuotePostResource;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class QuoteController extends Controller
{
	public function index(): JsonResponse
	{
		$quotes = QuotePostResource::collection(Quote::orderByDesc('id')->get());
		return response()->json($quotes, 200);
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
		return response()->json(QuotePostResource::make($quote), 200);
	}

	public function update(EditQuoteRequest $request, Quote $quote): JsonResponse
	{
		$attributes = [
			'quote' => [
				'en' => $request['body_en'],
				'ka' => $request['body_ka'],
			],
		];

		if ($request->hasFile('thumbnail')) {
			$attributes['thumbnail'] = $request->file('thumbnail')->store('thumbnails');
		}

		$quote->update($attributes);
		return response()->json($quote);
	}

	public function destroy(Quote $quote)
	{
		$quote->delete();
		return response()->json('Quote deleted successfully');
	}

	public function searchPost(SearchQuoteRequest $request): JsonResponse
{
    $search = $request->search;
    $query = Quote::with('movie');

    if (strpos($search, '@') === 0) {
        $search = ltrim($search, '@');
        $query->whereHas('movie', function ($movie) use ($search) {
            $movie->where(DB::raw('lower(name)'), 'LIKE', '%' . strtolower($search) . '%')
                  ->orWhere('name->ka', 'LIKE', "%{$search}%");
        });
    } elseif (strpos($search, '#') === 0) {
        $search = ltrim($search, '#');
        $query->where(function ($query) use ($search) {
            $query->where(DB::raw('lower(quote)'), 'LIKE', '%' . strtolower($search) . '%')
                  ->orWhere('quote->ka', 'LIKE', "%{$search}%");
        });
    } else {
        $query->where(function ($query) use ($search) {
            $query->where(function ($subQuery) use ($search) {
                $subQuery->where(DB::raw('lower(name)'), 'LIKE', '%' . strtolower($search) . '%')
                         ->orWhere('name->ka', 'LIKE', "%{$search}%");
            })
            ->orWhere(function ($subQuery) use ($search) {
                $subQuery->where(DB::raw('lower(quote)'), 'LIKE', '%' . strtolower($search) . '%')
                         ->orWhere('quote->ka', 'LIKE', "%{$search}%");
            });
        });
    }
    $quote = QuotePostResource::collection($query->orderByDesc('id')->get());
    return response()->json($quote, 200);
}

}
