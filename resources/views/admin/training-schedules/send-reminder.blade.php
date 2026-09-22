@extends('layouts.admin')

@section('title', 'Kirim Pengingat Jadwal Latihan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header & Back Button -->
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Kirim Pengingat Email</h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">Kirim notifikasi email pengingat latihan secara langsung ke Senpai dan Kohai</p>
        </div>
        <a href="{{ route('admin.training-schedules.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-200 hover:bg-slate-300 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs font-bold rounded-xl transition whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Ringkasan Jadwal Latihan Card -->
    <div class="bg-white dark:bg-slate-900 p-5 sm:p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm transition-colors space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 dark:border-slate-800 pb-4">
            <div>
                <div class="flex items-center gap-2 mb-1.5 flex-wrap">
                    @if($trainingSchedule->type === 'rutin')
                        <span class="px-2.5 py-0.5 inline-flex text-[10px] font-extrabold rounded-full bg-blue-50 dark:bg-blue-950/40 text-brand-primary dark:text-blue-300 border border-blue-200 dark:border-blue-800/60">
                            🔄 Rutin Mingguan
                        </span>
                    @else
                        <span class="px-2.5 py-0.5 inline-flex text-[10px] font-extrabold rounded-full bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-800/60">
                            ⚡ Latihan Tambahan
                        </span>
                    @endif

                    <span class="px-2.5 py-0.5 inline-flex items-center gap-1 text-[10px] font-extrabold rounded-full border {{ $trainingSchedule->is_active ? 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 border-emerald-200 dark:border-emerald-800/60' : 'bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 border-slate-200 dark:border-slate-700' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $trainingSchedule->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                        {{ $trainingSchedule->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
                <h2 class="text-base sm:text-lg font-extrabold text-slate-900 dark:text-white leading-snug">{{ $trainingSchedule->title }}</h2>
            </div>
            <div class="sm:text-right">
                <span class="text-[11px] text-slate-400 font-medium block">Waktu Latihan</span>
                <span class="font-mono font-bold text-sm sm:text-base text-brand-primary dark:text-brand-secondary bg-slate-50 dark:bg-slate-800 px-2.5 py-1 rounded-lg border border-slate-200 dark:border-slate-700 inline-block mt-0.5">
                    {{ $trainingSchedule->time_range }} WIB
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
            <div class="p-3 rounded-xl bg-slate-50/70 dark:bg-slate-800/50 border border-slate-200/60 dark:border-slate-700/60">
                <span class="text-slate-400 font-medium block text-[11px]">Hari / Tanggal</span>
                <span class="font-bold text-slate-900 dark:text-white block mt-0.5">{{ $trainingSchedule->days_string }}</span>
            </div>
            <div class="p-3 rounded-xl bg-slate-50/70 dark:bg-slate-800/50 border border-slate-200/60 dark:border-slate-700/60">
                <span class="text-slate-400 font-medium block text-[11px]">Lokasi Tempat</span>
                <span class="font-bold text-slate-900 dark:text-white block mt-0.5 truncate">
                    📍 {{ $trainingSchedule->location_label }} ({{ $trainingSchedule->location_detail ?? 'Dojo Utama' }})
                </span>
            </div>
            <div class="p-3 rounded-xl bg-slate-50/70 dark:bg-slate-800/50 border border-slate-200/60 dark:border-slate-700/60">
                <span class="text-slate-400 font-medium block text-[11px]">Catatan Latihan</span>
                <span class="font-medium text-slate-700 dark:text-slate-300 block mt-0.5 truncate">
                    {{ $trainingSchedule->notes ?? 'Tidak ada catatan tambahan.' }}
                </span>
            </div>
        </div>
    </div>

    <!-- Send Form -->
    <form action="{{ route('admin.training-schedules.send-reminder.post', $trainingSchedule->id) }}" method="POST" class="space-y-6" id="send-reminder-form">
        @csrf

        <!-- 1. Target Senpai -->
        <div class="bg-white dark:bg-slate-900 p-5 sm:p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm transition-colors space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3.5">
                <div>
                    <h3 class="text-sm font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                        <span>🥋</span> Kirim ke Senpai (Instruktur / Pelatih)
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Pesan dengan format kepelatihan & evaluasi khusus Senpai</p>
                </div>
                <span class="text-[11px] font-bold bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-300 px-2.5 py-0.5 rounded-full border border-amber-200 dark:border-amber-800/60">
                    {{ $senpaiList->count() }} Senpai Terdaftar
                </span>
            </div>

            <div class="space-y-2.5">
                <label class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/80 hover:border-brand-primary dark:hover:border-brand-primary cursor-pointer transition">
                    <input type="radio" name="send_to_senpai" value="all" checked class="w-4 h-4 text-brand-primary focus:ring-brand-primary" onchange="toggleSenpaiPicker(this.value)">
                    <div>
                        <span class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white block">Kirim ke Seluruh Senpai</span>
                        <span class="text-[11px] text-slate-500 dark:text-slate-400">Kirim email ke seluruh instruktur Senpai yang terdaftar ({{ $senpaiList->count() }} akun)</span>
                    </div>
                </label>

                <label class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/80 hover:border-brand-primary dark:hover:border-brand-primary cursor-pointer transition">
                    <input type="radio" name="send_to_senpai" value="selected" class="w-4 h-4 text-brand-primary focus:ring-brand-primary" onchange="toggleSenpaiPicker(this.value)">
                    <div>
                        <span class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white block">Pilih Senpai Tertentu</span>
                        <span class="text-[11px] text-slate-500 dark:text-slate-400">Pilih beberapa instruktur dari daftar</span>
                    </div>
                </label>

                <label class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/80 hover:border-brand-primary dark:hover:border-brand-primary cursor-pointer transition">
                    <input type="radio" name="send_to_senpai" value="none" class="w-4 h-4 text-brand-primary focus:ring-brand-primary" onchange="toggleSenpaiPicker(this.value)">
                    <div>
                        <span class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white block">Jangan Kirim ke Senpai</span>
                        <span class="text-[11px] text-slate-500 dark:text-slate-400">Lewati pengiriman email ke role Senpai</span>
                    </div>
                </label>
            </div>

            <!-- Senpai Checklist Container (Hidden by default) -->
            <div id="senpai-picker-container" class="hidden pt-3 border-t border-slate-100 dark:border-slate-800 space-y-2">
                <div class="flex items-center justify-between text-xs">
                    <span class="font-bold text-slate-700 dark:text-slate-300">Pilih Nama Senpai:</span>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="setAllChecks('senpai-item', true)" class="font-bold text-brand-primary dark:text-brand-secondary hover:underline text-[11px]">Pilih Semua</button>
                        <span class="text-slate-300 dark:text-slate-600">•</span>
                        <button type="button" onclick="setAllChecks('senpai-item', false)" class="font-bold text-slate-500 hover:underline text-[11px]">Hapus</button>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 max-h-56 overflow-y-auto p-1">
                    @foreach($senpaiList as $senpai)
                        <label class="flex items-center gap-2.5 p-2.5 rounded-xl bg-slate-50/80 dark:bg-slate-800/50 border border-slate-200/80 dark:border-slate-700/60 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                            <input type="checkbox" name="senpai_ids[]" value="{{ $senpai->id }}" class="senpai-item w-4 h-4 rounded text-brand-primary focus:ring-brand-primary">
                            <div class="min-w-0">
                                <span class="text-xs font-bold text-slate-900 dark:text-white block truncate">{{ $senpai->name }}</span>
                                <span class="text-[10px] text-slate-400 dark:text-slate-500 truncate block">{{ $senpai->email }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- 2. Target Kohai -->
        <div class="bg-white dark:bg-slate-900 p-5 sm:p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm transition-colors space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3.5">
                <div>
                    <h3 class="text-sm font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                        <span>🥋</span> Kirim ke Kohai (Anggota Dojo)
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Pesan pengingat persiapan Gi & kehadiran tepat waktu khusus Kohai</p>
                </div>
                <span class="text-[11px] font-bold bg-blue-50 dark:bg-blue-950/40 text-brand-primary dark:text-blue-300 px-2.5 py-0.5 rounded-full border border-blue-200 dark:border-blue-800/60">
                    {{ $kohaiList->count() }} Kohai Terdaftar
                </span>
            </div>

            <div class="space-y-2.5">
                <label class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/80 hover:border-brand-primary dark:hover:border-brand-primary cursor-pointer transition">
                    <input type="radio" name="send_to_kohai" value="all" checked class="w-4 h-4 text-brand-primary focus:ring-brand-primary" onchange="toggleKohaiPicker(this.value)">
                    <div>
                        <span class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white block">Kirim ke Seluruh Kohai</span>
                        <span class="text-[11px] text-slate-500 dark:text-slate-400">Kirim email ke seluruh anggota Kohai yang terdaftar ({{ $kohaiList->count() }} akun)</span>
                    </div>
                </label>

                <label class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/80 hover:border-brand-primary dark:hover:border-brand-primary cursor-pointer transition">
                    <input type="radio" name="send_to_kohai" value="polindra" class="w-4 h-4 text-brand-primary focus:ring-brand-primary" onchange="toggleKohaiPicker(this.value)">
                    <div>
                        <span class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white block">Hanya Kohai Mahasiswa Polindra</span>
                        <span class="text-[11px] text-slate-500 dark:text-slate-400">Hanya anggota yang terdaftar di jurusan & prodi Polindra</span>
                    </div>
                </label>

                <label class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/80 hover:border-brand-primary dark:hover:border-brand-primary cursor-pointer transition">
                    <input type="radio" name="send_to_kohai" value="selected" class="w-4 h-4 text-brand-primary focus:ring-brand-primary" onchange="toggleKohaiPicker(this.value)">
                    <div>
                        <span class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white block">Pilih Kohai Tertentu</span>
                        <span class="text-[11px] text-slate-500 dark:text-slate-400">Pilih beberapa murid dari daftar</span>
                    </div>
                </label>

                <label class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/80 hover:border-brand-primary dark:hover:border-brand-primary cursor-pointer transition">
                    <input type="radio" name="send_to_kohai" value="none" class="w-4 h-4 text-brand-primary focus:ring-brand-primary" onchange="toggleKohaiPicker(this.value)">
                    <div>
                        <span class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white block">Jangan Kirim ke Kohai</span>
                        <span class="text-[11px] text-slate-500 dark:text-slate-400">Lewati pengiriman email ke role Kohai</span>
                    </div>
                </label>
            </div>

            <!-- Kohai Checklist Container (Hidden by default) -->
            <div id="kohai-picker-container" class="hidden pt-3 border-t border-slate-100 dark:border-slate-800 space-y-2">
                <div class="flex items-center justify-between text-xs">
                    <span class="font-bold text-slate-700 dark:text-slate-300">Pilih Nama Kohai:</span>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="setAllChecks('kohai-item', true)" class="font-bold text-brand-primary dark:text-brand-secondary hover:underline text-[11px]">Pilih Semua</button>
                        <span class="text-slate-300 dark:text-slate-600">•</span>
                        <button type="button" onclick="setAllChecks('kohai-item', false)" class="font-bold text-slate-500 hover:underline text-[11px]">Hapus</button>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 max-h-64 overflow-y-auto p-1">
                    @foreach($kohaiList as $kohai)
                        <label class="flex items-center gap-2.5 p-2.5 rounded-xl bg-slate-50/80 dark:bg-slate-800/50 border border-slate-200/80 dark:border-slate-700/60 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                            <input type="checkbox" name="kohai_ids[]" value="{{ $kohai->id }}" class="kohai-item w-4 h-4 rounded text-brand-primary focus:ring-brand-primary">
                            <div class="min-w-0">
                                <span class="text-xs font-bold text-slate-900 dark:text-white block truncate">{{ $kohai->name }}</span>
                                <span class="text-[10px] text-slate-400 dark:text-slate-500 truncate block">
                                    {{ $kohai->kohaiProfile?->studyProgram?->name ?? 'Umum' }} • {{ $kohai->email }}
                                </span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Submit Button Row -->
        <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3">
            <a href="{{ route('admin.training-schedules.index') }}" class="py-2.5 px-4 bg-slate-200 hover:bg-slate-300 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs font-bold rounded-xl transition">
                Batal
            </a>
            <button type="submit" id="btn-submit-send" class="py-2.5 px-6 bg-gradient-to-r from-brand-primary to-brand-secondary hover:from-brand-primary/90 hover:to-brand-secondary/90 text-white text-xs font-bold rounded-xl transition shadow-md shadow-brand-primary/20 inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                <span>Kirim Notifikasi Email Sekarang</span>
            </button>
        </div>
    </form>
</div>

<script>
    function toggleSenpaiPicker(val) {
        const c = document.getElementById('senpai-picker-container');
        if (val === 'selected') {
            c.classList.remove('hidden');
        } else {
            c.classList.add('hidden');
        }
    }

    function toggleKohaiPicker(val) {
        const c = document.getElementById('kohai-picker-container');
        if (val === 'selected') {
            c.classList.remove('hidden');
        } else {
            c.classList.add('hidden');
        }
    }

    function setAllChecks(className, checked) {
        document.querySelectorAll('.' + className).forEach(cb => cb.checked = checked);
    }

    document.getElementById('send-reminder-form').addEventListener('submit', function() {
        const btn = document.getElementById('btn-submit-send');
        btn.disabled = true;
        btn.innerHTML = `
            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
            <span>Mengirim Notifikasi Email...</span>
        `;
    });
</script>
@endsection
