<?php
use App\Http\Controllers\AkunController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', fn () => view('admin.dashboard'));
Route::resource('akun', AkunController::class)->except(['show']);
Route::get('/perwalian', fn () => view('admin.perwalian'));
Route::get('/badge', fn () => view('admin.badge'));
Route::get('/laporan', fn () => view('admin.laporan'));
Route::get('/pengaturan', fn () => view('admin.pengaturan'));
