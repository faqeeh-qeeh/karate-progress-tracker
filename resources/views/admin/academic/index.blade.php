@extends('layouts.admin')

@section('title', 'Master Jurusan, Prodi & Kelas')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-slate-900 p-5 sm:p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-brand-primary"></span>
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Master Data Akademik Polindra</h1>
            </div>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola data Jurusan (*Department*), Program Studi (*Study Program*), dan Kelas (*Academic Class*)</p>
        </div>
        <div class="flex items-center gap-3">
            <button type="button" onclick="openAddDepartmentModal()"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-brand-primary to-brand-secondary hover:from-brand-primary/90 hover:to-brand-secondary/90 text-white font-bold text-xs sm:text-sm shadow-md hover:shadow-lg transition cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Tambah Jurusan Baru</span>
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 dark:text-slate-400 uppercase tracking-wider">Total Jurusan</p>
                <h3 class="text-2xl font-extrabold text-slate-800 dark:text-white mt-1">{{ $totalDepartments }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-950/40 text-brand-primary dark:text-blue-400 flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 dark:text-slate-400 uppercase tracking-wider">Program Studi</p>
                <h3 class="text-2xl font-extrabold text-emerald-600 dark:text-emerald-400 mt-1">{{ $totalStudyPrograms }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 dark:text-slate-400 uppercase tracking-wider">Total Kelas</p>
                <h3 class="text-2xl font-extrabold text-amber-600 dark:text-amber-400 mt-1">{{ $totalClasses }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
        </div>
    </div>

    <!-- Search Box -->
    <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-4">
        <form action="{{ route('admin.departments.index') }}" method="GET" class="w-full sm:max-w-md relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama jurusan atau deskripsi..."
                class="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary transition placeholder:text-slate-400 dark:placeholder:text-slate-500">
        </form>
        @if(request('search'))
            <a href="{{ route('admin.departments.index') }}" class="text-xs text-red-600 dark:text-red-400 font-bold hover:underline">
                Reset Pencarian
            </a>
        @endif
    </div>

    <!-- Departments List & Hierarchical Tree -->
    <div class="space-y-6">
        @forelse($departments as $dept)
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs overflow-hidden">
                <!-- Department Header Bar -->
                <div class="px-6 py-4 bg-slate-900 dark:bg-slate-950 text-white flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-800">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-10 h-10 rounded-xl bg-slate-800 dark:bg-slate-900 border border-slate-700 flex items-center justify-center font-bold text-white shrink-0 shadow-xs">
                            <svg class="w-5 h-5 text-brand-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <div class="min-w-0">
                            <div class="flex items-center gap-2.5 flex-wrap">
                                <h2 class="text-base font-extrabold text-white truncate">{{ $dept->name }}</h2>
                                @if($dept->is_active)
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">Aktif</span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-700 text-slate-300 border border-slate-600">Nonaktif</span>
                                @endif
                                <span class="text-[11px] text-slate-400 font-medium">({{ $dept->study_programs_count }} Program Studi)</span>
                            </div>
                            @if($dept->description)
                                <p class="text-xs text-slate-400 mt-0.5 line-clamp-1">{{ $dept->description }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Department Actions -->
                    <div class="flex items-center gap-2 shrink-0">
                        <button type="button" onclick="openAddProdiModal({{ $dept->id }}, '{{ addslashes($dept->name) }}')"
                            class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs flex items-center gap-1.5 transition shadow-xs cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <span>Tambah Prodi</span>
                        </button>

                        <button type="button" onclick="openEditDepartmentModal({{ $dept->id }}, '{{ addslashes($dept->name) }}', '{{ addslashes($dept->description ?? '') }}', {{ $dept->is_active ? 'true' : 'false' }})"
                            class="p-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white transition cursor-pointer" title="Edit Jurusan">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </button>

                        <form action="{{ route('admin.departments.destroy', $dept) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jurusan &quot;{{ $dept->name }}&quot; beserta seluruh prodi dan kelas di dalamnya?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 rounded-xl bg-slate-800 hover:bg-red-900/80 text-slate-300 hover:text-red-300 transition cursor-pointer" title="Hapus Jurusan">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Study Programs under this Department -->
                <div class="p-5 sm:p-6 divide-y divide-slate-100 dark:divide-slate-800 space-y-4">
                    @forelse($dept->studyPrograms as $prodi)
                        <div class="pt-4 first:pt-0 space-y-3">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-slate-50 dark:bg-slate-800/60 p-3.5 rounded-xl border border-slate-200/80 dark:border-slate-700">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 flex items-center justify-center font-bold text-xs shrink-0">
                                        Prodi
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <h3 class="text-sm font-bold text-slate-900 dark:text-white">{{ $prodi->name }}</h3>
                                            @if($prodi->is_active)
                                                <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-100 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300">Aktif</span>
                                            @else
                                                <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300">Nonaktif</span>
                                            @endif
                                        </div>
                                        @if($prodi->description)
                                            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">{{ $prodi->description }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 self-end sm:self-center">
                                    <button type="button" onclick="openAddClassModal({{ $prodi->id }}, '{{ addslashes($prodi->name) }}')"
                                        class="px-2.5 py-1 rounded-lg bg-amber-500 hover:bg-amber-600 text-white font-bold text-[11px] flex items-center gap-1 transition shadow-xs cursor-pointer">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        <span>Tambah Kelas</span>
                                    </button>

                                    <button type="button" onclick="openEditProdiModal({{ $prodi->id }}, {{ $dept->id }}, '{{ addslashes($prodi->name) }}', '{{ addslashes($prodi->description ?? '') }}', {{ $prodi->is_active ? 'true' : 'false' }})"
                                        class="p-1.5 rounded-lg text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white hover:bg-slate-200/60 dark:hover:bg-slate-700 transition cursor-pointer" title="Edit Prodi">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>

                                    <form action="{{ route('admin.study-programs.destroy', $prodi) }}" method="POST" onsubmit="return confirm('Hapus prodi &quot;{{ $prodi->name }}&quot; beserta seluruh kelas di dalamnya?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-slate-400 dark:text-slate-500 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/40 transition cursor-pointer" title="Hapus Prodi">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Classes Badge List -->
                            <div class="pl-2 sm:pl-4">
                                <div class="flex items-center gap-1.5 mb-2 text-xs font-bold text-slate-600 dark:text-slate-300">
                                    <svg class="w-3.5 h-3.5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                    <span>Daftar Kelas ({{ $prodi->academicClasses->count() }} Kelas):</span>
                                </div>

                                <div class="flex flex-wrap gap-2">
                                    @forelse($prodi->academicClasses as $cls)
                                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-700 dark:text-slate-300 font-bold hover:border-brand-primary transition group shadow-2xs">
                                            <span>{{ $cls->name }}</span>
                                            <button type="button" onclick="openEditClassModal({{ $cls->id }}, {{ $prodi->id }}, '{{ addslashes($cls->name) }}')"
                                                class="text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 transition" title="Edit Kelas">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                            </button>
                                            <form action="{{ route('admin.academic-classes.destroy', $cls) }}" method="POST" onsubmit="return confirm('Hapus kelas &quot;{{ $cls->name }}&quot;?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-slate-400 hover:text-red-600 dark:hover:text-red-400 transition" title="Hapus Kelas">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    @empty
                                        <span class="text-xs text-slate-400 dark:text-slate-500 italic">Belum ada kelas yang ditambahkan. Silakan klik "Tambah Kelas".</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-slate-400 dark:text-slate-500 text-xs">
                            <p>Belum ada program studi di jurusan ini.</p>
                            <button type="button" onclick="openAddProdiModal({{ $dept->id }}, '{{ addslashes($dept->name) }}')" class="mt-2 text-brand-primary dark:text-blue-400 font-bold hover:underline">
                                + Tambah Program Studi Sekarang
                            </button>
                        </div>
                    @endforelse
                </div>
            </div>
        @empty
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 p-12 text-center text-slate-500 dark:text-slate-400">
                <svg class="w-12 h-12 mx-auto text-slate-300 dark:text-slate-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                <h3 class="text-sm font-bold text-slate-800 dark:text-white">Tidak ada data jurusan</h3>
                <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Belum ada data jurusan yang terdaftar pada sistem.</p>
                <button type="button" onclick="openAddDepartmentModal()" class="mt-4 px-4 py-2 bg-brand-primary hover:bg-brand-primary/90 text-white text-xs font-bold rounded-xl">
                    Tambah Jurusan Pertama
                </button>
            </div>
        @endforelse
    </div>
</div>

<!-- ================= MODALS ================= -->

<!-- 1. Modal Tambah Jurusan -->
<div id="modal-add-dept" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-xs">
    <div class="bg-white dark:bg-slate-900 rounded-2xl max-w-md w-full p-6 space-y-4 shadow-2xl border border-slate-100 dark:border-slate-800">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
            <h3 class="text-base font-bold text-slate-800 dark:text-white">Tambah Jurusan Baru</h3>
            <button type="button" onclick="closeModal('modal-add-dept')" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form action="{{ route('admin.departments.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Nama Jurusan <span class="text-red-500">*</span></label>
                <input type="text" name="name" required placeholder="Contoh: Teknik Informatika" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-brand-primary focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Deskripsi Jurusan (Opsional)</label>
                <textarea name="description" rows="2" placeholder="Deskripsi singkat jurusan..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-brand-primary focus:outline-none resize-none"></textarea>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="dept_active" value="1" checked class="w-4 h-4 text-brand-primary rounded border-slate-300 focus:ring-brand-primary">
                <label for="dept_active" class="text-xs text-slate-700 dark:text-slate-300 font-medium">Status Jurusan Aktif</label>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-800">
                <button type="button" onclick="closeModal('modal-add-dept')" class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800">Batal</button>
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-brand-primary hover:bg-brand-primary/90 text-xs font-bold text-white">Simpan Jurusan</button>
            </div>
        </form>
    </div>
</div>

<!-- 2. Modal Edit Jurusan -->
<div id="modal-edit-dept" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-xs">
    <div class="bg-white dark:bg-slate-900 rounded-2xl max-w-md w-full p-6 space-y-4 shadow-2xl border border-slate-100 dark:border-slate-800">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
            <h3 class="text-base font-bold text-slate-800 dark:text-white">Edit Jurusan</h3>
            <button type="button" onclick="closeModal('modal-edit-dept')" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form id="form-edit-dept" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Nama Jurusan <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="edit-dept-name" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-brand-primary focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Deskripsi Jurusan (Opsional)</label>
                <textarea name="description" id="edit-dept-desc" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-brand-primary focus:outline-none resize-none"></textarea>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="edit-dept-active" value="1" class="w-4 h-4 text-brand-primary rounded border-slate-300 focus:ring-brand-primary">
                <label for="edit-dept-active" class="text-xs text-slate-700 dark:text-slate-300 font-medium">Status Jurusan Aktif</label>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-800">
                <button type="button" onclick="closeModal('modal-edit-dept')" class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800">Batal</button>
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-brand-primary hover:bg-brand-primary/90 text-xs font-bold text-white">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- 3. Modal Tambah Prodi -->
<div id="modal-add-prodi" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-xs">
    <div class="bg-white dark:bg-slate-900 rounded-2xl max-w-md w-full p-6 space-y-4 shadow-2xl border border-slate-100 dark:border-slate-800">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
            <div>
                <h3 class="text-base font-bold text-slate-800 dark:text-white">Tambah Program Studi</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400" id="add-prodi-dept-label">Jurusan: -</p>
            </div>
            <button type="button" onclick="closeModal('modal-add-prodi')" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form action="{{ route('admin.study-programs.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="department_id" id="add-prodi-dept-id">
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Nama Program Studi <span class="text-red-500">*</span></label>
                <input type="text" name="name" required placeholder="Contoh: D4 Rekayasa Perangkat Lunak" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Deskripsi Prodi (Opsional)</label>
                <textarea name="description" rows="2" placeholder="Deskripsi singkat prodi..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none resize-none"></textarea>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="prodi_active" value="1" checked class="w-4 h-4 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500">
                <label for="prodi_active" class="text-xs text-slate-700 dark:text-slate-300 font-medium">Status Prodi Aktif</label>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-800">
                <button type="button" onclick="closeModal('modal-add-prodi')" class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800">Batal</button>
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-xs font-bold text-white">Simpan Prodi</button>
            </div>
        </form>
    </div>
</div>

<!-- 4. Modal Edit Prodi -->
<div id="modal-edit-prodi" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-xs">
    <div class="bg-white dark:bg-slate-900 rounded-2xl max-w-md w-full p-6 space-y-4 shadow-2xl border border-slate-100 dark:border-slate-800">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
            <h3 class="text-base font-bold text-slate-800 dark:text-white">Edit Program Studi</h3>
            <button type="button" onclick="closeModal('modal-edit-prodi')" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form id="form-edit-prodi" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Jurusan Induk <span class="text-red-500">*</span></label>
                <select name="department_id" id="edit-prodi-dept-id" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    @foreach($departments as $d)
                        <option value="{{ $d->id }}">{{ $d->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Nama Program Studi <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="edit-prodi-name" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Deskripsi Prodi (Opsional)</label>
                <textarea name="description" id="edit-prodi-desc" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none resize-none"></textarea>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="edit-prodi-active" value="1" class="w-4 h-4 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500">
                <label for="edit-prodi-active" class="text-xs text-slate-700 dark:text-slate-300 font-medium">Status Prodi Aktif</label>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-800">
                <button type="button" onclick="closeModal('modal-edit-prodi')" class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800">Batal</button>
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-xs font-bold text-white">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- 5. Modal Tambah Kelas -->
<div id="modal-add-class" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-xs">
    <div class="bg-white dark:bg-slate-900 rounded-2xl max-w-sm w-full p-6 space-y-4 shadow-2xl border border-slate-100 dark:border-slate-800">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
            <div>
                <h3 class="text-base font-bold text-slate-800 dark:text-white">Tambah Kelas Baru</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400" id="add-class-prodi-label">Prodi: -</p>
            </div>
            <button type="button" onclick="closeModal('modal-add-class')" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form action="{{ route('admin.academic-classes.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="study_program_id" id="add-class-prodi-id">
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Nama Kelas <span class="text-red-500">*</span></label>
                <input type="text" name="name" required placeholder="Contoh: RPL 1A" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-800">
                <button type="button" onclick="closeModal('modal-add-class')" class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800">Batal</button>
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-xs font-bold text-white">Simpan Kelas</button>
            </div>
        </form>
    </div>
</div>

<!-- 6. Modal Edit Kelas -->
<div id="modal-edit-class" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-xs">
    <div class="bg-white dark:bg-slate-900 rounded-2xl max-w-sm w-full p-6 space-y-4 shadow-2xl border border-slate-100 dark:border-slate-800">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
            <h3 class="text-base font-bold text-slate-800 dark:text-white">Edit Nama Kelas</h3>
            <button type="button" onclick="closeModal('modal-edit-class')" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form id="form-edit-class" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <input type="hidden" name="study_program_id" id="edit-class-prodi-id">
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Nama Kelas <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="edit-class-name" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-800">
                <button type="button" onclick="closeModal('modal-edit-class')" class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800">Batal</button>
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-xs font-bold text-white">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function closeModal(id) {
        document.getElementById(id)?.classList.add('hidden');
    }

    function openAddDepartmentModal() {
        document.getElementById('modal-add-dept')?.classList.remove('hidden');
    }

    function openEditDepartmentModal(id, name, desc, isActive) {
        const modal = document.getElementById('modal-edit-dept');
        const form = document.getElementById('form-edit-dept');
        form.action = `/admin/departments/${id}`;
        document.getElementById('edit-dept-name').value = name;
        document.getElementById('edit-dept-desc').value = desc;
        document.getElementById('edit-dept-active').checked = isActive;
        modal.classList.remove('hidden');
    }

    function openAddProdiModal(deptId, deptName) {
        const modal = document.getElementById('modal-add-prodi');
        document.getElementById('add-prodi-dept-id').value = deptId;
        document.getElementById('add-prodi-dept-label').innerText = `Jurusan: ${deptName}`;
        modal.classList.remove('hidden');
    }

    function openEditProdiModal(id, deptId, name, desc, isActive) {
        const modal = document.getElementById('modal-edit-prodi');
        const form = document.getElementById('form-edit-prodi');
        form.action = `/admin/study-programs/${id}`;
        document.getElementById('edit-prodi-dept-id').value = deptId;
        document.getElementById('edit-prodi-name').value = name;
        document.getElementById('edit-prodi-desc').value = desc;
        document.getElementById('edit-prodi-active').checked = isActive;
        modal.classList.remove('hidden');
    }

    function openAddClassModal(prodiId, prodiName) {
        const modal = document.getElementById('modal-add-class');
        document.getElementById('add-class-prodi-id').value = prodiId;
        document.getElementById('add-class-prodi-label').innerText = `Prodi: ${prodiName}`;
        modal.classList.remove('hidden');
    }

    function openEditClassModal(id, prodiId, name) {
        const modal = document.getElementById('modal-edit-class');
        const form = document.getElementById('form-edit-class');
        form.action = `/admin/academic-classes/${id}`;
        document.getElementById('edit-class-prodi-id').value = prodiId;
        document.getElementById('edit-class-name').value = name;
        modal.classList.remove('hidden');
    }
</script>
@endsection
