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

    <form action="{{ route('admin.landing-page.settings.update') }}" method="POST" enctype="multipart/form-data" id="landing-settings-form" class="space-y-6">
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
                <span class="text-[11px] px-2.5 py-1 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 text-emerald-700 dark:text-emerald-300 font-bold rounded-lg self-start sm:self-auto flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Live Reactive Preview</span>
                </span>
            </div>

            <!-- Preview Card Bar (Real-time Updated) -->
            <div class="mb-6 p-4 sm:p-5 rounded-2xl bg-slate-950 text-white border border-slate-800 shadow-inner">
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-3 flex items-center justify-between">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                        <span>Preview Tampilan Hero Stats di Landing Page (Real-Time)</span>
                    </div>
                    <span class="text-[9px] text-slate-400 italic">Perubahan langsung ter-update otomatis di kotak ini</span>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-center divide-x divide-slate-800/80">
                    <!-- Stat 1 Preview -->
                    <div id="preview-stat-1" class="p-2 transition-all duration-200">
                        <div id="preview-stat-1-num" class="text-xl sm:text-2xl font-black text-red-500">{{ $settings['stat_founded_year'] ?? 2016 }}</div>
                        <div id="preview-stat-1-label" class="text-xs font-semibold text-slate-300 mt-0.5">{{ $settings['stat_founded_label'] ?? 'Tahun Berdiri' }}</div>
                        <span id="preview-stat-1-status" class="text-[10px] font-bold block mt-1.5 {{ ($settings['stat_founded_active'] ?? true) ? 'text-emerald-400' : 'text-slate-500 line-through' }}">
                            {{ ($settings['stat_founded_active'] ?? true) ? '● Aktif' : '○ Sembunyi' }}
                        </span>
                    </div>

                    <!-- Stat 2 Preview -->
                    <div id="preview-stat-2" class="p-2 transition-all duration-200">
                        <div id="preview-stat-2-num" class="text-xl sm:text-2xl font-black text-white">80+</div>
                        <div id="preview-stat-2-label" class="text-xs font-semibold text-slate-300 mt-0.5">{{ $settings['stat_members_label'] ?? 'Anggota Aktif' }}</div>
                        <span id="preview-stat-2-status" class="text-[10px] font-bold block mt-1.5 {{ ($settings['stat_members_active'] ?? true) ? 'text-emerald-400' : 'text-slate-500 line-through' }}">
                            {{ ($settings['stat_members_active'] ?? true) ? '● Aktif' : '○ Sembunyi' }}
                        </span>
                    </div>

                    <!-- Stat 3 Preview -->
                    <div id="preview-stat-3" class="p-2 transition-all duration-200">
                        <div id="preview-stat-3-num" class="text-xl sm:text-2xl font-black text-blue-400">50+</div>
                        <div id="preview-stat-3-label" class="text-xs font-semibold text-slate-300 mt-0.5">{{ $settings['stat_medals_label'] ?? 'Medali Kejuaraan' }}</div>
                        <span id="preview-stat-3-status" class="text-[10px] font-bold block mt-1.5 {{ ($settings['stat_medals_active'] ?? true) ? 'text-emerald-400' : 'text-slate-500 line-through' }}">
                            {{ ($settings['stat_medals_active'] ?? true) ? '● Aktif' : '○ Sembunyi' }}
                        </span>
                    </div>

                    <!-- Stat 4 Preview -->
                    <div id="preview-stat-4" class="p-2 transition-all duration-200">
                        <div id="preview-stat-4-num" class="text-xl sm:text-2xl font-black text-white">20+</div>
                        <div id="preview-stat-4-label" class="text-xs font-semibold text-slate-300 mt-0.5">{{ $settings['stat_events_label'] ?? 'Event Diikuti' }}</div>
                        <span id="preview-stat-4-status" class="text-[10px] font-bold block mt-1.5 {{ ($settings['stat_events_active'] ?? true) ? 'text-emerald-400' : 'text-slate-500 line-through' }}">
                            {{ ($settings['stat_events_active'] ?? true) ? '● Aktif' : '○ Sembunyi' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- ── STAT 1: TAHUN BERDIRI ─────────────────── -->
                <div class="p-5 rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/40 space-y-4 shadow-2xs">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-200 dark:border-slate-700/60">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-red-100 dark:bg-red-950/60 text-brand-primary flex items-center justify-center text-sm font-black">
                                01
                            </div>
                            <div>
                                <span class="text-xs font-black text-slate-900 dark:text-white uppercase tracking-wider block">Tahun Berdiri</span>
                                <span class="text-[10px] text-slate-500">Angka tahun berdirinya UKM</span>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="stat_founded_active" name="stat_founded_active" value="1" {{ ($settings['stat_founded_active'] ?? true) ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-9 h-5 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-brand-primary"></div>
                            <span class="ml-2 text-xs font-bold text-slate-700 dark:text-slate-300">Tampilkan</span>
                        </label>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Tahun Berdiri</label>
                            <input type="number" id="stat_founded_year" name="stat_founded_year" value="{{ old('stat_founded_year', $settings['stat_founded_year'] ?? 2016) }}" min="1950" max="2099" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs sm:text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary focus:border-brand-primary">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Label Teks</label>
                            <input type="text" id="stat_founded_label" name="stat_founded_label" value="{{ old('stat_founded_label', $settings['stat_founded_label'] ?? 'Tahun Berdiri') }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary focus:border-brand-primary">
                        </div>
                    </div>
                </div>

                <!-- ── STAT 2: ANGGOTA AKTIF ─────────────────── -->
                <div class="p-5 rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/40 space-y-4 shadow-2xs">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-200 dark:border-slate-700/60">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-950/60 text-blue-600 flex items-center justify-center text-sm font-black">
                                02
                            </div>
                            <div>
                                <span class="text-xs font-black text-slate-900 dark:text-white uppercase tracking-wider block">Anggota Aktif</span>
                                <span class="text-[10px] text-slate-500">Hitung otomatis atau manual</span>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="stat_members_active" name="stat_members_active" value="1" {{ ($settings['stat_members_active'] ?? true) ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-9 h-5 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-brand-primary"></div>
                            <span class="ml-2 text-xs font-bold text-slate-700 dark:text-slate-300">Tampilkan</span>
                        </label>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Mode Perhitungan Angka</label>
                        <select name="stat_members_mode" id="stat_members_mode" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary focus:border-brand-primary cursor-pointer">
                            <option value="auto_polindra" {{ ($settings['stat_members_mode'] ?? '') === 'auto_polindra' ? 'selected' : '' }}>
                                ⚡ Otomatis: Hitung Kohai Polindra (Saat ini: {{ $realStats['kohai_polindra_count'] }} akun)
                            </option>
                            <option value="auto_all" {{ ($settings['stat_members_mode'] ?? '') === 'auto_all' ? 'selected' : '' }}>
                                ⚡ Otomatis: Hitung Seluruh Kohai (Saat ini: {{ $realStats['kohai_all_count'] }} akun)
                            </option>
                            <option value="manual" {{ ($settings['stat_members_mode'] ?? '') === 'manual' ? 'selected' : '' }}>
                                ✍️ Manual: Input angka kustom sendiri
                            </option>
                        </select>
                    </div>

                    <!-- Dynamic Auto Info Box (Tampil saat mode Otomatis) -->
                    <div id="members_auto_info" class="p-3 rounded-xl bg-blue-50/80 dark:bg-blue-950/40 border border-blue-200/80 dark:border-blue-800/60 text-xs text-blue-900 dark:text-blue-300 font-medium flex items-center gap-2">
                        <span class="text-base">⚡</span>
                        <div>
                            <span class="font-bold">Mode Otomatis Aktif:</span> Angka dihitung langsung dari total akun Kohai di database (<span id="members_auto_count_val" class="font-bold underline">{{ $realStats['kohai_polindra_count'] }}</span> anggota). Input angka dinonaktifkan.
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <!-- Custom value input (Hanya muncul saat mode Manual) -->
                        <div id="members_custom_container" class="sm:col-span-1 hidden">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Angka Manual</label>
                            <input type="number" id="stat_members_custom_value" name="stat_members_custom_value" value="{{ old('stat_members_custom_value', $settings['stat_members_custom_value'] ?? 80) }}" min="0" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs sm:text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                        </div>
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Simbol Suffix</label>
                            <input type="text" id="stat_members_suffix" name="stat_members_suffix" value="{{ old('stat_members_suffix', $settings['stat_members_suffix'] ?? '+') }}" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs sm:text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                        </div>
                        <div id="members_label_container" class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Label Teks</label>
                            <input type="text" id="stat_members_label" name="stat_members_label" value="{{ old('stat_members_label', $settings['stat_members_label'] ?? 'Anggota Aktif') }}" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                        </div>
                    </div>
                </div>

                <!-- ── STAT 3: MEDALI KEJUARAAN ──────────────── -->
                <div class="p-5 rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/40 space-y-4 shadow-2xs">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-200 dark:border-slate-700/60">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-amber-100 dark:bg-amber-950/60 text-amber-600 flex items-center justify-center text-sm font-black">
                                03
                            </div>
                            <div>
                                <span class="text-xs font-black text-slate-900 dark:text-white uppercase tracking-wider block">Medali Kejuaraan</span>
                                <span class="text-[10px] text-slate-500">Hitung otomatis dari input prestasi</span>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="stat_medals_active" name="stat_medals_active" value="1" {{ ($settings['stat_medals_active'] ?? true) ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-9 h-5 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-brand-primary"></div>
                            <span class="ml-2 text-xs font-bold text-slate-700 dark:text-slate-300">Tampilkan</span>
                        </label>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Mode Perhitungan Medali</label>
                        <select name="stat_medals_mode" id="stat_medals_mode" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary focus:border-brand-primary cursor-pointer">
                            <option value="auto" {{ ($settings['stat_medals_mode'] ?? '') === 'auto' ? 'selected' : '' }}>
                                ⚡ Otomatis: Hitung dari input Prestasi (Saat ini: {{ $realStats['medals_auto_count'] }} medali aktif)
                            </option>
                            <option value="manual" {{ ($settings['stat_medals_mode'] ?? '') === 'manual' ? 'selected' : '' }}>
                                ✍️ Manual: Input angka kustom sendiri
                            </option>
                        </select>
                    </div>

                    <!-- Dynamic Auto Info Box (Tampil saat mode Otomatis) -->
                    <div id="medals_auto_info" class="p-3 rounded-xl bg-amber-50/80 dark:bg-amber-950/40 border border-amber-200/80 dark:border-amber-800/60 text-xs text-amber-900 dark:text-amber-300 font-medium flex items-center gap-2">
                        <span class="text-base">🥇</span>
                        <div>
                            <span class="font-bold">Mode Otomatis Aktif:</span> Angka dihitung dari data <a href="{{ route('admin.achievements.index') }}" class="underline font-bold">Prestasi Kejuaraan</a> (<span class="font-bold underline">{{ $realStats['medals_auto_count'] }}</span> medali). Input angka dinonaktifkan.
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <!-- Custom value input (Hanya muncul saat mode Manual) -->
                        <div id="medals_custom_container" class="sm:col-span-1 hidden">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Angka Manual</label>
                            <input type="number" id="stat_medals_custom_value" name="stat_medals_custom_value" value="{{ old('stat_medals_custom_value', $settings['stat_medals_custom_value'] ?? 50) }}" min="0" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs sm:text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                        </div>
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Simbol Suffix</label>
                            <input type="text" id="stat_medals_suffix" name="stat_medals_suffix" value="{{ old('stat_medals_suffix', $settings['stat_medals_suffix'] ?? '+') }}" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs sm:text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                        </div>
                        <div id="medals_label_container" class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Label Teks</label>
                            <input type="text" id="stat_medals_label" name="stat_medals_label" value="{{ old('stat_medals_label', $settings['stat_medals_label'] ?? 'Medali Kejuaraan') }}" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                        </div>
                    </div>
                </div>

                <!-- ── STAT 4: EVENT DIIKUTI ─────────────────── -->
                <div class="p-5 rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/40 space-y-4 shadow-2xs">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-200 dark:border-slate-700/60">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-950/60 text-emerald-600 flex items-center justify-center text-sm font-black">
                                04
                            </div>
                            <div>
                                <span class="text-xs font-black text-slate-900 dark:text-white uppercase tracking-wider block">Event Diikuti</span>
                                <span class="text-[10px] text-slate-500">Input biasa atau hitung otomatis</span>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="stat_events_active" name="stat_events_active" value="1" {{ ($settings['stat_events_active'] ?? true) ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-9 h-5 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-brand-primary"></div>
                            <span class="ml-2 text-xs font-bold text-slate-700 dark:text-slate-300">Tampilkan</span>
                        </label>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Mode Event</label>
                        <select name="stat_events_mode" id="stat_events_mode" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary focus:border-brand-primary cursor-pointer">
                            <option value="manual" {{ ($settings['stat_events_mode'] ?? '') === 'manual' ? 'selected' : '' }}>
                                ✍️ Input Biasa / Manual (Sesuai keinginan)
                            </option>
                            <option value="auto" {{ ($settings['stat_events_mode'] ?? '') === 'auto' ? 'selected' : '' }}>
                                ⚡ Otomatis: Hitung dari Event Unik Kejuaraan (Saat ini: {{ $realStats['events_auto_count'] }} event)
                            </option>
                        </select>
                    </div>

                    <!-- Dynamic Auto Info Box (Tampil saat mode Otomatis) -->
                    <div id="events_auto_info" class="p-3 rounded-xl bg-emerald-50/80 dark:bg-emerald-950/40 border border-emerald-200/80 dark:border-emerald-800/60 text-xs text-emerald-900 dark:text-emerald-300 font-medium flex items-center gap-2 hidden">
                        <span class="text-base">🏆</span>
                        <div>
                            <span class="font-bold">Mode Otomatis Aktif:</span> Angka dihitung dari nama event unik di data prestasi (<span class="font-bold underline">{{ $realStats['events_auto_count'] }}</span> event). Input angka dinonaktifkan.
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <!-- Custom value input (Hanya muncul saat mode Manual) -->
                        <div id="events_custom_container" class="sm:col-span-1">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Jumlah Event</label>
                            <input type="number" id="stat_events_value" name="stat_events_value" value="{{ old('stat_events_value', $settings['stat_events_value'] ?? 20) }}" min="0" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs sm:text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                        </div>
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Simbol Suffix</label>
                            <input type="text" id="stat_events_suffix" name="stat_events_suffix" value="{{ old('stat_events_suffix', $settings['stat_events_suffix'] ?? '+') }}" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs sm:text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                        </div>
                        <div id="events_label_container" class="sm:col-span-1">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Label Teks</label>
                            <input type="text" id="stat_events_label" name="stat_events_label" value="{{ old('stat_events_label', $settings['stat_events_label'] ?? 'Event Diikuti') }}" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ═════════════════════════════════════════════════════
             BAGIAN 2: PENGATURAN SEKSI TENTANG KAMI (ABOUT US)
             ═════════════════════════════════════════════════════ -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm p-5 sm:p-6 transition-colors">
            <div class="border-b border-slate-100 dark:border-slate-800 pb-4 mb-6">
                <div class="flex items-center gap-2">
                    <span class="text-xl">🥋</span>
                    <h2 class="text-base sm:text-lg font-black text-slate-900 dark:text-white">Pengaturan Seksi Tentang Kami (About Us)</h2>
                </div>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Kelola foto utama tim/kegiatan, narasi penjelasan organisasi, dan teks 4 pilar latihan (Kihon, Kata, Kumite, Kompetisi).</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Kolom Kiri: Foto Utama (4 Kolom) -->
                <div class="lg:col-span-4 space-y-4">
                    <div class="p-4 rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30 space-y-3">
                        <label class="block text-xs font-bold text-slate-800 dark:text-slate-200">
                            Foto Seksi Tentang Kami
                        </label>

                        <!-- Box Preview Gambar -->
                        <div class="relative w-full aspect-4/3 rounded-xl overflow-hidden border-2 border-dashed border-slate-300 dark:border-slate-700 bg-slate-100 dark:bg-slate-800 flex items-center justify-center group shadow-inner">
                            @php
                                $currentAboutImg = $settings['about_image'] ?? null;
                                $hasCustomImg = !empty($currentAboutImg) && file_exists(public_path($currentAboutImg));
                                $imgSrc = $hasCustomImg ? asset($currentAboutImg) : (file_exists(public_path('images/landing/about-team.jpeg')) ? asset('images/landing/about-team.jpeg') : null);
                            @endphp

                            @if($imgSrc)
                                <img id="about-img-preview" src="{{ $imgSrc }}" alt="Preview Foto Tentang Kami" class="w-full h-full object-cover">
                            @else
                                <div id="about-img-placeholder" class="text-center p-4 text-slate-400">
                                    <svg class="w-10 h-10 mx-auto mb-1 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span class="text-xs">Belum ada foto</span>
                                </div>
                            @endif

                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <label for="about_image" class="px-3 py-1.5 bg-white/90 text-slate-900 rounded-lg text-xs font-bold cursor-pointer hover:bg-white shadow">
                                    Ganti Foto
                                </label>
                            </div>
                        </div>

                        <!-- Status Gambar -->
                        <div class="flex items-center justify-between text-[11px]">
                            <span class="font-medium text-slate-500 dark:text-slate-400">Status Foto:</span>
                            @if($hasCustomImg)
                                <span class="px-2 py-0.5 rounded-full bg-blue-100 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 font-bold">Foto Kustom Aktif</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold">Foto Default Bawaan</span>
                            @endif
                        </div>

                        <!-- Input File -->
                        <div>
                            <input type="file" id="about_image" name="about_image" accept="image/jpeg,image/png,image/jpg,image/webp" class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-red-50 file:text-brand-primary hover:file:bg-red-100 dark:file:bg-red-950/60 dark:file:text-red-300 cursor-pointer">
                        </div>

                        @if($hasCustomImg)
                            <!-- Option to reset to default -->
                            <div class="pt-2 border-t border-slate-200 dark:border-slate-700/60">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="delete_about_image" value="1" class="rounded border-slate-300 text-brand-primary focus:ring-brand-primary">
                                    <span class="text-xs font-medium text-rose-600 dark:text-rose-400">Kembalikan ke Foto Default Bawaan</span>
                                </label>
                            </div>
                        @endif

                        <p class="text-[10px] text-slate-400 dark:text-slate-500 leading-relaxed">
                            💡 Format: JPG, PNG, WEBP (Maks. 5MB). Ketika foto baru diunggah, file foto lama akan <strong>otomatis terhapus</strong> dari server.
                        </p>
                    </div>
                </div>

                <!-- Kolom Kanan: Teks Judul & Penjelasan (8 Kolom) -->
                <div class="lg:col-span-8 space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-3.5">
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Badge Label</label>
                            <input type="text" name="about_badge_label" value="{{ old('about_badge_label', $settings['about_badge_label'] ?? 'Tentang Kami') }}" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs sm:text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                        </div>
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Judul Baris 1</label>
                            <input type="text" name="about_title_1" value="{{ old('about_title_1', $settings['about_title_1'] ?? 'Disiplin') }}" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs sm:text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                        </div>
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Judul Baris 2</label>
                            <input type="text" name="about_title_2" value="{{ old('about_title_2', $settings['about_title_2'] ?? 'Membentuk') }}" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs sm:text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                        </div>
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Kata Aksen/Italic</label>
                            <input type="text" name="about_title_highlight" value="{{ old('about_title_highlight', $settings['about_title_highlight'] ?? 'Juara') }}" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs sm:text-sm font-bold text-brand-primary focus:ring-2 focus:ring-brand-primary">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Paragraf Penjelasan 1 (Wajib)</label>
                        <textarea name="about_description_1" rows="3" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs sm:text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary resize-none leading-relaxed">{{ old('about_description_1', $settings['about_description_1'] ?? 'UKM Karate Politeknik Negeri Indramayu adalah wadah resmi bagi mahasiswa yang ingin mengembangkan kemampuan bela diri karate di lingkungan kampus. Kami bernaung di bawah WKF (World Karate Federation) dan aktif mengikuti berbagai kejuaraan tingkat regional maupun nasional.') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Paragraf Penjelasan 2 (Opsional)</label>
                        <textarea name="about_description_2" rows="2" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs sm:text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary resize-none leading-relaxed">{{ old('about_description_2', $settings['about_description_2'] ?? 'Dengan pelatih berpengalaman dan program latihan terstruktur, kami memastikan setiap anggota berkembang — baik dalam teknik, mental, maupun karakter.') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- ── 4 PILAR LATIHAN ────────────────────────────── -->
            <div class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-800">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-5">
                    <div>
                        <h3 class="text-sm font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                            <span>⚡</span>
                            <span>Pengaturan 4 Pilar Latihan (Kihon, Kata, Kumite, Kompetisi)</span>
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                            Pilih pilar yang ingin ditampilkan di Landing Page (Bisa 1, 2, 3, 4 pilar, atau dinonaktifkan semua).
                        </p>
                    </div>
                    <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 px-3 py-1 rounded-full self-start sm:self-auto">
                        Layout otomatis menyesuaikan jumlah pilar aktif
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- ── PILAR 1 ── -->
                    @php $p1Active = $settings['about_pillar_1_active'] ?? true; @endphp
                    <div id="pillar-card-1" class="p-4 sm:p-5 rounded-2xl border transition-all {{ $p1Active ? 'border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-slate-800/50' : 'border-dashed border-slate-300 dark:border-slate-800 bg-slate-100/40 dark:bg-slate-900/40 opacity-60' }} space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-200/80 dark:border-slate-700/60">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-lg bg-amber-100 dark:bg-amber-950/60 text-amber-700 dark:text-amber-400 text-xs font-black flex items-center justify-center">01</span>
                                <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Pilar Pertama</span>
                            </div>
                            <label class="flex items-center gap-2 cursor-pointer select-none">
                                <span class="text-[11px] font-bold {{ $p1Active ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400' }}">Tampilkan</span>
                                <input type="checkbox" name="about_pillar_1_active" value="1" {{ $p1Active ? 'checked' : '' }} onchange="document.getElementById('pillar-card-1').classList.toggle('opacity-60', !this.checked)" class="rounded border-slate-300 text-brand-primary focus:ring-brand-primary w-4 h-4">
                            </label>
                        </div>
                        <div class="space-y-3">
                            <div class="grid grid-cols-12 gap-3">
                                <div class="col-span-3 sm:col-span-3">
                                    <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Emoji / Icon</label>
                                    <input type="text" name="about_pillar_1_icon" value="{{ old('about_pillar_1_icon', $settings['about_pillar_1_icon'] ?? '⚡') }}" required class="w-full text-center text-lg h-10 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                                </div>
                                <div class="col-span-9 sm:col-span-9">
                                    <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Nama Pilar</label>
                                    <input type="text" name="about_pillar_1_title" value="{{ old('about_pillar_1_title', $settings['about_pillar_1_title'] ?? 'Kihon') }}" placeholder="Contoh: Kihon" required class="w-full px-3.5 h-10 text-xs sm:text-sm font-bold rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Deskripsi / Penjelasan Singkat</label>
                                <textarea name="about_pillar_1_desc" rows="2" placeholder="Penjelasan singkat materi latihan..." required class="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-200 resize-none leading-relaxed focus:ring-2 focus:ring-brand-primary">{{ old('about_pillar_1_desc', $settings['about_pillar_1_desc'] ?? 'Latihan teknik dasar yang konsisten setiap sesi') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- ── PILAR 2 ── -->
                    @php $p2Active = $settings['about_pillar_2_active'] ?? true; @endphp
                    <div id="pillar-card-2" class="p-4 sm:p-5 rounded-2xl border transition-all {{ $p2Active ? 'border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-slate-800/50' : 'border-dashed border-slate-300 dark:border-slate-800 bg-slate-100/40 dark:bg-slate-900/40 opacity-60' }} space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-200/80 dark:border-slate-700/60">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-lg bg-red-100 dark:bg-red-950/60 text-red-700 dark:text-red-400 text-xs font-black flex items-center justify-center">02</span>
                                <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Pilar Kedua</span>
                            </div>
                            <label class="flex items-center gap-2 cursor-pointer select-none">
                                <span class="text-[11px] font-bold {{ $p2Active ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400' }}">Tampilkan</span>
                                <input type="checkbox" name="about_pillar_2_active" value="1" {{ $p2Active ? 'checked' : '' }} onchange="document.getElementById('pillar-card-2').classList.toggle('opacity-60', !this.checked)" class="rounded border-slate-300 text-brand-primary focus:ring-brand-primary w-4 h-4">
                            </label>
                        </div>
                        <div class="space-y-3">
                            <div class="grid grid-cols-12 gap-3">
                                <div class="col-span-3 sm:col-span-3">
                                    <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Emoji / Icon</label>
                                    <input type="text" name="about_pillar_2_icon" value="{{ old('about_pillar_2_icon', $settings['about_pillar_2_icon'] ?? '🥋') }}" required class="w-full text-center text-lg h-10 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                                </div>
                                <div class="col-span-9 sm:col-span-9">
                                    <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Nama Pilar</label>
                                    <input type="text" name="about_pillar_2_title" value="{{ old('about_pillar_2_title', $settings['about_pillar_2_title'] ?? 'Kata') }}" placeholder="Contoh: Kata" required class="w-full px-3.5 h-10 text-xs sm:text-sm font-bold rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Deskripsi / Penjelasan Singkat</label>
                                <textarea name="about_pillar_2_desc" rows="2" placeholder="Penjelasan singkat materi latihan..." required class="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-200 resize-none leading-relaxed focus:ring-2 focus:ring-brand-primary">{{ old('about_pillar_2_desc', $settings['about_pillar_2_desc'] ?? 'Rangkaian gerakan terstandar sebagai fondasi seni') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- ── PILAR 3 ── -->
                    @php $p3Active = $settings['about_pillar_3_active'] ?? true; @endphp
                    <div id="pillar-card-3" class="p-4 sm:p-5 rounded-2xl border transition-all {{ $p3Active ? 'border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-slate-800/50' : 'border-dashed border-slate-300 dark:border-slate-800 bg-slate-100/40 dark:bg-slate-900/40 opacity-60' }} space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-200/80 dark:border-slate-700/60">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-lg bg-blue-100 dark:bg-blue-950/60 text-blue-700 dark:text-blue-400 text-xs font-black flex items-center justify-center">03</span>
                                <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Pilar Ketiga</span>
                            </div>
                            <label class="flex items-center gap-2 cursor-pointer select-none">
                                <span class="text-[11px] font-bold {{ $p3Active ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400' }}">Tampilkan</span>
                                <input type="checkbox" name="about_pillar_3_active" value="1" {{ $p3Active ? 'checked' : '' }} onchange="document.getElementById('pillar-card-3').classList.toggle('opacity-60', !this.checked)" class="rounded border-slate-300 text-brand-primary focus:ring-brand-primary w-4 h-4">
                            </label>
                        </div>
                        <div class="space-y-3">
                            <div class="grid grid-cols-12 gap-3">
                                <div class="col-span-3 sm:col-span-3">
                                    <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Emoji / Icon</label>
                                    <input type="text" name="about_pillar_3_icon" value="{{ old('about_pillar_3_icon', $settings['about_pillar_3_icon'] ?? '🥊') }}" required class="w-full text-center text-lg h-10 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                                </div>
                                <div class="col-span-9 sm:col-span-9">
                                    <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Nama Pilar</label>
                                    <input type="text" name="about_pillar_3_title" value="{{ old('about_pillar_3_title', $settings['about_pillar_3_title'] ?? 'Kumite') }}" placeholder="Contoh: Kumite" required class="w-full px-3.5 h-10 text-xs sm:text-sm font-bold rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Deskripsi / Penjelasan Singkat</label>
                                <textarea name="about_pillar_3_desc" rows="2" placeholder="Penjelasan singkat materi latihan..." required class="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-200 resize-none leading-relaxed focus:ring-2 focus:ring-brand-primary">{{ old('about_pillar_3_desc', $settings['about_pillar_3_desc'] ?? 'Pertarungan terkontrol untuk mengasah insting & refleks') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- ── PILAR 4 ── -->
                    @php $p4Active = $settings['about_pillar_4_active'] ?? true; @endphp
                    <div id="pillar-card-4" class="p-4 sm:p-5 rounded-2xl border transition-all {{ $p4Active ? 'border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-slate-800/50' : 'border-dashed border-slate-300 dark:border-slate-800 bg-slate-100/40 dark:bg-slate-900/40 opacity-60' }} space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-200/80 dark:border-slate-700/60">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-lg bg-purple-100 dark:bg-purple-950/60 text-purple-700 dark:text-purple-400 text-xs font-black flex items-center justify-center">04</span>
                                <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Pilar Keempat</span>
                            </div>
                            <label class="flex items-center gap-2 cursor-pointer select-none">
                                <span class="text-[11px] font-bold {{ $p4Active ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400' }}">Tampilkan</span>
                                <input type="checkbox" name="about_pillar_4_active" value="1" {{ $p4Active ? 'checked' : '' }} onchange="document.getElementById('pillar-card-4').classList.toggle('opacity-60', !this.checked)" class="rounded border-slate-300 text-brand-primary focus:ring-brand-primary w-4 h-4">
                            </label>
                        </div>
                        <div class="space-y-3">
                            <div class="grid grid-cols-12 gap-3">
                                <div class="col-span-3 sm:col-span-3">
                                    <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Emoji / Icon</label>
                                    <input type="text" name="about_pillar_4_icon" value="{{ old('about_pillar_4_icon', $settings['about_pillar_4_icon'] ?? '🏆') }}" required class="w-full text-center text-lg h-10 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                                </div>
                                <div class="col-span-9 sm:col-span-9">
                                    <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Nama Pilar</label>
                                    <input type="text" name="about_pillar_4_title" value="{{ old('about_pillar_4_title', $settings['about_pillar_4_title'] ?? 'Kompetisi') }}" placeholder="Contoh: Kompetisi" required class="w-full px-3.5 h-10 text-xs sm:text-sm font-bold rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Deskripsi / Penjelasan Singkat</label>
                                <textarea name="about_pillar_4_desc" rows="2" placeholder="Penjelasan singkat materi latihan..." required class="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-200 resize-none leading-relaxed focus:ring-2 focus:ring-brand-primary">{{ old('about_pillar_4_desc', $settings['about_pillar_4_desc'] ?? 'Mengikuti kejuaraan sebagai uji kemampuan nyata') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ═════════════════════════════════════════════════════
             BAGIAN 3: PENGATURAN SEKSI JADWAL LATIHAN (SCHEDULE)
             ═════════════════════════════════════════════════════ -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm p-5 sm:p-6 transition-colors">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 dark:border-slate-800 pb-4 mb-6">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-xl">📅</span>
                        <h2 class="text-base sm:text-lg font-black text-slate-900 dark:text-white">Pengaturan Seksi Jadwal Latihan (Schedule)</h2>
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Kelola teks judul pengantar, deskripsi, informasi tempat latihan, dan tautan Google Maps.</p>
                </div>
                <a href="{{ route('admin.training-schedules.index') }}" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-blue-50 dark:bg-blue-950/60 border border-blue-200 dark:border-blue-800/60 text-blue-700 dark:text-blue-300 hover:bg-blue-100 dark:hover:bg-blue-900/60 text-xs font-bold transition shadow-2xs self-start sm:self-auto">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Kelola Data Jadwal ({{ $realStats['active_schedules'] ?? 0 }} Aktif / {{ $realStats['total_schedules'] ?? 0 }} Total) &rarr;</span>
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Kolom Kiri: Teks Pengantar Jadwal -->
                <div class="p-5 rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30 space-y-4">
                    <h3 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                        <span>📝</span>
                        <span>Teks Judul & Pengantar</span>
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Badge Label</label>
                            <input type="text" name="schedule_badge_label" value="{{ old('schedule_badge_label', $settings['schedule_badge_label'] ?? 'Latihan Rutin') }}" required class="w-full px-3.5 py-2 text-xs sm:text-sm font-bold rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Judul Baris 1</label>
                            <input type="text" name="schedule_title_1" value="{{ old('schedule_title_1', $settings['schedule_title_1'] ?? 'Jadwal') }}" required class="w-full px-3.5 py-2 text-xs sm:text-sm font-bold rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Kata Highlight (Merah)</label>
                            <input type="text" name="schedule_title_highlight" value="{{ old('schedule_title_highlight', $settings['schedule_title_highlight'] ?? 'Berlatih') }}" required class="w-full px-3.5 py-2 text-xs sm:text-sm font-bold rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-brand-primary focus:ring-2 focus:ring-brand-primary">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Judul Baris 2</label>
                        <input type="text" name="schedule_title_2" value="{{ old('schedule_title_2', $settings['schedule_title_2'] ?? 'Mingguan') }}" required class="w-full px-3.5 py-2 text-xs sm:text-sm font-bold rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Paragraf Deskripsi Pengantar</label>
                        <textarea name="schedule_description" rows="3" required class="w-full px-3.5 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary resize-none leading-relaxed">{{ old('schedule_description', $settings['schedule_description'] ?? 'Latihan terbuka untuk mahasiswa aktif Polindra. Pemula sangat dipersilakan — kami mulai dari nol bersama.') }}</textarea>
                    </div>
                </div>

                <!-- Kolom Kanan: Tempat & Google Maps -->
                <div class="p-5 rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30 space-y-4">
                    <h3 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                        <span>📍</span>
                        <span>Lokasi Latihan & Google Maps</span>
                    </h3>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Nama Tempat / Gedung</label>
                        <input type="text" name="schedule_location_name" value="{{ old('schedule_location_name', $settings['schedule_location_name'] ?? 'GOR / Hall Olahraga Polindra') }}" required placeholder="Contoh: GOR / Hall Olahraga Polindra" class="w-full px-3.5 py-2 text-xs sm:text-sm font-bold rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Alamat Lengkap</label>
                        <textarea name="schedule_location_address" rows="2" required placeholder="Contoh: Jl. Lohbener Lama No. 08, Indramayu, Jawa Barat" class="w-full px-3.5 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary resize-none">{{ old('schedule_location_address', $settings['schedule_location_address'] ?? 'Jl. Lohbener Lama No. 08, Indramayu, Jawa Barat') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Tautan / Link Google Maps (URL)</label>
                        <input type="url" name="schedule_maps_url" value="{{ old('schedule_maps_url', $settings['schedule_maps_url'] ?? '') }}" placeholder="https://maps.app.goo.gl/..." class="w-full px-3.5 py-2 text-xs sm:text-sm font-medium rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                        <span class="text-[10px] text-slate-400 mt-1 block">Tautan ini akan membuka lokasi dojo/latihan di Google Maps saat diklik pengunjung.</span>
                    </div>

                    <div class="p-3.5 rounded-xl bg-blue-50 dark:bg-blue-950/40 border border-blue-200/80 dark:border-blue-800/60 flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div class="text-[11px] text-blue-800 dark:text-blue-300 leading-relaxed">
                            Tabel jadwal latihan pada Landing Page otomatis mengambil seluruh jadwal bertipe <strong>Aktif</strong> yang dikelola pada menu <strong>Jadwal Latihan</strong>.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ═════════════════════════════════════════════════════
             BAGIAN 4: PENGATURAN SEKSI GALERI MOMEN (GALLERY)
             ═════════════════════════════════════════════════════ -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm p-5 sm:p-6 transition-colors">
            <div class="border-b border-slate-100 dark:border-slate-800 pb-4 mb-6">
                <div class="flex items-center gap-2">
                    <span class="text-xl">📸</span>
                    <h2 class="text-base sm:text-lg font-black text-slate-900 dark:text-white">Pengaturan Seksi Galeri Momen (Gallery)</h2>
                </div>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Atur judul pengantar serta ganti 5 foto dokumentasi momen terbaik yang tampil pada grid galeri Landing Page.</p>
            </div>

            <!-- Teks Judul & Narasi Galeri -->
            <div class="p-5 rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30 mb-6 space-y-4">
                <h3 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                    <span>📝</span>
                    <span>Teks Header Seksi Galeri</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Badge Label</label>
                        <input type="text" name="gallery_badge_label" value="{{ old('gallery_badge_label', $settings['gallery_badge_label'] ?? 'Galeri') }}" required class="w-full px-3.5 py-2 text-xs sm:text-sm font-bold rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Judul Baris 1</label>
                        <input type="text" name="gallery_title_1" value="{{ old('gallery_title_1', $settings['gallery_title_1'] ?? 'Momen') }}" required class="w-full px-3.5 py-2 text-xs sm:text-sm font-bold rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Kata Highlight (Merah)</label>
                        <input type="text" name="gallery_title_highlight" value="{{ old('gallery_title_highlight', $settings['gallery_title_highlight'] ?? 'Terbaik') }}" required class="w-full px-3.5 py-2 text-xs sm:text-sm font-bold rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-brand-primary focus:ring-2 focus:ring-brand-primary">
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Deskripsi Samping Header</label>
                    <textarea name="gallery_description" rows="2" required class="w-full px-3.5 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary resize-none leading-relaxed">{{ old('gallery_description', $settings['gallery_description'] ?? 'Setiap latihan, setiap pertandingan — diabadikan.') }}</textarea>
                </div>
            </div>

            <!-- 5 Item Foto Galeri -->
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                        <span>🖼️</span>
                        <span>5 Slot Foto Dokumentasi & Label</span>
                    </h3>
                    <span class="text-[10px] text-slate-400">Foto lama otomatis terhapus saat foto baru diunggah</span>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
                    <!-- Foto 1: Slot Utama (Large) -->
                    @php
                        $g1Img = $settings['gallery_item_1_image'] ?? null;
                        $hasCustomG1 = !empty($g1Img) && file_exists(public_path($g1Img));
                        $g1Src = $hasCustomG1 ? asset($g1Img) : (file_exists(public_path('images/landing/gallery-1.jpeg')) ? asset('images/landing/gallery-1.jpeg') : null);
                    @endphp
                    <div class="lg:col-span-12 p-4 sm:p-5 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-slate-800/40">
                        <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-200/80 dark:border-slate-700/60">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded-lg bg-red-100 dark:bg-red-950/60 text-brand-primary text-xs font-black">Slot 01 (Utama / Lebar)</span>
                                <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Foto Utama Galeri</span>
                            </div>
                            @if($hasCustomG1)
                                <span class="px-2 py-0.5 text-[10px] rounded-full bg-blue-100 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 font-bold">Foto Kustom Aktif</span>
                            @else
                                <span class="px-2 py-0.5 text-[10px] rounded-full bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold">Foto Default</span>
                            @endif
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-center">
                            <div class="sm:col-span-4">
                                <div class="relative w-full aspect-16/9 rounded-xl overflow-hidden border border-slate-300 dark:border-slate-700 bg-slate-100 dark:bg-slate-900 flex items-center justify-center">
                                    @if($g1Src)
                                        <img id="gallery-preview-1" src="{{ $g1Src }}" alt="Preview Foto 1" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-xs text-slate-400">Belum ada foto</span>
                                    @endif
                                </div>
                            </div>
                            <div class="sm:col-span-8 space-y-3">
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Label / Judul Foto 01</label>
                                    <input type="text" name="gallery_item_1_label" value="{{ old('gallery_item_1_label', $settings['gallery_item_1_label'] ?? 'Sesi Latihan') }}" required placeholder="Contoh: Sesi Latihan" class="w-full px-3.5 py-2 text-xs sm:text-sm font-bold rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Upload File Foto Baru</label>
                                    <input type="file" id="gallery_item_1_image" name="gallery_item_1_image" accept="image/jpeg,image/png,image/jpg,image/webp" class="block w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-red-50 file:text-brand-primary hover:file:bg-red-100 dark:file:bg-red-950/60 dark:file:text-red-300 cursor-pointer">
                                </div>
                                @if($hasCustomG1)
                                    <label class="inline-flex items-center gap-2 cursor-pointer pt-1">
                                        <input type="checkbox" name="delete_gallery_item_1_image" value="1" class="rounded border-slate-300 text-brand-primary focus:ring-brand-primary">
                                        <span class="text-xs font-medium text-rose-600 dark:text-rose-400">Kembalikan ke Foto Default Bawaan</span>
                                    </label>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Foto 2 s/d 5: Grid 4 Kolom -->
                    @for($i = 2; $i <= 5; $i++)
                        @php
                            $gImg = $settings["gallery_item_{$i}_image"] ?? null;
                            $hasCustomG = !empty($gImg) && file_exists(public_path($gImg));
                            $gSrc = $hasCustomG ? asset($gImg) : (file_exists(public_path("images/landing/gallery-{$i}.jpeg")) ? asset("images/landing/gallery-{$i}.jpeg") : null);
                        @endphp
                        <div class="lg:col-span-3 sm:col-span-6 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-slate-800/40 space-y-3">
                            <div class="flex items-center justify-between pb-2 border-b border-slate-200/80 dark:border-slate-700/60">
                                <span class="px-2 py-0.5 rounded-lg bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs font-black">Slot 0{{ $i }}</span>
                                @if($hasCustomG)
                                    <span class="text-[10px] font-bold text-blue-600 dark:text-blue-400">Kustom</span>
                                @else
                                    <span class="text-[10px] text-slate-400">Default</span>
                                @endif
                            </div>

                            <div class="relative w-full aspect-4/3 rounded-xl overflow-hidden border border-slate-300 dark:border-slate-700 bg-slate-100 dark:bg-slate-900 flex items-center justify-center">
                                @if($gSrc)
                                    <img id="gallery-preview-{{ $i }}" src="{{ $gSrc }}" alt="Preview Foto {{ $i }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-xs text-slate-400">Belum ada foto</span>
                                @endif
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 mb-1">Label Foto</label>
                                <input type="text" name="gallery_item_{{ $i }}_label" value="{{ old("gallery_item_{$i}_label", $settings["gallery_item_{$i}_label"] ?? "Foto {$i}") }}" required class="w-full px-3 py-1.5 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 mb-1">Ganti Foto</label>
                                <input type="file" id="gallery_item_{{ $i }}_image" name="gallery_item_{{ $i }}_image" accept="image/jpeg,image/png,image/jpg,image/webp" class="block w-full text-[11px] text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:bg-red-50 file:text-brand-primary hover:file:bg-red-100 dark:file:bg-red-950/60 dark:file:text-red-300 cursor-pointer">
                            </div>

                            @if($hasCustomG)
                                <label class="inline-flex items-center gap-1.5 cursor-pointer pt-1">
                                    <input type="checkbox" name="delete_gallery_item_{{ $i }}_image" value="1" class="rounded border-slate-300 text-brand-primary focus:ring-brand-primary text-xs">
                                    <span class="text-[10px] font-medium text-rose-600 dark:text-rose-400">Reset Default</span>
                                </label>
                            @endif
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        <!-- ═════════════════════════════════════════════════════
             BAGIAN 5: TOGGLE AKTIF / NONAKTIF SEKSI LANDING PAGE
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

<!-- ═════════════════════════════════════════════════════
     LIVE REACTIVE JAVASCRIPT LOGIC
     ═════════════════════════════════════════════════════ -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Database real auto counts from PHP
    const realAutoData = {
        kohai_polindra: {{ (int) $realStats['kohai_polindra_count'] }},
        kohai_all: {{ (int) $realStats['kohai_all_count'] }},
        medals_auto: {{ (int) $realStats['medals_auto_count'] }},
        events_auto: {{ (int) $realStats['events_auto_count'] }}
    };

    // Elements
    const stat1Active = document.getElementById('stat_founded_active');
    const stat1Year = document.getElementById('stat_founded_year');
    const stat1Label = document.getElementById('stat_founded_label');

    const stat2Active = document.getElementById('stat_members_active');
    const stat2Mode = document.getElementById('stat_members_mode');
    const stat2CustomVal = document.getElementById('stat_members_custom_value');
    const stat2Suffix = document.getElementById('stat_members_suffix');
    const stat2Label = document.getElementById('stat_members_label');
    const membersAutoInfo = document.getElementById('members_auto_info');
    const membersCustomContainer = document.getElementById('members_custom_container');
    const membersLabelContainer = document.getElementById('members_label_container');
    const membersAutoCountVal = document.getElementById('members_auto_count_val');

    const stat3Active = document.getElementById('stat_medals_active');
    const stat3Mode = document.getElementById('stat_medals_mode');
    const stat3CustomVal = document.getElementById('stat_medals_custom_value');
    const stat3Suffix = document.getElementById('stat_medals_suffix');
    const stat3Label = document.getElementById('stat_medals_label');
    const medalsAutoInfo = document.getElementById('medals_auto_info');
    const medalsCustomContainer = document.getElementById('medals_custom_container');
    const medalsLabelContainer = document.getElementById('medals_label_container');

    const stat4Active = document.getElementById('stat_events_active');
    const stat4Mode = document.getElementById('stat_events_mode');
    const stat4Val = document.getElementById('stat_events_value');
    const stat4Suffix = document.getElementById('stat_events_suffix');
    const stat4Label = document.getElementById('stat_events_label');
    const eventsAutoInfo = document.getElementById('events_auto_info');
    const eventsCustomContainer = document.getElementById('events_custom_container');
    const eventsLabelContainer = document.getElementById('events_label_container');

    // Preview Elements
    const p1 = document.getElementById('preview-stat-1');
    const p1Num = document.getElementById('preview-stat-1-num');
    const p1Label = document.getElementById('preview-stat-1-label');
    const p1Status = document.getElementById('preview-stat-1-status');

    const p2 = document.getElementById('preview-stat-2');
    const p2Num = document.getElementById('preview-stat-2-num');
    const p2Label = document.getElementById('preview-stat-2-label');
    const p2Status = document.getElementById('preview-stat-2-status');

    const p3 = document.getElementById('preview-stat-3');
    const p3Num = document.getElementById('preview-stat-3-num');
    const p3Label = document.getElementById('preview-stat-3-label');
    const p3Status = document.getElementById('preview-stat-3-status');

    const p4 = document.getElementById('preview-stat-4');
    const p4Num = document.getElementById('preview-stat-4-num');
    const p4Label = document.getElementById('preview-stat-4-label');
    const p4Status = document.getElementById('preview-stat-4-status');

    function syncFormAndPreview() {
        // ── 1. Update Mode Toggles (Show / Hide manual inputs) ──
        // Stat 2: Members
        if (stat2Mode.value === 'manual') {
            membersAutoInfo.classList.add('hidden');
            membersCustomContainer.classList.remove('hidden');
            membersLabelContainer.classList.remove('sm:col-span-2');
            membersLabelContainer.classList.add('sm:col-span-1');
            stat2CustomVal.required = true;
        } else {
            membersAutoInfo.classList.remove('hidden');
            membersCustomContainer.classList.add('hidden');
            membersLabelContainer.classList.remove('sm:col-span-1');
            membersLabelContainer.classList.add('sm:col-span-2');
            stat2CustomVal.required = false;

            if (stat2Mode.value === 'auto_polindra') {
                membersAutoCountVal.textContent = realAutoData.kohai_polindra;
            } else {
                membersAutoCountVal.textContent = realAutoData.kohai_all;
            }
        }

        // Stat 3: Medals
        if (stat3Mode.value === 'manual') {
            medalsAutoInfo.classList.add('hidden');
            medalsCustomContainer.classList.remove('hidden');
            medalsLabelContainer.classList.remove('sm:col-span-2');
            medalsLabelContainer.classList.add('sm:col-span-1');
            stat3CustomVal.required = true;
        } else {
            medalsAutoInfo.classList.remove('hidden');
            medalsCustomContainer.classList.add('hidden');
            medalsLabelContainer.classList.remove('sm:col-span-1');
            medalsLabelContainer.classList.add('sm:col-span-2');
            stat3CustomVal.required = false;
        }

        // Stat 4: Events
        if (stat4Mode.value === 'manual') {
            eventsAutoInfo.classList.add('hidden');
            eventsCustomContainer.classList.remove('hidden');
            eventsLabelContainer.classList.remove('sm:col-span-2');
            eventsLabelContainer.classList.add('sm:col-span-1');
            stat4Val.required = true;
        } else {
            eventsAutoInfo.classList.remove('hidden');
            eventsCustomContainer.classList.add('hidden');
            eventsLabelContainer.classList.remove('sm:col-span-1');
            eventsLabelContainer.classList.add('sm:col-span-2');
            stat4Val.required = false;
        }

        // ── 2. Update Live Preview Box Content ──
        // Stat 1 Preview
        p1Num.textContent = stat1Year.value || '2016';
        p1Label.textContent = stat1Label.value || 'Tahun Berdiri';
        if (stat1Active.checked) {
            p1.style.opacity = '1';
            p1Status.textContent = '● Aktif';
            p1Status.className = 'text-[10px] font-bold block mt-1.5 text-emerald-400';
        } else {
            p1.style.opacity = '0.35';
            p1Status.textContent = '○ Sembunyi';
            p1Status.className = 'text-[10px] font-bold block mt-1.5 text-slate-500 line-through';
        }

        // Stat 2 Preview
        let s2Val = 80;
        if (stat2Mode.value === 'auto_polindra') {
            s2Val = realAutoData.kohai_polindra;
        } else if (stat2Mode.value === 'auto_all') {
            s2Val = realAutoData.kohai_all;
        } else {
            s2Val = stat2CustomVal.value || 0;
        }
        p2Num.textContent = s2Val + (stat2Suffix.value || '');
        p2Label.textContent = stat2Label.value || 'Anggota Aktif';
        if (stat2Active.checked) {
            p2.style.opacity = '1';
            p2Status.textContent = '● Aktif';
            p2Status.className = 'text-[10px] font-bold block mt-1.5 text-emerald-400';
        } else {
            p2.style.opacity = '0.35';
            p2Status.textContent = '○ Sembunyi';
            p2Status.className = 'text-[10px] font-bold block mt-1.5 text-slate-500 line-through';
        }

        // Stat 3 Preview
        let s3Val = 50;
        if (stat3Mode.value === 'auto') {
            s3Val = realAutoData.medals_auto;
        } else {
            s3Val = stat3CustomVal.value || 0;
        }
        p3Num.textContent = s3Val + (stat3Suffix.value || '');
        p3Label.textContent = stat3Label.value || 'Medali Kejuaraan';
        if (stat3Active.checked) {
            p3.style.opacity = '1';
            p3Status.textContent = '● Aktif';
            p3Status.className = 'text-[10px] font-bold block mt-1.5 text-emerald-400';
        } else {
            p3.style.opacity = '0.35';
            p3Status.textContent = '○ Sembunyi';
            p3Status.className = 'text-[10px] font-bold block mt-1.5 text-slate-500 line-through';
        }

        // Stat 4 Preview
        let s4Val = 20;
        if (stat4Mode.value === 'auto') {
            s4Val = realAutoData.events_auto;
        } else {
            s4Val = stat4Val.value || 0;
        }
        p4Num.textContent = s4Val + (stat4Suffix.value || '');
        p4Label.textContent = stat4Label.value || 'Event Diikuti';
        if (stat4Active.checked) {
            p4.style.opacity = '1';
            p4Status.textContent = '● Aktif';
            p4Status.className = 'text-[10px] font-bold block mt-1.5 text-emerald-400';
        } else {
            p4.style.opacity = '0.35';
            p4Status.textContent = '○ Sembunyi';
            p4Status.className = 'text-[10px] font-bold block mt-1.5 text-slate-500 line-through';
        }
    }

    // Attach listeners to all inputs in the form
    const form = document.getElementById('landing-settings-form');
    form.querySelectorAll('input, select').forEach(input => {
        input.addEventListener('input', syncFormAndPreview);
        input.addEventListener('change', syncFormAndPreview);
        input.addEventListener('keyup', syncFormAndPreview);
    });

    // Image Preview for About Section
    const aboutImageInput = document.getElementById('about_image');
    const aboutImgPreview = document.getElementById('about-img-preview');
    if (aboutImageInput) {
        aboutImageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(evt) {
                    if (aboutImgPreview) {
                        aboutImgPreview.src = evt.target.result;
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Image Previews for Gallery Section (Slot 01 - 05)
    for (let i = 1; i <= 5; i++) {
        const galInput = document.getElementById(`gallery_item_${i}_image`);
        const galPreview = document.getElementById(`gallery-preview-${i}`);
        if (galInput) {
            galInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(evt) {
                        if (galPreview) {
                            galPreview.src = evt.target.result;
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    }

    // Run on initial load
    syncFormAndPreview();
});
</script>
@endsection
