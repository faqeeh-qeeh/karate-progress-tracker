@extends('layouts.kohai')

@section('title', 'Detail Raport Kumite Saya')

@section('content')
<div class="space-y-6">
    <!-- Header Title & Back Button -->
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-gray-100 shadow-xs">
        <div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand-secondary/20 text-brand-black text-xs font-bold mb-1">
                <span>🥋 RAPORT EVALUASI KUMITE WKF</span>
            </div>
            <h1 class="text-2xl font-extrabold text-brand-black">Rincian Raport Tanding Saya</h1>
            <p class="text-xs text-gray-500 mt-1">
                Diuji oleh Senpai {{ $kumiteReport->senpai->name ?? 'Senpai' }} • {{ $kumiteReport->match_date->format('d M Y') }} ({{ $kumiteReport->match_time }} WIB)
            </p>
        </div>
        <a href="{{ route('kohai.kumite.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-xs font-bold rounded-xl transition">
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

    <div class="bg-gradient-to-r from-brand-black via-gray-900 to-brand-primary p-6 sm:p-8 rounded-2xl text-white shadow-xl text-center relative overflow-hidden">
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
                <div class="inline-flex items-center justify-center gap-3 bg-black/60 px-6 py-3 rounded-2xl border border-white/20 shadow-inner">
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
    <div class="bg-gradient-to-r from-emerald-50 to-teal-50 p-6 rounded-2xl border border-emerald-200 shadow-xs space-y-2">
        <h3 class="text-xs font-extrabold text-emerald-900 uppercase tracking-wider flex items-center gap-2">
            <span>💡</span> Catatan Evaluasi Khusus Senpai Untuk Anda ({{ auth()->user()->name }})
        </h3>
        <p class="text-sm text-emerald-950 font-medium leading-relaxed bg-white p-4 rounded-xl border border-emerald-100">
            {{ $myNotes ?: 'Belum ada catatan tertulis khusus untuk Anda pada pertandingan ini.' }}
        </p>
    </div>

    <!-- WKF Detailed Scorecard Table -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-base font-extrabold text-brand-black">Rincian Penilaian Poin & Pelanggaran Standar WKF</h3>
            <span class="text-xs text-gray-500 font-semibold">Penilai: Senpai {{ $kumiteReport->senpai->name ?? 'Pelatih' }}</span>
        </div>

        <div class="overflow-x-auto min-w-0">
            <table class="w-full text-center text-sm min-w-full">
                <thead class="bg-brand-light text-brand-black text-xs uppercase font-extrabold border-b border-gray-200">
                    <tr>
                        <th class="py-3 px-6 text-red-700 bg-red-50/50">AKA (MERAH) - {{ $kumiteReport->akaKohai->name }}</th>
                        <th class="py-3 px-6 bg-gray-100">INDIKATOR PENILAIAN WKF</th>
                        <th class="py-3 px-6 text-brand-primary bg-blue-50/50">AO (BIRU) - {{ $kumiteReport->aoKohai->name }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 font-medium">
                    <!-- Senshu -->
                    <tr class="bg-gray-50/40">
                        <td class="py-3 px-6 font-bold bg-red-50/20">
                            {!! $kumiteReport->senshu_corner === 'aka' ? '<span class="text-red-700 font-black">✓ SENSHU</span>' : '-' !!}
                        </td>
                        <td class="py-3 px-6 font-bold text-gray-700">Senshu (Keunggulan Pertama)</td>
                        <td class="py-3 px-6 font-bold bg-blue-50/20">
                            {!! $kumiteReport->senshu_corner === 'ao' ? '<span class="text-brand-primary font-black">✓ SENSHU</span>' : '-' !!}
                        </td>
                    </tr>
                    <!-- IPPON -->
                    <tr>
                        <td class="py-3 px-6 font-bold text-red-600 bg-red-50/20">{{ $kumiteReport->aka_ippon }} kali ({{ $kumiteReport->aka_ippon * 3 }} Poin)</td>
                        <td class="py-3 px-6 font-bold text-gray-700">IPPON (3 Poin)</td>
                        <td class="py-3 px-6 font-bold text-brand-primary bg-blue-50/20">{{ $kumiteReport->ao_ippon }} kali ({{ $kumiteReport->ao_ippon * 3 }} Poin)</td>
                    </tr>
                    <!-- WAZAARI -->
                    <tr>
                        <td class="py-3 px-6 font-bold text-red-600 bg-red-50/20">{{ $kumiteReport->aka_wazaari }} kali ({{ $kumiteReport->aka_wazaari * 2 }} Poin)</td>
                        <td class="py-3 px-6 font-bold text-gray-700">WAZA-ARI (2 Poin)</td>
                        <td class="py-3 px-6 font-bold text-brand-primary bg-blue-50/20">{{ $kumiteReport->ao_wazaari }} kali ({{ $kumiteReport->ao_wazaari * 2 }} Poin)</td>
                    </tr>
                    <!-- YUKO -->
                    <tr>
                        <td class="py-3 px-6 font-bold text-red-600 bg-red-50/20">{{ $kumiteReport->aka_yuko }} kali ({{ $kumiteReport->aka_yuko * 1 }} Poin)</td>
                        <td class="py-3 px-6 font-bold text-gray-700">YUKO (1 Poin)</td>
                        <td class="py-3 px-6 font-bold text-brand-primary bg-blue-50/20">{{ $kumiteReport->ao_yuko }} kali ({{ $kumiteReport->ao_yuko * 1 }} Poin)</td>
                    </tr>
                    <!-- C1 -->
                    <tr>
                        <td class="py-3 px-6 text-gray-700 bg-red-50/20">{{ $kumiteReport->aka_c1 }} kali</td>
                        <td class="py-3 px-6 font-bold text-gray-700">Pelanggaran C1 (Kontak Berlebihan)</td>
                        <td class="py-3 px-6 text-gray-700 bg-blue-50/20">{{ $kumiteReport->ao_c1 }} kali</td>
                    </tr>
                    <!-- C2 -->
                    <tr>
                        <td class="py-3 px-6 text-gray-700 bg-red-50/20">{{ $kumiteReport->aka_c2 }} kali</td>
                        <td class="py-3 px-6 font-bold text-gray-700">Pelanggaran C2 (Keluar Arena / Pasif)</td>
                        <td class="py-3 px-6 text-gray-700 bg-blue-50/20">{{ $kumiteReport->ao_c2 }} kali</td>
                    </tr>
                    <!-- Warnings CE, HC, H -->
                    <tr>
                        <td class="py-3 px-6 bg-red-50/20 text-xs"><span class="font-bold">{{ $kumiteReport->aka_ce ? 'CE (Chukoku)' : '-' }}</span></td>
                        <td class="py-3 px-6 font-bold text-gray-700">Peringatan Chukoku (CE)</td>
                        <td class="py-3 px-6 bg-blue-50/20 text-xs"><span class="font-bold">{{ $kumiteReport->ao_ce ? 'CE (Chukoku)' : '-' }}</span></td>
                    </tr>
                    <tr>
                        <td class="py-3 px-6 bg-red-50/20 text-xs"><span class="font-bold">{{ $kumiteReport->aka_hc ? 'HC (Hansoku Chui)' : '-' }}</span></td>
                        <td class="py-3 px-6 font-bold text-gray-700">Peringatan Hansoku Chui (HC)</td>
                        <td class="py-3 px-6 bg-blue-50/20 text-xs"><span class="font-bold">{{ $kumiteReport->ao_hc ? 'HC (Hansoku Chui)' : '-' }}</span></td>
                    </tr>
                    <tr>
                        <td class="py-3 px-6 bg-red-50/20 text-xs"><span class="font-black text-red-700">{{ $kumiteReport->aka_h ? 'DISKUALIFIKASI (H)' : '-' }}</span></td>
                        <td class="py-3 px-6 font-bold text-gray-700">H (Hansoku / Diskualifikasi)</td>
                        <td class="py-3 px-6 bg-blue-50/20 text-xs"><span class="font-black text-red-700">{{ $kumiteReport->ao_h ? 'DISKUALIFIKASI (H)' : '-' }}</span></td>
                    </tr>
                    <!-- Technical Evaluation -->
                    <tr class="bg-gray-50 font-bold">
                        <td class="py-3.5 px-6 text-red-700 bg-red-100/50">Serangan: {{ $kumiteReport->aka_score_attack }}/10 | Akurasi: {{ $kumiteReport->aka_score_accuracy }}/10</td>
                        <td class="py-3.5 px-6 text-brand-black">EVALUASI TEKNIS SENPAI (1-10)</td>
                        <td class="py-3.5 px-6 text-brand-primary bg-blue-100/50">Serangan: {{ $kumiteReport->ao_score_attack }}/10 | Akurasi: {{ $kumiteReport->ao_score_accuracy }}/10</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
