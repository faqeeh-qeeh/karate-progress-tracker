@extends('layouts.senpai')

@section('title', 'Detail & Analisis Kohai - ' . $kohai->name)

@section('content')
<div class="space-y-6">
    <!-- Kohai Student Profile & Physical Information Card -->
    @php
        $kp = $kohai->kohaiProfile;
    @endphp
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 p-6 shadow-sm transition-colors duration-200">
        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4 mb-5">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-brand-primary to-brand-secondary text-white font-black text-lg flex items-center justify-center shadow-md shadow-brand-primary/20 shrink-0">
                    {{ $kohai->initials }}
                </div>
                <div>
                    <h2 class="text-base font-extrabold text-slate-900 dark:text-white">Informasi Biodata & Data Fisik Murid</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Data akademik, tingkat sabuk, data fisik, dan kontak darurat murid Kohai</p>
                </div>
            </div>
            <div>
                @if($kp?->type === 'non_polindra')
                    <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-purple-50 dark:bg-purple-950/50 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-800">
                        🏛️ Luar Polindra / Umum
                    </span>
                @else
                    <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-blue-50 dark:bg-blue-950/50 text-brand-primary dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                        🎓 Mahasiswa Polindra
                    </span>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Kolom 1: Data Pribadi & Kontak -->
            <div class="space-y-3 bg-slate-50/70 dark:bg-slate-950/50 p-4 rounded-xl border border-slate-100 dark:border-slate-800 text-xs">
                <p class="font-extrabold text-slate-900 dark:text-white uppercase tracking-wider text-[11px] pb-1 border-b border-slate-200/60 dark:border-slate-800 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-brand-primary"></span>
                    <span>Data Pribadi & Kontak</span>
                </p>
                <div class="flex justify-between py-0.5">
                    <span class="text-slate-500 dark:text-slate-400">Nama Lengkap:</span>
                    <span class="font-bold text-slate-900 dark:text-white text-right">{{ $kohai->name }}</span>
                </div>
                <div class="flex justify-between py-0.5">
                    <span class="text-slate-500 dark:text-slate-400">TTL / Usia:</span>
                    <span class="font-bold text-slate-900 dark:text-white text-right">
                        {{ $kohai->birth_place ?? '-' }}, {{ $kohai->birth_date ? $kohai->birth_date->format('d M Y') : '-' }}
                        @if($kohai->birth_date)
                            <span class="text-slate-400 dark:text-slate-500 font-normal">({{ \Carbon\Carbon::parse($kohai->birth_date)->age }} th)</span>
                        @endif
                    </span>
                </div>
                <div class="flex justify-between py-0.5">
                    <span class="text-slate-500 dark:text-slate-400">Jenis Kelamin:</span>
                    <span class="font-bold text-slate-900 dark:text-white text-right">{{ $kohai->gender === 'male' ? 'Laki-laki' : ($kohai->gender === 'female' ? 'Perempuan' : '-') }}</span>
                </div>
                <div class="flex justify-between py-0.5">
                    <span class="text-slate-500 dark:text-slate-400">WhatsApp / HP:</span>
                    <span class="font-bold text-slate-900 dark:text-white text-right font-mono">{{ $kohai->phone ?? '-' }}</span>
                </div>
                <div class="flex justify-between py-0.5">
                    <span class="text-slate-500 dark:text-slate-400">Alamat:</span>
                    <span class="font-bold text-slate-900 dark:text-white text-right max-w-[170px] truncate" title="{{ $kohai->address }}">{{ $kohai->address ?? '-' }}</span>
                </div>
            </div>

            <!-- Kolom 2: Data Akademik & Sabuk -->
            <div class="space-y-3 bg-slate-50/70 dark:bg-slate-950/50 p-4 rounded-xl border border-slate-100 dark:border-slate-800 text-xs">
                <p class="font-extrabold text-slate-900 dark:text-white uppercase tracking-wider text-[11px] pb-1 border-b border-slate-200/60 dark:border-slate-800 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    <span>Akademik & Tingkat Sabuk</span>
                </p>
                @if($kp?->type === 'non_polindra')
                    <div class="flex justify-between py-0.5">
                        <span class="text-slate-500 dark:text-slate-400">Asal Instansi/Sekolah:</span>
                        <span class="font-bold text-slate-900 dark:text-white text-right">{{ $kp->school_origin ?? '-' }}</span>
                    </div>
                @else
                    <div class="flex justify-between py-0.5">
                        <span class="text-slate-500 dark:text-slate-400">NIM Polindra:</span>
                        <span class="font-bold text-slate-900 dark:text-white font-mono text-right">{{ $kp?->nim ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-0.5">
                        <span class="text-slate-500 dark:text-slate-400">Jurusan:</span>
                        <span class="font-bold text-slate-900 dark:text-white text-right">{{ $kp?->studyProgram?->department?->nama ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-0.5">
                        <span class="text-slate-500 dark:text-slate-400">Program Studi / Kelas:</span>
                        <span class="font-bold text-slate-900 dark:text-white text-right">{{ $kp?->studyProgram?->nama ?? '-' }} ({{ $kp?->academicClass?->nama ?? '-' }})</span>
                    </div>
                    <div class="flex justify-between py-0.5">
                        <span class="text-slate-500 dark:text-slate-400">Tahun Angkatan:</span>
                        <span class="font-bold text-slate-900 dark:text-white text-right">{{ $kp?->entry_year ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-0.5">
                        <span class="text-slate-500 dark:text-slate-400">Asal SMA/SMK:</span>
                        <span class="font-bold text-slate-900 dark:text-white text-right">{{ $kp?->school_origin ?? '-' }}</span>
                    </div>
                @endif
                <div class="flex justify-between py-0.5 border-t border-slate-200/50 dark:border-slate-800 pt-1.5">
                    <span class="text-slate-500 dark:text-slate-400">Tingkat Sabuk:</span>
                    <span class="font-bold text-slate-900 dark:text-white text-right">
                        @if($kp?->rank?->belt)
                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700">
                                <span class="w-2.5 h-2.5 rounded-full border border-slate-300 dark:border-slate-600" style="background-color: {{ $kp->rank->belt->warna ?? '#e2e8f0' }}"></span>
                                <span>Sabuk {{ $kp->rank->belt->nama }} - {{ $kp->rank->nama }}</span>
                            </span>
                        @else
                            <span class="text-slate-400 dark:text-slate-500 italic">Belum ditentukan</span>
                        @endif
                    </span>
                </div>
            </div>

            <!-- Kolom 3: Data Fisik & Kontak Darurat -->
            <div class="space-y-3 bg-slate-50/70 dark:bg-slate-950/50 p-4 rounded-xl border border-slate-100 dark:border-slate-800 text-xs">
                <p class="font-extrabold text-slate-900 dark:text-white uppercase tracking-wider text-[11px] pb-1 border-b border-slate-200/60 dark:border-slate-800 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>Data Fisik & Kontak Darurat</span>
                </p>
                <div class="grid grid-cols-2 gap-2 my-1">
                    <div class="bg-white dark:bg-slate-900 p-2.5 rounded-lg border border-slate-200 dark:border-slate-800 text-center">
                        <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase block">Tinggi</span>
                        <span class="font-black text-slate-900 dark:text-white text-sm">{{ $kp?->height ?? '-' }} cm</span>
                    </div>
                    <div class="bg-white dark:bg-slate-900 p-2.5 rounded-lg border border-slate-200 dark:border-slate-800 text-center">
                        <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase block">Berat</span>
                        <span class="font-black text-slate-900 dark:text-white text-sm">{{ $kp?->weight ?? '-' }} kg</span>
                    </div>
                </div>
                <div class="flex justify-between py-0.5 border-t border-slate-200/50 dark:border-slate-800 pt-1.5">
                    <span class="text-slate-500 dark:text-slate-400">Wali / Kontak Darurat:</span>
                    <span class="font-bold text-slate-900 dark:text-white text-right">{{ $kp?->emergency_contact_name ?? '-' }}</span>
                </div>
                <div class="flex justify-between py-0.5">
                    <span class="text-slate-500 dark:text-slate-400">No. HP Kontak Darurat:</span>
                    <span class="font-bold text-slate-900 dark:text-white text-right font-mono">{{ $kp?->emergency_contact_phone ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Performance Statistics Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Matches -->
        <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs transition-colors duration-200">
            <div class="flex items-center justify-between text-slate-400 dark:text-slate-500 mb-2">
                <span class="text-xs font-bold uppercase tracking-wider">Total Tanding</span>
                <div class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
            </div>
            <p class="text-3xl font-black text-slate-900 dark:text-white">{{ $totalMatches }} <span class="text-sm font-semibold text-slate-400 dark:text-slate-500">Match</span></p>
        </div>

        <!-- Win / Loss -->
        <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs transition-colors duration-200">
            <div class="flex items-center justify-between text-slate-400 dark:text-slate-500 mb-2">
                <span class="text-xs font-bold uppercase tracking-wider">Hasil (W / L)</span>
                <div class="w-8 h-8 rounded-xl bg-emerald-100 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-400 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="flex items-baseline gap-3">
                <span class="text-2xl font-black text-emerald-600 dark:text-emerald-400">{{ $wins }} <span class="text-xs font-bold text-slate-400 dark:text-slate-500">Menang (W)</span></span>
                <span class="text-slate-300 dark:text-slate-600">/</span>
                <span class="text-2xl font-black text-red-500 dark:text-red-400">{{ $losses }} <span class="text-xs font-bold text-slate-400 dark:text-slate-500">Kalah (L)</span></span>
            </div>
        </div>

        <!-- Rata-rata Attack (3 Bulan Terakhir) -->
        <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs transition-colors duration-200">
            <div class="flex items-center justify-between text-slate-400 dark:text-slate-500 mb-2">
                <span class="text-xs font-bold uppercase tracking-wider">Rata-Rata Attack (3 Bln)</span>
                <div class="w-8 h-8 rounded-xl bg-blue-100 dark:bg-blue-950/50 text-brand-primary dark:text-blue-400 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                </div>
            </div>
            <p class="text-3xl font-black text-brand-primary dark:text-brand-secondary">{{ $avgAttack }} <span class="text-sm font-semibold text-slate-400 dark:text-slate-500">Kali</span></p>
        </div>

        <!-- Rata-rata Accuracy (3 Bulan Terakhir) -->
        <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs transition-colors duration-200">
            <div class="flex items-center justify-between text-slate-400 dark:text-slate-500 mb-2">
                <span class="text-xs font-bold uppercase tracking-wider">Rata-Rata Accuracy (3 Bln)</span>
                <div class="w-8 h-8 rounded-xl bg-cyan-100 dark:bg-cyan-950/50 text-brand-secondary dark:text-cyan-400 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </div>
            </div>
            <p class="text-3xl font-black text-brand-secondary dark:text-cyan-400">{{ $avgAccuracy }} <span class="text-sm font-semibold text-slate-400 dark:text-slate-500">%</span></p>
        </div>
    </div>

    <!-- Chart Section: Attack & Accuracy Progression (3 Bulan Terakhir) -->
    <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4 transition-colors duration-200">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 dark:border-slate-800 pb-4">
            <div>
                <h2 class="text-lg font-extrabold text-slate-900 dark:text-white">Grafik Analisis Performa (3 Bulan Terakhir)</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400">Tren perkembangan jumlah Serangan (Attack) dan Akurasi (Accuracy %) Kohai dalam 3 bulan terakhir</p>
            </div>
            <div class="flex items-center gap-4 text-xs font-bold">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-[#146C94] inline-block"></span>
                    <span class="text-slate-700 dark:text-slate-300">Jumlah Serangan (Attack)</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-[#19A7CE] inline-block"></span>
                    <span class="text-slate-700 dark:text-slate-300">Persentase Akurasi (%)</span>
                </div>
            </div>
        </div>

        @if($recentMatchesCount > 0)
            <div class="relative w-full h-80 sm:h-96">
                <canvas id="performanceChart"></canvas>
            </div>
        @else
            <div class="py-16 text-center text-slate-400 dark:text-slate-500">
                <svg class="w-12 h-12 mx-auto mb-3 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                </svg>
                <p class="text-sm font-semibold">Belum ada grafik analisis 3 bulan terakhir.</p>
                <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Kohai ini tidak memiliki catatan pertandingan Kumite dalam 3 bulan terakhir.</p>
            </div>
        @endif
    </div>

    <!-- Match History Table Section -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs overflow-hidden transition-colors duration-200">
        <div class="p-6 border-b border-slate-100 dark:border-slate-800">
            <h2 class="text-lg font-extrabold text-slate-900 dark:text-white">Riwayat Tanding & Catatan Evaluasi Senpai</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Daftar lengkap hasil pertandingan Kumite beserta catatan spesifik dari Senpai</p>
        </div>

        <div class="overflow-x-auto min-w-0">
            <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300 min-w-full">
                <thead class="bg-slate-50 dark:bg-slate-950/60 text-slate-800 dark:text-slate-200 text-xs uppercase font-bold tracking-wider border-b border-slate-200/80 dark:border-slate-800 whitespace-nowrap">
                    <tr>
                        <th class="py-3.5 px-6">Waktu Tanding</th>
                        <th class="py-3.5 px-6">Sudut</th>
                        <th class="py-3.5 px-6">Lawan</th>
                        <th class="py-3.5 px-6 text-center">Skor Akhir WKF</th>
                        <th class="py-3.5 px-6 text-center">Hasil</th>
                        <th class="py-3.5 px-6 text-center">Attack / Accuracy</th>
                        <th class="py-3.5 px-6">Catatan Evaluasi Senpai</th>
                        <th class="py-3.5 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 whitespace-nowrap">
                    @forelse($reportsDesc as $r)
                        @php
                            $isAka = ($r->aka_kohai_id === $kohai->id);
                            $opponent = $isAka ? $r->aoKohai : $r->akaKohai;
                            $myScore = $isAka ? $r->aka_total_score : $r->ao_total_score;
                            $oppScore = $isAka ? $r->ao_total_score : $r->aka_total_score;
                            $myAttack = $isAka ? $r->aka_score_attack : $r->ao_score_attack;
                            $myAccuracy = $isAka ? $r->aka_score_accuracy : $r->ao_score_accuracy;
                            $myNotes = $isAka ? $r->aka_evaluation_notes : $r->ao_evaluation_notes;
                            $isWinner = ($r->winner_id === $kohai->id);
                        @endphp
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition">
                            <!-- Match Date -->
                            <td class="py-4 px-6 text-xs text-slate-600 dark:text-slate-300 font-medium">
                                <p class="font-bold text-slate-900 dark:text-white">{{ $r->match_date->format('d M Y') }}</p>
                                <p class="text-slate-400 dark:text-slate-500 font-mono">{{ $r->match_time }} WIB</p>
                            </td>

                            <!-- Corner -->
                            <td class="py-4 px-6 font-bold text-xs">
                                @if($isAka)
                                    <span class="px-2.5 py-1 rounded-full bg-red-100 dark:bg-red-950/60 text-red-800 dark:text-red-300 border border-red-200 dark:border-red-900 inline-flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-red-600"></span>
                                        <span>AKA (Merah)</span>
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full bg-blue-100 dark:bg-blue-950/60 text-blue-800 dark:text-blue-300 border border-blue-200 dark:border-blue-900 inline-flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-brand-primary"></span>
                                        <span>AO (Biru)</span>
                                    </span>
                                @endif
                            </td>

                            <!-- Opponent -->
                            <td class="py-4 px-6 font-bold text-slate-900 dark:text-white text-xs">
                                {{ $opponent->name ?? 'N/A' }}
                            </td>

                            <!-- Score Comparison -->
                            <td class="py-4 px-6 text-center font-black text-sm">
                                <span class="{{ $isAka ? 'text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-950/50 border-red-200 dark:border-red-900/60' : 'text-brand-primary dark:text-brand-secondary bg-blue-50 dark:bg-blue-950/50 border-blue-200 dark:border-blue-900/60' }} px-2 py-1 rounded-lg border">
                                    {{ $myScore }}
                                </span>
                                <span class="text-slate-400 dark:text-slate-600 mx-1">:</span>
                                <span class="{{ !$isAka ? 'text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-950/50 border-red-200 dark:border-red-900/60' : 'text-brand-primary dark:text-brand-secondary bg-blue-50 dark:bg-blue-950/50 border-blue-200 dark:border-blue-900/60' }} px-2 py-1 rounded-lg border">
                                    {{ $oppScore }}
                                </span>
                            </td>

                            <!-- Result Badge -->
                            <td class="py-4 px-6 text-center">
                                @if($isWinner)
                                    <span class="px-3 py-1 font-extrabold text-xs rounded-full bg-emerald-100 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-900">
                                        🏆 Menang
                                    </span>
                                @else
                                    <span class="px-3 py-1 font-extrabold text-xs rounded-full bg-red-100 dark:bg-red-950/60 text-red-800 dark:text-red-300 border border-red-200 dark:border-red-900">
                                        ❌ Kalah
                                    </span>
                                @endif
                            </td>

                            <!-- Attack / Accuracy -->
                            <td class="py-4 px-6 text-center text-xs">
                                <span class="font-extrabold text-brand-primary dark:text-brand-secondary">{{ $myAttack }} Kali</span>
                                <span class="text-slate-400 dark:text-slate-600 mx-0.5">/</span>
                                <span class="font-extrabold text-brand-secondary dark:text-cyan-400">{{ $myAccuracy }}%</span>
                            </td>

                            <!-- Evaluation Notes -->
                            <td class="py-4 px-6 text-xs max-w-xs whitespace-normal">
                                @if($myNotes)
                                    <p class="text-slate-700 dark:text-slate-300 bg-slate-50 dark:bg-slate-950/50 p-2.5 rounded-xl border border-slate-200 dark:border-slate-800 italic">
                                        "{{ $myNotes }}"
                                    </p>
                                @else
                                    <span class="text-slate-400 dark:text-slate-500 italic">Tidak ada catatan.</span>
                                @endif
                            </td>

                            <!-- View Raport Detail Link -->
                            <td class="py-4 px-6 text-center">
                                <a href="{{ route('senpai.kumite.show', $r->id) }}" class="px-3 py-1.5 bg-brand-primary text-white text-xs font-bold rounded-lg hover:bg-brand-primary/90 transition shadow-2xs inline-flex items-center gap-1">
                                    <span>Detail</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-10 text-center text-slate-400 dark:text-slate-500 text-sm">
                                Belum ada riwayat pertandingan Kumite untuk murid ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($recentMatchesCount > 0)
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const isDarkMode = () => document.documentElement.classList.contains('dark');
            const performanceCanvas = document.getElementById('performanceChart');
            if (!performanceCanvas) return;

            const ctx = performanceCanvas.getContext('2d');
            const labels = @json($chartLabels);
            const attackData = @json($chartAttack);
            const accuracyData = @json($chartAccuracy);

            function getPerfColors() {
                const dark = isDarkMode();
                return {
                    text: dark ? '#94a3b8' : '#6b7280',
                    grid: dark ? 'rgba(51, 65, 85, 0.4)' : '#f3f4f6'
                };
            }

            const colors = getPerfColors();

            const chartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Jumlah Serangan (Attack)',
                            data: attackData,
                            borderColor: '#146C94',
                            backgroundColor: 'rgba(20, 108, 148, 0.15)',
                            fill: true,
                            tension: 0.35,
                            borderWidth: 3,
                            pointBackgroundColor: '#146C94',
                            pointRadius: 5,
                            pointHoverRadius: 7
                        },
                        {
                            label: 'Persentase Akurasi (%)',
                            data: accuracyData,
                            borderColor: '#19A7CE',
                            backgroundColor: 'rgba(255, 255, 255, 0)',
                            fill: false,
                            tension: 0.35,
                            borderWidth: 3,
                            borderDash: [5, 5],
                            pointBackgroundColor: '#19A7CE',
                            pointRadius: 5,
                            pointHoverRadius: 7
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
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleFont: { size: 12, weight: 'bold' },
                            bodyFont: { size: 12 },
                            padding: 12,
                            cornerRadius: 10,
                            callbacks: {
                                label: function(context) {
                                    if (context.dataset.label.includes('%') || context.dataset.label.includes('Akurasi')) {
                                        return ' ' + context.dataset.label + ': ' + context.parsed.y + '%';
                                    }
                                    return ' ' + context.dataset.label + ': ' + context.parsed.y + ' Serangan';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: { size: 11, weight: '600' },
                                color: colors.text
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: colors.grid
                            },
                            ticks: {
                                font: { size: 11, weight: '600' },
                                color: colors.text,
                                stepSize: 2
                            }
                        }
                    }
                }
            });

            window.addEventListener('karateThemeChanged', function() {
                const c = getPerfColors();
                chartInstance.options.scales.x.ticks.color = c.text;
                chartInstance.options.scales.y.ticks.color = c.text;
                chartInstance.options.scales.y.grid.color = c.grid;
                chartInstance.update();
            });
        });
    </script>
@endif
@endsection
