<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\AssessmentCategory;
use App\Models\Assessment;
use App\Models\AssessmentDetail;
use App\Models\User;
use App\Models\Guru;
use App\Models\Kelas;
use Carbon\Carbon;


class AssessmentController extends Controller
{
    //
    public function daftarSiswa()
    {
        $siswa = Siswa::with(['kelas.guru'])->get();

        $bulan = Carbon::now()->month;
        $tahun = Carbon::now()->year;

        // total siswa
        $totalSiswa = $siswa->count();

        // siswa yang sudah dinilai bulan ini
        $sudahDinilai = Assessment::whereMonth('assessment_date', $bulan)
            ->whereYear('assessment_date', $tahun)
            ->distinct('siswa_id')
            ->count('siswa_id');

        return view('assessment.daftar_siswa', compact(
            'siswa',
            'totalSiswa',
            'sudahDinilai'
        ));
    }

    public function create($id)
    {
        $siswa = Siswa::with('kelas')->findOrFail($id);
        $categories = AssessmentCategory::where('is_active', true)->get();

        return view('assessment.form_penilaian', compact('siswa', 'categories'));
    }

    public function store(Request $request)
    {
        $guru = Auth::user()->guru;

        $assessment = Assessment::create([
            'evaluator_id' => $guru->id,
            'siswa_id' => $request->siswa_id,
            'assessment_date' => now(),
            'period' => date('F Y'),
            'general_notes' => $request->notes
        ]);

        foreach ($request->score as $category_id => $score) {

            AssessmentDetail::create([
                'assessment_id' => $assessment->id,
                'category_id' => $category_id,
                'score' => $score
            ]);
        }

        return redirect('/penilaian/siswa')
            ->with('success', 'Penilaian berhasil disimpan');
    }

    public function laporan(Request $request, $id)
    {

        $siswa = Siswa::with('kelas')->findOrFail($id);

        $query = Assessment::where('siswa_id', $id)
            ->with('details.category');

        if ($request->periode == 'harian') {
            $query->whereDate('assessment_date', today());
        }

        if ($request->periode == 'mingguan') {
            $query->whereBetween('assessment_date', [now()->startOfWeek(), now()->endOfWeek()]);
        }

        if ($request->periode == 'bulanan') {
            $query->whereMonth('assessment_date', now()->month);
        }

        $assessments = $query->latest()->get();

        $labels = [];
        $scores = [];

        $categories = \App\Models\AssessmentCategory::all();

        foreach ($categories as $category) {

            $labels[] = $category->name;

            $avg = \App\Models\AssessmentDetail::whereHas('assessment', function ($q) use ($siswa) {
                $q->where('siswa_id', $siswa->id);
            })
                ->where('category_id', $category->id)
                ->avg('score');

            $scores[] = round($avg, 1);
        }

        return view('assessment.laporan', compact(
            'siswa',
            'assessments',
            'labels',
            'scores'
        ));
    }

    public function indexLaporan()
    {

        $siswa = Siswa::with('kelas')->get();

        $bulan = Carbon::now()->month;
        $tahun = Carbon::now()->year;

        // jumlah siswa
        $totalSiswa = $siswa->count();

        // siswa yang sudah dinilai bulan ini
        $sudahDinilai = Assessment::whereMonth('assessment_date', $bulan)
            ->whereYear('assessment_date', $tahun)
            ->distinct('siswa_id')
            ->count('siswa_id');

        return view('assessment.daftar_laporan', compact(
            'siswa',
            'totalSiswa',
            'sudahDinilai'
        ));
    }
}
