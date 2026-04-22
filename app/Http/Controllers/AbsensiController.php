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

    public function rekapBulanan(Request $request)
    {
        $user = $request->user();

        $bulan = now()->month;
        $tahun = now()->year;

        $data = Absensi::where('user_id', $user->id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->selectRaw("
            status,
            COUNT(*) as total
        ")
            ->groupBy('status')
            ->pluck('total', 'status');

        return response()->json([
            'Hadir' => $data['Hadir'] ?? 0,
            'Ijin'  => $data['Ijin'] ?? 0,
            'Sakit' => $data['Sakit'] ?? 0,
            'Alpha' => $data['Alpha'] ?? 0,
        ]);
    }
}
