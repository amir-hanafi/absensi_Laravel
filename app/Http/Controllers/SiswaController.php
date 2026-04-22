<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiswaController extends Controller
{
    //
    public function getKelasByTingkat(Request $request)
    {
        $kelas = \App\Models\Kelas::where('tingkat_kelas', $request->tingkat)->get();

        return response()->json($kelas);
    }
}
