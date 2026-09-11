@extends('layouts.auth')

@section('title', 'Pendaftaran Akun Baru')

@section('content')
<div class="space-y-5">
    <div class="text-center">
        <h2 class="text-2xl font-bold text-brand-black">Daftar Akun Baru</h2>
        <p class="text-xs text-gray-500 mt-1">Lengkapi formulir untuk membuat akun Karate Dojo</p>
    </div>

    <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Nama Lengkap</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                placeholder="Contoh: Budi Santoso"
                class="w-full px-4 py-2.5 rounded-xl border @error('name') border-red-500 bg-red-50/30 @else border-gray-300 bg-gray-50/50 @enderror text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white transition duration-150">
            @error('name')
                <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Alamat Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                placeholder="nama@email.com"
                class="w-full px-4 py-2.5 rounded-xl border @error('email') border-red-500 bg-red-50/30 @else border-gray-300 bg-gray-50/50 @enderror text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white transition duration-150">
            @error('email')
                <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Role Select -->
        <div>
            <label for="role_id" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Daftar Sebagai Role</label>
            <select name="role_id" id="role_id" required
                class="w-full px-4 py-2.5 rounded-xl border @error('role_id') border-red-500 bg-red-50/30 @else border-gray-300 bg-gray-50/50 @enderror text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white transition duration-150">
                <option value="" disabled selected>-- Pilih Role --</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                        {{ $role->nama }} {{ $role->nama === 'Senpai' ? '(Pelatih / Senior)' : ($role->nama === 'Kohai' ? '(Murid / Anggota)' : '') }}
                    </option>
                @endforeach
            </select>
            @error('role_id')
                <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Kata Sandi</label>
            <input type="password" name="password" id="password" required
                placeholder="Minimal 6 karakter"
                class="w-full px-4 py-2.5 rounded-xl border @error('password') border-red-500 bg-red-50/30 @else border-gray-300 bg-gray-50/50 @enderror text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white transition duration-150">
            @error('password')
                <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password Confirmation -->
        <div>
            <label for="password_confirmation" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Konfirmasi Kata Sandi</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required
                placeholder="Ulangi kata sandi"
                class="w-full px-4 py-2.5 rounded-xl border border-gray-300 bg-gray-50/50 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white transition duration-150">
        </div>

        <!-- Submit Button -->
        <button type="submit"
            class="w-full py-3 px-4 rounded-xl bg-brand-primary hover:bg-brand-primary/90 text-white font-bold text-sm shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-brand-secondary focus:ring-offset-2 transition duration-200 mt-2">
            Daftar Sekarang
        </button>
    </form>

    <!-- Login Link -->
    <div class="text-center pt-2 border-t border-gray-100">
        <p class="text-xs text-gray-600">
            Sudah memiliki akun?
            <a href="{{ route('login') }}" class="font-bold text-brand-primary hover:text-brand-secondary transition">
                Masuk Ke Akun
            </a>
        </p>
    </div>
</div>
@endsection
