<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Guru;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with('guru')->latest()->get();

        return view('kelas.index', compact('kelas'));
    }

    public function create()
    {
        $gurus = Guru::all();

        return view('kelas.create', compact('gurus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required',
            'tingkat_kelas' => 'required|integer|min:10|max:12',
            'guru_id' => 'required'
        ]);

        Kelas::create($request->all());

        return redirect()->route('kelas.index')
            ->with('success', 'Data kelas berhasil ditambahkan');
    }

    public function show($id)
    {
        $kelas = Kelas::with(['guru', 'siswa'])->findOrFail($id);

        return view('kelas.show', compact('kelas'));
    }

    public function edit(Kelas $kela)
    {
        $gurus = Guru::all();

        return view('kelas.edit', [
            'kelas' => $kela,
            'gurus' => $gurus
        ]);
    }

    public function update(Request $request, Kelas $kela)
    {
        $request->validate([
            'nama_kelas' => 'required',
            'tingkat_kelas' => 'required|integer|min:10|max:12',
            'guru_id' => 'required'
        ]);

        $kela->update($request->all());

        return redirect()->route('kelas.index')
            ->with('success', 'Data kelas berhasil diupdate');
    }

    public function destroy(Kelas $kela)
    {
        $kela->delete();

        return redirect()->route('kelas.index')
            ->with('success', 'Data kelas berhasil dihapus');
    }
}
