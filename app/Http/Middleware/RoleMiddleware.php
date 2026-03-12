<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * @class RoleMiddleware
 * @brief Middleware untuk membatasi akses berdasarkan role user.
 *
 * Mengecek apakah user sudah login dan memiliki role yang sesuai.
 * Jika tidak login, diarahkan ke halaman login.
 * Jika role tidak sesuai, diberikan HTTP 403.
 */
class RoleMiddleware
{
    /**
     * @brief Menangani request dan memeriksa role user.
     *
     * @param Request $request Objek HTTP request
     * @param Closure $next Fungsi closure untuk meneruskan request
     * @param string $role Role yang diizinkan (contoh: 'admin', 'guru', 'siswa')
     *
     * @return Response Response setelah middleware dijalankan
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Cek apakah role sesuai
        if (Auth::user()->role !== $role) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }

        // Lanjutkan request
        return $next($request);
    }
}