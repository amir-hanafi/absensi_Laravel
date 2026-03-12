<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

/**
 * @file
 * @brief Definisi command custom dan penjadwalan task otomatis
 */

// Command bawaan Laravel untuk menampilkan quote inspiratif
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/**
 * @brief Penjadwalan command generate QR token
 * 
 * Command "app:generate-qr-token" dijalankan setiap 5 menit untuk membuat token QR
 * bagi jadwal yang sedang aktif.
 */
Schedule::command('app:generate-qr-token')
    ->everyFiveMinutes();