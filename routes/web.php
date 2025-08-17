<?php

use App\Http\Controllers\PsychologistController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('home/index');
})->name('home');

Route::get('/cari-psikolog', [PsychologistController::class, 'index'])
    ->name('psychologist.find');

Route::get('/psikolog/{id}', [PsychologistController::class, 'show'])
    ->name('psychologist.detail');

Route::get('/psikolog-terbaik', function () {
    return Inertia::render('psychologist/best/index');
})->name('psychologist.best');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
