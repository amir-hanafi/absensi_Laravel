<?php

namespace App\Http\Controllers;

use App\Models\FlexibilityItem;
use App\Models\PointLedger;
use App\Models\UserToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MarketplaceController extends Controller
{
    public function index()
    {
        $items = FlexibilityItem::all();

        return view('marketplace.index', compact('items'));
    }


    public function buy($id)
    {
        return DB::transaction(function () use ($id) {

            $userId = Auth::id();

            $hasAvailableToken = UserToken::where('user_id', $userId)
                ->where('status', 'AVAILABLE')
                ->exists();

            if ($hasAvailableToken) {
                return response()->json([
                    'message' => 'Masih ada token yang belum digunakan'
                ], 400);
            }

            $item = FlexibilityItem::findOrFail($id);

            $last = PointLedger::where('user_id', $userId)->latest()->first();
            $balance = $last ? $last->current_balance : 0;

            if ($balance < $item->point_cost) {
                return response()->json([
                    'message' => 'Poin tidak cukup'
                ], 400);
            }

            $newBalance = $balance - $item->point_cost;

            PointLedger::create([
                'user_id' => $userId,
                'transaction_type' => 'SPEND',
                'amount' => -$item->point_cost,
                'current_balance' => $newBalance,
                'description' => 'Beli ' . $item->item_name,
            ]);

            UserToken::create([
                'user_id' => $userId,
                'item_id' => $item->id,
                'status' => 'AVAILABLE',
            ]);

            return response()->json([
                'message' => 'Berhasil membeli'
            ]);
        });
    }

    public function getPoints()
    {
        $userId = Auth::id();

        $last = PointLedger::where('user_id', $userId)
            ->latest()
            ->first();

        return response()->json([
            'points' => $last ? $last->current_balance : 0
        ]);
    }

    public function getTokens()
    {
        $userId = Auth::id();

        $tokens = UserToken::where('user_id', $userId)
            ->where('status', 'AVAILABLE')
            ->with('item') // relasi ke item
            ->get()
            ->map(function ($token) {
                return [
                    'id' => $token->id,
                    'item_name' => $token->item->item_name
                ];
            });

        return response()->json([
            'tokens' => $tokens
        ]);
    }

    public function getLedger()
    {
        $userId = Auth::id();

        $ledgers = PointLedger::where('user_id', $userId)
            ->latest()
            ->get()
            ->map(function ($item) {
                return [
                    'type' => $item->transaction_type,
                    'amount' => $item->amount,
                    'description' => $item->description,
                    'date' => $item->created_at->format('d M Y H:i')
                ];
            });

        return response()->json([
            'data' => $ledgers
        ]);
    }
}
