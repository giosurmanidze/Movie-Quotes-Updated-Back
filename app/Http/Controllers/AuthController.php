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

		$user = User::where(function ($query) use ($username) {
			$query->where('email', $username)->orWhere('username', $username);
		})->first();

		if (!$user || !$user->email_verified_at || !password_verify($password, $user->password)) {
			return back()->withInput($request->only('username'))->withErrors([
				'password' => trans('user_password_incorrect'),
				'username' => trans('is_incorrect_input'),
			]);
		}
		Auth::guard('web')->attempt(['username' => $username, 'password' => $password]);

		session()->regenerate();
		return response()->json('success!');
	}

	public function getUser(Request $request)
	{
		return $request->user();
	}
}
