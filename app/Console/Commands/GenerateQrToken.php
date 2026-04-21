<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\QrToken;
use App\Models\JadwalSekolah;
use Illuminate\Support\Str;

class GenerateQrToken extends Command
{
    protected $signature = 'app:generate-qr-token';
    protected $description = 'Generate QR token berdasarkan jam sekolah aktif';

    public function handle()
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

        $today = $hariMap[now()->format('l')];
        $now = now()->format('H:i:s');

        // 🔥 Ambil jam sekolah aktif
        $jamSekarang = JadwalSekolah::where('hari', $today)
            ->where('jam_mulai', '<=', $now)
            ->where('jam_selesai', '>=', $now)
            ->first();

        if (!$jamSekarang) {
            $this->info("Tidak ada jam sekolah aktif");
            return 0;
        }

        // 🔥 Hapus semua token lama (opsional tapi disarankan)
        QrToken::query()->delete();

        // 🔥 Buat 1 token global
        $token = Str::random(40);

        QrToken::create([
            'token' => $token,
            'expired_at' => now()->addMinutes(5)
        ]);

        $this->info("Token baru dibuat: " . $token);

        return 0;
    }
}