<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', [AuthController::class, 'getUser']);

Route::controller(AuthController::class)->group(function () {
	Route::post('register', 'register')->name('register');
	Route::post('login', 'login')->name('login');
	Route::get('/email/verify/{id}/{hash}', 'verify')->name('verification.verify');
});
