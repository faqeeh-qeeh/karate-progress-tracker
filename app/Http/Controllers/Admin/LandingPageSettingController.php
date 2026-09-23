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
            'stat_events_value' => 'nullable|integer|min:0',
            'stat_events_suffix' => 'nullable|string|max:10',
            'stat_events_label' => 'required|string|max:50',

            // Seksi Tentang Kami (About Us)
            'about_badge_label' => 'required|string|max:50',
            'about_title_1' => 'required|string|max:100',
            'about_title_2' => 'required|string|max:100',
            'about_title_highlight' => 'required|string|max:100',
            'about_description_1' => 'required|string|max:1000',
            'about_description_2' => 'nullable|string|max:1000',
            'about_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'delete_about_image' => 'nullable|boolean',

            // 4 Pilar Latihan
            'about_pillar_1_active' => 'nullable|boolean',
            'about_pillar_1_icon' => 'required|string|max:20',
            'about_pillar_1_title' => 'required|string|max:50',
            'about_pillar_1_desc' => 'required|string|max:255',

            'about_pillar_2_active' => 'nullable|boolean',
            'about_pillar_2_icon' => 'required|string|max:20',
            'about_pillar_2_title' => 'required|string|max:50',
            'about_pillar_2_desc' => 'required|string|max:255',

            'about_pillar_3_active' => 'nullable|boolean',
            'about_pillar_3_icon' => 'required|string|max:20',
            'about_pillar_3_title' => 'required|string|max:50',
            'about_pillar_3_desc' => 'required|string|max:255',

            'about_pillar_4_active' => 'nullable|boolean',
            'about_pillar_4_icon' => 'required|string|max:20',
            'about_pillar_4_title' => 'required|string|max:50',
            'about_pillar_4_desc' => 'required|string|max:255',
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
        LandingSetting::set('stat_events_value', (int) ($validated['stat_events_value'] ?? 20), 'stats', 'integer');
        LandingSetting::set('stat_events_suffix', $validated['stat_events_suffix'] ?? '+', 'stats', 'string');
        LandingSetting::set('stat_events_label', $validated['stat_events_label'], 'stats', 'string');

        // Simpan setting Tentang Kami (About Us)
        LandingSetting::set('about_badge_label', $validated['about_badge_label'], 'about', 'string');
        LandingSetting::set('about_title_1', $validated['about_title_1'], 'about', 'string');
        LandingSetting::set('about_title_2', $validated['about_title_2'], 'about', 'string');
        LandingSetting::set('about_title_highlight', $validated['about_title_highlight'], 'about', 'string');
        LandingSetting::set('about_description_1', $validated['about_description_1'], 'about', 'string');
        LandingSetting::set('about_description_2', $validated['about_description_2'] ?? '', 'about', 'string');

        // Handle hapus/reset gambar Tentang Kami jika diminta
        if ($request->boolean('delete_about_image')) {
            $currentImage = LandingSetting::get('about_image');
            if ($currentImage && str_starts_with($currentImage, 'uploads/') && file_exists(public_path($currentImage))) {
                @unlink(public_path($currentImage));
            }
            LandingSetting::set('about_image', null, 'about', 'string');
        }

        // Handle upload gambar baru Tentang Kami (gantikan & hapus gambar lama)
        if ($request->hasFile('about_image') && $request->file('about_image')->isValid()) {
            $currentImage = LandingSetting::get('about_image');
            if ($currentImage && str_starts_with($currentImage, 'uploads/') && file_exists(public_path($currentImage))) {
                @unlink(public_path($currentImage));
            }

            $file = $request->file('about_image');
            $uploadDir = public_path('uploads/landing');
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $fileName = 'about_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $fileName);

            LandingSetting::set('about_image', 'uploads/landing/' . $fileName, 'about', 'string');
        }

        // Simpan 4 Pilar beserta status aktifnya
        for ($i = 1; $i <= 4; $i++) {
            LandingSetting::set("about_pillar_{$i}_active", $request->boolean("about_pillar_{$i}_active"), 'about', 'boolean');
            LandingSetting::set("about_pillar_{$i}_icon", $validated["about_pillar_{$i}_icon"], 'about', 'string');
            LandingSetting::set("about_pillar_{$i}_title", $validated["about_pillar_{$i}_title"], 'about', 'string');
            LandingSetting::set("about_pillar_{$i}_desc", $validated["about_pillar_{$i}_desc"], 'about', 'string');
        }

        return redirect()->route('admin.landing-page.index')
            ->with('success', 'Pengaturan Landing Page (Statistik & Tentang Kami) berhasil diperbarui!');
    }
}
