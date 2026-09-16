<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicClass;
use App\Models\Department;
use App\Models\StudyProgram;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    /**
     * Tampilkan daftar master Jurusan, Program Studi, dan Kelas.
     */
    public function index(Request $request): View
    {
        $query = Department::with(['studyPrograms.academicClasses' => function ($q) {
            $q->orderBy('name', 'asc');
        }])->withCount('studyPrograms');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        $departments = $query->latest()->get();

        // Statistik
        $totalDepartments = $departments->count();
        $totalStudyPrograms = StudyProgram::count();
        $totalClasses = AcademicClass::count();

        return view('admin.academic.index', compact(
            'departments',
            'totalDepartments',
            'totalStudyPrograms',
            'totalClasses'
        ));
    }

    /**
     * Simpan jurusan baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:departments,name'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'name.required' => 'Nama jurusan wajib diisi.',
            'name.unique' => 'Nama jurusan ini sudah terdaftar.',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $department = Department::create($validated);

        return redirect()->route('admin.departments.index')
            ->with('success', 'Jurusan "' . $department->name . '" berhasil ditambahkan.');
    }

    /**
     * Perbarui data jurusan.
     */
    public function update(Request $request, Department $department): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:departments,name,' . $department->id],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'name.required' => 'Nama jurusan wajib diisi.',
            'name.unique' => 'Nama jurusan ini sudah terdaftar pada data lain.',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $department->update($validated);

        return redirect()->route('admin.departments.index')
            ->with('success', 'Jurusan "' . $department->name . '" berhasil diperbarui.');
    }

    /**
     * Hapus jurusan beserta program studi dan kelas terkait.
     */
    public function destroy(Department $department): RedirectResponse
    {
        $name = $department->name;
        $department->delete();

        return redirect()->route('admin.departments.index')
            ->with('success', 'Jurusan "' . $name . '" beserta prodi dan kelas di dalamnya berhasil dihapus.');
    }
}
