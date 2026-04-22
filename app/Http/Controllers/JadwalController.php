<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Jadwal;
use App\Models\JadwalSekolah;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Matapel;
use Illuminate\Support\Facades\DB;

/**
 * @class JadwalController
 * @brief Controller untuk mengelola jadwal pelajaran.
 *
 * Menyediakan CRUD (Create, Read, Update, Delete) jadwal
 * serta API untuk mendapatkan jadwal sekarang berdasarkan waktu.
 */
class JadwalController extends Controller
{
    // ========================
    // CRUD JADWAL
    // ========================

    /**
     * @brief Menampilkan daftar seluruh jadwal.
     *
     * @return \Illuminate\View\View
     */


    public function index()
    {
        $data = Jadwal::with([
            'jadwalSekolah',
            'kelas',
            'guru',
            'matapel'
        ])
            ->join('jadwal_sekolah', 'jadwal.jadwal_sekolah_id', '=', 'jadwal_sekolah.id')
            ->orderByRaw("
        CASE 
            WHEN jadwal_sekolah.hari = 'Senin' THEN 1
            WHEN jadwal_sekolah.hari = 'Selasa' THEN 2
            WHEN jadwal_sekolah.hari = 'Rabu' THEN 3
            WHEN jadwal_sekolah.hari = 'Kamis' THEN 4
            WHEN jadwal_sekolah.hari = 'Jumat' THEN 5
            WHEN jadwal_sekolah.hari = 'Sabtu' THEN 6
            WHEN jadwal_sekolah.hari = 'Minggu' THEN 7
        END
    ")
            ->orderBy('jadwal_sekolah.jam_ke') // 🔥 INI KUNCI UTAMA
            ->select('jadwal.*')
            ->get();

        return view('jadwal.index', compact('data'));
    }

    /**
     * @brief Menampilkan form untuk menambahkan jadwal baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('jadwal.create', [
            'jadwalSekolah' => JadwalSekolah::orderBy('hari')->orderBy('jam_ke')->get(),
            'kelas' => Kelas::all(),
            'guru' => Guru::all(),
            'mapel' => Matapel::all()
        ]);
    }

    /**
     * @brief Menyimpan jadwal baru ke database.
     *
     * @param Request $request Objek request berisi data jadwal
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'jadwal_sekolah_id' => 'required',
            'kelas_id' => 'required',
            'guru_id' => 'required',
            'matapel_id' => 'required'
        ]);

        // 🔥 CEK BENTROK
        $cek = Jadwal::where('kelas_id', $request->kelas_id)
            ->where('jadwal_sekolah_id', $request->jadwal_sekolah_id)
            ->exists();

        if ($cek) {
            return back()->with('error', 'Jadwal bentrok untuk kelas ini!');
        }

        Jadwal::create($request->all());

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    /**
     * @brief Menampilkan detail jadwal tertentu.
     *
     * @param int $id ID jadwal
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $jadwal = Jadwal::with(['guru', 'kelas', 'matapel'])->findOrFail($id);

        return view('jadwal.show', compact('jadwal'));
    }

    /**
     * @brief Menampilkan form edit jadwal.
     *
     * @param int $id ID jadwal
     * @return \Illuminate\View\View
     */
    public function edit(Jadwal $jadwal)
    {
        return view('jadwal.edit', [
            'jadwal' => $jadwal,
            'jadwalSekolah' => JadwalSekolah::orderBy('hari')->orderBy('jam_ke')->get(),
            'kelas' => Kelas::all(),
            'guru' => Guru::all(),
            'mapel' => Matapel::all()
        ]);
    }

    /**
     * @brief Memperbarui jadwal di database.
     *
     * @param Request $request Objek request berisi data baru
     * @param int $id ID jadwal
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Jadwal $jadwal)
    {
        $request->validate([
            'jadwal_sekolah_id' => 'required',
            'kelas_id' => 'required',
            'guru_id' => 'required',
            'matapel_id' => 'required'
        ]);

        $cek = Jadwal::where('kelas_id', $request->kelas_id)
            ->where('jadwal_sekolah_id', $request->jadwal_sekolah_id)
            ->where('id', '!=', $jadwal->id)
            ->exists();

        if ($cek) {
            return back()->with('error', 'Jadwal bentrok untuk kelas ini!');
        }

        $jadwal->update($request->all());

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diupdate');
    }

    /**
     * @brief Menghapus jadwal dari database.
     *
     * @param int $id ID jadwal
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('jadwal.index')
            ->with('success', 'Jadwal berhasil dihapus');
    }

    // ========================
    // API ABSENSI
    // ========================

    /**
     * @brief Mendapatkan jadwal sekarang untuk absensi berbasis API.
     *
     * Menentukan jadwal berdasarkan:
     * - Hari ini
     * - Waktu saat ini (jam_mulai <= sekarang <= jam_selesai)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sekarang()
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

        $today = $hariMap[Carbon::now()->format('l')];
        $now = Carbon::now()->format('H:i:s');

        $jamSekarang = JadwalSekolah::where('hari', $today)
            ->where('jam_mulai', '<=', $now)
            ->where('jam_selesai', '>=', $now)
            ->first();

        if (!$jamSekarang) {
            return response()->json([
                'status' => 'kosong'
            ]);
        }

        $jadwal = Jadwal::where('jadwal_sekolah_id', $jamSekarang->id)->first();

        if (!$jadwal) {
            return response()->json([
                'status' => 'kosong'
            ]);
        }

        return response()->json([
            'status' => 'ada',
            'tanggal' => Carbon::now()->format('d/m/Y'),
            'pukul' => Carbon::now()->format('H:i'),
            'jam_pelajaran' => $jamSekarang->jam_mulai . ' - ' . $jamSekarang->jam_selesai,
            'mata_pelajaran' => $jadwal->matapel->mata_pelajaran ?? '-',
        ]);
    }



    public function getGuruByMatapel($id)
    {
        $guru = DB::table('guru_matapel')
            ->join('guru', 'guru.id', '=', 'guru_matapel.guru_id')
            ->where('guru_matapel.matapel_id', $id)
            ->select('guru.id', 'guru.nama')
            ->get();

        return response()->json($guru);
    }

    public function getGuruAvailable(Request $request)
    {
        $jadwalSekolah = JadwalSekolah::find($request->jadwal_sekolah_id);

        $guruTerpakai = Jadwal::where('jadwal_sekolah_id', $request->jadwal_sekolah_id)
            ->pluck('guru_id');

        $guru = Guru::where('matapel_id', $request->matapel_id)
            ->whereNotIn('id', $guruTerpakai)
            ->get();

        return response()->json($guru);
    }

    public function apiJadwal()
    {
        $jadwal = Jadwal::with(['jadwalSekolah', 'guru', 'kelas', 'matapel'])
            ->join('jadwal_sekolah', 'jadwal.jadwal_sekolah_id', '=', 'jadwal_sekolah.id')
            ->orderByRaw("
            CASE 
                WHEN jadwal_sekolah.hari = 'Senin' THEN 1
                WHEN jadwal_sekolah.hari = 'Selasa' THEN 2
                WHEN jadwal_sekolah.hari = 'Rabu' THEN 3
                WHEN jadwal_sekolah.hari = 'Kamis' THEN 4
                WHEN jadwal_sekolah.hari = 'Jumat' THEN 5
                WHEN jadwal_sekolah.hari = 'Sabtu' THEN 6
                WHEN jadwal_sekolah.hari = 'Minggu' THEN 7
            END
        ")
            ->orderBy('jadwal_sekolah.jam_ke') // 🔥 FIX UTAMA
            ->select(
                'jadwal.*',
                'jadwal_sekolah.hari',
                'jadwal_sekolah.jam_ke',
                'jadwal_sekolah.jam_mulai',
                'jadwal_sekolah.jam_selesai'
            )
            ->get();

        return response()->json($jadwal);
    }

    public function jadwalSiswa(Request $request)
    {
        $user = $request->user();

        $siswa = \App\Models\Siswa::where('user_id', $user->id)->first();

        if (!$siswa) {
            return response()->json([
                'message' => 'Siswa tidak ditemukan'
            ], 404);
        }

        $jadwal = Jadwal::with(['jadwalSekolah', 'guru', 'kelas', 'matapel'])
            ->join('jadwal_sekolah', 'jadwal.jadwal_sekolah_id', '=', 'jadwal_sekolah.id')
            ->where('jadwal.kelas_id', $siswa->kelas_id)

            ->orderByRaw("
            CASE 
                WHEN jadwal_sekolah.hari = 'Senin' THEN 1
                WHEN jadwal_sekolah.hari = 'Selasa' THEN 2
                WHEN jadwal_sekolah.hari = 'Rabu' THEN 3
                WHEN jadwal_sekolah.hari = 'Kamis' THEN 4
                WHEN jadwal_sekolah.hari = 'Jumat' THEN 5
                WHEN jadwal_sekolah.hari = 'Sabtu' THEN 6
                WHEN jadwal_sekolah.hari = 'Minggu' THEN 7
            END
        ")
            ->orderBy('jadwal_sekolah.jam_ke')

            ->select(
                'jadwal.*',
                'jadwal_sekolah.hari',
                'jadwal_sekolah.jam_ke',
                'jadwal_sekolah.jam_mulai',
                'jadwal_sekolah.jam_selesai'
            )
            ->get();

        return response()->json($jadwal);
    }

    public function jadwalGuru(Request $request)
    {
        $user = $request->user();

        $guru = \App\Models\Guru::where('user_id', $user->id)->first();

        if (!$guru) {
            return response()->json([
                'message' => 'Guru tidak ditemukan'
            ], 404);
        }

        $jadwal = Jadwal::with(['jadwalSekolah', 'guru', 'kelas', 'matapel'])
            ->join('jadwal_sekolah', 'jadwal.jadwal_sekolah_id', '=', 'jadwal_sekolah.id')
            ->where('jadwal.guru_id', $guru->id)

            ->orderByRaw("
            CASE 
                WHEN jadwal_sekolah.hari = 'Senin' THEN 1
                WHEN jadwal_sekolah.hari = 'Selasa' THEN 2
                WHEN jadwal_sekolah.hari = 'Rabu' THEN 3
                WHEN jadwal_sekolah.hari = 'Kamis' THEN 4
                WHEN jadwal_sekolah.hari = 'Jumat' THEN 5
                WHEN jadwal_sekolah.hari = 'Sabtu' THEN 6
                WHEN jadwal_sekolah.hari = 'Minggu' THEN 7
            END
        ")
            ->orderBy('jadwal_sekolah.jam_ke')

            ->select(
                'jadwal.*',
                'jadwal_sekolah.hari',
                'jadwal_sekolah.jam_ke',
                'jadwal_sekolah.jam_mulai',
                'jadwal_sekolah.jam_selesai'
            )
            ->get();

        return response()->json($jadwal);
    }

    public function jamSekolah()
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

        $today = $hariMap[\Carbon\Carbon::now()->format('l')];

        // ambil jam masuk (jam_ke 1)
        $jamMasuk = \App\Models\JadwalSekolah::where('hari', $today)
            ->where('jam_ke', 1)
            ->first();

        // ambil jam pulang (jam_ke 6)
        $jamPulang = \App\Models\JadwalSekolah::where('hari', $today)
            ->where('jam_ke', 6)
            ->first();

        return response()->json([
            'jam_masuk' => $jamMasuk->jam_mulai ?? '-',
            'jam_pulang' => $jamPulang->jam_selesai ?? '-',
        ]);
    }
}
