<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::controller(EmailVerificationController::class)->group(function () {
	Route::post('email/{token}', 'verifyUser')->name('email.verify');
});
Route::controller(AuthController::class)->group(function () {
	Route::post('register', 'register')->name('register');
	Route::post('verify-email', 'sendVerificationEmail')->name('verify_email.send');
});
