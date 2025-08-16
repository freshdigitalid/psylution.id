<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('home/index');
})->name('home');

Route::get('/cari-psikolog', function () {
    return Inertia::render('find-psychologist/index');
})->name('find-psychologist');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
