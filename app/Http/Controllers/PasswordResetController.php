<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
	public function showResetForm(Request $request, $token = null): View
	{
		return view('auth.reset-password', ['request' => $request, 'token' => $token]);
	}

	public function reset(ResetPasswordRequest $request): RedirectResponse
	{
		$validatedData = $request->validated();

		$credentials = [
			'token'                 => $validatedData['token'],
			'email'                 => $validatedData['email'],
			'password'              => $validatedData['password'],
			'password_confirmation' => $validatedData['password_confirmation'],
		];

		$response = Password::broker()->reset(
			$credentials,
			function ($user, $password) {
				$user->forceFill([
					'password' => Hash::make($password),
				])->save();
			}
		);

		if ($response === Password::PASSWORD_RESET) {
			return redirect(env('FRONT_BASE_URL') . '/login')->with('status', trans('passwords.reset'));
		} else {
			return back()->withErrors(['email' => [trans($response)]]);
		}
	}
}
