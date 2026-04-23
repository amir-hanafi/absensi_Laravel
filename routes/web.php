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
use App\Http\Controllers\KelasController;
use App\Http\Controllers\GuruMatapelController;
use App\Http\Controllers\JadwalSekolahController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TicketController;

/**
 * =========================
 * GUEST (BELUM LOGIN)
 * =========================
 */
Route::middleware('guest')->group(function () {
    Route::get('/login', fn() => view('auth.login'))->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

/**
 * =========================
 * LOGOUT (HARUS LOGIN)
 * =========================
 */
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


/**
 * =========================
 * SEMUA HARUS LOGIN
 * =========================
 */
Route::middleware('auth')->group(function () {

    /**
     * =========================
     * SEMUA ROLE BOLEH
     * =========================
     */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/points', [PointController::class, 'index'])->name('points.index');
    Route::get('/points/{user}', [PointController::class, 'detail'])->name('points.detail');

    Route::get('/leaderboard', [PointController::class, 'leaderboard'])->name('leaderboard');

    Route::get('/marketplace', [MarketplaceController::class, 'index'])->name('marketplace.index');
    Route::post('/marketplace/buy/{id}', [MarketplaceController::class, 'buy'])->name('marketplace.buy');


    /**
     * =========================
     * KHUSUS GURU (ADMIN DILARANG)
     * =========================
     */
    Route::middleware('role:guru')->group(function () {


        // tetap guru-only? atau mau admin juga?
        Route::get('/penilaian/siswa', [AssessmentController::class, 'daftarSiswa']);
        Route::get('/penilaian/{id}', [AssessmentController::class, 'create']);
        Route::post('/penilaian', [AssessmentController::class, 'store']);
    });

    Route::middleware(['auth', 'role:guru,admin'])->group(function () {
        Route::resource('absensi', AbsensiController::class);
    });


    /**
     * =========================
     * KHUSUS ADMIN
     * =========================
     */
    Route::middleware('role:admin')->group(function () {

        Route::resource('jadwal', JadwalController::class);

        Route::resource('assessment-categories', AssessmentCategoryController::class);

        Route::get('/laporan', [AssessmentController::class, 'indexLaporan']);
        Route::get('/laporan/{siswa}', [AssessmentController::class, 'laporan']);

        Route::resource('point-rules', PointRuleController::class);

        Route::resource('user', UserController::class);

        Route::resource('matapel', MatapelController::class);

        Route::resource('places', PlaceController::class);

        Route::resource('kelas', KelasController::class);

        Route::resource('jadwal-sekolah', JadwalSekolahController::class);

        Route::resource('guru-matapel', GuruMatapelController::class);

        Route::get('/get-guru-by-matapel/{id}', [JadwalController::class, 'getGuruByMatapel']);

        Route::get('/get-guru-available', [JadwalController::class, 'getGuruAvailable']);

        Route::get('/get-kelas-by-tingkat', [SiswaController::class, 'getKelasByTingkat']);
    });
});


Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::resource('tickets', TicketController::class);

    Route::post('/tickets/{id}/response', [TicketController::class, 'storeResponse'])
        ->name('tickets.response.store');

    Route::post('/tickets/{id}/close', [TicketController::class, 'close'])
        ->name('tickets.close');

    Route::post('/tickets/{id}/rating', [TicketController::class, 'storeRating'])
    ->name('tickets.rating.store');

    Route::get('/dashboard/helpdesk', [DashboardController::class, 'helpdesk'])
    ->name('dashboard.helpdesk')
    ->middleware('role:admin');
});

Route::middleware(['auth', 'role:siswa'])->group(function () {

    Route::get('/my-tickets', [TicketController::class, 'myTickets'])->name('tickets.my');

    Route::get('/my-tickets/create', [TicketController::class, 'create'])->name('tickets.create');

    Route::post('/my-tickets', [TicketController::class, 'store'])->name('tickets.store');

    
});


