<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Guru;

/**
 * @class AuthController
 * @brief Controller untuk proses autentikasi pengguna (login/logout) baik web maupun API.
 *
 * Menangani login berbasis username, NIS (siswa), kode_guru (guru),
 * validasi password, pembuatan token API (Sanctum), dan logout.
 */
class AuthController extends Controller
{
    /**
     * @brief Melakukan login pengguna melalui web.
     *
     * Mendukung login menggunakan:
     * - username (admin)
     * - kode_guru (guru)
     * - nis (siswa)
     *
     * @param Request $request Objek request berisi 'identifier' dan 'password'
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'identifier' => 'required',
            'password'   => 'required',
        ]);

        $identifier = $request->identifier;
        $user = null;

        // =====================
        // ADMIN (username)
        // =====================
        $user = User::where('username', $identifier)->first();

        // =====================
        // GURU (kode_guru)
        // =====================
        if (!$user) {
            $guru = Guru::where('kode_guru', $identifier)->first();
            $user = $guru?->user;
        }

        // =====================
        // SISWA (nis)
        // =====================
        if (!$user) {
            $siswa = Siswa::where('nis', $identifier)->first();
            $user = $siswa?->user;
        }

        // =====================
        // VALIDASI PASSWORD
        // =====================
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'login' => 'Username / NIS / Kode Guru atau password salah'
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    /**
     * @brief Melakukan login pengguna melalui API (Sanctum).
     *
     * Mendukung login menggunakan:
     * - username (admin)
     * - kode_guru (guru)
     * - nis (siswa)
     *
     * Jika berhasil, menghasilkan token API untuk digunakan oleh Flutter atau aplikasi lain.
     *
     * @param Request $request Objek request berisi 'identifier' dan 'password'
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiLogin(Request $request)
    {
        $request->validate([
            'identifier' => 'required',
            'password'   => 'required',
        ]);

        $identifier = $request->identifier;
        $user = null;

        // ADMIN
        $user = User::where('username', $identifier)->first();

        // GURU
        if (!$user) {
            $guru = Guru::where('kode_guru', $identifier)->first();
            $user = $guru?->user;
        }

        // SISWA
        if (!$user) {
            $siswa = Siswa::where('nis', $identifier)->first();
            $user = $siswa?->user;
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Identifier atau password salah'
            ], 401);
        }

        // 🔑 BUAT TOKEN SANCTUM
        $token = $user->createToken('flutter-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'role' => $user->role,
            ]
        ]);
    }

    /**
     * @brief Logout pengguna dari sesi web.
     *
     * Menghapus sesi login dan mengarahkan kembali ke halaman login.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    /**
     * @brief Logout pengguna dari API (Sanctum).
     *
     * Menghapus token API saat ini sehingga pengguna tidak bisa lagi menggunakan token tersebut.
     *
     * @param Request $request Objek request dari API
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiLogout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil'
        ]);
    }
}