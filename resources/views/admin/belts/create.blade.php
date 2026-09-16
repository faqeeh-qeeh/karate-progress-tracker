@extends('layouts.admin')

@section('title', 'Tambah Master Sabuk Baru')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Back Header -->
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Tambah Master Sabuk Baru</h1>
            <p class="text-xs text-slate-500 mt-1 font-medium">Buat data master sabuk baru untuk pengelompokan tingkatan</p>
        </div>
        <a href="{{ route('admin.belts.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold rounded-xl transition whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Create Belt Form Card -->
    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-sm">
        <form action="{{ route('admin.belts.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Name Field -->
            <div>
                <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Sabuk</label>
                <div class="relative rounded-xl">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    </div>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                        placeholder="Contoh: Sabuk Oranye / Sabuk Ungu"
                        class="w-full pl-10 pr-4 py-3 rounded-xl border @error('name') border-red-500 bg-red-50/30 text-red-900 @else border-slate-200 bg-slate-50/50 text-slate-900 @enderror text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white transition placeholder:text-slate-400">
                </div>
                @error('name')
                    <p class="text-xs text-red-600 mt-1.5 font-medium flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Color Picker & Hex Code -->
            <div>
                <label for="color_code" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kode Warna Sabuk</label>
                <div class="flex items-center gap-3">
                    <input type="color" id="color-picker" value="{{ old('color_code', '#3B82F6') }}" onchange="document.getElementById('color_code').value = this.value" class="w-12 h-11 p-1 rounded-xl border border-slate-300 cursor-pointer bg-white">
                    <div class="flex-1 relative rounded-xl">
                        <input type="text" name="color_code" id="color_code" value="{{ old('color_code', '#3B82F6') }}" onchange="document.getElementById('color-picker').value = this.value"
                            placeholder="#3B82F6"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white transition font-mono font-bold uppercase">
                    </div>
                </div>
            </div>

            <!-- Description Field -->
            <div>
                <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Keterangan / Filosofi Sabuk</label>
                <div class="relative rounded-xl">
                    <textarea name="description" id="description" rows="3"
                        placeholder="Deskripsikan filosofi atau tahapan latihan dari sabuk ini..."
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white transition placeholder:text-slate-400 resize-none">{{ old('description') }}</textarea>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.belts.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm shadow-md transition-all active:scale-[0.99]">
                    Simpan Master Sabuk
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
