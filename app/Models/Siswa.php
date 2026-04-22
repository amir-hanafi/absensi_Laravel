<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @class Siswa
 * @brief Model Eloquent untuk tabel `siswa`.
 *
 * Model ini merepresentasikan siswa di sekolah, termasuk informasi
 * pribadi, relasi ke kelas, akun pengguna, dan absensi yang dilakukan.
 */
class Siswa extends Model
{
    /// Nama tabel yang digunakan
    protected $table = 'siswa';

    /**
     * @brief Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'nis',       ///< Nomor Induk Siswa (unik)
        'nama',      ///< Nama siswa
        'tahun_masuk',
        'kelas_id',  ///< ID kelas siswa
        'user_id',   ///< ID user terkait siswa
        'status',
    ];

    /**
     * @brief Relasi ke model Kelas.
     *
     * Menunjukkan kelas tempat siswa ini tergabung.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    /**
     * @brief Relasi ke model Absensi.
     *
     * Mengambil semua record absensi yang dimiliki siswa ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    /**
     * @brief Relasi ke model User.
     *
     * Menunjukkan akun pengguna terkait siswa ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusLabelAttribute()
    {
        return $this->kelas_sekarang;
    }

    public function getKelasSekarangAttribute()
    {
        if (!$this->kelas) return '-';

        $tahunSekarang = date('Y');
        $selisih = $tahunSekarang - $this->tahun_masuk;

        // kalau sudah lebih dari 3 tahun → lulus
        if ($selisih >= 3) {
            return 'Sudah Lulus';
        }

        $tingkatAwal = $this->kelas->tingkat_kelas; // 10
        $tingkatSekarang = $tingkatAwal + $selisih;

        // 🔥 ambil nama kelas TANPA tingkat
        // misal: "IPS-1"
        $nama = $this->kelas->nama_kelas;

        // hapus X / XI / XII dari nama
        $nama = preg_replace('/^(X|XI|XII)\s*-?\s*/', '', $nama);

        return $this->convertRomawi($tingkatSekarang) . ' - ' . $nama;
    }

    private function convertRomawi($angka)
    {
        $map = [
            10 => 'X',
            11 => 'XI',
            12 => 'XII'
        ];

        return $map[$angka] ?? $angka;
    }
}
