@extends('layouts.senpai')

@section('title', 'Detail Raport Kumite WKF')

@section('content')
<div class="space-y-6">
    <!-- Header Title & Back Button -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs transition-colors duration-200">
        <div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand-primary/10 dark:bg-brand-primary/20 text-brand-primary dark:text-brand-secondary text-xs font-bold mb-1">
                <span>🥋 EVALUASI TANDING WKF</span>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white">Detail Raport Kumite</h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 flex items-center flex-wrap gap-2 font-medium">
                <span>Pertandingan tanggal {{ $kumiteReport->match_date->format('d M Y') }}</span>
                <span>•</span>
                <span>Jam {{ $kumiteReport->match_time }} WIB</span>
                <span>•</span>
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-amber-50 dark:bg-amber-950/50 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-800 font-bold">
                    ⏱️ Durasi: {{ $kumiteReport->formatted_duration }} ({{ $kumiteReport->human_duration }})
                </span>
            </p>
        </div>
        <a href="{{ route('senpai.kumite.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 text-xs font-bold rounded-xl transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Match Summary Banner -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-900 to-brand-primary dark:from-slate-950 dark:via-slate-900 dark:to-blue-950 p-6 sm:p-8 rounded-2xl text-white shadow-xl text-center relative overflow-hidden border border-slate-800">
        <div class="relative z-10 grid grid-cols-1 sm:grid-cols-3 items-center gap-6">
            <!-- AKA Player -->
            <div class="text-center sm:text-right space-y-1">
                <span class="inline-block px-3 py-0.5 rounded bg-red-600 font-extrabold text-xs tracking-wider">AKA (MERAH)</span>
                <h3 class="text-xl sm:text-2xl font-black text-white">{{ $kumiteReport->akaKohai->name ?? 'Kohai AKA' }}</h3>
                @if($kumiteReport->senshu_corner === 'aka')
                    <span class="inline-block text-[10px] bg-red-200 text-red-900 px-2 py-0.5 rounded font-black">SENSHU</span>
                @endif
            </div>

            <!-- Score Center -->
            <div class="text-center space-y-2">
                <div class="inline-flex items-center justify-center gap-3 bg-black/50 px-6 py-3 rounded-2xl border border-white/20 shadow-inner">
                    <span class="text-4xl sm:text-5xl font-black text-red-500">{{ $kumiteReport->aka_total_score }}</span>
                    <span class="text-2xl text-slate-400 font-light">:</span>
                    <span class="text-4xl sm:text-5xl font-black text-brand-secondary">{{ $kumiteReport->ao_total_score }}</span>
                </div>
                <div>
                    @if($kumiteReport->winner)
                        <p class="text-xs text-emerald-400 font-bold uppercase tracking-wider">PEMENANG: {{ $kumiteReport->winner->name }} 🏆</p>
                    @else
                        <p class="text-xs text-slate-300 font-bold uppercase tracking-wider">HASIL: SERI (DRAW) 🤝</p>
                    @endif
                </div>
                <div class="pt-1">
                    <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full bg-white/10 text-slate-200 text-[11px] font-mono border border-white/10">
                        ⏱️ Durasi Ronde: {{ $kumiteReport->formatted_duration }} ({{ $kumiteReport->human_duration }})
                    </span>
                </div>
            </div>

            <!-- AO Player -->
            <div class="text-center sm:text-left space-y-1">
                <span class="inline-block px-3 py-0.5 rounded bg-brand-primary font-extrabold text-xs tracking-wider">AO (BIRU)</span>
                <h3 class="text-xl sm:text-2xl font-black text-white">{{ $kumiteReport->aoKohai->name ?? 'Kohai AO' }}</h3>
                @if($kumiteReport->senshu_corner === 'ao')
                    <span class="inline-block text-[10px] bg-blue-200 text-blue-900 px-2 py-0.5 rounded font-black">SENSHU</span>
                @endif
            </div>
        </div>
    </div>

    <!-- WKF Detailed Statistics Table -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs overflow-hidden transition-colors duration-200">
        <div class="p-5 border-b border-slate-100 dark:border-slate-800">
            <h3 class="text-base font-extrabold text-slate-900 dark:text-white">Rincian Perolehan Poin & Pelanggaran WKF</h3>
        </div>

        <div class="overflow-x-auto min-w-0">
            <table class="w-full text-center text-sm min-w-full">
                <thead class="bg-slate-50 dark:bg-slate-950/60 text-slate-900 dark:text-white text-xs uppercase font-extrabold border-b border-slate-200 dark:border-slate-800">
                    <tr>
                        <th class="py-3 px-6 text-red-700 dark:text-red-400 bg-red-50/50 dark:bg-red-950/20">AKA (MERAH)</th>
                        <th class="py-3 px-6 bg-slate-100 dark:bg-slate-800">INDIKATOR PENILAIAN WKF</th>
                        <th class="py-3 px-6 text-brand-primary dark:text-brand-secondary bg-blue-50/50 dark:bg-blue-950/20">AO (BIRU)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800 font-medium">
                    <tr class="bg-slate-50/40 dark:bg-slate-950/30">
                        <td class="py-3 px-6 font-bold bg-red-50/20 dark:bg-red-950/10">
                            {!! $kumiteReport->senshu_corner === 'aka' ? '<span class="text-red-700 dark:text-red-400 font-black">✓ SENSHU</span>' : '<span class="text-slate-400 dark:text-slate-600">-</span>' !!}
                        </td>
                        <td class="py-3 px-6 font-bold text-slate-700 dark:text-slate-300">Senshu (Keunggulan Pertama)</td>
                        <td class="py-3 px-6 font-bold bg-blue-50/20 dark:bg-blue-950/10">
                            {!! $kumiteReport->senshu_corner === 'ao' ? '<span class="text-brand-primary dark:text-brand-secondary font-black">✓ SENSHU</span>' : '<span class="text-slate-400 dark:text-slate-600">-</span>' !!}
                        </td>
                    </tr>
                    <tr>
                        <td class="py-3 px-6 font-bold text-red-600 dark:text-red-400 bg-red-50/20 dark:bg-red-950/10">{{ $kumiteReport->aka_ippon }} ({{ $kumiteReport->aka_ippon * 3 }} Pts)</td>
                        <td class="py-3 px-6 font-bold text-slate-700 dark:text-slate-300">IPPON (3 Poin)</td>
                        <td class="py-3 px-6 font-bold text-brand-primary dark:text-brand-secondary bg-blue-50/20 dark:bg-blue-950/10">{{ $kumiteReport->ao_ippon }} ({{ $kumiteReport->ao_ippon * 3 }} Pts)</td>
                    </tr>
                    <tr>
                        <td class="py-3 px-6 font-bold text-red-600 dark:text-red-400 bg-red-50/20 dark:bg-red-950/10">{{ $kumiteReport->aka_wazaari }} ({{ $kumiteReport->aka_wazaari * 2 }} Pts)</td>
                        <td class="py-3 px-6 font-bold text-slate-700 dark:text-slate-300">WAZA-ARI (2 Poin)</td>
                        <td class="py-3 px-6 font-bold text-brand-primary dark:text-brand-secondary bg-blue-50/20 dark:bg-blue-950/10">{{ $kumiteReport->ao_wazaari }} ({{ $kumiteReport->ao_wazaari * 2 }} Pts)</td>
                    </tr>
                    <tr>
                        <td class="py-3 px-6 font-bold text-red-600 dark:text-red-400 bg-red-50/20 dark:bg-red-950/10">{{ $kumiteReport->aka_yuko }} ({{ $kumiteReport->aka_yuko * 1 }} Pts)</td>
                        <td class="py-3 px-6 font-bold text-slate-700 dark:text-slate-300">YUKO (1 Poin)</td>
                        <td class="py-3 px-6 font-bold text-brand-primary dark:text-brand-secondary bg-blue-50/20 dark:bg-blue-950/10">{{ $kumiteReport->ao_yuko }} ({{ $kumiteReport->ao_yuko * 1 }} Pts)</td>
                    </tr>
                    <tr>
                        <td class="py-3 px-6 text-slate-700 dark:text-slate-300 bg-red-50/20 dark:bg-red-950/10 font-bold">
                            @if($kumiteReport->aka_fouls == 0)
                                <span class="text-xs text-emerald-600 dark:text-emerald-400 font-bold">0 (Bersih / Nihil)</span>
                            @else
                                <span class="text-xs text-red-700 dark:text-red-400 font-bold">{{ $kumiteReport->aka_fouls }} Poin Pelanggaran</span>
                            @endif
                        </td>
                        <td class="py-3 px-6 font-bold text-slate-700 dark:text-slate-300">Poin Pelanggaran WKF</td>
                        <td class="py-3 px-6 text-slate-700 dark:text-slate-300 bg-blue-50/20 dark:bg-blue-950/10 font-bold">
                            @if($kumiteReport->ao_fouls == 0)
                                <span class="text-xs text-emerald-600 dark:text-emerald-400 font-bold">0 (Bersih / Nihil)</span>
                            @else
                                <span class="text-xs text-brand-primary dark:text-brand-secondary font-bold">{{ $kumiteReport->ao_fouls }} Poin Pelanggaran</span>
                            @endif
                        </td>
                    </tr>
                    <tr class="bg-slate-50 dark:bg-slate-950/50 font-bold">
                        <td class="py-3.5 px-6 text-red-700 dark:text-red-400 bg-red-100/50 dark:bg-red-950/30">
                            Serangan: {{ $kumiteReport->aka_score_attack }} kali | Akurasi: {{ $kumiteReport->aka_score_accuracy }}%
                        </td>
                        <td class="py-3.5 px-6 text-slate-900 dark:text-white">EVALUASI TEKNIS SENPAI</td>
                        <td class="py-3.5 px-6 text-brand-primary dark:text-brand-secondary bg-blue-100/50 dark:bg-blue-950/30">
                            Serangan: {{ $kumiteReport->ao_score_attack }} kali | Akurasi: {{ $kumiteReport->ao_score_accuracy }}%
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Senshu History & Cancelling Log Timeline -->
    @if($kumiteReport->senshuLogs && $kumiteReport->senshuLogs->count() > 0)
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs p-6 space-y-4 transition-colors duration-200">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                <div class="flex items-center gap-2">
                    <span class="p-2 rounded-xl bg-amber-50 dark:bg-amber-950/50 text-amber-700 dark:text-amber-400 font-black text-sm">📜</span>
                    <div>
                        <h3 class="text-base font-extrabold text-slate-900 dark:text-white">Riwayat & Log Keputusan SENSHU (Senshu Cancelling)</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Kronologi pemberian dan pembatalan Senshu selama pertandingan berlangsung</p>
                    </div>
                </div>
                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                    {{ $kumiteReport->senshuLogs->count() }} Keputusan Dicatat
                </span>
            </div>

            <div class="relative pl-6 space-y-3 before:absolute before:left-2.5 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-200 dark:before:bg-slate-800">
                @foreach($kumiteReport->senshuLogs->sortBy('sequence') as $log)
                    <div class="relative flex items-start gap-4">
                        <div class="absolute -left-6 top-1.5 w-5 h-5 rounded-full border-2 border-white dark:border-slate-900 shadow-xs flex items-center justify-center text-[10px] font-black {{ $log->status === 'cancelled' ? 'bg-red-500 text-white' : ($log->status === 'active' ? 'bg-emerald-500 text-white' : 'bg-slate-400 text-white') }}">
                            @if($log->status === 'cancelled')
                                ✕
                            @elseif($log->status === 'active')
                                ✓
                            @else
                                -
                            @endif
                        </div>

                        <div class="flex-1 bg-slate-50 dark:bg-slate-950/50 rounded-xl p-3 border {{ $log->status === 'active' ? 'border-emerald-200 dark:border-emerald-900 bg-emerald-50/30 dark:bg-emerald-950/20' : ($log->status === 'cancelled' ? 'border-red-200 dark:border-red-900 bg-red-50/20 dark:bg-red-950/10' : 'border-slate-200 dark:border-slate-800') }}">
                            <div class="flex items-center justify-between flex-wrap gap-2 mb-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-extrabold text-slate-700 dark:text-slate-300">Tahap #{{ $log->sequence }}</span>
                                    @if($log->corner === 'aka')
                                        <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-red-100 dark:bg-red-950/60 text-red-800 dark:text-red-300 border border-red-200 dark:border-red-900">
                                            🔴 AKA ({{ $kumiteReport->akaKohai->name }})
                                        </span>
                                    @elseif($log->corner === 'ao')
                                        <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-blue-100 dark:bg-blue-950/60 text-blue-800 dark:text-blue-300 border border-blue-200 dark:border-blue-900">
                                            🔵 AO ({{ $kumiteReport->aoKohai->name }})
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                                            ⚪ Tidak Ada Senshu
                                        </span>
                                    @endif
                                </div>

                                <div>
                                    @if($log->status === 'active')
                                        <span class="inline-flex items-center gap-1 text-[11px] font-extrabold text-emerald-700 dark:text-emerald-400 bg-emerald-100 dark:bg-emerald-950/60 px-2 py-0.5 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Keputusan Akhir Berlaku
                                        </span>
                                    @elseif($log->status === 'cancelled')
                                        <span class="inline-flex items-center gap-1 text-[11px] font-extrabold text-red-700 dark:text-red-400 bg-red-100 dark:bg-red-950/60 px-2 py-0.5 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Dibatalkan (Senshu Cancelled)
                                        </span>
                                    @else
                                        <span class="text-[11px] font-bold text-slate-500 bg-slate-200 dark:bg-slate-800 px-2 py-0.5 rounded-full">
                                            Nihil
                                        </span>
                                    @endif
                                </div>
                            </div>

                            @if($log->notes)
                                <p class="text-xs text-slate-600 dark:text-slate-400 mt-1 italic bg-white/80 dark:bg-slate-900/80 p-2 rounded border border-slate-100 dark:border-slate-800">
                                    Catatan: {{ $log->notes }}
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Separate Evaluation Notes Cards for AKA & AO -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- AKA Notes -->
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-red-200 dark:border-red-900/60 shadow-xs space-y-3 transition-colors duration-200">
            <h3 class="text-sm font-extrabold text-red-800 dark:text-red-400 uppercase tracking-wider flex items-center gap-2 border-b border-red-100 dark:border-red-900/60 pb-2">
                <span>📝</span> Catatan Evaluasi AKA ({{ $kumiteReport->akaKohai->name }})
            </h3>
            <p class="text-xs sm:text-sm text-slate-800 dark:text-slate-200 bg-red-50/50 dark:bg-red-950/20 p-4 rounded-xl border border-red-100 dark:border-red-900/40 leading-relaxed font-medium">
                {{ $kumiteReport->aka_evaluation_notes ?: 'Tidak ada catatan evaluasi tertulis untuk Kohai AKA.' }}
            </p>
        </div>

        <!-- AO Notes -->
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-blue-200 dark:border-blue-900/60 shadow-xs space-y-3 transition-colors duration-200">
            <h3 class="text-sm font-extrabold text-brand-primary dark:text-brand-secondary uppercase tracking-wider flex items-center gap-2 border-b border-blue-100 dark:border-blue-900/60 pb-2">
                <span>📝</span> Catatan Evaluasi AO ({{ $kumiteReport->aoKohai->name }})
            </h3>
            <p class="text-xs sm:text-sm text-slate-800 dark:text-slate-200 bg-blue-50/50 dark:bg-blue-950/20 p-4 rounded-xl border border-blue-100 dark:border-blue-900/40 leading-relaxed font-medium">
                {{ $kumiteReport->ao_evaluation_notes ?: 'Tidak ada catatan evaluasi tertulis untuk Kohai AO.' }}
            </p>
        </div>
    </div>
</div>
@endsection
