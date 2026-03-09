<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\QrToken;
use App\Models\Place;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{

    public function scanQr(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        $user = $request->user();

        $token = QrToken::where('token', $request->token)->first();

        if (!$token) {
            return response()->json([
                "status" => "invalid",
                "message" => "QR tidak valid"
            ], 404);
        }

        if (now()->gt($token->expired_at)) {
            return response()->json([
                "status" => "invalid",
                "message" => "QR sudah expired"
            ], 400);
        }

        // cek apakah sudah absen valid
        $alreadyValid = Attendance::where('user_id', $user->id)
            ->where('jadwal_id', $token->jadwal_id)
            ->where('status', 'valid')
            ->exists();

        if ($alreadyValid) {
            return response()->json([
                "status" => "rejected",
                "message" => "Anda sudah absen pada jadwal ini"
            ], 403);
        }

        $places = Place::all();

        $status = "invalid";
        $distance = null;
        $placeName = null;

        foreach ($places as $place) {

            $currentDistance = $this->calculateDistance(
                $place->latitude,
                $place->longitude,
                $request->latitude,
                $request->longitude
            );

            if ($currentDistance <= $place->allowed_radius) {
                $status = "valid";
                $distance = $currentDistance;
                $placeName = $place->name;
                break;
            }
        }

        if ($distance === null) {
            $place = $places->first();

            $distance = $this->calculateDistance(
                $place->latitude,
                $place->longitude,
                $request->latitude,
                $request->longitude
            );
        }

        Attendance::create([
            'qr_token_id' => $token->id,
            'user_id' => $user->id,
            'jadwal_id' => $token->jadwal_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'distance' => $distance,
            'status' => $status,
            'scan_time' => now()
        ]);

        return response()->json([
            "status" => $status,
            "distance" => $distance,
            "message" => $status == "valid"
                ? "Absensi berhasil di $placeName"
                : "Diluar radius semua tempat"
        ]);
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {

        $earthRadius = 6371000;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a =
            sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) *
            cos(deg2rad($lat2)) *
            sin($dLon / 2) *
            sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
