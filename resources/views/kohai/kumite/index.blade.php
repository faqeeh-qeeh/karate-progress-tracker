@extends('layouts.kohai')

@section('title', 'Riwayat Raport Kumite Saya')

@section('content')
<div class="space-y-6">
    <!-- Header Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-gray-100 shadow-xs">
        <div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand-secondary/20 text-brand-black text-xs font-bold mb-1">
                <span>🥋 RAPORT KUMITE WKF</span>
            </div>
            <h1 class="text-2xl font-extrabold text-brand-black">Riwayat Pertandingan Kumite Saya</h1>
            <p class="text-xs text-gray-500 mt-1">Pantau perolehan poin WKF, riwayat tanding, serta evaluasi instruktur Senpai</p>
        </div>
    </div>

    <!-- Kumite Reports Table -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
        <div class="overflow-x-auto min-w-0">
            <table class="w-full text-left text-sm text-gray-600 min-w-full">
                <thead class="bg-brand-light text-brand-black text-xs uppercase font-bold tracking-wider border-b border-gray-200 whitespace-nowrap">
                    <tr>
                        <th class="py-3.5 px-6">Waktu Tanding</th>
                        <th class="py-3.5 px-6">Posisi Sudut Saya</th>
                        <th class="py-3.5 px-6">Lawan Tanding</th>
                        <th class="py-3.5 px-6 text-center">Skor Akhir WKF</th>
                        <th class="py-3.5 px-6 text-center">Hasil Pertandingan</th>
                        <th class="py-3.5 px-6">Penilai (Senpai)</th>
                        <th class="py-3.5 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 whitespace-nowrap">
                    @forelse($reports as $r)
                        @php
                            $myId = auth()->id();
                            $isAka = ($r->aka_kohai_id === $myId);
                            $myScore = $isAka ? $r->aka_total_score : $r->ao_total_score;
                            $oppScore = $isAka ? $r->ao_total_score : $r->aka_total_score;
                            $opponent = $isAka ? $r->aoKohai : $r->akaKohai;
                            $isWinner = ($r->winner_id === $myId);
                            $isDraw = ($r->winner_id === null);
                        @endphp
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="py-4 px-6 text-xs text-gray-600 font-medium">
                                <p class="font-bold text-brand-black">{{ $r->match_date->format('d M Y') }}</p>
                                <p class="text-gray-400 font-mono">{{ $r->match_time }} WIB</p>
                            </td>

                            <!-- My Corner -->
                            <td class="py-4 px-6">
                                @if($isAka)
                                    <span class="px-2.5 py-1 text-xs font-black rounded-lg bg-red-100 text-red-800 border border-red-200 inline-flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-red-600"></span> AKA (Merah)
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-black rounded-lg bg-blue-100 text-brand-primary border border-blue-200 inline-flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-brand-primary"></span> AO (Biru)
                                    </span>
                                @endif
                            </td>

                            <!-- Opponent -->
                            <td class="py-4 px-6 font-bold text-brand-black">
                                {{ $opponent->name ?? 'Lawan Tanding' }}
                            </td>

                            <!-- Score -->
                            <td class="py-4 px-6 text-center font-black text-base">
                                <span class="{{ $isAka ? 'text-red-600' : 'text-brand-primary' }}">{{ $myScore }}</span>
                                <span class="text-gray-400 mx-1">:</span>
                                <span class="{{ $isAka ? 'text-brand-primary' : 'text-red-600' }}">{{ $oppScore }}</span>
                            </td>

                            <!-- Result Badge -->
                            <td class="py-4 px-6 text-center text-xs">
                                @if($isWinner)
                                    <span class="px-3 py-1 font-extrabold rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200 inline-flex items-center gap-1">
                                        🏆 Menang
                                    </span>
                                @else
                                    <span class="px-3 py-1 font-extrabold rounded-full bg-red-100 text-red-700 border border-red-200 inline-flex items-center gap-1">
                                        ❌ Kalah
                                    </span>
                                @endif
                            </td>

                            <!-- Senpai Evaluator -->
                            <td class="py-4 px-6 text-xs text-gray-600 font-semibold">
                                {{ $r->senpai->name ?? 'Senpai' }}
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-6 text-center">
                                <a href="{{ route('kohai.kumite.show', $r->id) }}" class="px-3.5 py-1.5 bg-brand-primary text-white text-xs font-bold rounded-lg hover:bg-brand-primary/90 transition shadow-2xs inline-flex items-center gap-1">
                                    <span>Lihat Raport Detail</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-gray-400 text-sm">
                                Belum ada riwayat Raport Kumite untuk Anda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-gray-100">
            {{ $reports->links() }}
        </div>
    </div>
</div>
@endsection
