<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SenpaiSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_senpai_can_access_settings_page(): void
    {
        $senpaiRole = Role::create(['nama' => 'Senpai']);

        $senpai = User::factory()->create([
            'role_id' => $senpaiRole->id,
        ]);

        $response = $this->actingAs($senpai)->get(route('senpai.settings.index'));

        $response->assertStatus(200);
        $response->assertSee('Pengaturan & Tampilan Senpai', false);
        $response->assertSee('Mode Tampilan & Tema Warna', false);
        $response->assertSee('Informasi Akun & Instruktur Senpai', false);
    }

    public function test_guest_cannot_access_senpai_settings_page(): void
    {
        $response = $this->get(route('senpai.settings.index'));

        $response->assertRedirect(route('login'));
    }
}
