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
		return response()->json(['msg' => 'success registered!']);
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

		$credentials = [
			'password' => $password,
		];

		if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
			$credentials['email'] = $username;
		} else {
			$credentials['username'] = $username;
		}

		return Auth::guard('web')->attempt($credentials)
			? (auth()->user()->email_verified_at
				? response()->json('success!')
				: (auth()->logout() && response()->json([
					'error' => trans('email_not_verified'),
				], 401)))
			: response()->json([
				'error'    => trans('user_password_incorrect'),
				'username' => trans('is_incorrect_input'),
			], 401);
	}

	public function getUser(Request $request)
	{
		return $request->user();
	}

	public function logout(Request $request)
	{
		$request->session()->invalidate();
		$request->session()->regenerateToken();
		Auth::guard('web')->logout();

		return response()->json(['message' => 'You are logged out']);
	}
}
