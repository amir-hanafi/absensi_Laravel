<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'login' => 'Username / NIS / Kode Guru atau password salah'
            ]);
        }

        Auth::login($user);
        return redirect()->route('dashboard');
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
