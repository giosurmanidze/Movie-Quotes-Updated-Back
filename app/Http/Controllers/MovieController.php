<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddMoviesRequest;
use App\Http\Requests\EditMoviesRequest;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;

class MovieController extends Controller
{
	public function store(AddMoviesRequest $storedRequest): JsonResponse
	{
		$request = $storedRequest->validated();
		$user = auth()->user();

		$movie = Movie::create([
			'name' => [
				'en' => $request['name_en'],
				'ka' => $request['name_ka'],
			],
			'director' => [
				'en' => $request['director_en'],
				'ka' => $request['director_ka'],
			],
			'description' => [
				'en' => $request['description_en'],
				'ka' => $request['description_ka'],
			],
			'release_date' => $request['release_date'],
			'budget'       => $request['budget'],
			'thumbnail'    => $storedRequest->file('thumbnail')->store('thumbnails'),
			'user_id'      => $user->id,
		]);

		$genresIds = array_map('intval', $request['genre']);

		$movie->genres()->attach($genresIds);
		return response()->json($movie, 201);
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

	public function getMovie($id): JsonResponse
	{
		$movie = Movie::where('id', $id)->with('quotes')->first();
		if (auth()->user()->id !== $movie->user_id) {
			return response()->json('page is forbidden', 404);
		}

		return response()->json([$movie, $movie->genres]);
	}

	public function update(EditMoviesRequest $request, $id): JsonResponse
	{
		$movie = Movie::findOrFail($id);

		$attributes = [
			'name' => [
				'en' => $request['name_en'],
				'ka' => $request['name_ka'],
			],
			'director' => [
				'en' => $request['director_en'],
				'ka' => $request['director_ka'],
			],
			'description' => [
				'en' => $request['description_en'],
				'ka' => $request['description_ka'],
			],
			'release_date' => $request['release_date'],
			'budget'       => $request['budget'],
		];

		if (isset($request['thumbnail'])) {
			$attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');
		}

		$genresIds = array_map('intval', $request['genre']);

		$movie->genres()->sync($genresIds);
		$movie->update($attributes);

		return response()->json($movie);
	}

}
