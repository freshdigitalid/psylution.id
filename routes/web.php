<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PsychologistController;
use App\Http\Controllers\TestimoniController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [Controller::class, 'home'])
    ->name('home');

Route::get('/tentang', [Controller::class, 'about'])
    ->name('about');

Route::get('/layanan-konseling', [Controller::class, 'service'])
    ->name('services');

Route::get('/cari-psikolog', [PsychologistController::class, 'index'])
    ->name('psychologist.find');

Route::get('/psikolog/{id}', [PsychologistController::class, 'show'])
    ->name('psychologist.detail');

Route::get('/psikolog-terbaik', function () {
    return Inertia::render('psychologist/best/index');
})->name('psychologist.best');

Route::get('/testimoni', [TestimoniController::class, 'index'])
    ->name('testimoni');

Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', [Controller::class, 'dashboard'])
        ->name('dashboard');

    Route::get('/profile', [Controller::class, 'profile'])
        ->name('profile');
    
    Route::post('/profile/avatar', [Controller::class, 'updateAvatar'])
        ->name('profile.avatar');
    
    Route::put('/profile', [Controller::class, 'updateProfile'])
        ->name('profile.update');

    Route::middleware('role:patient')->group(function () {

        Route::get('/booking/{psychologist_id}', [AppointmentController::class, 'index'])
            ->name('psychologist.book');

        Route::post('/booking', [AppointmentController::class, 'book'])
            ->name('appointment.book');
    });
});

require __DIR__ . '/auth.php';
