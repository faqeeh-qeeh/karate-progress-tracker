@extends('layouts.auth')

@section('title', 'Masuk ke Sistem')

@section('content')
<div class="flex flex-col gap-6">

    {{-- Header --}}
    <div>
        <div class="inline-flex items-center gap-2 mb-3">
            <div style="width:28px;height:2px;background:linear-gradient(to right,#c8102e,#1a56c9);"></div>
            <span style="font-size:11px;font-weight:700;letter-spacing:0.18em;text-transform:uppercase;color:#1a56c9;">
                Sistem KARATER
            </span>
        </div>
        <h1 style="font-family:'Bebas Neue',sans-serif;font-size:clamp(32px,4vw,42px);letter-spacing:0.04em;color:#0a0a12;line-height:1.05;margin-bottom:8px;">
            SELAMAT DATANG<br>KEMBALI
        </h1>
        <p class="text-sm text-slate-500 leading-relaxed">
            Masukkan email dan kata sandi untuk mengakses sistem.
        </p>
    </div>

    {{-- Error notifikasi Google OAuth --}}
    @if ($errors->has('google'))
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 flex items-start gap-3">
            <div class="w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-red-800">Login Google Ditolak</p>
                <p class="text-[11px] text-red-700 mt-0.5 leading-relaxed">{{ $errors->first('google') }}</p>
            </div>
        </div>
    @endif

    {{-- Google OAuth --}}
    <a href="{{ route('auth.google') }}" id="btn-google-login"
       class="w-full flex items-center justify-center gap-3 py-3 px-4 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 hover:border-slate-300 text-slate-700 font-semibold text-sm shadow-xs hover:shadow transition-all duration-200 group">
        <svg class="shrink-0" width="18" height="18" viewBox="0 0 24 24">
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
        <span class="divider-label">atau</span>
        <div class="flex-1 h-px bg-slate-200"></div>
    </div>

    {{-- Login Form --}}
    <form action="{{ route('login.post') }}" method="POST" class="flex flex-col gap-4.5" id="login-form">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">
                Alamat Email
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                    </svg>
                </div>
                <input type="email" name="email" id="email"
                       value="{{ old('email') }}" required autofocus
                       placeholder="nama@email.com"
                       class="w-full pl-10 pr-4 py-3 rounded-xl border text-sm transition-all duration-200 placeholder:text-slate-300 bg-white
                              {{ $errors->has('email') ? 'border-red-400 bg-red-50 text-red-900' : 'border-slate-200 text-slate-800 hover:border-slate-300' }}"
                       style="outline:none;"
                       onfocus="this.style.borderColor='#c8102e';this.style.boxShadow='0 0 0 3px rgba(200,16,46,0.1)'"
                       onblur="this.style.borderColor='';this.style.boxShadow=''">
            </div>
            @error('email')
                <p class="text-xs text-red-600 mt-1.5 flex items-center gap-1 font-medium">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <div class="flex justify-between items-center mb-1.5">
                <label for="password" class="block text-xs font-bold text-slate-600 uppercase tracking-wider">
                    Kata Sandi
                </label>
                <a href="{{ route('password.request') }}" id="forgot-password-link"
                   class="text-xs font-semibold link-ao hover:underline underline-offset-2 transition-colors">
                    Lupa kata sandi?
                </a>
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <input type="password" name="password" id="password" required
                       placeholder="••••••••"
                       class="w-full pl-10 pr-11 py-3 rounded-xl border text-sm transition-all duration-200 placeholder:text-slate-300 bg-white
                              {{ $errors->has('password') ? 'border-red-400 bg-red-50 text-red-900' : 'border-slate-200 text-slate-800 hover:border-slate-300' }}"
                       style="outline:none;"
                       onfocus="this.style.borderColor='#c8102e';this.style.boxShadow='0 0 0 3px rgba(200,16,46,0.1)'"
                       onblur="this.style.borderColor='';this.style.boxShadow=''">
                <button type="button" onclick="togglePasswordVisibility('password', 'pw-eye-icon')"
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition-colors focus:outline-none"
                        title="Tampilkan / Sembunyikan">
                    <svg id="pw-eye-icon" class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="text-xs text-red-600 mt-1.5 flex items-center gap-1 font-medium">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Remember me --}}
        <label class="flex items-center gap-2.5 cursor-pointer group w-fit">
            <input type="checkbox" name="remember"
                   class="w-4 h-4 rounded border-slate-300 transition cursor-pointer"
                   style="accent-color:#c8102e;">
            <span class="text-xs text-slate-500 font-medium group-hover:text-slate-700 transition">Ingat Saya</span>
        </label>

        {{-- Submit --}}
        <button type="submit" id="login-submit-btn"
                class="w-full py-3.5 px-4 mt-1 rounded-xl text-white font-bold text-sm tracking-wide transition-all duration-200 btn-aka focus:outline-none shadow-sm hover:shadow-md cursor-pointer">
            Masuk ke Sistem
        </button>
    </form>

    {{-- Info box registrasi --}}
    <div class="rounded-2xl border border-slate-200/80 bg-slate-50/80 p-4.5 flex items-start gap-3.5 shadow-2xs">
        <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 mt-0.5"
             style="background:rgba(26,86,201,0.08);color:#1a56c9;">
            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="flex-1 min-w-0">
            <h4 class="text-xs font-bold text-slate-800">Belum memiliki akun?</h4>
            <p class="text-[11px] text-slate-500 leading-relaxed mt-0.5">
                Pendaftaran akun dikelola langsung oleh <strong>Admin Karate Polindra</strong>.
            </p>
            <a href="{{ route('register') }}" id="goto-register-link"
               class="inline-flex items-center gap-1.5 text-xs font-bold link-ao hover:underline underline-offset-2 transition-colors mt-2">
                Lihat Tata Cara Registrasi
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>

</div>

<script>
function togglePasswordVisibility(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (!input || !icon) return;
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a8.962 8.962 0 013.982-.963c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m-6.165-4.571a3 3 0 11-4.243-4.243"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 3l18 18"/>`;
    } else {
        input.type = 'password';
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
    }
}
</script>
@endsection
