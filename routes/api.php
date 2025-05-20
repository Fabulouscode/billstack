<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OTPController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/verify-email', [OTPController::class, 'verifyEmail'])->name('verify.email');
});
