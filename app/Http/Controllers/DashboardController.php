<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\User;
use App\Models\PointLedger;



class DashboardController extends Controller
{
    //
    public function index()
    {
        $totalKelas = Kelas::count();

        $totalAdmin = User::where('role', 'admin')->count();
        $totalGuru  = User::where('role', 'guru')->count();
        $totalSiswa = User::where('role', 'siswa')->count();


        return view('dashboard', compact('totalKelas', 'totalAdmin', 'totalGuru', 'totalSiswa'));
    }
}
