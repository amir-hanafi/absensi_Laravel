<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\QrController;


Route::post('/login', [AuthController::class, 'apiLogin']);
Route::post('/logout', [AuthController::class, 'apiLogout']);


// generate QR untuk jadwal
// Route::post('/generate-qr/{jadwal}', [QrController::class, 'generate']);
Route::get('/qr-token/{jadwal}', [QrController::class, 'getToken']);

// scan QR (validasi token)
Route::post('/scan-qr', [AttendanceController::class, 'scanQr']);
