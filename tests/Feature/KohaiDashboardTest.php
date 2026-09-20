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

class KohaiDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_kohai_dashboard_renders_with_real_data()
    {
        $senpaiRole = Role::create(['nama' => 'Senpai']);
        $kohaiRole = Role::create(['nama' => 'Kohai']);

        $belt = Belt::create(['name' => 'Sabuk Kuning', 'color_code' => '#eab308']);
        $rank = Rank::create(['belt_id' => $belt->id, 'category' => 'Kyu', 'name' => 'KYU 8', 'order' => 2]);

        $senpai = User::factory()->create([
            'name' => 'Senpai Kenji',
            'role_id' => $senpaiRole->id,
        ]);

        $kohai1 = User::factory()->create([
            'name' => 'Kohai Budi Pratama',
            'role_id' => $kohaiRole->id,
        ]);
        KohaiProfile::create([
            'user_id' => $kohai1->id,
            'type' => 'polindra',
            'rank_id' => $rank->id,
            'nim' => '2201001',
        ]);

        $kohai2 = User::factory()->create([
            'name' => 'Kohai Siti Rahma',
            'role_id' => $kohaiRole->id,
        ]);
        KohaiProfile::create([
            'user_id' => $kohai2->id,
            'type' => 'polindra',
            'rank_id' => $rank->id,
            'nim' => '2201002',
        ]);

        // Sesi Absensi
        $session = AttendanceSession::createNewSession($senpai->id, 'Latihan Kumite Malam', now()->toDateString());
        Attendance::create([
            'attendance_session_id' => $session->id,
            'kohai_id' => $kohai1->id,
            'scanned_at' => now(),
            'status' => 'Hadir',
        ]);

        // Pertandingan Kumite dimana Kohai 1 Menang
        KumiteReport::create([
            'senpai_id' => $senpai->id,
            'aka_kohai_id' => $kohai1->id,
            'ao_kohai_id' => $kohai2->id,
            'match_date' => now()->toDateString(),
            'match_time' => '17:00',
            'duration_seconds' => 180,
            'aka_ippon' => 2,
            'aka_wazaari' => 0,
            'aka_yuko' => 0,
            'aka_fouls' => 0,
            'aka_score_attack' => 20,
            'aka_score_accuracy' => 60,
            'aka_total_score' => 6,
            'ao_ippon' => 0,
            'ao_wazaari' => 1,
            'ao_yuko' => 0,
            'ao_fouls' => 0,
            'ao_score_attack' => 15,
            'ao_score_accuracy' => 30,
            'ao_total_score' => 2,
            'winner_id' => $kohai1->id,
        ]);

        $response = $this->actingAs($kohai1)->get(route('kohai.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Semangat Latihan, Kohai Budi Pratama!');
        $response->assertSee('KYU 8 (Sabuk Kuning)');
        $response->assertSee('2201001');
        $response->assertSee('1 Laga');
        $response->assertSee('100%'); // 1 win from 1 match
        $response->assertSee('MENANG');
    }
}
