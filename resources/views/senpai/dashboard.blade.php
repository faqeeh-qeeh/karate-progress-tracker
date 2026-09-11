@extends('layouts.senpai')

@section('title', 'Dashboard Senpai')

@section('content')
<div class="space-y-6">
    <!-- Header Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-brand-primary via-blue-900 to-brand-black p-6 sm:p-8 text-white shadow-xl">
        <div class="relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-secondary/30 border border-brand-secondary/40 text-xs font-bold text-white mb-3">
                <span>🥋</span> PANEL PELATIH SENPAI
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Osu, {{ auth()->user()->name }}! 🙏</h1>
            <p class="text-gray-200 text-sm mt-1 max-w-2xl">
                Kelola materi instruksi, tinjau perkembangan teknik Kohai, serta jadwal sesi latihan Dojo Karate minggu ini.
            </p>
        </div>
        <div class="absolute -right-6 -bottom-6 w-48 h-48 bg-brand-secondary/20 rounded-full blur-2xl"></div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Kohai Binaan</p>
            <p class="text-3xl font-black text-brand-primary mt-1">{{ count($kohaiList) }} Murid</p>
            <p class="text-xs text-gray-500 mt-2">Terdaftar di Dojo Utama</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Jadwal Minggu Ini</p>
            <p class="text-3xl font-black text-brand-black mt-1">2 Sesi</p>
            <p class="text-xs text-emerald-600 font-medium mt-2">Selasa & Jumat</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Fokus Latihan</p>
            <p class="text-xl font-extrabold text-brand-secondary mt-1">Kata Heian & Kumite</p>
            <p class="text-xs text-gray-500 mt-2">Persiapan Ujian Kenaikan Sabuk</p>
        </div>
    </div>

    <!-- Grid Layout: Schedule & Kohai Oversight -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Schedule Section -->
        <div class="lg:col-span-1 bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                <h3 class="text-lg font-extrabold text-brand-black flex items-center gap-2">
                    <span>📅</span> Jadwal Mengajar
                </h3>
                <span class="text-xs bg-brand-light text-brand-primary px-2.5 py-1 rounded-full font-bold">Minggu Ini</span>
            </div>

            <div class="space-y-3">
                @foreach($schedules as $sched)
                    <div class="p-4 rounded-xl bg-gray-50 border border-gray-100 hover:border-brand-primary/30 transition">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-black text-brand-primary uppercase">{{ $sched['hari'] }}</span>
                            <span class="text-xs text-gray-500 font-mono">{{ $sched['jam'] }}</span>
                        </div>
                        <h4 class="text-sm font-bold text-brand-black mt-1">{{ $sched['materi'] }}</h4>
                        <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                            <span>📍</span> {{ $sched['lokasi'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Kohai List Section -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                <div>
                    <h3 class="text-lg font-extrabold text-brand-black">Daftar Kohai (Murid Binaan)</h3>
                    <p class="text-xs text-gray-500">Monitoring absensi dan tingkat perkembangan teknik murid</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-brand-light text-brand-black text-xs uppercase font-bold border-b border-gray-200">
                        <tr>
                            <th class="py-3 px-4">Nama Kohai</th>
                            <th class="py-3 px-4">Email</th>
                            <th class="py-3 px-4">Status Sabuk</th>
                            <th class="py-3 px-4 text-center">Aksi Pelatih</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($kohaiList as $k)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-3.5 px-4 font-bold text-brand-black flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-brand-secondary text-white flex items-center justify-center text-xs">
                                        🥋
                                    </div>
                                    {{ $k->name }}
                                </td>
                                <td class="py-3.5 px-4 text-xs text-gray-500">{{ $k->email }}</td>
                                <td class="py-3.5 px-4">
                                    <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-amber-100 text-amber-800 border border-amber-200">
                                        Sabuk Kuning (KYU 8)
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <button class="px-3 py-1 bg-brand-primary text-white text-xs font-semibold rounded-lg hover:bg-brand-primary/90 transition shadow-2xs">
                                        Nilai Teknik
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-6 text-center text-gray-400 text-sm">
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
