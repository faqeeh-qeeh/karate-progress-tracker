@extends('layouts.auth')

@section('title', 'Aktivasi Akun & Atur Kata Sandi')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="text-center">
        <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-200 mb-3 shadow-xs">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
        </div>
        <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Aktivasi Akun Baru</h2>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">Konfirmasi email dan tentukan kata sandi untuk akun Anda</p>
    </div>

    <!-- Account Details Summary Card -->
    <div class="bg-slate-50/80 rounded-xl p-4 border border-slate-200/90 space-y-2">
        <div class="flex items-center justify-between text-xs pb-1.5 border-b border-slate-200/60">
            <span class="text-slate-500 font-medium">Nama Lengkap</span>
            <span class="font-bold text-slate-900 text-right">{{ $user->name }}</span>
        </div>
        <div class="flex items-center justify-between text-xs pb-1.5 border-b border-slate-200/60">
            <span class="text-slate-500 font-medium">Alamat Email</span>
            <span class="font-bold text-slate-900 text-right font-mono">{{ $user->email }}</span>
        </div>
        <div class="flex items-center justify-between text-xs">
            <span class="text-slate-500 font-medium">Peran / Role</span>
            @php
                $roleName = $user->role->nama ?? 'Pengguna';
                $roleBadgeClass = match(strtolower($roleName)) {
                    'admin' => 'bg-red-50 text-red-700 border-red-200',
                    'senpai' => 'bg-blue-50 text-blue-700 border-blue-200',
                    'kohai' => 'bg-cyan-50 text-cyan-800 border-cyan-200',
                    default => 'bg-slate-100 text-slate-700 border-slate-200'
                };
            @endphp
            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-extrabold border {{ $roleBadgeClass }}">
                {{ $roleName }}
            </span>
        </div>
    </div>

    <!-- Password Setup Form -->
    <form action="{{ route('account.activate.post', ['id' => $id, 'hash' => $hash] + request()->query()) }}" method="POST" class="space-y-4">
        @csrf

        <!-- Password Field -->
        <div>
            <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                Buat Kata Sandi Baru
            </label>
            <div class="relative rounded-xl">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input type="password" name="password" id="password" required autofocus
                    placeholder="Minimal 6 karakter"
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

        <!-- Password Confirmation Field -->
        <div>
            <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                Konfirmasi Kata Sandi Baru
            </label>
            <div class="relative rounded-xl">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    placeholder="Ulangi kata sandi baru"
                    class="w-full pl-10 pr-11 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white transition duration-200 placeholder:text-slate-400">
                <button type="button" onclick="togglePasswordVisibility('password_confirmation', 'password-confirm-toggle-icon')"
                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none transition-colors"
                    title="Tampilkan / Sembunyikan Konfirmasi Kata Sandi">
                    <svg id="password-confirm-toggle-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Security Note -->
        <div class="p-3 bg-blue-50/60 rounded-xl border border-blue-100 flex items-start gap-2.5">
            <svg class="w-4 h-4 text-brand-primary shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-[11px] text-slate-600 leading-relaxed">
                Dengan menekan tombol aktivasi, email Anda akan ditandai sebagai <strong>terverifikasi</strong> dan kata sandi baru akan langsung disimpan secara aman.
            </p>
        </div>

        <!-- Submit Button -->
        <button type="submit"
            class="w-full py-3.5 px-4 bg-gradient-to-r from-brand-primary via-blue-600 to-brand-secondary hover:from-brand-primary/90 hover:to-brand-secondary/90 text-white font-bold text-sm rounded-xl shadow-lg shadow-brand-primary/20 hover:shadow-xl transition-all duration-200 active:scale-[0.99] flex items-center justify-center gap-2">
            <span>Aktifkan Akun & Masuk</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
        </button>
    </form>

    <!-- Return to Login link -->
    <div class="text-center pt-2">
        <a href="{{ route('login') }}" class="text-xs text-slate-500 hover:text-brand-primary font-medium transition">
            Sudah memiliki kata sandi? <span class="font-bold underline">Masuk ke Sistem</span>
        </a>
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
