<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\AttendanceSession;
use App\Models\KumiteReport;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AttendanceAndKumiteSeeder extends Seeder
{
    public function run(): void
    {
        $senpaiRole = Role::where('nama', 'Senpai')->first();
        $kohaiRole = Role::where('nama', 'Kohai')->first();

        // 1. Ambil atau Buat Senpai Utama
        $senpai = User::firstOrCreate(
            ['email' => 'senpai@karate.com'],
            [
                'name' => 'Senpai Kenji Takahashi',
                'birth_place' => 'Cirebon',
                'birth_date' => '1995-08-17',
                'gender' => 'male',
                'address' => 'Jl. Pemuda No. 45, Cirebon',
                'phone' => '081298765432',
                'password' => Hash::make('password'),
                'role_id' => $senpaiRole->id,
            ]
        );

        // 2. Ambil atau Buat Daftar Kohai (5 Kohai)
        $kohais = [];

        $kohai1 = User::firstOrCreate(
            ['email' => 'kohai@karate.com'],
            [
                'name' => 'Kohai Budi Pratama',
                'birth_place' => 'Indramayu',
                'birth_date' => '2004-03-12',
                'gender' => 'male',
                'address' => 'Jl. Lohbener Timur No. 8, Indramayu',
                'phone' => '085712345671',
                'password' => Hash::make('password'),
                'role_id' => $kohaiRole->id,
            ]
        );
        $kohais[] = $kohai1;

        $kohai2 = User::firstOrCreate(
            ['email' => 'siti@karate.com'],
            [
                'name' => 'Kohai Siti Rahma',
                'birth_place' => 'Indramayu',
                'birth_date' => '2004-07-25',
                'gender' => 'female',
                'address' => 'Jl. Jatibarang No. 19, Indramayu',
                'phone' => '085712345672',
                'password' => Hash::make('password'),
                'role_id' => $kohaiRole->id,
            ]
        );
        $kohais[] = $kohai2;

        $kohai3 = User::firstOrCreate(
            ['email' => 'andi@karate.com'],
            [
                'name' => 'Kohai Andi Wijaya',
                'birth_place' => 'Kuningan',
                'birth_date' => '2003-11-05',
                'gender' => 'male',
                'address' => 'Jl. Siliwangi No. 88, Kuningan',
                'phone' => '085712345673',
                'password' => Hash::make('password'),
                'role_id' => $kohaiRole->id,
            ]
        );
        $kohais[] = $kohai3;

        $kohai4 = User::firstOrCreate(
            ['email' => 'dewi@karate.com'],
            [
                'name' => 'Kohai Dewi Lestari',
                'birth_place' => 'Majalengka',
                'birth_date' => '2005-01-18',
                'gender' => 'female',
                'address' => 'Jl. KH Abdul Halim No. 23, Majalengka',
                'phone' => '085712345674',
                'password' => Hash::make('password'),
                'role_id' => $kohaiRole->id,
            ]
        );
        $kohais[] = $kohai4;

        $kohai5 = User::firstOrCreate(
            ['email' => 'rizky@karate.com'],
            [
                'name' => 'Kohai Rizky Pratama',
                'birth_place' => 'Indramayu',
                'birth_date' => '2004-09-30',
                'gender' => 'male',
                'address' => 'Jl. Sudirman No. 50, Indramayu',
                'phone' => '085712345675',
                'password' => Hash::make('password'),
                'role_id' => $kohaiRole->id,
            ]
        );
        $kohais[] = $kohai5;

        // Clean existing attendance and kumite reports to avoid conflict on full re-seed
        // (opsional/aman)
        
        // 3. SEED 25 SESI ABSENSI & PRESENSI KOHAI
        // Hapus sesi absensi lama jika perlu agar seeder ini bersih
        AttendanceSession::where('senpai_id', $senpai->id)->delete();
        KumiteReport::where('senpai_id', $senpai->id)->delete();

        $sessionTitles = [
            'Latihan Teknik Dasar Kihon & Kata',
            'Sparing Kumite Persiapan Kejuaraan',
            'Latihan Fisik Stamina & Agilitas',
            'Pembahasan Aturan Tanding WKF Terbaru',
            'Latihan Strategi Serangan Jarak Jauh',
            'Evaluasi Tanding & Kontrol Senjata Tubuh',
            'Simulasi Tanding Kumite Reguler',
            'Latihan Pertahanan Defensif & Counter Attack',
            'Sesi Kombinasi Kizami Zuki & Gyaku Zuki',
            'Latihan Mawashi Geri & Ura Mawashi Geri',
            'Latihan Penguasaan Maai (Jarak Tanding)',
            'Pemberkasan Raport Evaluasi Bulanan Dojo',
            'Latihan Pengkondisian Mental Bertanding',
        ];

        // Buat 24 Sesi Lampau (is_active = false)
        for ($i = 24; $i >= 1; $i--) {
            $date = Carbon::now()->subDays($i * 2);
            $titleIndex = $i % count($sessionTitles);
            $title = $sessionTitles[$titleIndex] . ' - ' . $date->format('d M Y');

            $session = AttendanceSession::create([
                'senpai_id' => $senpai->id,
                'title' => $title,
                'date' => $date->format('Y-m-d'),
                'qr_token' => strtoupper(Str::random(6)),
                'is_active' => false,
                'created_at' => $date,
                'updated_at' => $date,
            ]);

            // Selalu masukkan Kohai Budi Pratama dan sebagian Kohai lain
            foreach ($kohais as $kIndex => $k) {
                // Kohai Budi (kIndex 0) hadir 90% waktu, Kohai lain acak
                if ($kIndex === 0 || rand(0, 1) === 1) {
                    Attendance::create([
                        'attendance_session_id' => $session->id,
                        'kohai_id' => $k->id,
                        'scanned_at' => $date->copy()->addMinutes(rand(5, 45)),
                        'status' => 'Hadir',
                    ]);
                }
            }
        }

        // Buat 1 Sesi Aktif Hari Ini (is_active = true)
        $todaySession = AttendanceSession::create([
            'senpai_id' => $senpai->id,
            'title' => 'Latihan Rutin Dojo Hari Ini - ' . Carbon::now()->format('d M Y'),
            'date' => Carbon::now()->format('Y-m-d'),
            'qr_token' => strtoupper(Str::random(6)),
            'is_active' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Catat beberapa Kohai hadir pada sesi aktif hari ini
        Attendance::create([
            'attendance_session_id' => $todaySession->id,
            'kohai_id' => $kohai1->id,
            'scanned_at' => Carbon::now()->subMinutes(10),
            'status' => 'Hadir',
        ]);
        Attendance::create([
            'attendance_session_id' => $todaySession->id,
            'kohai_id' => $kohai2->id,
            'scanned_at' => Carbon::now()->subMinutes(5),
            'status' => 'Hadir',
        ]);

        // 4. SEED 25 DATA RAPORT KUMITE WKF
        $evalNotesAKA = [
            'Serangan Gyaku Zuki sangat presisi. Perlu ditingkatkan ketahanan fisik saat menit terakhir.',
            'Senshu dimanfaatkan dengan baik. Pertahanan saat serangan balik lawan cukup solid.',
            'Akurasi pukulan Kizami Zuki sangat tajam. Hindari pelanggaran kontak berlebih (C1).',
            'Tendangan Mawashi Geri mendarat sempurna (Ippon). Pertahankan kewaspadaan Maai.',
            'Gerakan kaki sangat aktif. Perlu perbaikan pada timing eksekusi konter serangan.',
            'Kombinasi pukulan cepat dan efisien. Pertahankan fokus hingga akhir ronde.',
        ];

        $evalNotesAO = [
            'Pertahanan cukup rapat, namun reaksi serangan balik masih agak terlambat.',
            'Pergerakan lincah. Perlu menambah variasi tendangan area kepala untuk meraih Ippon.',
            'Bermain sangat tenang. Harus lebih agresif mengambil inisiatif serangan diawal.',
            'Kontrol jarak sangat baik. Perhatikan disiplin agar tidak terkena peringatan C2.',
            'Semangat tanding luar biasa. Perbaiki akurasi pukulan agar poin terhitung sah oleh juri.',
            'Kemampuan membaca ritme lawan bagus. Ditingkatkan lagi kecepatan eksekusi teknik.',
        ];

        for ($i = 25; $i >= 1; $i--) {
            $matchDate = Carbon::now()->subDays($i * 2);
            $matchTime = sprintf('%02d:%02d', rand(14, 20), rand(0, 59));

            // Pilih AKA & AO kohai yang berbeda
            $akaIndex = ($i % count($kohais));
            $aoIndex = ($i + 1) % count($kohais);
            if ($akaIndex === $aoIndex) {
                $aoIndex = ($aoIndex + 1) % count($kohais);
            }

            $akaKohai = $kohais[$akaIndex];
            $aoKohai = $kohais[$aoIndex];

            // Poin & Pelanggaran AKA
            $akaIppon = rand(0, 2);
            $akaWazaari = rand(0, 2);
            $akaYuko = rand(0, 4);
            $akaTotal = ($akaIppon * 3) + ($akaWazaari * 2) + ($akaYuko * 1);
            $akaFouls = rand(0, 3);
            $akaAttack = rand(10, 30);
            $akaHits = $akaIppon + $akaWazaari + $akaYuko;
            $akaAccuracy = $akaAttack > 0 ? round(($akaHits / $akaAttack) * 100, 1) : 0;

            // Poin & Pelanggaran AO
            $aoIppon = rand(0, 2);
            $aoWazaari = rand(0, 2);
            $aoYuko = rand(0, 4);
            $aoTotal = ($aoIppon * 3) + ($aoWazaari * 2) + ($aoYuko * 1);
            $aoFouls = rand(0, 3);
            $aoAttack = rand(10, 30);
            $aoHits = $aoIppon + $aoWazaari + $aoYuko;
            $aoAccuracy = $aoAttack > 0 ? round(($aoHits / $aoAttack) * 100, 1) : 0;

            // Senshu corner
            $senshu = rand(0, 1) === 1 ? 'aka' : 'ao';

            // Tentukan Pemenang (memperhitungkan Hansoku jika fouls >= 4)
            $akaDisqualified = ($akaFouls >= 4);
            $aoDisqualified = ($aoFouls >= 4);
            $winnerId = null;

            if ($akaDisqualified && !$aoDisqualified) {
                $winnerId = $aoKohai->id;
            } elseif ($aoDisqualified && !$akaDisqualified) {
                $winnerId = $akaKohai->id;
            } elseif ($akaTotal > $aoTotal) {
                $winnerId = $akaKohai->id;
            } elseif ($aoTotal > $akaTotal) {
                $winnerId = $aoKohai->id;
            } else {
                // Jika skor sama, pemenang berdasarkan Senshu
                if ($senshu === 'aka') {
                    $winnerId = $akaKohai->id;
                } else {
                    $winnerId = $aoKohai->id;
                }
            }

            $durationPool = [90, 120, 180, 180, 180, 300];
            $durationSeconds = $durationPool[$i % count($durationPool)];

            $report = KumiteReport::create([
                'senpai_id' => $senpai->id,
                'aka_kohai_id' => $akaKohai->id,
                'ao_kohai_id' => $aoKohai->id,
                'match_date' => $matchDate->format('Y-m-d'),
                'match_time' => $matchTime,
                'duration_seconds' => $durationSeconds,
                'senshu_corner' => $senshu,

                'aka_ippon' => $akaIppon,
                'aka_wazaari' => $akaWazaari,
                'aka_yuko' => $akaYuko,
                'aka_fouls' => $akaFouls,
                'aka_score_attack' => $akaAttack,
                'aka_score_accuracy' => $akaAccuracy,
                'aka_total_score' => $akaTotal,
                'aka_evaluation_notes' => $evalNotesAKA[$i % count($evalNotesAKA)],

                'ao_ippon' => $aoIppon,
                'ao_wazaari' => $aoWazaari,
                'ao_yuko' => $aoYuko,
                'ao_fouls' => $aoFouls,
                'ao_score_attack' => $aoAttack,
                'ao_score_accuracy' => $aoAccuracy,
                'ao_total_score' => $aoTotal,
                'ao_evaluation_notes' => $evalNotesAO[$i % count($evalNotesAO)],

                'winner_id' => $winnerId,
                'created_at' => $matchDate,
                'updated_at' => $matchDate,
            ]);

            // Seed Senshu logs (showcasing Senshu Cancelling on some matches)
            if ($i % 3 === 0) {
                // Match with Senshu Cancelling
                $initialCorner = ($senshu === 'aka') ? 'ao' : 'aka';
                \App\Models\KumiteSenshuLog::create([
                    'kumite_report_id' => $report->id,
                    'sequence' => 1,
                    'corner' => $initialCorner,
                    'status' => 'cancelled',
                    'notes' => 'Senshu pertama dibatalkan wasit karena pelanggaran Kategori 2 di detik akhir.',
                ]);
                \App\Models\KumiteSenshuLog::create([
                    'kumite_report_id' => $report->id,
                    'sequence' => 2,
                    'corner' => $senshu,
                    'status' => 'active',
                    'notes' => 'Pemberian Senshu baru setelah peninjauan wasit tatami.',
                ]);
            } elseif ($senshu) {
                \App\Models\KumiteSenshuLog::create([
                    'kumite_report_id' => $report->id,
                    'sequence' => 1,
                    'corner' => $senshu,
                    'status' => 'active',
                    'notes' => 'Poin pertama tanpa pembatalan.',
                ]);
            }
        }
    }
}
