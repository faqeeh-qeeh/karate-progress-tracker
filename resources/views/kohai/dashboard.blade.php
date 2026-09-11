@extends('layouts.kohai')

@section('title', 'Dashboard Kohai')

@section('content')
<div class="space-y-6">
    <!-- Header Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-brand-secondary via-sky-700 to-brand-primary p-6 sm:p-8 text-white shadow-xl">
        <div class="relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-xs font-bold text-white mb-3">
                <span>⚪</span> PANEL ANGGOTA KOHAI
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Semangat Latihan, {{ auth()->user()->name }}! 🔥</h1>
            <p class="text-sky-100 text-sm mt-1 max-w-2xl">
                Pantau perkembangan sabuk, presensi kehadiran dojo, serta target kurikulum materi Karate Anda.
            </p>
        </div>
        <div class="absolute -right-6 -bottom-6 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>
    </div>

    <!-- Belt Progress Card -->
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <span class="text-xs uppercase tracking-wider font-extrabold text-brand-secondary">Peringkat Kenaikan Sabuk</span>
                <h3 class="text-xl font-black text-brand-black">Status Tingkat: KYU 8 (Sabuk Kuning)</h3>
            </div>
            <span class="inline-flex items-center px-3 py-1 rounded-full bg-amber-100 text-amber-800 border border-amber-300 text-xs font-bold w-max">
                🟡 Sabuk Aktif Saat Ini
            </span>
        </div>

        <!-- Progress Bar -->
        <div>
            <div class="flex justify-between text-xs font-bold mb-1">
                <span class="text-gray-600">Progres Menuju Sabuk Hijau (KYU 7)</span>
                <span class="text-brand-primary">75% Selesai</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden p-0.5">
                <div class="bg-gradient-to-r from-brand-primary to-brand-secondary h-2 rounded-full transition-all duration-500" style="width: 75%"></div>
            </div>
        </div>
    </div>

    <!-- Grid Layout: Presensi & Kurikulum -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Upcoming Sessions -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-4">
            <h3 class="text-lg font-extrabold text-brand-black flex items-center gap-2 border-b border-gray-100 pb-3">
                <span>🗓️</span> Jadwal Latihan Wajib
            </h3>

            <div class="space-y-3">
                @foreach($scheduleList as $s)
                    <div class="p-4 rounded-xl bg-brand-light border border-gray-200 flex items-center justify-between">
                        <div>
                            <span class="text-xs font-black text-brand-primary uppercase">{{ $s['hari'] }} • {{ $s['jam'] }}</span>
                            <h4 class="text-sm font-bold text-brand-black mt-0.5">{{ $s['materi'] }}</h4>
                        </div>
                        <span class="px-2.5 py-1 text-[11px] font-bold text-emerald-700 bg-emerald-100 rounded-lg border border-emerald-200">
                            Hadir
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Curriculum Mastery Checklist -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-4">
            <h3 class="text-lg font-extrabold text-brand-black flex items-center gap-2 border-b border-gray-100 pb-3">
                <span>🥋</span> Kurikulum Teknik Karate (KYU 8)
            </h3>

            <div class="space-y-2.5">
                <label class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 border border-gray-100 cursor-pointer">
                    <input type="checkbox" checked disabled class="w-4 h-4 text-brand-primary rounded border-gray-300">
                    <div class="text-xs">
                        <p class="font-bold text-gray-900">Kihon: Oi-Zuki & Age-Uke</p>
                        <p class="text-gray-500">Pukulan lurus & tangkisan atas (Dikuasai)</p>
                    </div>
                </label>

                <label class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 border border-gray-100 cursor-pointer">
                    <input type="checkbox" checked disabled class="w-4 h-4 text-brand-primary rounded border-gray-300">
                    <div class="text-xs">
                        <p class="font-bold text-gray-900">Kata: Heian Shodan</p>
                        <p class="text-gray-500">Jurus dasar 21 gerakan (Dikuasai)</p>
                    </div>
                </label>

                <label class="flex items-center gap-3 p-3 rounded-xl bg-amber-50/50 border border-amber-200/70 cursor-pointer">
                    <input type="checkbox" disabled class="w-4 h-4 text-amber-500 rounded border-gray-300">
                    <div class="text-xs">
                        <p class="font-bold text-amber-900">Kumite: Gohon Kumite</p>
                        <p class="text-amber-700">Pertarungan dasar 5 langkah (Dalam Proses)</p>
                    </div>
                </label>
            </div>
        </div>
    </div>
</div>
@endsection
