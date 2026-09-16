<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Karate Polindra Tracker</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-brand-light min-h-screen flex flex-col selection:bg-brand-secondary selection:text-white">
    <!-- Navbar -->
    <header class="bg-brand-black text-white shadow-lg sticky top-0 z-50 border-b border-brand-primary/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Brand Logo & Name -->
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/LOGO KARATER POLINDRA.png') }}" alt="Logo Polindra" class="w-10 h-10 object-contain shrink-0">
                    <div>
                        <a href="{{ url('/') }}" class="text-xl font-black tracking-wider text-white hover:text-brand-secondary transition">
                            KARATE<span class="text-brand-secondary">POLINDRA</span>
                        </a>
                        <span class="hidden sm:inline-block text-xs text-gray-400 ml-2 font-mono">v1.0</span>
                    </div>
                </div>

                <!-- Desktop User Navigation -->
                <div class="hidden md:flex items-center space-x-4">
                    <!-- Role Badge -->
                    @php
                        $userRole = auth()->user()->role->nama ?? 'User';
                        $badgeBg = match(strtolower($userRole)) {
                            'admin' => 'bg-red-900/60 text-red-200 border-red-500/30',
                            'senpai' => 'bg-brand-primary/60 text-white border-brand-primary/40',
                            'kohai' => 'bg-brand-secondary/30 text-brand-secondary border-brand-secondary/40',
                            default => 'bg-gray-800 text-gray-300 border-gray-700'
                        };
                    @endphp

                    <div class="flex items-center space-x-3 bg-gray-900/80 px-3 py-1.5 rounded-full border border-gray-800">
                        <div class="w-8 h-8 rounded-full bg-brand-primary text-white flex items-center justify-center font-bold text-xs uppercase">
                            {{ auth()->user()->initials }}
                        </div>
                        <div class="text-left">
                            <p class="text-xs font-semibold text-white leading-tight">{{ auth()->user()->name }}</p>
                            <span class="inline-block text-[10px] uppercase font-bold px-2 py-0.5 rounded-full border {{ $badgeBg }}">
                                {{ $userRole }}
                            </span>
                        </div>
                    </div>

                    <!-- Logout Button -->
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-red-600/90 hover:bg-red-700 text-white text-xs font-semibold shadow transition duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn" type="button" class="p-2 rounded-lg text-gray-300 hover:text-white hover:bg-gray-800 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div id="mobile-menu" class="hidden md:hidden bg-gray-900 border-t border-gray-800 px-4 pt-3 pb-4 space-y-3">
            <div class="flex items-center space-x-3 pb-3 border-b border-gray-800">
                <div class="w-10 h-10 rounded-full bg-brand-primary text-white flex items-center justify-center font-bold text-sm">
                    {{ auth()->user()->initials }}
                </div>
                <div>
                    <p class="text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-400">{{ auth()->user()->email }}</p>
                    <span class="inline-block mt-1 text-[10px] uppercase font-bold px-2 py-0.5 rounded-full border {{ $badgeBg }}">
                        Role: {{ $userRole }}
                    </span>
                </div>
            </div>
            
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-red-600 text-white text-sm font-medium shadow">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span>Keluar dari Akun</span>
                </button>
            </form>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @include('partials.notifications')

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-brand-black text-gray-400 py-6 border-t border-gray-800 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center text-xs gap-3">
            <p>&copy; {{ date('Y') }} Karate Polindra Progress Tracker System. Hak Cipta Dilindungi.</p>
            <div class="flex items-center space-x-4">
                <span class="text-brand-secondary font-semibold">Role: {{ auth()->user()->role->nama ?? 'Role' }}</span>
                <span>•</span>
                <span>Karate System v1.0</span>
            </div>
        </div>
    </footer>

    <script>
        // Toggle mobile menu
        document.getElementById('mobile-menu-btn')?.addEventListener('click', function () {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
