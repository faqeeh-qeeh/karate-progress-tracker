@extends('layouts.senpai')

@section('title', 'Dashboard Senpai')

@section('content')
<div class="space-y-6">
    <!-- Header Hero Banner Pelatih -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-brand-primary via-slate-900 to-slate-900 dark:from-blue-950 dark:via-slate-900 dark:to-slate-950 p-6 sm:p-8 text-white shadow-xl border border-slate-800/60">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2.5 max-w-2xl">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand-secondary/25 border border-brand-secondary/40 text-[11px] font-black text-brand-secondary">
                        <span>🥋</span> PANEL PELATIH SENPAI
                    </span>
                    @if($senpai->senpaiProfile?->rank)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 backdrop-blur-xs border border-white/20 text-[11px] font-bold text-slate-200">
                            <span>⭐</span> {{ $senpai->senpaiProfile->rank->name }} ({{ $senpai->senpaiProfile->rank->belt->name ?? 'Sabuk Hitam' }})
                        </span>
                    @endif
                </div>

                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight leading-tight text-white">
                    Osu, {{ $senpai->name }}! 🙏
                </h1>
                <p class="text-slate-300 text-xs sm:text-sm font-medium leading-relaxed">
                    Pantau perkembangan fisik & teknik murid binaan dojo, kelola sesi absensi QR presensi, serta lakukan evaluasi tanding Raport Kumite standar WKF.
                </p>
            </div>

            <!-- Quick Action Shortcut Buttons -->
            <div class="flex flex-wrap sm:flex-nowrap items-center gap-3 shrink-0">
                <a href="{{ route('senpai.kumite.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 sm:px-5 py-3 rounded-2xl bg-brand-secondary hover:bg-sky-400 text-slate-950 font-black text-xs sm:text-sm shadow-lg shadow-brand-secondary/20 hover:scale-[1.02] active:scale-[0.98] transition-all">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    <span>Input Raport Kumite</span>
                </a>

                <a href="{{ route('senpai.attendance.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 sm:px-5 py-3 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold text-xs sm:text-sm backdrop-blur-md hover:scale-[1.02] active:scale-[0.98] transition-all">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                    <span>Absensi QR Dojo</span>
                </a>
            </div>
        </div>

        <div class="absolute -right-8 -bottom-8 w-64 h-64 bg-brand-secondary/15 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    @if($activeSession)
        <!-- Live Active Session Announcement Widget -->
        <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-slate-900 rounded-3xl p-5 sm:p-6 border border-emerald-500/30 text-white shadow-lg flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-start sm:items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500/20 border border-emerald-500/40 text-emerald-400 flex items-center justify-center text-2xl shrink-0">
                    <span class="animate-pulse">🟢</span>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 text-[10px] font-black tracking-wider uppercase">
                            Sesi Latihan Aktif
                        </span>
                        <span class="text-xs text-slate-400 font-mono">Token: <strong class="text-brand-secondary font-black">{{ $activeSession->qr_token }}</strong></span>
                    </div>
                    <h3 class="text-base sm:text-lg font-black text-white mt-1">{{ $activeSession->title }}</h3>
                    <p class="text-xs text-slate-300 mt-0.5">
                        Tanggal: <span class="font-bold text-white">{{ $activeSession->date->format('d M Y') }}</span> • 
                        <strong class="text-emerald-400 font-black">{{ $activeSession->attendances->count() }} Kohai</strong> telah terdata hadir
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3 shrink-0 pt-2 md:pt-0">
                <a href="{{ route('senpai.attendance.index') }}" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-extrabold rounded-xl transition-all shadow-md flex items-center gap-2">
                    <span>Pantau QR & Presensi</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    @endif

    <!-- 4 Quick Stats KPI Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        <!-- Metric 1: Kohai Binaan -->
        <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs hover:shadow-md hover:border-brand-primary/40 dark:hover:border-brand-primary/50 transition-all duration-200 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-extrabold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Kohai Terdaftar</p>
                    <p class="text-2xl sm:text-3xl font-black text-brand-primary dark:text-brand-secondary mt-1">{{ $totalKohai }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-brand-primary/10 dark:bg-brand-primary/20 text-brand-primary dark:text-brand-secondary flex items-center justify-center text-xl font-bold group-hover:scale-110 transition-transform">
                    🥋
                </div>
            </div>
            <div class="flex items-center justify-between text-xs text-slate-500 dark:text-slate-400 font-medium mt-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                <span>Murid Aktif Dojo</span>
                <a href="{{ route('senpai.kohai.index') }}" class="text-brand-primary dark:text-brand-secondary font-bold hover:underline">Kelola &rarr;</a>
            </div>
        </div>

        <!-- Metric 2: Raport Kumite -->
        <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs hover:shadow-md hover:border-brand-secondary/40 dark:hover:border-brand-secondary/50 transition-all duration-200 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-extrabold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Raport Kumite</p>
                    <p class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white mt-1">{{ $totalKumiteReports }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-brand-secondary/10 dark:bg-brand-secondary/20 text-brand-secondary flex items-center justify-center text-xl font-bold group-hover:scale-110 transition-transform">
                    🏆
                </div>
            </div>
            <div class="flex items-center justify-between text-xs text-slate-500 dark:text-slate-400 font-medium mt-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                <span>Laga WKF Dievaluasi</span>
                <a href="{{ route('senpai.kumite.index') }}" class="text-brand-secondary font-bold hover:underline">Riwayat &rarr;</a>
            </div>
        </div>

        <!-- Metric 3: Sesi Absensi -->
        <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs hover:shadow-md hover:border-amber-400 dark:hover:border-amber-500/50 transition-all duration-200 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-extrabold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Sesi Absensi</p>
                    <p class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white mt-1">{{ $totalSessions }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-950/50 text-amber-600 dark:text-amber-400 flex items-center justify-center text-xl font-bold group-hover:scale-110 transition-transform">
                    📅
                </div>
            </div>
            <div class="flex items-center justify-between text-xs text-slate-500 dark:text-slate-400 font-medium mt-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                <span>Total Sesi Dibuka</span>
                <span class="font-bold text-slate-700 dark:text-slate-300">{{ $activeSession ? '1 Sesi Aktif' : 'Semua Ditutup' }}</span>
            </div>
        </div>

        <!-- Metric 4: Total Presensi Hadir -->
        <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs hover:shadow-md hover:border-emerald-400 dark:hover:border-emerald-500/50 transition-all duration-200 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-extrabold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Log Kehadiran</p>
                    <p class="text-2xl sm:text-3xl font-black text-emerald-600 dark:text-emerald-400 mt-1">{{ $totalAttendances }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl font-bold group-hover:scale-110 transition-transform">
                    👥
                </div>
            </div>
            <div class="flex items-center justify-between text-xs text-slate-500 dark:text-slate-400 font-medium mt-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                <span>Scan Presensi Masuk</span>
                <span class="text-emerald-700 dark:text-emerald-400 font-extrabold">Terverifikasi</span>
            </div>
        </div>
    </div>

    <!-- Charts Section: Tren Performa & Distribusi Sabuk -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Chart 1: Kumite Performance Dynamics -->
        <div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm p-5 sm:p-6 space-y-4 transition-colors duration-200">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 dark:border-slate-800 pb-4">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                        <span>📈</span> Tren Rata-rata Evaluasi Kumite Murid
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium mt-0.5">Analisis intensitas serangan (Attack) & persentase akurasi poin pada laga-laga terbaru</p>
                </div>
                <span class="px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-950/60 text-brand-primary dark:text-blue-300 border border-blue-200/60 dark:border-blue-800/80 text-xs font-black self-start sm:self-auto">
                    WKF Analytics
                </span>
            </div>

            @if(count($chartMatchLabels) > 0)
                <div class="h-64 sm:h-72 w-full">
                    <canvas id="kumiteTrendChart"></canvas>
                </div>
            @else
                <div class="h-64 flex flex-col items-center justify-center text-center p-6 text-slate-400 dark:text-slate-500">
                    <p class="text-sm font-medium">Belum ada data evaluasi Kumite untuk ditampilkan pada grafik.</p>
                </div>
            @endif
        </div>

        <!-- Chart 2: Belt Rank Composition -->
        <div class="lg:col-span-1 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm p-5 sm:p-6 space-y-4 flex flex-col justify-between transition-colors duration-200">
            <div class="border-b border-slate-100 dark:border-slate-800 pb-4">
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                    <span>🥋</span> Komposisi Sabuk Dojo
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium mt-0.5">Distribusi tingkatan sabuk seluruh murid Kohai</p>
            </div>

            @if(count($beltDistribution) > 0)
                <div class="h-56 sm:h-60 w-full flex items-center justify-center my-auto">
                    <canvas id="beltDonutChart"></canvas>
                </div>
            @else
                <div class="h-56 flex flex-col items-center justify-center text-center p-6 text-slate-400 dark:text-slate-500">
                    <p class="text-sm font-medium">Belum ada data profil sabuk murid terdata.</p>
                </div>
            @endif

            <div class="pt-3 border-t border-slate-100 dark:border-slate-800 grid grid-cols-2 gap-2 text-[11px] font-bold">
                @foreach($beltDistribution as $b)
                    <div class="flex items-center gap-1.5 truncate">
                        <span class="w-2.5 h-2.5 rounded-full shrink-0" style="background-color: {{ $b['color'] }}"></span>
                        <span class="text-slate-600 dark:text-slate-400 truncate">{{ $b['name'] }}:</span>
                        <span class="text-slate-900 dark:text-white font-extrabold">{{ $b['count'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Dual Layout: Recent Kumite Reports & Schedule Agenda -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Kumite Reports Table (2 Columns) -->
        <div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm p-5 sm:p-6 space-y-4 transition-colors duration-200">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                        <span>🏆</span> Evaluasi Raport Kumite Terbaru
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 font-medium">Hasil laga WKF yang baru saja dinilai oleh Senpai</p>
                </div>
                <a href="{{ route('senpai.kumite.index') }}" class="inline-flex items-center gap-1 text-xs font-extrabold text-brand-primary dark:text-brand-secondary hover:underline transition">
                    <span>Lihat Semua</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <!-- Table List -->
            <div class="overflow-x-auto min-w-0">
                <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300 min-w-full">
                    <thead class="bg-slate-50 dark:bg-slate-950/60 text-slate-700 dark:text-slate-300 text-[11px] uppercase font-bold tracking-wider border-b border-slate-200/80 dark:border-slate-800 whitespace-nowrap">
                        <tr>
                            <th class="py-3 px-3.5">Tanggal</th>
                            <th class="py-3 px-3.5">Sudut AKA (Merah)</th>
                            <th class="py-3 px-3.5 text-center">Skor WKF</th>
                            <th class="py-3 px-3.5">Sudut AO (Biru)</th>
                            <th class="py-3 px-3.5 text-center">Pemenang</th>
                            <th class="py-3 px-3.5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 whitespace-nowrap font-medium text-xs">
                        @forelse($recentKumiteReports as $r)
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors">
                                <td class="py-3.5 px-3.5">
                                    <span class="font-bold text-slate-900 dark:text-white block">{{ $r->match_date->format('d M Y') }}</span>
                                    <span class="text-[10px] text-slate-400 dark:text-slate-500 font-mono">{{ $r->match_time }} WIB</span>
                                </td>
                                <td class="py-3.5 px-3.5">
                                    <div class="flex items-center gap-1.5 font-bold text-red-600 dark:text-red-400">
                                        <span class="w-2 h-2 rounded-full bg-red-600 dark:bg-red-500 shrink-0"></span>
                                        <span class="truncate max-w-[120px]">{{ $r->akaKohai->name ?? 'N/A' }}</span>
                                        @if($r->senshu_corner === 'aka')
                                             <span class="px-1.5 py-0.2 text-[8px] font-black bg-red-100 dark:bg-red-950/60 text-red-700 dark:text-red-300 rounded border border-red-200 dark:border-red-900">SENSHU</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3.5 px-3.5 text-center font-black">
                                    <span class="px-2 py-0.5 rounded-md bg-red-50 dark:bg-red-950/50 text-red-600 dark:text-red-400 border border-red-200/80 dark:border-red-900/60">{{ $r->aka_total_score }}</span>
                                    <span class="text-slate-300 dark:text-slate-600 mx-1">:</span>
                                    <span class="px-2 py-0.5 rounded-md bg-blue-50 dark:bg-blue-950/50 text-brand-primary dark:text-brand-secondary border border-blue-200/80 dark:border-blue-900/60">{{ $r->ao_total_score }}</span>
                                </td>
                                <td class="py-3.5 px-3.5">
                                    <div class="flex items-center gap-1.5 font-bold text-brand-primary dark:text-brand-secondary">
                                        <span class="w-2 h-2 rounded-full bg-brand-primary dark:bg-brand-secondary shrink-0"></span>
                                        <span class="truncate max-w-[120px]">{{ $r->aoKohai->name ?? 'N/A' }}</span>
                                        @if($r->senshu_corner === 'ao')
                                             <span class="px-1.5 py-0.2 text-[8px] font-black bg-blue-100 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 rounded border border-blue-200 dark:border-blue-900">SENSHU</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3.5 px-3.5 text-center">
                                    @if($r->winner)
                                        <span class="px-2.5 py-1 text-[11px] font-extrabold rounded-full bg-emerald-50 dark:bg-emerald-950/50 text-emerald-800 dark:text-emerald-300 border border-emerald-200/80 dark:border-emerald-900/60">
                                            🏆 {{ $r->winner->name }}
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 text-[11px] font-bold rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                                            Draw / Hantei
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-3.5 text-center">
                                    <a href="{{ route('senpai.kumite.show', $r->id) }}" class="px-2.5 py-1 bg-brand-primary hover:bg-brand-primary/90 text-white font-bold rounded-lg transition text-[11px] shadow-xs">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400 dark:text-slate-500 text-xs font-medium">
                                    Belum ada data evaluasi Kumite. Klik "Input Raport Kumite" untuk memulai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Schedule & Curriculum Section (1 Column) -->
        <div class="lg:col-span-1 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm p-5 sm:p-6 space-y-4 transition-colors duration-200">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4">
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white flex items-center gap-2 tracking-tight">
                    <span>📅</span> Jadwal Mengajar Dojo
                </h3>
                <span class="text-[11px] bg-blue-50 dark:bg-blue-950/60 text-brand-primary dark:text-blue-300 px-3 py-1 rounded-full font-black border border-blue-200/60 dark:border-blue-800/80">
                    Mingguan
                </span>
            </div>

            <div class="space-y-3">
                @foreach($schedules as $sched)
                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950/50 border border-slate-200/80 dark:border-slate-800 hover:border-brand-primary/40 dark:hover:border-brand-primary/50 transition-all space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-black text-brand-primary dark:text-brand-secondary uppercase tracking-wider">{{ $sched['hari'] }}</span>
                            <span class="text-[11px] text-slate-500 dark:text-slate-400 font-mono font-bold bg-white dark:bg-slate-900 px-2 py-0.5 rounded-md border border-slate-200 dark:border-slate-700">{{ $sched['jam'] }}</span>
                        </div>
                        <div>
                            <h4 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white leading-snug">{{ $sched['materi'] }}</h4>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 font-medium flex items-center gap-1">
                                <span>🎯</span> {{ $sched['fokus'] }}
                            </p>
                        </div>
                        <div class="pt-2 border-t border-slate-200/60 dark:border-slate-800/80 flex items-center justify-between text-[11px] text-slate-400 dark:text-slate-500 font-medium">
                            <span class="flex items-center gap-1">📍 {{ $sched['lokasi'] }}</span>
                            <span class="text-emerald-600 dark:text-emerald-400 font-bold">Wajib</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Kohai Roster Section: Murid Terdaftar & Status Sabuk Riil -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm p-5 sm:p-6 space-y-4 transition-colors duration-200">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 dark:border-slate-800 pb-4">
            <div>
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                    <span>🥋</span> Roster Kohai Binaan Terkini
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 font-medium">Monitoring data tingkatan sabuk aktual, riwayat pertarungan, dan presensi latihan</p>
            </div>
            <a href="{{ route('senpai.kohai.index') }}" class="inline-flex items-center gap-1 text-xs font-extrabold text-brand-primary dark:text-brand-secondary hover:underline transition">
                <span>Kelola Seluruh Murid ({{ $totalKohai }})</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="overflow-x-auto min-w-0">
            <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300 min-w-full">
                <thead class="bg-slate-50 dark:bg-slate-950/60 text-slate-700 dark:text-slate-300 text-[11px] uppercase font-bold tracking-wider border-b border-slate-200/80 dark:border-slate-800 whitespace-nowrap">
                    <tr>
                        <th class="py-3.5 px-4">Nama Kohai</th>
                        <th class="py-3.5 px-4">NIM / Asal</th>
                        <th class="py-3.5 px-4">Tingkatan Sabuk</th>
                        <th class="py-3.5 px-4 text-center">Duel Kumite</th>
                        <th class="py-3.5 px-4 text-center">Presensi Hadir</th>
                        <th class="py-3.5 px-4 text-center">Aksi Pelatih</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 whitespace-nowrap font-medium text-xs">
                    @forelse($kohaiList as $k)
                        @php
                            $totalMatches = ($k->matches_as_aka_count ?? 0) + ($k->matches_as_ao_count ?? 0);
                            $rankName = $k->kohaiProfile?->rank?->name ?? 'KYU 10 (Putih)';
                            $beltName = $k->kohaiProfile?->rank?->belt?->name ?? 'Putih';
                            $beltColor = $k->kohaiProfile?->rank?->belt?->color_code ?? '#94a3b8';
                        @endphp
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="py-3.5 px-4 font-bold text-slate-900 dark:text-white">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl bg-brand-primary text-white flex items-center justify-center text-xs font-black uppercase shrink-0 shadow-xs">
                                        {{ $k->initials }}
                                    </div>
                                    <div>
                                        <a href="{{ route('senpai.kohai.show', $k->id) }}" class="hover:text-brand-primary dark:hover:text-brand-secondary transition block font-extrabold text-slate-900 dark:text-white">
                                            {{ $k->name }}
                                        </a>
                                        <span class="text-[10px] text-slate-400 dark:text-slate-500 font-mono">{{ $k->email }}</span>
                                    </div>
                                </div>
                            </td>

                            <td class="py-3.5 px-4 text-slate-600 dark:text-slate-300">
                                @if($k->kohaiProfile?->isPolindra())
                                    <span class="font-bold text-slate-800 dark:text-slate-200 block">{{ $k->kohaiProfile->nim ?? '-' }}</span>
                                    <span class="text-[10px] text-slate-400 dark:text-slate-500 truncate">{{ $k->kohaiProfile->studyProgram->name ?? 'Polindra' }}</span>
                                @else
                                    <span class="font-bold text-slate-800 dark:text-slate-200 block">{{ $k->kohaiProfile->institution ?? 'Non-Polindra' }}</span>
                                    <span class="text-[10px] text-slate-400 dark:text-slate-500">Umum / Luar</span>
                                @endif
                            </td>

                            <td class="py-3.5 px-4">
                                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 text-[11px] font-extrabold text-slate-800 dark:text-slate-200">
                                    <span class="w-2.5 h-2.5 rounded-full shrink-0 shadow-xs" style="background-color: {{ $beltColor }}"></span>
                                    <span>{{ $rankName }}</span>
                                </div>
                            </td>

                            <td class="py-3.5 px-4 text-center font-bold text-slate-800 dark:text-slate-200">
                                <span class="px-2.5 py-1 rounded-lg bg-blue-50 dark:bg-blue-950/50 text-brand-primary dark:text-brand-secondary border border-blue-200/60 dark:border-blue-900/60 font-black">
                                    {{ $totalMatches }} Laga
                                </span>
                            </td>

                            <td class="py-3.5 px-4 text-center">
                                <span class="px-2.5 py-1 rounded-lg bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-400 border border-emerald-200/60 dark:border-emerald-900/60 font-black">
                                    {{ $k->attendance_count ?? 0 }} Sesi
                                </span>
                            </td>

                            <td class="py-3.5 px-4 text-center">
                                <a href="{{ route('senpai.kohai.show', $k->id) }}" class="px-3 py-1.5 bg-brand-primary hover:bg-brand-primary/90 text-white font-bold rounded-xl transition text-xs shadow-xs inline-flex items-center gap-1.5">
                                    <span>Analisis Teknik</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 dark:text-slate-500 text-xs font-medium">
                                Belum ada Kohai binaan terdaftar di dojo.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Chart.js CDN and Initialization -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isDarkMode = () => document.documentElement.classList.contains('dark');
        let kumiteChartInstance = null;
        let beltChartInstance = null;

        function getChartColors() {
            const dark = isDarkMode();
            return {
                text: dark ? '#94a3b8' : '#64748b',
                grid: dark ? 'rgba(51, 65, 85, 0.4)' : 'rgba(226, 232, 240, 0.6)',
                border: dark ? '#0f172a' : '#ffffff',
                legend: dark ? '#e2e8f0' : '#1e293b'
            };
        }

        // 1. Tren Evaluasi Kumite Chart
        const trendCanvas = document.getElementById('kumiteTrendChart');
        if (trendCanvas) {
            const ctxTrend = trendCanvas.getContext('2d');
            const matchLabels = @json($chartMatchLabels);
            const attackData = @json($chartAttack);
            const accuracyData = @json($chartAccuracy);
            const colors = getChartColors();

            kumiteChartInstance = new Chart(ctxTrend, {
                type: 'line',
                data: {
                    labels: matchLabels,
                    datasets: [
                        {
                            label: 'Rata-rata Nilai Attack (Serangan)',
                            data: attackData,
                            borderColor: '#146C94',
                            backgroundColor: 'rgba(20, 108, 148, 0.15)',
                            borderWidth: 2.5,
                            fill: true,
                            tension: 0.35,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            pointBackgroundColor: '#146C94',
                        },
                        {
                            label: 'Rata-rata Akurasi Poin (%)',
                            data: accuracyData,
                            borderColor: '#19A7CE',
                            backgroundColor: 'rgba(25, 167, 206, 0.15)',
                            borderWidth: 2.5,
                            fill: false,
                            tension: 0.35,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            pointBackgroundColor: '#19A7CE',
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                color: colors.legend,
                                font: {
                                    family: 'Plus Jakarta Sans',
                                    size: 11,
                                    weight: 'bold'
                                },
                                usePointStyle: true,
                                boxWidth: 8
                            }
                        },
                        tooltip: {
                            padding: 10,
                            titleFont: { family: 'Plus Jakarta Sans', size: 12, weight: 'bold' },
                            bodyFont: { family: 'Plus Jakarta Sans', size: 11 },
                            cornerRadius: 10
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: colors.grid },
                            ticks: { 
                                color: colors.text,
                                font: { family: 'Plus Jakarta Sans', size: 10 } 
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { 
                                color: colors.text,
                                font: { family: 'Plus Jakarta Sans', size: 10 } 
                            }
                        }
                    }
                }
            });
        }

        // 2. Komposisi Sabuk Donut Chart
        const donutCanvas = document.getElementById('beltDonutChart');
        if (donutCanvas) {
            const ctxDonut = donutCanvas.getContext('2d');
            const beltDist = @json($beltDistribution);
            const colors = getChartColors();

            const beltLabels = beltDist.map(item => item.name);
            const beltCounts = beltDist.map(item => item.count);
            const beltColors = beltDist.map(item => item.color);

            beltChartInstance = new Chart(ctxDonut, {
                type: 'doughnut',
                data: {
                    labels: beltLabels,
                    datasets: [{
                        data: beltCounts,
                        backgroundColor: beltColors,
                        borderWidth: 2,
                        borderColor: colors.border,
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
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const value = context.raw || 0;
                                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                    return ` ${context.label}: ${value} Kohai (${percentage}%)`;
                                }
                            }
                        }
                    },
                    cutout: '68%'
                }
            });
        }

        // Listen for Theme Change Event to dynamically update Chart colors
        window.addEventListener('karateThemeChanged', function() {
            const colors = getChartColors();
            if (kumiteChartInstance) {
                kumiteChartInstance.options.plugins.legend.labels.color = colors.legend;
                kumiteChartInstance.options.scales.y.grid.color = colors.grid;
                kumiteChartInstance.options.scales.y.ticks.color = colors.text;
                kumiteChartInstance.options.scales.x.ticks.color = colors.text;
                kumiteChartInstance.update();
            }
            if (beltChartInstance) {
                beltChartInstance.data.datasets[0].borderColor = colors.border;
                beltChartInstance.update();
            }
        });
    });
</script>
@endsection
