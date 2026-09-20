@extends('layouts.kohai')

@section('title', 'Riwayat Raport Kumite Saya')

@section('content')
<div class="space-y-6">
    <!-- Header Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-sm">
        <div>
            {{-- <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand-secondary/15 text-brand-black text-xs font-bold mb-1 border border-brand-secondary/30">
                <span>🥋 RAPORT KUMITE WKF</span>
            </div> --}}
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Riwayat Pertandingan Kumite Saya</h1>
            <p class="text-xs text-slate-500 mt-1 font-medium">Pantau perolehan poin WKF, riwayat tanding, serta evaluasi instruktur Senpai</p>
        </div>
    </div>

    <!-- Mobile View: Card Match List (Shown on mobile screens < md) -->
    <div class="block md:hidden space-y-4">
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
            <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm hover:shadow-md transition-all space-y-3.5">
                <!-- Header Card Info -->
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div class="flex items-center gap-2">
                        <span class="p-1.5 rounded-lg bg-slate-100 text-slate-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </span>
                        <div>
                            <p class="text-xs font-bold text-slate-900">{{ $r->match_date->format('d M Y') }}</p>
                            <p class="text-[10px] text-slate-400 font-mono flex items-center gap-1.5">
                                <span>{{ $r->match_time }} WIB</span>
                                <span>•</span>
                                <span class="text-amber-700 font-bold">⏱️ {{ $r->formatted_duration }}</span>
                            </p>
                        </div>
                    </div>
                    <div>
                        @if($isWinner)
                            <span class="px-2.5 py-1 inline-flex text-[11px] font-extrabold rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200/80">
                                🏆 Menang
                            </span>
                        @else
                            <span class="px-2.5 py-1 inline-flex text-[11px] font-extrabold rounded-full bg-red-50 text-red-700 border border-red-200/80">
                                ❌ Kalah
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Match Detail Box -->
                <div class="grid grid-cols-5 items-center gap-2 bg-slate-50/80 p-3 rounded-xl border border-slate-100">
                    <!-- My Side -->
                    <div class="col-span-2 space-y-1 text-left">
                        <div class="flex items-center gap-1.5">
                            @if($isAka)
                                <span class="w-2.5 h-2.5 rounded-full bg-red-600 shrink-0"></span>
                                <span class="text-[10px] font-bold text-red-600 uppercase">AKA (Merah)</span>
                            @else
                                <span class="w-2.5 h-2.5 rounded-full bg-brand-primary shrink-0"></span>
                                <span class="text-[10px] font-bold text-brand-primary uppercase">AO (Biru)</span>
                            @endif
                        </div>
                        <p class="text-xs font-extrabold text-slate-900 leading-tight">Saya</p>
                    </div>

                    <!-- Score Center -->
                    <div class="col-span-1 text-center font-black">
                        <div class="inline-flex items-center justify-center gap-1 text-sm bg-white px-2.5 py-1 rounded-lg border border-slate-200/80 shadow-xs">
                            <span class="{{ $isAka ? 'text-red-600' : 'text-brand-primary' }}">{{ $myScore }}</span>
                            <span class="text-slate-300">-</span>
                            <span class="{{ $isAka ? 'text-brand-primary' : 'text-red-600' }}">{{ $oppScore }}</span>
                        </div>
                    </div>

                    <!-- Opponent Side -->
                    <div class="col-span-2 space-y-1 text-right">
                        <div class="flex items-center justify-end gap-1.5">
                            @if($isAka)
                                <span class="text-[10px] font-bold text-brand-primary uppercase">AO (Biru)</span>
                                <span class="w-2.5 h-2.5 rounded-full bg-brand-primary shrink-0"></span>
                            @else
                                <span class="text-[10px] font-bold text-red-600 uppercase">AKA (Merah)</span>
                                <span class="w-2.5 h-2.5 rounded-full bg-red-600 shrink-0"></span>
                            @endif
                        </div>
                        <p class="text-xs font-extrabold text-slate-900 truncate leading-tight">{{ $opponent->name ?? 'Lawan Tanding' }}</p>
                    </div>
                </div>

                <!-- Instructor Note Footer -->
                <div class="flex items-center justify-between text-xs text-slate-500 font-medium pt-1">
                    <span>Penilai: <strong class="text-slate-800">{{ $r->senpai->name ?? 'Senpai' }}</strong></span>
                </div>

                <!-- Footer Action Button -->
                <a href="{{ route('kohai.kumite.show', $r->id) }}" class="w-full py-2.5 px-4 bg-brand-primary hover:bg-brand-primary/90 text-white text-xs font-bold rounded-xl transition-all shadow-xs flex items-center justify-center gap-2">
                    <span>Lihat Raport Detail</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        @empty
            <div class="bg-white rounded-2xl p-8 text-center text-slate-400 border border-slate-200/80 shadow-sm">
                <p class="text-sm font-medium">Belum ada riwayat Raport Kumite untuk Anda.</p>
            </div>
        @endforelse

        <div class="p-2">
            {{ $reports->links() }}
        </div>
    </div>

    <!-- Desktop View: Table Format (Hidden on mobile < md) -->
    <div class="hidden md:block bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto min-w-0">
            <table class="w-full text-left text-sm text-slate-600 min-w-full">
                <thead class="bg-slate-50 text-slate-700 text-[11px] uppercase font-bold tracking-wider border-b border-slate-200/80 whitespace-nowrap">
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
                <tbody class="divide-y divide-slate-100 whitespace-nowrap font-medium">
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
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-6 text-xs text-slate-600 font-medium">
                                <p class="font-bold text-slate-900">{{ $r->match_date->format('d M Y') }}</p>
                                <p class="text-slate-400 font-mono flex items-center gap-1.5 mt-0.5">
                                    <span>{{ $r->match_time }} WIB</span>
                                    <span>•</span>
                                    <span class="text-amber-700 font-bold bg-amber-50 px-1.5 py-0.5 rounded border border-amber-200/60">⏱️ {{ $r->formatted_duration }}</span>
                                </p>
                            </td>

                            <!-- My Corner -->
                            <td class="py-4 px-6">
                                @if($isAka)
                                    <span class="px-2.5 py-1 text-xs font-black rounded-lg bg-red-50 text-red-800 border border-red-200/80 inline-flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-red-600"></span> AKA (Merah)
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-black rounded-lg bg-blue-50 text-brand-primary border border-blue-200/80 inline-flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-brand-primary"></span> AO (Biru)
                                    </span>
                                @endif
                            </td>

                            <!-- Opponent -->
                            <td class="py-4 px-6 font-bold text-slate-900">
                                {{ $opponent->name ?? 'Lawan Tanding' }}
                            </td>

                            <!-- Score -->
                            <td class="py-4 px-6 text-center font-black text-base">
                                <span class="{{ $isAka ? 'text-red-600' : 'text-brand-primary' }}">{{ $myScore }}</span>
                                <span class="text-slate-300 mx-1">:</span>
                                <span class="{{ $isAka ? 'text-brand-primary' : 'text-red-600' }}">{{ $oppScore }}</span>
                            </td>

                            <!-- Result Badge -->
                            <td class="py-4 px-6 text-center text-xs">
                                @if($isWinner)
                                    <span class="px-3 py-1 font-extrabold rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200/80 inline-flex items-center gap-1">
                                        🏆 Menang
                                    </span>
                                @else
                                    <span class="px-3 py-1 font-extrabold rounded-full bg-red-50 text-red-700 border border-red-200/80 inline-flex items-center gap-1">
                                        ❌ Kalah
                                    </span>
                                @endif
                            </td>

                            <!-- Senpai Evaluator -->
                            <td class="py-4 px-6 text-xs text-slate-600 font-medium">
                                {{ $r->senpai->name ?? 'Senpai' }}
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-6 text-center">
                                <a href="{{ route('kohai.kumite.show', $r->id) }}" class="px-3.5 py-1.5 bg-brand-primary hover:bg-brand-primary/90 text-white text-xs font-bold rounded-xl transition-all shadow-xs inline-flex items-center gap-1">
                                    <span>Lihat Raport Detail</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400 text-sm font-medium">
                                Belum ada riwayat Raport Kumite untuk Anda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $reports->links() }}
        </div>
    </div>
</div>
@endsection
