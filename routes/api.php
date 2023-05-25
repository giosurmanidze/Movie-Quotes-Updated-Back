<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::controller(EmailVerificationController::class)->group(function () {
	Route::post('email/{token}', 'verifyUser')->name('email.verify');
});
