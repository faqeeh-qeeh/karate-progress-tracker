@extends('layouts.senpai')

@section('title', 'Pengaturan & Tampilan Senpai')

@section('content')
<div class="space-y-6 max-w-6xl mx-auto">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm transition-colors duration-200">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-brand-primary/10 dark:bg-brand-primary/20 text-brand-primary dark:text-brand-secondary flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Pengaturan & Tampilan Senpai</h1>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-0.5">Konfigurasi preferensi tema antarmuka (Dark / Light Mode) dan informasi akun pelatih</p>
            </div>
        </div>

        <div class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-xs font-semibold self-start sm:self-auto">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span>Status: Aktif</span>
        </div>
    </div>

    <!-- Theme & Display Mode Section -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden transition-colors duration-200">
        <div class="p-6 border-b border-slate-100 dark:border-slate-800/80 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <span>Mode Tampilan & Tema Warna</span>
                </h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Pilih gaya visual yang paling nyaman untuk Anda saat mengelola kelas dan raport kumite</p>
            </div>

            <!-- Current Active Theme Badge -->
            <div id="senpai-theme-status-badge" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-brand-primary/10 dark:bg-brand-primary/20 text-brand-primary dark:text-brand-secondary text-xs font-bold self-start sm:self-auto">
                <span id="senpai-theme-badge-icon">🌙</span>
                <span id="senpai-theme-badge-text">Mode Gelap Aktif</span>
            </div>
        </div>

        <div class="p-6 sm:p-8">
            <!-- Theme Selection Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <!-- Light Mode Card Option -->
                <button type="button" onclick="setSenpaiTheme('light')" id="theme-card-light" class="relative text-left p-5 rounded-2xl border-2 transition-all duration-200 cursor-pointer group hover:shadow-md border-slate-200 hover:border-brand-primary dark:border-slate-800 dark:hover:border-slate-600 bg-slate-50/50 dark:bg-slate-950/40">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-950/50 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div id="radio-light" class="w-5 h-5 rounded-full border-2 border-slate-300 dark:border-slate-700 flex items-center justify-center">
                            <div class="w-2.5 h-2.5 rounded-full bg-transparent"></div>
                        </div>
                    </div>

                    <!-- Mini Mockup of Light Mode -->
                    <div class="w-full h-24 rounded-xl bg-white border border-slate-200 p-2.5 space-y-2 mb-4 shadow-2xs overflow-hidden pointer-events-none">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-1.5">
                            <div class="w-12 h-2 rounded bg-slate-800"></div>
                            <div class="w-4 h-4 rounded-full bg-slate-200"></div>
                        </div>
                        <div class="grid grid-cols-2 gap-1.5">
                            <div class="h-6 rounded bg-slate-100 border border-slate-200/60"></div>
                            <div class="h-6 rounded bg-brand-primary/10 border border-brand-primary/20"></div>
                        </div>
                        <div class="w-full h-4 rounded bg-slate-50 border border-slate-100"></div>
                    </div>

                    <h3 class="text-sm font-bold text-slate-900 dark:text-white">Mode Terang (Light)</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Tampilan cerah dengan kontras bersih, nyaman di tempat terang.</p>
                </button>

                <!-- Dark Mode Card Option -->
                <button type="button" onclick="setSenpaiTheme('dark')" id="theme-card-dark" class="relative text-left p-5 rounded-2xl border-2 transition-all duration-200 cursor-pointer group hover:shadow-md border-slate-200 hover:border-brand-primary dark:border-slate-800 dark:hover:border-slate-600 bg-slate-50/50 dark:bg-slate-950/40">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 rounded-xl bg-indigo-100 dark:bg-indigo-950/50 text-indigo-600 dark:text-indigo-400 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </div>
                        <div id="radio-dark" class="w-5 h-5 rounded-full border-2 border-slate-300 dark:border-slate-700 flex items-center justify-center">
                            <div class="w-2.5 h-2.5 rounded-full bg-transparent"></div>
                        </div>
                    </div>

                    <!-- Mini Mockup of Dark Mode -->
                    <div class="w-full h-24 rounded-xl bg-slate-950 border border-slate-800 p-2.5 space-y-2 mb-4 shadow-2xs overflow-hidden pointer-events-none">
                        <div class="flex items-center justify-between border-b border-slate-800 pb-1.5">
                            <div class="w-12 h-2 rounded bg-slate-200"></div>
                            <div class="w-4 h-4 rounded-full bg-slate-800"></div>
                        </div>
                        <div class="grid grid-cols-2 gap-1.5">
                            <div class="h-6 rounded bg-slate-900 border border-slate-800"></div>
                            <div class="h-6 rounded bg-brand-primary/30 border border-brand-primary/40"></div>
                        </div>
                        <div class="w-full h-4 rounded bg-slate-900 border border-slate-800"></div>
                    </div>

                    <h3 class="text-sm font-bold text-slate-900 dark:text-white">Mode Gelap (Dark)</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Mengurangi ketegangan mata di ruangan redup dan tampilan lebih elegan.</p>
                </button>

                <!-- System Auto Preference Option -->
                <button type="button" onclick="setSenpaiTheme('system')" id="theme-card-system" class="relative text-left p-5 rounded-2xl border-2 transition-all duration-200 cursor-pointer group hover:shadow-md border-slate-200 hover:border-brand-primary dark:border-slate-800 dark:hover:border-slate-600 bg-slate-50/50 dark:bg-slate-950/40">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 rounded-xl bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div id="radio-system" class="w-5 h-5 rounded-full border-2 border-slate-300 dark:border-slate-700 flex items-center justify-center">
                            <div class="w-2.5 h-2.5 rounded-full bg-transparent"></div>
                        </div>
                    </div>

                    <!-- Mini Split Mockup -->
                    <div class="w-full h-24 rounded-xl border border-slate-200 dark:border-slate-800 p-2.5 space-y-2 mb-4 shadow-2xs overflow-hidden pointer-events-none relative bg-gradient-to-r from-white via-slate-100 to-slate-950">
                        <div class="flex items-center justify-between border-b border-slate-300/40 pb-1.5">
                            <div class="w-12 h-2 rounded bg-slate-700"></div>
                            <div class="w-4 h-4 rounded-full bg-amber-400"></div>
                        </div>
                        <div class="grid grid-cols-2 gap-1.5">
                            <div class="h-6 rounded bg-white/80 border border-slate-300/50"></div>
                            <div class="h-6 rounded bg-slate-900 border border-slate-700"></div>
                        </div>
                        <div class="w-full h-4 rounded bg-slate-800/60 border border-slate-700"></div>
                    </div>

                    <h3 class="text-sm font-bold text-slate-900 dark:text-white">Otomatis (Sesuai Sistem)</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Menyesuaikan tema secara dinamis mengikuti setelan tema sistem perangkat Anda.</p>
                </button>
            </div>
        </div>
    </div>

    <!-- User & System Info Section -->
    <div class="bg-white dark:bg-slate-900 p-6 sm:p-8 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-5 transition-colors duration-200">
        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800/80 pb-4">
            <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                <svg class="w-4 h-4 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span>Informasi Akun & Instruktur Senpai</span>
            </h3>
            <a href="{{ route('senpai.profile.index') }}" class="text-xs font-bold text-brand-primary dark:text-brand-secondary hover:underline flex items-center gap-1">
                <span>Edit Biodata</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="p-4 rounded-xl bg-slate-50/70 dark:bg-slate-950/50 border border-slate-200/60 dark:border-slate-800">
                <span class="block text-xs text-slate-500 dark:text-slate-400 font-medium mb-1">Nama Senpai / Pelatih</span>
                <span class="text-sm font-bold text-slate-800 dark:text-slate-200">{{ $user->name }}</span>
            </div>
            <div class="p-4 rounded-xl bg-slate-50/70 dark:bg-slate-950/50 border border-slate-200/60 dark:border-slate-800">
                <span class="block text-xs text-slate-500 dark:text-slate-400 font-medium mb-1">Email Terdaftar</span>
                <span class="text-sm font-bold text-slate-800 dark:text-slate-200 truncate block">{{ $user->email }}</span>
            </div>
            <div class="p-4 rounded-xl bg-slate-50/70 dark:bg-slate-950/50 border border-slate-200/60 dark:border-slate-800">
                <span class="block text-xs text-slate-500 dark:text-slate-400 font-medium mb-1">Sabuk / Tingkatan</span>
                @if($user->senpaiProfile?->rank)
                    <span class="inline-flex items-center gap-1.5 text-sm font-bold text-slate-800 dark:text-slate-200">
                        <span class="w-2.5 h-2.5 rounded-full shrink-0" style="background-color: {{ $user->senpaiProfile->rank->belt->color_code ?? '#1e293b' }}"></span>
                        <span>{{ $user->senpaiProfile->rank->belt->name ?? 'Sabuk' }} - {{ $user->senpaiProfile->rank->name }}</span>
                    </span>
                @else
                    <span class="text-xs font-semibold text-amber-600 dark:text-amber-400">Belum Ditentukan</span>
                @endif
            </div>
            <div class="p-4 rounded-xl bg-slate-50/70 dark:bg-slate-950/50 border border-slate-200/60 dark:border-slate-800">
                <span class="block text-xs text-slate-500 dark:text-slate-400 font-medium mb-1">Peran & Otoritas</span>
                <span class="inline-block px-2.5 py-0.5 rounded-md font-bold text-xs uppercase bg-brand-primary/10 text-brand-primary dark:bg-brand-primary/30 dark:text-blue-300">
                    Senpai / Instruktur Dojo
                </span>
            </div>
            <div class="p-4 rounded-xl bg-slate-50/70 dark:bg-slate-950/50 border border-slate-200/60 dark:border-slate-800">
                <span class="block text-xs text-slate-500 dark:text-slate-400 font-medium mb-1">Nomor Telepon / WhatsApp</span>
                <span class="text-sm font-bold text-slate-800 dark:text-slate-200">
                    {{ $user->phone ?? '-' }}
                </span>
            </div>
            <div class="p-4 rounded-xl bg-slate-50/70 dark:bg-slate-950/50 border border-slate-200/60 dark:border-slate-800">
                <span class="block text-xs text-slate-500 dark:text-slate-400 font-medium mb-1">Zona Waktu Server</span>
                <span class="text-sm font-bold text-slate-800 dark:text-slate-200">{{ $systemInfo['timezone'] }}</span>
            </div>
        </div>
    </div>
</div>

<script>
    function updateSenpaiSettingsPageUI() {
        const storedTheme = localStorage.getItem('karate_theme') || 'system';
        const isDark = document.documentElement.classList.contains('dark');
        
        // Cards
        const cardLight = document.getElementById('theme-card-light');
        const cardDark = document.getElementById('theme-card-dark');
        const cardSystem = document.getElementById('theme-card-system');

        // Radios
        const radioLight = document.getElementById('radio-light')?.firstElementChild;
        const radioDark = document.getElementById('radio-dark')?.firstElementChild;
        const radioSystem = document.getElementById('radio-system')?.firstElementChild;

        // Reset all cards styling
        [cardLight, cardDark, cardSystem].forEach(card => {
            if (card) {
                card.classList.remove('border-brand-primary', 'ring-2', 'ring-brand-primary/20', 'bg-white', 'dark:bg-slate-900');
                card.classList.add('border-slate-200', 'dark:border-slate-800', 'bg-slate-50/50', 'dark:bg-slate-950/40');
            }
        });

        // Reset radios
        if (radioLight) radioLight.className = 'w-2.5 h-2.5 rounded-full bg-transparent';
        if (radioDark) radioDark.className = 'w-2.5 h-2.5 rounded-full bg-transparent';
        if (radioSystem) radioSystem.className = 'w-2.5 h-2.5 rounded-full bg-transparent';

        // Highlight selected
        if (storedTheme === 'light' && cardLight) {
            cardLight.classList.remove('border-slate-200', 'dark:border-slate-800', 'bg-slate-50/50', 'dark:bg-slate-950/40');
            cardLight.classList.add('border-brand-primary', 'ring-2', 'ring-brand-primary/20', 'bg-white', 'dark:bg-slate-900');
            if (radioLight) radioLight.className = 'w-2.5 h-2.5 rounded-full bg-brand-primary';
        } else if (storedTheme === 'dark' && cardDark) {
            cardDark.classList.remove('border-slate-200', 'dark:border-slate-800', 'bg-slate-50/50', 'dark:bg-slate-950/40');
            cardDark.classList.add('border-brand-primary', 'ring-2', 'ring-brand-primary/20', 'bg-white', 'dark:bg-slate-900');
            if (radioDark) radioDark.className = 'w-2.5 h-2.5 rounded-full bg-brand-primary';
        } else if (storedTheme === 'system' && cardSystem) {
            cardSystem.classList.remove('border-slate-200', 'dark:border-slate-800', 'bg-slate-50/50', 'dark:bg-slate-950/40');
            cardSystem.classList.add('border-brand-primary', 'ring-2', 'ring-brand-primary/20', 'bg-white', 'dark:bg-slate-900');
            if (radioSystem) radioSystem.className = 'w-2.5 h-2.5 rounded-full bg-brand-primary';
        }

        // Status badge
        const badgeIcon = document.getElementById('senpai-theme-badge-icon');
        const badgeText = document.getElementById('senpai-theme-badge-text');

        if (isDark) {
            if (badgeIcon) badgeIcon.textContent = '🌙';
            if (badgeText) badgeText.textContent = 'Mode Gelap Aktif';
        } else {
            if (badgeIcon) badgeIcon.textContent = '☀️';
            if (badgeText) badgeText.textContent = 'Mode Terang Aktif';
        }
    }

    function setSenpaiTheme(theme) {
        if (theme === 'light') {
            document.documentElement.classList.remove('dark');
            document.body.classList.remove('dark');
            localStorage.setItem('karate_theme', 'light');
        } else if (theme === 'dark') {
            document.documentElement.classList.add('dark');
            document.body.classList.add('dark');
            localStorage.setItem('karate_theme', 'dark');
        } else if (theme === 'system') {
            localStorage.removeItem('karate_theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (prefersDark) {
                document.documentElement.classList.add('dark');
                document.body.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
                document.body.classList.remove('dark');
            }
        }

        updateSenpaiSettingsPageUI();
        window.dispatchEvent(new CustomEvent('karateThemeChanged', { 
            detail: { isDark: document.documentElement.classList.contains('dark') } 
        }));
    }

    window.addEventListener('karateThemeChanged', updateSenpaiSettingsPageUI);
    document.addEventListener('DOMContentLoaded', updateSenpaiSettingsPageUI);
</script>
@endsection
