<?php

namespace Database\Seeders;

use App\Models\Achievement;
use App\Models\User;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kohaiUser = User::where('email', 'kohai@karate.com')->first();
        $senpaiUser = User::where('email', 'senpai@karate.com')->first();

        $achievements = [
            [
                'user_id' => $kohaiUser?->id,
                'athlete_name' => 'Budi Pratama',
                'event_name' => 'POMNAS 2024',
                'title' => 'Juara 1 Kata Perorangan Putra',
                'medal_type' => 'gold',
                'event_date' => '2024-08-15',
                'location' => 'Jakarta',
                'description' => 'Meraih medali emas pada ajang Pekan Olahraga Mahasiswa Nasional mewakili kontingen Jawa Barat.',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 1,
            ],
            [
                'user_id' => $kohaiUser?->id,
                'athlete_name' => 'Budi Pratama',
                'event_name' => 'Kejurda Jabar 2024',
                'title' => 'Juara 2 Kumite -60kg Putra',
                'medal_type' => 'silver',
                'event_date' => '2024-04-20',
                'location' => 'Bandung',
                'description' => 'Juara 2 Kumite -60kg pada Kejuaraan Daerah Karate Jawa Barat.',
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 2,
            ],
            [
                'user_id' => null,
                'athlete_name' => 'Tim Karate Polindra',
                'event_name' => 'Kejuaraan Politeknik',
                'title' => 'Juara Umum Se-Jawa Barat',
                'medal_type' => 'gold',
                'event_date' => '2023-11-10',
                'location' => 'Bekasi',
                'description' => 'UKM Karate Polindra menyabet piala Juara Umum antar Politeknik se-Jawa Barat.',
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 3,
            ],
            [
                'user_id' => null,
                'athlete_name' => 'Tim Beregu Putri',
                'event_name' => 'Piala Rektor 2023',
                'title' => 'Juara 3 Kata Beregu Putri',
                'medal_type' => 'bronze',
                'event_date' => '2023-10-05',
                'location' => 'Cirebon',
                'description' => 'Podium 3 Kata Beregu Putri pada invitasi Piala Rektor.',
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 4,
            ],
            [
                'user_id' => null,
                'athlete_name' => 'Siti Nurhaliza',
                'event_name' => 'Forki Cup 2023',
                'title' => 'Juara 2 Kumite -55kg Putri',
                'medal_type' => 'silver',
                'event_date' => '2023-03-18',
                'location' => 'Indramayu',
                'description' => 'Medali perak pada kejuaraan FORKI Cup tingkat Kabupaten Indramayu.',
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 5,
            ],
            [
                'user_id' => $senpaiUser?->id,
                'athlete_name' => 'Kenji & Tim Beregu',
                'event_name' => 'Open Championship 2022',
                'title' => 'Juara 1 Kata Beregu Putra',
                'medal_type' => 'gold',
                'event_date' => '2022-12-12',
                'location' => 'Karawang',
                'description' => 'Juara 1 Kata Beregu Putra pada Karate Open Championship.',
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($achievements as $data) {
            Achievement::updateOrCreate(
                [
                    'event_name' => $data['event_name'],
                    'title' => $data['title'],
                ],
                $data
            );
        }
    }
}
