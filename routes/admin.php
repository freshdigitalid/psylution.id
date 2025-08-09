<?php

use App\Http\Controllers\Auth\AdminAuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:admin')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login']);
});

Route::middleware('admin')->group(function () {
    Route::get('dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
}); 