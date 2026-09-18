<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AccountActivationController extends Controller
{
    /**
     * Tampilkan formulir pengaturan kata sandi dan aktivasi akun.
     */
    public function show(Request $request, int|string $id, string $hash): View|RedirectResponse
    {
        // 1. Verifikasi Validitas Signed URL
        if (! $request->hasValidSignature()) {
            return redirect()->route('login')
                ->with('error', 'Tautan aktivasi tidak valid atau telah kedaluwarsa. Silakan hubungi admin dojo untuk meminta tautan aktivasi baru.');
        }

        $user = User::with('role')->findOrFail($id);

        // 2. Verifikasi Hash Email
        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return redirect()->route('login')
                ->with('error', 'Tautan aktivasi tidak valid untuk akun ini.');
        }

        // 3. Jika email sudah terverifikasi sebelumnya
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login')
                ->with('info', 'Akun Anda sudah aktif dan email telah terverifikasi sebelumnya. Silakan masuk menggunakan kata sandi Anda.');
        }

        return view('auth.set-password', [
            'user' => $user,
            'id' => $id,
            'hash' => $hash,
        ]);
    }

    /**
     * Simpan kata sandi baru, tandai email terverifikasi, dan login otomatis ke dashboard.
     */
    public function activate(Request $request, int|string $id, string $hash): RedirectResponse
    {
        // 1. Verifikasi Validitas Signed URL
        if (! $request->hasValidSignature()) {
            return redirect()->route('login')
                ->with('error', 'Tautan aktivasi tidak valid atau telah kedaluwarsa. Silakan hubungi admin dojo untuk meminta tautan baru.');
        }

        $user = User::findOrFail($id);

        // 2. Verifikasi Hash Email
        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return redirect()->route('login')
                ->with('error', 'Tautan aktivasi tidak cocok dengan data akun.');
        }

        // 3. Validasi Password
        $request->validate([
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi minimal terdiri dari 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        // 4. Update Password dan Verifikasi Email
        $user->forceFill([
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
        ])->save();

        // 5. Arahkan ke halaman login (tidak login otomatis)
        return redirect()->route('login')
            ->with('success', 'Akun Anda (' . $user->email . ') telah berhasil diaktivasi dan email terverifikasi! Silakan masuk menggunakan kata sandi baru Anda.');
    }
}
