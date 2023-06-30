<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddNewEmailRequest;
use App\Http\Requests\StoreProfileAvatarRequest;
use App\Http\Requests\UpdateNameRequest;
use App\Http\Requests\UpdateUserPassowrdRequest;
use App\Models\User;
use App\Mail\UpdateEmailVerifyMail;
use App\Models\Email;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

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

	public function updatePassowrd(UpdateUserPassowrdRequest $request)
	{
		$user = User::find(auth()->id());
		$user->forceFill([
			'password' => $request->password,
		]);
		$user->save();
		return response()->json(['message' => 'Password updated successfully'], 200);
	}

	public function addEmail(AddNewEmailRequest $request): JsonResponse
	{
		$email = Email::create($request->validated());
		$user = User::find($request->user_id);
		// $confirmationLink = url(env('FRONT_BASE_URL') . '/user-profile/' . $user->id);
		Mail::to($email)->send(new UpdateEmailVerifyMail($user));

		return response()->json(['message' => 'Email created successfully!']);
	}

	public function confirmEmail(User $user): JsonResponse
	{
		$user->email_verified_at = now();
		$latestEmail = $user->emails()->latest()->first();

		if ($latestEmail) {
			$user->email = $latestEmail->email;
			$user->save();

			$latestEmail->delete();
		}

		return response()->json(['message' => 'Email verified successfully!']);
	}
}
