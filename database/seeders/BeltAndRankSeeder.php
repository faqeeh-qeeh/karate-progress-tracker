<?php

namespace Database\Seeders;

use App\Models\Belt;
use App\Models\Rank;
use Illuminate\Database\Seeder;

class BeltAndRankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Sabuk Putih
        $whiteBelt = Belt::updateOrCreate(
            ['name' => 'Sabuk Putih'],
            [
                'color_code' => '#FFFFFF',
                'description' => 'Tingkat pemula (dasar). Melambangkan kemurnian, kesucian, dan awal mula perjalanan karateka.',
            ]
        );

        Rank::updateOrCreate(
            ['belt_id' => $whiteBelt->id, 'name' => 'Kyu 10'],
            [
                'category' => 'Kyu',
                'order' => 1,
                'description' => 'Tingkatan awal pengenalan teknik dasar (Kihon), kuda-kuda dasar (Zenkutsu Dachi), dan etika Dojo.',
            ]
        );

        Rank::updateOrCreate(
            ['belt_id' => $whiteBelt->id, 'name' => 'Kyu 9'],
            [
                'category' => 'Kyu',
                'order' => 2,
                'description' => 'Pemantapan teknik pukulan dan tangkisan dasar.',
            ]
        );

        // 2. Sabuk Kuning
        $yellowBelt = Belt::updateOrCreate(
            ['name' => 'Sabuk Kuning'],
            [
                'color_code' => '#EAB308',
                'description' => 'Melambangkan pancaran sinar matahari pertama yang memberikan energi dan semangat baru.',
            ]
        );

        Rank::updateOrCreate(
            ['belt_id' => $yellowBelt->id, 'name' => 'Kyu 8'],
            [
                'category' => 'Kyu',
                'order' => 3,
                'description' => 'Penguasaan Kata dasar (Heian Shodan / Taikyoku) dan dasar-dasar serangan balik.',
            ]
        );

        Rank::updateOrCreate(
            ['belt_id' => $yellowBelt->id, 'name' => 'Kyu 7'],
            [
                'category' => 'Kyu',
                'order' => 4,
                'description' => 'Peningkatan variasi tendangan (Mae Geri) dan tangkisan ganda.',
            ]
        );

        // 3. Sabuk Hijau
        $greenBelt = Belt::updateOrCreate(
            ['name' => 'Sabuk Hijau'],
            [
                'color_code' => '#10B981',
                'description' => 'Melambangkan pertumbuhan tunas tanaman, mulai mengasah teknik dan kedalaman pemahaman.',
            ]
        );

        Rank::updateOrCreate(
            ['belt_id' => $greenBelt->id, 'name' => 'Kyu 6'],
            [
                'category' => 'Kyu',
                'order' => 5,
                'description' => 'Penguasaan Kata lanjutan (Heian Nidan / Heian Sandan) dan simulasi Ippon Kumite.',
            ]
        );

        Rank::updateOrCreate(
            ['belt_id' => $greenBelt->id, 'name' => 'Kyu 5'],
            [
                'category' => 'Kyu',
                'order' => 6,
                'description' => 'Penerapan strategi gerak langkah (Tai Sabaki) dan kombinasi pukulan-tendangan.',
            ]
        );

        // 4. Sabuk Biru
        $blueBelt = Belt::updateOrCreate(
            ['name' => 'Sabuk Biru'],
            [
                'color_code' => '#3B82F6',
                'description' => 'Melambangkan luasnya langit dan kedalaman samudera. Menggambarkan kematangan teknik dan ketenangan mental.',
            ]
        );

        Rank::updateOrCreate(
            ['belt_id' => $blueBelt->id, 'name' => 'Kyu 4'],
            [
                'category' => 'Kyu',
                'order' => 7,
                'description' => 'Penguasaan Kata Heian Yondan / Heian Godan serta penerapan teknik kuncian dan sapuan kaki.',
            ]
        );

        // 5. Sabuk Coklat
        $brownBelt = Belt::updateOrCreate(
            ['name' => 'Sabuk Coklat'],
            [
                'color_code' => '#78350F',
                'description' => 'Melambangkan kematangan tanah dan kesiapan memasuki tingkatan sabuk hitam (Yudansha).',
            ]
        );

        Rank::updateOrCreate(
            ['belt_id' => $brownBelt->id, 'name' => 'Kyu 3'],
            [
                'category' => 'Kyu',
                'order' => 8,
                'description' => 'Penguasaan Kata Tekki Shodan / Bassai Dai dan kematangan teknik tanding Kumite.',
            ]
        );

        Rank::updateOrCreate(
            ['belt_id' => $brownBelt->id, 'name' => 'Kyu 2'],
            [
                'category' => 'Kyu',
                'order' => 9,
                'description' => 'Pendalaman filosofi Budo, kontrol emosi, dan ketepatan refleks tanding.',
            ]
        );

        Rank::updateOrCreate(
            ['belt_id' => $brownBelt->id, 'name' => 'Kyu 1'],
            [
                'category' => 'Kyu',
                'order' => 10,
                'description' => 'Tingkatan tertinggi jenjang Kyu. Persiapan ujian nasional kenaikan tingkat ke Sabuk Hitam (Dan 1).',
            ]
        );

        // 6. Sabuk Hitam
        $blackBelt = Belt::updateOrCreate(
            ['name' => 'Sabuk Hitam'],
            [
                'color_code' => '#0F172A',
                'description' => 'Melambangkan kedalaman ilmu, kerendahan hati, dan awal dari penguasaan sejati (Yudansha).',
            ]
        );

        $danRanks = [
            ['name' => 'Dan 1 (Shodan)', 'order' => 11, 'desc' => 'Tingkat pertama Yudansha (Langkah Pertama), resmi menyandang gelar Senpai / Pelatih Muda.'],
            ['name' => 'Dan 2 (Nidan)', 'order' => 12, 'desc' => 'Tingkat kedua Yudansha, pemantapan pemahaman aplikasi beladiri nyata (Bunkai).'],
            ['name' => 'Dan 3 (Sandan)', 'order' => 13, 'desc' => 'Tingkat ketiga Yudansha, penguasaan tingkat instruktur dan pembina teknik dojo.'],
            ['name' => 'Dan 4 (Yondan)', 'order' => 14, 'desc' => 'Tingkat master muda, kontribusi terhadap pengembangan perguruan dan wasit WKF.'],
            ['name' => 'Dan 5 (Godan)', 'order' => 15, 'desc' => 'Tingkat Master / Sensei Senior, penguasaan utuh atas teknik fisik, mental, dan filosofi Karate-Do.'],
        ];

        foreach ($danRanks as $d) {
            Rank::updateOrCreate(
                ['belt_id' => $blackBelt->id, 'name' => $d['name']],
                [
                    'category' => 'Dan',
                    'order' => $d['order'],
                    'description' => $d['desc'],
                ]
            );
        }
    }
}
