<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.welcome');
})->name('home');

Route::get('/lapor', function () {
    return view('pages.lapor');
})->name('lapor.index');

Route::get('/lacak', function () {
    return view('pages.lacak');
})->name('lapor.lacak');