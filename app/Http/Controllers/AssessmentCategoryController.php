<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssessmentCategory;

class AssessmentCategoryController extends Controller
{
    /**
     * Display list kategori
     */
    public function index()
    {
        $categories = AssessmentCategory::latest()->paginate(10);

        return view('assessment.index_category', compact('categories'));
    }

    /**
     * Form create
     */
    public function create()
    {
        return view('assessment.create_category');
    }

    /**
     * Simpan kategori baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string',
        ]);

        AssessmentCategory::create([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('assessment-categories.index')
            ->with('success', 'Kategori berhasil dibuat');
    }

    /**
     * Detail kategori
     */
    public function show(AssessmentCategory $assessmentCategory)
    {
        return view('assessment_categories.show', compact('assessmentCategory'));
    }

    /**
     * Form edit
     */
    public function edit(AssessmentCategory $assessmentCategory)
    {
        return view('assessment.edit_category', compact('assessmentCategory'));
    }

    /**
     * Update kategori
     */
    public function update(Request $request, AssessmentCategory $assessmentCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'nullable|string|max:100',
        ]);

        $assessmentCategory->update([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('assessment-categories.index')
            ->with('success', 'Kategori berhasil diupdate');
    }

    /**
     * Hapus kategori
     */
    public function destroy(AssessmentCategory $assessmentCategory)
    {
        $assessmentCategory->delete();

        return redirect()
            ->route('assessment-categories.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
}
