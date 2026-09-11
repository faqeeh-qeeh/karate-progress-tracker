<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Otentikasi System') - Karate Tracker</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-brand-light min-h-screen flex flex-col justify-between selection:bg-brand-secondary selection:text-white">
    <!-- Top Branding Accent Bar -->
    <div class="h-2 bg-gradient-to-r from-brand-black via-brand-primary to-brand-secondary"></div>

    <main class="flex-grow flex items-center justify-center p-4 sm:p-6 md:p-8">
        <div class="w-full max-w-md">
            <!-- Header Logo -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-brand-black text-white shadow-xl ring-4 ring-brand-primary/20 mb-4 transform hover:scale-105 transition-transform duration-300">
                    <svg class="w-9 h-9 text-brand-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-extrabold text-brand-black tracking-tight">KARATE<span class="text-brand-secondary">DOJO</span></h1>
                <p class="text-sm text-gray-600 mt-1 font-medium">Sistem Informasi & Track Progress Karate</p>
            </div>

            <!-- Flash Alert -->
            @if(session('error'))
                <div class="mb-5 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm flex items-center gap-3 shadow-sm animate-fade-in">
                    <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-5 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm flex items-center gap-3 shadow-sm animate-fade-in">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Auth Content Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 sm:p-8 backdrop-blur-lg">
                @yield('content')
            </div>

            <!-- Footer info -->
            <p class="text-center text-xs text-gray-500 mt-8">
                &copy; {{ date('Y') }} Karate Progress Tracker. All rights reserved.
            </p>
        </div>
    </main>

    <!-- Bottom Accent -->
    <div class="h-1 bg-brand-black"></div>
</body>
</html>
