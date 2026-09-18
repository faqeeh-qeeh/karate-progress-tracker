<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AccountActivationMail;
use App\Models\KohaiProfile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Tampilkan daftar seluruh pengguna.
     */
    public function index(Request $request): View
    {
        $query = User::with(['role', 'kohaiProfile'])->latest();

        // Filter Pencarian (Nama / Email)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter Berdasarkan Role
        if ($request->filled('role_id')) {
            $query->where('role_id', $request->role_id);
        }

        $users = $query->paginate(10)->withQueryString();
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Tampilkan form pembuatan akun pengguna baru.
     */
    public function create(): View
    {
        $roles = Role::all();

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Tampilkan detail lengkap biodata akun pengguna.
     */
    public function show(User $user): View
    {
        $user->load([
            'role',
            'senpaiProfile.rank.belt',
            'kohaiProfile.studyProgram.department',
            'kohaiProfile.academicClass',
            'kohaiProfile.rank.belt',
        ]);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Simpan akun pengguna baru ke basis data dan kirim email aktivasi.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role_id' => ['required', 'exists:roles,id'],
            'kohai_type' => ['nullable', 'in:polindra,non_polindra'],
            'birth_place' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date'],
            'gender' => ['required', 'in:male,female'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap pengguna wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Alamat email ini sudah terdaftar.',
            'role_id.required' => 'Role pengguna wajib dipilih.',
            'birth_place.required' => 'Tempat lahir wajib diisi.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'birth_date.date' => 'Format tanggal lahir tidak valid.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'gender.in' => 'Pilihan jenis kelamin tidak valid.',
            'phone.required' => 'Nomor kontak/telepon wajib diisi.',
            'address.required' => 'Alamat lengkap wajib diisi.',
            'password.min' => 'Password minimal 6 karakter jika diisi manual.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Jika password tidak diisi oleh admin, generate password acak sementara
        $rawPassword = !empty($validated['password']) ? $validated['password'] : Str::random(32);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role_id' => $validated['role_id'],
            'birth_place' => $validated['birth_place'],
            'birth_date' => $validated['birth_date'],
            'gender' => $validated['gender'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'password' => Hash::make($rawPassword),
            'email_verified_at' => null, // Belum terverifikasi sebelum user membuka link
        ]);

        $kohaiRole = Role::whereRaw('LOWER(nama) = ?', ['kohai'])->first();
        if ($user->role_id == $kohaiRole?->id) {
            KohaiProfile::create([
                'user_id' => $user->id,
                'type' => $request->input('kohai_type', 'polindra'),
            ]);
        }

        // Kirim email aktivasi dan pengaturan kata sandi
        $emailStatusMsg = '';
        try {
            Mail::to($user->email)->send(new AccountActivationMail($user));
            $emailStatusMsg = ' dan email arahan aktivasi akun telah dikirimkan ke ' . $user->email . '.';
        } catch (\Exception $e) {
            Log::error('Gagal mengirim email aktivasi ke ' . $user->email . ': ' . $e->getMessage());
            $emailStatusMsg = ', namun pengiriman email aktivasi mengalami kendala teknis (cek konfigurasi mailer).';
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Akun pengguna "' . $validated['name'] . '" berhasil ditambahkan' . $emailStatusMsg);
    }

    /**
     * Kirim ulang email arahan & aktivasi akun ke pengguna.
     */
    public function resendActivation(User $user): RedirectResponse
    {
        if ($user->hasVerifiedEmail()) {
            return back()->with('info', 'Email pengguna "' . $user->name . '" sudah terverifikasi sebelumnya.');
        }

        try {
            Mail::to($user->email)->send(new AccountActivationMail($user));
            return back()->with('success', 'Email aktivasi dan tautan pengaturan kata sandi berhasil dikirim ulang ke "' . $user->email . '".');
        } catch (\Exception $e) {
            Log::error('Gagal mengirim ulang email aktivasi ke ' . $user->email . ': ' . $e->getMessage());
            return back()->with('error', 'Gagal mengirim ulang email: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan form edit akun pengguna.
     */
    public function edit(User $user): View
    {
        $user->load('kohaiProfile');
        $roles = Role::all();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Perbarui data akun pengguna di basis data.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role_id' => ['required', 'exists:roles,id'],
            'kohai_type' => ['nullable', 'in:polindra,non_polindra'],
            'birth_place' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date'],
            'gender' => ['required', 'in:male,female'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap pengguna wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Alamat email ini sudah digunakan oleh pengguna lain.',
            'role_id.required' => 'Role pengguna wajib dipilih.',
            'birth_place.required' => 'Tempat lahir wajib diisi.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'birth_date.date' => 'Format tanggal lahir tidak valid.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'gender.in' => 'Pilihan jenis kelamin tidak valid.',
            'phone.required' => 'Nomor kontak/telepon wajib diisi.',
            'address.required' => 'Alamat lengkap wajib diisi.',
            'password.min' => 'Password baru minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role_id' => $validated['role_id'],
            'birth_place' => $validated['birth_place'],
            'birth_date' => $validated['birth_date'],
            'gender' => $validated['gender'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
        ];

        if (!empty($validated['password'])) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $user->update($userData);

        $kohaiRole = Role::whereRaw('LOWER(nama) = ?', ['kohai'])->first();
        if ($user->role_id == $kohaiRole?->id) {
            KohaiProfile::updateOrCreate(
                ['user_id' => $user->id],
                ['type' => $request->input('kohai_type', 'polindra')]
            );
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Data akun pengguna "' . $user->name . '" berhasil diperbarui.');
    }

    /**
     * Hapus akun pengguna.
     */
    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Akun pengguna "' . $userName . '" berhasil dihapus.');
    }
}
