<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\QrToken;
use App\Models\Place;
use App\Models\Absensi;
use App\Models\PointRule;
use App\Models\PointLedger;
use Carbon\Carbon;
use App\Models\UserToken;
use App\Models\FlexibilityItem;

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

        // ======================
        // VALIDASI QR
        // ======================
        $token = QrToken::where('token', $request->token)->latest()->first();

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

        // ======================
        // CEK SUDAH ABSEN
        // ======================
        $alreadyValid = Attendance::where('user_id', $user->id)
            ->whereDate('scan_time', now()->toDateString())
            ->where('status', 'valid')
            ->exists();

        if ($alreadyValid) {
            return response()->json([
                "status" => "rejected",
                "message" => "Anda sudah absen"
            ], 403);
        }

        // ======================
        // VALIDASI LOKASI
        // ======================
        $places = Place::all();

        $distance = null;
        $placeName = null;

        foreach ($places as $place) {
            $d = $this->calculateDistance(
                $place->latitude,
                $place->longitude,
                $request->latitude,
                $request->longitude
            );

            if ($d <= $place->allowed_radius) {
                $distance = $d;
                $placeName = $place->name;
                break;
            }
        }

        if (!$distance) {
            return response()->json([
                "status" => "rejected",
                "message" => "Diluar radius"
            ], 403);
        }

        // ======================
        // SIMPAN ATTENDANCE
        // ======================
        $attendance = Attendance::create([
            'qr_token_id' => $token->id,
            'user_id' => $user->id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'distance' => $distance,
            'status' => 'valid',
            'scan_time' => now()
        ]);

        // ======================
        // HITUNG TELAT
        // ======================
        $ruleTerlambat = PointRule::where('rule_name', 'Terlambat')->first();

        $jamMasuk = $ruleTerlambat->condition_value;

        $startTime = Carbon::parse($jamMasuk);
        $scanTime = Carbon::parse($attendance->scan_time);

        $lateMinutes = $startTime->diffInMinutes($scanTime, false);
        $isLate = $lateMinutes > 0;

        $tokenUsed = false;

        // ======================
        // CEK TOKEN
        // ======================
        if ($isLate) {

            $tokens = UserToken::where('user_id', $user->id)
                ->where('status', 'AVAILABLE')
                ->get();

            foreach ($tokens as $tokenUser) {

                $item = FlexibilityItem::find($tokenUser->item_id);

                if (
                    $item &&
                    $item->max_late_minutes !== null &&
                    $item->max_late_minutes >= $lateMinutes
                ) {

                    $tokenUser->update([
                        'status' => 'USED'
                    ]);

                    $tokenUsed = true;
                    break;
                }
            }
        }

        // ======================
        // LEDGER
        // ======================
        $last = PointLedger::where('user_id', $user->id)->latest()->first();
        $balance = $last ? $last->current_balance : 0;

        if ($tokenUsed) {

            PointLedger::create([
                'user_id' => $user->id,
                'transaction_type' => 'TOKEN_USED',
                'amount' => 0,
                'current_balance' => $balance,
                'description' => 'Menggunakan token keterlambatan'
            ]);
        } else {

            $waktuAbsen = $scanTime->format('H:i:s');
            $rules = PointRule::all();

            foreach ($rules as $rule) {

                $match = false;

                if ($rule->condition_operator == '<') {
                    $match = $waktuAbsen < $rule->condition_value;
                } elseif ($rule->condition_operator == '>') {
                    $match = $waktuAbsen > $rule->condition_value;
                } elseif ($rule->condition_operator == 'between') {

                    [$rangeStart, $rangeEnd] = explode('-', $rule->condition_value);

                    $match = $waktuAbsen >= $rangeStart && $waktuAbsen <= $rangeEnd;
                }

                if ($match) {

                    $point = $rule->point_modifier;

                    PointLedger::create([
                        'user_id' => $user->id,
                        'transaction_type' => $point >= 0 ? 'EARN' : 'PENALTY',
                        'amount' => $point,
                        'current_balance' => $balance + $point,
                        'description' => $rule->rule_name,
                    ]);

                    break;
                }
            }
        }

        // ======================
        // SIMPAN ABSENSI
        // ======================
        Absensi::updateOrCreate(
            [
                'user_id' => $user->id,
                'tanggal' => now()->toDateString(),
            ],
            [
                'status' => 'Hadir', // FIXED
                'attendance_id' => $attendance->id
            ]
        );

        return response()->json([
            "status" => "valid",
            "message" => !$isLate
                ? "Absensi berhasil di $placeName"
                : ($tokenUsed
                    ? "Telat $lateMinutes menit, pakai token 👍"
                    : "Telat $lateMinutes menit")
        ]);
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a =
            sin($dLat / 2) ** 2 +
            cos(deg2rad($lat1)) *
            cos(deg2rad($lat2)) *
            sin($dLon / 2) ** 2;

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
