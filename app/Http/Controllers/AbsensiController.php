<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Attendance;


class AbsensiController extends Controller
{
    public function index()
    {
        $absensis = Absensi::with('user')
            ->latest()
            ->paginate(10);

        return view('absensi.index', compact('absensis'));
    }

    public function create()
    {
        $users = User::all();
        return view('absensi.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'tanggal' => 'required|date',
            'status' => 'required'
        ]);

        Absensi::create($request->all());

        return redirect()->route('absensi.index')
            ->with('success', 'Absensi berhasil ditambahkan');
    }

    public function edit(Absensi $absensi)
    {
        $users = User::all();
        return view('absensi.edit', compact('absensi', 'users'));
    }

    public function update(Request $request, Absensi $absensi)
    {
        $request->validate([
            'user_id' => 'required',
            'tanggal' => 'required|date',
            'status' => 'required'
        ]);

        $absensi->update($request->all());

        return redirect()->route('absensi.index')
            ->with('success', 'Absensi berhasil diupdate');
    }

    public function destroy(Absensi $absensi)
    {
        // Cek apakah ada relasi ke attendance
        if ($absensi->attendance_id) {

            $attendance = Attendance::find($absensi->attendance_id);

            if ($attendance) {
                $attendance->delete();
            }
        }

        // Hapus absensi
        $absensi->delete();

        return back()->with('success', 'Absensi dan attendance terkait berhasil dihapus');
    }
}
