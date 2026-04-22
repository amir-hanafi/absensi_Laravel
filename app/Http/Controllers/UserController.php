<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Kelas;

class UserController extends Controller
{
    public function index()
    {
        $data = User::latest()->get();

        return view('user.index', [
            'title' => 'Manajemen User',
            'data' => $data,
            'columns' => ['Username', 'Role'],
            'fields' => ['username', 'role'],
            'route' => 'user',
            'createRoute' => route('user.create')
        ]);
    }

    public function create()
    {
        $kelas = Kelas::where('tingkat_kelas', 10)->get();

        return view('user.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        // dd($request->all());

        // 🔥 VALIDASI GLOBAL + ROLE
        $rules = [
            'username' => 'required|unique:users',
            'password' => 'required|min:5',
            'role'     => 'required'
        ];



        // 🔥 tambahan jika siswa
        if ($request->role == 'siswa') {
            $rules['tahun_masuk'] = 'required|integer';
            $rules['kelas_id'] = 'required';
        }

        $request->validate($rules);

        // ========================
        // BARU BUAT USER
        // ========================
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role'     => $request->role
        ]);

        // ========================
        // GURU
        // ========================
        if ($request->role == 'guru') {

            $lastGuru = Guru::orderBy('id', 'desc')->first();

            $nextNumber = $lastGuru
                ? (int) substr($lastGuru->kode_guru, 3) + 1
                : 1;

            $kodeGuru = 'GR-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            Guru::create([
                'kode_guru' => $kodeGuru,
                'nama'      => $request->username,
                'no_hp'     => $request->no_hp,
                'user_id'   => $user->id
            ]);
        }

        // ========================
        // SISWA
        // ========================
        if ($request->role == 'siswa') {

            // 🔥 HITUNG STATUS DULU
            $tahunSekarang = date('Y');
            $selisih = $tahunSekarang - $request->tahun_masuk;

            $status = ($selisih >= 3) ? 'nonaktif' : 'aktif';

            // 🔥 GENERATE NIS
            $lastSiswa = Siswa::orderBy('id', 'desc')->first();

            $nextNumber = $lastSiswa
                ? (int) substr($lastSiswa->nis, 3) + 1
                : 1;

            $nis = 'NIS' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            // 🔥 SIMPAN
            Siswa::create([
                'nis' => $nis,
                'nama' => $request->username,
                'tahun_masuk' => $request->tahun_masuk,
                'kelas_id' => $request->kelas_id,
                'status' => $status,
                'user_id' => $user->id
            ]);
        }





        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan');
    }

    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    public function edit(User $user)
    {
        $kelas = Kelas::all();

        return view('user.edit', compact('user', 'kelas'));
    }

    public function update(Request $request, User $user)
    {
        // dd($request->all());

        $request->validate([
            'username' => 'required|unique:users,username,' . $user->id,
            'role'     => 'required'
        ]);

        $user->update([
            'username' => $request->username,
            'role'     => $request->role
        ]);

        if ($request->password) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        // ========================
        // UPDATE GURU
        // ========================
        if ($request->role == 'guru') {

            $guru = Guru::where('user_id', $user->id)->first();

            if ($guru) {
                // ✅ update saja TANPA kode_guru
                $guru->update([
                    'nama'  => $request->username,
                    'no_hp' => $request->no_hp
                ]);
            } else {
                // ❗ kalau belum ada → generate kode_guru
                $lastGuru = Guru::orderBy('id', 'desc')->first();

                $nextNumber = $lastGuru
                    ? (int) substr($lastGuru->kode_guru, 3) + 1
                    : 1;

                $kodeGuru = 'GR-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

                Guru::create([
                    'kode_guru' => $kodeGuru,
                    'nama'      => $request->username,
                    'no_hp'     => $request->no_hp,
                    'user_id'   => $user->id
                ]);
            }
        }

        if ($request->role == 'siswa') {

            $request->validate([
                'kelas_id' => 'required'
            ]);

            $siswa = Siswa::where('user_id', $user->id)->first();

            if ($siswa) {
                // ✅ kalau sudah ada → update
                $siswa->update([
                    'nama' => $request->username,
                    'kelas_id' => $request->kelas_id
                ]);
            } else {
                // ❗ kalau belum ada → buat + generate NIS
                $lastSiswa = Siswa::orderBy('id', 'desc')->first();

                $nextNumber = $lastSiswa
                    ? (int) substr($lastSiswa->nis, 3) + 1
                    : 1;

                $nis = 'NIS' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

                Siswa::create([
                    'nis'      => $nis,
                    'nama'     => $request->username,
                    'tahun_masuk'  => $request->tahun_masuk,
                    'kelas_id' => $request->kelas_id,
                    'user_id'  => $user->id
                ]);
            }
        }



        return redirect()->route('user.index')->with('success', 'User berhasil diupdate');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User berhasil dihapus');
    }
}
