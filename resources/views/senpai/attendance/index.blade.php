@extends('layouts.senpai')

@section('title', 'Absensi QR Dojo')

@section('content')
<div class="space-y-6">
    <!-- Action Header Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-slate-900 p-5 sm:p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm transition-colors duration-200">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Absensi QR Dojo</h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">Kelola sesi absensi latihan Kohai, generate QR Code, dan pantau kehadiran secara real-time</p>
        </div>
        @if(!$activeSession)
            <button type="button" onclick="document.getElementById('modal-create-session').classList.remove('hidden')" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3 bg-gradient-to-r from-brand-primary to-brand-secondary hover:from-brand-primary/90 hover:to-brand-secondary/90 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md shadow-brand-primary/20 hover:shadow-lg transition-all active:scale-[0.99] whitespace-nowrap cursor-pointer">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Buat Sesi Absensi Baru</span>
            </button>
        @else
            <div class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-5 py-3 rounded-xl bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-300 border border-emerald-200/80 dark:border-emerald-800 text-xs sm:text-sm font-extrabold shadow-xs">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Sesi Absensi Sedang Berjalan</span>
            </div>
        @endif
    </div>

    @if($activeSession)
        <!-- ACTIVE QR SESSION CARD -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- QR Code Display Box -->
            <div class="lg:col-span-1 bg-white dark:bg-slate-900 rounded-3xl border-2 border-brand-primary/30 dark:border-blue-900/50 p-6 shadow-lg flex flex-col items-center justify-between text-center relative overflow-hidden transition-colors duration-200">
                <div class="w-full flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 text-xs font-black">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                        SESI AKTIF
                    </span>
                    <form action="{{ route('senpai.attendance.close', $activeSession->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menutup sesi absensi ini?')">
                        @csrf
                        <button type="submit" class="text-xs font-bold text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 hover:underline">
                            Tutup Sesi
                        </button>
                    </form>
                </div>

                <div class="my-5 space-y-3 flex flex-col items-center">
                    <h3 class="text-base font-extrabold text-slate-900 dark:text-white leading-snug">{{ $activeSession->title }}</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Tanggal: <span class="font-bold text-slate-700 dark:text-slate-200">{{ \Carbon\Carbon::parse($activeSession->date)->format('d F Y') }}</span></p>

                    <!-- QR Code Image -->
                    @php
                        $scanUrl = route('kohai.attendance.direct_scan', $activeSession->qr_token);
                        $qrApiUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=240x240&data=' . urlencode($scanUrl);
                    @endphp
                    <div class="p-3 bg-white rounded-2xl border border-slate-200 shadow-md my-2">
                        <img src="{{ $qrApiUrl }}" alt="QR Code Absensi" class="w-52 h-52 object-contain rounded-lg">
                    </div>

                    <div class="bg-slate-50 dark:bg-slate-950/50 p-3 rounded-xl border border-slate-200/80 dark:border-slate-800 w-full text-left space-y-1.5 text-xs text-slate-600 dark:text-slate-300">
                        <p class="truncate"><span class="font-bold text-slate-800 dark:text-slate-200">Senpai ID:</span> #{{ auth()->id() }} ({{ auth()->user()->name }})</p>
                        <div class="flex items-center justify-between pt-1 border-t border-slate-200/60 dark:border-slate-800">
                            <span class="font-bold text-slate-800 dark:text-slate-200">Kode Token:</span> 
                            <span class="font-mono font-black text-sm text-brand-primary dark:text-brand-secondary bg-blue-50 dark:bg-blue-950/60 px-2.5 py-1 rounded-lg border border-blue-200 dark:border-blue-900 select-all tracking-wider">
                                {{ $activeSession->qr_token }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="w-full bg-slate-50 dark:bg-slate-950/50 rounded-2xl p-3 border border-slate-200/60 dark:border-slate-800 text-xs text-slate-500 dark:text-slate-400 font-medium">
                    🔍 Arahkan kamera Kohai ke QR Code ini atau masukkan Kode Token di atas untuk mencatat presensi.
                </div>
            </div>

            <!-- Live Attendance Tracker Table -->
            <div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 p-6 shadow-sm flex flex-col justify-between space-y-4 transition-colors duration-200">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4">
                    <div>
                        <h3 class="text-base font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                            <span>👥</span> Daftar Kohai Sudah Absen
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Daftar ini akan diperbarui secara real-time saat Kohai melakukan scan.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span id="live-indicator" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-950/60 text-brand-primary dark:text-blue-300 text-xs font-bold border border-blue-200 dark:border-blue-900">
                            <span class="w-2 h-2 rounded-full bg-brand-primary animate-pulse"></span>
                            Live Updates
                        </span>
                        <span id="attendee-count-badge" class="px-3.5 py-1 rounded-full bg-slate-900 dark:bg-slate-800 text-white font-extrabold text-xs">
                            {{ count($activeSession->attendances) }} Hadir
                        </span>
                    </div>
                </div>

                <div class="overflow-x-auto min-w-0 flex-1">
                    <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                        <thead class="bg-slate-50 dark:bg-slate-950/60 text-slate-700 dark:text-slate-300 text-[11px] uppercase font-bold tracking-wider border-b border-slate-200/80 dark:border-slate-800 whitespace-nowrap">
                            <tr>
                                <th class="py-3 px-4">Nama Kohai</th>
                                <th class="py-3 px-4">Email</th>
                                <th class="py-3 px-4">Waktu Scan</th>
                                <th class="py-3 px-4 text-center">Status Presensi</th>
                            </tr>
                        </thead>
                        <tbody id="attendees-table-body" class="divide-y divide-slate-100 dark:divide-slate-800 whitespace-nowrap font-medium">
                            @forelse($activeSession->attendances as $att)
                                <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors">
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
                                <tr id="empty-attendees-row">
                                    <td colspan="4" class="py-12 text-center text-slate-400 dark:text-slate-500 text-xs font-medium">
                                        Belum ada Kohai yang meng-scan QR Code ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <!-- NO ACTIVE SESSION PLACEHOLDER -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 p-8 sm:p-12 text-center space-y-3 shadow-sm transition-colors duration-200">
            <div class="w-14 h-14 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-500 flex items-center justify-center text-2xl mx-auto border border-slate-200/60 dark:border-slate-700">
                📱
            </div>
            <div class="max-w-md mx-auto space-y-1">
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white">Belum Ada Sesi Absensi Aktif</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium leading-relaxed">
                    Silakan klik tombol <span class="font-bold text-brand-primary dark:text-brand-secondary">"Buat Sesi Absensi Baru"</span> pada bagian atas untuk memulai sesi absensi latihan hari ini.
                </p>
            </div>
        </div>
    @endif

    <!-- PAST ATTENDANCE SESSIONS HISTORY -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 p-6 shadow-sm space-y-4 transition-colors duration-200">
        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4">
            <div>
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                    <span>📜</span> Riwayat Sesi Absensi Sebelumnya
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Klik pada tanggal atau tombol Lanjutkan untuk membuka kembali sesi absensi pada hari tersebut.</p>
            </div>
        </div>

        <!-- Mobile View: Card Roster List (Shown on mobile screens < md) -->
        <div class="block md:hidden space-y-4">
            @forelse($pastSessions as $ps)
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 p-4 shadow-sm hover:shadow-md transition-all space-y-3">
                    <!-- Header Card Info -->
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-2.5">
                        <div class="flex items-center gap-2">
                            <span class="p-1.5 rounded-lg bg-blue-50 dark:bg-blue-950/50 text-brand-primary dark:text-brand-secondary">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </span>
                            <span class="text-xs font-bold text-slate-800 dark:text-slate-200">
                                {{ \Carbon\Carbon::parse($ps->date)->format('d F Y') }}
                            </span>
                        </div>
                        <span class="px-2.5 py-0.5 text-[10px] font-extrabold rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                            Ditutup / Inaktif
                        </span>
                    </div>

                    <!-- Title & Attendees Count Info -->
                    <div class="space-y-1.5">
                        <a href="{{ route('senpai.attendance.show', $ps->id) }}" class="text-sm font-extrabold text-slate-900 dark:text-white hover:text-brand-primary dark:hover:text-brand-secondary transition leading-snug block">
                            {{ $ps->title }}
                        </a>
                        <div class="flex items-center justify-between text-xs text-slate-500 dark:text-slate-400 font-medium pt-0.5">
                            <span>Total Hadir:</span>
                            <span class="font-extrabold text-brand-primary dark:text-brand-secondary bg-blue-50 dark:bg-blue-950/50 px-2.5 py-0.5 rounded-lg border border-blue-100 dark:border-blue-900">
                                {{ $ps->attendances_count }} Murid Hadir
                            </span>
                        </div>
                    </div>

                    <!-- Footer Action Buttons -->
                    <div class="pt-2 border-t border-slate-100 dark:border-slate-800 flex items-center gap-2">
                        <form action="{{ route('senpai.attendance.reactivate', $ps->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Apakah Anda yakin ingin melanjutkan sesi absensi tanggal {{ \Carbon\Carbon::parse($ps->date)->format('d M Y') }} ini?')">
                            @csrf
                            <button type="submit" class="w-full py-2 px-3 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition shadow-xs flex items-center justify-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Lanjutkan Sesi</span>
                            </button>
                        </form>
                        <a href="{{ route('senpai.attendance.show', $ps->id) }}" class="py-2 px-4 bg-slate-800 dark:bg-slate-700 hover:bg-slate-900 dark:hover:bg-slate-600 text-white text-xs font-bold rounded-xl transition shadow-xs flex items-center justify-center">
                            <span>Detail</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 text-center text-slate-400 dark:text-slate-500 text-xs font-medium border border-slate-200/80 dark:border-slate-800 shadow-sm">
                    Belum ada riwayat sesi absensi lampau.
                </div>
            @endforelse

            <div class="pt-2">
                {{ $pastSessions->links() }}
            </div>
        </div>

        <!-- Desktop View: Table Format (Hidden on mobile < md) -->
        <div class="hidden md:block">
            <div class="overflow-x-auto min-w-0 border border-slate-200/80 dark:border-slate-800 rounded-2xl">
                <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                    <thead class="bg-slate-50 dark:bg-slate-950/60 text-slate-700 dark:text-slate-300 text-[11px] uppercase font-bold tracking-wider border-b border-slate-200/80 dark:border-slate-800 whitespace-nowrap">
                        <tr>
                            <th class="py-3 px-4">Judul Sesi Absensi</th>
                            <th class="py-3 px-4">Tanggal Pelaksanaan</th>
                            <th class="py-3 px-4 text-center">Jumlah Kohai Hadir</th>
                            <th class="py-3 px-4 text-center">Status Sesi</th>
                            <th class="py-3 px-4 text-center">Aksi Pelatih</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 whitespace-nowrap font-medium">
                        @forelse($pastSessions as $ps)
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors">
                                <td class="py-3.5 px-4 font-bold text-slate-900 dark:text-white">
                                    <a href="{{ route('senpai.attendance.show', $ps->id) }}" class="hover:text-brand-primary dark:hover:text-brand-secondary transition">
                                        {{ $ps->title }}
                                    </a>
                                </td>
                                <td class="py-3.5 px-4 text-xs font-bold">
                                    <a href="{{ route('senpai.attendance.show', $ps->id) }}" title="Klik untuk lihat daftar Kohai yang hadir" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-blue-50 dark:bg-blue-950/50 text-brand-primary dark:text-brand-secondary border border-blue-200/80 dark:border-blue-900 hover:bg-brand-primary hover:text-white transition group shadow-xs">
                                        <svg class="w-3.5 h-3.5 text-brand-primary dark:text-brand-secondary group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <span>{{ \Carbon\Carbon::parse($ps->date)->format('d F Y') }}</span>
                                    </a>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200">
                                        {{ $ps->attendances_count }} Murid Hadir
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <span class="px-2.5 py-1 text-[11px] font-bold rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                                        Ditutup / Inaktif
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <div class="inline-flex items-center gap-2">
                                        <!-- Tombol Lanjutkan Sesi (Reactivate) -->
                                        <form action="{{ route('senpai.attendance.reactivate', $ps->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin melanjutkan sesi absensi tanggal {{ \Carbon\Carbon::parse($ps->date)->format('d M Y') }} ini? Data presensi {{ $ps->attendances_count }} Kohai sebelumnya tetap tersimpan.')">
                                            @csrf
                                            <button type="submit" class="px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition shadow-xs inline-flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                <span>Lanjutkan Sesi</span>
                                            </button>
                                        </form>

                                        <!-- Tombol Lihat Detail -->
                                        <a href="{{ route('senpai.attendance.show', $ps->id) }}" class="px-3.5 py-1.5 bg-slate-800 dark:bg-slate-700 hover:bg-slate-900 dark:hover:bg-slate-600 text-white text-xs font-bold rounded-xl transition shadow-xs inline-flex items-center gap-1">
                                            <span>Detail</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-slate-400 dark:text-slate-500 text-xs font-medium">
                                    Belum ada riwayat sesi absensi lampau.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pt-4">
                {{ $pastSessions->links() }}
            </div>
        </div>
    </div>
</div>

<!-- MODAL: BUAT SESI ABSENSI BARU -->
<div id="modal-create-session" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs">
    <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-md w-full p-6 shadow-2xl space-y-5 border border-slate-100 dark:border-slate-800 animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
            <h3 class="text-base font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                <span>📌</span> Buat Sesi Absensi
            </h3>
            <button onclick="document.getElementById('modal-create-session').classList.add('hidden')" class="p-1 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form action="{{ route('senpai.attendance.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="space-y-1.5">
                <label for="title" class="block text-xs font-bold text-slate-700 dark:text-slate-300">Judul Sesi Absensi</label>
                <input type="text" id="title" name="title" required value="Latihan Dojo - {{ date('d M Y') }}" placeholder="Contoh: Latihan Rutin Kumite & Kata" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary focus:border-brand-primary outline-none transition font-medium">
            </div>

            <div class="space-y-1.5">
                <label for="date" class="block text-xs font-bold text-slate-700 dark:text-slate-300">Tanggal Pelaksanaan</label>
                <input type="date" id="date" name="date" required value="{{ date('Y-m-d') }}" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary focus:border-brand-primary outline-none transition font-medium">
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('modal-create-session').classList.add('hidden')" class="px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 font-bold text-xs hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-brand-primary hover:bg-brand-primary/90 text-white font-bold text-xs shadow-md transition">
                    Proses Sesi
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL PERINGATAN: DITEMUKAN SESI PADA TANGGAL YANG SAMA -->
@if(session('existing_session_warning'))
@php $warn = session('existing_session_warning'); @endphp
<div id="modal-existing-warning" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-xs">
    <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-md w-full p-6 shadow-2xl space-y-5 border border-slate-100 dark:border-slate-800 animate-in fade-in zoom-in duration-200 text-slate-800 dark:text-slate-200">
        <!-- Modal Header -->
        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3.5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-amber-100 dark:bg-amber-950/50 text-amber-600 dark:text-amber-400 flex items-center justify-center text-xl font-bold shrink-0">
                    ⚠️
                </div>
                <div>
                    <h3 class="text-base font-extrabold text-slate-900 dark:text-white leading-tight">Konfirmasi Sesi Absensi</h3>
                    <span class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">Tanggal {{ $warn['date'] }}</span>
                </div>
            </div>
            <button onclick="document.getElementById('modal-existing-warning').remove()" class="p-1.5 text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Description Box -->
        <div class="bg-slate-50 dark:bg-slate-950/50 p-4 rounded-2xl border border-slate-200/80 dark:border-slate-800 space-y-2 text-xs leading-relaxed text-slate-700 dark:text-slate-300 font-medium">
            <p>
                Sesi absensi pada tanggal <strong class="text-slate-900 dark:text-white font-extrabold">{{ $warn['date'] }}</strong> sudah pernah dibuat dengan judul <strong class="text-slate-900 dark:text-white font-extrabold">"{{ $warn['title'] }}"</strong> dan memiliki <strong class="text-brand-primary dark:text-brand-secondary font-black text-sm">{{ $warn['attendee_count'] }} Kohai</strong> yang terdaftar hadir.
            </p>
            <p class="font-bold text-slate-900 dark:text-white border-t border-slate-200/60 dark:border-slate-800 pt-2">
                Pilih tindakan yang ingin Anda lakukan:
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-3 pt-1">
            <!-- Opsi 1: Melanjutkan Sesi Pada Tanggal Yang Sama -->
            <form action="{{ route('senpai.attendance.store') }}" method="POST">
                @csrf
                <input type="hidden" name="title" value="{{ $warn['new_title'] }}">
                <input type="hidden" name="date" value="{{ $warn['new_date'] }}">
                <input type="hidden" name="action_choice" value="reactivate">
                <button type="submit" style="background-color: #059669; color: #ffffff;" class="w-full py-3.5 px-4 font-extrabold text-xs sm:text-sm rounded-2xl shadow-md hover:brightness-110 transition flex items-center justify-center gap-2 text-center cursor-pointer">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>▶️ Ya, Lanjutkan Sesi Tanggal Ini ({{ $warn['attendee_count'] }} Kohai)</span>
                </button>
            </form>

            <!-- Opsi 2: Tidak / Pilih Tanggal Lain -->
            <button type="button" onclick="document.getElementById('modal-existing-warning').remove(); document.getElementById('modal-create-session').classList.remove('hidden');" style="background-color: #1e293b; color: #ffffff;" class="w-full py-3.5 px-4 font-bold text-xs sm:text-sm rounded-2xl shadow-sm hover:bg-slate-800 transition flex items-center justify-center gap-2 text-center cursor-pointer">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>📅 Tidak, Pilih Tanggal Lain</span>
            </button>
        </div>
    </div>
</div>
@endif

@if($activeSession)
<script>
    // Real-time polling untuk update daftar kohai yang absen secara live
    const activeSessionId = {{ $activeSession->id }};
    const attendeesUrl = "{{ route('senpai.attendance.attendees', $activeSession->id) }}";

    function refreshAttendees() {
        fetch(attendeesUrl)
            .then(res => res.json())
            .then(data => {
                if (data.attendees) {
                    const badge = document.getElementById('attendee-count-badge');
                    if (badge) badge.textContent = `${data.count} Hadir`;

                    const tbody = document.getElementById('attendees-table-body');
                    if (tbody) {
                        if (data.attendees.length === 0) {
                            tbody.innerHTML = `
                                <tr id="empty-attendees-row">
                                    <td colspan="4" class="py-12 text-center text-slate-400 dark:text-slate-500 text-xs font-medium">
                                        Belum ada Kohai yang meng-scan QR Code ini.
                                    </td>
                                </tr>
                            `;
                        } else {
                            let rowsHtml = '';
                            data.attendees.forEach(att => {
                                rowsHtml += `
                                    <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors">
                                        <td class="py-3.5 px-4 font-bold text-slate-900 dark:text-white flex items-center gap-2.5">
                                            <div class="w-7 h-7 rounded-lg bg-brand-primary text-white flex items-center justify-center text-xs font-bold shrink-0">
                                                🥋
                                            </div>
                                            <span>${att.kohai_name}</span>
                                        </td>
                                        <td class="py-3.5 px-4 text-xs text-slate-500 dark:text-slate-400">${att.kohai_email}</td>
                                        <td class="py-3.5 px-4 text-xs font-mono text-slate-700 dark:text-slate-300">${att.scanned_at}</td>
                                        <td class="py-3.5 px-4 text-center">
                                            <span class="px-3 py-1 text-xs font-extrabold rounded-full bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                                                ${att.status}
                                            </span>
                                        </td>
                                    </tr>
                                `;
                            });
                            tbody.innerHTML = rowsHtml;
                        }
                    }
                }
            })
            .catch(err => console.error('Error fetching live attendees:', err));
    }

    // Refresh every 3 seconds
    setInterval(refreshAttendees, 3000);
</script>
@endif
@endsection
