<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Models\Kebiasaan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

// Public landing reads kebiasaan directly from db_g7kaih.
$renderHome = function () {
    $kebiasaan = Schema::hasTable('kebiasaan')
        ? Kebiasaan::orderBy('id_kebiasaan')->get()
        : collect();
    return view('home', compact('kebiasaan'));
};

Route::get('/', $renderHome)->name('home');
Route::get('/home', $renderHome);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login.post');
Route::get('/lupa-sandi', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/lupa-sandi', [AuthController::class, 'submitForgotPassword'])->name('password.request.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:siswa'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {
        Route::get('/', [StudentController::class, 'dashboard'])->name('dashboard');
        Route::get('/laporan', [StudentController::class, 'createLaporan'])->name('laporan');
        Route::post('/laporan', [StudentController::class, 'storeLaporan'])->name('laporan.store');
        Route::get('/riwayat', [StudentController::class, 'riwayat'])->name('riwayat');
        Route::get('/detail-riwayat/{laporan}', [StudentController::class, 'detailRiwayat'])->name('riwayat.detail');
        Route::get('/lencana', [StudentController::class, 'lencana'])->name('lencana');
        Route::get('/profil', [StudentController::class, 'profil'])->name('profil');
        Route::put('/profil', [StudentController::class, 'updateProfil'])->name('profil.update');
        Route::put('/profil/password', [StudentController::class, 'updatePassword'])->name('profil.password');
    });

Route::middleware(['auth', 'role:guru_wali'])
    ->prefix('teacher')
    ->name('teacher.')
    ->group(function () {
        Route::get('/', [TeacherController::class, 'dashboard'])->name('dashboard');
        Route::get('/verifikasi', [TeacherController::class, 'verifikasi'])->name('verifikasi');
        Route::get('/detail-laporan/{laporan}', [TeacherController::class, 'detailLaporan'])->name('detail-laporan');
        Route::post('/verifikasi/{laporan}', [TeacherController::class, 'verifyLaporan'])->name('verify');
        Route::get('/detail-siswa/{siswa}', [TeacherController::class, 'detailSiswa'])->name('detail-siswa');
        Route::get('/rekapitulasi', [TeacherController::class, 'rekapitulasi'])->name('rekapitulasi');
        Route::get('/profil', [TeacherController::class, 'profil'])->name('profil');
        Route::put('/profil', [TeacherController::class, 'updateProfil'])->name('profil.update');
    });

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::post('/akun/reset-password', [AkunController::class, 'resetPassword'])->name('akun.reset-password');
    Route::resource('akun', AkunController::class)->except(['show']);
    Route::get('/perwalian', [AdminController::class, 'perwalian'])->name('admin.perwalian');
    Route::put('/perwalian/kelas/{kelas}', [AdminController::class, 'updateKelasPerwalian'])->name('admin.perwalian.kelas');
    Route::put('/perwalian/{siswa}', [AdminController::class, 'updatePerwalian'])->name('admin.perwalian.update');
    Route::get('/badge', [AdminController::class, 'badge'])->name('admin.badge');
    Route::post('/badge', [AdminController::class, 'storeBadge'])->name('admin.badge.store');
    Route::put('/badge/{badge}', [AdminController::class, 'updateBadge'])->name('admin.badge.update');
    Route::delete('/badge/{badge}', [AdminController::class, 'destroyBadge'])->name('admin.badge.destroy');
    Route::get('/laporan', [AdminController::class, 'laporan'])->name('admin.laporan');
    Route::get('/pengaturan', [AdminController::class, 'pengaturan'])->name('admin.pengaturan');
    Route::put('/pengaturan', [AdminController::class, 'updatePengaturan'])->name('admin.pengaturan.update');
});
