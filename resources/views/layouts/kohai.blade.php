<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kohai Dashboard') - Karate Tracker</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-brand-light min-h-screen flex selection:bg-brand-secondary selection:text-white overflow-x-hidden">

    <!-- Desktop Sidebar Kohai -->
    <aside class="hidden lg:flex flex-col w-64 bg-brand-black text-white min-h-screen fixed inset-y-0 left-0 z-40 border-r border-gray-800 shadow-2xl">
        <!-- Sidebar Brand -->
        <div class="h-16 flex items-center px-6 border-b border-gray-800/80 gap-3 shrink-0">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-brand-secondary to-brand-primary flex items-center justify-center shadow-lg shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div>
                <a href="{{ route('kohai.dashboard') }}" class="text-lg font-black tracking-wider text-white">
                    KOHAI<span class="text-brand-secondary">DOJO</span>
                </a>
                <span class="block text-[10px] text-brand-secondary font-bold uppercase tracking-widest">Anggota / Murid</span>
            </div>
        </div>

        <!-- Sidebar Navigation Menu -->
        <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
            <div class="text-[10px] font-extrabold uppercase text-gray-500 tracking-wider px-3 mb-2">Progres Saya</div>

            <a href="{{ route('kohai.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('kohai.dashboard') ? 'bg-brand-primary text-white shadow-md' : 'text-gray-400 hover:text-white hover:bg-gray-900' }} transition">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('kohai.dashboard') ? 'text-brand-secondary' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span>Dashboard Kohai</span>
            </a>

            <a href="{{ route('kohai.kumite.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('kohai.kumite.*') ? 'bg-brand-primary text-white shadow-md' : 'text-gray-400 hover:text-white hover:bg-gray-900' }} transition">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('kohai.kumite.*') ? 'text-brand-secondary' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                <span>Raport Kumite Saya</span>
            </a>
        </nav>

        <!-- Sidebar User Profile Footer -->
        <div class="p-4 border-t border-gray-800/80 bg-gray-950/60 shrink-0">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-brand-secondary text-white flex items-center justify-center font-bold text-xs uppercase shrink-0">
                        {{ substr(auth()->user()->name, 0, 2) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-white truncate max-w-[110px]">{{ auth()->user()->name }}</p>
                        <span class="text-[10px] text-brand-secondary font-semibold uppercase block truncate">Kohai / Murid</span>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="shrink-0">
                    @csrf
                    <button type="submit" title="Keluar" class="p-2 rounded-lg text-gray-400 hover:text-red-400 hover:bg-gray-900 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Mobile Drawer Kohai Sidebar -->
    <div id="mobile-sidebar" class="fixed inset-0 z-50 hidden lg:hidden">
        <div id="mobile-sidebar-backdrop" class="fixed inset-0 bg-black/70 backdrop-blur-xs"></div>
        <div class="fixed inset-y-0 left-0 w-72 max-w-[85vw] bg-brand-black text-white flex flex-col z-10 shadow-2xl">
            <div class="h-16 flex items-center justify-between px-5 border-b border-gray-800 shrink-0">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-brand-secondary text-white flex items-center justify-center font-bold text-xs">K</div>
                    <span class="text-base font-black tracking-wider text-white">KOHAI<span class="text-brand-secondary">DOJO</span></span>
                </div>
                <button id="close-mobile-sidebar" class="p-2 rounded-lg text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <nav class="flex-1 px-4 py-5 space-y-2 overflow-y-auto">
                <a href="{{ route('kohai.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm bg-brand-primary text-white">Dashboard Kohai</a>
            </nav>
            <div class="p-4 border-t border-gray-800 bg-gray-950/80 shrink-0">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-xs font-bold transition shadow-md">
                        <span>Keluar dari Akun</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content Wrapper with min-w-0 for flex layout -->
    <div class="flex-1 min-w-0 lg:pl-64 flex flex-col min-h-screen w-full">
        <!-- Top Navbar -->
        <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-3 sm:px-6 lg:px-8 sticky top-0 z-30 shadow-2xs">
            <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                <button id="open-mobile-sidebar" class="lg:hidden p-2 rounded-xl text-gray-700 hover:bg-gray-100 focus:outline-none shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h2 class="text-sm sm:text-lg font-bold text-brand-black truncate">Panel Kohai / Anggota Dojo</h2>
            </div>
            
            <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                <span class="px-2.5 py-1 bg-brand-secondary/20 text-brand-black border border-brand-secondary/40 rounded-full text-[11px] sm:text-xs font-extrabold uppercase whitespace-nowrap">
                    Role: Kohai
                </span>
                <span class="hidden md:inline-block text-xs text-gray-500 max-w-[150px] truncate">{{ auth()->user()->email }}</span>
            </div>
        </header>

        <!-- Main Body Content -->
        <main class="flex-1 p-3 sm:p-6 lg:p-8 w-full max-w-7xl mx-auto">
            @if(session('success'))
                <div class="mb-5 p-3.5 sm:p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm flex items-center gap-3 shadow-xs">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('warning'))
                <div class="mb-5 p-3.5 sm:p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs sm:text-sm flex items-center gap-3 shadow-xs">
                    <svg class="w-5 h-5 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span>{{ session('warning') }}</span>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-3.5 px-4 sm:px-6 text-[11px] sm:text-xs text-gray-500 flex flex-col sm:flex-row justify-between items-center gap-2">
            <p>&copy; {{ date('Y') }} Karate Dojo Tracker • Student Member Workspace</p>
            <span>v1.0.0</span>
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
