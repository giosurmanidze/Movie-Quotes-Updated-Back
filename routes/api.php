<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', [AuthController::class, 'getUser']);

Route::controller(AuthController::class)->group(function () {
	Route::post('register', 'register')->name('register');
	Route::post('login', 'login')->name('login');
	Route::get('/email/verify/{id}/{hash}', 'verify')->name('verification.verify');
	Route::post('logout', 'logout')->name('logout');
});

Route::controller(PasswordResetController::class)->group(function () {
	Route::post('/forgot-password', 'forgotPassword')->name('password.email');
	Route::post('/reset-password', 'passwordUpdate')->name('password.reset');
});

Route::controller(QuoteController::class)->group(function () {
	Route::post('quotes', 'store')->name('quotes.store');
	Route::get('quotes', 'index')->name('quotes.index');
	Route::get('quotes/{quote}', 'show')->name('quotes.get');
	Route::post('quotes/{quote}', 'update')->name('quotes.update');
	Route::delete('quotes/{quote}', 'destroy')->name('quotes.destroy');
});

Route::get('genres', [GenreController::class, 'index'])->name('view.genre');
Route::post('comments', [CommentController::class, 'store'])->name('comments.store');

Route::controller(MovieController::class)->group(function () {
	Route::post('movies', 'store')->name('movies.store');
	Route::get('movies', 'index')->name('movies.index');
	Route::get('movies/{movie}', 'show')->name('movies.get');
	Route::post('movies/{movie}', 'update')->name('movies.update');
	Route::delete('movies/{movie}', 'destroy')->name('movies.destroy');
});
Route::middleware(['web'])->group(function () {
	Route::get('/auth/google/redirect', [GoogleLoginController::class, 'redirect']);
	Route::get('/auth/google/callback', [GoogleLoginController::class, 'callback']);
});
