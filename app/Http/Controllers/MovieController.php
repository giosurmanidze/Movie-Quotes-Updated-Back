<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddMoviesRequest;
use App\Http\Requests\EditMoviesRequest;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;

class MovieController extends Controller
{
	public function store(AddMoviesRequest $request): JsonResponse
	{
		$storedRequest = $request->validated();
		$user = auth()->user();

		$movie = Movie::create([
			'name' => [
				'en' => $storedRequest['name_en'],
				'ka' => $storedRequest['name_ka'],
			],
			'director' => [
				'en' => $storedRequest['director_en'],
				'ka' => $storedRequest['director_ka'],
			],
			'description' => [
				'en' => $storedRequest['description_en'],
				'ka' => $storedRequest['description_ka'],
			],
			'release_date' => $storedRequest['release_date'],
			'budget'       => $storedRequest['budget'],
			'thumbnail'    => $request->file('thumbnail')->store('thumbnails'),
			'user_id'      => $user->id,
		]);

		$genresIds = json_decode($request['genre'], true);

		$movie->genres()->attach($genresIds);
		return response()->json($movie);
	}

	public function index(): JsonResponse
	{
		$movie = MovieResource::collection(auth()->user()->movies->sortByDesc('created_at'));

		return response()->json($movie, 200);
	}

	public function show(Movie $movie): JsonResponse
	{
		if ($movie->user_id !== auth()->id()) {
			return response()->json(['message' => 'Not Authorized'], 401);
		}

		return response()->json(MovieResource::make($movie), 200);
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
		$genresIds = json_decode($request['genre'], true);

		$movie->genres()->sync($genresIds);
		$movie->update($attributes);
		return response()->json($movie);
	}
}
