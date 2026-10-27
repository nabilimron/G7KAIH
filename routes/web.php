<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('admin.dashboard');
});

// Kelola Akun & Pengguna
Route::get('/akun', function () {
    return view('admin.akun');
});

// Atur Perwalian
Route::get('/perwalian', function () {
    return view('admin.perwalian');
});

Route::get('/badge', function () {
    return view('admin.badge');
});

Route::get('/laporan', function () {
    return view('admin.laporan');
});

Route::get('/pengaturan', function () {
    return view('admin.pengaturan');
});

