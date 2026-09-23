<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\LandingSetting;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingPageSettingController extends Controller
{
    /**
     * Tampilkan Halaman Pengaturan Landing Page pada Admin.
     */
    public function index(): View
    {
        $settings = LandingSetting::getAllSettings();

        // Hitung preview real-time untuk data statistik
        $realStats = [
            'kohai_polindra_count' => User::whereHas('role', fn($q) => $q->where('nama', 'Kohai'))
                ->whereHas('kohaiProfile', fn($q) => $q->where('type', 'polindra'))
                ->count(),
            'kohai_all_count' => User::whereHas('role', fn($q) => $q->where('nama', 'Kohai'))->count(),
            'medals_auto_count' => Achievement::where('is_published', true)->count(),
            'events_auto_count' => Achievement::where('is_published', true)->distinct('event_name')->count('event_name'),
            'total_achievements' => Achievement::count(),
            'published_achievements' => Achievement::where('is_published', true)->count(),
        ];

        return view('admin.landing.index', compact('settings', 'realStats'));
    }

    /**
     * Simpan pembaruan pengaturan Landing Page.
     */
    public function updateSettings(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            // Seksi
            'section_hero' => 'nullable|boolean',
            'section_stats' => 'nullable|boolean',
            'section_about' => 'nullable|boolean',
            'section_achievements' => 'nullable|boolean',
            'section_schedule' => 'nullable|boolean',
            'section_gallery' => 'nullable|boolean',
            'section_join' => 'nullable|boolean',
            'section_footer' => 'nullable|boolean',

            // Stat 1: Tahun Berdiri
            'stat_founded_active' => 'nullable|boolean',
            'stat_founded_year' => 'required|integer|min:1950|max:2099',
            'stat_founded_label' => 'required|string|max:50',

            // Stat 2: Anggota Aktif
            'stat_members_active' => 'nullable|boolean',
            'stat_members_mode' => 'required|in:auto_polindra,auto_all,manual',
            'stat_members_custom_value' => 'nullable|integer|min:0',
            'stat_members_suffix' => 'nullable|string|max:10',
            'stat_members_label' => 'required|string|max:50',

            // Stat 3: Medali Kejuaraan
            'stat_medals_active' => 'nullable|boolean',
            'stat_medals_mode' => 'required|in:auto,manual',
            'stat_medals_custom_value' => 'nullable|integer|min:0',
            'stat_medals_suffix' => 'nullable|string|max:10',
            'stat_medals_label' => 'required|string|max:50',

            // Stat 4: Event Diikuti
            'stat_events_active' => 'nullable|boolean',
            'stat_events_mode' => 'required|in:auto,manual',
            'stat_events_value' => 'required|integer|min:0',
            'stat_events_suffix' => 'nullable|string|max:10',
            'stat_events_label' => 'required|string|max:50',
        ]);

        // Simpan toggle seksi
        $sections = [
            'section_hero',
            'section_stats',
            'section_about',
            'section_achievements',
            'section_schedule',
            'section_gallery',
            'section_join',
            'section_footer',
        ];

        foreach ($sections as $sectionKey) {
            $isEnabled = $request->boolean($sectionKey);
            LandingSetting::set($sectionKey, $isEnabled, 'sections', 'boolean');
        }

        // Simpan setting statistik
        LandingSetting::set('stat_founded_active', $request->boolean('stat_founded_active'), 'stats', 'boolean');
        LandingSetting::set('stat_founded_year', (int) $validated['stat_founded_year'], 'stats', 'integer');
        LandingSetting::set('stat_founded_label', $validated['stat_founded_label'], 'stats', 'string');

        LandingSetting::set('stat_members_active', $request->boolean('stat_members_active'), 'stats', 'boolean');
        LandingSetting::set('stat_members_mode', $validated['stat_members_mode'], 'stats', 'string');
        LandingSetting::set('stat_members_custom_value', (int) ($validated['stat_members_custom_value'] ?? 80), 'stats', 'integer');
        LandingSetting::set('stat_members_suffix', $validated['stat_members_suffix'] ?? '+', 'stats', 'string');
        LandingSetting::set('stat_members_label', $validated['stat_members_label'], 'stats', 'string');

        LandingSetting::set('stat_medals_active', $request->boolean('stat_medals_active'), 'stats', 'boolean');
        LandingSetting::set('stat_medals_mode', $validated['stat_medals_mode'], 'stats', 'string');
        LandingSetting::set('stat_medals_custom_value', (int) ($validated['stat_medals_custom_value'] ?? 50), 'stats', 'integer');
        LandingSetting::set('stat_medals_suffix', $validated['stat_medals_suffix'] ?? '+', 'stats', 'string');
        LandingSetting::set('stat_medals_label', $validated['stat_medals_label'], 'stats', 'string');

        LandingSetting::set('stat_events_active', $request->boolean('stat_events_active'), 'stats', 'boolean');
        LandingSetting::set('stat_events_mode', $validated['stat_events_mode'], 'stats', 'string');
        LandingSetting::set('stat_events_value', (int) $validated['stat_events_value'], 'stats', 'integer');
        LandingSetting::set('stat_events_suffix', $validated['stat_events_suffix'] ?? '+', 'stats', 'string');
        LandingSetting::set('stat_events_label', $validated['stat_events_label'], 'stats', 'string');

        return redirect()->route('admin.landing-page.index')
            ->with('success', 'Pengaturan Landing Page berhasil diperbarui!');
    }
}
