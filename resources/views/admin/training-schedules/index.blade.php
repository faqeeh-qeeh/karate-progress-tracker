@extends('layouts.admin')

@section('title', 'Manajemen Jadwal Latihan')

@section('content')
<div class="space-y-6">
    <!-- Top Action & Title Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-slate-900 p-5 sm:p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm transition-colors">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Manajemen Jadwal Latihan</h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">Kelola jadwal latihan rutin mingguan & tambahan serta notifikasi pengingat email</p>
        </div>
        <a href="{{ route('admin.training-schedules.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3 bg-gradient-to-r from-brand-primary to-brand-secondary hover:from-brand-primary/90 hover:to-brand-secondary/90 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md shadow-brand-primary/20 hover:shadow-lg transition-all active:scale-[0.99] whitespace-nowrap">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Tambah Jadwal Baru</span>
        </a>
    </div>

    <!-- Statistics Row -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: Total Jadwal -->
        <div class="bg-white dark:bg-slate-900 p-4 sm:p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm flex items-center gap-3.5 transition-colors">
            <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-blue-950/40 text-brand-primary dark:text-blue-400 border border-blue-200/80 dark:border-blue-800/60 flex items-center justify-center text-xl shrink-0">
                📅
            </div>
            <div class="min-w-0">
                <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Total Jadwal</p>
                <p class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white">{{ $totalSchedules }}</p>
            </div>
        </div>

        <!-- Card 2: Latihan Rutin -->
        <div class="bg-white dark:bg-slate-900 p-4 sm:p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm flex items-center gap-3.5 transition-colors">
            <div class="w-11 h-11 rounded-xl bg-cyan-50 dark:bg-cyan-950/40 text-cyan-600 dark:text-cyan-400 border border-cyan-200/80 dark:border-cyan-800/60 flex items-center justify-center text-xl shrink-0">
                🔄
            </div>
            <div class="min-w-0">
                <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Latihan Rutin</p>
                <p class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white">{{ $totalRutin }}</p>
            </div>
        </div>

        <!-- Card 3: Latihan Tambahan -->
        <div class="bg-white dark:bg-slate-900 p-4 sm:p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm flex items-center gap-3.5 transition-colors">
            <div class="w-11 h-11 rounded-xl bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 border border-amber-200/80 dark:border-amber-800/60 flex items-center justify-center text-xl shrink-0">
                ⚡
            </div>
            <div class="min-w-0">
                <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Tambahan</p>
                <p class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white">{{ $totalTambahan }}</p>
            </div>
        </div>

        <!-- Card 4: Jadwal Aktif -->
        <div class="bg-white dark:bg-slate-900 p-4 sm:p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm flex items-center gap-3.5 transition-colors">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 border border-emerald-200/80 dark:border-emerald-800/60 flex items-center justify-center text-xl shrink-0">
                ●
            </div>
            <div class="min-w-0">
                <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Jadwal Aktif</p>
                <p class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white">{{ $totalActive }}</p>
            </div>
        </div>
    </div>

    <!-- Search & Filter Form Card -->
    <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm transition-colors">
        <form action="{{ route('admin.training-schedules.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <!-- Search Keyword Input -->
            <div class="sm:col-span-5 relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari judul latihan, lokasi, atau catatan..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary bg-slate-50/50 dark:bg-slate-800/80 text-slate-900 dark:text-white placeholder:text-slate-400 dark:placeholder:text-slate-500 transition">
            </div>

            <!-- Type Filter Select -->
            <div class="sm:col-span-3 relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                </div>
                <select name="type" onchange="this.form.submit()" class="w-full pl-10 pr-8 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary bg-slate-50/50 dark:bg-slate-800/80 text-slate-700 dark:text-slate-200 cursor-pointer appearance-none transition">
                    <option value="">Semua Jenis Latihan</option>
                    <option value="rutin" {{ request('type') === 'rutin' ? 'selected' : '' }}>Latihan Rutin</option>
                    <option value="tambahan" {{ request('type') === 'tambahan' ? 'selected' : '' }}>Latihan Tambahan</option>
                </select>
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>

            <!-- Status Filter Select -->
            <div class="sm:col-span-2 relative">
                <select name="status" onchange="this.form.submit()" class="w-full px-3.5 pr-8 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary bg-slate-50/50 dark:bg-slate-800/80 text-slate-700 dark:text-slate-200 cursor-pointer appearance-none transition">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>

            <!-- Submit & Reset Buttons -->
            <div class="sm:col-span-2 flex items-center gap-2">
                <button type="submit" class="w-full py-2.5 px-4 bg-slate-900 hover:bg-slate-800 dark:bg-slate-800 dark:hover:bg-slate-700 text-white text-xs font-bold rounded-xl transition shadow-xs">
                    Cari
                </button>
                @if(request('search') || request('type') || request('status'))
                    <a href="{{ route('admin.training-schedules.index') }}" class="py-2.5 px-3.5 bg-slate-200 hover:bg-slate-300 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs font-bold rounded-xl transition whitespace-nowrap">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Desktop View: Table (Hidden on mobile screens < md) -->
    <div class="hidden md:block bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden transition-colors">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300 min-w-full">
                <thead class="bg-slate-50 dark:bg-slate-950/60 text-slate-700 dark:text-slate-300 text-[11px] uppercase font-bold tracking-wider border-b border-slate-200/80 dark:border-slate-800 whitespace-nowrap">
                    <tr>
                        <th class="py-3.5 px-4">Jadwal Latihan</th>
                        <th class="py-3.5 px-4">Jenis</th>
                        <th class="py-3.5 px-4">Hari / Tanggal</th>
                        <th class="py-3.5 px-4">Waktu</th>
                        <th class="py-3.5 px-4">Lokasi & Tempat</th>
                        <th class="py-3.5 px-4 text-center">Pengingat Email</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 whitespace-nowrap font-medium text-xs">
                    @forelse($schedules as $schedule)
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors">
                            <!-- Judul & Detail -->
                            <td class="py-3.5 px-4">
                                <div class="max-w-[200px] truncate">
                                    <span class="font-bold text-slate-900 dark:text-white block truncate">{{ $schedule->title }}</span>
                                    <span class="text-[10px] text-slate-400 dark:text-slate-500">Oleh: {{ $schedule->creator->name ?? 'Administrator' }}</span>
                                </div>
                            </td>

                            <!-- Jenis Badge -->
                            <td class="py-3.5 px-4">
                                @if($schedule->type === 'rutin')
                                    <span class="px-2.5 py-1 inline-flex text-[11px] font-extrabold rounded-full bg-blue-50 dark:bg-blue-950/40 text-brand-primary dark:text-blue-300 border border-blue-200 dark:border-blue-800/60">
                                        🔄 Rutin
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 inline-flex text-[11px] font-extrabold rounded-full bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-800/60">
                                        ⚡ Tambahan
                                    </span>
                                @endif
                            </td>

                            <!-- Hari / Tanggal -->
                            <td class="py-3.5 px-4">
                                <span class="font-bold text-slate-800 dark:text-slate-200 block">{{ $schedule->days_string }}</span>
                                @if($schedule->type === 'rutin' && $schedule->start_date)
                                    <span class="text-[10px] text-slate-400 dark:text-slate-500 font-mono">
                                        Mulai: {{ $schedule->start_date->format('d/m/Y') }}
                                    </span>
                                @endif
                            </td>

                            <!-- Waktu -->
                            <td class="py-3.5 px-4">
                                <span class="font-mono font-bold text-slate-900 dark:text-white bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded-md border border-slate-200 dark:border-slate-700">
                                    {{ $schedule->time_range }} WIB
                                </span>
                            </td>

                            <!-- Lokasi & Detail -->
                            <td class="py-3.5 px-4">
                                <div class="max-w-[200px]">
                                    <span class="font-bold text-slate-800 dark:text-slate-200 block truncate">
                                        📍 {{ $schedule->location_label }}
                                    </span>
                                    <span class="text-[10px] text-slate-400 dark:text-slate-500 block truncate">
                                        {{ $schedule->location_detail ?? 'Dojo Utama' }}
                                    </span>
                                </div>
                            </td>

                            <!-- Pengingat Email -->
                            <td class="py-3.5 px-4 text-center">
                                @if($schedule->email_reminder)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/60">
                                        <span>📧</span>
                                        <span>{{ $schedule->reminder_time === 'malam' ? 'Malam (H-1)' : 'Pagi (H)' }}</span>
                                    </span>
                                @else
                                    <span class="text-[11px] text-slate-400 dark:text-slate-500">Nonaktif</span>
                                @endif
                            </td>

                            <!-- Status Aktif -->
                            <td class="py-3.5 px-4 text-center">
                                <form action="{{ route('admin.training-schedules.toggle-active', $schedule->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" title="Klik untuk mengubah status"
                                        class="px-2.5 py-1 inline-flex items-center gap-1.5 text-[11px] font-extrabold rounded-full border transition cursor-pointer {{ $schedule->is_active ? 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 border-emerald-200 dark:border-emerald-800/60 hover:bg-emerald-100' : 'bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 border-slate-200 dark:border-slate-700 hover:bg-slate-200' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $schedule->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                        <span>{{ $schedule->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                    </button>
                                </form>
                            </td>

                            <!-- Aksi -->
                            <td class="py-3.5 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Kirim Pengingat -->
                                    <a href="{{ route('admin.training-schedules.send-reminder', $schedule->id) }}"
                                       title="Kirim Notifikasi Email"
                                       class="p-1.5 rounded-lg bg-blue-50 dark:bg-blue-950/40 text-brand-primary dark:text-blue-300 hover:bg-blue-100 dark:hover:bg-blue-900/60 border border-blue-200 dark:border-blue-800/60 transition shadow-xs">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    </a>

                                    <!-- Edit -->
                                    <a href="{{ route('admin.training-schedules.edit', $schedule->id) }}"
                                       title="Edit Jadwal"
                                       class="p-1.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 transition shadow-xs">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('admin.training-schedules.destroy', $schedule->id) }}" method="POST"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal latihan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                title="Hapus Jadwal"
                                                class="p-1.5 rounded-lg bg-red-50 dark:bg-red-950/40 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/60 border border-red-200 dark:border-red-800/60 transition shadow-xs cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400 dark:text-slate-500 text-xs font-medium">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <span class="text-3xl">🥋</span>
                                    <p class="text-slate-600 dark:text-slate-400 font-bold">Belum ada data jadwal latihan.</p>
                                    <p class="text-slate-400 dark:text-slate-500 text-[11px]">Silakan tambahkan jadwal latihan baru menggunakan tombol di atas.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($schedules->hasPages())
            <div class="px-5 py-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                {{ $schedules->links() }}
            </div>
        @endif
    </div>

    <!-- Mobile View: Card Roster (Shown on mobile screens < md) -->
    <div class="block md:hidden space-y-4">
        @forelse($schedules as $schedule)
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 p-4 shadow-sm hover:shadow-md transition-all space-y-3.5">
                <!-- Card Header -->
                <div class="flex items-start justify-between gap-3 border-b border-slate-100 dark:border-slate-800 pb-3">
                    <div>
                        <div class="flex items-center gap-2 flex-wrap mb-1">
                            @if($schedule->type === 'rutin')
                                <span class="px-2 py-0.5 inline-flex text-[10px] font-extrabold rounded-full bg-blue-50 dark:bg-blue-950/40 text-brand-primary dark:text-blue-300 border border-blue-200 dark:border-blue-800/60">
                                    🔄 Rutin
                                </span>
                            @else
                                <span class="px-2 py-0.5 inline-flex text-[10px] font-extrabold rounded-full bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-800/60">
                                    ⚡ Tambahan
                                </span>
                            @endif

                            <span class="px-2 py-0.5 inline-flex items-center gap-1 text-[10px] font-extrabold rounded-full border {{ $schedule->is_active ? 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 border-emerald-200 dark:border-emerald-800/60' : 'bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 border-slate-200 dark:border-slate-700' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $schedule->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                {{ $schedule->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                        <h3 class="text-sm font-extrabold text-slate-900 dark:text-white leading-tight">{{ $schedule->title }}</h3>
                    </div>
                    <span class="font-mono text-xs font-bold text-slate-800 dark:text-slate-200 bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded-md border border-slate-200 dark:border-slate-700 shrink-0">
                        {{ $schedule->time_range }}
                    </span>
                </div>

                <!-- Card Details -->
                <div class="space-y-1.5 text-xs">
                    <div class="flex items-center justify-between text-slate-600 dark:text-slate-400">
                        <span class="font-medium">Hari / Tanggal:</span>
                        <span class="font-bold text-slate-900 dark:text-white">{{ $schedule->days_string }}</span>
                    </div>
                    <div class="flex items-center justify-between text-slate-600 dark:text-slate-400">
                        <span class="font-medium">Lokasi:</span>
                        <span class="font-bold text-slate-900 dark:text-white truncate max-w-[180px]">
                            {{ $schedule->location_label }} ({{ $schedule->location_detail ?? 'Dojo' }})
                        </span>
                    </div>
                    <div class="flex items-center justify-between text-slate-600 dark:text-slate-400">
                        <span class="font-medium">Pengingat Email:</span>
                        @if($schedule->email_reminder)
                            <span class="font-bold text-emerald-600 dark:text-emerald-400">
                                Aktif ({{ $schedule->reminder_time === 'malam' ? 'Malam' : 'Pagi' }})
                            </span>
                        @else
                            <span class="text-slate-400 dark:text-slate-500">Tidak Aktif</span>
                        @endif
                    </div>
                </div>

                <!-- Card Actions -->
                <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between gap-2">
                    <a href="{{ route('admin.training-schedules.send-reminder', $schedule->id) }}"
                       class="flex-1 py-2 px-3 bg-blue-50 dark:bg-blue-950/40 text-brand-primary dark:text-blue-300 hover:bg-blue-100 dark:hover:bg-blue-900/60 border border-blue-200 dark:border-blue-800/60 rounded-xl text-xs font-bold text-center transition">
                        📧 Kirim Email
                    </a>
                    <a href="{{ route('admin.training-schedules.edit', $schedule->id) }}"
                       class="py-2 px-3 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-bold transition">
                        Edit
                    </a>
                    <form action="{{ route('admin.training-schedules.destroy', $schedule->id) }}" method="POST"
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal latihan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="py-2 px-3 bg-red-50 dark:bg-red-950/40 text-red-600 dark:text-red-400 rounded-xl text-xs font-bold transition">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 p-8 text-center text-slate-400 dark:text-slate-500 text-xs font-medium">
                Belum ada data jadwal latihan.
            </div>
        @endforelse

        @if($schedules->hasPages())
            <div class="pt-2">
                {{ $schedules->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
