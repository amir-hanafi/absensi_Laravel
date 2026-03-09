<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QrToken;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Jadwal;
use App\Models\JadwalSekolah;



class QrController extends Controller
{


    public function getToken($jadwal_id)
    {
        $qr = QrToken::where('jadwal_id', $jadwal_id)
            ->latest()
            ->first();

        if (!$qr) {
            return response()->json([
                "message" => "Token belum tersedia"
            ], 404);
        }

        return response()->json([
            "token" => $qr->token,
            "expired_at" => $qr->expired_at
        ]);
    }



    public function getCurrentToken()
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
                "message" => "Tidak ada jam pelajaran saat ini"
            ], 404);
        }

        $jadwal = Jadwal::where('hari', $today)
            ->where('jam_ke', $jamSekarang->jam_ke)
            ->first();


        if (!$jadwal) {
            return response()->json([
                "message" => "Tidak ada jadwal saat ini"
            ], 404);
        }

        $qr = QrToken::where('jadwal_id', $jadwal->id)
            ->latest()
            ->first();

        if (!$qr) {
            return response()->json([
                "message" => "Token belum tersedia"
            ], 404);
        }

        return response()->json([
            "token" => $qr->token,
            "jadwal_id" => $jadwal->id,
            "expired_at" => $qr->expired_at
        ]);
    }


    public function scanQr(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $qr = QrToken::where('token', $request->token)->first();

        if (!$qr) {
            return response()->json([
                "status" => "invalid",
                "message" => "QR tidak valid"
            ], 404);
        }

        if (Carbon::now()->greaterThan($qr->expired_at)) {
            return response()->json([
                "status" => "invalid",
                "message" => "QR sudah expired"
            ], 400);
        }

        return response()->json([
            "status" => "valid",
            "message" => "Absensi berhasil",
            "jadwal_id" => $qr->jadwal_id
        ]);
    }
}
