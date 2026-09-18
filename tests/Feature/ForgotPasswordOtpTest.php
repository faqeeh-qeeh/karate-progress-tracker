<?php

namespace Tests\Feature;

use App\Mail\ResetPasswordOtpMail;
use App\Models\PasswordResetOtp;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ForgotPasswordOtpTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $role = Role::firstOrCreate(['nama' => 'Kohai']);
        $this->user = User::factory()->create([
            'email' => 'user_test@example.com',
            'phone' => '081234567890',
            'role_id' => $role->id,
            'password' => Hash::make('old_password_123'),
        ]);
    }

    public function test_user_can_view_forgot_password_form(): void
    {
        $response = $this->get(route('password.request'));

        $response->assertStatus(200);
        $response->assertSee('Lupa Kata Sandi?');
    }

    public function test_forgot_password_fails_if_phone_does_not_match(): void
    {
        Mail::fake();

        $response = $this->post(route('password.email'), [
            'email' => 'user_test@example.com',
            'phone' => '089999999999', // salah
        ]);

        $response->assertSessionHasErrors('phone');
        Mail::assertNothingSent();
    }

    public function test_user_receives_otp_when_email_and_phone_match(): void
    {
        Mail::fake();

        $response = $this->post(route('password.email'), [
            'email' => 'user_test@example.com',
            'phone' => '0812-3456-7890', // format dengan strip
        ]);

        $response->assertRedirect(route('password.otp.show'));
        $response->assertSessionHas('password_reset_email', 'user_test@example.com');

        $otpRecord = PasswordResetOtp::where('email', 'user_test@example.com')->first();
        $this->assertNotNull($otpRecord);
        $this->assertEquals(6, strlen($otpRecord->otp));
        $this->assertTrue($otpRecord->isOtpValid());

        Mail::assertSent(ResetPasswordOtpMail::class, function ($mail) use ($otpRecord) {
            return $mail->hasTo('user_test@example.com') && $mail->otp === $otpRecord->otp;
        });
    }

    public function test_user_cannot_verify_wrong_otp(): void
    {
        PasswordResetOtp::create([
            'email' => 'user_test@example.com',
            'otp' => '123456',
            'otp_expires_at' => now()->addMinutes(5),
        ]);

        $response = $this->withSession(['password_reset_email' => 'user_test@example.com'])
            ->post(route('password.otp.verify'), [
                'otp' => '654321', // salah
            ]);

        $response->assertSessionHasErrors('otp');
    }

    public function test_user_cannot_verify_expired_otp(): void
    {
        PasswordResetOtp::create([
            'email' => 'user_test@example.com',
            'otp' => '123456',
            'otp_expires_at' => now()->subMinute(), // sudah kedaluwarsa (>5 menit)
        ]);

        $response = $this->withSession(['password_reset_email' => 'user_test@example.com'])
            ->post(route('password.otp.verify'), [
                'otp' => '123456',
            ]);

        $response->assertSessionHasErrors('otp');
    }

    public function test_user_can_verify_valid_otp_and_receive_reset_token(): void
    {
        $otpRecord = PasswordResetOtp::create([
            'email' => 'user_test@example.com',
            'otp' => '123456',
            'otp_expires_at' => now()->addMinutes(5),
        ]);

        $response = $this->withSession(['password_reset_email' => 'user_test@example.com'])
            ->post(route('password.otp.verify'), [
                'otp' => '123456',
            ]);

        $otpRecord->refresh();

        $this->assertNotEmpty($otpRecord->reset_token);
        $this->assertTrue($otpRecord->isResetTokenValid());
        $response->assertRedirect(route('password.reset.form', ['token' => $otpRecord->reset_token]));
    }

    public function test_user_can_reset_password_with_valid_token_and_login(): void
    {
        $token = 'valid-test-reset-token-60-characters-long-string-for-verification';

        PasswordResetOtp::create([
            'email' => 'user_test@example.com',
            'otp' => '',
            'reset_token' => $token,
            'otp_expires_at' => now()->subMinutes(10),
            'reset_expires_at' => now()->addHours(2), // Berlaku 2 jam
        ]);

        // Cek halaman form reset
        $viewResponse = $this->get(route('password.reset.form', ['token' => $token]));
        $viewResponse->assertStatus(200);
        $viewResponse->assertSee('Atur Kata Sandi Baru');

        // Submit ganti password baru
        $response = $this->post(route('password.reset.submit', ['token' => $token]), [
            'password' => 'new_secure_password_99',
            'password_confirmation' => 'new_secure_password_99',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('success');

        $this->user->refresh();
        $this->assertTrue(Hash::check('new_secure_password_99', $this->user->password));
        $this->assertDatabaseMissing('password_reset_otps', ['reset_token' => $token]);

        // Login dengan password baru
        $loginResponse = $this->post(route('login.post'), [
            'email' => 'user_test@example.com',
            'password' => 'new_secure_password_99',
        ]);
        $this->assertAuthenticatedAs($this->user);
        $loginResponse->assertRedirect(route('kohai.dashboard'));
    }

    public function test_reset_password_fails_if_token_is_expired(): void
    {
        $token = 'expired-token-over-2-hours';

        PasswordResetOtp::create([
            'email' => 'user_test@example.com',
            'otp' => '',
            'reset_token' => $token,
            'otp_expires_at' => now()->subMinutes(130),
            'reset_expires_at' => now()->subMinutes(10), // Kedaluwarsa > 2 jam
        ]);

        $response = $this->get(route('password.reset.form', ['token' => $token]));
        $response->assertRedirect(route('password.request'));
        $response->assertSessionHas('error');
    }
}
