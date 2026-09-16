<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

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
            $request->session()->regenerate();
            $user = Auth::user();

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
}
