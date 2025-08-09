<?php

use App\Http\Controllers\Auth\PsikologAuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:psikolog')->group(function () {
    Route::get('login', [PsikologAuthController::class, 'showLoginForm'])->name('psikolog.login');
    Route::post('login', [PsikologAuthController::class, 'login']);
    Route::get('register', [PsikologAuthController::class, 'showRegistrationForm'])->name('psikolog.register');
    Route::post('register', [PsikologAuthController::class, 'register']);
});

Route::middleware('psikolog')->group(function () {
    Route::get('dashboard', [PsikologAuthController::class, 'dashboard'])->name('psikolog.dashboard');
    Route::post('logout', [PsikologAuthController::class, 'logout'])->name('psikolog.logout');
}); 