<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KohaiSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_kohai_can_access_settings_page(): void
    {
        $kohaiRole = Role::create(['nama' => 'Kohai']);

        $kohai = User::factory()->create([
            'role_id' => $kohaiRole->id,
        ]);

        $response = $this->actingAs($kohai)->get(route('kohai.settings.index'));

        $response->assertStatus(200);
        $response->assertSee('Pengaturan & Tampilan Kohai', false);
        $response->assertSee('Mode Tampilan & Tema Warna', false);
        $response->assertSee('Informasi Akun & Keanggotaan Kohai', false);
    }

    public function test_guest_cannot_access_kohai_settings_page(): void
    {
        $response = $this->get(route('kohai.settings.index'));

        $response->assertRedirect(route('login'));
    }
}
