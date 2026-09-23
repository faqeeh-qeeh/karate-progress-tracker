<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Karate Tracker</title>
    <script>
        // Inline theme check to prevent flash of unstyled light theme
        (function() {
            try {
                const storedTheme = localStorage.getItem('karate_theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (storedTheme === 'dark' || (!storedTheme && prefersDark)) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            } catch (e) {}
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 dark:bg-slate-950 min-h-screen flex text-slate-800 dark:text-slate-100 antialiased selection:bg-brand-primary selection:text-white overflow-x-hidden transition-colors duration-200">

    <!-- Desktop Sidebar Admin -->
    <aside class="hidden lg:flex flex-col w-64 bg-slate-900 dark:bg-slate-950 text-white min-h-screen fixed inset-y-0 left-0 z-40 border-r border-slate-800/80 dark:border-slate-800/90 shadow-xl">
        <!-- Sidebar Brand Header -->
        <div class="h-16 flex items-center px-5 border-b border-slate-800/80 dark:border-slate-800/90 gap-3 shrink-0">
            <div class="w-9 h-9 rounded-xl bg-slate-800 dark:bg-slate-900 border border-slate-700/80 p-1.5 flex items-center justify-center shrink-0">
                <img src="{{ asset('images/LOGO KARATER POLINDRA.png') }}" alt="Logo Polindra" class="w-full h-full object-contain">
            </div>
            <div>
                <a href="{{ route('admin.dashboard') }}" class="text-base font-extrabold tracking-tight text-white block leading-tight">
                    KARATE<span class="text-brand-secondary">POLINDRA</span>
                </a>
                <span class="block text-[10px] text-red-400 font-bold uppercase tracking-widest mt-0.5">Control Center</span>
            </div>
        </div>

        <!-- Sidebar Navigation Menu -->
        <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto">
            <div class="text-[10px] font-bold uppercase text-slate-500 tracking-wider px-3 mb-2">Utama</div>

            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-brand-primary to-brand-secondary text-white shadow-md shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60 dark:hover:bg-slate-900/80' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span>Dashboard Admin</span>
            </a>

            <div class="text-[10px] font-bold uppercase text-slate-500 tracking-wider px-3 mt-6 mb-2">Manajemen</div>

            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-brand-primary to-brand-secondary text-white shadow-md shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60 dark:hover:bg-slate-900/80' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <span>Kelola User & Role</span>
            </a>

            <a href="{{ route('admin.belts.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition-all duration-200 {{ request()->routeIs('admin.belts.*') ? 'bg-gradient-to-r from-brand-primary to-brand-secondary text-white shadow-md shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60 dark:hover:bg-slate-900/80' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.belts.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                <span>Sabuk & Tingkatan</span>
            </a>

            <a href="{{ route('admin.departments.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition-all duration-200 {{ request()->routeIs('admin.departments.*') || request()->routeIs('admin.study-programs.*') || request()->routeIs('admin.academic-classes.*') ? 'bg-gradient-to-r from-brand-primary to-brand-secondary text-white shadow-md shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60 dark:hover:bg-slate-900/80' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.departments.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                <span>Jurusan, Prodi & Kelas</span>
            </a>

            <a href="{{ route('admin.training-schedules.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition-all duration-200 {{ request()->routeIs('admin.training-schedules.*') ? 'bg-gradient-to-r from-brand-primary to-brand-secondary text-white shadow-md shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60 dark:hover:bg-slate-900/80' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.training-schedules.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>Jadwal Latihan</span>
            </a>

            <div class="text-[10px] font-bold uppercase text-slate-500 tracking-wider px-3 mt-6 mb-2">Landing Page & Prestasi</div>

            <a href="{{ route('admin.landing-page.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition-all duration-200 {{ request()->routeIs('admin.landing-page.*') ? 'bg-gradient-to-r from-brand-primary to-brand-secondary text-white shadow-md shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60 dark:hover:bg-slate-900/80' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.landing-page.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                <span>Kelola Landing Page</span>
            </a>

            <a href="{{ route('admin.achievements.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition-all duration-200 {{ request()->routeIs('admin.achievements.*') ? 'bg-gradient-to-r from-brand-primary to-brand-secondary text-white shadow-md shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60 dark:hover:bg-slate-900/80' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.achievements.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                <span>Prestasi & Medali</span>
            </a>

            <div class="text-[10px] font-bold uppercase text-slate-500 tracking-wider px-3 mt-6 mb-2">Akun & Sistem</div>

            <a href="{{ route('admin.profile.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition-all duration-200 {{ request()->routeIs('admin.profile.*') ? 'bg-gradient-to-r from-brand-primary to-brand-secondary text-white shadow-md shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60 dark:hover:bg-slate-900/80' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.profile.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span>Profil Administrator</span>
            </a>

            <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition-all duration-200 {{ request()->routeIs('admin.settings.*') ? 'bg-gradient-to-r from-brand-primary to-brand-secondary text-white shadow-md shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60 dark:hover:bg-slate-900/80' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.settings.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Pengaturan Sistem</span>
            </a>
        </nav>

        <!-- Sidebar User Profile Footer -->
        <div class="p-3.5 border-t border-slate-800/80 dark:border-slate-800/90 bg-slate-950/60 dark:bg-slate-950/90 shrink-0">
            <div class="flex items-center justify-between gap-2">
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-9 h-9 rounded-xl bg-red-600 text-white flex items-center justify-center font-bold text-xs uppercase shrink-0 shadow-xs">
                        {{ auth()->user()->initials }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-white truncate max-w-[110px]">{{ auth()->user()->name }}</p>
                        <span class="text-[10px] text-red-400 font-semibold uppercase block truncate">Administrator</span>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="shrink-0">
                    @csrf
                    <button type="submit" title="Keluar dari Akun" class="p-2 rounded-xl text-slate-400 hover:text-red-400 hover:bg-slate-800/80 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Mobile Drawer Admin Sidebar -->
    <div id="mobile-sidebar" class="fixed inset-0 z-50 hidden lg:hidden">
        <div id="mobile-sidebar-backdrop" class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs transition-opacity"></div>
        <div class="fixed inset-y-0 left-0 w-72 max-w-[85vw] bg-slate-900 dark:bg-slate-950 text-white flex flex-col z-10 shadow-2xl transition-transform duration-300 border-r border-slate-800">
            <div class="h-16 flex items-center justify-between px-5 border-b border-slate-800 shrink-0">
                <div class="flex items-center gap-2.5">
                    <img src="{{ asset('images/LOGO KARATER POLINDRA.png') }}" alt="Logo Polindra" class="w-8 h-8 object-contain shrink-0">
                    <span class="text-base font-extrabold tracking-tight text-white">KARATE<span class="text-brand-secondary">ADMIN</span></span>
                </div>
                <button id="close-mobile-sidebar" class="p-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <nav class="flex-1 px-4 py-5 space-y-2 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-brand-primary to-brand-secondary text-white shadow-md' : 'text-slate-300 hover:bg-slate-800' }}">
                    <svg class="w-5 h-5 shrink-0 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span>Dashboard Admin</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-brand-primary to-brand-secondary text-white shadow-md' : 'text-slate-300 hover:bg-slate-800' }}">
                    <svg class="w-5 h-5 shrink-0 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <span>Kelola User & Role</span>
                </a>
                <a href="{{ route('admin.belts.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm {{ request()->routeIs('admin.belts.*') ? 'bg-gradient-to-r from-brand-primary to-brand-secondary text-white shadow-md' : 'text-slate-300 hover:bg-slate-800' }}">
                    <svg class="w-5 h-5 shrink-0 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    <span>Sabuk & Tingkatan</span>
                </a>
                <a href="{{ route('admin.departments.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm {{ request()->routeIs('admin.departments.*') ? 'bg-gradient-to-r from-brand-primary to-brand-secondary text-white shadow-md' : 'text-slate-300 hover:bg-slate-800' }}">
                    <svg class="w-5 h-5 shrink-0 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span>Jurusan, Prodi & Kelas</span>
                </a>
                <a href="{{ route('admin.training-schedules.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm {{ request()->routeIs('admin.training-schedules.*') ? 'bg-gradient-to-r from-brand-primary to-brand-secondary text-white shadow-md' : 'text-slate-300 hover:bg-slate-800' }}">
                    <svg class="w-5 h-5 shrink-0 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Jadwal Latihan</span>
                </a>
                <a href="{{ route('admin.landing-page.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm {{ request()->routeIs('admin.landing-page.*') ? 'bg-gradient-to-r from-brand-primary to-brand-secondary text-white shadow-md' : 'text-slate-300 hover:bg-slate-800' }}">
                    <svg class="w-5 h-5 shrink-0 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span>Kelola Landing Page</span>
                </a>
                <a href="{{ route('admin.achievements.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm {{ request()->routeIs('admin.achievements.*') ? 'bg-gradient-to-r from-brand-primary to-brand-secondary text-white shadow-md' : 'text-slate-300 hover:bg-slate-800' }}">
                    <svg class="w-5 h-5 shrink-0 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    <span>Prestasi & Medali</span>
                </a>
                <a href="{{ route('admin.profile.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm {{ request()->routeIs('admin.profile.*') ? 'bg-gradient-to-r from-brand-primary to-brand-secondary text-white shadow-md' : 'text-slate-300 hover:bg-slate-800' }}">
                    <svg class="w-5 h-5 shrink-0 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>Profil Administrator</span>
                </a>

                <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm {{ request()->routeIs('admin.settings.*') ? 'bg-gradient-to-r from-brand-primary to-brand-secondary text-white shadow-md' : 'text-slate-300 hover:bg-slate-800' }}">
                    <svg class="w-5 h-5 shrink-0 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>Pengaturan Sistem</span>
                </a>
            </nav>
            <div class="p-4 border-t border-slate-800 bg-slate-950/80 shrink-0">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-9 h-9 rounded-xl bg-red-600 text-white flex items-center justify-center font-bold text-xs uppercase shrink-0">
                        {{ auth()->user()->initials }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-slate-400 truncate">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-xs font-bold transition shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span>Keluar dari Akun</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content Wrapper -->
    <div class="flex-1 min-w-0 lg:pl-64 flex flex-col min-h-screen w-full">
        <!-- Top Navbar -->
        <header class="bg-white/90 dark:bg-slate-900/90 backdrop-blur-md border-b border-slate-200/80 dark:border-slate-800 h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8 sticky top-0 z-30 transition-colors duration-200">
            <div class="flex items-center gap-3 min-w-0">
                <button id="open-mobile-sidebar" class="lg:hidden p-2 rounded-xl text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none shrink-0" aria-label="Buka Menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                    <h2 class="text-sm sm:text-base font-extrabold text-slate-900 dark:text-white truncate tracking-tight">Panel Administrator</h2>
                </div>
            </div>
            
            <div class="flex items-center gap-2.5 sm:gap-3 shrink-0">
                <!-- Clickable Avatar Initial Box Linking to Profile -->
                <a href="{{ route('admin.profile.index') }}" 
                   title="Profil Administrator ({{ auth()->user()->name }})" 
                   class="w-10 h-10 rounded-xl bg-red-600 hover:bg-red-700 text-white flex items-center justify-center font-black text-sm uppercase shadow-md hover:shadow-lg hover:scale-105 active:scale-95 transition-all duration-200 ring-2 {{ request()->routeIs('admin.profile.*') ? 'ring-red-600 ring-offset-2 dark:ring-offset-slate-900' : 'ring-red-600/20 hover:ring-red-600' }}">
                    {{ auth()->user()->initials }}
                </a>
            </div>
        </header>

        <!-- Main Body Content -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 w-full max-w-7xl mx-auto space-y-6">
            @include('partials.notifications')

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white dark:bg-slate-900 border-t border-slate-200/80 dark:border-slate-800 py-3.5 px-4 sm:px-6 text-[11px] sm:text-xs text-slate-500 dark:text-slate-400 flex flex-col sm:flex-row justify-between items-center gap-2 transition-colors duration-200">
            <p>&copy; {{ date('Y') }} Karate Polindra Tracker • Workspace Administrator</p>
            <span class="font-mono text-slate-400 dark:text-slate-500">v1.0.0</span>
        </footer>
    </div>

    <script>
        const sidebar = document.getElementById('mobile-sidebar');
        document.getElementById('open-mobile-sidebar')?.addEventListener('click', () => sidebar.classList.remove('hidden'));
        document.getElementById('close-mobile-sidebar')?.addEventListener('click', () => sidebar.classList.add('hidden'));
        document.getElementById('mobile-sidebar-backdrop')?.addEventListener('click', () => sidebar.classList.add('hidden'));

        // Theme Switcher Logic
        function syncThemeUI() {
            const isDark = document.documentElement.classList.contains('dark');
            
            // Desktop Sidebar elements
            const sidebarSun = document.getElementById('sidebar-sun-icon');
            const sidebarMoon = document.getElementById('sidebar-moon-icon');
            const sidebarBg = document.getElementById('sidebar-switch-bg');
            const sidebarKnob = document.getElementById('sidebar-switch-knob');
            const sidebarEmoji = document.getElementById('sidebar-switch-emoji');

            // Mobile Sidebar elements
            const mobileSun = document.getElementById('mobile-sidebar-sun-icon');
            const mobileMoon = document.getElementById('mobile-sidebar-moon-icon');
            const mobileBg = document.getElementById('mobile-sidebar-switch-bg');
            const mobileKnob = document.getElementById('mobile-sidebar-switch-knob');
            const mobileEmoji = document.getElementById('mobile-sidebar-switch-emoji');

            if (isDark) {
                // Desktop
                if (sidebarSun) sidebarSun.classList.remove('hidden');
                if (sidebarMoon) sidebarMoon.classList.add('hidden');
                if (sidebarBg) {
                    sidebarBg.classList.remove('bg-slate-700/80');
                    sidebarBg.classList.add('bg-brand-primary');
                }
                if (sidebarKnob) {
                    sidebarKnob.classList.remove('translate-x-0');
                    sidebarKnob.classList.add('translate-x-5');
                }
                if (sidebarEmoji) sidebarEmoji.textContent = '☀️';

                // Mobile
                if (mobileSun) mobileSun.classList.remove('hidden');
                if (mobileMoon) mobileMoon.classList.add('hidden');
                if (mobileBg) {
                    mobileBg.classList.remove('bg-slate-700/80');
                    mobileBg.classList.add('bg-brand-primary');
                }
                if (mobileKnob) {
                    mobileKnob.classList.remove('translate-x-0');
                    mobileKnob.classList.add('translate-x-5');
                }
                if (mobileEmoji) mobileEmoji.textContent = '☀️';
            } else {
                // Desktop
                if (sidebarSun) sidebarSun.classList.add('hidden');
                if (sidebarMoon) sidebarMoon.classList.remove('hidden');
                if (sidebarBg) {
                    sidebarBg.classList.add('bg-slate-700/80');
                    sidebarBg.classList.remove('bg-brand-primary');
                }
                if (sidebarKnob) {
                    sidebarKnob.classList.add('translate-x-0');
                    sidebarKnob.classList.remove('translate-x-5');
                }
                if (sidebarEmoji) sidebarEmoji.textContent = '🌙';

                // Mobile
                if (mobileSun) mobileSun.classList.add('hidden');
                if (mobileMoon) mobileMoon.classList.remove('hidden');
                if (mobileBg) {
                    mobileBg.classList.add('bg-slate-700/80');
                    mobileBg.classList.remove('bg-brand-primary');
                }
                if (mobileKnob) {
                    mobileKnob.classList.add('translate-x-0');
                    mobileKnob.classList.remove('translate-x-5');
                }
                if (mobileEmoji) mobileEmoji.textContent = '🌙';
            }
        }

        function toggleAdminTheme() {
            const isCurrentlyDark = document.documentElement.classList.contains('dark');
            if (isCurrentlyDark) {
                document.documentElement.classList.remove('dark');
                document.body.classList.remove('dark');
                localStorage.setItem('karate_theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                document.body.classList.add('dark');
                localStorage.setItem('karate_theme', 'dark');
            }
            syncThemeUI();
            window.dispatchEvent(new CustomEvent('karateThemeChanged', { 
                detail: { isDark: !isCurrentlyDark } 
            }));
        }

        // Initialize theme and UI
        document.addEventListener('DOMContentLoaded', () => {
            const storedTheme = localStorage.getItem('karate_theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (storedTheme === 'dark' || (!storedTheme && prefersDark)) {
                document.documentElement.classList.add('dark');
                document.body.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
                document.body.classList.remove('dark');
            }
            syncThemeUI();
        });
    </script>
</body>
</html>
