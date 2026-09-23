<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Otentikasi') — UKM Karate Polindra</title>
    <meta name="description" content="Sistem KARATER — UKM Karate Politeknik Negeri Indramayu">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --aka: #c8102e;
            --ao:  #1a56c9;
            --ao-light: #4d8cff;
        }

        html, body { height: 100%; min-height: 100%; }
        body { font-family: 'Inter', sans-serif; }

        /* Thin top accent bar — dual color */
        .auth-accent-bar {
            height: 3px;
            background: linear-gradient(90deg, var(--aka) 0%, var(--aka) 50%, var(--ao) 50%, var(--ao) 100%);
        }

        /* Side panel */
        .auth-side {
            background: #06080f;
            position: relative;
            overflow: hidden;
        }
        .auth-side::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse at 20% 80%, rgba(200,16,46,0.25) 0%, transparent 55%),
                radial-gradient(ellipse at 80% 20%, rgba(26,86,201,0.2) 0%, transparent 55%);
        }
        .auth-side-noise {
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
            opacity: 0.5;
        }
        .auth-side-content {
            position: relative;
            z-index: 1;
            padding: 48px 40px;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        /* Watermark text */
        .auth-watermark {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 96px;
            line-height: 0.88;
            letter-spacing: 0.03em;
            color: rgba(255,255,255,0.035);
            pointer-events: none;
            user-select: none;
        }

        /* Accent line */
        .auth-side-line {
            width: 2px;
            height: 48px;
            background: linear-gradient(to bottom, var(--aka), var(--ao));
            margin-bottom: 20px;
        }

        /* Input focus ring uses brand colors */
        .auth-input:focus {
            outline: none;
            ring: none;
            border-color: var(--aka) !important;
            box-shadow: 0 0 0 3px rgba(200,16,46,0.1) !important;
        }

        /* Red-blue gradient button */
        .btn-aka {
            background: var(--aka);
            transition: all 0.25s ease;
        }
        .btn-aka:hover {
            background: #e0132f;
            box-shadow: 0 8px 24px rgba(200,16,46,0.3);
            transform: translateY(-1px);
        }

        /* Underline hover link — blue */
        .link-ao { color: var(--ao); }
        .link-ao:hover { color: var(--ao-light); }

        /* Step number badges */
        .step-badge-red { background: var(--aka); }
        .step-badge-blue { background: var(--ao); }

        /* Tag pill */
        .auth-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }
        .auth-pill-blue {
            background: rgba(26,86,201,0.08);
            color: var(--ao);
            border: 1px solid rgba(26,86,201,0.15);
        }

        /* Custom scrollbar matching landing page (Aka x Ao gradient) */
        ::-webkit-scrollbar {
            width: 5px;
        }
        ::-webkit-scrollbar-track {
            background: #f8fafc;
        }
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, var(--aka), var(--ao));
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #e0132f, #4d8cff);
        }

        /* Scrollbar inside textarea */
        #message-body::-webkit-scrollbar { width: 4px; }
        #message-body::-webkit-scrollbar-track { background: #1e2030; }
        #message-body::-webkit-scrollbar-thumb { background: var(--aka); border-radius: 2px; }

        /* Toast */
        #copy-toast { transition: all 0.3s cubic-bezier(0.16,1,0.3,1); }

        /* Divider label */
        .divider-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #94a3b8;
        }

        @media (max-width: 767px) {
            .auth-side { display: none; }
        }
    </style>
</head>
<body class="bg-white min-h-screen md:h-screen md:overflow-hidden antialiased selection:bg-red-600 selection:text-white flex flex-col">

    {{-- Top accent bar --}}
    <div class="auth-accent-bar flex-shrink-0"></div>

    <div class="flex-1 flex flex-col md:flex-row min-h-0 overflow-y-auto md:overflow-hidden">

        {{-- ── Left: Dark Side Panel (Permanent Fixed & Non-scrollable) ──────── --}}
        <aside class="auth-side hidden md:flex w-[360px] lg:w-[420px] xl:w-[440px] flex-shrink-0 flex-col h-full overflow-hidden select-none">
            <div class="auth-side-noise"></div>
            <div class="auth-side-content h-full flex flex-col justify-between">

                {{-- Logo --}}
                <a href="{{ route('landing') }}" class="flex items-center gap-3 group shrink-0" id="auth-side-logo">
                    <img src="{{ asset('images/LOGO KARATER POLINDRA.png') }}"
                         alt="Logo UKM Karate Polindra"
                         class="h-10 w-auto group-hover:scale-105 transition-transform duration-300">
                    <div class="flex flex-col leading-tight">
                        <span style="font-family:'Bebas Neue',sans-serif;font-size:17px;letter-spacing:0.08em;color:#f0f2f8;">
                            UKM KARATE
                        </span>
                        <span style="font-size:9px;letter-spacing:0.14em;text-transform:uppercase;color:rgba(220,228,255,0.5);">
                            Politeknik Negeri Indramayu
                        </span>
                    </div>
                </a>

                {{-- Main panel content --}}
                <div class="my-auto py-6">
                    {{-- Watermark --}}
                    <div class="auth-watermark mb-5 select-none">
                        AKA<br>×<br>AO
                    </div>

                    {{-- Accent line + headline --}}
                    <div class="auth-side-line"></div>
                    <h2 style="font-family:'Bebas Neue',sans-serif;font-size:clamp(28px,3vw,38px);letter-spacing:0.04em;color:#f0f2f8;line-height:1.05;margin-bottom:12px;">
                        SATU JIWA,<br>SATU <span style="color:#c8102e;">TEKAD</span>
                    </h2>
                    <p style="font-size:13px;color:rgba(220,228,255,0.5);line-height:1.7;max-width:280px;">
                        Platform resmi pencatatan progress dan manajemen anggota UKM Karate Polindra.
                    </p>
                </div>

                {{-- Footer --}}
                <p class="shrink-0" style="font-size:11px;color:rgba(220,228,255,0.3);">
                    © {{ date('Y') }} UKM Karate Polindra
                </p>

            </div>
        </aside>

        {{-- ── Right: White Content Area (Scrolls independently) ── --}}
        <main class="flex-1 flex flex-col min-h-0 overflow-y-auto bg-white">
            {{-- Top mini nav --}}
            <div class="flex-shrink-0 flex items-center justify-between px-6 sm:px-10 py-4 border-b border-slate-100 bg-white/90 backdrop-blur-sm sticky top-0 z-20">
                <a href="{{ route('landing') }}" id="auth-back-landing"
                   class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-slate-700 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Beranda
                </a>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-slate-400">
                        @if(request()->routeIs('login'))
                            Belum punya akun?
                        @else
                            Sudah punya akun?
                        @endif
                    </span>
                    @if(request()->routeIs('login'))
                        <a href="{{ route('register') }}" id="auth-switch-register"
                           class="text-xs font-bold link-ao hover:underline underline-offset-2 transition-colors">
                            Lihat Cara Daftar →
                        </a>
                    @else
                        <a href="{{ route('login') }}" id="auth-switch-login"
                           class="text-xs font-bold link-ao hover:underline underline-offset-2 transition-colors">
                            Masuk ke Sistem →
                        </a>
                    @endif
                </div>
            </div>

            {{-- Content area (my-auto centers vertically when height allows, scrolls smoothly when tall) --}}
            <div class="flex-1 flex flex-col justify-center px-6 sm:px-10 lg:px-12 py-8 sm:py-10">
                <div class="w-full @yield('card-width', 'max-w-md') mx-auto my-auto">

                    @include('partials.notifications')

                    @yield('content')

                </div>
            </div>

            {{-- Bottom footer --}}
            <div class="flex-shrink-0 px-6 sm:px-10 py-4 border-t border-slate-100 flex items-center justify-between flex-wrap gap-2 bg-white">
                <p class="text-xs text-slate-400">© {{ date('Y') }} Karate Progress Tracker — Polindra</p>
                <div style="display:flex;align-items:center;gap:6px;font-size:11px;color:#94a3b8;">
                    <span style="width:6px;height:6px;border-radius:50%;background:#22c55e;display:inline-block;animation:pulse 2s ease-in-out infinite;"></span>
                    Sistem Online
                </div>
            </div>
        </main>

    </div>

    <style>
        @keyframes pulse {
            0%,100% { opacity:1; }
            50% { opacity:0.4; }
        }
    </style>

</body>
</html>
