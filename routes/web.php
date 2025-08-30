<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\OtpController;

Route::get('/', function () {
    return Inertia::render('home/index');
})->name('home');

Route::get('/about', function () {
    return Inertia::render('about/index');
})->name('about');

Route::get('/cari-psikolog', function () {
    return Inertia::render('psychologist/find/index');
})->name('psychologist.find');

Route::get('/psikolog', function () {
    return Inertia::render('psychologist/detail/index');
})->name('psychologist.detail');

Route::get('/psikolog-terbaik', function () {
    return Inertia::render('psychologist/best/index');
})->name('psychologist.best');

Route::get('/layanan-konseling', [ServiceController::class, 'index'])->name('services');

Route::get('/booking', function () {
    return Inertia::render('booking/index');
})->name('booking');

Route::get('/payment/success', function () {
    return Inertia::render('payment/success');
})->name('payment.success');

Route::get('/examples/alerts', function () {
    return Inertia::render('examples/alerts');
})->name('examples.alerts');

// OTP Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/otp/verify', [OtpController::class, 'showVerificationForm'])->name('otp.verify.form');
    Route::post('/otp/verify', [OtpController::class, 'verify'])->name('otp.verify');
    Route::post('/otp/resend', [OtpController::class, 'resend'])->name('otp.resend');
});

// Profile route for authenticated users
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
