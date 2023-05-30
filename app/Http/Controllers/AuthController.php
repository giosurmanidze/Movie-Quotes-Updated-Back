<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;

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
		$validated = $request->validated();

		$username = $validated['username'];
		$password = $validated['password'];

		if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
			$user = User::where('email', $username)->first();
		} else {
			$user = User::where('username', $username)->first();
		}
		if (!$user) {
			return back()->withInput($request->only('username'))->withErrors(['username' => trans('user_not_found')]);
		}
		if (!$user->email_verified_at || !password_verify($password, $user->password)) {
			return back()->withInput($request->only('username'))->withErrors(['password' => trans('user_password_incorrect')])->withErrors(['username' => trans('is_incorrect_input')]);
		}

		$credentials = [
			'username'    => $user,
			'password'    => $password,
		];

		Auth::guard('web')->attempt($credentials);

		session()->regenerate();

		return response()->json('success!');
	}
}
