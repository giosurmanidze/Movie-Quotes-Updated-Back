<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

Broadcast::routes();

Route::middleware('auth:sanctum')->group(function () {
	Route::get('/user', [AuthController::class, 'getUser'])->name('getUsers');

	Route::controller(QuoteController::class)->group(function () {
		Route::post('quotes', 'store')->name('quotes.store');
		Route::get('quotes', 'index')->name('quotes.index');
		Route::get('quotes/{quote}', 'show')->name('quotes.get');
		Route::post('quotes/{quote}', 'update')->name('quotes.update');
		Route::post('quotes-refresh', 'index')->name('quotes.refresh');
		Route::delete('quotes/{quote}', 'destroy')->name('quotes.destroy');
		Route::get('quote-search', 'searchPost')->name('quote.search');
	});

	Route::controller(MovieController::class)->group(function () {
		Route::post('movies', 'store')->name('movies.store');
		Route::get('movies', 'index')->name('movies.index');
		Route::get('movies/{movie}', 'show')->name('movies.get');
		Route::post('movies/{movie}', 'update')->name('movies.update');
		Route::delete('movies/{movie}', 'destroy')->name('movies.destroy');
	});

	Route::controller(UserController::class)->group(function () {
		Route::post('user/update', 'update')->name('update.user');
		Route::post('user/add-email', 'addEmail')->name('email.add');
		Route::post('confirm-account/{user}', 'confirmEmail')->name('confirm-account');
	});

	Route::get('genres', [GenreController::class, 'index'])->name('view.genre');
	Route::post('comments', [CommentController::class, 'store'])->name('comments.store');

	Route::post('likes', [LikeController::class, 'store'])->name('like.store');
	Route::delete('likes/{like}', [LikeController::class, 'destroy'])->name('like.destroy');

	Route::controller(NotificationController::class)->group(function () {
		Route::get('get-notifications', 'index')->name('notifications.index');
		Route::post('mark-read', 'markAsRead')->name('notification.mark');
	});
});

Route::controller(AuthController::class)->group(function () {
	Route::post('register', 'register')->name('register');
	Route::post('login', 'login')->name('login');
	Route::post('email/verify', 'verify')->name('verification.verify');
	Route::post('logout', 'logout')->name('logout');
});

Route::controller(PasswordResetController::class)->group(function () {
	Route::post('/forgot-password', 'forgotPassword')->name('password.email');
	Route::post('/reset-password', 'passwordUpdate')->name('password.reset');
});
Route::middleware(['web'])->group(function () {
	Route::get('/auth/google/redirect', [GoogleLoginController::class, 'redirect']);
	Route::get('/auth/google/callback', [GoogleLoginController::class, 'callback']);
});
