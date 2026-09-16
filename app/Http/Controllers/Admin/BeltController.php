<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Belt;
use App\Models\Rank;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BeltController extends Controller
{
    /**
     * Tampilkan daftar master sabuk dan tingkatannya.
     */
    public function index(Request $request): View
    {
        $query = Belt::with(['ranks' => function ($q) {
            $q->orderBy('order', 'asc');
        }])->withCount('ranks');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        $belts = $query->get();

        // Statistik
        $totalBelts = $belts->count();
        $totalRanks = Rank::count();
        $totalKyu = Rank::where('category', 'Kyu')->count();
        $totalDan = Rank::where('category', 'Dan')->count();

        return view('admin.belts.index', compact(
            'belts',
            'totalBelts',
            'totalRanks',
            'totalKyu',
            'totalDan'
        ));
    }

    /**
     * Tampilkan form pembuatan master sabuk baru.
     */
    public function create(): View
    {
        return view('admin.belts.create');
    }

    /**
     * Simpan master sabuk baru ke basis data.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:belts,name'],
            'color_code' => ['nullable', 'string', 'max:30'],
            'description' => ['nullable', 'string'],
        ], [
            'name.required' => 'Nama sabuk wajib diisi.',
            'name.unique' => 'Nama sabuk tersebut sudah terdaftar.',
        ]);

        $belt = Belt::create($validated);

        return redirect()->route('admin.belts.index')
            ->with('success', 'Master Sabuk "' . $belt->name . '" berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit master sabuk.
     */
    public function edit(Belt $belt): View
    {
        return view('admin.belts.edit', compact('belt'));
    }

    /**
     * Perbarui data master sabuk di basis data.
     */
    public function update(Request $request, Belt $belt): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:belts,name,' . $belt->id],
            'color_code' => ['nullable', 'string', 'max:30'],
            'description' => ['nullable', 'string'],
        ], [
            'name.required' => 'Nama sabuk wajib diisi.',
            'name.unique' => 'Nama sabuk tersebut sudah digunakan oleh sabuk lain.',
        ]);

        $belt->update($validated);

        return redirect()->route('admin.belts.index')
            ->with('success', 'Data Master Sabuk "' . $belt->name . '" berhasil diperbarui.');
    }

    /**
     * Hapus master sabuk beserta seluruh tingkatannya.
     */
    public function destroy(Belt $belt): RedirectResponse
    {
        $beltName = $belt->name;
        $belt->delete();

        return redirect()->route('admin.belts.index')
            ->with('success', 'Master Sabuk "' . $beltName . '" dan seluruh tingkatannya berhasil dihapus.');
    }
}
