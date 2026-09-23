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
