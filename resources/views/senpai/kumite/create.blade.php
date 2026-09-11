@extends('layouts.senpai')

@section('title', 'Input Raport Kumite WKF')

@section('content')
<div class="space-y-6">
    <!-- Header Title -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-gray-100 shadow-xs">
        <div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand-primary/10 text-brand-primary text-xs font-bold mb-1">
                <span>🥋 WKF KUMITE EVALUATION</span>
            </div>
            <h1 class="text-2xl font-extrabold text-brand-black">Input Raport Tanding Kumite</h1>
            <p class="text-xs text-gray-500 mt-1">Catat poin WKF, pelanggaran, dan evaluasi teknis antara dua Kohai (AKA vs AO)</p>
        </div>
        <a href="{{ route('senpai.kumite.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-xs font-bold rounded-xl transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Main Input Form -->
    <form action="{{ route('senpai.kumite.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Date, Time & Senshu Selection Card -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-xs space-y-4">
            <h3 class="text-sm font-extrabold text-brand-black uppercase tracking-wider border-b border-gray-100 pb-2">
                1. Informasi Spesifik & Penetapan SENSHU
            </h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <!-- Date -->
                <div>
                    <label for="match_date" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Tanggal Pertandingan</label>
                    <input type="date" name="match_date" id="match_date" value="{{ old('match_date', date('Y-m-d')) }}" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 bg-gray-50/50 text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:bg-white">
                    @error('match_date')
                        <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Time -->
                <div>
                    <label for="match_time" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Jam Pertandingan</label>
                    <input type="time" name="match_time" id="match_time" value="{{ old('match_time', date('H:i')) }}" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 bg-gray-50/50 text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white">
                    @error('match_time')
                        <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Senshu Single Selection (Wajib) -->
                <div>
                    <label for="senshu_corner" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">
                        SENSHU (Keunggulan Poin Pertama) <span class="text-red-500 font-bold">*</span>
                    </label>
                    <select name="senshu_corner" id="senshu_corner" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 bg-gray-50/50 text-sm font-bold focus:outline-none focus:ring-2 focus:ring-brand-primary focus:bg-white">
                        <option value="" disabled {{ old('senshu_corner') === null ? 'selected' : '' }}>-- Pilih Peraih SENSHU --</option>
                        <option value="aka" {{ old('senshu_corner') === 'aka' ? 'selected' : '' }}>🔴 AKA (Keunggulan Sudut Merah)</option>
                        <option value="ao" {{ old('senshu_corner') === 'ao' ? 'selected' : '' }}>🔵 AO (Keunggulan Sudut Biru)</option>
                    </select>
                    @error('senshu_corner')
                        <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Split Screen WKF Scoreboard Input (AKA Red vs AO Blue) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- SISI AKA (MERAH / RED CORNER) -->
            <div class="bg-white rounded-2xl border-2 border-red-500/40 shadow-md overflow-hidden flex flex-col justify-between">
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
                            <label for="aka_kohai_id" class="block text-xs font-extrabold text-red-700 uppercase tracking-wider mb-1">Pilih Kohai (Sudut Merah AKA)</label>
                            <select name="aka_kohai_id" id="aka_kohai_id" required onchange="updateKohaiDropdowns()" class="w-full px-4 py-2.5 rounded-xl border border-red-300 bg-red-50/30 text-sm font-bold text-gray-900 focus:outline-none focus:ring-2 focus:ring-red-500">
                                <option value="" disabled selected>-- Pilih Kohai AKA --</option>
                                @foreach($kohais as $k)
                                    <option value="{{ $k->id }}" {{ old('aka_kohai_id') == $k->id ? 'selected' : '' }}>
                                        🔴 {{ $k->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('aka_kohai_id')
                                <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Poin WKF (Ippon, Waza-ari, Yuko) -->
                        <div>
                            <h4 class="text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2 border-b border-gray-100 pb-1">Perolehan Poin WKF (AKA)</h4>
                            <div class="grid grid-cols-3 gap-3">
                                <div class="bg-gray-50 p-3 rounded-xl border border-gray-200 text-center">
                                    <label for="aka_ippon" class="block text-[11px] font-bold text-gray-600">IPPON (3 Pts)</label>
                                    <input type="number" name="aka_ippon" id="aka_ippon" value="{{ old('aka_ippon', 0) }}" min="0" required class="w-full mt-1 text-center font-bold text-lg rounded-lg border-gray-300 bg-white">
                                </div>
                                <div class="bg-gray-50 p-3 rounded-xl border border-gray-200 text-center">
                                    <label for="aka_wazaari" class="block text-[11px] font-bold text-gray-600">WAZA-ARI (2 Pts)</label>
                                    <input type="number" name="aka_wazaari" id="aka_wazaari" value="{{ old('aka_wazaari', 0) }}" min="0" required class="w-full mt-1 text-center font-bold text-lg rounded-lg border-gray-300 bg-white">
                                </div>
                                <div class="bg-gray-50 p-3 rounded-xl border border-gray-200 text-center">
                                    <label for="aka_yuko" class="block text-[11px] font-bold text-gray-600">YUKO (1 Pt)</label>
                                    <input type="number" name="aka_yuko" id="aka_yuko" value="{{ old('aka_yuko', 0) }}" min="0" required class="w-full mt-1 text-center font-bold text-lg rounded-lg border-gray-300 bg-white">
                                </div>
                            </div>
                        </div>

                        <!-- Pelanggaran WKF (C1, C2, Warnings) -->
                        <div>
                            <h4 class="text-xs font-extrabold text-red-700 uppercase tracking-wider mb-2 border-b border-gray-100 pb-1">Pelanggaran WKF (AKA)</h4>
                            <div class="grid grid-cols-2 gap-3 mb-3">
                                <div class="bg-red-50/50 p-3 rounded-xl border border-red-200 text-center">
                                    <label for="aka_c1" class="block text-[11px] font-bold text-red-800">Categori 1 (C1)</label>
                                    <input type="number" name="aka_c1" id="aka_c1" value="{{ old('aka_c1', 0) }}" min="0" required class="w-full mt-1 text-center font-bold text-base rounded-lg border-red-300 bg-white">
                                </div>
                                <div class="bg-red-50/50 p-3 rounded-xl border border-red-200 text-center">
                                    <label for="aka_c2" class="block text-[11px] font-bold text-red-800">Categori 2 (C2)</label>
                                    <input type="number" name="aka_c2" id="aka_c2" value="{{ old('aka_c2', 0) }}" min="0" required class="w-full mt-1 text-center font-bold text-base rounded-lg border-red-300 bg-white">
                                </div>
                            </div>

                            <div class="flex flex-wrap gap-3 text-xs">
                                <label class="flex items-center gap-1.5 cursor-pointer">
                                    <input type="checkbox" name="aka_ce" value="1" {{ old('aka_ce') ? 'checked' : '' }} class="w-4 h-4 text-red-600 rounded">
                                    <span class="font-bold text-gray-700">CE (Chukoku)</span>
                                </label>
                                <label class="flex items-center gap-1.5 cursor-pointer">
                                    <input type="checkbox" name="aka_hc" value="1" {{ old('aka_hc') ? 'checked' : '' }} class="w-4 h-4 text-red-600 rounded">
                                    <span class="font-bold text-gray-700">HC (Hansoku Chui)</span>
                                </label>
                                <label class="flex items-center gap-1.5 cursor-pointer">
                                    <input type="checkbox" name="aka_h" value="1" {{ old('aka_h') ? 'checked' : '' }} class="w-4 h-4 text-red-600 rounded">
                                    <span class="font-bold text-red-700">H (Hansoku / Diskualifikasi)</span>
                                </label>
                            </div>
                        </div>

                        <!-- Rating Evaluasi Teknis AKA -->
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-200 space-y-3">
                            <h4 class="text-xs font-extrabold text-gray-700 uppercase tracking-wider">Evaluasi Teknis AKA (Skala 1 - 10)</h4>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label for="aka_score_attack" class="block text-[11px] font-bold text-gray-600">Nilai Attack / Serangan</label>
                                    <input type="number" name="aka_score_attack" id="aka_score_attack" value="{{ old('aka_score_attack', 7) }}" min="1" max="10" required class="w-full mt-1 px-3 py-1.5 rounded-lg border-gray-300 text-sm font-bold">
                                </div>
                                <div>
                                    <label for="aka_score_accuracy" class="block text-[11px] font-bold text-gray-600">Nilai Accuracy / Akurasi</label>
                                    <input type="number" name="aka_score_accuracy" id="aka_score_accuracy" value="{{ old('aka_score_accuracy', 7) }}" min="1" max="10" required class="w-full mt-1 px-3 py-1.5 rounded-lg border-gray-300 text-sm font-bold">
                                </div>
                            </div>
                        </div>

                        <!-- Catatan Evaluasi Khusus AKA -->
                        <div>
                            <label for="aka_evaluation_notes" class="block text-xs font-extrabold text-red-800 uppercase tracking-wider mb-1">Catatan Evaluasi & Saran Khusus AKA</label>
                            <textarea name="aka_evaluation_notes" id="aka_evaluation_notes" rows="3" placeholder="Saran khusus untuk Kohai AKA (misal: perbaiki pertahanan atas, kontrol emosi saat menyerang)..."
                                class="w-full p-3 rounded-xl border border-red-200 text-xs bg-red-50/20 focus:outline-none focus:ring-2 focus:ring-red-500">{{ old('aka_evaluation_notes') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SISI AO (BIRU / BLUE CORNER) -->
            <div class="bg-white rounded-2xl border-2 border-brand-primary/40 shadow-md overflow-hidden flex flex-col justify-between">
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
                            <label for="ao_kohai_id" class="block text-xs font-extrabold text-brand-primary uppercase tracking-wider mb-1">Pilih Kohai (Sudut Biru AO)</label>
                            <select name="ao_kohai_id" id="ao_kohai_id" required onchange="updateKohaiDropdowns()" class="w-full px-4 py-2.5 rounded-xl border border-brand-primary/40 bg-blue-50/30 text-sm font-bold text-gray-900 focus:outline-none focus:ring-2 focus:ring-brand-primary">
                                <option value="" disabled selected>-- Pilih Kohai AO --</option>
                                @foreach($kohais as $k)
                                    <option value="{{ $k->id }}" {{ old('ao_kohai_id') == $k->id ? 'selected' : '' }}>
                                        🔵 {{ $k->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('ao_kohai_id')
                                <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Poin WKF (Ippon, Waza-ari, Yuko) -->
                        <div>
                            <h4 class="text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2 border-b border-gray-100 pb-1">Perolehan Poin WKF (AO)</h4>
                            <div class="grid grid-cols-3 gap-3">
                                <div class="bg-gray-50 p-3 rounded-xl border border-gray-200 text-center">
                                    <label for="ao_ippon" class="block text-[11px] font-bold text-gray-600">IPPON (3 Pts)</label>
                                    <input type="number" name="ao_ippon" id="ao_ippon" value="{{ old('ao_ippon', 0) }}" min="0" required class="w-full mt-1 text-center font-bold text-lg rounded-lg border-gray-300 bg-white">
                                </div>
                                <div class="bg-gray-50 p-3 rounded-xl border border-gray-200 text-center">
                                    <label for="ao_wazaari" class="block text-[11px] font-bold text-gray-600">WAZA-ARI (2 Pts)</label>
                                    <input type="number" name="ao_wazaari" id="ao_wazaari" value="{{ old('ao_wazaari', 0) }}" min="0" required class="w-full mt-1 text-center font-bold text-lg rounded-lg border-gray-300 bg-white">
                                </div>
                                <div class="bg-gray-50 p-3 rounded-xl border border-gray-200 text-center">
                                    <label for="ao_yuko" class="block text-[11px] font-bold text-gray-600">YUKO (1 Pt)</label>
                                    <input type="number" name="ao_yuko" id="ao_yuko" value="{{ old('ao_yuko', 0) }}" min="0" required class="w-full mt-1 text-center font-bold text-lg rounded-lg border-gray-300 bg-white">
                                </div>
                            </div>
                        </div>

                        <!-- Pelanggaran WKF (C1, C2, Warnings) -->
                        <div>
                            <h4 class="text-xs font-extrabold text-brand-primary uppercase tracking-wider mb-2 border-b border-gray-100 pb-1">Pelanggaran WKF (AO)</h4>
                            <div class="grid grid-cols-2 gap-3 mb-3">
                                <div class="bg-blue-50/50 p-3 rounded-xl border border-blue-200 text-center">
                                    <label for="ao_c1" class="block text-[11px] font-bold text-blue-900">Categori 1 (C1)</label>
                                    <input type="number" name="ao_c1" id="ao_c1" value="{{ old('ao_c1', 0) }}" min="0" required class="w-full mt-1 text-center font-bold text-base rounded-lg border-blue-300 bg-white">
                                </div>
                                <div class="bg-blue-50/50 p-3 rounded-xl border border-blue-200 text-center">
                                    <label for="ao_c2" class="block text-[11px] font-bold text-blue-900">Categori 2 (C2)</label>
                                    <input type="number" name="ao_c2" id="ao_c2" value="{{ old('ao_c2', 0) }}" min="0" required class="w-full mt-1 text-center font-bold text-base rounded-lg border-blue-300 bg-white">
                                </div>
                            </div>

                            <div class="flex flex-wrap gap-3 text-xs">
                                <label class="flex items-center gap-1.5 cursor-pointer">
                                    <input type="checkbox" name="ao_ce" value="1" {{ old('ao_ce') ? 'checked' : '' }} class="w-4 h-4 text-brand-primary rounded">
                                    <span class="font-bold text-gray-700">CE (Chukoku)</span>
                                </label>
                                <label class="flex items-center gap-1.5 cursor-pointer">
                                    <input type="checkbox" name="ao_hc" value="1" {{ old('ao_hc') ? 'checked' : '' }} class="w-4 h-4 text-brand-primary rounded">
                                    <span class="font-bold text-gray-700">HC (Hansoku Chui)</span>
                                </label>
                                <label class="flex items-center gap-1.5 cursor-pointer">
                                    <input type="checkbox" name="ao_h" value="1" {{ old('ao_h') ? 'checked' : '' }} class="w-4 h-4 text-brand-primary rounded">
                                    <span class="font-bold text-blue-900">H (Hansoku / Diskualifikasi)</span>
                                </label>
                            </div>
                        </div>

                        <!-- Rating Evaluasi Teknis AO -->
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-200 space-y-3">
                            <h4 class="text-xs font-extrabold text-gray-700 uppercase tracking-wider">Evaluasi Teknis AO (Skala 1 - 10)</h4>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label for="ao_score_attack" class="block text-[11px] font-bold text-gray-600">Nilai Attack / Serangan</label>
                                    <input type="number" name="ao_score_attack" id="ao_score_attack" value="{{ old('ao_score_attack', 7) }}" min="1" max="10" required class="w-full mt-1 px-3 py-1.5 rounded-lg border-gray-300 text-sm font-bold">
                                </div>
                                <div>
                                    <label for="ao_score_accuracy" class="block text-[11px] font-bold text-gray-600">Nilai Accuracy / Akurasi</label>
                                    <input type="number" name="ao_score_accuracy" id="ao_score_accuracy" value="{{ old('ao_score_accuracy', 7) }}" min="1" max="10" required class="w-full mt-1 px-3 py-1.5 rounded-lg border-gray-300 text-sm font-bold">
                                </div>
                            </div>
                        </div>

                        <!-- Catatan Evaluasi Khusus AO -->
                        <div>
                            <label for="ao_evaluation_notes" class="block text-xs font-extrabold text-brand-primary uppercase tracking-wider mb-1">Catatan Evaluasi & Saran Khusus AO</label>
                            <textarea name="ao_evaluation_notes" id="ao_evaluation_notes" rows="3" placeholder="Saran khusus untuk Kohai AO (misal: tingkatkan fleksibilitas kaki untuk Gyaku-Zuki)..."
                                class="w-full p-3 rounded-xl border border-blue-200 text-xs bg-blue-50/20 focus:outline-none focus:ring-2 focus:ring-brand-primary">{{ old('ao_evaluation_notes') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Submit Button -->
        <div class="flex justify-end gap-3 pt-2">
            <a href="{{ route('senpai.kumite.index') }}" class="px-5 py-3 rounded-xl bg-gray-200 hover:bg-gray-300 text-gray-800 text-xs font-bold transition">
                Batal
            </a>
            <button type="submit" class="px-8 py-3 rounded-xl bg-brand-primary hover:bg-brand-primary/90 text-white font-bold text-sm shadow-md transition">
                Simpan Raport Kumite WKF
            </button>
        </div>
    </form>
</div>

<!-- JS Dynamic Filter so AKA and AO cannot select the same Kohai -->
<script>
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

    document.addEventListener('DOMContentLoaded', updateKohaiDropdowns);
</script>
@endsection
