<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Matapel;
use Illuminate\Support\Facades\DB;

class GuruMatapelController extends Controller
{
    public function index()
    {
        $data = DB::table('guru_matapel')
            ->join('guru', 'guru.id', '=', 'guru_matapel.guru_id')
            ->join('matapel', 'matapel.id', '=', 'guru_matapel.matapel_id')
            ->select('guru_matapel.*', 'guru.nama as guru_nama', 'matapel.mata_pelajaran as matapel_nama')
            ->get();

        return view('guru_matapel.index', compact('data'));
    }

    public function create()
    {
        $guru = Guru::all();
        $matapel = Matapel::all();

        return view('guru_matapel.create', compact('guru', 'matapel'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'guru_id' => 'required',
            'matapel_id' => 'required'
        ]);

        // CEK DUPLIKAT
        $exists = DB::table('guru_matapel')
            ->where('guru_id', $request->guru_id)
            ->where('matapel_id', $request->matapel_id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Relasi sudah ada!');
        }

        DB::table('guru_matapel')->insert([
            'guru_id' => $request->guru_id,
            'matapel_id' => $request->matapel_id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('guru-matapel.index')
            ->with('success', 'Relasi berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = DB::table('guru_matapel')->where('id', $id)->first();
        $guru = Guru::all();
        $matapel = Matapel::all();

        return view('guru_matapel.edit', compact('data', 'guru', 'matapel'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'guru_id' => 'required',
            'matapel_id' => 'required'
        ]);

        DB::table('guru_matapel')
            ->where('id', $id)
            ->update([
                'guru_id' => $request->guru_id,
                'matapel_id' => $request->matapel_id,
                'updated_at' => now()
            ]);

        return redirect()->route('guru-matapel.index')
            ->with('success', 'Relasi berhasil diupdate');
    }

    public function destroy($id)
    {
        DB::table('guru_matapel')->where('id', $id)->delete();

        return redirect()->route('guru-matapel.index')
            ->with('success', 'Relasi berhasil dihapus');
    }
}