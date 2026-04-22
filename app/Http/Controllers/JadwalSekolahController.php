<?php

namespace App\Http\Controllers;

use App\Models\JadwalSekolah;
use Illuminate\Http\Request;

class JadwalSekolahController extends Controller
{
    public function index()
    {
        $data = JadwalSekolah::orderBy('hari')
                    ->orderBy('jam_ke')
                    ->get();

        return view('jadwal_sekolah.index', compact('data'));
    }

    public function create()
    {
        return view('jadwal_sekolah.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required',
            'jam_ke' => 'required|integer',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai'
        ]);

        JadwalSekolah::create($request->all());

        return redirect()->route('jadwal-sekolah.index')
            ->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function show(JadwalSekolah $jadwal_sekolah)
    {
        return view('jadwal_sekolah.show', compact('jadwal_sekolah'));
    }

    public function edit(JadwalSekolah $jadwal_sekolah)
    {
        return view('jadwal_sekolah.edit', compact('jadwal_sekolah'));
    }

    public function update(Request $request, JadwalSekolah $jadwal_sekolah)
    {
        $request->validate([
            'hari' => 'required',
            'jam_ke' => 'required|integer',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai'
        ]);

        $jadwal_sekolah->update($request->all());

        return redirect()->route('jadwal-sekolah.index')
            ->with('success', 'Jadwal berhasil diupdate');
    }

    public function destroy(JadwalSekolah $jadwal_sekolah)
    {
        $jadwal_sekolah->delete();

        return redirect()->route('jadwal-sekolah.index')
            ->with('success', 'Jadwal berhasil dihapus');
    }
}