<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PointLedger;
use Illuminate\Support\Facades\DB;

class PointController extends Controller
{
    public function index()
    {
        $users = User::all();

        foreach ($users as $user) {
            $last = PointLedger::where('user_id', $user->id)
                ->latest()
                ->first();

            $user->point = $last ? $last->current_balance : 0;
        }

        return view('points.index', compact('users'));
    }

    public function detail($id)
    {
        $user = User::findOrFail($id);

        $ledgers = PointLedger::where('user_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('points.detail', compact('user', 'ledgers'));
    }

    public function leaderboard()
    {
        $users = User::select(
            'users.*',
            DB::raw('
                (
                    SELECT COALESCE(SUM(amount), 0)
                    FROM point_ledgers
                    WHERE point_ledgers.user_id = users.id
                ) as total_point
            ')
        )
            ->orderByDesc('total_point')
            ->get();

        return view('points.leaderboard', compact('users'));
    }
}
