<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\LandingSetting;
use App\Models\TrainingSchedule;
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
            'total_schedules' => TrainingSchedule::count(),
            'active_schedules' => TrainingSchedule::where('is_active', true)->count(),
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

            // Seksi Jadwal Latihan (Schedule)
            'schedule_badge_label' => 'required|string|max:50',
            'schedule_title_1' => 'required|string|max:100',
            'schedule_title_highlight' => 'required|string|max:100',
            'schedule_title_2' => 'required|string|max:100',
            'schedule_description' => 'required|string|max:1000',
            'schedule_location_name' => 'required|string|max:150',
            'schedule_location_address' => 'required|string|max:255',
            'schedule_maps_url' => 'nullable|url|max:500',

            // Seksi Galeri Momen (Gallery)
            'gallery_badge_label' => 'required|string|max:50',
            'gallery_title_1' => 'required|string|max:100',
            'gallery_title_highlight' => 'required|string|max:100',
            'gallery_description' => 'required|string|max:1000',
            'gallery_item_1_label' => 'required|string|max:100',
            'gallery_item_1_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'delete_gallery_item_1_image' => 'nullable|boolean',
            'gallery_item_2_label' => 'required|string|max:100',
            'gallery_item_2_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'delete_gallery_item_2_image' => 'nullable|boolean',
            'gallery_item_3_label' => 'required|string|max:100',
            'gallery_item_3_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'delete_gallery_item_3_image' => 'nullable|boolean',
            'gallery_item_4_label' => 'required|string|max:100',
            'gallery_item_4_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'delete_gallery_item_4_image' => 'nullable|boolean',
            'gallery_item_5_label' => 'required|string|max:100',
            'gallery_item_5_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'delete_gallery_item_5_image' => 'nullable|boolean',

            // Seksi Footer & Media Sosial
            'footer_description' => 'required|string|max:500',
            'footer_instagram_url' => 'nullable|url|max:255',
            'footer_youtube_url' => 'nullable|url|max:255',
            'footer_tiktok_url' => 'nullable|url|max:255',
            'footer_whatsapp_url' => 'nullable|url|max:255',
            'footer_email' => 'required|email|max:100',
            'footer_address' => 'required|string|max:255',
            'footer_copyright' => 'required|string|max:255',
        ], [
            'about_image.max' => 'Ukuran foto Tentang Kami maksimal 5 MB.',
            'about_image.image' => 'File foto Tentang Kami harus berupa gambar (JPG, JPEG, PNG, WEBP).',
            'gallery_item_1_image.max' => 'Ukuran foto Galeri Slot 01 maksimal 5 MB.',
            'gallery_item_1_image.image' => 'File foto Galeri Slot 01 harus berupa gambar (JPG, JPEG, PNG, WEBP).',
            'gallery_item_2_image.max' => 'Ukuran foto Galeri Slot 02 maksimal 5 MB.',
            'gallery_item_2_image.image' => 'File foto Galeri Slot 02 harus berupa gambar (JPG, JPEG, PNG, WEBP).',
            'gallery_item_3_image.max' => 'Ukuran foto Galeri Slot 03 maksimal 5 MB.',
            'gallery_item_3_image.image' => 'File foto Galeri Slot 03 harus berupa gambar (JPG, JPEG, PNG, WEBP).',
            'gallery_item_4_image.max' => 'Ukuran foto Galeri Slot 04 maksimal 5 MB.',
            'gallery_item_4_image.image' => 'File foto Galeri Slot 04 harus berupa gambar (JPG, JPEG, PNG, WEBP).',
            'gallery_item_5_image.max' => 'Ukuran foto Galeri Slot 05 maksimal 5 MB.',
            'gallery_item_5_image.image' => 'File foto Galeri Slot 05 harus berupa gambar (JPG, JPEG, PNG, WEBP).',
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

        // Simpan setting Jadwal Latihan (Schedule)
        LandingSetting::set('schedule_badge_label', $validated['schedule_badge_label'], 'schedule', 'string');
        LandingSetting::set('schedule_title_1', $validated['schedule_title_1'], 'schedule', 'string');
        LandingSetting::set('schedule_title_highlight', $validated['schedule_title_highlight'], 'schedule', 'string');
        LandingSetting::set('schedule_title_2', $validated['schedule_title_2'], 'schedule', 'string');
        LandingSetting::set('schedule_description', $validated['schedule_description'], 'schedule', 'string');
        LandingSetting::set('schedule_location_name', $validated['schedule_location_name'], 'schedule', 'string');
        LandingSetting::set('schedule_location_address', $validated['schedule_location_address'], 'schedule', 'string');
        LandingSetting::set('schedule_maps_url', $validated['schedule_maps_url'] ?? '', 'schedule', 'string');

        // Simpan setting Galeri Momen (Gallery)
        LandingSetting::set('gallery_badge_label', $validated['gallery_badge_label'], 'gallery', 'string');
        LandingSetting::set('gallery_title_1', $validated['gallery_title_1'], 'gallery', 'string');
        LandingSetting::set('gallery_title_highlight', $validated['gallery_title_highlight'], 'gallery', 'string');
        LandingSetting::set('gallery_description', $validated['gallery_description'], 'gallery', 'string');

        $uploadDir = public_path('uploads/landing');
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Simpan 5 Item Galeri (Label & Gambar)
        for ($i = 1; $i <= 5; $i++) {
            LandingSetting::set("gallery_item_{$i}_label", $validated["gallery_item_{$i}_label"], 'gallery', 'string');

            // Handle delete/reset image to default
            if ($request->boolean("delete_gallery_item_{$i}_image")) {
                $currentImg = LandingSetting::get("gallery_item_{$i}_image");
                if ($currentImg && str_starts_with($currentImg, 'uploads/') && file_exists(public_path($currentImg))) {
                    @unlink(public_path($currentImg));
                }
                LandingSetting::set("gallery_item_{$i}_image", null, 'gallery', 'string');
            }

            // Handle new upload
            if ($request->hasFile("gallery_item_{$i}_image") && $request->file("gallery_item_{$i}_image")->isValid()) {
                $currentImg = LandingSetting::get("gallery_item_{$i}_image");
                if ($currentImg && str_starts_with($currentImg, 'uploads/') && file_exists(public_path($currentImg))) {
                    @unlink(public_path($currentImg));
                }

                $file = $request->file("gallery_item_{$i}_image");
                $fileName = "gallery_{$i}_" . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($uploadDir, $fileName);

                LandingSetting::set("gallery_item_{$i}_image", 'uploads/landing/' . $fileName, 'gallery', 'string');
            }
        }

        // Simpan setting Footer & Media Sosial
        LandingSetting::set('footer_description', $validated['footer_description'], 'footer', 'string');
        LandingSetting::set('footer_instagram_url', $validated['footer_instagram_url'] ?? '', 'footer', 'string');
        LandingSetting::set('footer_youtube_url', $validated['footer_youtube_url'] ?? '', 'footer', 'string');
        LandingSetting::set('footer_tiktok_url', $validated['footer_tiktok_url'] ?? '', 'footer', 'string');
        LandingSetting::set('footer_whatsapp_url', $validated['footer_whatsapp_url'] ?? '', 'footer', 'string');
        LandingSetting::set('footer_email', $validated['footer_email'], 'footer', 'string');
        LandingSetting::set('footer_address', $validated['footer_address'], 'footer', 'string');
        LandingSetting::set('footer_copyright', $validated['footer_copyright'], 'footer', 'string');

        return redirect()->route('admin.landing-page.index')
            ->with('success', 'Pengaturan Landing Page berhasil diperbarui!');
    }
}
