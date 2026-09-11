@extends('layouts.senpai')

@section('title', 'Riwayat Raport Kumite WKF')

@section('content')
<div class="space-y-6">
    <!-- Action Header Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-gray-100 shadow-xs">
        <div>
            <h1 class="text-2xl font-extrabold text-brand-black">Riwayat Raport Kumite WKF</h1>
            <p class="text-xs text-gray-500 mt-1">Daftar seluruh evaluasi tanding Kumite yang telah diinput dan dinilai oleh Senpai</p>
        </div>
        <a href="{{ route('senpai.kumite.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-brand-primary hover:bg-brand-primary/90 text-white font-bold text-sm rounded-xl shadow-md transition">
            <svg class="w-5 h-5 text-brand-secondary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Input Raport Kumite Baru</span>
        </a>
    </div>

    <!-- Kumite Reports Table -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
        <div class="overflow-x-auto min-w-0">
            <table class="w-full text-left text-sm text-gray-600 min-w-full">
                <thead class="bg-brand-light text-brand-black text-xs uppercase font-bold tracking-wider border-b border-gray-200 whitespace-nowrap">
                    <tr>
                        <th class="py-3.5 px-6">Waktu Tanding</th>
                        <th class="py-3.5 px-6">Sudut AKA (Merah)</th>
                        <th class="py-3.5 px-6 text-center">Skor Akhir WKF</th>
                        <th class="py-3.5 px-6">Sudut AO (Biru)</th>
                        <th class="py-3.5 px-6">Pemenang</th>
                        <th class="py-3.5 px-6 text-center">Detail Raport</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 whitespace-nowrap">
                    @forelse($reports as $r)
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="py-4 px-6 text-xs text-gray-600 font-medium">
                                <p class="font-bold text-brand-black">{{ $r->match_date->format('d M Y') }}</p>
                                <p class="text-gray-400 font-mono">{{ $r->match_time }} WIB</p>
                            </td>

                            <!-- AKA Kohai -->
                            <td class="py-4 px-6 font-bold text-red-700">
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-red-600 shrink-0"></span>
                                    <span>{{ $r->akaKohai->name ?? 'N/A' }}</span>
                                    @if($r->aka_senshu)
                                        <span class="px-1.5 py-0.5 text-[9px] bg-red-100 text-red-800 rounded font-black border border-red-200">SENSHU</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Score Comparison -->
                            <td class="py-4 px-6 text-center font-black text-base">
                                <span class="text-red-600 px-2 py-1 bg-red-50 rounded-lg border border-red-200">{{ $r->aka_total_score }}</span>
                                <span class="text-gray-400 mx-1">:</span>
                                <span class="text-brand-primary px-2 py-1 bg-blue-50 rounded-lg border border-blue-200">{{ $r->ao_total_score }}</span>
                            </td>

                            <!-- AO Kohai -->
                            <td class="py-4 px-6 font-bold text-brand-primary">
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-brand-primary shrink-0"></span>
                                    <span>{{ $r->aoKohai->name ?? 'N/A' }}</span>
                                    @if($r->ao_senshu)
                                        <span class="px-1.5 py-0.5 text-[9px] bg-blue-100 text-blue-800 rounded font-black border border-blue-200">SENSHU</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Winner -->
                            <td class="py-4 px-6 text-xs">
                                <span class="px-3 py-1 inline-flex font-extrabold rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    🏆 {{ $r->winner->name ?? 'N/A' }}
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-6 text-center">
                                <a href="{{ route('senpai.kumite.show', $r->id) }}" class="px-3 py-1.5 bg-brand-primary text-white text-xs font-bold rounded-lg hover:bg-brand-primary/90 transition shadow-2xs inline-flex items-center gap-1">
                                    <span>Lihat Detail</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-gray-400 text-sm">
                                Belum ada data Raport Kumite yang dicatat.
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
