@extends('layouts.admin')

@section('title', 'Manajemen Sabuk & Tingkatan')

@section('content')
<div class="space-y-6">
    <!-- Top Action & Title Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-sm">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Manajemen Sabuk & Tingkatan</h1>
            <p class="text-xs text-slate-500 mt-1 font-medium">Kelola data master sabuk karate beserta tingkatan Kyu dan Dan</p>
        </div>
        <div class="flex items-center gap-2.5 flex-wrap sm:flex-nowrap">
            <!-- Button Tambah Sabuk -->
            <button type="button" onclick="openModal('modal-create-belt')" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs sm:text-sm rounded-xl shadow-xs transition-all active:scale-[0.99] whitespace-nowrap cursor-pointer">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>+ Sabuk Baru</span>
            </button>

            <!-- Button Tambah Tingkatan -->
            <button type="button" onclick="openModal('modal-create-rank')" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-gradient-to-r from-brand-primary to-brand-secondary hover:from-brand-primary/90 hover:to-brand-secondary/90 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md shadow-brand-primary/20 hover:shadow-lg transition-all active:scale-[0.99] whitespace-nowrap cursor-pointer">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <span>+ Tingkatan (Kyu/Dan)</span>
            </button>
        </div>
    </div>

    <!-- Statistics Row -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: Total Sabuk -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 border border-amber-200/80 flex items-center justify-center text-xl shrink-0">
                🥋
            </div>
            <div class="min-w-0">
                <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Total Sabuk</p>
                <p class="text-xl sm:text-2xl font-black text-slate-900">{{ $totalBelts }}</p>
            </div>
        </div>

        <!-- Card 2: Total Tingkatan -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-blue-50 text-brand-primary border border-blue-200/80 flex items-center justify-center text-xl shrink-0">
                🏆
            </div>
            <div class="min-w-0">
                <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Total Tingkatan</p>
                <p class="text-xl sm:text-2xl font-black text-slate-900">{{ $totalRanks }}</p>
            </div>
        </div>

        <!-- Card 3: Tingkatan Kyu -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-cyan-50 text-cyan-600 border border-cyan-200/80 flex items-center justify-center text-xl shrink-0">
                🎖️
            </div>
            <div class="min-w-0">
                <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Tingkatan Kyu</p>
                <p class="text-xl sm:text-2xl font-black text-slate-900">{{ $totalKyu }} <span class="text-xs text-slate-400 font-normal">Level</span></p>
            </div>
        </div>

        <!-- Card 4: Tingkatan Dan -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-purple-50 text-purple-600 border border-purple-200/80 flex items-center justify-center text-xl shrink-0">
                ⭐
            </div>
            <div class="min-w-0">
                <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Tingkatan Dan</p>
                <p class="text-xl sm:text-2xl font-black text-slate-900">{{ $totalDan }} <span class="text-xs text-slate-400 font-normal">Yudansha</span></p>
            </div>
        </div>
    </div>

    <!-- Search Form Card -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm">
        <form action="{{ route('admin.belts.index') }}" method="GET" class="flex items-center gap-3">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama sabuk atau keterangan filosofi..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary bg-slate-50/50 placeholder:text-slate-400 transition">
            </div>
            <button type="submit" class="py-2.5 px-5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl transition shadow-xs whitespace-nowrap">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('admin.belts.index') }}" class="py-2.5 px-3.5 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold rounded-xl transition whitespace-nowrap">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Belts & Ranks Roster Grid / List -->
    <div class="space-y-4">
        @forelse($belts as $belt)
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden hover:border-slate-300 transition-all">
                <!-- Belt Header Bar -->
                <div class="p-4 sm:p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-slate-50/50">
                    <div class="flex items-center gap-3.5 min-w-0">
                        <!-- Color Preview Indicator -->
                        <div class="w-8 h-8 rounded-xl shadow-xs border border-slate-300/80 shrink-0 flex items-center justify-center font-bold text-xs" style="background-color: {{ $belt->color_code ?? '#E2E8F0' }};">
                            @if(in_array(strtolower($belt->color_code), ['#ffffff', '#fff', 'white']))
                                <span class="w-3 h-3 rounded-full border border-slate-400 bg-white"></span>
                            @endif
                        </div>
                        <div class="min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <h3 class="text-base font-extrabold text-slate-900 tracking-tight">{{ $belt->name }}</h3>
                                <span class="px-2.5 py-0.5 text-[10px] font-extrabold rounded-full bg-slate-100 text-slate-700 border border-slate-200">
                                    {{ $belt->ranks_count }} Tingkatan
                                </span>
                            </div>
                            @if($belt->description)
                                <p class="text-xs text-slate-500 mt-0.5 line-clamp-1">{{ $belt->description }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Belt Action Buttons -->
                    <div class="flex items-center gap-2 self-end sm:self-auto shrink-0">
                        <!-- Tambah Tingkatan untuk Sabuk Ini -->
                        <button type="button" onclick="openCreateRankForBelt({{ $belt->id }}, '{{ addslashes($belt->name) }}')" class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-brand-primary border border-blue-200/80 rounded-xl text-xs font-bold transition flex items-center gap-1 shadow-xs" title="Tambah Tingkatan ke Sabuk Ini">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <span>+ Tingkatan</span>
                        </button>

                        <!-- Edit Sabuk -->
                        <a href="{{ route('admin.belts.edit', $belt->id) }}" class="p-1.5 rounded-xl bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200/80 transition-colors" title="Edit Sabuk">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>

                        <!-- Hapus Sabuk -->
                        <form action="{{ route('admin.belts.destroy', $belt->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus master sabuk {{ $belt->name }} beserta seluruh tingkatannya? Tindakan ini tidak dapat dibatalkan.');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 rounded-xl bg-red-50 text-red-700 hover:bg-red-100 border border-red-200/80 transition-colors" title="Hapus Sabuk">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Ranks Container -->
                <div class="p-4 sm:p-5">
                    @if($belt->ranks->count() > 0)
                        <!-- Mobile View: Ranks List Cards -->
                        <div class="block sm:hidden space-y-2.5">
                            @foreach($belt->ranks as $rk)
                                <div class="p-3 rounded-xl bg-slate-50/80 border border-slate-100 flex items-start justify-between gap-2.5">
                                    <div class="space-y-1 min-w-0">
                                        <div class="flex items-center gap-2">
                                            <span class="px-2 py-0.5 text-[10px] font-black rounded-md {{ $rk->category === 'Dan' ? 'bg-purple-100 text-purple-800' : 'bg-cyan-100 text-cyan-800' }}">
                                                {{ $rk->category }}
                                            </span>
                                            <h4 class="text-xs font-extrabold text-slate-900">{{ $rk->name }}</h4>
                                            <span class="text-[10px] font-mono text-slate-400">#{{ $rk->order }}</span>
                                        </div>
                                        @if($rk->description)
                                            <p class="text-[11px] text-slate-500 leading-relaxed">{{ $rk->description }}</p>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-1 shrink-0">
                                        <button type="button" onclick="openEditRankModal({{ json_encode($rk) }})" class="p-1.5 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200/80" title="Edit Tingkatan">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>
                                        <form action="{{ route('admin.ranks.destroy', $rk->id) }}" method="POST" onsubmit="return confirm('Hapus tingkatan {{ $rk->name }}?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg bg-red-50 text-red-700 hover:bg-red-100 border border-red-200/80" title="Hapus Tingkatan">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Desktop View: Ranks Table -->
                        <div class="hidden sm:block overflow-x-auto min-w-0 border border-slate-200/80 rounded-xl">
                            <table class="w-full text-left text-xs text-slate-600">
                                <thead class="bg-slate-50 text-slate-700 text-[10px] uppercase font-bold tracking-wider border-b border-slate-200/80">
                                    <tr>
                                        <th class="py-2.5 px-4 w-16 text-center">Urutan</th>
                                        <th class="py-2.5 px-4 w-28">Kategori</th>
                                        <th class="py-2.5 px-4 w-44">Nama Tingkatan</th>
                                        <th class="py-2.5 px-4">Deskripsi / Silabus Ujian</th>
                                        <th class="py-2.5 px-4 text-center w-28">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 font-medium">
                                    @foreach($belt->ranks as $rk)
                                        <tr class="hover:bg-slate-50/80 transition-colors">
                                            <td class="py-3 px-4 text-center font-mono font-bold text-slate-500">
                                                {{ $rk->order }}
                                            </td>
                                            <td class="py-3 px-4">
                                                <span class="px-2.5 py-0.5 text-[10px] font-black rounded-full border {{ $rk->category === 'Dan' ? 'bg-purple-50 text-purple-800 border-purple-200' : 'bg-cyan-50 text-cyan-800 border-cyan-200' }}">
                                                    {{ $rk->category }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4 font-bold text-slate-900">
                                                {{ $rk->name }}
                                            </td>
                                            <td class="py-3 px-4 text-slate-500 leading-relaxed">
                                                {{ $rk->description ?? '-' }}
                                            </td>
                                            <td class="py-3 px-4 text-center">
                                                <div class="flex items-center justify-center gap-1.5">
                                                    <button type="button" onclick="openEditRankModal({{ json_encode($rk) }})" class="p-1.5 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200/80 transition-colors" title="Edit Tingkatan">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                    </button>
                                                    <form action="{{ route('admin.ranks.destroy', $rk->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tingkatan {{ $rk->name }}?');" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="p-1.5 rounded-lg bg-red-50 text-red-700 hover:bg-red-100 border border-red-200/80 transition-colors" title="Hapus Tingkatan">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="py-6 px-4 rounded-xl bg-slate-50 border border-dashed border-slate-200 text-center space-y-2">
                            <p class="text-xs text-slate-400 font-medium">Belum ada data tingkatan (Kyu/Dan) yang didaftarkan pada sabuk ini.</p>
                            <button type="button" onclick="openCreateRankForBelt({{ $belt->id }}, '{{ addslashes($belt->name) }}')" class="px-3.5 py-1.5 bg-white hover:bg-slate-50 text-brand-primary border border-slate-200 rounded-xl text-xs font-bold transition inline-flex items-center gap-1 shadow-2xs">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                <span>Tambah Tingkatan Pertama</span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl p-8 sm:p-12 text-center text-slate-400 border border-slate-200/80 shadow-sm space-y-3">
                <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center text-2xl mx-auto border border-slate-200/60">
                    🥋
                </div>
                <div class="max-w-md mx-auto space-y-1">
                    <h3 class="text-base font-extrabold text-slate-900">Belum Ada Data Sabuk</h3>
                    <p class="text-xs text-slate-500 font-medium">
                        Silakan klik tombol <span class="font-bold text-brand-primary">"+ Sabuk Baru"</span> untuk membuat data master sabuk pertama.
                    </p>
                </div>
            </div>
        @endforelse
    </div>
</div>

<!-- ================= MODAL: TAMBAH MASTER SABUK ================= -->
<div id="modal-create-belt" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl space-y-5 border border-slate-100 animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                <span>🥋</span> Tambah Master Sabuk Baru
            </h3>
            <button onclick="closeModal('modal-create-belt')" class="p-1 text-slate-400 hover:text-slate-600 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form action="{{ route('admin.belts.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="space-y-1.5">
                <label for="create-belt-name" class="block text-xs font-bold text-slate-700">Nama Sabuk</label>
                <input type="text" id="create-belt-name" name="name" required placeholder="Contoh: Sabuk Ungu / Sabuk Oranye" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-primary focus:border-brand-primary outline-none transition font-medium">
            </div>

            <div class="space-y-1.5">
                <label for="create-belt-color" class="block text-xs font-bold text-slate-700">Kode Warna Sabuk (Hex)</label>
                <div class="flex items-center gap-2">
                    <input type="color" id="create-belt-picker" value="#3B82F6" onchange="document.getElementById('create-belt-color').value = this.value" class="w-10 h-9 p-0.5 rounded-xl border border-slate-300 cursor-pointer bg-white">
                    <input type="text" id="create-belt-color" name="color_code" value="#3B82F6" onchange="document.getElementById('create-belt-picker').value = this.value" placeholder="#3B82F6" class="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-primary focus:border-brand-primary outline-none transition font-mono font-bold uppercase">
                </div>
            </div>

            <div class="space-y-1.5">
                <label for="create-belt-desc" class="block text-xs font-bold text-slate-700">Keterangan / Filosofi Sabuk (Opsional)</label>
                <textarea id="create-belt-desc" name="description" rows="2" placeholder="Jelaskan makna filosofis atau ketentuan sabuk ini..." class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-primary focus:border-brand-primary outline-none transition font-medium resize-none"></textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button" onclick="closeModal('modal-create-belt')" class="px-4 py-2.5 rounded-xl border border-slate-300 text-slate-700 font-bold text-xs hover:bg-slate-50 transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow-md transition">
                    Simpan Sabuk
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ================= MODAL: TAMBAH TINGKATAN ================= -->
<div id="modal-create-rank" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl space-y-5 border border-slate-100 animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                <span>🏆</span> Tambah Tingkatan Baru
            </h3>
            <button onclick="closeModal('modal-create-rank')" class="p-1 text-slate-400 hover:text-slate-600 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form action="{{ route('admin.ranks.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="space-y-1.5">
                <label for="rank-belt-select" class="block text-xs font-bold text-slate-700">Pilih Master Sabuk</label>
                <select id="rank-belt-select" name="belt_id" required class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-primary focus:border-brand-primary outline-none transition font-medium cursor-pointer">
                    <option value="" disabled selected>-- Pilih Sabuk --</option>
                    @foreach($belts as $b)
                        <option value="{{ $b->id }}">{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1.5">
                    <label for="rank-category" class="block text-xs font-bold text-slate-700">Kategori</label>
                    <select id="rank-category" name="category" required class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-primary focus:border-brand-primary outline-none transition font-medium cursor-pointer">
                        <option value="Kyu">Kyu (Murid)</option>
                        <option value="Dan">Dan (Yudansha)</option>
                    </select>
                </div>
                <div class="space-y-1.5">
                    <label for="rank-order" class="block text-xs font-bold text-slate-700">Urutan Hierarki</label>
                    <input type="number" id="rank-order" name="order" required min="1" value="{{ $totalRanks + 1 }}" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-primary focus:border-brand-primary outline-none transition font-mono font-bold">
                </div>
            </div>

            <div class="space-y-1.5">
                <label for="rank-name" class="block text-xs font-bold text-slate-700">Nama Tingkatan</label>
                <input type="text" id="rank-name" name="name" required placeholder="Contoh: Kyu 10 / Dan 1 (Shodan)" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-primary focus:border-brand-primary outline-none transition font-medium">
            </div>

            <div class="space-y-1.5">
                <label for="rank-desc" class="block text-xs font-bold text-slate-700">Deskripsi / Silabus Ujian (Opsional)</label>
                <textarea id="rank-desc" name="description" rows="2" placeholder="Materi Kata, Kihon, atau syarat kelulusan..." class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-primary focus:border-brand-primary outline-none transition font-medium resize-none"></textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button" onclick="closeModal('modal-create-rank')" class="px-4 py-2.5 rounded-xl border border-slate-300 text-slate-700 font-bold text-xs hover:bg-slate-50 transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-brand-primary hover:bg-brand-primary/90 text-white font-bold text-xs shadow-md transition">
                    Simpan Tingkatan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ================= MODAL: EDIT TINGKATAN ================= -->
<div id="modal-edit-rank" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl space-y-5 border border-slate-100 animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                <span>✏️</span> Edit Tingkatan
            </h3>
            <button onclick="closeModal('modal-edit-rank')" class="p-1 text-slate-400 hover:text-slate-600 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form id="form-edit-rank" action="" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div class="space-y-1.5">
                <label for="edit-rank-belt-select" class="block text-xs font-bold text-slate-700">Pilih Master Sabuk</label>
                <select id="edit-rank-belt-select" name="belt_id" required class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-primary focus:border-brand-primary outline-none transition font-medium cursor-pointer">
                    @foreach($belts as $b)
                        <option value="{{ $b->id }}">{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1.5">
                    <label for="edit-rank-category" class="block text-xs font-bold text-slate-700">Kategori</label>
                    <select id="edit-rank-category" name="category" required class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-primary focus:border-brand-primary outline-none transition font-medium cursor-pointer">
                        <option value="Kyu">Kyu (Murid)</option>
                        <option value="Dan">Dan (Yudansha)</option>
                    </select>
                </div>
                <div class="space-y-1.5">
                    <label for="edit-rank-order" class="block text-xs font-bold text-slate-700">Urutan Hierarki</label>
                    <input type="number" id="edit-rank-order" name="order" required min="1" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-primary focus:border-brand-primary outline-none transition font-mono font-bold">
                </div>
            </div>

            <div class="space-y-1.5">
                <label for="edit-rank-name" class="block text-xs font-bold text-slate-700">Nama Tingkatan</label>
                <input type="text" id="edit-rank-name" name="name" required class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-primary focus:border-brand-primary outline-none transition font-medium">
            </div>

            <div class="space-y-1.5">
                <label for="edit-rank-desc" class="block text-xs font-bold text-slate-700">Deskripsi / Silabus Ujian (Opsional)</label>
                <textarea id="edit-rank-desc" name="description" rows="2" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-primary focus:border-brand-primary outline-none transition font-medium resize-none"></textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button" onclick="closeModal('modal-edit-rank')" class="px-4 py-2.5 rounded-xl border border-slate-300 text-slate-700 font-bold text-xs hover:bg-slate-50 transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs shadow-md transition">
                    Perbarui Tingkatan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) modal.classList.remove('hidden');
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) modal.classList.add('hidden');
    }

    function openCreateRankForBelt(beltId, beltName) {
        const beltSelect = document.getElementById('rank-belt-select');
        if (beltSelect) {
            beltSelect.value = beltId;
        }
        openModal('modal-create-rank');
    }

    function openEditRankModal(rank) {
        const form = document.getElementById('form-edit-rank');
        if (form) {
            form.action = `/admin/ranks/${rank.id}`;
        }
        document.getElementById('edit-rank-belt-select').value = rank.belt_id;
        document.getElementById('edit-rank-category').value = rank.category;
        document.getElementById('edit-rank-order').value = rank.order;
        document.getElementById('edit-rank-name').value = rank.name;
        document.getElementById('edit-rank-desc').value = rank.description || '';

        openModal('modal-edit-rank');
    }
</script>
@endsection
