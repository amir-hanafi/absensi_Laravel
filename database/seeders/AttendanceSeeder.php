<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\User;
use App\Models\QrToken;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $tokens = QrToken::all();
        $users  = User::where('role', 'siswa')->get();

        if ($tokens->isEmpty() || $users->isEmpty()) {
            return;
        }

        foreach ($tokens as $token) {

            foreach ($users as $user) {

                Attendance::create([
                    'qr_token_id' => $token->id,
                    'user_id'     => $user->id,

                    'latitude'  => -6.200000,
                    'longitude' => 106.816666,

                    'distance' => rand(1, 50),

                    'status' => 'valid',

                    'scan_time' => Carbon::now()->subMinutes(rand(1, 60)),
                ]);
            }

        }
    }
}