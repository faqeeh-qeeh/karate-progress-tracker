@extends('layouts.senpai')

@section('title', 'Daftar Kohai (Murid)')

@section('content')
<div class="space-y-6">
    <!-- Action & Search Header Bar -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-sm">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Daftar Kohai (Murid Dojo)</h1>
            <p class="text-xs text-slate-500 mt-1 font-medium">Pantau perkembangan, rekam jejak, dan analisis grafik performa Kumite seluruh murid Kohai</p>
        </div>
        
        <!-- Search Bar Form -->
        <form action="{{ route('senpai.kohai.index') }}" method="GET" class="flex items-center gap-2 w-full md:w-80">
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Cari nama / email murid..." 
                       class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white transition placeholder:text-slate-400">
            </div>
            <button type="submit" class="px-4 py-2.5 bg-slate-900 text-white text-xs font-bold rounded-xl hover:bg-slate-800 transition shadow-xs">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('senpai.kohai.index') }}" class="px-3.5 py-2.5 bg-slate-200 text-slate-700 text-xs font-bold rounded-xl hover:bg-slate-300 transition whitespace-nowrap">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Kohai Grid List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($kohais as $k)
            @php
                $totalMatches = $k->matches_as_aka_count + $k->matches_as_ao_count;
            @endphp
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between group">
                <div>
                    <!-- Header Profile Card -->
                    <div class="flex items-center gap-3.5 mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-brand-primary to-brand-secondary text-white font-extrabold text-base flex items-center justify-center shadow-md shadow-brand-primary/20 shrink-0">
                            {{ $k->initials }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="font-extrabold text-slate-900 text-base truncate group-hover:text-brand-primary transition-colors">
                                {{ $k->name }}
                            </h3>
                            <p class="text-xs text-slate-400 truncate font-medium">{{ $k->email }}</p>
                        </div>
                    </div>

                    <!-- Details & Badge -->
                    <div class="space-y-2 pt-3 border-t border-slate-100">
                        @php
                            $kp = $k->kohaiProfile;
                        @endphp
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-500 font-medium">Tingkat Sabuk:</span>
                            @if($kp?->rank?->belt)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-800 text-[11px] font-bold border border-slate-200">
                                    <span class="w-2 h-2 rounded-full border border-slate-400" style="background-color: {{ $kp->rank->belt->warna ?? '#94a3b8' }}"></span>
                                    <span>Sabuk {{ $kp->rank->belt->nama }}</span>
                                </span>
                            @else
                                <span class="text-slate-400 text-[11px] italic">Belum diatur</span>
                            @endif
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-500 font-medium">Afiliasi / Status:</span>
                            @if($kp?->type === 'non_polindra')
                                <span class="px-2 py-0.5 bg-purple-50 text-purple-700 rounded-full font-bold text-[10px] border border-purple-200/80 truncate max-w-[150px]">
                                    {{ $kp->school_origin ?? 'Luar Polindra' }}
                                </span>
                            @else
                                <span class="px-2 py-0.5 bg-blue-50 text-brand-primary rounded-full font-bold text-[10px] border border-blue-200/80 truncate max-w-[150px]">
                                    {{ $kp?->studyProgram?->nama ?? 'Polindra' }}
                                </span>
                            @endif
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-500 font-medium">Total Kumite:</span>
                            <span class="font-extrabold text-slate-900 px-2 py-0.5 bg-slate-100 rounded-lg text-xs">
                                {{ $totalMatches }} Match
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Footer Action Button -->
                <div class="mt-5 pt-4 border-t border-slate-100">
                    <a href="{{ route('senpai.kohai.show', $k->id) }}" class="w-full py-2.5 px-4 bg-slate-50 hover:bg-brand-primary hover:text-white text-brand-primary text-xs font-extrabold rounded-xl transition-all flex items-center justify-center gap-2 group-hover:bg-brand-primary group-hover:text-white shadow-2xs border border-slate-200/60">
                        <svg class="w-4 h-4 text-brand-secondary group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z"/>
                        </svg>
                        <span>Lihat Detail & Grafik Analisis</span>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl p-12 text-center text-slate-400 border border-slate-200/80 shadow-sm">
                <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <p class="text-sm font-bold text-slate-700">Tidak ditemukan akun Kohai yang sesuai.</p>
                @if(request('search'))
                    <p class="text-xs mt-1 text-slate-400 font-medium">Coba ubah kata kunci pencarian Anda.</p>
                @endif
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="pt-2">
        {{ $kohais->links() }}
    </div>
</div>
@endsection
