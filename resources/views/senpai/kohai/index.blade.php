@extends('layouts.senpai')

@section('title', 'Daftar Kohai (Murid)')

@section('content')
<div class="space-y-6">
    <!-- Action & Search Header Bar -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-gray-100 shadow-xs">
        <div>
            <h1 class="text-2xl font-extrabold text-brand-black">Daftar Kohai (Murid Dojo)</h1>
            <p class="text-xs text-gray-500 mt-1">Pantau perkembangan, rekam jejak, dan analisis grafik performa Kumite seluruh murid Kohai</p>
        </div>
        
        <!-- Search Bar Form -->
        <form action="{{ route('senpai.kohai.index') }}" method="GET" class="flex items-center gap-2 w-full md:w-80">
            <div class="relative w-full">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Cari nama / email murid..." 
                       class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs text-brand-black focus:outline-none focus:border-brand-primary focus:bg-white transition">
                <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <button type="submit" class="px-4 py-2 bg-brand-primary text-white text-xs font-bold rounded-xl hover:bg-brand-primary/90 transition shadow-xs">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('senpai.kohai.index') }}" class="px-3 py-2 bg-gray-100 text-gray-600 text-xs font-semibold rounded-xl hover:bg-gray-200 transition">
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
            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-xs hover:shadow-md transition flex flex-col justify-between group">
                <div>
                    <!-- Header Profile Card -->
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-brand-primary to-brand-secondary text-white font-extrabold text-base flex items-center justify-center shadow-md shrink-0">
                            {{ strtoupper(substr($k->name, 0, 2)) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="font-extrabold text-brand-black text-base truncate group-hover:text-brand-primary transition">
                                {{ $k->name }}
                            </h3>
                            <p class="text-xs text-gray-400 truncate">{{ $k->email }}</p>
                        </div>
                    </div>

                    <!-- Details & Badge -->
                    <div class="space-y-2 pt-2 border-t border-gray-50">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-gray-500 font-medium">Role Pangkat:</span>
                            <span class="px-2.5 py-0.5 bg-amber-100 text-amber-800 rounded-full font-bold text-[10px] uppercase border border-amber-200">
                                🥋 {{ $k->role->nama ?? 'Kohai' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-gray-500 font-medium">Total Pertandingan Kumite:</span>
                            <span class="font-extrabold text-brand-black px-2 py-0.5 bg-gray-100 rounded-md">
                                {{ $totalMatches }} Match
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Footer Action Button -->
                <div class="mt-5 pt-4 border-t border-gray-100">
                    <a href="{{ route('senpai.kohai.show', $k->id) }}" class="w-full py-2.5 px-4 bg-brand-light hover:bg-brand-primary hover:text-white text-brand-primary text-xs font-extrabold rounded-xl transition flex items-center justify-center gap-2 group-hover:bg-brand-primary group-hover:text-white shadow-2xs">
                        <svg class="w-4 h-4 text-brand-secondary group-hover:text-brand-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z"/>
                        </svg>
                        <span>Lihat Detail & Grafik Analisis</span>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl p-12 text-center text-gray-400 border border-gray-100 shadow-xs">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <p class="text-sm font-semibold">Tidak ditemukan akun Kohai yang sesuai.</p>
                @if(request('search'))
                    <p class="text-xs mt-1 text-gray-400">Coba ubah kata kunci pencarian Anda.</p>
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
