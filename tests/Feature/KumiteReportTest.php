<?php

namespace Tests\Feature;

use App\Models\KumiteReport;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KumiteReportTest extends TestCase
{
    use RefreshDatabase;

    protected User $senpai;
    protected User $kohaiAka;
    protected User $kohaiAo;

    protected function setUp(): void
    {
        parent::setUp();

        $senpaiRole = Role::create(['nama' => 'Senpai']);
        $kohaiRole = Role::create(['nama' => 'Kohai']);

        $this->senpai = User::factory()->create([
            'name' => 'Senpai Kenji',
            'role_id' => $senpaiRole->id,
        ]);

        $this->kohaiAka = User::factory()->create([
            'name' => 'Kohai Budi (AKA)',
            'role_id' => $kohaiRole->id,
        ]);

        $this->kohaiAo = User::factory()->create([
            'name' => 'Kohai Siti (AO)',
            'role_id' => $kohaiRole->id,
        ]);
    }

    public function test_senpai_can_store_kumite_report_with_live_points_fouls_and_auto_accuracy(): void
    {
        $response = $this->actingAs($this->senpai)->post(route('senpai.kumite.store'), [
            'aka_kohai_id' => $this->kohaiAka->id,
            'ao_kohai_id' => $this->kohaiAo->id,
            'match_date' => now()->toDateString(),
            'match_time' => '14:30',
            'senshu_corner' => 'aka',

            // AKA: Ippon 2 (6 pts), Wazaari 1 (2 pts), Yuko 4 (4 pts) -> Total = 12 pts, Hits = 7
            'aka_ippon' => 2,
            'aka_wazaari' => 1,
            'aka_yuko' => 4,
            'aka_fouls' => 2,
            'aka_score_attack' => 10, // 7 hits / 10 attacks = 70.0%
            'aka_evaluation_notes' => 'Bagus sekali',

            // AO: Ippon 0, Wazaari 1 (2 pts), Yuko 1 (1 pt) -> Total = 3 pts, Hits = 2
            'ao_ippon' => 0,
            'ao_wazaari' => 1,
            'ao_yuko' => 1,
            'ao_fouls' => 1,
            'ao_score_attack' => 8, // 2 hits / 8 attacks = 25.0%
            'ao_evaluation_notes' => 'Tingkatkan serangan',
        ]);

        $response->assertRedirect(route('senpai.kumite.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('kumite_reports', [
            'senpai_id' => $this->senpai->id,
            'aka_kohai_id' => $this->kohaiAka->id,
            'ao_kohai_id' => $this->kohaiAo->id,
            'aka_total_score' => 12,
            'aka_fouls' => 2,
            'aka_score_attack' => 10,
            'aka_score_accuracy' => 70.0,

            'ao_total_score' => 3,
            'ao_fouls' => 1,
            'ao_score_attack' => 8,
            'ao_score_accuracy' => 25.0,

            'winner_id' => $this->kohaiAka->id,
        ]);
    }

    public function test_kumite_report_with_zero_attack_handles_accuracy_gracefully(): void
    {
        $response = $this->actingAs($this->senpai)->post(route('senpai.kumite.store'), [
            'aka_kohai_id' => $this->kohaiAka->id,
            'ao_kohai_id' => $this->kohaiAo->id,
            'match_date' => now()->toDateString(),
            'match_time' => '15:00',
            'senshu_corner' => 'ao',

            'aka_ippon' => 0,
            'aka_wazaari' => 0,
            'aka_yuko' => 0,
            'aka_fouls' => 0,
            'aka_score_attack' => 0,

            'ao_ippon' => 1,
            'ao_wazaari' => 0,
            'ao_yuko' => 0,
            'ao_fouls' => 0,
            'ao_score_attack' => 5,
        ]);

        $response->assertRedirect(route('senpai.kumite.index'));

        $this->assertDatabaseHas('kumite_reports', [
            'aka_score_attack' => 0,
            'aka_score_accuracy' => 0.0,
            'ao_score_attack' => 5,
            'ao_score_accuracy' => 20.0,
            'winner_id' => $this->kohaiAo->id,
        ]);
    }

    public function test_fighter_with_4_or_more_fouls_automatically_loses_even_with_higher_score(): void
    {
        // Simulasi: AKA memiliki poin jauh lebih tinggi (Ippon 3 = 9 pts vs AO 0 pts)
        // Tetapi AKA melakukan 4 pelanggaran (fouls = 4), sedangkan AO hanya 1 pelanggaran (fouls = 1)
        // Hasil yang diharapkan: AO dinyatakan MENANG karena AKA terkena Hansoku.
        $response = $this->actingAs($this->senpai)->post(route('senpai.kumite.store'), [
            'aka_kohai_id' => $this->kohaiAka->id,
            'ao_kohai_id' => $this->kohaiAo->id,
            'match_date' => now()->toDateString(),
            'match_time' => '16:00',
            'senshu_corner' => 'aka',

            'aka_ippon' => 3, // 9 Pts
            'aka_wazaari' => 0,
            'aka_yuko' => 0,
            'aka_fouls' => 4, // Hansoku (>= 4)
            'aka_score_attack' => 10,

            'ao_ippon' => 0, // 0 Pts
            'ao_wazaari' => 0,
            'ao_yuko' => 0,
            'ao_fouls' => 1,
            'ao_score_attack' => 5,
        ]);

        $response->assertRedirect(route('senpai.kumite.index'));

        $this->assertDatabaseHas('kumite_reports', [
            'aka_kohai_id' => $this->kohaiAka->id,
            'ao_kohai_id' => $this->kohaiAo->id,
            'aka_total_score' => 9,
            'aka_fouls' => 4,
            'ao_total_score' => 0,
            'ao_fouls' => 1,
            'winner_id' => $this->kohaiAo->id, // Pemenang harus AO
        ]);
    }

    public function test_kumite_report_stores_senshu_cancelling_logs_and_sets_final_active_senshu(): void
    {
        // Simulasi: AKA awalnya dapat Senshu, kemudian terjadi Senshu Cancelling, dan Senshu baru diberikan ke AO
        // Skor akhir seri (3 vs 3) dan pelanggaran < 4. Pemenang harus AO karena memegang Senshu aktif terakhir.
        $response = $this->actingAs($this->senpai)->post(route('senpai.kumite.store'), [
            'aka_kohai_id' => $this->kohaiAka->id,
            'ao_kohai_id' => $this->kohaiAo->id,
            'match_date' => now()->toDateString(),
            'match_time' => '17:00',
            'senshu_corner' => 'aka', // initial fallback field

            'senshu_logs' => [
                [
                    'corner' => 'aka',
                    'status' => 'cancelled',
                    'notes' => 'Pelanggaran C2 sebelum waktu habis',
                ],
                [
                    'corner' => 'ao',
                    'status' => 'active',
                    'notes' => 'Serangan poin balasan valid',
                ],
            ],

            'aka_ippon' => 1, // 3 Pts
            'aka_wazaari' => 0,
            'aka_yuko' => 0,
            'aka_fouls' => 1,
            'aka_score_attack' => 5,

            'ao_ippon' => 1, // 3 Pts
            'ao_wazaari' => 0,
            'ao_yuko' => 0,
            'ao_fouls' => 0,
            'ao_score_attack' => 6,
        ]);

        $response->assertRedirect(route('senpai.kumite.index'));

        $this->assertDatabaseHas('kumite_reports', [
            'aka_kohai_id' => $this->kohaiAka->id,
            'ao_kohai_id' => $this->kohaiAo->id,
            'aka_total_score' => 3,
            'ao_total_score' => 3,
            'senshu_corner' => 'ao', // Senshu efektif akhir adalah AO
            'winner_id' => $this->kohaiAo->id, // AO menang berdasarkan Senshu
        ]);

        $this->assertDatabaseHas('kumite_senshu_logs', [
            'sequence' => 1,
            'corner' => 'aka',
            'status' => 'cancelled',
        ]);

        $this->assertDatabaseHas('kumite_senshu_logs', [
            'sequence' => 2,
            'corner' => 'ao',
            'status' => 'active',
        ]);
    }

    public function test_kumite_report_with_all_senshu_cancelled_results_in_draw_when_scores_tied(): void
    {
        // Simulasi: AKA awalnya dapat Senshu, dibatalkan (Senshu Cancelling), dan keputusan akhir adalah "none" (Tidak ada Senshu)
        // Skor seri (2 vs 2). Karena tidak ada Senshu aktif, hasil pertandingan menjadi SERI (Draw / winner_id = null).
        $response = $this->actingAs($this->senpai)->post(route('senpai.kumite.store'), [
            'aka_kohai_id' => $this->kohaiAka->id,
            'ao_kohai_id' => $this->kohaiAo->id,
            'match_date' => now()->toDateString(),
            'match_time' => '17:30',

            'senshu_logs' => [
                [
                    'corner' => 'aka',
                    'status' => 'cancelled',
                    'notes' => 'Senshu dibatalkan wasit',
                ],
                [
                    'corner' => 'none',
                    'status' => 'none',
                    'notes' => 'Tidak ada senshu lanjutan',
                ],
            ],

            'aka_ippon' => 0,
            'aka_wazaari' => 1, // 2 Pts
            'aka_yuko' => 0,
            'aka_fouls' => 0,
            'aka_score_attack' => 4,

            'ao_ippon' => 0,
            'ao_wazaari' => 1, // 2 Pts
            'ao_yuko' => 0,
            'ao_fouls' => 0,
            'ao_score_attack' => 4,
        ]);

        $response->assertRedirect(route('senpai.kumite.index'));

        $this->assertDatabaseHas('kumite_reports', [
            'aka_kohai_id' => $this->kohaiAka->id,
            'ao_kohai_id' => $this->kohaiAo->id,
            'aka_total_score' => 2,
            'ao_total_score' => 2,
            'senshu_corner' => null, // Tidak ada senshu
            'winner_id' => null, // Hasil Seri (Draw)
        ]);

        $this->assertDatabaseHas('kumite_senshu_logs', [
            'sequence' => 1,
            'corner' => 'aka',
            'status' => 'cancelled',
        ]);
    }

    public function test_kumite_report_stores_custom_match_duration_correctly(): void
    {
        // Simulasi: Senpai menentukan waktu tanding 1 menit 30 detik (90 detik)
        $response = $this->actingAs($this->senpai)->post(route('senpai.kumite.store'), [
            'aka_kohai_id' => $this->kohaiAka->id,
            'ao_kohai_id' => $this->kohaiAo->id,
            'match_date' => now()->toDateString(),
            'match_time' => '18:00',
            'duration_minutes' => 1,
            'duration_seconds' => 30,

            'aka_ippon' => 1,
            'aka_wazaari' => 0,
            'aka_yuko' => 0,
            'aka_fouls' => 0,
            'aka_score_attack' => 5,

            'ao_ippon' => 0,
            'ao_wazaari' => 0,
            'ao_yuko' => 0,
            'ao_fouls' => 0,
            'ao_score_attack' => 3,
        ]);

        $response->assertRedirect(route('senpai.kumite.index'));

        $this->assertDatabaseHas('kumite_reports', [
            'aka_kohai_id' => $this->kohaiAka->id,
            'ao_kohai_id' => $this->kohaiAo->id,
            'duration_seconds' => 90,
        ]);

        $report = KumiteReport::where('duration_seconds', 90)->first();
        $this->assertNotNull($report);
        $this->assertEquals('01:30', $report->formatted_duration);
        $this->assertEquals('1m 30s', $report->human_duration);
    }
}
