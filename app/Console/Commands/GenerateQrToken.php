<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\QrToken;
use App\Models\Jadwal;
use Illuminate\Support\Str;

class GenerateQrToken extends Command
{
    protected $signature = 'app:generate-qr-token';

    protected $description = 'Generate QR token untuk jadwal aktif';

    public function handle()
    {
        $now = now()->format('H:i:s');

        // ambil jadwal hari ini yang sedang berlangsung
        $jadwals = Jadwal::where('tanggal', now()->toDateString())
            ->where('jam_mulai', '<=', $now)
            ->where('jam_selesai', '>=', $now)
            ->get();

        foreach ($jadwals as $jadwal) {

            // hapus token lama
            QrToken::where('jadwal_id', $jadwal->id)->delete();

            // buat token baru
            QrToken::create([
                'jadwal_id' => $jadwal->id,
                'token' => Str::random(40),
                'expired_at' => now()->addMinutes(30)
            ]);

            $this->info("Token dibuat untuk jadwal ID: " . $jadwal->id);
        }

        return 0;
    }
}