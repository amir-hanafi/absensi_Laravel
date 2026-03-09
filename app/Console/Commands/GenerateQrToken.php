<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\QrToken;
use App\Models\Jadwal;
use App\Models\JadwalSekolah;
use Illuminate\Support\Str;

class GenerateQrToken extends Command
{
    protected $signature = 'app:generate-qr-token';

    protected $description = 'Generate QR token untuk jadwal aktif';

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

        // cari jam pelajaran sekarang
        $jamSekarang = JadwalSekolah::where('hari', $today)
            ->where('jam_mulai', '<=', $now)
            ->where('jam_selesai', '>=', $now)
            ->first();

        if (!$jamSekarang) {
            $this->info("Tidak ada jam pelajaran saat ini");
            return 0;
        }

        // ambil semua jadwal kelas pada jam tersebut
        $jadwals = Jadwal::where('hari', $today)
            ->where('jam_ke', $jamSekarang->jam_ke)
            ->get();

        $this->info("Jumlah jadwal aktif: " . $jadwals->count());

        foreach ($jadwals as $jadwal) {

            QrToken::where('jadwal_id', $jadwal->id)->delete();

            QrToken::create([
                'jadwal_id' => $jadwal->id,
                'token' => Str::random(40),
                'expired_at' => now()->addMinutes(5)
            ]);

            $this->info("Token dibuat untuk jadwal ID: " . $jadwal->id);
        }

        return 0;
    }
}
