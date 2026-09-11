@extends('layouts.senpai')

@section('title', 'Detail Raport Kumite WKF')

@section('content')
<div class="space-y-6">
    <!-- Header Title & Back Button -->
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-gray-100 shadow-xs">
        <div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand-primary/10 text-brand-primary text-xs font-bold mb-1">
                <span>🥋 EVALUASI TANDING WKF</span>
            </div>
            <h1 class="text-2xl font-extrabold text-brand-black">Detail Raport Kumite</h1>
            <p class="text-xs text-gray-500 mt-1">
                Pertandingan tanggal {{ $kumiteReport->match_date->format('d M Y') }} • Jam {{ $kumiteReport->match_time }} WIB
            </p>
        </div>
        <a href="{{ route('senpai.kumite.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-xs font-bold rounded-xl transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Match Summary Banner -->
    <div class="bg-gradient-to-r from-brand-black via-gray-900 to-brand-primary p-6 sm:p-8 rounded-2xl text-white shadow-xl text-center relative overflow-hidden">
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
                    <span class="text-2xl text-gray-400 font-light">:</span>
                    <span class="text-4xl sm:text-5xl font-black text-brand-secondary">{{ $kumiteReport->ao_total_score }}</span>
                </div>
                <div>
                    @if($kumiteReport->winner)
                        <p class="text-xs text-emerald-400 font-bold uppercase tracking-wider">PEMENANG: {{ $kumiteReport->winner->name }} 🏆</p>
                    @else
                        <p class="text-xs text-gray-300 font-bold uppercase tracking-wider">HASIL: SERI (DRAW) 🤝</p>
                    @endif
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
    <div class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-gray-100">
            <h3 class="text-base font-extrabold text-brand-black">Rincian Perolehan Poin & Pelanggaran WKF</h3>
        </div>

        <div class="overflow-x-auto min-w-0">
            <table class="w-full text-center text-sm min-w-full">
                <thead class="bg-brand-light text-brand-black text-xs uppercase font-extrabold border-b border-gray-200">
                    <tr>
                        <th class="py-3 px-6 text-red-700 bg-red-50/50">AKA (MERAH)</th>
                        <th class="py-3 px-6 bg-gray-100">INDIKATOR PENILAIAN WKF</th>
                        <th class="py-3 px-6 text-brand-primary bg-blue-50/50">AO (BIRU)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 font-medium">
                    <tr class="bg-gray-50/40">
                        <td class="py-3 px-6 font-bold bg-red-50/20">
                            {!! $kumiteReport->senshu_corner === 'aka' ? '<span class="text-red-700 font-black">✓ SENSHU</span>' : '-' !!}
                        </td>
                        <td class="py-3 px-6 font-bold text-gray-700">Senshu (Keunggulan Pertama)</td>
                        <td class="py-3 px-6 font-bold bg-blue-50/20">
                            {!! $kumiteReport->senshu_corner === 'ao' ? '<span class="text-brand-primary font-black">✓ SENSHU</span>' : '-' !!}
                        </td>
                    </tr>
                    <tr>
                        <td class="py-3 px-6 font-bold text-red-600 bg-red-50/20">{{ $kumiteReport->aka_ippon }} ({{ $kumiteReport->aka_ippon * 3 }} Pts)</td>
                        <td class="py-3 px-6 font-bold text-gray-700">IPPON (3 Poin)</td>
                        <td class="py-3 px-6 font-bold text-brand-primary bg-blue-50/20">{{ $kumiteReport->ao_ippon }} ({{ $kumiteReport->ao_ippon * 3 }} Pts)</td>
                    </tr>
                    <tr>
                        <td class="py-3 px-6 font-bold text-red-600 bg-red-50/20">{{ $kumiteReport->aka_wazaari }} ({{ $kumiteReport->aka_wazaari * 2 }} Pts)</td>
                        <td class="py-3 px-6 font-bold text-gray-700">WAZA-ARI (2 Poin)</td>
                        <td class="py-3 px-6 font-bold text-brand-primary bg-blue-50/20">{{ $kumiteReport->ao_wazaari }} ({{ $kumiteReport->ao_wazaari * 2 }} Pts)</td>
                    </tr>
                    <tr>
                        <td class="py-3 px-6 font-bold text-red-600 bg-red-50/20">{{ $kumiteReport->aka_yuko }} ({{ $kumiteReport->aka_yuko * 1 }} Pts)</td>
                        <td class="py-3 px-6 font-bold text-gray-700">YUKO (1 Poin)</td>
                        <td class="py-3 px-6 font-bold text-brand-primary bg-blue-50/20">{{ $kumiteReport->ao_yuko }} ({{ $kumiteReport->ao_yuko * 1 }} Pts)</td>
                    </tr>
                    <tr>
                        <td class="py-3 px-6 text-gray-700 bg-red-50/20">{{ $kumiteReport->aka_c1 }} kali</td>
                        <td class="py-3 px-6 font-bold text-gray-700">Pelanggaran C1 (Category 1)</td>
                        <td class="py-3 px-6 text-gray-700 bg-blue-50/20">{{ $kumiteReport->ao_c1 }} kali</td>
                    </tr>
                    <tr>
                        <td class="py-3 px-6 text-gray-700 bg-red-50/20">{{ $kumiteReport->aka_c2 }} kali</td>
                        <td class="py-3 px-6 font-bold text-gray-700">Pelanggaran C2 (Category 2)</td>
                        <td class="py-3 px-6 text-gray-700 bg-blue-50/20">{{ $kumiteReport->ao_c2 }} kali</td>
                    </tr>
                    <tr>
                        <td class="py-3 px-6 bg-red-50/20"><span class="text-xs font-bold">{{ $kumiteReport->aka_ce ? 'Ya' : '-' }}</span></td>
                        <td class="py-3 px-6 font-bold text-gray-700">CE (Chukoku / Peringatan)</td>
                        <td class="py-3 px-6 bg-blue-50/20"><span class="text-xs font-bold">{{ $kumiteReport->ao_ce ? 'Ya' : '-' }}</span></td>
                    </tr>
                    <tr>
                        <td class="py-3 px-6 bg-red-50/20"><span class="text-xs font-bold">{{ $kumiteReport->aka_hc ? 'Ya' : '-' }}</span></td>
                        <td class="py-3 px-6 font-bold text-gray-700">HC (Hansoku Chui)</td>
                        <td class="py-3 px-6 bg-blue-50/20"><span class="text-xs font-bold">{{ $kumiteReport->ao_hc ? 'Ya' : '-' }}</span></td>
                    </tr>
                    <tr>
                        <td class="py-3 px-6 bg-red-50/20"><span class="text-xs font-extrabold text-red-700">{{ $kumiteReport->aka_h ? 'Diskualifikasi' : '-' }}</span></td>
                        <td class="py-3 px-6 font-bold text-gray-700">H (Hansoku / Pelanggaran Berat)</td>
                        <td class="py-3 px-6 bg-blue-50/20"><span class="text-xs font-extrabold text-red-700">{{ $kumiteReport->ao_h ? 'Diskualifikasi' : '-' }}</span></td>
                    </tr>
                    <tr class="bg-gray-50 font-bold">
                        <td class="py-3.5 px-6 text-red-700 bg-red-100/50">Serangan: {{ $kumiteReport->aka_score_attack }}/10 | Akurasi: {{ $kumiteReport->aka_score_accuracy }}/10</td>
                        <td class="py-3.5 px-6 text-brand-black">EVALUASI TEKNIS SENPAI</td>
                        <td class="py-3.5 px-6 text-brand-primary bg-blue-100/50">Serangan: {{ $kumiteReport->ao_score_attack }}/10 | Akurasi: {{ $kumiteReport->ao_score_accuracy }}/10</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Separate Evaluation Notes Cards for AKA & AO -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- AKA Notes -->
        <div class="bg-white p-6 rounded-2xl border border-red-200 shadow-xs space-y-3">
            <h3 class="text-sm font-extrabold text-red-800 uppercase tracking-wider flex items-center gap-2 border-b border-red-100 pb-2">
                <span>📝</span> Catatan Evaluasi AKA ({{ $kumiteReport->akaKohai->name }})
            </h3>
            <p class="text-xs sm:text-sm text-gray-800 bg-red-50/50 p-4 rounded-xl border border-red-100 leading-relaxed font-medium">
                {{ $kumiteReport->aka_evaluation_notes ?: 'Tidak ada catatan evaluasi tertulis untuk Kohai AKA.' }}
            </p>
        </div>

        <!-- AO Notes -->
        <div class="bg-white p-6 rounded-2xl border border-blue-200 shadow-xs space-y-3">
            <h3 class="text-sm font-extrabold text-brand-primary uppercase tracking-wider flex items-center gap-2 border-b border-blue-100 pb-2">
                <span>📝</span> Catatan Evaluasi AO ({{ $kumiteReport->aoKohai->name }})
            </h3>
            <p class="text-xs sm:text-sm text-gray-800 bg-blue-50/50 p-4 rounded-xl border border-blue-100 leading-relaxed font-medium">
                {{ $kumiteReport->ao_evaluation_notes ?: 'Tidak ada catatan evaluasi tertulis untuk Kohai AO.' }}
            </p>
        </div>
    </div>
</div>
@endsection
