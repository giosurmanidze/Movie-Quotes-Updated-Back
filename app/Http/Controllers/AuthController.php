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
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;

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

	public function login(LoginRequest $request)
{
	$validated = $request->validated();

	$username = $validated['name'];
	$password = $validated['password'];


	if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
		$user = User::where('email', $username)->first();
	} else {
		$user = User::where('name', $username)->first();
	}

    if ($user && Hash::check($password, $user->password)) {
        if ($user->hasVerifiedEmail()) {
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Email not verified'], 401);
        }
    }

    return response()->json(['error' => 'Invalid credentials'], 401);
}
}
