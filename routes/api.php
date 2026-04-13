<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\MarketplaceController;

/**
 * @file routes/api.php
 * @brief Mendefinisikan route API untuk autentikasi, QR absensi, dan jadwal
 */

/** 
 * @brief Endpoint login API
 * @route POST /login
 * @param identifier Username / NIS / Kode Guru
 * @param password Password user
 * @return JSON token jika berhasil login
 */
Route::post('/login', [AuthController::class, 'apiLogin']);

/**
 * @brief Endpoint logout API
 * @route POST /logout
 * @middleware auth:sanctum
 * @return JSON status logout
 */
Route::post('/logout', [AuthController::class, 'apiLogout']);

/**
 * @brief Mendapatkan token QR untuk jadwal tertentu
 * @route GET /qr-token/{jadwal}
 * @param jadwal ID jadwal
 * @return JSON token dan expired_at
 */
Route::get('/qr-token/{jadwal}', [QrController::class, 'getToken']);

/**
 * @brief Mendapatkan token QR yang sedang aktif saat ini
 * @route GET /qr-token-current
 * @return JSON token, jadwal_id, dan expired_at
 */
Route::get('/qr-token-current', [QrController::class, 'getCurrentToken']);

/**
 * @brief Group route yang memerlukan autentikasi Sanctum
 */
Route::middleware('auth:sanctum')->group(function () {

    /**
     * @brief Scan QR dan absensi
     * @route POST /scan-qr
     * @param token Token QR
     * @param latitude Latitude pengguna
     * @param longitude Longitude pengguna
     * @return JSON status valid / invalid dan jarak ke tempat
     */
    Route::post('/scan-qr', [AttendanceController::class, 'scanQr']);

});

/**
 * @brief Mendapatkan jadwal pelajaran sekarang
 * @route GET /jadwal-sekarang
 * @middleware auth:sanctum
 * @return JSON info jadwal saat ini (mata pelajaran, jam, tanggal)
 */
Route::middleware('auth:sanctum')->get('/jadwal-sekarang', [JadwalController::class, 'sekarang']);

Route::middleware('auth:sanctum')->get('/marketplace', function () {
    return \App\Models\FlexibilityItem::all();
});

Route::middleware('auth:sanctum')->post('/marketplace/buy/{id}', [MarketplaceController::class, 'buy']);