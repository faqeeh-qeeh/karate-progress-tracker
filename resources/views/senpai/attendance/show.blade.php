@extends('layouts.senpai')

@section('title', 'Detail Sesi Absensi')

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb & Navigation -->
    <div class="flex items-center justify-between">
        <a href="{{ route('senpai.attendance.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 dark:text-slate-400 hover:text-brand-primary dark:hover:text-brand-secondary transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali ke Absensi QR</span>
        </a>
    </div>

    <!-- Session Detail Card Header -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 p-6 sm:p-8 shadow-sm space-y-4 transition-colors duration-200">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 dark:border-slate-800 pb-4">
            <div>
                <span class="text-xs uppercase tracking-wider font-extrabold text-brand-primary dark:text-brand-secondary">Laporan Presensi Dojo</span>
                <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight mt-0.5">{{ $attendanceSession->title }}</h1>
            </div>
            <span class="px-3.5 py-1.5 rounded-full text-xs font-bold w-max {{ $attendanceSession->is_active ? 'bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700' }}">
                Status: {{ $attendanceSession->is_active ? 'Aktif (Sedang Berjalan)' : 'Selesai / Ditutup' }}
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs font-medium">
            <div class="p-4 bg-slate-50 dark:bg-slate-950/50 rounded-2xl border border-slate-200/80 dark:border-slate-800">
                <span class="text-slate-400 dark:text-slate-500 block font-bold uppercase text-[10px]">Tanggal Pelaksanaan</span>
                <span class="text-sm font-bold text-slate-800 dark:text-slate-200 mt-1 block">{{ \Carbon\Carbon::parse($attendanceSession->date)->format('d F Y') }}</span>
            </div>
            <div class="p-4 bg-slate-50 dark:bg-slate-950/50 rounded-2xl border border-slate-200/80 dark:border-slate-800">
                <span class="text-slate-400 dark:text-slate-500 block font-bold uppercase text-[10px]">Pelatih / Senpai Penanggungjawab</span>
                <span class="text-sm font-bold text-slate-800 dark:text-slate-200 mt-1 block">{{ $attendanceSession->senpai->name }} (ID #{{ $attendanceSession->senpai_id }})</span>
            </div>
            <div class="p-4 bg-slate-50 dark:bg-slate-950/50 rounded-2xl border border-slate-200/80 dark:border-slate-800">
                <span class="text-slate-400 dark:text-slate-500 block font-bold uppercase text-[10px]">Total Kohai Hadir</span>
                <span class="text-sm font-bold text-brand-primary dark:text-brand-secondary mt-1 block">{{ count($attendanceSession->attendances) }} Murid Terdaftar</span>
            </div>
        </div>
    </div>

    <!-- Attendee List Table -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 p-6 shadow-sm space-y-4 transition-colors duration-200">
        <h3 class="text-base font-extrabold text-slate-900 dark:text-white flex items-center gap-2 border-b border-slate-100 dark:border-slate-800 pb-4">
            <span>📋</span> Daftar Presensi Kohai
        </h3>

        <!-- Mobile View: Card Roster List (Shown on mobile screens < md) -->
        <div class="block md:hidden space-y-3">
            @forelse($attendanceSession->attendances as $index => $att)
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 p-4 shadow-sm flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-9 h-9 rounded-xl bg-brand-primary text-white flex items-center justify-center text-sm font-bold shrink-0">
                            🥋
                        </div>
                        <div class="min-w-0 space-y-0.5">
                            <p class="text-xs font-bold text-slate-900 dark:text-white truncate">{{ $att->kohai->name }}</p>
                            <p class="text-[10px] text-slate-400 dark:text-slate-500 truncate">{{ $att->kohai->email }}</p>
                            <p class="text-[10px] font-mono text-slate-500 dark:text-slate-400">
                                {{ \Carbon\Carbon::parse($att->scanned_at)->setTimezone('Asia/Jakarta')->format('H:i:s - d M Y') }}
                            </p>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 text-[11px] font-extrabold rounded-full bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 shrink-0">
                        {{ $att->status }}
                    </span>
                </div>
            @empty
                <div class="py-8 text-center text-slate-400 dark:text-slate-500 text-xs font-medium">
                    Tidak ada Kohai yang tercatat pada sesi absensi ini.
                </div>
            @endforelse
        </div>

        <!-- Desktop View: Table Format (Hidden on mobile < md) -->
        <div class="hidden md:block">
            <div class="overflow-x-auto min-w-0 border border-slate-200/80 dark:border-slate-800 rounded-2xl">
                <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                    <thead class="bg-slate-50 dark:bg-slate-950/60 text-slate-700 dark:text-slate-300 text-[11px] uppercase font-bold tracking-wider border-b border-slate-200/80 dark:border-slate-800 whitespace-nowrap">
                        <tr>
                            <th class="py-3 px-4">#</th>
                            <th class="py-3 px-4">Nama Kohai</th>
                            <th class="py-3 px-4">Email</th>
                            <th class="py-3 px-4">Waktu Scan Absen</th>
                            <th class="py-3 px-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 whitespace-nowrap font-medium">
                        @forelse($attendanceSession->attendances as $index => $att)
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors">
                                <td class="py-3.5 px-4 text-xs font-bold text-slate-400 dark:text-slate-500">{{ $index + 1 }}</td>
                                <td class="py-3.5 px-4 font-bold text-slate-900 dark:text-white flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-lg bg-brand-primary text-white flex items-center justify-center text-xs font-bold shrink-0">
                                        🥋
                                    </div>
                                    <span>{{ $att->kohai->name }}</span>
                                </td>
                                <td class="py-3.5 px-4 text-xs text-slate-500 dark:text-slate-400">{{ $att->kohai->email }}</td>
                                <td class="py-3.5 px-4 text-xs font-mono text-slate-700 dark:text-slate-300">
                                    {{ \Carbon\Carbon::parse($att->scanned_at)->setTimezone('Asia/Jakarta')->format('H:i:s - d M Y') }}
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <span class="px-3 py-1 text-xs font-extrabold rounded-full bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                                        {{ $att->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400 dark:text-slate-500 text-xs font-medium">
                                    Tidak ada Kohai yang tercatat pada sesi absensi ini.
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
