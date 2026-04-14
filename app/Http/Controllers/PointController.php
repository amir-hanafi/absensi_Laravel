<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PointLedger;

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
}
