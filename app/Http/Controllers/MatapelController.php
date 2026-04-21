<?php

namespace App\Http\Controllers;

use App\Models\Matapel;
use Illuminate\Http\Request;

class MatapelController extends Controller
{
    public function index()
    {
        $data = Matapel::latest()->get();

        return view('matapel.index', [
            'title' => 'Manajemen Mata Pelajaran',
            'data' => $data,
            'columns' => ['Mata Pelajaran'],
            'fields' => ['mata_pelajaran'],
            'route' => 'matapel',
            'createRoute' => route('matapel.create')
        ]);
    }

    public function create()
    {
        return view('matapel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'mata_pelajaran' => 'required'
        ]);

        Matapel::create($request->all());

        return redirect()->route('matapel.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function show(Matapel $matapel)
    {
        return view('matapel.show', compact('matapel'));
    }

    public function edit(Matapel $matapel)
    {
        return view('matapel.edit', compact('matapel'));
    }

    public function update(Request $request, Matapel $matapel)
    {
        $request->validate([
            'mata_pelajaran' => 'required'
        ]);

        $matapel->update($request->all());

        return redirect()->route('matapel.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy(Matapel $matapel)
    {
        $matapel->delete();

        return redirect()->route('matapel.index')
            ->with('success', 'Data berhasil dihapus');
    }
}