<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\QrToken;
use App\Models\Jadwal;
use App\Models\JadwalSekolah;
use Illuminate\Support\Str;

/**
 * @class GenerateQrToken
 * @brief Command Artisan untuk membuat token QR otomatis untuk jadwal yang sedang aktif
 */
class GenerateQrToken extends Command
{
    /**
     * @brief Signature command Artisan
     */
    protected $signature = 'app:generate-qr-token';

    /**
     * @brief Deskripsi command
     */
    protected $description = 'Generate QR token untuk jadwal aktif';

    /**
     * @brief Eksekusi command
     * 
     * Logic:
     *  - Cek hari & jam sekarang
     *  - Cari jam pelajaran aktif
     *  - Ambil semua jadwal untuk jam tersebut
     *  - Hapus token lama
     *  - Buat token baru dengan masa berlaku 5 menit
     */
    public function handle()
    {
        // Mapping nama hari
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

        // Cari jam pelajaran aktif
        $jamSekarang = JadwalSekolah::where('hari', $today)
            ->where('jam_mulai', '<=', $now)
            ->where('jam_selesai', '>=', $now)
            ->first();

        if (!$jamSekarang) {
            $this->info("Tidak ada jam pelajaran saat ini");
            return 0;
        }

        // Ambil semua jadwal untuk jam aktif
        $jadwals = Jadwal::where('hari', $today)
            ->where('jam_ke', $jamSekarang->jam_ke)
            ->get();

        $this->info("Jumlah jadwal aktif: " . $jadwals->count());

        foreach ($jadwals as $jadwal) {

            // // Hapus token lama
            // QrToken::where('jadwal_id', $jadwal->id)->delete();

            // Buat token baru
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