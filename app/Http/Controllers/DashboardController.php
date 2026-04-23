<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\User;
use App\Models\PointLedger;
use App\Models\Ticket;
use App\Models\SatisfactionRating;



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



    public function helpdesk()
    {
        $tickets = Ticket::with('responses', 'rating')->get();

        // 🔥 RESPONSE TIME
        $responseTimes = [];

        foreach ($tickets as $ticket) {
            $first = $ticket->responses->sortBy('created_at')->first();

            if ($first) {
                $responseTimes[] = $ticket->created_at->diffInMinutes($first->created_at);
            }
        }

        $avgResponse = count($responseTimes)
            ? round(array_sum($responseTimes) / count($responseTimes), 2)
            : 0;

        // 🔥 RESOLUTION TIME
        $closedTickets = $tickets->where('status', 'closed');

        $resolutionTimes = [];

        foreach ($closedTickets as $ticket) {
            $resolutionTimes[] = $ticket->created_at->diffInMinutes($ticket->updated_at);
        }

        $avgResolution = count($resolutionTimes)
            ? round(array_sum($resolutionTimes) / count($resolutionTimes), 2)
            : 0;

        // 🔥 RATING
        $ratings = SatisfactionRating::pluck('score');

        $avgRating = $ratings->count()
            ? round($ratings->avg(), 2)
            : 0;

        return view('dashboard.helpdesk', compact(
            'avgResponse',
            'avgResolution',
            'avgRating',
            'tickets'
        ));
    }
}
