<?php

namespace App\Http\Controllers\Senpai;

use App\Http\Controllers\Controller;
use App\Models\Belt;
use App\Models\Rank;
use App\Models\SenpaiProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman formulir biodata / profil Senpai.
     */
    public function index(): View
    {
        $user = Auth::user()->load(['senpaiProfile.rank.belt']);
        $belts = Belt::with(['ranks' => fn($q) => $q->orderBy('order')])->orderBy('id')->get();
        $ranks = Rank::with('belt')->orderBy('order')->get();
        $profile = $user->senpaiProfile ?? new SenpaiProfile();

        return view('senpai.profile.index', compact('user', 'belts', 'ranks', 'profile'));
    }

    /**
     * Perbarui data biodata / profil Senpai.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', 'string', 'max:20'],
            'birth_place' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date'],
            'gender' => ['required', 'in:male,female'],
            'address' => ['required', 'string'],
            'rank_id' => ['nullable', 'exists:ranks,id'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.',
            'phone.required' => 'Nomor HP / WhatsApp wajib diisi.',
            'birth_place.required' => 'Tempat lahir wajib diisi.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'birth_date.date' => 'Format tanggal lahir tidak valid.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'address.required' => 'Alamat lengkap wajib diisi.',
            'rank_id.exists' => 'Tingkat sabuk tidak valid.',
            'password.min' => 'Kata sandi baru minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        // Update User data
        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'birth_place' => $validated['birth_place'],
            'birth_date' => $validated['birth_date'],
            'gender' => $validated['gender'],
            'address' => $validated['address'],
        ];

        if (!empty($validated['password'])) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $user->update($userData);

        // Update / create SenpaiProfile data
        SenpaiProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'rank_id' => $validated['rank_id'] ?? null,
            ]
        );

        return redirect()->route('senpai.profile.index')
            ->with('success', 'Biodata Senpai berhasil diperbarui!');
    }
}
