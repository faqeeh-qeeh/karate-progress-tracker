<?php

namespace Tests\Feature;

use App\Mail\AccountActivationMail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class AccountActivationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_user_and_trigger_activation_email(): void
    {
        Mail::fake();

        $adminRole = Role::firstOrCreate(['nama' => 'admin']);
        $kohaiRole = Role::firstOrCreate(['nama' => 'Kohai']);

        $admin = User::factory()->create([
            'role_id' => $adminRole->id,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => 'Kohai Baru',
            'email' => 'kohaibaru@test.com',
            'role_id' => $kohaiRole->id,
            'birth_place' => 'Indramayu',
            'birth_date' => '2004-05-15',
            'gender' => 'male',
            'phone' => '081234567890',
            'address' => 'Jl. Lohbener No. 10',
            'kohai_type' => 'polindra',
        ]);

        $response->assertRedirect(route('admin.users.index'));

        $this->assertDatabaseHas('users', [
            'email' => 'kohaibaru@test.com',
            'email_verified_at' => null,
        ]);

        Mail::assertSent(AccountActivationMail::class, function ($mail) {
            return $mail->hasTo('kohaibaru@test.com');
        });
    }

    public function test_user_can_view_set_password_page_with_valid_signature(): void
    {
        $kohaiRole = Role::firstOrCreate(['nama' => 'Kohai']);

        $user = User::factory()->create([
            'role_id' => $kohaiRole->id,
            'email_verified_at' => null,
        ]);

        $url = URL::temporarySignedRoute(
            'account.activate',
            now()->addHours(72),
            [
                'id' => $user->id,
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );

        $response = $this->get($url);

        $response->assertStatus(200);
        $response->assertSee('Aktivasi Akun Baru');
        $response->assertSee($user->email);
    }

    public function test_invalid_signature_is_rejected(): void
    {
        $kohaiRole = Role::firstOrCreate(['nama' => 'Kohai']);

        $user = User::factory()->create([
            'role_id' => $kohaiRole->id,
            'email_verified_at' => null,
        ]);

        // URL tanpa signature valid
        $url = route('account.activate', [
            'id' => $user->id,
            'hash' => sha1($user->getEmailForVerification()),
        ]);

        $response = $this->get($url);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error');
    }

    public function test_user_can_set_password_and_verify_email_and_redirect_to_login(): void
    {
        $kohaiRole = Role::firstOrCreate(['nama' => 'Kohai']);

        $user = User::factory()->create([
            'role_id' => $kohaiRole->id,
            'email' => 'kohai_test@example.com',
            'email_verified_at' => null,
            'password' => Hash::make('initial-random-pass'),
        ]);

        // Coba login sebelum aktivasi -> harus ditolak
        $loginAttempt = $this->post(route('login.post'), [
            'email' => 'kohai_test@example.com',
            'password' => 'initial-random-pass',
        ]);
        $loginAttempt->assertSessionHasErrors('email');
        $this->assertGuest();

        $url = URL::temporarySignedRoute(
            'account.activate',
            now()->addHours(72),
            [
                'id' => $user->id,
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );

        $response = $this->post($url, [
            'password' => 'newsecret123',
            'password_confirmation' => 'newsecret123',
        ]);

        $user->refresh();

        $this->assertNotNull($user->email_verified_at);
        $this->assertTrue(Hash::check('newsecret123', $user->password));
        $this->assertGuest();
        $response->assertRedirect(route('login'));
        $response->assertSessionHas('success');

        // Login setelah aktivasi -> harus berhasil
        $successLogin = $this->post(route('login.post'), [
            'email' => 'kohai_test@example.com',
            'password' => 'newsecret123',
        ]);
        $this->assertAuthenticatedAs($user);
        $successLogin->assertRedirect(route('kohai.dashboard'));
    }

    public function test_admin_can_resend_activation_email(): void
    {
        Mail::fake();

        $adminRole = Role::firstOrCreate(['nama' => 'admin']);
        $senpaiRole = Role::firstOrCreate(['nama' => 'Senpai']);

        $admin = User::factory()->create([
            'role_id' => $adminRole->id,
        ]);

        $senpai = User::factory()->create([
            'role_id' => $senpaiRole->id,
            'email' => 'senpai@test.com',
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.users.resend-activation', $senpai->id));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        Mail::assertSent(AccountActivationMail::class, function ($mail) {
            return $mail->hasTo('senpai@test.com');
        });
    }
}
