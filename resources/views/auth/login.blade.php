@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="space-y-6">
    <div class="text-center">
        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Masuk ke Akun</h2>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">Silakan masukkan email dan kata sandi Anda</p>
    </div>

    {{-- Error notifikasi Google OAuth --}}
    @if ($errors->has('google'))
        <div class="rounded-xl bg-red-50 border border-red-200 p-4 flex items-start gap-3">
            <div class="w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center shrink-0 mt-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
            </div>
            <div>
                <h4 class="text-xs font-bold text-red-800">Login Google Ditolak</h4>
                <p class="text-[11px] text-red-700 leading-relaxed mt-0.5">{{ $errors->first('google') }}</p>
            </div>
        </div>
    @endif

    {{-- Login dengan Google --}}
    <a href="{{ route('auth.google') }}" id="btn-google-login"
        class="w-full flex items-center justify-center gap-3 py-3 px-4 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 hover:border-slate-300 text-slate-700 font-semibold text-sm shadow-sm hover:shadow-md transition-all duration-200 group">
        {{-- Google Icon SVG --}}
        <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/>
            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
        </svg>
        <span class="group-hover:text-slate-900 transition-colors">Masuk dengan Google</span>
    </a>

    {{-- Divider --}}
    <div class="flex items-center gap-3">
        <div class="flex-1 h-px bg-slate-200"></div>
        <span class="text-xs text-slate-400 font-medium uppercase tracking-wider">atau</span>
        <div class="flex-1 h-px bg-slate-200"></div>
    </div>

    <!-- Login Form -->
    <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
        @csrf

        <!-- Email Field -->
        <div>
            <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                Alamat Email
            </label>
            <div class="relative rounded-xl">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                    placeholder="nama@email.com"
                    class="w-full pl-10 pr-4 py-3 rounded-xl border @error('email') border-red-500 bg-red-50/30 text-red-900 @else border-slate-200 bg-slate-50/50 text-slate-900 @enderror text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white transition duration-200 placeholder:text-slate-400">
            </div>
            @error('email')
                <p class="text-xs text-red-600 mt-1.5 font-medium flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Password Field -->
        <div>
            <div class="flex justify-between items-center mb-1.5">
                <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                    Kata Sandi
                </label>
                <a href="{{ route('password.request') }}" class="text-xs text-brand-primary hover:text-brand-secondary font-semibold transition">
                    Lupa kata sandi?
                </a>
            </div>
            <div class="relative rounded-xl">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input type="password" name="password" id="password" required
                    placeholder="••••••••"
                    class="w-full pl-10 pr-11 py-3 rounded-xl border @error('password') border-red-500 bg-red-50/30 text-red-900 @else border-slate-200 bg-slate-50/50 text-slate-900 @enderror text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white transition duration-200 placeholder:text-slate-400">
                <button type="button" onclick="togglePasswordVisibility('password', 'password-toggle-icon')"
                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none transition-colors"
                    title="Tampilkan / Sembunyikan Kata Sandi">
                    <svg id="password-toggle-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="text-xs text-red-600 mt-1.5 font-medium flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Remember Me Checkbox -->
        <div class="flex items-center justify-between pt-1">
            <label class="flex items-center gap-2.5 cursor-pointer group">
                <input type="checkbox" name="remember" class="w-4 h-4 text-brand-primary rounded border-slate-300 focus:ring-brand-primary focus:ring-offset-0 transition cursor-pointer">
                <span class="text-xs text-slate-600 font-medium group-hover:text-slate-800 transition">Ingat Saya</span>
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit"
            class="w-full py-3.5 px-4 rounded-xl bg-gradient-to-r from-brand-primary to-brand-secondary hover:from-brand-primary/90 hover:to-brand-secondary/90 text-white font-bold text-sm shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-brand-secondary focus:ring-offset-2 transition-all duration-200">
            Masuk ke Sistem
        </button>
    </form>

    <!-- Register Info Notice -->
    <div class="pt-3 border-t border-slate-100">
        <div class="rounded-xl bg-slate-50 border border-slate-200/80 p-3.5 flex items-start gap-3">
            <div class="w-8 h-8 rounded-lg bg-brand-primary/10 text-brand-primary flex items-center justify-center shrink-0 mt-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h4 class="text-xs font-bold text-slate-800">Belum memiliki akun?</h4>
                <p class="text-[11px] text-slate-500 leading-relaxed mt-0.5">
                    Pendaftaran akun baru dikelola langsung oleh <strong>Admin Karate Polindra</strong>. Silakan ikuti tata cara pendaftaran akun baru.
                </p>
                <a href="{{ route('register') }}" class="inline-flex items-center gap-1 text-xs font-bold text-brand-primary hover:text-brand-secondary transition-colors mt-2">
                    Lihat Tata Cara Registrasi
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const iconSvg = document.getElementById(iconId);
        if (!passwordInput || !iconSvg) return;

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            iconSvg.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a8.962 8.962 0 013.982-.963c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m-6.165-4.571a3 3 0 11-4.243-4.243" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
            `;
        } else {
            passwordInput.type = 'password';
            iconSvg.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            `;
        }
    }
</script>
@endsection
