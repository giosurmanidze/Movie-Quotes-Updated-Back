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
		$check_link_sent_status = $status === Password::RESET_LINK_SENT;

		$response = $check_link_sent_status ? 'Password reset email sent!' : __($status);
		return response()->json(['message' => $response], $check_link_sent_status ? 200 : 404);
	}

	public function passwordUpdate(UpdatePasswordRequest $request): JsonResponse
	{
		$status = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function ($user, $password) {
			$user->forceFill(['password' => $password]);
			$user->save();
			event(new PasswordReset($user));
		});

		$check_password_is_updated = $status === Password::PASSWORD_RESET;

		$response = $check_password_is_updated ? 'Password updated successfully !' : __($status);
		return response()->json(['message' => $response], $check_password_is_updated ? 200 : 404);
	}
}
