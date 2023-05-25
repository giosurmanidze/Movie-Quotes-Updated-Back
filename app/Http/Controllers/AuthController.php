<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailVerification\SendEmailVerificationRequest;
use App\Http\Requests\RegisterRequest;
use App\Mail\VerifyEmail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
	public function register(RegisterRequest $request): JsonResponse
	{
		$validatedData = $request->validated();
		unset($validatedData['password_confirmation']);

		$user = User::create($validatedData);
		$token = $user->createToken('token-name')->plainTextToken;

		Mail::to($user->email)->send(new VerifyEmail($user));

		return response()->json('user created successfully', 200);
	}

	public function sendVerificationEmail(SendEmailVerificationRequest  $request): JsonResponse
	{
		$user = User::where('email', $request['email'])->first();

		if (!$user) {
			return response()->json(['error' => 'User does not exist !'], 401);
		}

		Mail::to($user->email)->send(new VerifyEmail($user));

		return response()->json('email sent');
	}
}
