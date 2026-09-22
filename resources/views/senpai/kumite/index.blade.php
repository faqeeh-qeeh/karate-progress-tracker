@extends('layouts.senpai')

@section('title', 'Riwayat Raport Kumite WKF')

@section('content')
<div class="space-y-6">
    <!-- Action Header Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-slate-900 p-5 sm:p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm transition-colors duration-200">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Riwayat Raport Kumite WKF</h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">Daftar seluruh evaluasi tanding Kumite yang telah diinput dan dinilai oleh Senpai</p>
        </div>
        <a href="{{ route('senpai.kumite.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3 bg-gradient-to-r from-brand-primary to-brand-secondary hover:from-brand-primary/90 hover:to-brand-secondary/90 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md shadow-brand-primary/20 hover:shadow-lg transition-all active:scale-[0.99] whitespace-nowrap">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Input Raport Kumite Baru</span>
        </a>
    </div>

    <!-- Mobile View: Card Roster List (Shown on mobile screens < md) -->
    <div class="block md:hidden space-y-4">
        @forelse($reports as $r)
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 p-4 shadow-sm hover:shadow-md transition-all space-y-3.5">
                <!-- Card Header Info -->
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                    <div class="flex items-center gap-2">
                        <span class="p-1.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </span>
                        <div>
                            <p class="text-xs font-bold text-slate-900 dark:text-white">{{ $r->match_date->format('d M Y') }}</p>
                            <p class="text-[10px] text-slate-400 dark:text-slate-500 font-mono flex items-center gap-1.5">
                                <span>{{ $r->match_time }} WIB</span>
                                <span>•</span>
                                <span class="text-amber-700 dark:text-amber-400 font-bold">⏱️ {{ $r->formatted_duration }}</span>
                            </p>
                        </div>
                    </div>
                    <div>
                        <span class="px-2.5 py-1 inline-flex text-[11px] font-extrabold rounded-full bg-emerald-50 dark:bg-emerald-950/50 text-emerald-800 dark:text-emerald-300 border border-emerald-200/80 dark:border-emerald-800">
                            🏆 {{ $r->winner->name ?? 'N/A' }}
                        </span>
                    </div>
                </div>

                <!-- Match AKA vs AO Duel Container -->
                <div class="grid grid-cols-5 items-center gap-2 bg-slate-50/80 dark:bg-slate-950/50 p-3 rounded-xl border border-slate-100 dark:border-slate-800">
                    <!-- AKA (Red Corner) -->
                    <div class="col-span-2 space-y-1 text-left">
                        <div class="flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-red-600 shrink-0"></span>
                            <span class="text-[10px] font-bold text-red-600 dark:text-red-400 uppercase tracking-wider">AKA (Merah)</span>
                        </div>
                        <p class="text-xs font-extrabold text-slate-900 dark:text-white truncate leading-tight">{{ $r->akaKohai->name ?? 'N/A' }}</p>
                        @if($r->aka_senshu)
                            <span class="inline-block px-1.5 py-0.5 text-[8px] bg-red-100 dark:bg-red-950/60 text-red-800 dark:text-red-300 rounded font-black border border-red-200 dark:border-red-900">SENSHU</span>
                        @endif
                    </div>

                    <!-- Score Badge Center -->
                    <div class="col-span-1 text-center font-black">
                        <div class="inline-flex items-center justify-center gap-1 text-sm bg-white dark:bg-slate-900 px-2 py-1 rounded-lg border border-slate-200/80 dark:border-slate-700 shadow-xs">
                            <span class="text-red-600 dark:text-red-400">{{ $r->aka_total_score }}</span>
                            <span class="text-slate-300 dark:text-slate-600">-</span>
                            <span class="text-brand-primary dark:text-brand-secondary">{{ $r->ao_total_score }}</span>
                        </div>
                    </div>

                    <!-- AO (Blue Corner) -->
                    <div class="col-span-2 space-y-1 text-right">
                        <div class="flex items-center justify-end gap-1.5">
                            <span class="text-[10px] font-bold text-brand-primary dark:text-brand-secondary uppercase tracking-wider">AO (Biru)</span>
                            <span class="w-2.5 h-2.5 rounded-full bg-brand-primary dark:bg-brand-secondary shrink-0"></span>
                        </div>
                        <p class="text-xs font-extrabold text-slate-900 dark:text-white truncate leading-tight">{{ $r->aoKohai->name ?? 'N/A' }}</p>
                        @if($r->ao_senshu)
                            <span class="inline-block px-1.5 py-0.5 text-[8px] bg-blue-100 dark:bg-blue-950/60 text-blue-800 dark:text-blue-300 rounded font-black border border-blue-200 dark:border-blue-900">SENSHU</span>
                        @endif
                    </div>
                </div>

                <!-- Footer Action Link -->
                <a href="{{ route('senpai.kumite.show', $r->id) }}" class="w-full py-2.5 px-4 bg-brand-primary hover:bg-brand-primary/90 text-white text-xs font-bold rounded-xl transition-all shadow-xs flex items-center justify-center gap-2">
                    <span>Lihat Detail Raport</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        @empty
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-8 text-center text-slate-400 dark:text-slate-500 border border-slate-200/80 dark:border-slate-800 shadow-sm">
                <p class="text-sm font-medium">Belum ada data Raport Kumite yang dicatat.</p>
            </div>
        @endforelse

        <div class="p-2">
            {{ $reports->links() }}
        </div>
    </div>

    <!-- Desktop View: Table Format (Hidden on mobile < md) -->
    <div class="hidden md:block bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden transition-colors duration-200">
        <div class="overflow-x-auto min-w-0">
            <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300 min-w-full">
                <thead class="bg-slate-50 dark:bg-slate-950/60 text-slate-700 dark:text-slate-300 text-[11px] uppercase font-bold tracking-wider border-b border-slate-200/80 dark:border-slate-800 whitespace-nowrap">
                    <tr>
                        <th class="py-3.5 px-6">Waktu Tanding</th>
                        <th class="py-3.5 px-6">Sudut AKA (Merah)</th>
                        <th class="py-3.5 px-6 text-center">Skor Akhir WKF</th>
                        <th class="py-3.5 px-6">Sudut AO (Biru)</th>
                        <th class="py-3.5 px-6">Pemenang</th>
                        <th class="py-3.5 px-6 text-center">Detail Raport</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 whitespace-nowrap font-medium">
                    @forelse($reports as $r)
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="py-4 px-6 text-xs text-slate-600 dark:text-slate-300 font-medium">
                                <p class="font-bold text-slate-900 dark:text-white">{{ $r->match_date->format('d M Y') }}</p>
                                <p class="text-slate-400 dark:text-slate-500 font-mono flex items-center gap-1.5 mt-0.5">
                                    <span>{{ $r->match_time }} WIB</span>
                                    <span>•</span>
                                    <span class="text-amber-700 dark:text-amber-400 font-bold bg-amber-50 dark:bg-amber-950/50 px-1.5 py-0.5 rounded border border-amber-200/60 dark:border-amber-800">⏱️ {{ $r->formatted_duration }}</span>
                                </p>
                            </td>

                            <!-- AKA Kohai -->
                            <td class="py-4 px-6 font-bold text-red-700 dark:text-red-400">
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-red-600 shrink-0"></span>
                                    <span>{{ $r->akaKohai->name ?? 'N/A' }}</span>
                                    @if($r->aka_senshu)
                                        <span class="px-2 py-0.5 text-[9px] bg-red-50 dark:bg-red-950/50 text-red-800 dark:text-red-300 rounded font-black border border-red-200/80 dark:border-red-900">SENSHU</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Score Comparison -->
                            <td class="py-4 px-6 text-center font-black text-base">
                                <span class="text-red-600 dark:text-red-400 px-2.5 py-1 bg-red-50 dark:bg-red-950/50 rounded-lg border border-red-200/80 dark:border-red-900/60">{{ $r->aka_total_score }}</span>
                                <span class="text-slate-400 dark:text-slate-600 mx-1">:</span>
                                <span class="text-brand-primary dark:text-brand-secondary px-2.5 py-1 bg-blue-50 dark:bg-blue-950/50 rounded-lg border border-blue-200/80 dark:border-blue-900/60">{{ $r->ao_total_score }}</span>
                            </td>

                            <!-- AO Kohai -->
                            <td class="py-4 px-6 font-bold text-brand-primary dark:text-brand-secondary">
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-brand-primary dark:bg-brand-secondary shrink-0"></span>
                                    <span>{{ $r->aoKohai->name ?? 'N/A' }}</span>
                                    @if($r->ao_senshu)
                                        <span class="px-2 py-0.5 text-[9px] bg-blue-50 dark:bg-blue-950/50 text-blue-800 dark:text-blue-300 rounded font-black border border-blue-200/80 dark:border-blue-900">SENSHU</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Winner -->
                            <td class="py-4 px-6 text-xs">
                                <span class="px-3 py-1 inline-flex font-extrabold rounded-full bg-emerald-50 dark:bg-emerald-950/50 text-emerald-800 dark:text-emerald-300 border border-emerald-200/80 dark:border-emerald-800">
                                    🏆 {{ $r->winner->name ?? 'N/A' }}
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-6 text-center">
                                <a href="{{ route('senpai.kumite.show', $r->id) }}" class="px-3.5 py-1.5 bg-brand-primary hover:bg-brand-primary/90 text-white text-xs font-bold rounded-xl transition-all shadow-xs inline-flex items-center gap-1">
                                    <span>Lihat Detail</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400 dark:text-slate-500 text-sm font-medium">
                                Belum ada data Raport Kumite yang dicatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100 dark:border-slate-800">
            {{ $reports->links() }}
        </div>
    </div>
</div>
@endsection
