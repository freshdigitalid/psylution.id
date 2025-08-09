<?php

use App\Http\Controllers\Auth\PasienAuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:pasien')->group(function () {
    Route::get('login', [PasienAuthController::class, 'showLoginForm'])->name('pasien.login');
    Route::post('login', [PasienAuthController::class, 'login']);
    Route::get('register', [PasienAuthController::class, 'showRegistrationForm'])->name('pasien.register');
    Route::post('register', [PasienAuthController::class, 'register']);
});

Route::middleware('pasien')->group(function () {
    Route::get('dashboard', [PasienAuthController::class, 'dashboard'])->name('pasien.dashboard');
    Route::post('logout', [PasienAuthController::class, 'logout'])->name('pasien.logout');
}); 