<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Guru;


class AuthController extends Controller
{
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

        // =====================
        // 🔐 FILTER ROLE ADMIN
        // =====================
        // if ($user->role !== 'admin') {
        //     return back()->withErrors([
        //         'login' => 'Akun ini tidak memiliki akses ke Admin Panel'
        //     ]);
        // }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

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



    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function apiLogout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil'
        ]);
    }
}
