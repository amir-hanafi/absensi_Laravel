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
            'role'     => 'required|in:admin,guru,siswa',
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = null;

        // =====================
        // SISWA → NIS
        // =====================
        if ($request->role === 'siswa') {
            $siswa = Siswa::where('nis', $request->username)->first();
            $user  = $siswa?->user;
        }

        // =====================
        // GURU → KODE GURU
        // =====================
        if ($request->role === 'guru') {
            $guru = Guru::where('kode_guru', $request->username)->first();
            $user = $guru?->user;
        }

        // =====================
        // ADMIN → USERNAME
        // =====================
        if ($request->role === 'admin') {
            $user = User::where('username', $request->username)
                        ->where('role', 'admin')
                        ->first();
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'login' => 'Login gagal'
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
