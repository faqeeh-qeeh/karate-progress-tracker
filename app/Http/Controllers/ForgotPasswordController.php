<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordOtpMail;
use App\Models\PasswordResetOtp;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ForgotPasswordController extends Controller
{
    /**
     * Tampilkan formulir permintaan lupa kata sandi (Email + No. HP).
     */
    public function showForgotForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect(Auth::user()->getDashboardRoute());
        }

        return view('auth.forgot-password');
    }

    /**
     * Validasi kecocokan Email & No. HP, buat kode OTP 6-digit (5 menit), dan kirim email.
     */
    public function sendOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'phone' => ['required', 'string'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'phone.required' => 'Nomor kontak/telepon terdaftar wajib diisi.',
        ]);

        $user = User::where('email', $request->email)->first();

        // Normalisasi nomor telepon untuk membandingkan (hapus spasi, tanda minus, titik)
        $inputPhone = preg_replace('/[^0-9]/', '', $request->phone);
        $userPhone = $user ? preg_replace('/[^0-9]/', '', $user->phone) : '';

        // Cek kecocokan user dan nomor telepon
        if (! $user || empty($userPhone) || $inputPhone !== $userPhone) {
            return back()
                ->withErrors([
                    'phone' => 'Kombinasi alamat email dan nomor telepon tidak cocok dengan data pengguna terdaftar.',
                ])
                ->withInput();
        }

        // Generate kode OTP 6 digit angka
        $otp = (string) random_int(100000, 999999);

        // Simpan / perbarui catatan OTP dengan masa kedaluwarsa 5 menit
        PasswordResetOtp::updateOrCreate(
            ['email' => $user->email],
            [
                'otp' => $otp,
                'reset_token' => null,
                'otp_expires_at' => now()->addMinutes(5),
                'reset_expires_at' => null,
            ]
        );

        // Simpan email ke dalam session untuk proses verifikasi OTP
        session(['password_reset_email' => $user->email]);

        // Kirim email OTP
        try {
            Mail::to($user->email)->send(new ResetPasswordOtpMail($user, $otp, 5));
        } catch (\Exception $e) {
            Log::error('Gagal mengirim email OTP reset password ke ' . $user->email . ': ' . $e->getMessage());
            return back()
                ->with('error', 'Terjadi kendala saat mengirimkan email OTP. Silakan periksa konfigurasi mailer atau coba lagi.')
                ->withInput();
        }

        return redirect()->route('password.otp.show')
            ->with('success', 'Kode verifikasi 6 digit telah dikirimkan ke email Anda. Berlaku selama 5 menit.');
    }

    /**
     * Tampilkan halaman formulir verifikasi kode OTP.
     */
    public function showVerifyOtpForm(): View|RedirectResponse
    {
        $email = session('password_reset_email');

        if (! $email) {
            return redirect()->route('password.request')
                ->with('info', 'Silakan masukkan alamat email dan nomor telepon Anda terlebih dahulu.');
        }

        $otpRecord = PasswordResetOtp::where('email', $email)->first();
        $expiresAt = $otpRecord?->otp_expires_at;

        return view('auth.verify-otp', compact('email', 'expiresAt'));
    }

    /**
     * Verifikasi kode OTP 6 digit dan buat Reset Token berlaku 2 jam.
     */
    public function verifyOtp(Request $request): RedirectResponse
    {
        $email = session('password_reset_email');

        if (! $email) {
            return redirect()->route('password.request')
                ->with('error', 'Sesi verifikasi telah berakhir. Silakan ulangi permintaan Anda.');
        }

        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ], [
            'otp.required' => 'Kode verifikasi OTP wajib diisi.',
            'otp.size' => 'Kode verifikasi OTP harus terdiri dari 6 digit angka.',
        ]);

        $otpRecord = PasswordResetOtp::where('email', $email)->first();

        if (! $otpRecord || $otpRecord->otp !== $request->otp) {
            return back()->withErrors(['otp' => 'Kode OTP yang Anda masukkan salah.'])->withInput();
        }

        if (! $otpRecord->isOtpValid()) {
            return back()->withErrors(['otp' => 'Kode OTP telah kedaluwarsa (melebihi batas waktu 5 menit). Silakan klik "Kirim Ulang Kode OTP".'])->withInput();
        }

        // OTP Valid! Generate Reset Token 60 karakter yang berlaku 2 jam
        $resetToken = Str::random(60);

        $otpRecord->update([
            'otp' => '', // Bersihkan OTP agar tidak dapat digunakan kembali
            'reset_token' => $resetToken,
            'reset_expires_at' => now()->addHours(2),
        ]);

        return redirect()->route('password.reset.form', ['token' => $resetToken])
            ->with('success', 'Kode OTP berhasil diverifikasi! Silakan tentukan kata sandi baru Anda (berlaku hingga 2 jam).');
    }

    /**
     * Kirim ulang kode OTP baru jika kode sebelumnya kedaluwarsa.
     */
    public function resendOtp(): RedirectResponse
    {
        $email = session('password_reset_email');

        if (! $email) {
            return redirect()->route('password.request')
                ->with('error', 'Sesi telah berakhir. Silakan masukkan email kembali.');
        }

        $user = User::where('email', $email)->first();

        if (! $user) {
            return redirect()->route('password.request')
                ->with('error', 'Data pengguna tidak ditemukan.');
        }

        $otp = (string) random_int(100000, 999999);

        PasswordResetOtp::updateOrCreate(
            ['email' => $user->email],
            [
                'otp' => $otp,
                'reset_token' => null,
                'otp_expires_at' => now()->addMinutes(5),
                'reset_expires_at' => null,
            ]
        );

        try {
            Mail::to($user->email)->send(new ResetPasswordOtpMail($user, $otp, 5));
        } catch (\Exception $e) {
            Log::error('Gagal mengirim ulang email OTP ke ' . $user->email . ': ' . $e->getMessage());
            return back()->with('error', 'Gagal mengirim ulang OTP: ' . $e->getMessage());
        }

        return back()->with('success', 'Kode OTP baru telah berhasil dikirimkan ke email Anda.');
    }

    /**
     * Tampilkan formulir pembuatan kata sandi baru (Validitas token 2 jam).
     */
    public function showResetPasswordForm(string $token): View|RedirectResponse
    {
        $otpRecord = PasswordResetOtp::where('reset_token', $token)->first();

        if (! $otpRecord || ! $otpRecord->isResetTokenValid()) {
            return redirect()->route('password.request')
                ->with('error', 'Sesi reset kata sandi tidak valid atau telah kedaluwarsa (melebihi batas waktu 2 jam). Silakan ajukan permohonan baru.');
        }

        $user = User::where('email', $otpRecord->email)->first();

        return view('auth.reset-password-otp', [
            'token' => $token,
            'email' => $otpRecord->email,
            'user' => $user,
        ]);
    }

    /**
     * Simpan kata sandi baru pengguna dan bersihkan token reset.
     */
    public function resetPassword(Request $request, string $token): RedirectResponse
    {
        $otpRecord = PasswordResetOtp::where('reset_token', $token)->first();

        if (! $otpRecord || ! $otpRecord->isResetTokenValid()) {
            return redirect()->route('password.request')
                ->with('error', 'Sesi reset kata sandi telah kedaluwarsa. Silakan ajukan permohonan baru.');
        }

        $request->validate([
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi minimal terdiri dari 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $user = User::where('email', $otpRecord->email)->firstOrFail();

        // Update kata sandi baru dan pastikan email terverifikasi
        $user->forceFill([
            'password' => Hash::make($request->password),
            'email_verified_at' => $user->email_verified_at ?? now(),
        ])->save();

        // Hapus token OTP dari database
        $otpRecord->delete();
        session()->forget('password_reset_email');

        return redirect()->route('login')
            ->with('success', 'Kata sandi akun Anda berhasil diperbarui! Silakan masuk menggunakan kata sandi baru Anda.');
    }
}
