<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddNewEmailRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Mail\UpdateEmailVerifyMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
	public function update(UpdateUserRequest $request): JsonResponse
	{
		$attributes = [];

		if (isset($request['username'])) {
			$attributes['username'] = $request['username'];
		}

		if ($request->hasFile('thumbnail')) {
			if (auth()->user()->profile_picture) {
				Storage::delete(auth()->user()->profile_picture);
			}
			$attributes['profile_picture'] = $request->file('thumbnail')->store('thumbnails');
		}

		if (isset($request['password'])) {
			$attributes['password'] = $request['password'];
		}

		auth()->user()->fill($attributes);
		auth()->user()->save();

		return response()->json('success');
	}

	public function addEmail(AddNewEmailRequest $request): JsonResponse
	{
		$user = User::find(auth()->id());
		Mail::to($request->email)->send(new UpdateEmailVerifyMail($user, $request->email));

		return response()->json(['message' => 'Email created successfully!']);
	}

	public function confirmEmail(Request $request, User $user): JsonResponse
	{
		$user->email_verified_at = now();
		$user->email = $request->email;
		$user->save();

		return response()->json(['message' => 'Email verified successfully!']);
	}
}
