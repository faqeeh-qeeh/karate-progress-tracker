@extends('layouts.admin')

@section('title', 'Kelola Landing Page')

@section('content')
<div class="space-y-6">
    <!-- Top Action & Title Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-slate-900 p-5 sm:p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm transition-colors">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 dark:bg-red-950/60 text-brand-primary dark:text-red-400 border border-red-200 dark:border-red-900/50">
                    Landing Page CMS
                </span>
            </div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Pengaturan Landing Page</h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">Kontrol visibilitas seksi, angka statistik hero, dan integrasi data prestasi kejuaraan</p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('landing') }}" target="_blank" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold text-xs sm:text-sm rounded-xl transition shadow-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                <span>Lihat Landing Page</span>
            </a>
            <a href="{{ route('admin.achievements.index') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-brand-primary to-brand-secondary text-white font-bold text-xs sm:text-sm rounded-xl shadow-md shadow-brand-primary/20 hover:shadow-lg transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                <span>Kelola Prestasi ({{ $realStats['total_achievements'] }})</span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 text-emerald-800 dark:text-emerald-300 text-xs sm:text-sm font-semibold flex items-center gap-3 animate-fade-in shadow-xs">
            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <form action="{{ route('admin.landing-page.settings.update') }}" method="POST" class="space-y-6">
        @csrf

        <!-- ═════════════════════════════════════════════════════
             BAGIAN 1: PENGATURAN STATISTIK HERO (HIGHLIGHT)
             ═════════════════════════════════════════════════════ -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm p-5 sm:p-6 transition-colors">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 dark:border-slate-800 pb-4 mb-6">
                <div>
                    <h2 class="text-base sm:text-lg font-black text-slate-900 dark:text-white flex items-center gap-2">
                        <span>📊</span>
                        <span>Pengaturan 4 Statistik Hero Bar</span>
                    </h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Atur angka, label, mode otomatis, atau sembunyikan stat tertentu pada bar statistik hero.</p>
                </div>
                <span class="text-[11px] px-2.5 py-1 bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800/60 text-amber-700 dark:text-amber-300 font-bold rounded-lg self-start sm:self-auto">
                    Live Reactive Counter
                </span>
            </div>

            <!-- Preview Card Bar -->
            <div class="mb-6 p-4 rounded-xl bg-slate-950 text-white border border-slate-800 shadow-inner">
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Preview Tampilan Hero Stats di Landing Page</span>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-center divide-x divide-slate-800/80">
                    <div class="p-2">
                        <div class="text-lg sm:text-xl font-black text-red-500">{{ $settings['stat_founded_year'] ?? 2016 }}</div>
                        <div class="text-[10px] sm:text-xs font-semibold text-slate-300">{{ $settings['stat_founded_label'] ?? 'Tahun Berdiri' }}</div>
                        <span class="text-[9px] text-slate-500 block mt-0.5">{{ ($settings['stat_founded_active'] ?? true) ? '● Aktif' : '○ Sembunyi' }}</span>
                    </div>
                    <div class="p-2">
                        <div class="text-lg sm:text-xl font-black text-white">
                            @if(($settings['stat_members_mode'] ?? '') === 'auto_polindra')
                                {{ $realStats['kohai_polindra_count'] }}{{ $settings['stat_members_suffix'] ?? '+' }}
                            @elseif(($settings['stat_members_mode'] ?? '') === 'auto_all')
                                {{ $realStats['kohai_all_count'] }}{{ $settings['stat_members_suffix'] ?? '+' }}
                            @else
                                {{ $settings['stat_members_custom_value'] ?? 80 }}{{ $settings['stat_members_suffix'] ?? '+' }}
                            @endif
                        </div>
                        <div class="text-[10px] sm:text-xs font-semibold text-slate-300">{{ $settings['stat_members_label'] ?? 'Anggota Aktif' }}</div>
                        <span class="text-[9px] text-slate-500 block mt-0.5">{{ ($settings['stat_members_active'] ?? true) ? '● Aktif' : '○ Sembunyi' }}</span>
                    </div>
                    <div class="p-2">
                        <div class="text-lg sm:text-xl font-black text-white">
                            @if(($settings['stat_medals_mode'] ?? '') === 'auto')
                                {{ $realStats['medals_auto_count'] }}{{ $settings['stat_medals_suffix'] ?? '+' }}
                            @else
                                {{ $settings['stat_medals_custom_value'] ?? 50 }}{{ $settings['stat_medals_suffix'] ?? '+' }}
                            @endif
                        </div>
                        <div class="text-[10px] sm:text-xs font-semibold text-slate-300">{{ $settings['stat_medals_label'] ?? 'Medali Kejuaraan' }}</div>
                        <span class="text-[9px] text-slate-500 block mt-0.5">{{ ($settings['stat_medals_active'] ?? true) ? '● Aktif' : '○ Sembunyi' }}</span>
                    </div>
                    <div class="p-2">
                        <div class="text-lg sm:text-xl font-black text-white">
                            @if(($settings['stat_events_mode'] ?? '') === 'auto')
                                {{ $realStats['events_auto_count'] }}{{ $settings['stat_events_suffix'] ?? '+' }}
                            @else
                                {{ $settings['stat_events_value'] ?? 20 }}{{ $settings['stat_events_suffix'] ?? '+' }}
                            @endif
                        </div>
                        <div class="text-[10px] sm:text-xs font-semibold text-slate-300">{{ $settings['stat_events_label'] ?? 'Event Diikuti' }}</div>
                        <span class="text-[9px] text-slate-500 block mt-0.5">{{ ($settings['stat_events_active'] ?? true) ? '● Aktif' : '○ Sembunyi' }}</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- STAT 1: TAHUN BERDIRI -->
                <div class="p-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/40 space-y-4">
                    <div class="flex items-center justify-between pb-2 border-b border-slate-200 dark:border-slate-700/60">
                        <div class="flex items-center gap-2">
                            <span class="text-base">📅</span>
                            <span class="text-xs font-extrabold text-slate-900 dark:text-white uppercase tracking-wider">Stat 1: Tahun Berdiri</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="stat_founded_active" value="1" {{ ($settings['stat_founded_active'] ?? true) ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-9 h-5 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-brand-primary"></div>
                            <span class="ml-2 text-xs font-bold text-slate-700 dark:text-slate-300">Tampilkan</span>
                        </label>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Tahun Berdiri</label>
                            <input type="number" name="stat_founded_year" value="{{ old('stat_founded_year', $settings['stat_founded_year'] ?? 2016) }}" min="1950" max="2099" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs sm:text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary focus:border-brand-primary">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Label Teks</label>
                            <input type="text" name="stat_founded_label" value="{{ old('stat_founded_label', $settings['stat_founded_label'] ?? 'Tahun Berdiri') }}" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary focus:border-brand-primary">
                        </div>
                    </div>
                </div>

                <!-- STAT 2: ANGGOTA AKTIF -->
                <div class="p-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/40 space-y-4">
                    <div class="flex items-center justify-between pb-2 border-b border-slate-200 dark:border-slate-700/60">
                        <div class="flex items-center gap-2">
                            <span class="text-base">🥋</span>
                            <span class="text-xs font-extrabold text-slate-900 dark:text-white uppercase tracking-wider">Stat 2: Anggota Aktif</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="stat_members_active" value="1" {{ ($settings['stat_members_active'] ?? true) ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-9 h-5 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-brand-primary"></div>
                            <span class="ml-2 text-xs font-bold text-slate-700 dark:text-slate-300">Tampilkan</span>
                        </label>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Mode Perhitungan Angka</label>
                        <select name="stat_members_mode" id="stat_members_mode" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary focus:border-brand-primary cursor-pointer">
                            <option value="auto_polindra" {{ ($settings['stat_members_mode'] ?? '') === 'auto_polindra' ? 'selected' : '' }}>
                                ⚡ Otomatis: Hitung Kohai Polindra (Total saat ini: {{ $realStats['kohai_polindra_count'] }} akun)
                            </option>
                            <option value="auto_all" {{ ($settings['stat_members_mode'] ?? '') === 'auto_all' ? 'selected' : '' }}>
                                ⚡ Otomatis: Hitung Seluruh Kohai (Total saat ini: {{ $realStats['kohai_all_count'] }} akun)
                            </option>
                            <option value="manual" {{ ($settings['stat_members_mode'] ?? '') === 'manual' ? 'selected' : '' }}>
                                ✍️ Manual: Input angka kustom sendiri
                            </option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Angka Kustom</label>
                            <input type="number" name="stat_members_custom_value" value="{{ old('stat_members_custom_value', $settings['stat_members_custom_value'] ?? 80) }}" min="0" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs sm:text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary focus:border-brand-primary">
                        </div>
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Simbol Suffix</label>
                            <input type="text" name="stat_members_suffix" value="{{ old('stat_members_suffix', $settings['stat_members_suffix'] ?? '+') }}" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs sm:text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary focus:border-brand-primary">
                        </div>
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Label Teks</label>
                            <input type="text" name="stat_members_label" value="{{ old('stat_members_label', $settings['stat_members_label'] ?? 'Anggota Aktif') }}" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary focus:border-brand-primary">
                        </div>
                    </div>
                </div>

                <!-- STAT 3: MEDALI KEJUARAAN -->
                <div class="p-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/40 space-y-4">
                    <div class="flex items-center justify-between pb-2 border-b border-slate-200 dark:border-slate-700/60">
                        <div class="flex items-center gap-2">
                            <span class="text-base">🥇</span>
                            <span class="text-xs font-extrabold text-slate-900 dark:text-white uppercase tracking-wider">Stat 3: Medali Kejuaraan</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="stat_medals_active" value="1" {{ ($settings['stat_medals_active'] ?? true) ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-9 h-5 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-brand-primary"></div>
                            <span class="ml-2 text-xs font-bold text-slate-700 dark:text-slate-300">Tampilkan</span>
                        </label>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Mode Perhitungan Medali</label>
                        <select name="stat_medals_mode" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary focus:border-brand-primary cursor-pointer">
                            <option value="auto" {{ ($settings['stat_medals_mode'] ?? '') === 'auto' ? 'selected' : '' }}>
                                ⚡ Otomatis: Hitung dari input Prestasi Kejuaraan (Total: {{ $realStats['medals_auto_count'] }} prestasi aktif)
                            </option>
                            <option value="manual" {{ ($settings['stat_medals_mode'] ?? '') === 'manual' ? 'selected' : '' }}>
                                ✍️ Manual: Input angka kustom
                            </option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Angka Kustom</label>
                            <input type="number" name="stat_medals_custom_value" value="{{ old('stat_medals_custom_value', $settings['stat_medals_custom_value'] ?? 50) }}" min="0" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs sm:text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary focus:border-brand-primary">
                        </div>
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Simbol Suffix</label>
                            <input type="text" name="stat_medals_suffix" value="{{ old('stat_medals_suffix', $settings['stat_medals_suffix'] ?? '+') }}" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs sm:text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary focus:border-brand-primary">
                        </div>
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Label Teks</label>
                            <input type="text" name="stat_medals_label" value="{{ old('stat_medals_label', $settings['stat_medals_label'] ?? 'Medali Kejuaraan') }}" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary focus:border-brand-primary">
                        </div>
                    </div>
                </div>

                <!-- STAT 4: EVENT DIIKUTI -->
                <div class="p-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/40 space-y-4">
                    <div class="flex items-center justify-between pb-2 border-b border-slate-200 dark:border-slate-700/60">
                        <div class="flex items-center gap-2">
                            <span class="text-base">🏆</span>
                            <span class="text-xs font-extrabold text-slate-900 dark:text-white uppercase tracking-wider">Stat 4: Event Diikuti</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="stat_events_active" value="1" {{ ($settings['stat_events_active'] ?? true) ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-9 h-5 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-brand-primary"></div>
                            <span class="ml-2 text-xs font-bold text-slate-700 dark:text-slate-300">Tampilkan</span>
                        </label>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Mode Event</label>
                        <select name="stat_events_mode" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary focus:border-brand-primary cursor-pointer">
                            <option value="manual" {{ ($settings['stat_events_mode'] ?? '') === 'manual' ? 'selected' : '' }}>
                                ✍️ Input Biasa / Manual (Sesuai keinginan)
                            </option>
                            <option value="auto" {{ ($settings['stat_events_mode'] ?? '') === 'auto' ? 'selected' : '' }}>
                                ⚡ Otomatis: Hitung dari Event Unik Kejuaraan (Total: {{ $realStats['events_auto_count'] }} event unik)
                            </option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Jumlah Event</label>
                            <input type="number" name="stat_events_value" value="{{ old('stat_events_value', $settings['stat_events_value'] ?? 20) }}" min="0" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs sm:text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary focus:border-brand-primary">
                        </div>
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Simbol Suffix</label>
                            <input type="text" name="stat_events_suffix" value="{{ old('stat_events_suffix', $settings['stat_events_suffix'] ?? '+') }}" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs sm:text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary focus:border-brand-primary">
                        </div>
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Label Teks</label>
                            <input type="text" name="stat_events_label" value="{{ old('stat_events_label', $settings['stat_events_label'] ?? 'Event Diikuti') }}" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary focus:border-brand-primary">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ═════════════════════════════════════════════════════
             BAGIAN 2: TOGGLE AKTIF / NONAKTIF SEKSI LANDING PAGE
             ═════════════════════════════════════════════════════ -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm p-5 sm:p-6 transition-colors">
            <div class="border-b border-slate-100 dark:border-slate-800 pb-4 mb-6">
                <h2 class="text-base sm:text-lg font-black text-slate-900 dark:text-white flex items-center gap-2">
                    <span>🔘</span>
                    <span>Visibilitas Seksi Landing Page</span>
                </h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Aktifkan atau nonaktifkan seksi tertentu yang ingin ditampilkan atau disembunyikan dari halaman utama.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Seksi Hero -->
                <div class="p-4 rounded-xl border border-slate-200/80 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-red-100 dark:bg-red-950/60 text-brand-primary flex items-center justify-center font-bold text-sm shrink-0">
                            01
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white">Seksi Hero Banner</p>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">Judul utama & tombol aksi</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="section_hero" value="1" {{ ($settings['section_hero'] ?? true) ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-10 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-primary"></div>
                    </label>
                </div>

                <!-- Seksi Hero Stats Bar -->
                <div class="p-4 rounded-xl border border-slate-200/80 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-blue-100 dark:bg-blue-950/60 text-blue-600 flex items-center justify-center font-bold text-sm shrink-0">
                            02
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white">Hero Stats Bar</p>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">Baris 4 angka statistik</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="section_stats" value="1" {{ ($settings['section_stats'] ?? true) ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-10 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-primary"></div>
                    </label>
                </div>

                <!-- Seksi Tentang Kami -->
                <div class="p-4 rounded-xl border border-slate-200/80 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-emerald-100 dark:bg-emerald-950/60 text-emerald-600 flex items-center justify-center font-bold text-sm shrink-0">
                            03
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white">Tentang Kami</p>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">Pilar kihon, kata & kumite</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="section_about" value="1" {{ ($settings['section_about'] ?? true) ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-10 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-primary"></div>
                    </label>
                </div>

                <!-- Seksi Prestasi Kejuaraan -->
                <div class="p-4 rounded-xl border border-slate-200/80 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-amber-100 dark:bg-amber-950/60 text-amber-600 flex items-center justify-center font-bold text-sm shrink-0">
                            04
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white">Prestasi Kejuaraan</p>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">Daftar rekam jejak kemenangan</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="section_achievements" value="1" {{ ($settings['section_achievements'] ?? true) ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-10 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-primary"></div>
                    </label>
                </div>

                <!-- Seksi Jadwal Latihan -->
                <div class="p-4 rounded-xl border border-slate-200/80 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-cyan-100 dark:bg-cyan-950/60 text-cyan-600 flex items-center justify-center font-bold text-sm shrink-0">
                            05
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white">Jadwal Latihan</p>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">Tabel sesi mingguan & lokasi</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="section_schedule" value="1" {{ ($settings['section_schedule'] ?? true) ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-10 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-primary"></div>
                    </label>
                </div>

                <!-- Seksi Galeri -->
                <div class="p-4 rounded-xl border border-slate-200/80 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-purple-100 dark:bg-purple-950/60 text-purple-600 flex items-center justify-center font-bold text-sm shrink-0">
                            06
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white">Galeri Momen</p>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">Foto dokumentasi & lightbox</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="section_gallery" value="1" {{ ($settings['section_gallery'] ?? true) ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-10 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-primary"></div>
                    </label>
                </div>

                <!-- Seksi Cara Bergabung -->
                <div class="p-4 rounded-xl border border-slate-200/80 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-rose-100 dark:bg-rose-950/60 text-rose-600 flex items-center justify-center font-bold text-sm shrink-0">
                            07
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white">Cara Bergabung</p>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">Alur pendaftaran & tombol CTA</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="section_join" value="1" {{ ($settings['section_join'] ?? true) ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-10 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-primary"></div>
                    </label>
                </div>

                <!-- Seksi Footer -->
                <div class="p-4 rounded-xl border border-slate-200/80 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-300 flex items-center justify-center font-bold text-sm shrink-0">
                            08
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white">Footer Halaman</p>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">Navigasi bawah & hak cipta</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="section_footer" value="1" {{ ($settings['section_footer'] ?? true) ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-10 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-primary"></div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Tombol Simpan Perubahan -->
        <div class="flex items-center justify-end gap-3 pt-2">
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-brand-primary to-brand-secondary hover:from-brand-primary/90 hover:to-brand-secondary/90 text-white font-bold text-sm rounded-xl shadow-lg shadow-brand-primary/25 hover:shadow-xl transition-all active:scale-[0.99]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>Simpan Seluruh Pengaturan</span>
            </button>
        </div>
    </form>
</div>
@endsection
