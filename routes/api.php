<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\QrController;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::post('/login', [AuthController::class, 'apiLogin']);
Route::post('/logout', [AuthController::class, 'apiLogout']);

/*
|--------------------------------------------------------------------------
| QR CODE
|--------------------------------------------------------------------------
*/

// generate QR untuk jadwal
Route::post('/generate-qr/{jadwal}', [QrController::class, 'generate']);

// scan QR (validasi token)
Route::post('/scan-qr', [AttendanceController::class, 'scanQr']);

/*
|--------------------------------------------------------------------------
| ATTENDANCE
|--------------------------------------------------------------------------
*/