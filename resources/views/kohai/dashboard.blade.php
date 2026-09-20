@extends('layouts.kohai')

@section('title', 'Dashboard Kohai')

@section('content')
<div class="space-y-6">
    <!-- Header Hero Banner Kohai -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-brand-secondary via-sky-800 to-slate-900 p-6 sm:p-8 text-white shadow-xl">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2.5 max-w-2xl">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/25 text-[11px] font-black text-white">
                        <span>⚪</span> PANEL ANGGOTA KOHAI
                    </span>

                    @if($kohai->kohaiProfile?->rank)
                        @php
                            $beltColor = $kohai->kohaiProfile->rank->belt->color_code ?? '#ffffff';
                            $rankName = $kohai->kohaiProfile->rank->name;
                            $beltName = $kohai->kohaiProfile->rank->belt->name ?? 'Sabuk Putih';
                        @endphp
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-900/60 backdrop-blur-md border border-white/20 text-[11px] font-extrabold text-white">
                            <span class="w-2.5 h-2.5 rounded-full shrink-0 shadow-xs" style="background-color: {{ $beltColor }}"></span>
                            <span>{{ $rankName }} ({{ $beltName }})</span>
                        </span>
                    @endif

                    @if($kohai->kohaiProfile?->isPolindra())
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-blue-500/20 border border-blue-400/30 text-[11px] font-bold text-sky-200">
                            <span>🎓</span> {{ $kohai->kohaiProfile->nim ?? 'Polindra' }}
                        </span>
                    @endif
                </div>

                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight leading-tight">
                    Semangat Latihan, {{ $kohai->name }}! 🔥
                </h1>
                <p class="text-sky-100 text-xs sm:text-sm font-medium leading-relaxed">
                    Pantau perkembangan performa tanding Kumite WKF, tinjau log kehadiran presensi latihan dojo, dan evaluasi hasil latihan Anda bersama Senpai.
                </p>
            </div>

            <!-- Quick Action Buttons -->
            <div class="flex flex-wrap sm:flex-nowrap items-center gap-3 shrink-0">
                <a href="{{ route('kohai.attendance.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl bg-white text-slate-900 hover:bg-sky-50 font-black text-xs sm:text-sm shadow-lg hover:scale-[1.02] active:scale-[0.98] transition-all">
                    <svg class="w-4 h-4 shrink-0 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                    <span>Scan Absensi QR</span>
                </a>

                <a href="{{ route('kohai.kumite.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl bg-slate-900/60 hover:bg-slate-900/90 border border-white/20 text-white font-bold text-xs sm:text-sm backdrop-blur-md hover:scale-[1.02] active:scale-[0.98] transition-all">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    <span>Raport Kumite Saya</span>
                </a>
            </div>
        </div>

        <div class="absolute -right-8 -bottom-8 w-64 h-64 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- Active Dojo Session Status Widget -->
    @if($activeSession)
        @if(!$hasAttendedActive)
            <!-- Sesi Aktif & Belum Absen: Call to Action Alert -->
            <div class="bg-gradient-to-r from-amber-500/15 via-amber-50 to-white rounded-3xl p-5 sm:p-6 border-2 border-amber-300 text-slate-800 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-start sm:items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500 text-white flex items-center justify-center text-2xl shrink-0 shadow-md">
                        <span class="animate-bounce">📷</span>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-0.5 rounded-full bg-amber-200/80 text-amber-900 border border-amber-300 text-[10px] font-black uppercase tracking-wider">
                                Sesi Dojo Sedang Berjalan
                            </span>
                            <span class="text-xs text-slate-500 font-mono">Kode: <strong class="text-amber-900 font-black">{{ $activeSession->qr_token }}</strong></span>
                        </div>
                        <h3 class="text-base sm:text-lg font-black text-slate-900 mt-1">{{ $activeSession->title }}</h3>
                        <p class="text-xs text-slate-600 mt-0.5">
                            Dibuka oleh <strong class="text-slate-900">{{ $activeSession->senpai->name }}</strong> • Anda <span class="text-amber-700 font-extrabold underline">belum melakukan presensi</span> untuk sesi hari ini.
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3 shrink-0 pt-2 md:pt-0">
                    <a href="{{ route('kohai.attendance.index') }}" class="w-full sm:w-auto px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-black rounded-xl transition-all shadow-md flex items-center justify-center gap-2">
                        <span>Scan Presensi Sekarang</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            </div>
        @else
            <!-- Sesi Aktif & Sudah Absen: Success Confirmation -->
            <div class="bg-gradient-to-r from-emerald-500/15 via-emerald-50 to-white rounded-3xl p-5 sm:p-6 border border-emerald-300 text-slate-800 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-11 h-11 rounded-2xl bg-emerald-600 text-white flex items-center justify-center text-xl shrink-0 shadow-md">
                        ✓
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-300 text-[10px] font-black uppercase">
                                Presensi Berhasil
                            </span>
                        </div>
                        <h3 class="text-sm sm:text-base font-extrabold text-slate-900 mt-0.5">{{ $activeSession->title }}</h3>
                        <p class="text-xs text-emerald-800 font-medium mt-0.5">
                            Kehadiran Anda telah terverifikasi oleh Senpai {{ $activeSession->senpai->name }}. Osu! 🙏
                        </p>
                    </div>
                </div>

                <a href="{{ route('kohai.attendance.index') }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-900 hover:underline shrink-0">
                    Lihat Riwayat Presensi &rarr;
                </a>
            </div>
        @endif
    @endif

    <!-- 4 Key Performance Metrics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        <!-- Metric 1: Total Duel Kumite -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md hover:border-brand-primary/40 transition-all duration-200 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Total Duel Kumite</p>
                    <p class="text-2xl sm:text-3xl font-black text-brand-primary mt-1">{{ $totalMatches }} Laga</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-brand-primary/10 text-brand-primary flex items-center justify-center text-xl font-bold group-hover:scale-110 transition-transform">
                    🥋
                </div>
            </div>
            <div class="flex items-center justify-between text-xs text-slate-500 font-medium mt-3 pt-3 border-t border-slate-100">
                <span>Evaluasi Standar WKF</span>
                <a href="{{ route('kohai.kumite.index') }}" class="text-brand-primary font-bold hover:underline">Detail &rarr;</a>
            </div>
        </div>

        <!-- Metric 2: Tingkat Kemenangan (Win Rate) -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md hover:border-emerald-400 transition-all duration-200 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Tingkat Kemenangan</p>
                    <p class="text-2xl sm:text-3xl font-black text-emerald-600 mt-1">{{ $winRate }}%</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold group-hover:scale-110 transition-transform">
                    🏆
                </div>
            </div>
            <div class="flex items-center justify-between text-xs text-slate-500 font-medium mt-3 pt-3 border-t border-slate-100">
                <span>Rekor Duel</span>
                <span class="font-extrabold text-slate-700 font-mono">{{ $totalWins }}M - {{ $totalLosses }}K - {{ $totalDraws }}S</span>
            </div>
        </div>

        <!-- Metric 3: Akurasi Serangan -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md hover:border-brand-secondary/40 transition-all duration-200 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Rata-rata Akurasi Poin</p>
                    <p class="text-2xl sm:text-3xl font-black text-brand-secondary mt-1">{{ $avgAccuracy }}%</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-brand-secondary/10 text-brand-secondary flex items-center justify-center text-xl font-bold group-hover:scale-110 transition-transform">
                    🎯
                </div>
            </div>
            <div class="flex items-center justify-between text-xs text-slate-500 font-medium mt-3 pt-3 border-t border-slate-100">
                <span>Rata-rata Attack</span>
                <span class="font-bold text-slate-700">{{ $avgAttack }} Serangan/Laga</span>
            </div>
        </div>

        <!-- Metric 4: Kehadiran Presensi -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md hover:border-sky-400 transition-all duration-200 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Presensi Latihan</p>
                    <p class="text-2xl sm:text-3xl font-black text-slate-900 mt-1">{{ $totalAttendance }} Sesi</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center text-xl font-bold group-hover:scale-110 transition-transform">
                    📅
                </div>
            </div>
            <div class="flex items-center justify-between text-xs text-slate-500 font-medium mt-3 pt-3 border-t border-slate-100">
                <span>Tingkat Partisipasi</span>
                <span class="font-extrabold text-emerald-600">{{ $attendanceRate }}% Kehadiran</span>
            </div>
        </div>
    </div>

    <!-- Middle Section: Chart Tren Performa & Kartu Ringkasan Diri -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Chart: Perkembangan Attack & Akurasi (2 Columns) -->
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200/80 shadow-sm p-5 sm:p-6 space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                        <span>📈</span> Tren Performa Duel Kumite Saya
                    </h3>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">Pantau peningkatan jumlah serangan (Attack) dan ketepatan poin (Akurasi %) pada laga-laga terbaru</p>
                </div>
                <span class="px-3 py-1 rounded-full bg-blue-50 text-brand-primary border border-blue-200/60 text-xs font-black self-start sm:self-auto">
                    Statistik Pribadi
                </span>
            </div>

            @if(count($chartMatchLabels) > 0)
                <div class="h-64 sm:h-72 w-full">
                    <canvas id="kohaiPerformanceChart"></canvas>
                </div>
            @else
                <div class="h-64 flex flex-col items-center justify-center text-center p-6 text-slate-400">
                    <p class="text-sm font-medium">Belum ada riwayat laga Kumite untuk ditampilkan pada grafik.</p>
                    <p class="text-xs text-slate-400 mt-1">Ikuti sesi sparring dojo untuk mendapatkan evaluasi dari Senpai.</p>
                </div>
            @endif
        </div>

        <!-- Profil & Ringkasan Diri Kohai (1 Column) -->
        <div class="lg:col-span-1 bg-white rounded-3xl border border-slate-200/80 shadow-sm p-5 sm:p-6 space-y-4 flex flex-col justify-between">
            <div class="space-y-4">
                <div class="border-b border-slate-100 pb-4 flex items-center justify-between">
                    <h3 class="text-base font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                        <span>🥋</span> Identitas Karateka
                    </h3>
                    <a href="{{ route('kohai.profile.index') }}" class="text-xs font-bold text-brand-primary hover:underline">
                        Edit &rarr;
                    </a>
                </div>

                <!-- Info Profil Card -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-brand-secondary text-slate-950 flex items-center justify-center text-base font-black uppercase shadow-xs shrink-0">
                            {{ $kohai->initials }}
                        </div>
                        <div class="min-w-0">
                            <h4 class="text-sm font-extrabold text-slate-900 truncate">{{ $kohai->name }}</h4>
                            <p class="text-xs text-slate-500 truncate">{{ $kohai->email }}</p>
                        </div>
                    </div>

                    <div class="pt-2 border-t border-slate-200/60 space-y-2 text-xs">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 font-medium">Tingkat Sabuk:</span>
                            @if($kohai->kohaiProfile?->rank)
                                <span class="inline-flex items-center gap-1.5 font-bold text-slate-900">
                                    <span class="w-2.5 h-2.5 rounded-full shrink-0 shadow-xs" style="background-color: {{ $kohai->kohaiProfile->rank->belt->color_code ?? '#ffffff' }}"></span>
                                    <span>{{ $kohai->kohaiProfile->rank->name }}</span>
                                </span>
                            @else
                                <span class="text-slate-400">Belum Disetel</span>
                            @endif
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 font-medium">Status Asal:</span>
                            <span class="font-bold text-slate-800">
                                @if($kohai->kohaiProfile?->isPolindra())
                                    Polindra ({{ $kohai->kohaiProfile->studyProgram->name ?? 'Mahasiswa' }})
                                @else
                                    {{ $kohai->kohaiProfile->institution ?? 'Non-Polindra / Umum' }}
                                @endif
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 font-medium">Nomor WhatsApp:</span>
                            <span class="font-mono font-bold text-slate-800">{{ $kohai->phone ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Motivation Banner -->
                <div class="p-3.5 rounded-2xl bg-gradient-to-br from-blue-50 to-sky-50 border border-blue-200/60 text-xs text-brand-primary leading-relaxed font-medium">
                    <p class="font-extrabold text-slate-900 flex items-center gap-1.5 mb-1">
                        <span>💡</span> Prinsip Dojo Karate
                    </p>
                    <em>"Hitotsu! Reigi o omonzuru koto"</em> — Senantiasa memelihara sopan santun dan kejujuran dalam setiap latihan maupun pertandingan.
                </div>
            </div>

            <a href="{{ route('kohai.profile.index') }}" class="w-full py-2.5 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs text-center transition shadow-xs">
                Perbarui Biodata Lengkap
            </a>
        </div>
    </div>

    <!-- Bottom Section: 5 Recent Kumite Reports & Weekly Schedule -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- 5 Recent Kumite Reports (2 Columns) -->
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200/80 shadow-sm p-5 sm:p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                        <span>🏆</span> Riwayat Raport Kumite WKF Terkini
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5 font-medium">5 hasil duel tanding Kumite terakhir yang telah dinilai oleh Senpai</p>
                </div>
                <a href="{{ route('kohai.kumite.index') }}" class="inline-flex items-center gap-1 text-xs font-extrabold text-brand-primary hover:text-brand-secondary transition">
                    <span>Lihat Semua ({{ $totalMatches }})</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="overflow-x-auto min-w-0">
                <table class="w-full text-left text-sm text-slate-600 min-w-full">
                    <thead class="bg-slate-50 text-slate-700 text-[11px] uppercase font-bold tracking-wider border-b border-slate-200/80 whitespace-nowrap">
                        <tr>
                            <th class="py-3 px-3.5">Tanggal</th>
                            <th class="py-3 px-3.5">Posisi Sudut</th>
                            <th class="py-3 px-3.5">Lawan Tanding</th>
                            <th class="py-3 px-3.5 text-center">Skor WKF</th>
                            <th class="py-3 px-3.5 text-center">Hasil Duel</th>
                            <th class="py-3 px-3.5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 whitespace-nowrap font-medium text-xs">
                        @forelse($recentKumiteReports as $r)
                            @php
                                $isAka = ($r->aka_kohai_id === $kohai->id);
                                $myScore = $isAka ? $r->aka_total_score : $r->ao_total_score;
                                $opponentScore = $isAka ? $r->ao_total_score : $r->aka_total_score;
                                $opponent = $isAka ? $r->aoKohai : $r->akaKohai;
                                $isWinner = ($r->winner_id === $kohai->id);
                                $isDraw = ($r->winner_id === null);
                                $hasSenshu = $isAka ? ($r->senshu_corner === 'aka') : ($r->senshu_corner === 'ao');
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-3.5 px-3.5">
                                    <span class="font-bold text-slate-900 block">{{ $r->match_date->format('d M Y') }}</span>
                                    <span class="text-[10px] text-slate-400 font-mono">{{ $r->match_time }} WIB</span>
                                </td>

                                <td class="py-3.5 px-3.5">
                                    @if($isAka)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-red-50 text-red-700 font-bold border border-red-200/80">
                                            <span class="w-2 h-2 rounded-full bg-red-600 shrink-0"></span>
                                            AKA (Merah)
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-blue-50 text-brand-primary font-bold border border-blue-200/80">
                                            <span class="w-2 h-2 rounded-full bg-brand-primary shrink-0"></span>
                                            AO (Biru)
                                        </span>
                                    @endif
                                </td>

                                <td class="py-3.5 px-3.5">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-slate-900">{{ $opponent->name ?? 'N/A' }}</span>
                                    </div>
                                </td>

                                <td class="py-3.5 px-3.5 text-center font-black">
                                    <span class="px-2 py-0.5 rounded-md {{ $isWinner ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-800' }}">
                                        {{ $myScore }}
                                    </span>
                                    <span class="text-slate-300 mx-1">:</span>
                                    <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-600">
                                        {{ $opponentScore }}
                                    </span>
                                    @if($hasSenshu)
                                        <span class="ml-1 px-1.5 py-0.2 text-[8px] font-black bg-amber-100 text-amber-800 rounded border border-amber-200">SENSHU</span>
                                    @endif
                                </td>

                                <td class="py-3.5 px-3.5 text-center">
                                    @if($isWinner)
                                        <span class="px-2.5 py-1 text-[11px] font-black rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200/80">
                                            MENANG 🏆
                                        </span>
                                    @elseif($isDraw)
                                        <span class="px-2.5 py-1 text-[11px] font-bold rounded-full bg-amber-50 text-amber-800 border border-amber-200/80">
                                            SERI
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 text-[11px] font-extrabold rounded-full bg-red-50 text-red-700 border border-red-200/80">
                                            KALAH
                                        </span>
                                    @endif
                                </td>

                                <td class="py-3.5 px-3.5 text-center">
                                    <a href="{{ route('kohai.kumite.show', $r->id) }}" class="px-2.5 py-1 bg-brand-primary hover:bg-brand-primary/90 text-white font-bold rounded-lg transition text-[11px] shadow-xs">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400 text-xs font-medium">
                                    Belum ada data evaluasi Kumite. Ikuti sesi latihan tanding dojo untuk mendapatkan evaluasi dari Senpai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Jadwal Latihan Wajib Dojo (1 Column) -->
        <div class="lg:col-span-1 bg-white rounded-3xl border border-slate-200/80 shadow-sm p-5 sm:p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <h3 class="text-base font-extrabold text-slate-900 flex items-center gap-2 tracking-tight">
                    <span>🗓️</span> Jadwal Latihan Rutin
                </h3>
                <span class="text-[11px] bg-blue-50 text-brand-primary px-3 py-1 rounded-full font-black border border-blue-200/60">
                    Mingguan
                </span>
            </div>

            <div class="space-y-3">
                @foreach($scheduleList as $sched)
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 hover:border-brand-primary/40 transition-all space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-black text-brand-primary uppercase tracking-wider">{{ $sched['hari'] }}</span>
                            <span class="text-[11px] text-slate-500 font-mono font-bold bg-white px-2 py-0.5 rounded-md border border-slate-200">{{ $sched['jam'] }}</span>
                        </div>
                        <div>
                            <h4 class="text-xs sm:text-sm font-bold text-slate-900 leading-snug">{{ $sched['materi'] }}</h4>
                        </div>
                        <div class="pt-2 border-t border-slate-200/60 flex items-center justify-between text-[11px] text-slate-400 font-medium">
                            <span class="flex items-center gap-1">📍 {{ $sched['lokasi'] }}</span>
                            <span class="text-emerald-600 font-bold">Wajib Hadir</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN and Initialization -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const perfCanvas = document.getElementById('kohaiPerformanceChart');
        if (perfCanvas) {
            const ctxPerf = perfCanvas.getContext('2d');
            const matchLabels = @json($chartMatchLabels);
            const attackData = @json($chartAttack);
            const accuracyData = @json($chartAccuracy);

            new Chart(ctxPerf, {
                type: 'line',
                data: {
                    labels: matchLabels,
                    datasets: [
                        {
                            label: 'Nilai Serangan (Attack)',
                            data: attackData,
                            borderColor: '#146C94',
                            backgroundColor: 'rgba(20, 108, 148, 0.12)',
                            borderWidth: 2.5,
                            fill: true,
                            tension: 0.35,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            pointBackgroundColor: '#146C94',
                        },
                        {
                            label: 'Akurasi Poin (%)',
                            data: accuracyData,
                            borderColor: '#19A7CE',
                            backgroundColor: 'rgba(25, 167, 206, 0.12)',
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
                            grid: { color: 'rgba(226, 232, 240, 0.6)' },
                            ticks: { font: { family: 'Plus Jakarta Sans', size: 10 } }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { family: 'Plus Jakarta Sans', size: 10 } }
                        }
                    }
                }
            });
        }
    });
</script>
@endsection

