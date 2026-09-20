<?php

namespace Tests\Feature;

use App\Models\AcademicClass;
use App\Models\Attendance;
use App\Models\AttendanceSession;
use App\Models\Belt;
use App\Models\Department;
use App\Models\KumiteReport;
use App\Models\Rank;
use App\Models\Role;
use App\Models\StudyProgram;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_renders_with_real_metrics()
    {
        $adminRole = Role::create(['nama' => 'admin']);
        $senpaiRole = Role::create(['nama' => 'Senpai']);
        $kohaiRole = Role::create(['nama' => 'Kohai']);

        $admin = User::factory()->create([
            'name' => 'Super Admin',
            'role_id' => $adminRole->id,
        ]);

        $senpai = User::factory()->create([
            'name' => 'Senpai Kenji',
            'role_id' => $senpaiRole->id,
        ]);

        $kohai = User::factory()->create([
            'name' => 'Kohai Budi',
            'role_id' => $kohaiRole->id,
        ]);

        $dept = Department::create(['name' => 'Teknik Informatika', 'code' => 'TI']);
        $prodi = StudyProgram::create(['department_id' => $dept->id, 'name' => 'D4 Rekayasa Perangkat Lunak', 'code' => 'RPL']);
        $class = AcademicClass::create(['study_program_id' => $prodi->id, 'name' => 'RPL 1A']);

        $belt = Belt::create(['name' => 'Sabuk Putih', 'color_code' => '#ffffff']);
        $rank = Rank::create(['belt_id' => $belt->id, 'category' => 'Kyu', 'name' => 'KYU 10', 'order' => 1]);

        $session = AttendanceSession::createNewSession($senpai->id, 'Latihan Perdana', now()->toDateString());
        Attendance::create([
            'attendance_session_id' => $session->id,
            'kohai_id' => $kohai->id,
            'scanned_at' => now(),
            'status' => 'Hadir',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Selamat Datang, Admin Super Admin!');
        $response->assertSee('Total Pengguna');
        $response->assertSee('Pelatih (Senpai)');
        $response->assertSee('Murid (Kohai)');
        $response->assertSee('Latihan Perdana');
    }
}
