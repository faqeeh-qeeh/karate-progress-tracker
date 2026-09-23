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
