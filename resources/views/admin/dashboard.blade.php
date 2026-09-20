@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">
    <!-- Header Hero Banner Administrator -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-slate-800 to-brand-primary p-6 sm:p-8 text-white shadow-xl">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2.5 max-w-2xl">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-500/20 border border-red-500/30 text-[11px] font-black text-red-300">
                        <span class="w-2 h-2 rounded-full bg-red-400 animate-ping"></span>
                        PUSAT KONTROL ADMINISTRATOR
                    </span>
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-white/10 backdrop-blur-xs border border-white/20 text-[11px] font-bold text-slate-200">
                        <span>🛡️</span> Akses Penuh Sistem
                    </span>
                </div>

                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight leading-tight">
                    Selamat Datang, Admin {{ auth()->user()->name }}! 👋
                </h1>
                <p class="text-slate-300 text-xs sm:text-sm font-medium leading-relaxed">
                    Kelola akun pengguna, konfigurasi master data tingkatan sabuk & kurikulum akademik Polindra, serta pantau seluruh aktivitas dojo secara terpusat.
                </p>
            </div>

            <!-- Quick Action Shortcut Buttons -->
            <div class="flex flex-wrap sm:flex-nowrap items-center gap-3 shrink-0">
                <a href="{{ route('admin.users.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 sm:px-5 py-3 rounded-2xl bg-brand-secondary hover:bg-sky-400 text-slate-950 font-black text-xs sm:text-sm shadow-lg shadow-brand-secondary/20 hover:scale-[1.02] active:scale-[0.98] transition-all">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    <span>Tambah User Baru</span>
                </a>

                <a href="{{ route('admin.belts.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 sm:px-5 py-3 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold text-xs sm:text-sm backdrop-blur-md hover:scale-[1.02] active:scale-[0.98] transition-all">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    <span>Master Sabuk</span>
                </a>
            </div>
        </div>

        <div class="absolute -right-8 -bottom-8 w-64 h-64 bg-brand-secondary/15 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- 4 Main KPI Cards: User Management -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        <!-- Total Users -->
        <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs hover:shadow-md hover:border-slate-400 dark:hover:border-slate-700 transition-all duration-200 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Total Pengguna</p>
                    <p class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white mt-1">{{ $totalUsers }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200 flex items-center justify-center text-xl font-bold group-hover:scale-110 transition-transform">
                    👥
                </div>
            </div>
            <div class="flex items-center justify-between text-xs text-slate-500 dark:text-slate-400 font-medium mt-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                <span>Seluruh Akun Terdaftar</span>
                <a href="{{ route('admin.users.index') }}" class="text-slate-900 dark:text-brand-secondary font-bold hover:underline">Kelola &rarr;</a>
            </div>
        </div>

        <!-- Total Senpai -->
        <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs hover:shadow-md hover:border-brand-primary/40 transition-all duration-200 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Pelatih (Senpai)</p>
                    <p class="text-2xl sm:text-3xl font-black text-brand-primary dark:text-sky-400 mt-1">{{ $totalSenpai }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-brand-primary/10 dark:bg-brand-primary/20 text-brand-primary dark:text-sky-400 flex items-center justify-center text-xl font-bold group-hover:scale-110 transition-transform">
                    🥋
                </div>
            </div>
            <div class="flex items-center justify-between text-xs text-slate-500 dark:text-slate-400 font-medium mt-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                <span>Instruktur Karate Dojo</span>
                <span class="text-brand-primary dark:text-sky-400 font-extrabold">Aktif</span>
            </div>
        </div>

        <!-- Total Kohai -->
        <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs hover:shadow-md hover:border-brand-secondary/40 transition-all duration-200 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Murid (Kohai)</p>
                    <p class="text-2xl sm:text-3xl font-black text-brand-secondary mt-1">{{ $totalKohai }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-brand-secondary/10 dark:bg-brand-secondary/20 text-brand-secondary flex items-center justify-center text-xl font-bold group-hover:scale-110 transition-transform">
                    ⚪
                </div>
            </div>
            <div class="flex items-center justify-between text-xs text-slate-500 dark:text-slate-400 font-medium mt-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                <span>Anggota Latihan Dojo</span>
                <span class="text-brand-secondary font-extrabold">Aktif</span>
            </div>
        </div>

        <!-- Total Admin -->
        <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs hover:shadow-md hover:border-red-400 transition-all duration-200 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Administrator</p>
                    <p class="text-2xl sm:text-3xl font-black text-red-600 dark:text-red-400 mt-1">{{ $totalAdmin }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-red-50 dark:bg-red-950/40 text-red-600 dark:text-red-400 flex items-center justify-center text-xl font-bold group-hover:scale-110 transition-transform">
                    🔒
                </div>
            </div>
            <div class="flex items-center justify-between text-xs text-slate-500 dark:text-slate-400 font-medium mt-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                <span>Super Admin Access</span>
                <span class="text-red-700 dark:text-red-400 font-extrabold">Full Control</span>
            </div>
        </div>
    </div>

    <!-- 4 Secondary Metric Cards: Master Data & Activities -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        <!-- Raport Kumite -->
        <div class="bg-slate-900 dark:bg-slate-900/90 border border-transparent dark:border-slate-800 p-5 rounded-2xl text-white shadow-sm hover:shadow-md transition-all space-y-2">
            <div class="flex items-center justify-between text-slate-400 text-xs font-extrabold uppercase tracking-wider">
                <span>Laga Kumite WKF</span>
                <span>🏆</span>
            </div>
            <p class="text-2xl font-black text-white">{{ $totalKumiteReports }} Laga</p>
            <p class="text-[11px] text-slate-400 font-medium pt-1 border-t border-slate-800">Evaluasi Pertandingan Dojo</p>
        </div>

        <!-- Sesi & Presensi Absensi -->
        <div class="bg-slate-900 dark:bg-slate-900/90 border border-transparent dark:border-slate-800 p-5 rounded-2xl text-white shadow-sm hover:shadow-md transition-all space-y-2">
            <div class="flex items-center justify-between text-slate-400 text-xs font-extrabold uppercase tracking-wider">
                <span>Absensi & Presensi</span>
                <span>📅</span>
            </div>
            <p class="text-2xl font-black text-white">{{ $totalAttendanceSessions }} Sesi</p>
            <p class="text-[11px] text-slate-400 font-medium pt-1 border-t border-slate-800">{{ $totalAttendances }} Log Presensi Hadir</p>
        </div>

        <!-- Sabuk & Tingkatan -->
        <div class="bg-slate-900 dark:bg-slate-900/90 border border-transparent dark:border-slate-800 p-5 rounded-2xl text-white shadow-sm hover:shadow-md transition-all space-y-2">
            <div class="flex items-center justify-between text-slate-400 text-xs font-extrabold uppercase tracking-wider">
                <span>Sabuk & Rank</span>
                <span>🥋</span>
            </div>
            <p class="text-2xl font-black text-white">{{ $totalBelts }} Sabuk</p>
            <p class="text-[11px] text-slate-400 font-medium pt-1 border-t border-slate-800">{{ $totalRanks }} Tingkatan Kyu / Dan</p>
        </div>

        <!-- Struktur Polindra -->
        <div class="bg-slate-900 dark:bg-slate-900/90 border border-transparent dark:border-slate-800 p-5 rounded-2xl text-white shadow-sm hover:shadow-md transition-all space-y-2">
            <div class="flex items-center justify-between text-slate-400 text-xs font-extrabold uppercase tracking-wider">
                <span>Struktur Kampus</span>
                <span>🏛️</span>
            </div>
            <p class="text-2xl font-black text-white">{{ $totalDepartments }} Jurusan</p>
            <p class="text-[11px] text-slate-400 font-medium pt-1 border-t border-slate-800">{{ $totalStudyPrograms }} Prodi • {{ $totalClasses }} Kelas</p>
        </div>
    </div>

    <!-- Charts & System Status Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Chart: Komposisi Role Pengguna (1 Column) -->
        <div class="lg:col-span-1 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm p-5 sm:p-6 space-y-4 flex flex-col justify-between">
            <div class="border-b border-slate-100 dark:border-slate-800 pb-4">
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                    <span>📊</span> Distribusi Role Pengguna
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium mt-0.5">Proporsi akun Admin, Pelatih (Senpai), dan Murid (Kohai)</p>
            </div>

            <div class="h-56 sm:h-60 w-full flex items-center justify-center my-auto">
                <canvas id="roleDistributionChart"></canvas>
            </div>

            <div class="pt-3 border-t border-slate-100 dark:border-slate-800 grid grid-cols-3 gap-1 text-[11px] font-bold text-center">
                <div class="p-2 bg-red-50 dark:bg-red-950/40 rounded-xl border border-red-200/60 dark:border-red-800/50">
                    <span class="text-red-700 dark:text-red-300 block text-[10px] uppercase">Admin</span>
                    <span class="text-slate-900 dark:text-white font-black text-sm">{{ $totalAdmin }}</span>
                </div>
                <div class="p-2 bg-blue-50 dark:bg-blue-950/40 rounded-xl border border-blue-200/60 dark:border-blue-800/50">
                    <span class="text-brand-primary dark:text-sky-300 block text-[10px] uppercase">Senpai</span>
                    <span class="text-slate-900 dark:text-white font-black text-sm">{{ $totalSenpai }}</span>
                </div>
                <div class="p-2 bg-cyan-50 dark:bg-cyan-950/40 rounded-xl border border-cyan-200/60 dark:border-cyan-800/50">
                    <span class="text-cyan-800 dark:text-cyan-300 block text-[10px] uppercase">Kohai</span>
                    <span class="text-slate-900 dark:text-white font-black text-sm">{{ $totalKohai }}</span>
                </div>
            </div>
        </div>

        <!-- Activity Overview & Live Sesi (2 Columns) -->
        <div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm p-5 sm:p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                        <span>⚡</span> Status Aktivitas Dojo Terkini
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 font-medium">Monitoring sesi absensi aktif & evaluasi pertarungan WKF terbaru</p>
                </div>
                <span class="px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs font-black">
                    Live Monitor
                </span>
            </div>

            <!-- Active Session Status Alert -->
            @if($activeSession)
                <div class="p-4 rounded-2xl bg-gradient-to-r from-emerald-500/10 via-emerald-50 to-white dark:from-emerald-950/30 dark:via-slate-800/50 dark:to-slate-800/30 border border-emerald-300 dark:border-emerald-800 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <span class="w-3 h-3 rounded-full bg-emerald-500 animate-ping"></span>
                        <div>
                            <span class="text-[10px] font-black uppercase text-emerald-800 dark:text-emerald-300 bg-emerald-100 dark:bg-emerald-900/60 px-2 py-0.5 rounded-full">Sesi Absensi Aktif</span>
                            <h4 class="text-sm font-black text-slate-900 dark:text-white mt-0.5">{{ $activeSession->title }}</h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Pelatih: <strong class="text-slate-800 dark:text-slate-200">{{ $activeSession->senpai->name }}</strong> • Kode Token: <strong class="font-mono text-emerald-700 dark:text-emerald-400 font-bold">{{ $activeSession->qr_token }}</strong></p>
                        </div>
                    </div>
                    <span class="px-3 py-1 bg-emerald-600 text-white rounded-xl text-xs font-extrabold shrink-0 shadow-xs">
                        {{ $activeSession->attendances->count() }} Kohai Hadir
                    </span>
                </div>
            @else
                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700/80 flex items-center gap-3 text-xs text-slate-500 dark:text-slate-400 font-medium">
                    <span>ℹ️</span> Tidak ada sesi absensi latihan yang sedang aktif saat ini.
                </div>
            @endif

            <!-- 5 Recent Kumite Matches in System -->
            <div class="space-y-2.5 pt-2">
                <h4 class="text-xs font-black uppercase tracking-wider text-slate-400 dark:text-slate-500">Evaluasi Kumite WKF Terbaru di Sistem</h4>
                <div class="space-y-2">
                    @forelse($recentKumiteReports as $r)
                        <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/70 dark:border-slate-700/60 hover:border-slate-300 dark:hover:border-slate-600 transition flex items-center justify-between text-xs gap-3">
                            <div class="flex items-center gap-2 min-w-0">
                                <span class="text-[10px] text-slate-400 dark:text-slate-500 font-mono shrink-0">{{ $r->match_date->format('d/m') }}</span>
                                <span class="font-bold text-red-600 dark:text-red-400 truncate">{{ $r->akaKohai->name ?? 'N/A' }}</span>
                                <span class="font-black text-slate-900 dark:text-white px-2 py-0.5 bg-white dark:bg-slate-900 rounded border border-slate-200 dark:border-slate-700 shrink-0">
                                    {{ $r->aka_total_score }} - {{ $r->ao_total_score }}
                                </span>
                                <span class="font-bold text-brand-primary dark:text-sky-400 truncate">{{ $r->aoKohai->name ?? 'N/A' }}</span>
                            </div>

                            <div class="flex items-center gap-2 shrink-0">
                                @if($r->winner)
                                    <span class="px-2 py-0.5 text-[10px] font-black rounded-md bg-emerald-50 dark:bg-emerald-950/50 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/60">
                                        🏆 {{ $r->winner->name }}
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400">
                                        Seri
                                    </span>
                                @endif
                                <span class="text-[10px] text-slate-400 dark:text-slate-500 hidden sm:inline">by {{ $r->senpai->name ?? 'Senpai' }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 dark:text-slate-500 py-3 text-center">Belum ada evaluasi tanding kumite yang dicatat.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Section: Latest Users Table & Quick Management Navigation -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Latest Users Table (2 Columns) -->
        <div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm p-5 sm:p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                        <span>👥</span> Pengguna Baru Terdaftar
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 font-medium">Daftar pengguna terbaru yang terdaftar di sistem Karate Polindra</p>
                </div>
                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-1 text-xs font-extrabold text-brand-primary dark:text-brand-secondary hover:underline transition">
                    <span>Kelola Semua ({{ $totalUsers }})</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="overflow-x-auto min-w-0">
                <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300 min-w-full">
                    <thead class="bg-slate-50 dark:bg-slate-800/80 text-slate-700 dark:text-slate-300 text-[11px] uppercase font-bold tracking-wider border-b border-slate-200/80 dark:border-slate-700/80 whitespace-nowrap">
                        <tr>
                            <th class="py-3 px-3.5">Nama Pengguna</th>
                            <th class="py-3 px-3.5">Email</th>
                            <th class="py-3 px-3.5">Role</th>
                            <th class="py-3 px-3.5 text-center">Tanggal Daftar</th>
                            <th class="py-3 px-3.5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 whitespace-nowrap font-medium text-xs">
                        @forelse($recentUsers as $u)
                            @php
                                $roleName = $u->role->nama ?? 'Tanpa Role';
                                $badgeStyle = match(strtolower($roleName)) {
                                    'admin' => 'bg-red-50 dark:bg-red-950/40 text-red-700 dark:text-red-300 border-red-200 dark:border-red-800/60',
                                    'senpai' => 'bg-blue-50 dark:bg-blue-950/40 text-brand-primary dark:text-sky-300 border-blue-200 dark:border-blue-800/60',
                                    'kohai' => 'bg-cyan-50 dark:bg-cyan-950/40 text-cyan-800 dark:text-cyan-300 border-cyan-200 dark:border-cyan-800/60',
                                    default => 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border-slate-200 dark:border-slate-700'
                                };
                            @endphp
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition-colors">
                                <td class="py-3 px-3.5 font-bold text-slate-900 dark:text-white flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-xl bg-slate-900 dark:bg-slate-800 text-white flex items-center justify-center text-xs font-black uppercase shrink-0">
                                        {{ $u->initials }}
                                    </div>
                                    <span class="truncate max-w-[140px]">{{ $u->name }}</span>
                                </td>

                                <td class="py-3 px-3.5 text-slate-500 dark:text-slate-400 font-mono text-[11px]">{{ $u->email }}</td>

                                <td class="py-3 px-3.5">
                                    <span class="px-2.5 py-0.5 text-[10px] font-black rounded-full border {{ $badgeStyle }}">
                                        {{ $roleName }}
                                    </span>
                                </td>

                                <td class="py-3 px-3.5 text-center text-slate-400 dark:text-slate-500 text-[11px]">
                                    {{ $u->created_at ? $u->created_at->format('d M Y') : '-' }}
                                </td>

                                <td class="py-3 px-3.5 text-center">
                                    <a href="{{ route('admin.users.edit', $u->id) }}" class="px-2.5 py-1 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold rounded-lg transition text-[11px]">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-slate-400 dark:text-slate-500 text-xs">Belum ada pengguna terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Navigation Cards (1 Column) -->
        <div class="lg:col-span-1 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm p-5 sm:p-6 space-y-4 flex flex-col justify-between">
            <div class="space-y-4">
                <div class="border-b border-slate-100 dark:border-slate-800 pb-4">
                    <h3 class="text-base font-extrabold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                        <span>⚙️</span> Navigasi Kontrol Cepat
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium mt-0.5">Akses modul pengelolaan master data</p>
                </div>

                <div class="space-y-2.5">
                    <a href="{{ route('admin.users.index') }}" class="p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-800/60 hover:bg-blue-50 dark:hover:bg-slate-800 border border-slate-200/80 dark:border-slate-700/80 hover:border-brand-primary/40 dark:hover:border-brand-primary/60 transition flex items-center justify-between group">
                        <div class="flex items-center gap-3">
                            <span class="p-2 rounded-xl bg-white dark:bg-slate-900 text-brand-primary border border-slate-200 dark:border-slate-700 shadow-2xs">👥</span>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-brand-primary dark:group-hover:text-brand-secondary transition">Kelola User & Role</h4>
                                <p class="text-[10px] text-slate-500 dark:text-slate-400">{{ $totalUsers }} Total Pengguna</p>
                            </div>
                        </div>
                        <span class="text-slate-400 group-hover:text-brand-primary dark:group-hover:text-brand-secondary transition">&rarr;</span>
                    </a>

                    <a href="{{ route('admin.belts.index') }}" class="p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-800/60 hover:bg-blue-50 dark:hover:bg-slate-800 border border-slate-200/80 dark:border-slate-700/80 hover:border-brand-primary/40 dark:hover:border-brand-primary/60 transition flex items-center justify-between group">
                        <div class="flex items-center gap-3">
                            <span class="p-2 rounded-xl bg-white dark:bg-slate-900 text-brand-primary border border-slate-200 dark:border-slate-700 shadow-2xs">🥋</span>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-brand-primary dark:group-hover:text-brand-secondary transition">Sabuk & Tingkatan</h4>
                                <p class="text-[10px] text-slate-500 dark:text-slate-400">{{ $totalBelts }} Sabuk • {{ $totalRanks }} Kyu/Dan</p>
                            </div>
                        </div>
                        <span class="text-slate-400 group-hover:text-brand-primary dark:group-hover:text-brand-secondary transition">&rarr;</span>
                    </a>

                    <a href="{{ route('admin.departments.index') }}" class="p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-800/60 hover:bg-blue-50 dark:hover:bg-slate-800 border border-slate-200/80 dark:border-slate-700/80 hover:border-brand-primary/40 dark:hover:border-brand-primary/60 transition flex items-center justify-between group">
                        <div class="flex items-center gap-3">
                            <span class="p-2 rounded-xl bg-white dark:bg-slate-900 text-brand-primary border border-slate-200 dark:border-slate-700 shadow-2xs">🏛️</span>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-brand-primary dark:group-hover:text-brand-secondary transition">Jurusan, Prodi & Kelas</h4>
                                <p class="text-[10px] text-slate-500 dark:text-slate-400">{{ $totalDepartments }} Jurusan Polindra</p>
                            </div>
                        </div>
                        <span class="text-slate-400 group-hover:text-brand-primary dark:group-hover:text-brand-secondary transition">&rarr;</span>
                    </a>

                    <a href="{{ route('admin.profile.index') }}" class="p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-800/60 hover:bg-blue-50 dark:hover:bg-slate-800 border border-slate-200/80 dark:border-slate-700/80 hover:border-brand-primary/40 dark:hover:border-brand-primary/60 transition flex items-center justify-between group">
                        <div class="flex items-center gap-3">
                            <span class="p-2 rounded-xl bg-white dark:bg-slate-900 text-red-600 dark:text-red-400 border border-slate-200 dark:border-slate-700 shadow-2xs">🔒</span>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-red-600 dark:group-hover:text-red-400 transition">Profil Administrator</h4>
                                <p class="text-[10px] text-slate-500 dark:text-slate-400">Ubah Sandi & Pengaturan Akun</p>
                            </div>
                        </div>
                        <span class="text-slate-400 group-hover:text-red-600 dark:group-hover:text-red-400 transition">&rarr;</span>
                    </a>
                </div>
            </div>

            <div class="pt-3 border-t border-slate-100 dark:border-slate-800 text-[11px] text-slate-400 dark:text-slate-500 flex items-center justify-between font-mono">
                <span>Versi Sistem</span>
                <span class="font-bold text-slate-600 dark:text-slate-400">v1.0.0 Production</span>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN and Initialization -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let roleChartInstance = null;

    function initRoleChart() {
        const roleCanvas = document.getElementById('roleDistributionChart');
        if (!roleCanvas) return;

        const isDark = document.documentElement.classList.contains('dark');
        const borderColor = isDark ? '#0f172a' : '#ffffff';
        const roleData = @json($roleChartData);

        if (roleChartInstance) {
            roleChartInstance.destroy();
        }

        const ctxRole = roleCanvas.getContext('2d');
        roleChartInstance = new Chart(ctxRole, {
            type: 'doughnut',
            data: {
                labels: roleData.labels,
                datasets: [{
                    data: roleData.data,
                    backgroundColor: roleData.colors,
                    borderWidth: 2,
                    borderColor: borderColor,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        padding: 10,
                        backgroundColor: isDark ? '#1e293b' : '#0f172a',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: isDark ? '#334155' : 'transparent',
                        borderWidth: isDark ? 1 : 0,
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const value = context.raw || 0;
                                const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                return ` ${context.label}: ${value} Akun (${percentage}%)`;
                            }
                        }
                    }
                },
                cutout: '68%'
            }
        });
    }

    document.addEventListener('DOMContentLoaded', initRoleChart);
    window.addEventListener('karateThemeChanged', initRoleChart);
</script>
@endsection
