<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Jadwal;
use App\Models\JadwalSekolah;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Matapel;

class JadwalController extends Controller
{

    // ========================
    // CRUD JADWAL
    // ========================

    public function index()
    {
        $jadwal = Jadwal::with(['guru','kelas','matapel'])->get();

        return view('jadwal.index', compact('jadwal'));
    }

    public function create()
    {
        $guru = Guru::all();
        $kelas = Kelas::all();
        $matapel = Matapel::all();

        return view('jadwal.create', compact('guru','kelas','matapel'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required',
            'jam_ke' => 'required',
            'guru_id' => 'required',
            'kelas_id' => 'required',
            'matapel_id' => 'required',
        ]);

        Jadwal::create($request->all());

        return redirect()->route('jadwal.index')
            ->with('success','Jadwal berhasil ditambahkan');
    }

    public function show($id)
    {
        $jadwal = Jadwal::with(['guru','kelas','matapel'])->findOrFail($id);

        return view('jadwal.show', compact('jadwal'));
    }

    public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $guru = Guru::all();
        $kelas = Kelas::all();
        $matapel = Matapel::all();

        return view('jadwal.edit', compact('jadwal','guru','kelas','matapel'));
    }

    public function update(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $jadwal->update($request->all());

        return redirect()->route('jadwal.index')
            ->with('success','Jadwal berhasil diupdate');
    }

    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('jadwal.index')
            ->with('success','Jadwal berhasil dihapus');
    }

    // ========================
    // API ABSENSI (SUDAH ADA)
    // ========================

    public function sekarang()
    {
        $hariMap = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];

        $today = $hariMap[Carbon::now()->format('l')];
        $now = Carbon::now()->format('H:i:s');

        $jamSekarang = JadwalSekolah::where('hari', $today)
            ->where('jam_mulai', '<=', $now)
            ->where('jam_selesai', '>=', $now)
            ->first();

        if (!$jamSekarang) {
            return response()->json([
                'status' => 'kosong'
            ]);
        }

        $jadwal = Jadwal::where('hari', $today)
            ->where('jam_ke', $jamSekarang->jam_ke)
            ->first();

        if (!$jadwal) {
            return response()->json([
                'status' => 'kosong'
            ]);
        }

        return response()->json([
            'status' => 'ada',
            'tanggal' => Carbon::now()->format('d/m/Y'),
            'pukul' => Carbon::now()->format('H:i'),
            'jam_pelajaran' => $jamSekarang->jam_mulai . ' - ' . $jamSekarang->jam_selesai,
            'mata_pelajaran' => $jadwal->matapel->mata_pelajaran ?? '-',
        ]);
    }
}