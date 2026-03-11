<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\AssessmentCategoryController;
use App\Http\Controllers\AssessmentController;

// Guest only (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', fn() => view('auth.login'))->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Auth + Admin only
// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
//     Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// });

Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::resource('jadwal', JadwalController::class);

Route::resource('assessment-categories', AssessmentCategoryController::class);

Route::get('/penilaian/siswa', [AssessmentController::class, 'daftarSiswa']);

Route::get('/penilaian/{id}', [AssessmentController::class, 'create']);
Route::post('/penilaian', [AssessmentController::class, 'store']);


Route::get('/laporan', [AssessmentController::class,'indexLaporan']);
Route::get('/laporan/{siswa}', [AssessmentController::class,'laporan']);

