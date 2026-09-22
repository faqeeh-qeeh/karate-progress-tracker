@extends('layouts.admin')

@section('title', 'Tambah Jadwal Latihan')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header & Back Button -->
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Tambah Jadwal Latihan</h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">Buat jadwal latihan rutin mingguan atau latihan tambahan untuk dojo</p>
        </div>
        <a href="{{ route('admin.training-schedules.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-200 hover:bg-slate-300 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs font-bold rounded-xl transition whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white dark:bg-slate-900 p-6 sm:p-8 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm transition-colors">
        <form action="{{ route('admin.training-schedules.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- 1. Jenis Latihan Selection -->
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Jenis Latihan <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <label class="relative flex items-center gap-3 p-4 rounded-xl border-2 border-slate-200 dark:border-slate-700 hover:border-brand-primary dark:hover:border-brand-primary bg-slate-50/50 dark:bg-slate-800/80 cursor-pointer transition has-[:checked]:border-brand-primary has-[:checked]:bg-blue-50/40 dark:has-[:checked]:bg-blue-950/30">
                        <input type="radio" name="type" value="rutin" {{ old('type', 'rutin') === 'rutin' ? 'checked' : '' }} class="w-4 h-4 text-brand-primary focus:ring-brand-primary" onchange="toggleType(this.value)">
                        <div>
                            <span class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white block">🔄 Latihan Rutin</span>
                            <span class="text-xs text-slate-500 dark:text-slate-400">Terjadwal setiap minggu secara berulang</span>
                        </div>
                    </label>

                    <label class="relative flex items-center gap-3 p-4 rounded-xl border-2 border-slate-200 dark:border-slate-700 hover:border-brand-primary dark:hover:border-brand-primary bg-slate-50/50 dark:bg-slate-800/80 cursor-pointer transition has-[:checked]:border-brand-primary has-[:checked]:bg-blue-50/40 dark:has-[:checked]:bg-blue-950/30">
                        <input type="radio" name="type" value="tambahan" {{ old('type') === 'tambahan' ? 'checked' : '' }} class="w-4 h-4 text-brand-primary focus:ring-brand-primary" onchange="toggleType(this.value)">
                        <div>
                            <span class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white block">⚡ Latihan Tambahan</span>
                            <span class="text-xs text-slate-500 dark:text-slate-400">Latihan khusus pada tanggal tertentu</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- 2. Judul Latihan -->
            <div>
                <label for="title" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Judul / Nama Jadwal <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                    placeholder="Contoh: Latihan Rutin Selasa & Jumat, Latihan Persiapan Kejurnas..."
                    class="w-full px-4 py-3 rounded-xl border @error('title') border-red-500 bg-red-50/30 text-red-900 dark:text-red-300 @else border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/80 text-slate-900 dark:text-white @enderror text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition placeholder:text-slate-400 dark:placeholder:text-slate-500">
                @error('title')
                    <p class="text-xs text-red-600 dark:text-red-400 mt-1.5 font-medium flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- 3. Hari Latihan (Untuk Jadwal Rutin) -->
            <div id="section-days" class="{{ old('type', 'rutin') === 'tambahan' ? 'hidden' : '' }} space-y-2">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                    Hari Latihan Mingguan <span class="text-red-500">*</span>
                    <span class="text-xs text-slate-400 dark:text-slate-500 font-normal lowercase">(dapat memilih beberapa hari)</span>
                </label>
                <div class="flex flex-wrap gap-2">
                    @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $hari)
                        <label class="cursor-pointer">
                            <input type="checkbox" name="days_of_week[]" value="{{ $hari }}"
                                {{ in_array($hari, old('days_of_week', [])) ? 'checked' : '' }}
                                class="peer sr-only">
                            <span class="inline-flex items-center px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/80 text-slate-700 dark:text-slate-300 text-xs font-bold transition peer-checked:bg-brand-primary peer-checked:text-white peer-checked:border-brand-primary dark:peer-checked:bg-brand-primary dark:peer-checked:border-brand-primary hover:border-brand-primary/60">
                                {{ $hari }}
                            </span>
                        </label>
                    @endforeach
                </div>
                @error('days_of_week')
                    <p class="text-xs text-red-600 dark:text-red-400 mt-1.5 font-medium flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- 4. Tanggal Spesifik (Untuk Jadwal Tambahan) -->
            <div id="section-specific-date" class="{{ old('type', 'rutin') === 'tambahan' ? '' : 'hidden' }} space-y-1.5">
                <label for="specific_date" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Tanggal Latihan Spesifik <span class="text-red-500">*</span></label>
                <input type="date" name="specific_date" id="specific_date" value="{{ old('specific_date') }}"
                    class="w-full px-4 py-3 rounded-xl border @error('specific_date') border-red-500 bg-red-50/30 text-red-900 dark:text-red-300 @else border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/80 text-slate-900 dark:text-white @enderror text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition">
                @error('specific_date')
                    <p class="text-xs text-red-600 dark:text-red-400 mt-1.5 font-medium flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- 5. Periode Tanggal Berlaku (Mulai & Selesai) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="start_date" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Berlaku Mulai Tanggal <span class="text-red-500">*</span></label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date', date('Y-m-d')) }}" required
                        class="w-full px-4 py-3 rounded-xl border @error('start_date') border-red-500 bg-red-50/30 text-red-900 dark:text-red-300 @else border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/80 text-slate-900 dark:text-white @enderror text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition">
                    @error('start_date')
                        <p class="text-xs text-red-600 dark:text-red-400 mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="end_date" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Berlaku Sampai Tanggal <span class="text-slate-400 font-normal lowercase">(opsional)</span></label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                        class="w-full px-4 py-3 rounded-xl border @error('end_date') border-red-500 bg-red-50/30 text-red-900 dark:text-red-300 @else border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/80 text-slate-900 dark:text-white @enderror text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition">
                    @error('end_date')
                        <p class="text-xs text-red-600 dark:text-red-400 mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- 6. Waktu Latihan (Jam Mulai & Selesai) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="start_time" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Waktu Mulai <span class="text-red-500">*</span></label>
                    <input type="time" name="start_time" id="start_time" value="{{ old('start_time', '15:00') }}" required
                        class="w-full px-4 py-3 rounded-xl border @error('start_time') border-red-500 bg-red-50/30 text-red-900 dark:text-red-300 @else border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/80 text-slate-900 dark:text-white @enderror text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition">
                    @error('start_time')
                        <p class="text-xs text-red-600 dark:text-red-400 mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="end_time" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Waktu Selesai <span class="text-slate-400 font-normal lowercase">(opsional)</span></label>
                    <input type="time" name="end_time" id="end_time" value="{{ old('end_time') }}"
                        class="w-full px-4 py-3 rounded-xl border @error('end_time') border-red-500 bg-red-50/30 text-red-900 dark:text-red-300 @else border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/80 text-slate-900 dark:text-white @enderror text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition">
                    @error('end_time')
                        <p class="text-xs text-red-600 dark:text-red-400 mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- 7. Lokasi Latihan -->
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Lokasi Tempat <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="relative flex items-center gap-3 p-3.5 rounded-xl border-2 border-slate-200 dark:border-slate-700 hover:border-brand-primary dark:hover:border-brand-primary bg-slate-50/50 dark:bg-slate-800/80 cursor-pointer transition has-[:checked]:border-brand-primary has-[:checked]:bg-blue-50/40 dark:has-[:checked]:bg-blue-950/30">
                            <input type="radio" name="location_type" value="polindra" {{ old('location_type', 'polindra') === 'polindra' ? 'checked' : '' }} class="w-4 h-4 text-brand-primary focus:ring-brand-primary">
                            <div>
                                <span class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white block">🏛️ Di Dalam Polindra</span>
                                <span class="text-[11px] text-slate-500 dark:text-slate-400">Gedung / Lapangan kampus</span>
                            </div>
                        </label>

                        <label class="relative flex items-center gap-3 p-3.5 rounded-xl border-2 border-slate-200 dark:border-slate-700 hover:border-brand-primary dark:hover:border-brand-primary bg-slate-50/50 dark:bg-slate-800/80 cursor-pointer transition has-[:checked]:border-brand-primary has-[:checked]:bg-blue-50/40 dark:has-[:checked]:bg-blue-950/30">
                            <input type="radio" name="location_type" value="luar_polindra" {{ old('location_type') === 'luar_polindra' ? 'checked' : '' }} class="w-4 h-4 text-brand-primary focus:ring-brand-primary">
                            <div>
                                <span class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white block">📍 Di Luar Polindra</span>
                                <span class="text-[11px] text-slate-500 dark:text-slate-400">Dojo cabang / Tempat eksternal</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <label for="location_detail" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Detail Tempat Spesifik</label>
                    <input type="text" name="location_detail" id="location_detail" value="{{ old('location_detail') }}"
                        placeholder="Contoh: Gedung Student Center Lt. 2 / Lapangan Basket Utama..."
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/80 text-slate-900 dark:text-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition placeholder:text-slate-400 dark:placeholder:text-slate-500">
                </div>

                <div>
                    <label for="maps_url" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Link Google Maps <span class="text-slate-400 font-normal lowercase">(opsional)</span></label>
                    <input type="url" name="maps_url" id="maps_url" value="{{ old('maps_url') }}"
                        placeholder="https://maps.app.goo.gl/..."
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/80 text-slate-900 dark:text-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition placeholder:text-slate-400 dark:placeholder:text-slate-500">
                </div>
            </div>

            <!-- 8. Pengaturan Pengingat Email -->
            <div class="p-4 sm:p-5 rounded-2xl bg-slate-50/80 dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-700 space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
                            <span>📧</span> Pengingat Email Otomatis
                        </h3>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Kirim email pengingat terjadwal ke seluruh Senpai & Kohai</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="email_reminder" value="1" id="toggle-reminder" {{ old('email_reminder', '1') == '1' ? 'checked' : '' }} class="sr-only peer" onchange="toggleReminderTime(this.checked)">
                        <div class="w-11 h-6 bg-slate-200 dark:bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-primary"></div>
                    </label>
                </div>

                <div id="section-reminder-time" class="{{ old('email_reminder', '1') == '1' ? '' : 'hidden' }} pt-3 border-t border-slate-200/80 dark:border-slate-700">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Pilihan Waktu Pengiriman Email</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 cursor-pointer hover:border-brand-primary dark:hover:border-brand-primary transition">
                            <input type="radio" name="reminder_time" value="pagi" {{ old('reminder_time', 'pagi') === 'pagi' ? 'checked' : '' }} class="w-4 h-4 text-brand-primary focus:ring-brand-primary">
                            <div>
                                <span class="text-xs font-bold text-slate-900 dark:text-white block">🌅 Pagi Hari (Pukul 06:00 WIB)</span>
                                <span class="text-[10px] text-slate-500 dark:text-slate-400">Dikirim pada pagi hari H latihan</span>
                            </div>
                        </label>

                        <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 cursor-pointer hover:border-brand-primary dark:hover:border-brand-primary transition">
                            <input type="radio" name="reminder_time" value="malam" {{ old('reminder_time') === 'malam' ? 'checked' : '' }} class="w-4 h-4 text-brand-primary focus:ring-brand-primary">
                            <div>
                                <span class="text-xs font-bold text-slate-900 dark:text-white block">🌙 Malam Hari (Pukul 20:00 WIB)</span>
                                <span class="text-[10px] text-slate-500 dark:text-slate-400">Dikirim pada malam hari (H-1 sebelum latihan)</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- 9. Catatan / Deskripsi -->
            <div>
                <label for="notes" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Catatan / Materi Latihan <span class="text-slate-400 font-normal lowercase">(opsional)</span></label>
                <textarea name="notes" id="notes" rows="3"
                    placeholder="Contoh: Membawa perlengkapan pelindung Kumite (Hand protector, Shin guard), materi Kihon Ippon Kumite..."
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/80 text-slate-900 dark:text-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition placeholder:text-slate-400 dark:placeholder:text-slate-500">{{ old('notes') }}</textarea>
            </div>

            <!-- 10. Status Jadwal Aktif -->
            <div class="flex items-center gap-3 p-3.5 rounded-xl bg-slate-50/80 dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-700">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }}
                    class="w-4 h-4 rounded text-brand-primary focus:ring-brand-primary">
                <label for="is_active" class="cursor-pointer">
                    <span class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white block">Aktifkan Jadwal Ini</span>
                    <span class="text-[11px] text-slate-500 dark:text-slate-400">Jadwal yang aktif akan ditampilkan pada dashboard Senpai dan Kohai</span>
                </label>
            </div>

            <!-- Submit Button Row -->
            <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3">
                <a href="{{ route('admin.training-schedules.index') }}" class="py-2.5 px-4 bg-slate-200 hover:bg-slate-300 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs font-bold rounded-xl transition">
                    Batal
                </a>
                <button type="submit" class="py-2.5 px-6 bg-gradient-to-r from-brand-primary to-brand-secondary hover:from-brand-primary/90 hover:to-brand-secondary/90 text-white text-xs font-bold rounded-xl transition shadow-md shadow-brand-primary/20">
                    Simpan Jadwal Latihan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleType(val) {
        const daysSec = document.getElementById('section-days');
        const specSec = document.getElementById('section-specific-date');
        if (val === 'rutin') {
            daysSec.classList.remove('hidden');
            specSec.classList.add('hidden');
        } else {
            daysSec.classList.add('hidden');
            specSec.classList.remove('hidden');
        }
    }

    function toggleReminderTime(checked) {
        const reminderSec = document.getElementById('section-reminder-time');
        if (checked) {
            reminderSec.classList.remove('hidden');
        } else {
            reminderSec.classList.add('hidden');
        }
    }
</script>
@endsection
