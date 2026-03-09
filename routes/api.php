<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\JadwalController;


Route::post('/login', [AuthController::class, 'apiLogin']);
Route::post('/logout', [AuthController::class, 'apiLogout']);

// generate QR untuk jadwal
// Route::post('/generate-qr/{jadwal}', [QrController::class, 'generate']);
Route::get('/qr-token/{jadwal}', [QrController::class, 'getToken']);

Route::get('/qr-token-current', [QrController::class, 'getCurrentToken']);

// scan QR (validasi token)
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/scan-qr', [AttendanceController::class, 'scanQr']);

});

Route::middleware('auth:sanctum')->get('/jadwal-sekarang', [JadwalController::class, 'sekarang']);
