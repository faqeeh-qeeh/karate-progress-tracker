<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Tampilkan form login manual.
     */
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect(Auth::user()->getDashboardRoute());
        }

        return view('auth.login');
    }

    /**
     * Proses otentikasi login manual.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // Cek apakah email sudah terverifikasi / akun telah diaktivasi
            if (! $user->hasVerifiedEmail()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()
                    ->withErrors(['email' => 'Akun Anda belum diaktivasi. Silakan periksa inbox/spam email Anda dan klik tautan konfirmasi untuk mengaktifkan akun serta mengatur kata sandi terlebih dahulu.'])
                    ->onlyInput('email');
            }

            $request->session()->regenerate();

            return redirect($user->getDashboardRoute())
                ->with('success', 'Selamat datang kembali, ' . $user->name . '!');
        }

        return back()
            ->withErrors(['email' => 'Email atau password yang Anda masukkan salah.'])
            ->onlyInput('email');
    }

    /**
     * Tampilkan form registrasi (Dialihkan ke login karena registrasi dikelola Admin).
     */
    public function showRegister(): RedirectResponse
    {
        if (Auth::check()) {
            return redirect(Auth::user()->getDashboardRoute());
        }

        return redirect()->route('login')
            ->with('info', 'Pendaftaran akun baru dikelola langsung oleh Admin Karate Polindra. Silakan hubungi pengurus/admin dojo untuk pembuatan akun.');
    }

    /**
     * Proses registrasi user baru (Dialihkan ke login).
     */
    public function register(Request $request): RedirectResponse
    {
        return redirect()->route('login')
            ->with('info', 'Pendaftaran akun baru dikelola langsung oleh Admin Karate Polindra. Silakan hubungi pengurus/admin dojo untuk pembuatan akun.');
    }

    /**
     * Proses logout.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda telah berhasil keluar dari sistem.');
    }

    /**
     * Redirect ke halaman OAuth Google.
     */
    public function redirectToGoogle(): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Tangani callback dari Google setelah autentikasi.
     * Hanya izinkan login jika email sudah terdaftar (dibuat oleh Admin).
     */
    public function handleGoogleCallback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            // State tidak cocok — biasanya karena session expired atau dibuka di tab berbeda.
            // Solusi: minta user mencoba lagi (redirect ulang ke Google).
            return redirect()->route('auth.google');
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->withErrors(['google' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }

        // Cari user berdasarkan email Google
        $user = User::where('email', $googleUser->getEmail())->first();

        // Tolak login jika email belum terdaftar di sistem
        if (! $user) {
            return redirect()->route('login')
                ->withErrors([
                    'google' => 'Email "' . $googleUser->getEmail() . '" belum terdaftar dalam sistem. '
                        . 'Pendaftaran akun dikelola oleh Admin Karate Polindra. '
                        . 'Silakan hubungi pengurus/admin dojo untuk pembuatan akun.',
                ]);
        }

        // Simpan google_id jika belum tersimpan
        if (! $user->google_id) {
            $user->update(['google_id' => $googleUser->getId()]);
        }

        // Login user dan redirect ke dashboard sesuai role
        Auth::login($user, remember: true);
        request()->session()->regenerate();

        return redirect($user->getDashboardRoute())
            ->with('success', 'Selamat datang kembali, ' . $user->name . '!');
    }
}
