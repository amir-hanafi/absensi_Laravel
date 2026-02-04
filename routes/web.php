<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Guest only (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', fn () => view('auth.login'))->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Auth + Admin only
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
