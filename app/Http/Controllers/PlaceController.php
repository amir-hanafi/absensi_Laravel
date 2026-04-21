<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function index()
    {
        $places = Place::latest()->get();

        return view('places.index', compact('places'));
    }

    public function create()
    {
        return view('places.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'allowed_radius' => 'required|integer'
        ]);

        Place::create($request->all());

        return redirect()->route('places.index')
            ->with('success', 'Lokasi berhasil ditambahkan');
    }

    public function show(Place $place)
    {
        return view('places.show', compact('place'));
    }

    public function edit(Place $place)
    {
        return view('places.edit', compact('place'));
    }

    public function update(Request $request, Place $place)
    {
        $request->validate([
            'name' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'allowed_radius' => 'required|integer'
        ]);

        $place->update($request->all());

        return redirect()->route('places.index')
            ->with('success', 'Lokasi berhasil diupdate');
    }

    public function destroy(Place $place)
    {
        $place->delete();

        return redirect()->route('places.index')
            ->with('success', 'Lokasi berhasil dihapus');
    }
}