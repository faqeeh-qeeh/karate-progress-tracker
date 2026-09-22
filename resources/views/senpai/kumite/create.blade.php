@extends('layouts.senpai')

@section('title', 'Input Raport Kumite WKF')

@section('content')
<div class="space-y-6">
    <!-- Header Title -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs transition-colors duration-200">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white">Input Raport Tanding Kumite</h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Catat poin WKF, pelanggaran, dan evaluasi teknis antara dua Kohai (AKA vs AO)</p>
        </div>
        <a href="{{ route('senpai.kumite.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 text-xs font-bold rounded-xl transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Main Input Form -->
    <form action="{{ route('senpai.kumite.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Date, Time & Senshu Selection Card -->
        <div class="bg-white dark:bg-slate-900 p-5 sm:p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-5 transition-colors duration-200">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                <div>
                    <h3 class="text-sm font-extrabold text-slate-900 dark:text-white uppercase tracking-wider">
                        1. Informasi Spesifik & Penetapan SENSHU
                    </h3>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">Atur jadwal dan catat perolehan Senshu serta riwayat pembatalan (jika ada)</p>
                </div>
            </div>
            
            <!-- Match Duration (Durasi Waktu Bertanding) -->
            <div class="bg-gradient-to-br from-slate-50 via-slate-50 to-amber-50/30 dark:from-slate-950/60 dark:via-slate-900/40 dark:to-amber-950/20 p-4 sm:p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 space-y-3.5">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-200/60 dark:border-slate-800 pb-3">
                    <div class="flex items-center gap-2">
                        <span class="p-1.5 rounded-lg bg-brand-primary/10 dark:bg-brand-primary/20 text-brand-primary dark:text-brand-secondary text-sm font-black">⏱️</span>
                        <div>
                            <label class="block text-xs font-extrabold text-slate-800 dark:text-slate-200 uppercase tracking-wider">
                                Durasi Waktu Tanding Kumite
                            </label>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">Tentukan waktu lama ronde bertanding (Standar WKF / Kustom)</p>
                        </div>
                    </div>
                    
                    <!-- Live Duration Display Badge -->
                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl shadow-2xs self-start sm:self-auto">
                        <span class="text-[10px] uppercase font-bold text-slate-400 dark:text-slate-500">Total Durasi:</span>
                        <span id="live_duration_badge" class="font-mono font-black text-xs text-brand-primary dark:text-brand-secondary">03:00 (3 Menit)</span>
                    </div>
                </div>

                <!-- Quick Preset Buttons -->
                <div>
                    <span class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Pilih Cepat Durasi Standar:</span>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                        <button type="button" onclick="setMatchDurationPreset(1, 30, this)" 
                            class="duration-preset-btn flex items-center justify-center gap-1.5 px-3 py-2.5 rounded-xl text-xs font-bold border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 hover:border-brand-primary hover:text-brand-primary dark:hover:border-brand-secondary active:scale-95 transition-all text-slate-700 dark:text-slate-200 shadow-2xs">
                            <span>⚡ 1.5 Menit</span>
                            <span class="text-[10px] font-mono opacity-60">(01:30)</span>
                        </button>
                        <button type="button" onclick="setMatchDurationPreset(2, 0, this)" 
                            class="duration-preset-btn flex items-center justify-center gap-1.5 px-3 py-2.5 rounded-xl text-xs font-bold border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 hover:border-brand-primary hover:text-brand-primary dark:hover:border-brand-secondary active:scale-95 transition-all text-slate-700 dark:text-slate-200 shadow-2xs">
                            <span>🥋 2.0 Menit</span>
                            <span class="text-[10px] font-mono opacity-60">(02:00)</span>
                        </button>
                        <button type="button" onclick="setMatchDurationPreset(3, 0, this)" 
                            class="duration-preset-btn active-preset flex items-center justify-center gap-1.5 px-3 py-2.5 rounded-xl text-xs font-bold border-2 border-brand-primary bg-brand-primary text-white shadow-2xs active:scale-95 transition-all">
                            <span>🏆 3.0 Menit</span>
                            <span class="text-[10px] font-mono opacity-80">(03:00)</span>
                        </button>
                        <button type="button" onclick="setMatchDurationPreset(5, 0, this)" 
                            class="duration-preset-btn flex items-center justify-center gap-1.5 px-3 py-2.5 rounded-xl text-xs font-bold border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 hover:border-brand-primary hover:text-brand-primary dark:hover:border-brand-secondary active:scale-95 transition-all text-slate-700 dark:text-slate-200 shadow-2xs">
                            <span>🔥 5.0 Menit</span>
                            <span class="text-[10px] font-mono opacity-60">(05:00)</span>
                        </button>
                    </div>
                </div>

                <!-- Custom Minute & Second Numeric Inputs -->
                <div class="bg-white dark:bg-slate-900 p-3 rounded-xl border border-slate-200/80 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-2xs">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-extrabold text-slate-700 dark:text-slate-300">Atur Waktu Kustom:</span>
                        <span class="text-[10px] text-slate-400 dark:text-slate-500 font-medium">(Bebas menit & detik)</span>
                    </div>
                    <div class="flex items-center gap-2 self-start sm:self-auto">
                        <!-- Menit -->
                        <div class="flex items-center gap-1.5">
                            <input type="number" name="duration_minutes" id="duration_minutes" 
                                value="{{ old('duration_minutes', 3) }}" min="0" max="60" oninput="updateLiveDuration()"
                                class="w-16 px-2.5 py-1.5 text-center font-mono font-black text-sm rounded-lg border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-white focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-brand-primary focus:outline-none">
                            <span class="text-xs font-bold text-slate-500 dark:text-slate-400">Menit</span>
                        </div>
                        
                        <span class="text-slate-400 dark:text-slate-600 font-black">:</span>

                        <!-- Detik -->
                        <div class="flex items-center gap-1.5">
                            <input type="number" name="duration_seconds" id="duration_seconds" 
                                value="{{ old('duration_seconds', 0) }}" min="0" max="59" step="1" oninput="updateLiveDuration()"
                                class="w-16 px-2.5 py-1.5 text-center font-mono font-black text-sm rounded-lg border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-white focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-brand-primary focus:outline-none">
                            <span class="text-xs font-bold text-slate-500 dark:text-slate-400">Detik</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <!-- Date -->
                <div>
                    <label for="match_date" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Tanggal Pertandingan</label>
                    <input type="date" name="match_date" id="match_date" value="{{ old('match_date', date('Y-m-d')) }}" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-950/50 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-primary focus:bg-white dark:focus:bg-slate-900">
                    @error('match_date')
                        <p class="text-xs text-red-600 dark:text-red-400 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Time -->
                <div>
                    <label for="match_time" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Jam Pertandingan</label>
                    <input type="time" name="match_time" id="match_time" value="{{ old('match_time', date('H:i')) }}" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-950/50 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-900">
                    @error('match_time')
                        <p class="text-xs text-red-600 dark:text-red-400 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Senshu Awal Selection -->
                <div>
                    <label for="senshu_corner" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">
                        SENSHU Awal (Poin Pertama)
                    </label>
                    <select name="senshu_corner" id="senshu_corner" onchange="handleInitialSenshuChange()"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-950/50 text-sm font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-primary focus:bg-white dark:focus:bg-slate-900">
                        <option value="none" {{ old('senshu_corner') === 'none' ? 'selected' : '' }}>-- Tidak Ada Peraih Senshu --</option>
                        <option value="aka" {{ old('senshu_corner') === 'aka' ? 'selected' : '' }}>🔴 AKA (Sudut Merah)</option>
                        <option value="ao" {{ old('senshu_corner') === 'ao' ? 'selected' : '' }}>🔵 AO (Sudut Biru)</option>
                    </select>
                </div>
            </div>

            <!-- SENSHU CANCELLING SECTION -->
            <div class="mt-4 pt-4 border-t border-dashed border-slate-200 dark:border-slate-800 space-y-3">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-amber-50/60 dark:bg-amber-950/30 p-4 rounded-xl border border-amber-200/80 dark:border-amber-800/80">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-amber-800 dark:text-amber-300 font-black text-sm">⚠️ Fitur Senshu Cancelling (Pembatalan Senshu)</span>
                            <span class="text-[10px] bg-amber-200 dark:bg-amber-900 text-amber-900 dark:text-amber-200 px-2 py-0.5 rounded font-extrabold uppercase">Opsional</span>
                        </div>
                        <p class="text-xs text-amber-800/80 dark:text-amber-300/80 mt-0.5 font-medium">
                            Gunakan tombol ini jika terjadi pembatalan Senshu selama pertandingan. Seluruh riwayat penetapan lama akan tetap tersimpan.
                        </p>
                    </div>
                    <button type="button" onclick="addSenshuCancellingStep()" id="btn_add_cancelling" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold rounded-xl shadow-xs transition shrink-0 active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>+ Tambah Senshu Cancelling</span>
                    </button>
                </div>

                <!-- Senshu Cancelling Steps Container (Repeater) -->
                <div id="senshu_cancelling_container" class="space-y-3">
                    <!-- Dynamic Rows Rendered Here by JS -->
                </div>

                <!-- Final Effective Senshu Status Banner -->
                <div id="effective_senshu_banner" class="p-3 bg-slate-50 dark:bg-slate-950/50 border border-slate-200 dark:border-slate-800 rounded-xl flex items-center justify-between text-xs">
                    <span class="text-slate-600 dark:text-slate-400 font-bold">Status Efektif Peraih SENSHU Saat Ini:</span>
                    <span id="effective_senshu_badge" class="font-extrabold px-3 py-1 rounded-lg bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                        Tidak Ada Senshu
                    </span>
                </div>
            </div>
        </div>

        <!-- Split Screen WKF Scoreboard Input (AKA Red vs AO Blue) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- SISI AKA (MERAH / RED CORNER) -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl border-2 border-red-500/40 dark:border-red-900/60 shadow-md overflow-hidden flex flex-col justify-between transition-colors duration-200">
                <div>
                    <div class="bg-gradient-to-r from-red-600 to-red-700 p-4 text-white">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-black uppercase tracking-widest px-2.5 py-0.5 rounded bg-black/30 border border-white/20">SUDUT MERAH</span>
                            <span class="text-xl font-black">AKA</span>
                        </div>
                    </div>

                    <div class="p-5 sm:p-6 space-y-5">
                        <!-- Pilih Kohai AKA -->
                        <div>
                            <label for="aka_kohai_id" class="block text-xs font-extrabold text-red-700 dark:text-red-400 uppercase tracking-wider mb-1">Pilih Kohai (Sudut Merah AKA)</label>
                            <select name="aka_kohai_id" id="aka_kohai_id" required onchange="updateKohaiDropdowns()" class="w-full px-4 py-2.5 rounded-xl border border-red-300 dark:border-red-800 bg-red-50/30 dark:bg-red-950/20 text-sm font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-red-500">
                                <option value="" disabled selected>-- Pilih Kohai AKA --</option>
                                @foreach($kohais as $k)
                                    <option value="{{ $k->id }}" {{ old('aka_kohai_id') == $k->id ? 'selected' : '' }}>
                                        🔴 {{ $k->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('aka_kohai_id')
                                <p class="text-xs text-red-600 dark:text-red-400 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Poin WKF (Ippon, Waza-ari, Yuko) -->
                        <div>
                            <h4 class="text-xs font-extrabold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2 border-b border-slate-100 dark:border-slate-800 pb-1">Perolehan Poin WKF (AKA)</h4>
                            <div class="grid grid-cols-3 gap-3">
                                <div class="bg-slate-50 dark:bg-slate-950/50 p-3 rounded-xl border border-slate-200 dark:border-slate-800 text-center">
                                    <label for="aka_ippon" class="block text-[11px] font-bold text-slate-600 dark:text-slate-400">IPPON (3 Pts)</label>
                                    <input type="number" name="aka_ippon" id="aka_ippon" value="{{ old('aka_ippon', 0) }}" min="0" required class="w-full mt-1 text-center font-bold text-lg rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white">
                                </div>
                                <div class="bg-slate-50 dark:bg-slate-950/50 p-3 rounded-xl border border-slate-200 dark:border-slate-800 text-center">
                                    <label for="aka_wazaari" class="block text-[11px] font-bold text-slate-600 dark:text-slate-400">WAZA-ARI (2 Pts)</label>
                                    <input type="number" name="aka_wazaari" id="aka_wazaari" value="{{ old('aka_wazaari', 0) }}" min="0" required class="w-full mt-1 text-center font-bold text-lg rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white">
                                </div>
                                <div class="bg-slate-50 dark:bg-slate-950/50 p-3 rounded-xl border border-slate-200 dark:border-slate-800 text-center">
                                    <label for="aka_yuko" class="block text-[11px] font-bold text-slate-600 dark:text-slate-400">YUKO (1 Pt)</label>
                                    <input type="number" name="aka_yuko" id="aka_yuko" value="{{ old('aka_yuko', 0) }}" min="0" required class="w-full mt-1 text-center font-bold text-lg rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white">
                                </div>
                            </div>
                            <!-- Live Total Poin AKA Display -->
                            <div class="mt-3 p-3 bg-red-50/70 dark:bg-red-950/30 border border-red-200 dark:border-red-900/60 rounded-xl flex items-center justify-between">
                                <span class="text-xs font-extrabold text-red-800 dark:text-red-300 uppercase tracking-wider">Total Nilai Poin WKF (AKA):</span>
                                <span id="aka_total_points_display" class="text-base font-black text-red-600 dark:text-red-400 bg-white dark:bg-slate-900 px-3 py-1 rounded-lg border border-red-200 dark:border-red-900 shadow-2xs">0 Pts</span>
                            </div>
                        </div>

                        <!-- Pelanggaran WKF (AKA Dropdown) -->
                        <div>
                            <label for="aka_fouls" class="block text-xs font-extrabold text-red-700 dark:text-red-400 uppercase tracking-wider mb-1">
                                Pelanggaran WKF (Sudut Merah AKA)
                            </label>
                            <select name="aka_fouls" id="aka_fouls" required class="w-full px-4 py-2.5 rounded-xl border border-red-300 dark:border-red-800 bg-red-50/30 dark:bg-red-950/20 text-sm font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-red-500">
                                <option value="0" {{ old('aka_fouls', '0') == '0' ? 'selected' : '' }}>0 - Tidak Ada Pelanggaran</option>
                                <option value="1" {{ old('aka_fouls') == '1' ? 'selected' : '' }}>1 - 1 Poin Pelanggaran</option>
                                <option value="2" {{ old('aka_fouls') == '2' ? 'selected' : '' }}>2 - 2 Poin Pelanggaran</option>
                                <option value="3" {{ old('aka_fouls') == '3' ? 'selected' : '' }}>3 - 3 Poin Pelanggaran</option>
                                <option value="4" {{ old('aka_fouls') == '4' ? 'selected' : '' }}>4 - 4 Poin Pelanggaran (Hansoku / Kalah Otomatis)</option>
                                <option value="5" {{ old('aka_fouls') == '5' ? 'selected' : '' }}>5 - 5 Poin Pelanggaran (Hansoku / Diskualifikasi)</option>
                            </select>
                            @error('aka_fouls')
                                <p class="text-xs text-red-600 dark:text-red-400 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Rating Evaluasi Teknis AKA -->
                        <div class="p-4 bg-slate-50 dark:bg-slate-950/50 rounded-xl border border-slate-200 dark:border-slate-800 space-y-3">
                            <div class="flex items-center justify-between">
                                <h4 class="text-xs font-extrabold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Evaluasi Teknis AKA</h4>
                                <span class="text-[10px] text-slate-500 dark:text-slate-400 font-semibold">Akurasi dihitung otomatis</span>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label for="aka_score_attack" class="block text-[11px] font-bold text-slate-600 dark:text-slate-400">Nilai Attack / Jumlah Serangan</label>
                                    <input type="number" name="aka_score_attack" id="aka_score_attack" value="{{ old('aka_score_attack', 0) }}" min="0" required class="w-full mt-1 px-3 py-2 rounded-lg border-slate-300 dark:border-slate-700 text-sm font-bold bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-red-500">
                                    <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-1">Banyaknya serangan yang dilancarkan</p>
                                </div>
                                <div>
                                    <label for="aka_score_accuracy" class="block text-[11px] font-bold text-slate-600 dark:text-slate-400">Nilai Accuracy / Akurasi (%)</label>
                                    <input type="number" step="0.1" name="aka_score_accuracy" id="aka_score_accuracy" value="{{ old('aka_score_accuracy', 0) }}" readonly class="w-full mt-1 px-3 py-2 rounded-lg border-slate-300 dark:border-slate-700 text-sm font-bold bg-slate-100 dark:bg-slate-800 text-red-700 dark:text-red-400 cursor-not-allowed">
                                    <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-1">(Poin Masuk ÷ Serangan) × 100%</p>
                                </div>
                            </div>
                        </div>

                        <!-- Catatan Evaluasi Khusus AKA -->
                        <div>
                            <label for="aka_evaluation_notes" class="block text-xs font-extrabold text-red-800 dark:text-red-300 uppercase tracking-wider mb-1">Catatan Evaluasi & Saran Khusus AKA</label>
                            <textarea name="aka_evaluation_notes" id="aka_evaluation_notes" rows="3" placeholder="Saran khusus untuk Kohai AKA (misal: perbaiki pertahanan atas, kontrol emosi saat menyerang)..."
                                class="w-full p-3 rounded-xl border border-red-200 dark:border-red-900/60 text-xs bg-red-50/20 dark:bg-red-950/10 text-slate-900 dark:text-white placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-red-500">{{ old('aka_evaluation_notes') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SISI AO (BIRU / BLUE CORNER) -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl border-2 border-brand-primary/40 dark:border-blue-900/60 shadow-md overflow-hidden flex flex-col justify-between transition-colors duration-200">
                <div>
                    <div class="bg-gradient-to-r from-brand-primary to-blue-800 p-4 text-white">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-black uppercase tracking-widest px-2.5 py-0.5 rounded bg-black/30 border border-white/20">SUDUT BIRU</span>
                            <span class="text-xl font-black">AO</span>
                        </div>
                    </div>

                    <div class="p-5 sm:p-6 space-y-5">
                        <!-- Pilih Kohai AO -->
                        <div>
                            <label for="ao_kohai_id" class="block text-xs font-extrabold text-brand-primary dark:text-brand-secondary uppercase tracking-wider mb-1">Pilih Kohai (Sudut Biru AO)</label>
                            <select name="ao_kohai_id" id="ao_kohai_id" required onchange="updateKohaiDropdowns()" class="w-full px-4 py-2.5 rounded-xl border border-brand-primary/40 dark:border-blue-800 bg-blue-50/30 dark:bg-blue-950/20 text-sm font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-primary">
                                <option value="" disabled selected>-- Pilih Kohai AO --</option>
                                @foreach($kohais as $k)
                                    <option value="{{ $k->id }}" {{ old('ao_kohai_id') == $k->id ? 'selected' : '' }}>
                                        🔵 {{ $k->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('ao_kohai_id')
                                <p class="text-xs text-red-600 dark:text-red-400 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Poin WKF (Ippon, Waza-ari, Yuko) -->
                        <div>
                            <h4 class="text-xs font-extrabold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2 border-b border-slate-100 dark:border-slate-800 pb-1">Perolehan Poin WKF (AO)</h4>
                            <div class="grid grid-cols-3 gap-3">
                                <div class="bg-slate-50 dark:bg-slate-950/50 p-3 rounded-xl border border-slate-200 dark:border-slate-800 text-center">
                                    <label for="ao_ippon" class="block text-[11px] font-bold text-slate-600 dark:text-slate-400">IPPON (3 Pts)</label>
                                    <input type="number" name="ao_ippon" id="ao_ippon" value="{{ old('ao_ippon', 0) }}" min="0" required class="w-full mt-1 text-center font-bold text-lg rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white">
                                </div>
                                <div class="bg-slate-50 dark:bg-slate-950/50 p-3 rounded-xl border border-slate-200 dark:border-slate-800 text-center">
                                    <label for="ao_wazaari" class="block text-[11px] font-bold text-slate-600 dark:text-slate-400">WAZA-ARI (2 Pts)</label>
                                    <input type="number" name="ao_wazaari" id="ao_wazaari" value="{{ old('ao_wazaari', 0) }}" min="0" required class="w-full mt-1 text-center font-bold text-lg rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white">
                                </div>
                                <div class="bg-slate-50 dark:bg-slate-950/50 p-3 rounded-xl border border-slate-200 dark:border-slate-800 text-center">
                                    <label for="ao_yuko" class="block text-[11px] font-bold text-slate-600 dark:text-slate-400">YUKO (1 Pt)</label>
                                    <input type="number" name="ao_yuko" id="ao_yuko" value="{{ old('ao_yuko', 0) }}" min="0" required class="w-full mt-1 text-center font-bold text-lg rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white">
                                </div>
                            </div>
                            <!-- Live Total Poin AO Display -->
                            <div class="mt-3 p-3 bg-blue-50/70 dark:bg-blue-950/30 border border-blue-200 dark:border-blue-900/60 rounded-xl flex items-center justify-between">
                                <span class="text-xs font-extrabold text-brand-primary dark:text-brand-secondary uppercase tracking-wider">Total Nilai Poin WKF (AO):</span>
                                <span id="ao_total_points_display" class="text-base font-black text-brand-primary dark:text-brand-secondary bg-white dark:bg-slate-900 px-3 py-1 rounded-lg border border-blue-200 dark:border-blue-900 shadow-2xs">0 Pts</span>
                            </div>
                        </div>

                        <!-- Pelanggaran WKF (AO Dropdown) -->
                        <div>
                            <label for="ao_fouls" class="block text-xs font-extrabold text-brand-primary dark:text-brand-secondary uppercase tracking-wider mb-1">
                                Pelanggaran WKF (Sudut Biru AO)
                            </label>
                            <select name="ao_fouls" id="ao_fouls" required class="w-full px-4 py-2.5 rounded-xl border border-brand-primary/40 dark:border-blue-800 bg-blue-50/30 dark:bg-blue-950/20 text-sm font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-primary">
                                <option value="0" {{ old('ao_fouls', '0') == '0' ? 'selected' : '' }}>0 - Tidak Ada Pelanggaran</option>
                                <option value="1" {{ old('ao_fouls') == '1' ? 'selected' : '' }}>1 - 1 Poin Pelanggaran</option>
                                <option value="2" {{ old('ao_fouls') == '2' ? 'selected' : '' }}>2 - 2 Poin Pelanggaran</option>
                                <option value="3" {{ old('ao_fouls') == '3' ? 'selected' : '' }}>3 - 3 Poin Pelanggaran</option>
                                <option value="4" {{ old('ao_fouls') == '4' ? 'selected' : '' }}>4 - 4 Poin Pelanggaran (Hansoku / Kalah Otomatis)</option>
                                <option value="5" {{ old('ao_fouls') == '5' ? 'selected' : '' }}>5 - 5 Poin Pelanggaran (Hansoku / Diskualifikasi)</option>
                            </select>
                            @error('ao_fouls')
                                <p class="text-xs text-red-600 dark:text-red-400 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Rating Evaluasi Teknis AO -->
                        <div class="p-4 bg-slate-50 dark:bg-slate-950/50 rounded-xl border border-slate-200 dark:border-slate-800 space-y-3">
                            <div class="flex items-center justify-between">
                                <h4 class="text-xs font-extrabold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Evaluasi Teknis AO</h4>
                                <span class="text-[10px] text-slate-500 dark:text-slate-400 font-semibold">Akurasi dihitung otomatis</span>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label for="ao_score_attack" class="block text-[11px] font-bold text-slate-600 dark:text-slate-400">Nilai Attack / Jumlah Serangan</label>
                                    <input type="number" name="ao_score_attack" id="ao_score_attack" value="{{ old('ao_score_attack', 0) }}" min="0" required class="w-full mt-1 px-3 py-2 rounded-lg border-slate-300 dark:border-slate-700 text-sm font-bold bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary">
                                    <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-1">Banyaknya serangan yang dilancarkan</p>
                                </div>
                                <div>
                                    <label for="ao_score_accuracy" class="block text-[11px] font-bold text-slate-600 dark:text-slate-400">Nilai Accuracy / Akurasi (%)</label>
                                    <input type="number" step="0.1" name="ao_score_accuracy" id="ao_score_accuracy" value="{{ old('ao_score_accuracy', 0) }}" readonly class="w-full mt-1 px-3 py-2 rounded-lg border-slate-300 dark:border-slate-700 text-sm font-bold bg-slate-100 dark:bg-slate-800 text-brand-primary dark:text-brand-secondary cursor-not-allowed">
                                    <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-1">(Poin Masuk ÷ Serangan) × 100%</p>
                                </div>
                            </div>
                        </div>

                        <!-- Catatan Evaluasi Khusus AO -->
                        <div>
                            <label for="ao_evaluation_notes" class="block text-xs font-extrabold text-brand-primary dark:text-brand-secondary uppercase tracking-wider mb-1">Catatan Evaluasi & Saran Khusus AO</label>
                            <textarea name="ao_evaluation_notes" id="ao_evaluation_notes" rows="3" placeholder="Saran khusus untuk Kohai AO (misal: tingkatkan fleksibilitas kaki untuk Gyaku-Zuki)..."
                                class="w-full p-3 rounded-xl border border-blue-200 dark:border-blue-900/60 text-xs bg-blue-50/20 dark:bg-blue-950/10 text-slate-900 dark:text-white placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-brand-primary">{{ old('ao_evaluation_notes') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Submit Button -->
        <div class="flex justify-end gap-3 pt-2">
            <a href="{{ route('senpai.kumite.index') }}" class="px-5 py-3 rounded-xl bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 text-xs font-bold transition">
                Batal
            </a>
            <button type="submit" class="px-8 py-3 rounded-xl bg-brand-primary hover:bg-brand-primary/90 text-white font-bold text-sm shadow-md transition">
                Simpan Raport Kumite WKF
            </button>
        </div>
    </form>
</div>

<!-- JS Dynamic Calculations & Filters -->
<script>
    // State for Senshu Steps (Initial + Cancellations)
    let senshuSteps = [];

    function handleInitialSenshuChange() {
        const initialVal = document.getElementById('senshu_corner').value;
        if (senshuSteps.length === 0) {
            updateEffectiveSenshuDisplay();
        } else {
            // Update the first step
            senshuSteps[0].corner = initialVal;
            renderSenshuCancellingUI();
        }
    }

    function addSenshuCancellingStep() {
        // If this is the first cancellation, initialize step 0 (initial senshu)
        if (senshuSteps.length === 0) {
            const initialVal = document.getElementById('senshu_corner').value;
            senshuSteps.push({
                sequence: 1,
                corner: initialVal,
                status: 'cancelled',
                notes: 'Senshu Awal Dibatalkan (Senshu Cancelled)'
            });
        } else {
            // Mark the previous step as cancelled
            senshuSteps[senshuSteps.length - 1].status = 'cancelled';
            senshuSteps[senshuSteps.length - 1].notes = 'Dibatalkan (Senshu Cancelled #' + senshuSteps.length + ')';
        }

        // Add the new replacement step
        const nextSeq = senshuSteps.length + 1;
        senshuSteps.push({
            sequence: nextSeq,
            corner: 'none',
            status: 'active',
            notes: 'Senshu Pengganti #' + (nextSeq - 1)
        });

        renderSenshuCancellingUI();
    }

    function removeLastSenshuStep() {
        if (senshuSteps.length > 0) {
            senshuSteps.pop();
            if (senshuSteps.length === 1) {
                // Only step 0 left, revert back to no cancellations
                const step0 = senshuSteps[0];
                document.getElementById('senshu_corner').value = step0.corner;
                senshuSteps = [];
            } else if (senshuSteps.length > 1) {
                // Reactivate the new last step
                senshuSteps[senshuSteps.length - 1].status = 'active';
            }
            renderSenshuCancellingUI();
        }
    }

    function updateStepCorner(index, val) {
        if (senshuSteps[index]) {
            senshuSteps[index].corner = val;
            updateEffectiveSenshuDisplay();
        }
    }

    function renderSenshuCancellingUI() {
        const container = document.getElementById('senshu_cancelling_container');
        container.innerHTML = '';

        if (senshuSteps.length === 0) {
            updateEffectiveSenshuDisplay();
            return;
        }

        senshuSteps.forEach((step, idx) => {
            const isFirst = (idx === 0);
            const isLast = (idx === senshuSteps.length - 1);

            const rowDiv = document.createElement('div');
            rowDiv.className = 'p-3.5 rounded-xl border text-xs space-y-2 ' + 
                (isLast ? 'bg-emerald-50/50 dark:bg-emerald-950/30 border-emerald-300 dark:border-emerald-800 shadow-2xs' : 'bg-red-50/40 dark:bg-red-950/20 border-red-200 dark:border-red-900');

            let headerBadge = isLast 
                ? '<span class="px-2 py-0.5 rounded-md bg-emerald-100 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 font-extrabold text-[10px]">✅ AKTIF / FINAL</span>'
                : '<span class="px-2 py-0.5 rounded-md bg-red-100 dark:bg-red-950/60 text-red-800 dark:text-red-300 font-extrabold text-[10px]">❌ DIBATALKAN (CANCELLED)</span>';

            let cornerLabel = isFirst ? 'Keputusan Senshu Awal (Langkah #1)' : `Senshu Pengganti (Langkah #${idx + 1})`;

            let selectHtml = `
                <select onchange="updateStepCorner(${idx}, this.value)" class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 font-bold bg-white dark:bg-slate-900 text-slate-900 dark:text-white text-xs focus:ring-2 focus:ring-brand-primary">
                    <option value="none" ${step.corner === 'none' || !step.corner ? 'selected' : ''}>⚪ Tidak Ada Peraih Senshu</option>
                    <option value="aka" ${step.corner === 'aka' ? 'selected' : ''}>🔴 AKA (Sudut Merah)</option>
                    <option value="ao" ${step.corner === 'ao' ? 'selected' : ''}>🔵 AO (Sudut Biru)</option>
                </select>
            `;

            let deleteBtn = isLast && idx > 0 ? `
                <button type="button" onclick="removeLastSenshuStep()" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 text-[11px] font-bold underline inline-flex items-center gap-1">
                    <span>Hapus Langkah Ini</span>
                </button>
            ` : '';

            rowDiv.innerHTML = `
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="font-extrabold text-slate-800 dark:text-slate-200">${cornerLabel}</span>
                        ${headerBadge}
                    </div>
                    ${deleteBtn}
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 items-center">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase mb-0.5">Pilihan Peraih Senshu</label>
                        ${selectHtml}
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase mb-0.5">Catatan / Alasan</label>
                        <input type="text" value="${step.notes || ''}" onchange="senshuSteps[${idx}].notes = this.value" placeholder="Keterangan pembatalan/penggantian..." class="w-full px-3 py-1.5 rounded-lg border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white text-xs bg-white dark:bg-slate-900">
                    </div>
                </div>
                <!-- Hidden form fields to submit -->
                <input type="hidden" name="senshu_logs[${idx}][sequence]" value="${idx + 1}">
                <input type="hidden" name="senshu_logs[${idx}][corner]" value="${step.corner}">
                <input type="hidden" name="senshu_logs[${idx}][status]" value="${step.status}">
                <input type="hidden" name="senshu_logs[${idx}][notes]" value="${step.notes || ''}">
            `;

            container.appendChild(rowDiv);
        });

        updateEffectiveSenshuDisplay();
    }

    function updateEffectiveSenshuDisplay() {
        const badge = document.getElementById('effective_senshu_badge');
        let effectiveCorner = 'none';

        if (senshuSteps.length === 0) {
            effectiveCorner = document.getElementById('senshu_corner').value;
        } else {
            const last = senshuSteps[senshuSteps.length - 1];
            if (last && last.status === 'active') {
                effectiveCorner = last.corner;
            }
        }

        if (effectiveCorner === 'aka') {
            badge.className = 'font-extrabold px-3 py-1 rounded-lg bg-red-100 dark:bg-red-950/60 text-red-800 dark:text-red-300 border border-red-200 dark:border-red-900';
            badge.textContent = '🔴 AKA (Sudut Merah)';
        } else if (effectiveCorner === 'ao') {
            badge.className = 'font-extrabold px-3 py-1 rounded-lg bg-blue-100 dark:bg-blue-950/60 text-brand-primary dark:text-brand-secondary border border-blue-200 dark:border-blue-900';
            badge.textContent = '🔵 AO (Sudut Biru)';
        } else {
            badge.className = 'font-extrabold px-3 py-1 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700';
            badge.textContent = '⚪ Tidak Ada (Nihil)';
        }
    }

    function updateKohaiDropdowns() {
        const akaSelect = document.getElementById('aka_kohai_id');
        const aoSelect = document.getElementById('ao_kohai_id');

        const akaVal = akaSelect.value;
        const aoVal = aoSelect.value;

        // Reset disable status for all options first
        Array.from(akaSelect.options).forEach(opt => opt.disabled = false);
        Array.from(aoSelect.options).forEach(opt => opt.disabled = false);

        // Disable selected AKA in AO dropdown
        if (akaVal) {
            Array.from(aoSelect.options).forEach(opt => {
                if (opt.value === akaVal) opt.disabled = true;
            });
        }

        // Disable selected AO in AKA dropdown
        if (aoVal) {
            Array.from(akaSelect.options).forEach(opt => {
                if (opt.value === aoVal) opt.disabled = true;
            });
        }
    }

    function calculateLiveScoreAndAccuracy() {
        // --- AKA Calculations ---
        const akaIppon = parseInt(document.getElementById('aka_ippon').value) || 0;
        const akaWazaari = parseInt(document.getElementById('aka_wazaari').value) || 0;
        const akaYuko = parseInt(document.getElementById('aka_yuko').value) || 0;
        const akaAttack = parseInt(document.getElementById('aka_score_attack').value) || 0;

        const akaTotalPoints = (akaIppon * 3) + (akaWazaari * 2) + (akaYuko * 1);
        const akaSuccessfulHits = akaIppon + akaWazaari + akaYuko;
        const akaAccuracy = akaAttack > 0 ? ((akaSuccessfulHits / akaAttack) * 100).toFixed(1) : 0;

        document.getElementById('aka_total_points_display').textContent = akaTotalPoints + ' Pts';
        document.getElementById('aka_score_accuracy').value = akaAccuracy;

        // --- AO Calculations ---
        const aoIppon = parseInt(document.getElementById('ao_ippon').value) || 0;
        const aoWazaari = parseInt(document.getElementById('ao_wazaari').value) || 0;
        const aoYuko = parseInt(document.getElementById('ao_yuko').value) || 0;
        const aoAttack = parseInt(document.getElementById('ao_score_attack').value) || 0;

        const aoTotalPoints = (aoIppon * 3) + (aoWazaari * 2) + (aoYuko * 1);
        const aoSuccessfulHits = aoIppon + aoWazaari + aoYuko;
        const aoAccuracy = aoAttack > 0 ? ((aoSuccessfulHits / aoAttack) * 100).toFixed(1) : 0;

        document.getElementById('ao_total_points_display').textContent = aoTotalPoints + ' Pts';
        document.getElementById('ao_score_accuracy').value = aoAccuracy;
    }

    function setMatchDurationPreset(minutes, seconds, clickedBtn) {
        document.getElementById('duration_minutes').value = minutes;
        document.getElementById('duration_seconds').value = seconds;

        // Update active class on preset buttons
        document.querySelectorAll('.duration-preset-btn').forEach(btn => {
            btn.className = 'duration-preset-btn flex items-center justify-center gap-1.5 px-3 py-2.5 rounded-xl text-xs font-bold border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 hover:border-brand-primary hover:text-brand-primary dark:hover:border-brand-secondary active:scale-95 transition-all text-slate-700 dark:text-slate-200 shadow-2xs';
        });

        if (clickedBtn) {
            clickedBtn.className = 'duration-preset-btn active-preset flex items-center justify-center gap-1.5 px-3 py-2.5 rounded-xl text-xs font-bold border-2 border-brand-primary bg-brand-primary text-white shadow-2xs active:scale-95 transition-all';
        }

        updateLiveDuration();
    }

    function updateLiveDuration() {
        const minEl = document.getElementById('duration_minutes');
        const secEl = document.getElementById('duration_seconds');
        const badge = document.getElementById('live_duration_badge');

        let min = parseInt(minEl.value) || 0;
        let sec = parseInt(secEl.value) || 0;

        if (min < 0) min = 0;
        if (sec < 0) sec = 0;
        if (sec > 59) sec = 59;

        const formattedMin = String(min).padStart(2, '0');
        const formattedSec = String(sec).padStart(2, '0');

        let humanText = `${min} Menit`;
        if (sec > 0) {
            humanText = `${min}m ${sec}s`;
        }

        if (badge) {
            badge.textContent = `${formattedMin}:${formattedSec} (${humanText})`;
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        updateKohaiDropdowns();
        calculateLiveScoreAndAccuracy();
        updateEffectiveSenshuDisplay();
        updateLiveDuration();

        const triggerInputs = [
            'aka_ippon', 'aka_wazaari', 'aka_yuko', 'aka_score_attack',
            'ao_ippon', 'ao_wazaari', 'ao_yuko', 'ao_score_attack'
        ];

        triggerInputs.forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.addEventListener('input', calculateLiveScoreAndAccuracy);
                el.addEventListener('change', calculateLiveScoreAndAccuracy);
            }
        });
    });
</script>
@endsection
