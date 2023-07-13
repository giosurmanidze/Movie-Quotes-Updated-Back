<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddMoviesRequest;
use App\Http\Requests\EditMoviesRequest;
use App\Http\Requests\ShowMovieRequest;
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
		$movie->load('quotes', 'genres');
		return response()->json($movie);
	}

	public function index(): JsonResponse
	{
		$movie = MovieResource::collection(auth()->user()->movies->sortByDesc('created_at'));
		return response()->json($movie, 200);
	}

	public function show(ShowMovieRequest $request, Movie $movie): JsonResponse
	{
		return response()->json(MovieResource::make($movie), 200);
	}

	public function update(EditMoviesRequest $request, Movie $movie): JsonResponse
	{
		$attributes = [
			'name'         => [
				'en' => $request['name_en'],
				'ka' => $request['name_ka'],
			],
			'director'     => [
				'en' => $request['director_en'],
				'ka' => $request['director_ka'],
			],
			'description'  => [
				'en' => $request['description_en'],
				'ka' => $request['description_ka'],
			],
			'release_date' => $request['release_date'],
			'budget'       => $request['budget'],
		];

		if ($request->hasFile('thumbnail')) {
			$attributes['thumbnail'] = $request->file('thumbnail')->store('thumbnails');
		}

		$genresIds = json_decode($request['genre'], true);

		$movie->genres()->sync($genresIds);
		$movie->update($attributes);
		$movie->load('quotes', 'genres');
		return response()->json($movie);
	}

	public function destroy(Movie $movie)
	{
		$movie->delete();
		return response()->json('Movie deleted successfully');
	}
}
