<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudyProgram;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StudyProgramController extends Controller
{
    /**
     * Simpan Program Studi baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'department_id' => ['required', 'exists:departments,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'department_id.required' => 'Jurusan wajib dipilih.',
            'department_id.exists' => 'Jurusan tidak valid.',
            'name.required' => 'Nama program studi wajib diisi.',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $prodi = StudyProgram::create($validated);

        return redirect()->route('admin.departments.index')
            ->with('success', 'Program Studi "' . $prodi->name . '" berhasil ditambahkan.');
    }

    /**
     * Perbarui data Program Studi.
     */
    public function update(Request $request, StudyProgram $studyProgram): RedirectResponse
    {
        $validated = $request->validate([
            'department_id' => ['required', 'exists:departments,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'department_id.required' => 'Jurusan wajib dipilih.',
            'department_id.exists' => 'Jurusan tidak valid.',
            'name.required' => 'Nama program studi wajib diisi.',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $studyProgram->update($validated);

        return redirect()->route('admin.departments.index')
            ->with('success', 'Program Studi "' . $studyProgram->name . '" berhasil diperbarui.');
    }

    /**
     * Hapus Program Studi.
     */
    public function destroy(StudyProgram $studyProgram): RedirectResponse
    {
        $name = $studyProgram->name;
        $studyProgram->delete();

        return redirect()->route('admin.departments.index')
            ->with('success', 'Program Studi "' . $name . '" beserta kelas di dalamnya berhasil dihapus.');
    }
}
