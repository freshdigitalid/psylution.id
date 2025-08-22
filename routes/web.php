<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PsychologistController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [Controller::class, 'home'])
    ->name('home');

Route::get('/cari-psikolog', [PsychologistController::class, 'index'])
    ->name('psychologist.find');

Route::get('/psikolog/{id}', [PsychologistController::class, 'show'])
    ->name('psychologist.detail');

Route::get('/booking/{psychologist_id}', [AppointmentController::class, 'index'])
    ->name('psychologist.book');

Route::get('/psikolog-terbaik', function () {
    return Inertia::render('psychologist/best/index');
})->name('psychologist.best');


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [Controller::class, 'dashboard'])
        ->name('dashboard');

    Route::get('/profile', [Controller::class, 'profile'])
        ->name('profile');

    Route::middleware('role:patient')->group(function () {
        Route::post('/booking', [AppointmentController::class, 'book'])
            ->name('appointment.book');
    });
});

require __DIR__ . '/auth.php';
