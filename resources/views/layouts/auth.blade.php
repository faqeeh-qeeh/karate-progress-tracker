<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Otentikasi System') - Karate Tracker</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-brand-light min-h-screen flex flex-col justify-between text-slate-800 antialiased selection:bg-brand-primary selection:text-white">
    <!-- Top Branding Accent Bar -->
    <div class="h-1.5 bg-gradient-to-r from-brand-black via-brand-primary to-brand-secondary"></div>

    <main class="flex-grow flex items-center justify-center p-4 sm:p-6 py-8">
        <div class="w-full max-w-md space-y-6">
            <!-- Header Logo -->
            <div class="text-center space-y-2">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-brand-black text-white shadow-lg ring-4 ring-brand-primary/20 p-2.5 transform hover:scale-105 transition-all duration-300">
                    <img src="{{ asset('images/LOGO KARATER POLINDRA.png') }}" alt="Logo Polindra" class="w-full h-full object-contain">
                </div>
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-brand-black tracking-tight font-sans">
                        KARATE<span class="text-brand-secondary">POLINDRA</span>
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 font-medium mt-0.5">Sistem Informasi & Track Progress Karate</p>
                </div>
            </div>

            @include('partials.notifications')

            <!-- Auth Content Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200/80 p-6 sm:p-8">
                @yield('content')
            </div>

            <!-- Footer info -->
            <p class="text-center text-xs text-slate-400 font-medium">
                &copy; {{ date('Y') }} Karate Progress Tracker. All rights reserved.
            </p>
        </div>
    </main>

    <!-- Bottom Accent -->
    <div class="h-1 bg-brand-black"></div>
</body>
</html>
