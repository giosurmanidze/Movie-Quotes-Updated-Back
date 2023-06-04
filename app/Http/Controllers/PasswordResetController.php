<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;

class PasswordResetController extends Controller
{
	public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
	{
		$status = Password::sendResetLink($request->only('email'));
		$response = $status === Password::RESET_LINK_SENT ? 'Password reset email sent!' : __($status);
		return response()->json(['message' => $response], $status === Password::RESET_LINK_SENT ? 200 : 404);
	}

	public function passwordUpdate(UpdatePasswordRequest $request): JsonResponse
	{
		$status = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function ($user, $password) {
			$user->forceFill(['password' => $password]);
			$user->save();
			event(new PasswordReset($user));
		});

		$response = $status === Password::PASSWORD_RESET ? 'Password updated successfully !' : __($status);
		return response()->json(['message' => $response], $status === Password::PASSWORD_RESET ? 200 : 404);
	}
}
