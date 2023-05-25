<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/confirm-email/{user}', [AuthController::class, 'confirmEmail'])->name('confirm.email');
