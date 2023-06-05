<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller
{
	public function redirect(): RedirectResponse
	{
		return Socialite::driver('google')->redirect();
	}

	public function callback(): RedirectResponse
	{
		$user = Socialite::driver('google')->user();
		$existingUser = User::where('email', $user->email)->first();

		if ($existingUser) {
			Auth::guard('web')->login($existingUser, true);
		} else {
			$newUser = User::create([
				'username'        => $user->name,
				'email'           => $user->email,
				'google_id'       => $user->token,
				'profile_picture' => $user->avatar,
				'password'        => '',
			]);

			Auth::guard('web')->login($newUser, true);
		}

		return redirect(env('FRONT_BASE_URL') . '/news-feed');
	}
}
