<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
	public function register(RegisterRequest $request): JsonResponse
	{
		$user = User::create($request->validated());
		event(new Registered($user));

		$token = $user->createToken('auth_token')->plainTextToken;

		return response()->json(['token' => $token], 201);
	}

	public function verify(Request $request): RedirectResponse
	{
		$user = User::findOrFail($request->route('id'));

		if (!$user->hasVerifiedEmail()) {
			if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
				throw new AuthorizationException();
			}

			$user->markEmailAsVerified();
			event(new Verified($user));
		}

		return redirect(env('FRONT_BASE_URL') . '/success');
	}

	public function login(LoginRequest $request): JsonResponse
	{
		$credentials = $request->validated();
	
		if (!Auth::attempt($credentials)) {
			return response()->json(['message' => 'Invalid credentials'], 401);
		}
	
		$user = User::where('email', $request->email)->firstOrFail();
		$token = $user->createToken('auth_token')->plainTextToken;
	
		return response()->json(['token' => $token], 200);
	}
}
