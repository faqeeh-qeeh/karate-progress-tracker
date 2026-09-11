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
     * Tampilkan form registrasi.
     */
    public function showRegister(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect(Auth::user()->getDashboardRoute());
        }

        // Ambil pilihan role untuk pendaftaran (Senpai & Kohai, atau Admin jika diinginkan)
        $roles = Role::whereIn('nama', ['Senpai', 'Kohai'])->get();

        return view('auth.register', compact('roles'));
    }

    /**
     * Proses registrasi user baru.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role_id' => ['required', 'exists:roles,id'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Email tersebut sudah terdaftar.',
            'role_id.required' => 'Pilihan role wajib dipilih.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role_id' => $validated['role_id'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect($user->getDashboardRoute())
            ->with('success', 'Akun berhasil dibuat! Selamat datang di sistem Karate.');
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
