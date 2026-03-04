<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.welcome');
})->name('home');

Route::get('/lapor', function () {
    return view('pages.user.report-page.report');
})->name('lapor.index');

Route::get('/lacak', function () {
    return view('pages.user.track-page.track');
})->name('lapor.lacak');

//ADMINISTRATOR

Route::get('/login', function () {
    return view('pages.administrator.login-page.login');
})->name('administrator.login');

//REPORT CENTRAL

Route::get('/laporan-masuk', function () {
    return view('pages.administrator.report-management-page.incoming-report');
})->name('administrator.incoming-report');

Route::get('/menunggu-verifikasi', function () {
    return view('pages.administrator.report-management-page.pending-verification');
})->name('administrator.pending-verification');

Route::get('/proses-laporan', function () {
    return view('pages.administrator.report-management-page.processing-report');
})->name('administrator.processing-report');

Route::get('/laporan-selesai', function () {
    return view('pages.administrator.report-management-page.report-closed');
})->name('administrator.report-closed');
