<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return Inertia::render('home/index');
})->name('home');

Route::get('/cari-psikolog', function () {
    return Inertia::render('psychologist/find/index');
})->name('psychologist.find');

Route::get('/psikolog', function () {
    return Inertia::render('psychologist/detail/index');
})->name('psychologist.detail');

Route::get('/psikolog-terbaik', function () {
    return Inertia::render('psychologist/best/index');
})->name('psychologist.best');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
