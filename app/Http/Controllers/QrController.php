<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QrToken;
use Illuminate\Support\Str;
use Carbon\Carbon;



class QrController extends Controller
{
    //
    // public function generate($jadwal_id)
    // {
    //     $token = Str::random(40);

    //     $qr = QrToken::create([
    //         'jadwal_id' => $jadwal_id,
    //         'token' => $token,
    //         'expired_at' => now()->addMinutes(5)
    //     ]);

    //     return response()->json([
    //         'token' => $qr->token
    //     ]);
    // }

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
