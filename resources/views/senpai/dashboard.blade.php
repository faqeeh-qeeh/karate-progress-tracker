@extends('layouts.senpai')

@section('title', 'Dashboard Senpai')

@section('content')
<div class="space-y-6">
    <!-- Header Hero Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-brand-primary via-slate-900 to-slate-900 p-6 sm:p-8 text-white shadow-xl">
        <div class="relative z-10 space-y-2 sm:space-y-3">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-secondary/20 border border-brand-secondary/30 text-[11px] font-bold text-brand-secondary">
                <span>🥋</span> PANEL PELATIH SENPAI
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight leading-tight">Osu, {{ auth()->user()->name }}! 🙏</h1>
            <p class="text-slate-300 text-xs sm:text-sm max-w-2xl font-medium leading-relaxed">
                Kelola materi instruksi, tinjau perkembangan teknik Kohai, serta kelola evaluasi WKF Kumite Dojo Karate.
            </p>
        </div>
        <div class="absolute -right-8 -bottom-8 w-56 h-56 bg-brand-secondary/15 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kohai Binaan</p>
                    <p class="text-2xl sm:text-3xl font-black text-brand-primary mt-1">{{ count($kohaiList) }} Murid</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-brand-primary/10 text-brand-primary flex items-center justify-center text-xl font-bold">
                    🥋
                </div>
            </div>
            <p class="text-xs text-slate-500 font-medium mt-3">Terdaftar di Dojo Utama</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Jadwal Sesi</p>
                    <p class="text-2xl sm:text-3xl font-black text-slate-900 mt-1">2 Sesi / Mgg</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-800 flex items-center justify-center text-xl font-bold">
                    📅
                </div>
            </div>
            <p class="text-xs text-emerald-600 font-bold mt-3">Selasa & Jumat</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Fokus Latihan</p>
                    <p class="text-lg font-extrabold text-brand-secondary mt-1">Kata & Kumite</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-brand-secondary/10 text-brand-secondary flex items-center justify-center text-xl font-bold">
                    🏆
                </div>
            </div>
            <p class="text-xs text-slate-500 font-medium mt-3">Persiapan Ujian Kenaikan Sabuk</p>
        </div>
    </div>

    <!-- Grid Layout: Schedule & Kohai Roster -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Schedule Section -->
        <div class="lg:col-span-1 bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 sm:p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <h3 class="text-base font-extrabold text-slate-900 flex items-center gap-2 tracking-tight">
                    <span>📅</span> Jadwal Mengajar
                </h3>
                <span class="text-xs bg-blue-50 text-brand-primary px-3 py-1 rounded-full font-extrabold">Minggu Ini</span>
            </div>

            <div class="space-y-3">
                @foreach($schedules as $sched)
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80 hover:border-brand-primary/40 transition-all duration-200">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-black text-brand-primary uppercase tracking-wider">{{ $sched['hari'] }}</span>
                            <span class="text-xs text-slate-400 font-mono">{{ $sched['jam'] }}</span>
                        </div>
                        <h4 class="text-sm font-bold text-slate-900 mt-1">{{ $sched['materi'] }}</h4>
                        <p class="text-xs text-slate-500 mt-1 flex items-center gap-1 font-medium">
                            <span>📍</span> {{ $sched['lokasi'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Kohai List Section -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 sm:p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900 tracking-tight">Daftar Kohai (Murid Binaan)</h3>
                    <p class="text-xs text-slate-500 mt-0.5 font-medium">Monitoring absensi dan tingkat perkembangan teknik murid</p>
                </div>
                <a href="{{ route('senpai.kohai.index') }}" class="inline-flex items-center justify-center gap-1 text-xs font-bold text-brand-primary hover:text-brand-secondary transition">
                    <span>Lihat Semua</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="overflow-x-auto min-w-0">
                <table class="w-full text-left text-sm text-slate-600 min-w-full">
                    <thead class="bg-slate-50 text-slate-700 text-[11px] uppercase font-bold tracking-wider border-b border-slate-200/80 whitespace-nowrap">
                        <tr>
                            <th class="py-3 px-4">Nama Kohai</th>
                            <th class="py-3 px-4">Email</th>
                            <th class="py-3 px-4">Status Sabuk</th>
                            <th class="py-3 px-4 text-center">Aksi Pelatih</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 whitespace-nowrap font-medium">
                        @forelse($kohaiList as $k)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-3.5 px-4 font-bold text-slate-900 flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl bg-brand-primary text-white flex items-center justify-center text-xs font-extrabold shrink-0 shadow-xs">
                                        🥋
                                    </div>
                                    <span class="text-xs sm:text-sm font-bold text-slate-900">{{ $k->name }}</span>
                                </td>
                                <td class="py-3.5 px-4 text-xs text-slate-500">{{ $k->email }}</td>
                                <td class="py-3.5 px-4">
                                    <span class="px-2.5 py-1 text-xs font-extrabold rounded-full bg-amber-50 text-amber-800 border border-amber-200/80">
                                        Sabuk Kuning (KYU 8)
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <a href="{{ route('senpai.kohai.show', $k->id) }}" class="px-3.5 py-1.5 bg-brand-primary hover:bg-brand-primary/90 text-white text-xs font-bold rounded-xl transition-all shadow-xs inline-flex items-center gap-1">
                                        <span>Nilai Teknik</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-6 text-center text-slate-400 text-sm font-medium">
                                    Belum ada murid Kohai terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
