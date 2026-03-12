<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssessmentCategory;

/**
 * @class AssessmentCategoryController
 * @brief Controller untuk mengelola kategori penilaian.
 *
 * Controller ini menyediakan fungsi CRUD untuk model
 * AssessmentCategory, termasuk menampilkan daftar kategori,
 * membuat, mengedit, menampilkan detail, dan menghapus kategori.
 */
class AssessmentCategoryController extends Controller
{
    /**
     * @brief Menampilkan daftar kategori penilaian.
     *
     * Mengambil data kategori terbaru dan menampilkannya dengan
     * pagination 10 per halaman.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $categories = AssessmentCategory::latest()->paginate(10);

        return view('assessment.index_category', compact('categories'));
    }

    /**
     * @brief Menampilkan form untuk membuat kategori baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('assessment.create_category');
    }

    /**
     * @brief Menyimpan kategori baru ke database.
     *
     * @param Request $request Objek request yang berisi data input.
     * @return \Illuminate\Http\RedirectResponse
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
     * @brief Menampilkan detail kategori tertentu.
     *
     * @param AssessmentCategory $assessmentCategory Model kategori yang dipilih.
     * @return \Illuminate\View\View
     */
    public function show(AssessmentCategory $assessmentCategory)
    {
        return view('assessment_categories.show', compact('assessmentCategory'));
    }

    /**
     * @brief Menampilkan form untuk mengedit kategori.
     *
     * @param AssessmentCategory $assessmentCategory Model kategori yang dipilih.
     * @return \Illuminate\View\View
     */
    public function edit(AssessmentCategory $assessmentCategory)
    {
        return view('assessment.edit_category', compact('assessmentCategory'));
    }

    /**
     * @brief Memperbarui data kategori di database.
     *
     * @param Request $request Objek request yang berisi data input.
     * @param AssessmentCategory $assessmentCategory Model kategori yang dipilih.
     * @return \Illuminate\Http\RedirectResponse
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
     * @brief Menghapus kategori dari database.
     *
     * @param AssessmentCategory $assessmentCategory Model kategori yang dipilih.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(AssessmentCategory $assessmentCategory)
    {
        $assessmentCategory->delete();

        return redirect()
            ->route('assessment-categories.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
}