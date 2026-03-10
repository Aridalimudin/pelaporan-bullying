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

Route::get('/contact', function () {
    return view('pages.user.contact-page.contact');
})->name('lapor.contact');

//ADMINISTRATOR 

Route::get('/login', function () {
    return view('pages.administrator.login-page.login');
})->name('administrator.login');

//DASHBOARD

Route::get('/dashboard', function () {
    return view('pages.administrator.dashboard-page.dashboard');
})->name('administrator.dashboard');

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

Route::get('/laporan-ditolak', function () {
    return view('pages.administrator.report-management-page.report-rejected');
})->name('administrator.report-rejected');

//MASTER DATA

Route::get('/data-siswa', function () {
    return view('pages.administrator.master-data-page.students');
})->name('administrator.students');

Route::get('/jenis-pelanggaran', function () {
    return view('pages.administrator.master-data-page.case');
})->name('administrator.case');

Route::get('/tindakan-disiplin', function () {
    return view('pages.administrator.master-data-page.disciplinary');
})->name('administrator.disciplinary');

//USER MANAGEMENT

Route::get('/daftar-users', function () {
    return view('pages.administrator.user-management-page.users');
})->name('administrator.users');

Route::get('/daftar-roles', function () {
    return view('pages.administrator.user-management-page.roles');
})->name('administrator.roles');

Route::get('/daftar-permissions', function () {
    return view('pages.administrator.user-management-page.permissions');
})->name('administrator.permissions');

//CASE RECAPITULATION

Route::get('/rekapitulasi-PerBulan', function () {
    return view('pages.administrator.case-recapitulation-page.monthly');
})->name('administrator.monthly');

Route::get('/rekapitulasi-PerSemester', function () {
    return view('pages.administrator.case-recapitulation-page.semester');
})->name('administrator.semester');