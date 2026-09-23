<?php

namespace Database\Seeders;

use App\Models\LandingSetting;
use Illuminate\Database\Seeder;

class LandingSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // ── Section Visibility Toggles ───────────────────
            ['key' => 'section_hero', 'value' => true, 'group' => 'sections', 'type' => 'boolean'],
            ['key' => 'section_stats', 'value' => true, 'group' => 'sections', 'type' => 'boolean'],
            ['key' => 'section_about', 'value' => true, 'group' => 'sections', 'type' => 'boolean'],
            ['key' => 'section_achievements', 'value' => true, 'group' => 'sections', 'type' => 'boolean'],
            ['key' => 'section_schedule', 'value' => true, 'group' => 'sections', 'type' => 'boolean'],
            ['key' => 'section_gallery', 'value' => true, 'group' => 'sections', 'type' => 'boolean'],
            ['key' => 'section_join', 'value' => true, 'group' => 'sections', 'type' => 'boolean'],
            ['key' => 'section_footer', 'value' => true, 'group' => 'sections', 'type' => 'boolean'],

            // ── Stat Item 1: Tahun Berdiri ───────────────────
            ['key' => 'stat_founded_active', 'value' => true, 'group' => 'stats', 'type' => 'boolean'],
            ['key' => 'stat_founded_year', 'value' => 2016, 'group' => 'stats', 'type' => 'integer'],
            ['key' => 'stat_founded_label', 'value' => 'Tahun Berdiri', 'group' => 'stats', 'type' => 'string'],

            // ── Stat Item 2: Anggota Aktif ───────────────────
            ['key' => 'stat_members_active', 'value' => true, 'group' => 'stats', 'type' => 'boolean'],
            ['key' => 'stat_members_mode', 'value' => 'auto_polindra', 'group' => 'stats', 'type' => 'string'], // 'auto_polindra', 'auto_all', 'manual'
            ['key' => 'stat_members_custom_value', 'value' => 80, 'group' => 'stats', 'type' => 'integer'],
            ['key' => 'stat_members_suffix', 'value' => '+', 'group' => 'stats', 'type' => 'string'],
            ['key' => 'stat_members_label', 'value' => 'Anggota Aktif', 'group' => 'stats', 'type' => 'string'],

            // ── Stat Item 3: Medali Kejuaraan ────────────────
            ['key' => 'stat_medals_active', 'value' => true, 'group' => 'stats', 'type' => 'boolean'],
            ['key' => 'stat_medals_mode', 'value' => 'manual', 'group' => 'stats', 'type' => 'string'], // 'auto', 'manual'
            ['key' => 'stat_medals_custom_value', 'value' => 50, 'group' => 'stats', 'type' => 'integer'],
            ['key' => 'stat_medals_suffix', 'value' => '+', 'group' => 'stats', 'type' => 'string'],
            ['key' => 'stat_medals_label', 'value' => 'Medali Kejuaraan', 'group' => 'stats', 'type' => 'string'],

            // ── Stat Item 4: Event Diikuti ───────────────────
            ['key' => 'stat_events_active', 'value' => true, 'group' => 'stats', 'type' => 'boolean'],
            ['key' => 'stat_events_mode', 'value' => 'manual', 'group' => 'stats', 'type' => 'string'], // 'auto', 'manual'
            ['key' => 'stat_events_value', 'value' => 20, 'group' => 'stats', 'type' => 'integer'],
            ['key' => 'stat_events_suffix', 'value' => '+', 'group' => 'stats', 'type' => 'string'],
            ['key' => 'stat_events_label', 'value' => 'Event Diikuti', 'group' => 'stats', 'type' => 'string'],

            // ── Section Tentang Kami (About Us) ───────────────
            ['key' => 'about_badge_label', 'value' => 'Tentang Kami', 'group' => 'about', 'type' => 'string'],
            ['key' => 'about_title_1', 'value' => 'Disiplin', 'group' => 'about', 'type' => 'string'],
            ['key' => 'about_title_2', 'value' => 'Membentuk', 'group' => 'about', 'type' => 'string'],
            ['key' => 'about_title_highlight', 'value' => 'Juara', 'group' => 'about', 'type' => 'string'],
            ['key' => 'about_description_1', 'value' => 'UKM Karate Politeknik Negeri Indramayu adalah wadah resmi bagi mahasiswa yang ingin mengembangkan kemampuan bela diri karate di lingkungan kampus. Kami bernaung di bawah WKF (World Karate Federation) dan aktif mengikuti berbagai kejuaraan tingkat regional maupun nasional.', 'group' => 'about', 'type' => 'string'],
            ['key' => 'about_description_2', 'value' => 'Dengan pelatih berpengalaman dan program latihan terstruktur, kami memastikan setiap anggota berkembang — baik dalam teknik, mental, maupun karakter.', 'group' => 'about', 'type' => 'string'],
            ['key' => 'about_image', 'value' => null, 'group' => 'about', 'type' => 'string'],

            // ── 4 Pilar Latihan ──────────────────────────────
            ['key' => 'about_pillar_1_active', 'value' => true, 'group' => 'about', 'type' => 'boolean'],
            ['key' => 'about_pillar_1_icon', 'value' => '⚡', 'group' => 'about', 'type' => 'string'],
            ['key' => 'about_pillar_1_title', 'value' => 'Kihon', 'group' => 'about', 'type' => 'string'],
            ['key' => 'about_pillar_1_desc', 'value' => 'Latihan teknik dasar yang konsisten setiap sesi', 'group' => 'about', 'type' => 'string'],

            ['key' => 'about_pillar_2_active', 'value' => true, 'group' => 'about', 'type' => 'boolean'],
            ['key' => 'about_pillar_2_icon', 'value' => '🥋', 'group' => 'about', 'type' => 'string'],
            ['key' => 'about_pillar_2_title', 'value' => 'Kata', 'group' => 'about', 'type' => 'string'],
            ['key' => 'about_pillar_2_desc', 'value' => 'Rangkaian gerakan terstandar sebagai fondasi seni', 'group' => 'about', 'type' => 'string'],

            ['key' => 'about_pillar_3_active', 'value' => true, 'group' => 'about', 'type' => 'boolean'],
            ['key' => 'about_pillar_3_icon', 'value' => '🥊', 'group' => 'about', 'type' => 'string'],
            ['key' => 'about_pillar_3_title', 'value' => 'Kumite', 'group' => 'about', 'type' => 'string'],
            ['key' => 'about_pillar_3_desc', 'value' => 'Pertarungan terkontrol untuk mengasah insting & refleks', 'group' => 'about', 'type' => 'string'],

            ['key' => 'about_pillar_4_active', 'value' => true, 'group' => 'about', 'type' => 'boolean'],
            ['key' => 'about_pillar_4_icon', 'value' => '🏆', 'group' => 'about', 'type' => 'string'],
            ['key' => 'about_pillar_4_title', 'value' => 'Kompetisi', 'group' => 'about', 'type' => 'string'],
            ['key' => 'about_pillar_4_desc', 'value' => 'Mengikuti kejuaraan sebagai uji kemampuan nyata', 'group' => 'about', 'type' => 'string'],

            // ── Section Jadwal Latihan (Schedule) ──────────────
            ['key' => 'schedule_badge_label', 'value' => 'Latihan Rutin', 'group' => 'schedule', 'type' => 'string'],
            ['key' => 'schedule_title_1', 'value' => 'Jadwal', 'group' => 'schedule', 'type' => 'string'],
            ['key' => 'schedule_title_highlight', 'value' => 'Berlatih', 'group' => 'schedule', 'type' => 'string'],
            ['key' => 'schedule_title_2', 'value' => 'Mingguan', 'group' => 'schedule', 'type' => 'string'],
            ['key' => 'schedule_description', 'value' => 'Latihan terbuka untuk mahasiswa aktif Polindra. Pemula sangat dipersilakan — kami mulai dari nol bersama.', 'group' => 'schedule', 'type' => 'string'],
            ['key' => 'schedule_location_name', 'value' => 'GOR / Hall Olahraga Polindra', 'group' => 'schedule', 'type' => 'string'],
            ['key' => 'schedule_location_address', 'value' => 'Jl. Lohbener Lama No. 08, Indramayu, Jawa Barat', 'group' => 'schedule', 'type' => 'string'],
            ['key' => 'schedule_maps_url', 'value' => 'https://maps.app.goo.gl/Rd7vgrC7bLRvxGsL7', 'group' => 'schedule', 'type' => 'string'],

            // ── Section Galeri Momen (Gallery) ─────────────────
            ['key' => 'gallery_badge_label', 'value' => 'Galeri', 'group' => 'gallery', 'type' => 'string'],
            ['key' => 'gallery_title_1', 'value' => 'Momen', 'group' => 'gallery', 'type' => 'string'],
            ['key' => 'gallery_title_highlight', 'value' => 'Terbaik', 'group' => 'gallery', 'type' => 'string'],
            ['key' => 'gallery_description', 'value' => 'Setiap latihan, setiap pertandingan — diabadikan.', 'group' => 'gallery', 'type' => 'string'],

            ['key' => 'gallery_item_1_image', 'value' => null, 'group' => 'gallery', 'type' => 'string'],
            ['key' => 'gallery_item_1_label', 'value' => 'Sesi Latihan', 'group' => 'gallery', 'type' => 'string'],

            ['key' => 'gallery_item_2_image', 'value' => null, 'group' => 'gallery', 'type' => 'string'],
            ['key' => 'gallery_item_2_label', 'value' => 'Kihon', 'group' => 'gallery', 'type' => 'string'],

            ['key' => 'gallery_item_3_image', 'value' => null, 'group' => 'gallery', 'type' => 'string'],
            ['key' => 'gallery_item_3_label', 'value' => 'Kejuaraan', 'group' => 'gallery', 'type' => 'string'],

            ['key' => 'gallery_item_4_image', 'value' => null, 'group' => 'gallery', 'type' => 'string'],
            ['key' => 'gallery_item_4_label', 'value' => 'Podium', 'group' => 'gallery', 'type' => 'string'],

            ['key' => 'gallery_item_5_image', 'value' => null, 'group' => 'gallery', 'type' => 'string'],
            ['key' => 'gallery_item_5_label', 'value' => 'Opening Ceremony', 'group' => 'gallery', 'type' => 'string'],
        ];

        foreach ($settings as $setting) {
            LandingSetting::set(
                $setting['key'],
                $setting['value'],
                $setting['group'],
                $setting['type']
            );
        }
    }
}
