<?php

namespace Tests\Feature;

use App\Models\Attendance;
use App\Models\AttendanceSession;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendanceTest extends TestCase
{
    use RefreshDatabase;

    protected User $senpai;
    protected User $kohai;

    protected function setUp(): void
    {
        parent::setUp();

        $senpaiRole = Role::create(['nama' => 'Senpai']);
        $kohaiRole = Role::create(['nama' => 'Kohai']);

        $this->senpai = User::factory()->create([
            'name' => 'Senpai Kenji',
            'role_id' => $senpaiRole->id,
        ]);

        $this->kohai = User::factory()->create([
            'name' => 'Kohai Budi',
            'role_id' => $kohaiRole->id,
        ]);
    }

    public function test_senpai_can_create_attendance_session_and_generate_qr()
    {
        $response = $this->actingAs($this->senpai)
            ->post(route('senpai.attendance.store'), [
                'title' => 'Latihan Rutin Sesi 1',
                'date' => now()->toDateString(),
            ]);

        $response->assertRedirect(route('senpai.attendance.index'));
        $this->assertDatabaseHas('attendance_sessions', [
            'senpai_id' => $this->senpai->id,
            'title' => 'Latihan Rutin Sesi 1',
            'is_active' => true,
        ]);
    }

    public function test_creating_new_session_deactivates_previous_session_qr()
    {
        // 1. Senpai buat sesi A
        $sessionA = AttendanceSession::createNewSession($this->senpai->id, 'Sesi A', now()->toDateString());
        $this->assertTrue($sessionA->is_active);

        // 2. Senpai buat sesi B
        $sessionB = AttendanceSession::createNewSession($this->senpai->id, 'Sesi B', now()->toDateString());

        // 3. Pastikan sesi A otomatis ditutup (is_active = false)
        $sessionA->refresh();
        $this->assertFalse($sessionA->is_active);
        $this->assertTrue($sessionB->is_active);

        // 4. Kohai mencoba scan sesi A (yang sudah kadaluarsa)
        $responseA = $this->actingAs($this->kohai)
            ->post(route('kohai.attendance.scan'), [
                'qr_token' => $sessionA->qr_token,
            ]);

        $responseA->assertSessionHas('error');
        $this->assertDatabaseMissing('attendances', [
            'attendance_session_id' => $sessionA->id,
            'kohai_id' => $this->kohai->id,
        ]);

        // 5. Kohai scan sesi B (yang masih aktif)
        $responseB = $this->actingAs($this->kohai)
            ->post(route('kohai.attendance.scan'), [
                'qr_token' => $sessionB->qr_token,
            ]);

        $responseB->assertSessionHas('success');
        $this->assertDatabaseHas('attendances', [
            'attendance_session_id' => $sessionB->id,
            'kohai_id' => $this->kohai->id,
            'status' => 'Hadir',
        ]);
    }

    public function test_kohai_cannot_scan_same_session_twice()
    {
        $session = AttendanceSession::createNewSession($this->senpai->id, 'Sesi Kumite', now()->toDateString());

        // Scan pertama
        $this->actingAs($this->kohai)->post(route('kohai.attendance.scan'), [
            'qr_token' => $session->qr_token,
        ]);

        // Scan kedua
        $response2 = $this->actingAs($this->kohai)->post(route('kohai.attendance.scan'), [
            'qr_token' => $session->qr_token,
        ]);

        $response2->assertSessionHas('error');
        $this->assertEquals(1, Attendance::where('attendance_session_id', $session->id)->count());
    }

    public function test_reactivating_existing_session_on_same_date()
    {
        $today = now()->toDateString();
        
        // 1. Buat sesi awal pada tanggal ini
        $session = AttendanceSession::createNewSession($this->senpai->id, 'Sesi Pagi', $today);
        
        // 2. Kohai absen
        Attendance::create([
            'attendance_session_id' => $session->id,
            'kohai_id' => $this->kohai->id,
            'scanned_at' => now(),
            'status' => 'Hadir',
        ]);

        // 3. Sesi ditutup oleh Senpai
        $session->update(['is_active' => false]);
        $this->assertFalse($session->fresh()->is_active);

        // 4. Senpai menginputkan tanggal yang sama tanpa action_choice -> memicu warning
        $responseWarn = $this->actingAs($this->senpai)->post(route('senpai.attendance.store'), [
            'title' => 'Latihan Lanjutan',
            'date' => $today,
        ]);
        $responseWarn->assertSessionHas('existing_session_warning');

        // 5. Senpai memilih untuk melanjutkan (reactivate)
        $responseReactivate = $this->actingAs($this->senpai)->post(route('senpai.attendance.store'), [
            'title' => 'Latihan Lanjutan',
            'date' => $today,
            'action_choice' => 'reactivate',
        ]);

        $responseReactivate->assertRedirect(route('senpai.attendance.index'));
        $this->assertTrue($session->fresh()->is_active);
        
        // Data presensi Kohai sebelumnya tetap ada
        $this->assertEquals(1, Attendance::where('attendance_session_id', $session->id)->count());
    }
}
