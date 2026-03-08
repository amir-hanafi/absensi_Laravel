<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QrToken;
use Illuminate\Support\Str;

class QrController extends Controller
{
    //
    public function generate($jadwal_id)
    {
        $token = Str::random(40);

        $qr = QrToken::create([
            'jadwal_id' => $jadwal_id,
            'token' => $token,
            'expired_at' => now()->addMinutes(5)
        ]);

        return response()->json([
            'token' => $qr->token
        ]);
    }

    public function scan(Request $request)
    {
        $request->validate([
            'token' => 'required'
        ]);

        $qr = QrToken::where('token', $request->token)->first();

        if (!$qr) {
            return response()->json([
                'message' => 'QR tidak ditemukan'
            ], 404);
        }

        if (now()->gt($qr->expired_at)) {
            return response()->json([
                'message' => 'QR sudah expired'
            ], 400);
        }

        return response()->json([
            'message' => 'QR valid',
            'jadwal_id' => $qr->jadwal_id
        ]);
    }
}
