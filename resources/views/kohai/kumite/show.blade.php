@extends('layouts.kohai')

@section('title', 'Detail Raport Kumite Saya')

@section('content')
<div class="space-y-6">
    <!-- Header Title & Back Button -->
    <div class="flex items-center justify-between bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs transition-colors">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white">Rincian Raport Tanding Saya</h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 flex items-center flex-wrap gap-2 font-medium">
                <span>Diuji oleh Senpai {{ $kumiteReport->senpai->name ?? 'Senpai' }}</span>
                <span>•</span>
                <span>{{ $kumiteReport->match_date->format('d M Y') }} ({{ $kumiteReport->match_time }} WIB)</span>
                <span>•</span>
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-amber-50 dark:bg-amber-950/40 text-amber-800 dark:text-amber-400 border border-amber-200 dark:border-amber-800/60 font-bold">
                    ⏱️ Durasi: {{ $kumiteReport->formatted_duration }} ({{ $kumiteReport->human_duration }})
                </span>
            </p>
        </div>
        <a href="{{ route('kohai.kumite.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 text-xs font-bold rounded-xl transition cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Match Result Header Banner -->
    @php
        $myId = auth()->id();
        $isAka = ($kumiteReport->aka_kohai_id === $myId);
        $myScore = $isAka ? $kumiteReport->aka_total_score : $kumiteReport->ao_total_score;
        $oppScore = $isAka ? $kumiteReport->ao_total_score : $kumiteReport->aka_total_score;
        $opponent = $isAka ? $kumiteReport->aoKohai : $kumiteReport->akaKohai;
        $isWinner = ($kumiteReport->winner_id === $myId);
        $isDraw = ($kumiteReport->winner_id === null);
        $myNotes = $isAka ? $kumiteReport->aka_evaluation_notes : $kumiteReport->ao_evaluation_notes;
        $oppNotes = $isAka ? $kumiteReport->ao_evaluation_notes : $kumiteReport->aka_evaluation_notes;
    @endphp

    <div class="bg-gradient-to-r from-brand-black via-gray-900 to-brand-primary dark:from-slate-950 dark:via-slate-900 dark:to-slate-950 p-6 sm:p-8 rounded-2xl text-white shadow-xl text-center relative overflow-hidden border border-slate-800/80">
        <div class="relative z-10 grid grid-cols-1 sm:grid-cols-3 items-center gap-6">
            <!-- My Position -->
            <div class="text-center sm:text-right space-y-1">
                <span class="inline-block px-3 py-0.5 rounded {{ $isAka ? 'bg-red-600' : 'bg-brand-primary' }} font-extrabold text-xs tracking-wider">
                    SAYA (SUDUT {{ $isAka ? 'AKA - MERAH' : 'AO - BIRU' }})
                </span>
                <h3 class="text-xl sm:text-2xl font-black text-white">{{ auth()->user()->name }}</h3>
                @if(($isAka && $kumiteReport->senshu_corner === 'aka') || (!$isAka && $kumiteReport->senshu_corner === 'ao'))
                    <span class="inline-block text-[10px] bg-emerald-200 text-emerald-900 px-2 py-0.5 rounded font-black">SENSHU TERMASUK</span>
                @endif
            </div>

            <!-- Score Center -->
            <div class="text-center space-y-2">
                <div class="inline-flex items-center justify-center gap-3 bg-black/60 dark:bg-slate-950/80 px-6 py-3 rounded-2xl border border-white/20 dark:border-slate-700 shadow-inner">
                    <span class="text-4xl sm:text-5xl font-black {{ $isAka ? 'text-red-500' : 'text-brand-secondary' }}">{{ $myScore }}</span>
                    <span class="text-2xl text-gray-400 font-light">:</span>
                    <span class="text-4xl sm:text-5xl font-black {{ $isAka ? 'text-brand-secondary' : 'text-red-500' }}">{{ $oppScore }}</span>
                </div>
                <div>
                    @if($isWinner)
                        <span class="inline-block px-4 py-1 rounded-full bg-emerald-500/20 border border-emerald-400 text-emerald-300 text-xs font-black uppercase tracking-wider">
                            HASIL: MENANG 🏆
                        </span>
                    @elseif($isDraw)
                        <span class="inline-block px-4 py-1 rounded-full bg-gray-500/20 border border-gray-400 text-gray-300 text-xs font-black uppercase tracking-wider">
                            HASIL: SERI (DRAW) 🤝
                        </span>
                    @else
                        <span class="inline-block px-4 py-1 rounded-full bg-red-500/20 border border-red-400 text-red-300 text-xs font-black uppercase tracking-wider">
                            HASIL: KALAH ❌
                        </span>
                    @endif
                </div>
                <div class="pt-1">
                    <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full bg-white/10 text-gray-200 text-[11px] font-mono border border-white/10">
                        ⏱️ Durasi Ronde: {{ $kumiteReport->formatted_duration }} ({{ $kumiteReport->human_duration }})
                    </span>
                </div>
            </div>

            <!-- Opponent Position -->
            <div class="text-center sm:text-left space-y-1">
                <span class="inline-block px-3 py-0.5 rounded {{ $isAka ? 'bg-brand-primary' : 'bg-red-600' }} font-extrabold text-xs tracking-wider">
                    LAWAN (SUDUT {{ $isAka ? 'AO - BIRU' : 'AKA - MERAH' }})
                </span>
                <h3 class="text-xl sm:text-2xl font-black text-white">{{ $opponent->name ?? 'Lawan' }}</h3>
                @if(($isAka && $kumiteReport->senshu_corner === 'ao') || (!$isAka && $kumiteReport->senshu_corner === 'aka'))
                    <span class="inline-block text-[10px] bg-amber-200 text-amber-900 px-2 py-0.5 rounded font-black">SENSHU LAWAN</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Personal Feedback Highlight Box -->
    <div class="bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-950/30 dark:to-teal-950/20 p-6 rounded-2xl border border-emerald-200 dark:border-emerald-800/60 shadow-xs space-y-2 transition-colors">
        <h3 class="text-xs font-extrabold text-emerald-900 dark:text-emerald-400 uppercase tracking-wider flex items-center gap-2">
            <span>💡</span> Catatan Evaluasi Khusus Senpai Untuk Anda ({{ auth()->user()->name }})
        </h3>
        <p class="text-sm text-emerald-950 dark:text-emerald-200 font-medium leading-relaxed bg-white dark:bg-slate-900 p-4 rounded-xl border border-emerald-100 dark:border-emerald-900/60">
            {{ $myNotes ?: 'Belum ada catatan tertulis khusus untuk Anda pada pertandingan ini.' }}
        </p>
    </div>

    <!-- WKF Detailed Scorecard Table -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs overflow-hidden transition-colors">
        <div class="p-5 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center">
            <h3 class="text-base font-extrabold text-slate-900 dark:text-white">Rincian Penilaian Poin & Pelanggaran Standar WKF</h3>
            <span class="text-xs text-slate-500 dark:text-slate-400 font-semibold">Penilai: Senpai {{ $kumiteReport->senpai->name ?? 'Pelatih' }}</span>
        </div>

        <div class="overflow-x-auto min-w-0">
            <table class="w-full text-center text-sm min-w-full">
                <thead class="bg-slate-50 dark:bg-slate-800/80 text-slate-800 dark:text-slate-200 text-xs uppercase font-extrabold border-b border-slate-200 dark:border-slate-700">
                    <tr>
                        <th class="py-3 px-6 text-red-700 dark:text-red-400 bg-red-50/50 dark:bg-red-950/30">AKA (MERAH) - {{ $kumiteReport->akaKohai->name }}</th>
                        <th class="py-3 px-6 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">INDIKATOR PENILAIAN WKF</th>
                        <th class="py-3 px-6 text-brand-primary dark:text-sky-400 bg-blue-50/50 dark:bg-blue-950/30">AO (BIRU) - {{ $kumiteReport->aoKohai->name }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800 font-medium">
                    <!-- Senshu -->
                    <tr class="bg-slate-50/40 dark:bg-slate-800/20">
                        <td class="py-3 px-6 font-bold bg-red-50/20 dark:bg-red-950/20">
                            {!! $kumiteReport->senshu_corner === 'aka' ? '<span class="text-red-700 dark:text-red-400 font-black">✓ SENSHU</span>' : '-' !!}
                        </td>
                        <td class="py-3 px-6 font-bold text-slate-700 dark:text-slate-300">Senshu (Keunggulan Pertama)</td>
                        <td class="py-3 px-6 font-bold bg-blue-50/20 dark:bg-blue-950/20">
                            {!! $kumiteReport->senshu_corner === 'ao' ? '<span class="text-brand-primary dark:text-sky-400 font-black">✓ SENSHU</span>' : '-' !!}
                        </td>
                    </tr>
                    <!-- IPPON -->
                    <tr>
                        <td class="py-3 px-6 font-bold text-red-600 dark:text-red-400 bg-red-50/20 dark:bg-red-950/20">{{ $kumiteReport->aka_ippon }} kali ({{ $kumiteReport->aka_ippon * 3 }} Poin)</td>
                        <td class="py-3 px-6 font-bold text-slate-700 dark:text-slate-300">IPPON (3 Poin)</td>
                        <td class="py-3 px-6 font-bold text-brand-primary dark:text-sky-400 bg-blue-50/20 dark:bg-blue-950/20">{{ $kumiteReport->ao_ippon }} kali ({{ $kumiteReport->ao_ippon * 3 }} Poin)</td>
                    </tr>
                    <!-- WAZAARI -->
                    <tr>
                        <td class="py-3 px-6 font-bold text-red-600 dark:text-red-400 bg-red-50/20 dark:bg-red-950/20">{{ $kumiteReport->aka_wazaari }} kali ({{ $kumiteReport->aka_wazaari * 2 }} Poin)</td>
                        <td class="py-3 px-6 font-bold text-slate-700 dark:text-slate-300">WAZA-ARI (2 Poin)</td>
                        <td class="py-3 px-6 font-bold text-brand-primary dark:text-sky-400 bg-blue-50/20 dark:bg-blue-950/20">{{ $kumiteReport->ao_wazaari }} kali ({{ $kumiteReport->ao_wazaari * 2 }} Poin)</td>
                    </tr>
                    <!-- YUKO -->
                    <tr>
                        <td class="py-3 px-6 font-bold text-red-600 dark:text-red-400 bg-red-50/20 dark:bg-red-950/20">{{ $kumiteReport->aka_yuko }} kali ({{ $kumiteReport->aka_yuko * 1 }} Poin)</td>
                        <td class="py-3 px-6 font-bold text-slate-700 dark:text-slate-300">YUKO (1 Poin)</td>
                        <td class="py-3 px-6 font-bold text-brand-primary dark:text-sky-400 bg-blue-50/20 dark:bg-blue-950/20">{{ $kumiteReport->ao_yuko }} kali ({{ $kumiteReport->ao_yuko * 1 }} Poin)</td>
                    </tr>
                    <!-- Poin Pelanggaran -->
                    <tr>
                        <td class="py-3 px-6 text-slate-700 dark:text-slate-300 bg-red-50/20 dark:bg-red-950/20 font-bold">
                            @if($kumiteReport->aka_fouls == 0)
                                <span class="text-xs text-emerald-600 dark:text-emerald-400 font-bold">0 (Nihil / Bersih)</span>
                            @else
                                <span class="text-xs text-red-700 dark:text-red-400 font-bold">{{ $kumiteReport->aka_fouls }} Poin Pelanggaran</span>
                            @endif
                        </td>
                        <td class="py-3 px-6 font-bold text-slate-700 dark:text-slate-300">Poin Pelanggaran WKF</td>
                        <td class="py-3 px-6 text-slate-700 dark:text-slate-300 bg-blue-50/20 dark:bg-blue-950/20 font-bold">
                            @if($kumiteReport->ao_fouls == 0)
                                <span class="text-xs text-emerald-600 dark:text-emerald-400 font-bold">0 (Nihil / Bersih)</span>
                            @else
                                <span class="text-xs text-brand-primary dark:text-sky-400 font-bold">{{ $kumiteReport->ao_fouls }} Poin Pelanggaran</span>
                            @endif
                        </td>
                    </tr>
                    <!-- Technical Evaluation -->
                    <tr class="bg-slate-50 dark:bg-slate-800/80 font-bold">
                        <td class="py-3.5 px-6 text-red-700 dark:text-red-300 bg-red-100/50 dark:bg-red-950/40">Serangan: {{ $kumiteReport->aka_score_attack }} kali | Akurasi: {{ $kumiteReport->aka_score_accuracy }}%</td>
                        <td class="py-3.5 px-6 text-slate-900 dark:text-white">EVALUASI TEKNIS SENPAI</td>
                        <td class="py-3.5 px-6 text-brand-primary dark:text-sky-300 bg-blue-100/50 dark:bg-blue-950/40">Serangan: {{ $kumiteReport->ao_score_attack }} kali | Akurasi: {{ $kumiteReport->ao_score_accuracy }}%</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Senshu History & Cancelling Log Timeline -->
    @if($kumiteReport->senshuLogs && $kumiteReport->senshuLogs->count() > 0)
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs p-6 space-y-4 transition-colors">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                <div class="flex items-center gap-2">
                    <span class="p-2 rounded-xl bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400 font-black text-sm">📜</span>
                    <div>
                        <h3 class="text-base font-extrabold text-slate-900 dark:text-white">Riwayat & Log Keputusan SENSHU (Senshu Cancelling)</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Kronologi pemberian dan pembatalan Senshu selama pertandingan berlangsung</p>
                    </div>
                </div>
                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                    {{ $kumiteReport->senshuLogs->count() }} Keputusan Dicatat
                </span>
            </div>

            <div class="relative pl-6 space-y-3 before:absolute before:left-2.5 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-200 dark:before:bg-slate-700">
                @foreach($kumiteReport->senshuLogs->sortBy('sequence') as $log)
                    <div class="relative flex items-start gap-4">
                        <div class="absolute -left-6 top-1.5 w-5 h-5 rounded-full border-2 border-white dark:border-slate-900 shadow-xs flex items-center justify-center text-[10px] font-black {{ $log->status === 'cancelled' ? 'bg-red-500 text-white' : ($log->status === 'active' ? 'bg-emerald-500 text-white' : 'bg-gray-400 text-white') }}">
                            @if($log->status === 'cancelled')
                                ✕
                            @elseif($log->status === 'active')
                                ✓
                            @else
                                -
                            @endif
                        </div>

                        <div class="flex-1 bg-slate-50 dark:bg-slate-800/50 rounded-xl p-3 border {{ $log->status === 'active' ? 'border-emerald-200 dark:border-emerald-800/60 bg-emerald-50/30 dark:bg-emerald-950/20' : ($log->status === 'cancelled' ? 'border-red-200 dark:border-red-800/60 bg-red-50/20 dark:bg-red-950/20' : 'border-slate-200 dark:border-slate-700') }}">
                            <div class="flex items-center justify-between flex-wrap gap-2 mb-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-extrabold text-slate-700 dark:text-slate-300">Tahap #{{ $log->sequence }}</span>
                                    @if($log->corner === 'aka')
                                        <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-red-100 dark:bg-red-950/50 text-red-800 dark:text-red-300 border border-red-200 dark:border-red-800/60">
                                            🔴 AKA ({{ $kumiteReport->akaKohai->name }})
                                        </span>
                                    @elseif($log->corner === 'ao')
                                        <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-blue-100 dark:bg-blue-950/50 text-blue-800 dark:text-sky-300 border border-blue-200 dark:border-blue-800/60">
                                            🔵 AO ({{ $kumiteReport->aoKohai->name }})
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300">
                                            ⚪ Tidak Ada Senshu
                                        </span>
                                    @endif
                                </div>

                                <div>
                                    @if($log->status === 'active')
                                        <span class="inline-flex items-center gap-1 text-[11px] font-extrabold text-emerald-700 dark:text-emerald-400 bg-emerald-100 dark:bg-emerald-950/50 px-2 py-0.5 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Keputusan Akhir Berlaku
                                        </span>
                                    @elseif($log->status === 'cancelled')
                                        <span class="inline-flex items-center gap-1 text-[11px] font-extrabold text-red-700 dark:text-red-400 bg-red-100 dark:bg-red-950/50 px-2 py-0.5 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Dibatalkan (Senshu Cancelled)
                                        </span>
                                    @else
                                        <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 bg-slate-200 dark:bg-slate-700 px-2 py-0.5 rounded-full">
                                            Nihil
                                        </span>
                                    @endif
                                </div>
                            </div>

                            @if($log->notes)
                                <p class="text-xs text-slate-600 dark:text-slate-300 mt-1 italic bg-white/80 dark:bg-slate-900/80 p-2 rounded border border-slate-100 dark:border-slate-800">
                                    Catatan: {{ $log->notes }}
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
