<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PointRule;
use Carbon\Carbon;

class PointRuleController extends Controller
{
    public function index()
    {
        $rules = PointRule::all();
        return view('rule_points.index', compact('rules'));
    }

    public function store(Request $request)
    {
        if ($request->condition_operator == 'between') {

            if (!$request->value1 || !$request->value2) {
                return back()->with('error', 'Range waktu harus lengkap');
            }

            $value1 = Carbon::parse($request->value1)->format('H:i:s');
            $value2 = Carbon::parse($request->value2)->format('H:i:s');

            $condition_value = $value1 . '-' . $value2;
        } else {

            if (!$request->value1) {
                return back()->with('error', 'Waktu harus diisi');
            }

            $value1 = Carbon::parse($request->value1)->format('H:i:s');

            $condition_value = $value1;
        }

        PointRule::create([
            'rule_name' => $request->rule_name,
            'condition_operator' => $request->condition_operator,
            'condition_value' => $condition_value,
            'point_modifier' => $request->point_modifier,
        ]);

        return redirect()->back()->with('success', 'Rule berhasil dibuat');
    }

    public function destroy($id)
    {
        PointRule::findOrFail($id)->delete();
        return back()->with('success', 'Rule dihapus');
    }

    public function update(Request $request, $id)
    {
        $rule = PointRule::findOrFail($id);

        if ($request->condition_operator == 'between') {
            $value1 = Carbon::parse($request->value1)->format('H:i:s');
            $value2 = Carbon::parse($request->value2)->format('H:i:s');

            $condition_value = $value1 . '-' . $value2;
        } else {
            $value1 = Carbon::parse($request->value1)->format('H:i:s');

            $condition_value = $value1;
        }

        $rule->update([
            'rule_name' => $request->rule_name,
            'condition_operator' => $request->condition_operator,
            'condition_value' => $condition_value,
            'point_modifier' => $request->point_modifier,
        ]);

        // 🔥 INI YANG PENTING
        return redirect()->route('point-rules.index')
            ->with('success', 'Rule berhasil diupdate');
    }

    public function edit($id)
    {
        $rule = PointRule::findOrFail($id);
        return view('rule_points.edit', compact('rule'));
    }
}
