<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Admin routes
Route::prefix('admin')->group(function () {
    require __DIR__.'/admin.php';
});

// Psikolog routes
Route::prefix('psikolog')->group(function () {
    require __DIR__.'/psikolog.php';
});

// Pasien routes
Route::prefix('pasien')->group(function () {
    require __DIR__.'/pasien.php';
});
