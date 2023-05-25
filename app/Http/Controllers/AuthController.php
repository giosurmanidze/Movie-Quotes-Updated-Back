<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Mail\ConfirmationEmail;
use App\Models\User;
use Illuminate\Contracts\View\View;
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

		$confirmationLink = url('/confirm-email/' . $user->id);
		Mail::to($user->email)->send(new ConfirmationEmail($user, $confirmationLink));

		return response()->json(['token' => $token], 201);
	}

	public function confirmEmail(User $user): View
	{
		$user->email_verified_at = now();
		$user->save();

		return view('email.activated-account');
	}
}
