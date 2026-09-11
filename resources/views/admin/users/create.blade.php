@extends('layouts.admin')

@section('title', 'Tambah Akun Pengguna Baru')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Back Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-brand-black">Tambah Akun Pengguna Baru</h1>
            <p class="text-xs text-gray-500 mt-1">Buat akun pengguna baru dengan penetapan role (Admin, Senpai, atau Kohai)</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-xs font-bold rounded-xl transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Create User Form Card -->
    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-100 shadow-sm">
        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Name Field -->
            <div>
                <label for="name" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Nama Lengkap Pengguna</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                    placeholder="Contoh: Sensei Ahmad Kurnia"
                    class="w-full px-4 py-2.5 rounded-xl border @error('name') border-red-500 bg-red-50/30 @else border-gray-300 bg-gray-50/50 @enderror text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white transition">
                @error('name')
                    <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Alamat Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                    placeholder="pengguna@karate.com"
                    class="w-full px-4 py-2.5 rounded-xl border @error('email') border-red-500 bg-red-50/30 @else border-gray-300 bg-gray-50/50 @enderror text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white transition">
                @error('email')
                    <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Role Selection -->
            <div>
                <label for="role_id" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Role / Hak Akses</label>
                <select name="role_id" id="role_id" required
                    class="w-full px-4 py-2.5 rounded-xl border @error('role_id') border-red-500 bg-red-50/30 @else border-gray-300 bg-gray-50/50 @enderror text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white transition">
                    <option value="" disabled selected>-- Pilih Role Pengguna --</option>
                    @foreach($roles as $r)
                        <option value="{{ $r->id }}" {{ old('role_id') == $r->id ? 'selected' : '' }}>
                            Role: {{ $r->nama }}
                        </option>
                    @endforeach
                </select>
                @error('role_id')
                    <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Password</label>
                    <input type="password" name="password" id="password" required
                        placeholder="Minimal 6 karakter"
                        class="w-full px-4 py-2.5 rounded-xl border @error('password') border-red-500 bg-red-50/30 @else border-gray-300 bg-gray-50/50 @enderror text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white transition">
                    @error('password')
                        <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        placeholder="Ulangi password"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 bg-gray-50/50 text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white transition">
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-brand-primary hover:bg-brand-primary/90 text-white font-bold text-sm shadow-md transition">
                    Simpan Akun Baru
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
