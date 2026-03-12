<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

/**
 * @file bootstrap/app.php
 * @brief File bootstrap Laravel untuk konfigurasi aplikasi.
 *
 * Menyiapkan aplikasi Laravel, routing, middleware, dan exception handling.
 */

return Application::configure(basePath: dirname(__DIR__))
    /** 
     * @brief Mengatur routing aplikasi.
     *
     * @param web Path ke file routes web
     * @param api Path ke file routes api
     * @param commands Path ke file routes console
     * @param health Endpoint untuk health check
     */
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    /**
     * @brief Mengatur middleware aplikasi.
     *
     * Bisa menambahkan alias middleware, contohnya:
     * 'role' => \App\Http\Middleware\RoleMiddleware::class
     */
    ->withMiddleware(function (Middleware $middleware): void {
        //
        // $middleware->alias([
        // 'role' => \App\Http\Middleware\RoleMiddleware::class,
        // ]);
    })
    /**
     * @brief Mengatur exception handling aplikasi.
     *
     * Fungsi callback menerima objek Exceptions untuk dikustomisasi.
     */
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    /** @brief Membuat instance aplikasi */
    ->create();