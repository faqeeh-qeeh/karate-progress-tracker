@extends('layouts.auth')

@section('title', 'Verifikasi Kode OTP')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="text-center">
        <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-blue-50 text-brand-primary border border-blue-200 mb-3 shadow-xs">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>
        <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Masukkan Kode OTP</h2>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">
            Kode 6-digit telah dikirimkan ke email:
        </p>
        <div class="mt-1.5 inline-block px-3 py-1 bg-slate-100 rounded-full font-mono text-xs font-bold text-slate-800 border border-slate-200">
            {{ $email }}
        </div>
    </div>

    <!-- Countdown Timer Card -->
    <div class="p-3 bg-amber-50/70 rounded-xl border border-amber-200/80 flex items-center justify-between text-xs">
        <span class="flex items-center gap-1.5 text-amber-800 font-semibold">
            <svg class="w-4 h-4 text-amber-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>Masa Berlaku Kode:</span>
        </span>
        <span id="countdown-timer" class="font-mono font-extrabold text-amber-900 bg-amber-200/60 px-2 py-0.5 rounded-md">
            05:00
        </span>
    </div>

    <!-- OTP Verification Form -->
    <form action="{{ route('password.otp.verify') }}" method="POST" class="space-y-5">
        @csrf

        <!-- OTP Input -->
        <div>
            <label for="otp" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 text-center">
                6 Digit Kode OTP
            </label>
            <div class="relative">
                <input type="text" name="otp" id="otp" maxlength="6" inputmode="numeric" pattern="[0-9]{6}" required autofocus
                    placeholder="000000"
                    autocomplete="one-time-code"
                    class="w-full text-center tracking-[12px] sm:tracking-[16px] font-mono font-black text-2xl sm:text-3xl py-3.5 px-4 rounded-xl border @error('otp') border-red-500 bg-red-50/30 text-red-900 @else border-slate-200 bg-slate-50/50 text-brand-primary @enderror focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white transition duration-200 placeholder:text-slate-300">
            </div>
            @error('otp')
                <p class="text-xs text-red-600 mt-2 font-medium flex items-center justify-center gap-1 text-center">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit"
            class="w-full py-3.5 px-4 bg-gradient-to-r from-brand-primary via-blue-600 to-brand-secondary hover:from-brand-primary/90 hover:to-brand-secondary/90 text-white font-bold text-sm rounded-xl shadow-lg shadow-brand-primary/20 hover:shadow-xl transition-all duration-200 active:scale-[0.99] flex items-center justify-center gap-2">
            <span>Verifikasi Kode OTP</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </button>
    </form>

    <!-- Resend OTP Section -->
    <div class="pt-3 border-t border-slate-100 text-center space-y-2">
        <p class="text-xs text-slate-500">Tidak menerima email atau kode kedaluwarsa?</p>
        <form action="{{ route('password.otp.resend') }}" method="POST">
            @csrf
            <button type="submit" id="btn-resend-otp"
                class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-primary hover:text-brand-secondary transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                <span>Kirim Ulang Kode OTP</span>
            </button>
        </form>
    </div>

    <!-- Back Link -->
    <div class="text-center">
        <a href="{{ route('password.request') }}" class="text-xs text-slate-400 hover:text-slate-600 font-medium transition">
            &larr; Ganti Email / Nomor Telepon
        </a>
    </div>
</div>

<script>
    // Live countdown timer calculation based on server expiration timestamp
    @if(isset($expiresAt) && $expiresAt)
        const expiryTime = new Date("{{ $expiresAt->toIso8601String() }}").getTime();
    @else
        const expiryTime = new Date().getTime() + (5 * 60 * 1000);
    @endif

    function updateCountdown() {
        const now = new Date().getTime();
        const diff = Math.max(0, Math.floor((expiryTime - now) / 1000));
        
        const minutes = Math.floor(diff / 60);
        const seconds = diff % 60;
        
        const formatted = String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
        const timerElement = document.getElementById('countdown-timer');
        if (timerElement) {
            timerElement.textContent = formatted;
            if (diff === 0) {
                timerElement.classList.add('bg-red-200/60', 'text-red-900');
                timerElement.classList.remove('bg-amber-200/60', 'text-amber-900');
                timerElement.textContent = 'Kedaluwarsa (00:00)';
            }
        }
    }

    updateCountdown();
    setInterval(updateCountdown, 1000);

    // Auto clean non-digits on input
    const otpInput = document.getElementById('otp');
    if (otpInput) {
        otpInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    }
</script>
@endsection
