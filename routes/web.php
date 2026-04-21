<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\AssessmentCategoryController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\PointRuleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MatapelController;
use App\Http\Controllers\PlaceController;

/**
 * @file routes/web.php
 * @brief Mendefinisikan route web aplikasi Laravel
 *
 * Route di sini meliputi autentikasi, dashboard, jadwal, kategori penilaian, dan laporan penilaian siswa.
 */

/** 
 * @brief Route untuk guest (belum login)
 */
Route::middleware('guest')->group(function () {
    /** @brief Menampilkan halaman login */
    Route::get('/login', fn() => view('auth.login'))->name('login');

    /** @brief Menangani proses login */
    Route::post('/login', [AuthController::class, 'login']);
});

/**
 * @brief Route untuk user yang sudah login (auth)
 * @note Bagian role admin dikomentari, bisa diaktifkan jika ingin membatasi akses admin
 */
// Route::middleware(['auth', 'role:admin'])->group(function () {
//     /** @brief Dashboard admin */
//     Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
//     /** @brief Logout user */
//     Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// });



/** @brief Route untuk logout */
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/** @brief Resource route untuk CRUD Jadwal */
Route::resource('jadwal', JadwalController::class);

/** @brief Resource route untuk CRUD Kategori Penilaian */
Route::resource('assessment-categories', AssessmentCategoryController::class);

/** @brief Route menampilkan daftar siswa untuk penilaian */
Route::get('/penilaian/siswa', [AssessmentController::class, 'daftarSiswa']);

/** @brief Route menampilkan form penilaian untuk siswa tertentu */
Route::get('/penilaian/{id}', [AssessmentController::class, 'create']);

/** @brief Route untuk menyimpan hasil penilaian */
Route::post('/penilaian', [AssessmentController::class, 'store']);

/** @brief Route menampilkan daftar laporan penilaian */
Route::get('/laporan', [AssessmentController::class,'indexLaporan']);

/** @brief Route menampilkan laporan penilaian untuk siswa tertentu */
Route::get('/laporan/{siswa}', [AssessmentController::class,'laporan']);


/** @brief Route CRUD absensi */
Route::resource('absensi', AbsensiController::class);

/** @brief Route dashboard umum */
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/points', [PointController::class, 'index'])->name('points.index');

Route::get('/marketplace', [MarketplaceController::class, 'index'])->name('marketplace.index');
Route::post('/marketplace/buy/{id}', [MarketplaceController::class, 'buy'])->name('marketplace.buy');

Route::get('/points/{user}', [PointController::class, 'detail'])->name('points.detail');

Route::resource('point-rules', PointRuleController::class);

Route::get('/leaderboard', [PointController::class, 'leaderboard'])->name('leaderboard');

Route::resource('user', App\Http\Controllers\UserController::class);

Route::resource('matapel', App\Http\Controllers\MatapelController::class);

Route::resource('places', App\Http\Controllers\PlaceController::class);