<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kohai Dashboard') - Karate Tracker</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen flex text-slate-800 antialiased selection:bg-brand-primary selection:text-white overflow-x-hidden">

    <!-- Desktop Sidebar Kohai -->
    <aside class="hidden lg:flex flex-col w-64 bg-slate-900 text-white min-h-screen fixed inset-y-0 left-0 z-40 border-r border-slate-800/80 shadow-xl">
        <!-- Sidebar Brand Header -->
        <div class="h-16 flex items-center px-5 border-b border-slate-800/80 gap-3 shrink-0">
            <div class="w-9 h-9 rounded-xl bg-slate-800 border border-slate-700/80 p-1.5 flex items-center justify-center shrink-0">
                <img src="{{ asset('images/LOGO KARATER POLINDRA.png') }}" alt="Logo Polindra" class="w-full h-full object-contain">
            </div>
            <div>
                <a href="{{ route('kohai.dashboard') }}" class="text-base font-extrabold tracking-tight text-white block leading-tight">
                    KOHAI<span class="text-brand-secondary">POLINDRA</span>
                </a>
                <span class="block text-[10px] text-brand-secondary font-bold uppercase tracking-widest mt-0.5">Anggota / Murid</span>
            </div>
        </div>

        <!-- Sidebar Navigation Menu -->
        <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto">
            <div class="text-[10px] font-bold uppercase text-slate-500 tracking-wider px-3 mb-2">Progres Saya</div>

            <a href="{{ route('kohai.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition-all duration-200 {{ request()->routeIs('kohai.dashboard') ? 'bg-gradient-to-r from-brand-primary to-brand-secondary text-white shadow-md shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('kohai.dashboard') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span>Dashboard Kohai</span>
            </a>

            <a href="{{ route('kohai.kumite.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition-all duration-200 {{ request()->routeIs('kohai.kumite.*') ? 'bg-gradient-to-r from-brand-primary to-brand-secondary text-white shadow-md shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('kohai.kumite.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                <span>Raport Kumite Saya</span>
            </a>

            <a href="{{ route('kohai.attendance.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition-all duration-200 {{ request()->routeIs('kohai.attendance.*') ? 'bg-gradient-to-r from-brand-primary to-brand-secondary text-white shadow-md shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('kohai.attendance.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                <span>Scan Absensi QR</span>
            </a>
        </nav>

        <!-- Sidebar User Profile Footer -->
        <div class="p-3.5 border-t border-slate-800/80 bg-slate-950/60 shrink-0">
            <div class="flex items-center justify-between gap-2">
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-9 h-9 rounded-xl bg-brand-secondary text-slate-900 flex items-center justify-center font-bold text-xs uppercase shrink-0 shadow-xs">
                        {{ substr(auth()->user()->name, 0, 2) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-white truncate max-w-[110px]">{{ auth()->user()->name }}</p>
                        <span class="text-[10px] text-brand-secondary font-semibold uppercase block truncate">Kohai / Murid</span>
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

    <!-- Mobile Drawer Kohai Sidebar -->
    <div id="mobile-sidebar" class="fixed inset-0 z-50 hidden lg:hidden">
        <div id="mobile-sidebar-backdrop" class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs transition-opacity"></div>
        <div class="fixed inset-y-0 left-0 w-72 max-w-[85vw] bg-slate-900 text-white flex flex-col z-10 shadow-2xl transition-transform duration-300">
            <div class="h-16 flex items-center justify-between px-5 border-b border-slate-800 shrink-0">
                <div class="flex items-center gap-2.5">
                    <img src="{{ asset('images/LOGO KARATER POLINDRA.png') }}" alt="Logo Polindra" class="w-8 h-8 object-contain shrink-0">
                    <span class="text-base font-extrabold tracking-tight text-white">KOHAI<span class="text-brand-secondary">DOJO</span></span>
                </div>
                <button id="close-mobile-sidebar" class="p-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <nav class="flex-1 px-4 py-5 space-y-2 overflow-y-auto">
                <a href="{{ route('kohai.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm {{ request()->routeIs('kohai.dashboard') ? 'bg-gradient-to-r from-brand-primary to-brand-secondary text-white shadow-md' : 'text-slate-300 hover:bg-slate-800' }}">
                    <svg class="w-5 h-5 shrink-0 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span>Dashboard Kohai</span>
                </a>
                <a href="{{ route('kohai.kumite.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm {{ request()->routeIs('kohai.kumite.*') ? 'bg-gradient-to-r from-brand-primary to-brand-secondary text-white shadow-md' : 'text-slate-300 hover:bg-slate-800' }}">
                    <svg class="w-5 h-5 shrink-0 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    <span>Raport Kumite Saya</span>
                </a>
                <a href="{{ route('kohai.attendance.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm {{ request()->routeIs('kohai.attendance.*') ? 'bg-gradient-to-r from-brand-primary to-brand-secondary text-white shadow-md' : 'text-slate-300 hover:bg-slate-800' }}">
                    <svg class="w-5 h-5 shrink-0 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                    <span>Scan Absensi QR</span>
                </a>
            </nav>
            <div class="p-4 border-t border-slate-800 bg-slate-950/80 shrink-0">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-9 h-9 rounded-xl bg-brand-secondary text-slate-900 flex items-center justify-center font-bold text-xs uppercase">
                        {{ substr(auth()->user()->name, 0, 2) }}
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
        <header class="bg-white/90 backdrop-blur-md border-b border-slate-200/80 h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8 sticky top-0 z-30">
            <div class="flex items-center gap-3 min-w-0">
                <button id="open-mobile-sidebar" class="lg:hidden p-2 rounded-xl text-slate-700 hover:bg-slate-100 focus:outline-none shrink-0" aria-label="Buka Menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-brand-secondary animate-pulse"></span>
                    <h2 class="text-sm sm:text-base font-extrabold text-slate-900 truncate tracking-tight">Panel Kohai / Anggota Dojo</h2>
                </div>
            </div>
            
            <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                <span class="px-3 py-1 bg-cyan-50 text-cyan-800 border border-cyan-200/80 rounded-full text-[11px] font-extrabold uppercase whitespace-nowrap">
                    Role: Kohai
                </span>
                <span class="hidden md:inline-block text-xs font-medium text-slate-500 max-w-[160px] truncate">{{ auth()->user()->email }}</span>
            </div>
        </header>

        <!-- Main Body Content -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 w-full max-w-7xl mx-auto space-y-6">
            @include('partials.notifications')

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-slate-200/80 py-3.5 px-4 sm:px-6 text-[11px] sm:text-xs text-slate-500 flex flex-col sm:flex-row justify-between items-center gap-2">
            <p>&copy; {{ date('Y') }} Karate Polindra Progress Tracker System • Student Member Workspace</p>
            <span class="font-mono text-slate-400">v1.0.0</span>
        </footer>
    </div>

    <script>
        const sidebar = document.getElementById('mobile-sidebar');
        document.getElementById('open-mobile-sidebar')?.addEventListener('click', () => sidebar.classList.remove('hidden'));
        document.getElementById('close-mobile-sidebar')?.addEventListener('click', () => sidebar.classList.add('hidden'));
        document.getElementById('mobile-sidebar-backdrop')?.addEventListener('click', () => sidebar.classList.add('hidden'));
    </script>
</body>
</html>
