<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileAvatarRequest;
use App\Http\Requests\UpdateNameRequest;
use App\Http\Requests\UpdatePassowrdRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
	public function updateName(UpdateNameRequest $request): JsonResponse
	{
		$user = User::find(auth()->id());
		$user->update(['username' => $request->username]);
		return response()->json(['message' => 'User updated successfully'], 200);
	}

	public function storeProfileAvatar(StoreProfileAvatarRequest $request): JsonResponse
	{
		$user = User::find(auth()->id());
		$path = $request->file('thumbnail')->store('thumbnails');
		$user->profile_picture = $path;
		$user->save();
		return response()->json(['message' => 'Profile picture set successfully'], 201);
	}

	public function updatePassowrd(UpdatePassowrdRequest $request)
	{
		$user = User::find(auth()->id());
		$user->forceFill([
			'password' => $request->password,
		]);
		$user->save();
		return response()->json(['message' => 'Password updated successfully'], 200);
	}
}
