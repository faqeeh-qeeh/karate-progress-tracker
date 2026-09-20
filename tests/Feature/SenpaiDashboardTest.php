<?php

namespace Tests\Feature;

use App\Models\Attendance;
use App\Models\AttendanceSession;
use App\Models\Belt;
use App\Models\KohaiProfile;
use App\Models\KumiteReport;
use App\Models\Rank;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SenpaiDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_senpai_dashboard_renders_with_real_data()
    {
        $senpaiRole = Role::create(['nama' => 'Senpai']);
        $kohaiRole = Role::create(['nama' => 'Kohai']);

        $belt = Belt::create(['name' => 'Sabuk Putih', 'color_code' => '#ffffff']);
        $rank = Rank::create(['belt_id' => $belt->id, 'category' => 'Kyu', 'name' => 'KYU 10', 'order' => 1]);

        $senpai = User::factory()->create([
            'name' => 'Senpai Kenji',
            'role_id' => $senpaiRole->id,
        ]);

        $kohai1 = User::factory()->create([
            'name' => 'Kohai Budi',
            'role_id' => $kohaiRole->id,
        ]);
        KohaiProfile::create([
            'user_id' => $kohai1->id,
            'type' => 'polindra',
            'rank_id' => $rank->id,
            'nim' => '2201001',
        ]);

        $kohai2 = User::factory()->create([
            'name' => 'Kohai Siti',
            'role_id' => $kohaiRole->id,
        ]);
        KohaiProfile::create([
            'user_id' => $kohai2->id,
            'type' => 'polindra',
            'rank_id' => $rank->id,
            'nim' => '2201002',
        ]);

        $session = AttendanceSession::createNewSession($senpai->id, 'Latihan Rutin Sesi 1', now()->toDateString());
        Attendance::create([
            'attendance_session_id' => $session->id,
            'kohai_id' => $kohai1->id,
            'scanned_at' => now(),
            'status' => 'Hadir',
        ]);

        KumiteReport::create([
            'senpai_id' => $senpai->id,
            'aka_kohai_id' => $kohai1->id,
            'ao_kohai_id' => $kohai2->id,
            'match_date' => now()->toDateString(),
            'match_time' => '16:00',
            'duration_seconds' => 180,
            'aka_ippon' => 1,
            'aka_wazaari' => 1,
            'aka_yuko' => 0,
            'aka_fouls' => 0,
            'aka_score_attack' => 15,
            'aka_score_accuracy' => 50,
            'aka_total_score' => 5,
            'ao_ippon' => 0,
            'ao_wazaari' => 1,
            'ao_yuko' => 1,
            'ao_fouls' => 0,
            'ao_score_attack' => 12,
            'ao_score_accuracy' => 40,
            'ao_total_score' => 3,
            'winner_id' => $kohai1->id,
        ]);

        $response = $this->actingAs($senpai)->get(route('senpai.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Osu, Senpai Kenji!');
        $response->assertSee('Kohai Budi');
        $response->assertSee('Kohai Siti');
        $response->assertSee('Latihan Rutin Sesi 1');
        $response->assertSee('1 Sesi Aktif');
    }
}
