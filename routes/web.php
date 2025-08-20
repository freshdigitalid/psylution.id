<?php

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


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [Controller::class, 'dashboard'])
        ->name('dashboard');

    Route::get('/profile', [Controller::class, 'profile'])
        ->name('profile');

    Route::middleware('role:admin')->group(function () {
        Route::get('/psikolog-terbaik', function () {
            return Inertia::render('psychologist/best/index');
        })->name('psychologist.best');
    });
});

require __DIR__ . '/auth.php';
