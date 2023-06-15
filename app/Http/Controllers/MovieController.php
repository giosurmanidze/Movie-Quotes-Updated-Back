<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddMoviesRequest;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function store(AddMoviesRequest $request): JsonResponse
	{
		$movie = Movie::create([
			'name' => [
				'en' => $request['name_en'],
				'ka' => $request['name_ka'],
			],
			'genre' => json_encode($request['genre']),

			'director' => [
				'en' => $request['director_en'],
				'ka' => $request['director_ka'],
			],
			'description' => [
				'en' => $request['description_en'],
				'ka' => $request['description_ka'],
			],
			'user_id'      => auth()->user()->id,
			'budget'       => $request['budget'],
			'release_date' => $request['release_date'],
			'thumbnail'    => $request['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public'),
		]);

		if (!$movie)
		{
			return response()->json('Something went wrong', 422);
		}

		return response()->json($movie->load('quotes'), 200);
	}

	public function index(): JsonResponse
	{
		$userMovies = Movie::where('user_id', auth()->id())->latest()->get();

		$subset = $userMovies->map(function ($movie) {
			return $movie->only(['id', 'name', 'thumbnail', 'release_date', 'quotes']);
		});

		return response()->json(
			$subset
		);
	}
}
