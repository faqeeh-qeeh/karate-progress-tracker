@extends('layouts.kohai')

@section('title', 'Dashboard Kohai')

@section('content')
<div class="space-y-6">
    <!-- Header Hero Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-brand-secondary via-sky-700 to-slate-900 p-6 sm:p-8 text-white shadow-xl">
        <div class="relative z-10 space-y-2 sm:space-y-3">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-[11px] font-bold text-white">
                <span>⚪</span> PANEL ANGGOTA KOHAI
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight leading-tight">Semangat Latihan, {{ auth()->user()->name }}! 🔥</h1>
            <p class="text-sky-100 text-xs sm:text-sm max-w-2xl font-medium leading-relaxed">
                Pantau perkembangan sabuk, presensi kehadiran dojo, serta target kurikulum materi Karate Anda.
            </p>
        </div>
        <div class="absolute -right-8 -bottom-8 w-56 h-56 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- Belt Progress Card -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <span class="text-xs uppercase tracking-wider font-extrabold text-brand-secondary">Peringkat Kenaikan Sabuk</span>
                <h3 class="text-xl font-black text-slate-900 tracking-tight mt-0.5">Status Tingkat: KYU 8 (Sabuk Kuning)</h3>
            </div>
            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full bg-amber-50 text-amber-800 border border-amber-200/80 text-xs font-extrabold w-max">
                🟡 Sabuk Aktif Saat Ini
            </span>
        </div>

        <!-- Progress Bar -->
        <div class="space-y-1.5">
            <div class="flex justify-between text-xs font-bold">
                <span class="text-slate-600">Progres Menuju Sabuk Hijau (KYU 7)</span>
                <span class="text-brand-primary">75% Selesai</span>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden p-0.5 border border-slate-200/60">
                <div class="bg-gradient-to-r from-brand-primary to-brand-secondary h-2 rounded-full transition-all duration-500 shadow-xs" style="width: 75%"></div>
            </div>
        </div>
    </div>

    <!-- Grid Layout: Schedule & Curriculum -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Upcoming Sessions -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 sm:p-6 space-y-4">
            <h3 class="text-base font-extrabold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3.5 tracking-tight">
                <span>🗓️</span> Jadwal Latihan Wajib
            </h3>

            <div class="space-y-3">
                @foreach($scheduleList as $s)
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80 flex items-center justify-between hover:border-brand-primary/40 transition-all duration-200">
                        <div>
                            <span class="text-xs font-black text-brand-primary uppercase tracking-wider">{{ $s['hari'] }} • {{ $s['jam'] }}</span>
                            <h4 class="text-sm font-bold text-slate-900 mt-0.5">{{ $s['materi'] }}</h4>
                        </div>
                        <span class="px-3 py-1 text-[11px] font-extrabold text-emerald-700 bg-emerald-50 rounded-lg border border-emerald-200/80">
                            Hadir
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Curriculum Mastery Checklist -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 sm:p-6 space-y-4">
            <h3 class="text-base font-extrabold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3.5 tracking-tight">
                <span>🥋</span> Kurikulum Teknik Karate (KYU 8)
            </h3>

            <div class="space-y-2.5">
                <label class="flex items-center gap-3.5 p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 cursor-pointer">
                    <input type="checkbox" checked disabled class="w-4 h-4 text-brand-primary rounded border-slate-300">
                    <div class="text-xs">
                        <p class="font-bold text-slate-900">Kihon: Oi-Zuki & Age-Uke</p>
                        <p class="text-slate-500 font-medium">Pukulan lurus & tangkisan atas (Dikuasai)</p>
                    </div>
                </label>

                <label class="flex items-center gap-3.5 p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 cursor-pointer">
                    <input type="checkbox" checked disabled class="w-4 h-4 text-brand-primary rounded border-slate-300">
                    <div class="text-xs">
                        <p class="font-bold text-slate-900">Kata: Heian Shodan</p>
                        <p class="text-slate-500 font-medium">Jurus dasar 21 gerakan (Dikuasai)</p>
                    </div>
                </label>

                <label class="flex items-center gap-3.5 p-3.5 rounded-xl bg-amber-50/60 border border-amber-200/80 cursor-pointer">
                    <input type="checkbox" disabled class="w-4 h-4 text-amber-500 rounded border-slate-300">
                    <div class="text-xs">
                        <p class="font-bold text-amber-900">Kumite: Gohon Kumite</p>
                        <p class="text-amber-700 font-medium">Pertarungan dasar 5 langkah (Dalam Proses)</p>
                    </div>
                </label>
            </div>
        </div>
    </div>
</div>
@endsection
