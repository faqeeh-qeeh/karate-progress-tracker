<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationGuideTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_guest_can_access_registrasi_page(): void
    {
        $response = $this->get('/registrasi');

        $response->assertStatus(200);
        $response->assertSee('Tata Cara Registrasi Anggota');
        $response->assertSee('karatepolindra@gmail.com');
        $response->assertSee('Format Email Pendaftaran');
        $response->assertSee('Buka Langsung di Gmail');
    }

    public function test_guest_can_access_register_page(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Tata Cara Registrasi Anggota');
        $response->assertSee('karatepolindra@gmail.com');
    }

    public function test_authenticated_user_is_redirected_away_from_register_page(): void
    {
        $user = User::factory()->create([
            'role_id' => Role::where('nama', 'Kohai')->first()->id,
        ]);

        $response = $this->actingAs($user)->get('/registrasi');

        $response->assertRedirect('/');
    }
}
