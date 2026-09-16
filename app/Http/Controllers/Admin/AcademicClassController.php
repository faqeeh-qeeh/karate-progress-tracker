<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicClass;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AcademicClassController extends Controller
{
    /**
     * Simpan Kelas baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'study_program_id' => ['required', 'exists:study_programs,id'],
            'name' => ['required', 'string', 'max:255'],
        ], [
            'study_program_id.required' => 'Program Studi wajib dipilih.',
            'study_program_id.exists' => 'Program Studi tidak valid.',
            'name.required' => 'Nama kelas wajib diisi.',
        ]);

        $academicClass = AcademicClass::create($validated);

        return redirect()->route('admin.departments.index')
            ->with('success', 'Kelas "' . $academicClass->name . '" berhasil ditambahkan.');
    }

    /**
     * Perbarui data Kelas.
     */
    public function update(Request $request, AcademicClass $academicClass): RedirectResponse
    {
        $validated = $request->validate([
            'study_program_id' => ['required', 'exists:study_programs,id'],
            'name' => ['required', 'string', 'max:255'],
        ], [
            'study_program_id.required' => 'Program Studi wajib dipilih.',
            'study_program_id.exists' => 'Program Studi tidak valid.',
            'name.required' => 'Nama kelas wajib diisi.',
        ]);

        $academicClass->update($validated);

        return redirect()->route('admin.departments.index')
            ->with('success', 'Kelas "' . $academicClass->name . '" berhasil diperbarui.');
    }

    /**
     * Hapus Kelas.
     */
    public function destroy(AcademicClass $academicClass): RedirectResponse
    {
        $name = $academicClass->name;
        $academicClass->delete();

        return redirect()->route('admin.departments.index')
            ->with('success', 'Kelas "' . $name . '" berhasil dihapus.');
    }
}
