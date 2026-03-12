<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Jadwal;
use App\Models\JadwalSekolah;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Matapel;

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
        $jadwal = Jadwal::with(['guru','kelas','matapel'])->get();

        return view('jadwal.index', compact('jadwal'));
    }

    /**
     * @brief Menampilkan form untuk menambahkan jadwal baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $guru = Guru::all();
        $kelas = Kelas::all();
        $matapel = Matapel::all();

        return view('jadwal.create', compact('guru','kelas','matapel'));
    }

    /**
     * @brief Menyimpan jadwal baru ke database.
     *
     * @param Request $request Objek request berisi data jadwal
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required',
            'jam_ke' => 'required',
            'guru_id' => 'required',
            'kelas_id' => 'required',
            'matapel_id' => 'required',
        ]);

        Jadwal::create($request->all());

        return redirect()->route('jadwal.index')
            ->with('success','Jadwal berhasil ditambahkan');
    }

    /**
     * @brief Menampilkan detail jadwal tertentu.
     *
     * @param int $id ID jadwal
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $jadwal = Jadwal::with(['guru','kelas','matapel'])->findOrFail($id);

        return view('jadwal.show', compact('jadwal'));
    }

    /**
     * @brief Menampilkan form edit jadwal.
     *
     * @param int $id ID jadwal
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $guru = Guru::all();
        $kelas = Kelas::all();
        $matapel = Matapel::all();

        return view('jadwal.edit', compact('jadwal','guru','kelas','matapel'));
    }

    /**
     * @brief Memperbarui jadwal di database.
     *
     * @param Request $request Objek request berisi data baru
     * @param int $id ID jadwal
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $jadwal->update($request->all());

        return redirect()->route('jadwal.index')
            ->with('success','Jadwal berhasil diupdate');
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
            ->with('success','Jadwal berhasil dihapus');
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

        $jadwal = Jadwal::where('hari', $today)
            ->where('jam_ke', $jamSekarang->jam_ke)
            ->first();

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
}