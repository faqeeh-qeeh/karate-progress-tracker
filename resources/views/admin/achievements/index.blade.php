@extends('layouts.admin')

@section('title', 'Manajemen Prestasi & Kejuaraan')

@section('content')
<div class="space-y-6">
    <!-- Top Action & Title Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-slate-900 p-5 sm:p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm transition-colors">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-900/50">
                    Rekam Jejak Juara
                </span>
            </div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Manajemen Prestasi & Kejuaraan</h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">Kelola data kejuaraan, medali atlet, dan pilih prestasi yang tampil di Landing Page</p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.landing-page.index') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold text-xs sm:text-sm rounded-xl transition shadow-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Pengaturan Landing</span>
            </a>
            <button type="button" onclick="openCreateModal()" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-gradient-to-r from-brand-primary to-brand-secondary hover:from-brand-primary/90 hover:to-brand-secondary/90 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md shadow-brand-primary/20 hover:shadow-lg transition-all active:scale-[0.99] whitespace-nowrap">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Tambah Prestasi</span>
            </button>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 text-emerald-800 dark:text-emerald-300 text-xs sm:text-sm font-semibold flex items-center gap-3 animate-fade-in shadow-xs">
            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 rounded-2xl bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800/60 text-red-800 dark:text-red-300 text-xs sm:text-sm font-semibold space-y-1">
            <p class="font-bold flex items-center gap-2">
                <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Terjadi kesalahan input data:
            </p>
            <ul class="list-disc list-inside pl-2 space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Metric Cards Row -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        <!-- Card 1: Total Prestasi -->
        <div class="bg-white dark:bg-slate-900 p-4 sm:p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm flex items-center gap-3.5 transition-colors">
            <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-blue-950/40 text-brand-primary dark:text-blue-400 border border-blue-200/80 dark:border-blue-800/60 flex items-center justify-center text-xl shrink-0">
                🏆
            </div>
            <div class="min-w-0">
                <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Total Prestasi</p>
                <p class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white">{{ $stats['total'] }}</p>
            </div>
        </div>

        <!-- Card 2: Emas -->
        <div class="bg-white dark:bg-slate-900 p-4 sm:p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm flex items-center gap-3.5 transition-colors">
            <div class="w-11 h-11 rounded-xl bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 border border-amber-200/80 dark:border-amber-800/60 flex items-center justify-center text-xl shrink-0">
                🥇
            </div>
            <div class="min-w-0">
                <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Medali Emas</p>
                <p class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white">{{ $stats['gold'] }}</p>
            </div>
        </div>

        <!-- Card 3: Perak -->
        <div class="bg-white dark:bg-slate-900 p-4 sm:p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm flex items-center gap-3.5 transition-colors">
            <div class="w-11 h-11 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-xl shrink-0">
                🥈
            </div>
            <div class="min-w-0">
                <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Medali Perak</p>
                <p class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white">{{ $stats['silver'] }}</p>
            </div>
        </div>

        <!-- Card 4: Perunggu -->
        <div class="bg-white dark:bg-slate-900 p-4 sm:p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm flex items-center gap-3.5 transition-colors">
            <div class="w-11 h-11 rounded-xl bg-amber-100/50 dark:bg-amber-950/20 text-amber-800 dark:text-amber-500 border border-amber-300/60 dark:border-amber-900/40 flex items-center justify-center text-xl shrink-0">
                🥉
            </div>
            <div class="min-w-0">
                <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Perunggu</p>
                <p class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white">{{ $stats['bronze'] }}</p>
            </div>
        </div>

        <!-- Card 5: Tampil di Landing -->
        <div class="col-span-2 lg:col-span-1 bg-white dark:bg-slate-900 p-4 sm:p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm flex items-center gap-3.5 transition-colors">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 border border-emerald-200/80 dark:border-emerald-800/60 flex items-center justify-center text-xl shrink-0">
                🌐
            </div>
            <div class="min-w-0">
                <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Landing Page</p>
                <p class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white">{{ $stats['published'] }} Tampil</p>
            </div>
        </div>
    </div>

    <!-- Search & Filter Form Card -->
    <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm transition-colors">
        <form action="{{ route('admin.achievements.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <!-- Search Keyword Input -->
            <div class="sm:col-span-6 relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama kejuaraan, kategori, nama atlet, atau kota..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary bg-slate-50/50 dark:bg-slate-800/80 text-slate-900 dark:text-white placeholder:text-slate-400 dark:placeholder:text-slate-500 transition">
            </div>

            <!-- Medal Filter Select -->
            <div class="sm:col-span-3 relative">
                <select name="medal" onchange="this.form.submit()" class="w-full px-3.5 pr-8 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary bg-slate-50/50 dark:bg-slate-800/80 text-slate-700 dark:text-slate-200 cursor-pointer appearance-none transition">
                    <option value="">Semua Jenis Medali</option>
                    <option value="gold" {{ request('medal') === 'gold' ? 'selected' : '' }}>🥇 Emas (Gold)</option>
                    <option value="silver" {{ request('medal') === 'silver' ? 'selected' : '' }}>🥈 Perak (Silver)</option>
                    <option value="bronze" {{ request('medal') === 'bronze' ? 'selected' : '' }}>🥉 Perunggu (Bronze)</option>
                    <option value="trophy" {{ request('medal') === 'trophy' ? 'selected' : '' }}>🏆 Juara Umum / Trophy</option>
                    <option value="other" {{ request('medal') === 'other' ? 'selected' : '' }}>🎖️ Lainnya</option>
                </select>
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>

            <!-- Status Filter Select -->
            <div class="sm:col-span-3 relative">
                <select name="status" onchange="this.form.submit()" class="w-full px-3.5 pr-8 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary bg-slate-50/50 dark:bg-slate-800/80 text-slate-700 dark:text-slate-200 cursor-pointer appearance-none transition">
                    <option value="">Semua Status Landing</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Tampil di Landing Page</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Disembunyikan</option>
                </select>
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>
        </form>
    </div>

    <!-- Achievements Table Card -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden transition-colors">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800 text-[11px] font-extrabold uppercase text-slate-500 dark:text-slate-400 tracking-wider">
                        <th class="px-5 py-3.5">Medali & Kejuaraan</th>
                        <th class="px-5 py-3.5">Kategori / Judul Juara</th>
                        <th class="px-5 py-3.5">Atlet / Anggota</th>
                        <th class="px-5 py-3.5">Waktu & Tempat</th>
                        <th class="px-5 py-3.5 text-center">Sorotan</th>
                        <th class="px-5 py-3.5 text-center">Status Landing</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 text-xs sm:text-sm font-medium">
                    @forelse($achievements as $item)
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/30 transition-colors">
                            <!-- Medali & Event -->
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl shadow-xs shrink-0
                                        @if($item->medal_type === 'gold') bg-amber-50 dark:bg-amber-950/60 border border-amber-200 dark:border-amber-800/60
                                        @elseif($item->medal_type === 'silver') bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700
                                        @elseif($item->medal_type === 'bronze') bg-orange-50 dark:bg-orange-950/40 border border-orange-200 dark:border-orange-800/60
                                        @else bg-blue-50 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-800/60 @endif">
                                        {{ $item->medal_emoji }}
                                    </div>
                                    <div>
                                        <p class="font-extrabold text-slate-900 dark:text-white leading-tight">{{ $item->event_name }}</p>
                                        <span class="text-[11px] font-semibold text-slate-500 dark:text-slate-400">{{ $item->medal_label }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Title -->
                            <td class="px-5 py-4">
                                <p class="font-bold text-slate-800 dark:text-slate-200">{{ $item->title }}</p>
                                @if($item->description)
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-1 mt-0.5">{{ $item->description }}</p>
                                @endif
                            </td>

                            <!-- Athlete -->
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2">
                                    @if($item->user)
                                        <div class="w-7 h-7 rounded-lg bg-red-600 text-white flex items-center justify-center font-bold text-[10px] uppercase shrink-0">
                                            {{ $item->user->initials }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900 dark:text-white leading-tight">{{ $item->user->name }}</p>
                                            <span class="text-[10px] text-slate-500 dark:text-slate-400">Akun Terdaftar ({{ $item->user->role->nama ?? 'Anggota' }})</span>
                                        </div>
                                    @else
                                        <div class="w-7 h-7 rounded-lg bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 flex items-center justify-center font-bold text-[10px] shrink-0">
                                            👤
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-800 dark:text-slate-200 leading-tight">{{ $item->athlete_name ?: 'Tim / Atlet' }}</p>
                                            <span class="text-[10px] text-slate-500 dark:text-slate-400">Nama Manual</span>
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Meta Date & Location -->
                            <td class="px-5 py-4 whitespace-nowrap">
                                <p class="text-xs font-semibold text-slate-800 dark:text-slate-200">{{ $item->location ?: '-' }}</p>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400">
                                    {{ $item->event_date ? $item->event_date->translatedFormat('d M Y') : '-' }}
                                </p>
                            </td>

                            <!-- Featured -->
                            <td class="px-5 py-4 text-center">
                                <form action="{{ route('admin.achievements.toggle-featured', $item) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" title="Klik untuk ubah sorotan" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold transition
                                        {{ $item->is_featured ? 'bg-amber-100 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 border border-amber-300 dark:border-amber-800' : 'bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400' }}">
                                        <span>{{ $item->is_featured ? '⭐ Featured' : 'Biasa' }}</span>
                                    </button>
                                </form>
                            </td>

                            <!-- Published -->
                            <td class="px-5 py-4 text-center">
                                <form action="{{ route('admin.achievements.toggle-publish', $item) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" title="Klik untuk ubah status tayang di landing page" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold transition
                                        {{ $item->is_published ? 'bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-800' : 'bg-rose-100 dark:bg-rose-950/60 text-rose-700 dark:text-rose-300 border border-rose-300 dark:border-rose-800' }}">
                                        <span>{{ $item->is_published ? '● Tayang' : '○ Sembunyi' }}</span>
                                    </button>
                                </form>
                            </td>

                            <!-- Actions -->
                            <td class="px-5 py-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button type="button" onclick="openEditModal({{ json_encode($item) }})" class="p-2 rounded-xl text-slate-500 hover:text-brand-primary hover:bg-slate-100 dark:hover:bg-slate-800 transition" title="Edit Data">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <form action="{{ route('admin.achievements.destroy', $item) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data prestasi {{ $item->event_name }} ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-xl text-slate-500 hover:text-red-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition" title="Hapus Data">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center text-slate-400 dark:text-slate-500">
                                <div class="w-12 h-12 mx-auto rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-2xl mb-3">
                                    🏅
                                </div>
                                <p class="text-sm font-bold text-slate-700 dark:text-slate-300">Belum ada data prestasi kejuaraan</p>
                                <p class="text-xs text-slate-500 mt-1">Tambahkan prestasi pertama dengan menekan tombol Tambah Prestasi di atas.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($achievements->hasPages())
            <div class="px-5 py-4 border-t border-slate-100 dark:border-slate-800">
                {{ $achievements->links() }}
            </div>
        @endif
    </div>
</div>

<!-- ═════════════════════════════════════════════════════
     MODAL TAMBAH PRESTASI BARU
     ═════════════════════════════════════════════════════ -->
<div id="create-modal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-950/70 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="relative w-full max-w-2xl bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 dark:border-slate-800">
            <h3 class="text-base font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                <span>🥇</span>
                <span>Tambah Prestasi Kejuaraan</span>
            </h3>
            <button type="button" onclick="closeCreateModal()" class="p-2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800">
                ✕
            </button>
        </div>

        <form action="{{ route('admin.achievements.store') }}" method="POST" class="p-6 space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Event Name -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Nama Event / Kejuaraan <span class="text-red-500">*</span></label>
                    <input type="text" name="event_name" required placeholder="Contoh: POMNAS 2024 / Kejurda Jabar" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                </div>

                <!-- Title / Kategori -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Kategori / Gelar Juara <span class="text-red-500">*</span></label>
                    <input type="text" name="title" required placeholder="Contoh: Juara 1 Kata Perorangan Putra" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                </div>

                <!-- Jenis Medali -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Jenis Medali / Trofi <span class="text-red-500">*</span></label>
                    <select name="medal_type" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                        <option value="gold">🥇 Medali Emas (Gold)</option>
                        <option value="silver">🥈 Medali Perak (Silver)</option>
                        <option value="bronze">🥉 Medali Perunggu (Bronze)</option>
                        <option value="trophy">🏆 Juara Umum / Trofi</option>
                        <option value="other">🎖️ Lainnya</option>
                    </select>
                </div>

                <!-- Relasi Akun Atlet (User) -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Pilih Akun Anggota (Opsional)</label>
                    <select name="user_id" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                        <option value="">-- Bukan Akun / Input Manual --</option>
                        @foreach($athletes as $athlete)
                            <option value="{{ $athlete->id }}">{{ $athlete->name }} ({{ $athlete->email }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Nama Atlet Manual (Fallback) -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Nama Atlet / Tim (Jika manual)</label>
                    <input type="text" name="athlete_name" placeholder="Contoh: Budi Pratama / Tim Beregu Putri" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                </div>

                <!-- Tanggal Kejuaraan -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Tanggal Kejuaraan</label>
                    <input type="date" name="event_date" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                </div>

                <!-- Lokasi / Kota -->
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Lokasi / Kota Penyelenggaraan</label>
                    <input type="text" name="location" placeholder="Contoh: Jakarta / Bandung / Cirebon" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                </div>

                <!-- Deskripsi / Catatan Tambahan -->
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Deskripsi Singkat</label>
                    <textarea name="description" rows="2" placeholder="Keterangan tambahan tentang kejuaraan ini..." class="w-full px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-xs sm:text-sm font-medium text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary"></textarea>
                </div>
            </div>

            <!-- Toggles: Featured & Published -->
            <div class="flex flex-col sm:flex-row sm:items-center gap-6 pt-2 border-t border-slate-100 dark:border-slate-800">
                <label class="inline-flex items-center cursor-pointer gap-2.5">
                    <input type="checkbox" name="is_featured" value="1" class="w-4 h-4 text-brand-primary rounded border-slate-300 focus:ring-brand-primary">
                    <span class="text-xs font-bold text-slate-700 dark:text-slate-300">⭐ Tandai Sebagai Prestasi Unggulan (Featured)</span>
                </label>
                <label class="inline-flex items-center cursor-pointer gap-2.5">
                    <input type="checkbox" name="is_published" value="1" checked class="w-4 h-4 text-brand-primary rounded border-slate-300 focus:ring-brand-primary">
                    <span class="text-xs font-bold text-slate-700 dark:text-slate-300">🌐 Tampilkan di Landing Page</span>
                </label>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                <button type="button" onclick="closeCreateModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs sm:text-sm font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-brand-primary to-brand-secondary text-white font-bold text-xs sm:text-sm rounded-xl shadow-md transition">
                    Simpan Prestasi
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ═════════════════════════════════════════════════════
     MODAL EDIT PRESTASI
     ═════════════════════════════════════════════════════ -->
<div id="edit-modal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-950/70 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="relative w-full max-w-2xl bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 dark:border-slate-800">
            <h3 class="text-base font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                <span>✏️</span>
                <span>Edit Prestasi Kejuaraan</span>
            </h3>
            <button type="button" onclick="closeEditModal()" class="p-2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800">
                ✕
            </button>
        </div>

        <form id="edit-form" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Event Name -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Nama Event / Kejuaraan <span class="text-red-500">*</span></label>
                    <input type="text" id="edit-event_name" name="event_name" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                </div>

                <!-- Title / Kategori -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Kategori / Gelar Juara <span class="text-red-500">*</span></label>
                    <input type="text" id="edit-title" name="title" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                </div>

                <!-- Jenis Medali -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Jenis Medali / Trofi <span class="text-red-500">*</span></label>
                    <select id="edit-medal_type" name="medal_type" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                        <option value="gold">🥇 Medali Emas (Gold)</option>
                        <option value="silver">🥈 Medali Perak (Silver)</option>
                        <option value="bronze">🥉 Medali Perunggu (Bronze)</option>
                        <option value="trophy">🏆 Juara Umum / Trofi</option>
                        <option value="other">🎖️ Lainnya</option>
                    </select>
                </div>

                <!-- Relasi Akun Atlet (User) -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Pilih Akun Anggota (Opsional)</label>
                    <select id="edit-user_id" name="user_id" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                        <option value="">-- Bukan Akun / Input Manual --</option>
                        @foreach($athletes as $athlete)
                            <option value="{{ $athlete->id }}">{{ $athlete->name }} ({{ $athlete->email }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Nama Atlet Manual (Fallback) -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Nama Atlet / Tim (Jika manual)</label>
                    <input type="text" id="edit-athlete_name" name="athlete_name" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                </div>

                <!-- Tanggal Kejuaraan -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Tanggal Kejuaraan</label>
                    <input type="date" id="edit-event_date" name="event_date" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                </div>

                <!-- Lokasi / Kota -->
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Lokasi / Kota Penyelenggaraan</label>
                    <input type="text" id="edit-location" name="location" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                </div>

                <!-- Deskripsi / Catatan Tambahan -->
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Deskripsi Singkat</label>
                    <textarea id="edit-description" name="description" rows="2" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-xs sm:text-sm font-medium text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary"></textarea>
                </div>
            </div>

            <!-- Toggles: Featured & Published -->
            <div class="flex flex-col sm:flex-row sm:items-center gap-6 pt-2 border-t border-slate-100 dark:border-slate-800">
                <label class="inline-flex items-center cursor-pointer gap-2.5">
                    <input type="checkbox" id="edit-is_featured" name="is_featured" value="1" class="w-4 h-4 text-brand-primary rounded border-slate-300 focus:ring-brand-primary">
                    <span class="text-xs font-bold text-slate-700 dark:text-slate-300">⭐ Tandai Sebagai Prestasi Unggulan (Featured)</span>
                </label>
                <label class="inline-flex items-center cursor-pointer gap-2.5">
                    <input type="checkbox" id="edit-is_published" name="is_published" value="1" class="w-4 h-4 text-brand-primary rounded border-slate-300 focus:ring-brand-primary">
                    <span class="text-xs font-bold text-slate-700 dark:text-slate-300">🌐 Tampilkan di Landing Page</span>
                </label>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs sm:text-sm font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-brand-primary to-brand-secondary text-white font-bold text-xs sm:text-sm rounded-xl shadow-md transition">
                    Perbarui Prestasi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openCreateModal() {
    document.getElementById('create-modal').classList.remove('hidden');
}

function closeCreateModal() {
    document.getElementById('create-modal').classList.add('hidden');
}

function openEditModal(item) {
    const form = document.getElementById('edit-form');
    form.action = `/admin/achievements/${item.id}`;

    document.getElementById('edit-event_name').value = item.event_name || '';
    document.getElementById('edit-title').value = item.title || '';
    document.getElementById('edit-medal_type').value = item.medal_type || 'gold';
    document.getElementById('edit-user_id').value = item.user_id || '';
    document.getElementById('edit-athlete_name').value = item.athlete_name || '';
    document.getElementById('edit-event_date').value = item.event_date ? item.event_date.substring(0, 10) : '';
    document.getElementById('edit-location').value = item.location || '';
    document.getElementById('edit-description').value = item.description || '';
    document.getElementById('edit-is_featured').checked = Boolean(item.is_featured);
    document.getElementById('edit-is_published').checked = Boolean(item.is_published);

    document.getElementById('edit-modal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('edit-modal').classList.add('hidden');
}

// Close on escape
window.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeCreateModal();
        closeEditModal();
    }
});
</script>
@endsection
