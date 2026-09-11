@extends('layouts.auth')

@section('title', 'Login Manual')

@section('content')
<div class="space-y-6">
    <div class="text-center">
        <h2 class="text-2xl font-bold text-brand-black">Masuk ke Akun</h2>
        <p class="text-xs text-gray-500 mt-1">Silakan masukkan email dan kata sandi Anda</p>
    </div>

    <!-- Quick Demo Accounts Helper Box -->
    <div class="bg-brand-light p-3.5 rounded-xl border border-gray-200">
        <p class="text-xs font-bold text-brand-primary mb-2 flex items-center gap-1.5">
            <svg class="w-4 h-4 text-brand-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Uji Coba Akun Demo (Klik untuk Isi Otomatis):
        </p>
        <div class="grid grid-cols-3 gap-1.5 text-center">
            <button type="button" onclick="fillDemo('admin@karate.com')" class="px-2 py-1.5 bg-white hover:bg-red-50 hover:border-red-300 border border-gray-200 rounded-lg text-[11px] font-semibold text-gray-800 transition shadow-2xs">
                🔴 Admin
            </button>
            <button type="button" onclick="fillDemo('senpai@karate.com')" class="px-2 py-1.5 bg-white hover:bg-blue-50 hover:border-brand-primary/40 border border-gray-200 rounded-lg text-[11px] font-semibold text-gray-800 transition shadow-2xs">
                🥋 Senpai
            </button>
            <button type="button" onclick="fillDemo('kohai@karate.com')" class="px-2 py-1.5 bg-white hover:bg-cyan-50 hover:border-brand-secondary/40 border border-gray-200 rounded-lg text-[11px] font-semibold text-gray-800 transition shadow-2xs">
                ⚪ Kohai
            </button>
        </div>
    </div>

    <!-- Login Form -->
    <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
        @csrf

        <!-- Email Field -->
        <div>
            <label for="email" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Alamat Email</label>
            <div class="relative">
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                    placeholder="nama@email.com"
                    class="w-full px-4 py-2.5 rounded-xl border @error('email') border-red-500 bg-red-50/30 @else border-gray-300 bg-gray-50/50 @enderror text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white transition duration-150">
            </div>
            @error('email')
                <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password Field -->
        <div>
            <div class="flex justify-between items-center mb-1">
                <label for="password" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Kata Sandi</label>
            </div>
            <input type="password" name="password" id="password" required
                placeholder="••••••••"
                class="w-full px-4 py-2.5 rounded-xl border @error('password') border-red-500 bg-red-50/30 @else border-gray-300 bg-gray-50/50 @enderror text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white transition duration-150">
            @error('password')
                <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me Checkbox -->
        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="remember" class="w-4 h-4 text-brand-primary rounded border-gray-300 focus:ring-brand-primary">
                <span class="text-xs text-gray-600 font-medium">Ingat Saya</span>
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit"
            class="w-full py-3 px-4 rounded-xl bg-brand-primary hover:bg-brand-primary/90 text-white font-bold text-sm shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-brand-secondary focus:ring-offset-2 transition duration-200">
            Masuk ke Sistem
        </button>
    </form>

    <!-- Register Link -->
    <div class="text-center pt-2 border-t border-gray-100">
        <p class="text-xs text-gray-600">
            Belum memiliki akun?
            <a href="{{ route('register') }}" class="font-bold text-brand-primary hover:text-brand-secondary transition">
                Daftar Akun Baru
            </a>
        </p>
    </div>
</div>

<script>
    function fillDemo(email) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = 'password';
    }
</script>
@endsection
