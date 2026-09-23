<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AchievementController extends Controller
{
    /**
     * Tampilkan daftar prestasi kejuaraan.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $medalFilter = $request->input('medal');
        $statusFilter = $request->input('status');

        $query = Achievement::with('user')->ordered();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('event_name', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhere('athlete_name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($medalFilter) {
            $query->where('medal_type', $medalFilter);
        }

        if ($statusFilter !== null && $statusFilter !== '') {
            $query->where('is_published', $statusFilter === '1');
        }

        $achievements = $query->paginate(10)->withQueryString();

        // Ambil daftar atlet / anggota (Kohai & Senpai) untuk opsi dropdown user_id
        $athletes = User::whereHas('role', fn($q) => $q->whereIn('nama', ['Kohai', 'Senpai', 'admin']))
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        $stats = [
            'total' => Achievement::count(),
            'gold' => Achievement::where('medal_type', 'gold')->count(),
            'silver' => Achievement::where('medal_type', 'silver')->count(),
            'bronze' => Achievement::where('medal_type', 'bronze')->count(),
            'published' => Achievement::where('is_published', true)->count(),
        ];

        return view('admin.achievements.index', compact('achievements', 'athletes', 'stats'));
    }

    /**
     * Simpan data prestasi kejuaraan baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'athlete_name' => 'nullable|string|max:100',
            'event_name' => 'required|string|max:150',
            'title' => 'required|string|max:150',
            'medal_type' => 'required|in:gold,silver,bronze,trophy,other',
            'event_date' => 'nullable|date',
            'location' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:1000',
            'is_featured' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_published'] = $request->has('is_published') ? $request->boolean('is_published') : true;
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);

        Achievement::create($validated);

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Data prestasi kejuaraan berhasil ditambahkan!');
    }

    /**
     * Perbarui data prestasi kejuaraan.
     */
    public function update(Request $request, Achievement $achievement): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'athlete_name' => 'nullable|string|max:100',
            'event_name' => 'required|string|max:150',
            'title' => 'required|string|max:150',
            'medal_type' => 'required|in:gold,silver,bronze,trophy,other',
            'event_date' => 'nullable|date',
            'location' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:1000',
            'is_featured' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_published'] = $request->boolean('is_published');
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);

        $achievement->update($validated);

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Data prestasi kejuaraan berhasil diperbarui!');
    }

    /**
     * Hapus data prestasi kejuaraan.
     */
    public function destroy(Achievement $achievement): RedirectResponse
    {
        $achievement->delete();

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Data prestasi kejuaraan berhasil dihapus!');
    }

    /**
     * Toggle status publikasi prestasi kejuaraan.
     */
    public function togglePublish(Achievement $achievement): RedirectResponse|JsonResponse
    {
        $achievement->is_published = !$achievement->is_published;
        $achievement->save();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_published' => $achievement->is_published,
                'message' => 'Status publikasi berhasil diubah.',
            ]);
        }

        return redirect()->back()->with('success', 'Status publikasi berhasil diperbarui!');
    }

    /**
     * Toggle status featured kejuaraan.
     */
    public function toggleFeatured(Achievement $achievement): RedirectResponse|JsonResponse
    {
        $achievement->is_featured = !$achievement->is_featured;
        $achievement->save();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_featured' => $achievement->is_featured,
                'message' => 'Status sorotan (featured) berhasil diubah.',
            ]);
        }

        return redirect()->back()->with('success', 'Status sorotan (featured) berhasil diperbarui!');
    }
}
