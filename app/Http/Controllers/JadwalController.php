<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Jadwal;
use App\Models\JadwalSekolah;

class JadwalController extends Controller
{
    //

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

        // cari jam pelajaran sekarang
        $jamSekarang = JadwalSekolah::where('hari', $today)
            ->where('jam_mulai', '<=', $now)
            ->where('jam_selesai', '>=', $now)
            ->first();

        if (!$jamSekarang) {
            return response()->json([
                'status' => 'kosong'
            ]);
        }

        // cari jadwal kelas pada jam tersebut
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
