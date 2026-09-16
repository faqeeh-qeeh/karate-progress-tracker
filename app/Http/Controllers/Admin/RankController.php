<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rank;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RankController extends Controller
{
    /**
     * Simpan tingkatan sabuk baru ke basis data.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'belt_id' => ['required', 'exists:belts,id'],
            'category' => ['required', 'in:Kyu,Dan'],
            'name' => ['required', 'string', 'max:255'],
            'order' => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string'],
        ], [
            'belt_id.required' => 'Sabuk wajib dipilih.',
            'belt_id.exists' => 'Sabuk yang dipilih tidak valid.',
            'category.required' => 'Kategori (Kyu / Dan) wajib dipilih.',
            'category.in' => 'Kategori harus Kyu atau Dan.',
            'name.required' => 'Nama tingkatan wajib diisi.',
            'order.required' => 'Urutan tingkatan wajib diisi.',
            'order.integer' => 'Urutan harus berupa angka bulat positif.',
        ]);

        $rank = Rank::create($validated);

        return redirect()->route('admin.belts.index')
            ->with('success', 'Tingkatan "' . $rank->name . '" (' . $rank->category . ') berhasil ditambahkan.');
    }

    /**
     * Perbarui data tingkatan sabuk.
     */
    public function update(Request $request, Rank $rank): RedirectResponse
    {
        $validated = $request->validate([
            'belt_id' => ['required', 'exists:belts,id'],
            'category' => ['required', 'in:Kyu,Dan'],
            'name' => ['required', 'string', 'max:255'],
            'order' => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string'],
        ], [
            'belt_id.required' => 'Sabuk wajib dipilih.',
            'belt_id.exists' => 'Sabuk yang dipilih tidak valid.',
            'category.required' => 'Kategori (Kyu / Dan) wajib dipilih.',
            'category.in' => 'Kategori harus Kyu atau Dan.',
            'name.required' => 'Nama tingkatan wajib diisi.',
            'order.required' => 'Urutan tingkatan wajib diisi.',
            'order.integer' => 'Urutan harus berupa angka bulat positif.',
        ]);

        $rank->update($validated);

        return redirect()->route('admin.belts.index')
            ->with('success', 'Tingkatan "' . $rank->name . '" berhasil diperbarui.');
    }

    /**
     * Hapus tingkatan sabuk.
     */
    public function destroy(Rank $rank): RedirectResponse
    {
        $rankName = $rank->name;
        $rank->delete();

        return redirect()->route('admin.belts.index')
            ->with('success', 'Tingkatan "' . $rankName . '" berhasil dihapus.');
    }
}
