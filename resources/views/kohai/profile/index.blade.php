@extends('layouts.kohai')

@section('title', 'Biodata Kohai')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-slate-900 p-5 sm:p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs transition-colors">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-brand-secondary text-slate-950 flex items-center justify-center font-black text-lg shadow-md shrink-0">
                {{ $user->initials }}
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Biodata Kohai / Anggota</h1>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-0.5">Kelola data akademik, asal keanggotaan, sabuk, dan data fisik Anda</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            @if($profile->rank)
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-bold bg-slate-900 dark:bg-slate-800 text-white border border-slate-700/80 shadow-xs">
                    <span class="w-2.5 h-2.5 rounded-full" style="background-color: {{ $profile->rank->belt->color_code ?? '#eab308' }}"></span>
                    {{ $profile->rank->belt->name ?? 'Sabuk' }} - {{ $profile->rank->name }}
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800/60">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    Tingkat Sabuk Wajib Dilengkapi
                </span>
            @endif
        </div>
    </div>

    <!-- Main Biodata Form -->
    <form action="{{ route('kohai.profile.update') }}" method="POST" class="space-y-6" id="kohaiProfileForm">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left & Center Column: Data Pribadi & Keanggotaan & Fisik -->
            <div class="lg:col-span-2 space-y-6">

                <!-- 1. Kategori Keanggotaan (Ditetapkan oleh Admin) -->
                @if($profile->type === 'polindra')
                    <div class="p-5 rounded-2xl bg-gradient-to-r from-blue-50 to-indigo-50/50 dark:from-blue-950/30 dark:to-indigo-950/20 border border-blue-200/90 dark:border-blue-800/60 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-xs transition-colors">
                        <div class="flex items-center gap-3.5">
                            <div class="w-11 h-11 rounded-xl bg-brand-primary text-white flex items-center justify-center font-bold shrink-0 shadow-xs">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </div>
                            <div>
                                <span class="text-[10px] font-black uppercase tracking-widest text-brand-primary dark:text-sky-400">Kategori Keanggotaan</span>
                                <h2 class="text-sm sm:text-base font-extrabold text-slate-900 dark:text-white">Mahasiswa / Sivitas Polindra</h2>
                                <p class="text-[11px] text-slate-600 dark:text-slate-300 mt-0.5">Status anggota resmi Politeknik Negeri Indramayu (Ditetapkan oleh Admin Dojo)</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-blue-600 text-white shadow-xs self-start sm:self-auto shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Internal Polindra
                        </span>
                    </div>

                    <!-- 2. Field Khusus Polindra -->
                    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs p-6 space-y-4 transition-colors">
                        <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100 dark:border-slate-800">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-slate-800 text-brand-primary dark:text-sky-400 flex items-center justify-center font-bold text-xs">
                                1
                            </div>
                            <div>
                                <h2 class="text-sm font-bold text-slate-800 dark:text-white">Data Akademik Polindra</h2>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400">Lengkapi data Jurusan, Program Studi, Kelas, NIM, dan Angkatan</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- NIM -->
                            <div>
                                <label for="nim" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                    NIM (Nomor Induk Mahasiswa) <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nim" id="nim" value="{{ old('nim', $profile->nim) }}" required
                                    placeholder="Contoh: 2205001"
                                    class="w-full px-4 py-2.5 rounded-xl border @error('nim') border-red-500 bg-red-50/30 dark:bg-red-950/30 @else border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/60 @enderror text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition">
                                @error('nim')
                                    <p class="text-xs text-red-600 dark:text-red-400 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tahun Masuk / Angkatan -->
                            <div>
                                <label for="enrollment_year" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                    Tahun Masuk / Angkatan <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="enrollment_year" id="enrollment_year" min="2000" max="{{ date('Y') + 1 }}" required
                                    value="{{ old('enrollment_year', $profile->enrollment_year ?? date('Y')) }}"
                                    placeholder="Contoh: 2022"
                                    class="w-full px-4 py-2.5 rounded-xl border @error('enrollment_year') border-red-500 bg-red-50/30 dark:bg-red-950/30 @else border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/60 @enderror text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition">
                                @error('enrollment_year')
                                    <p class="text-xs text-red-600 dark:text-red-400 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Jurusan & Program Studi -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Jurusan -->
                            <div>
                                <label for="department_id" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                    Jurusan
                                </label>
                                <select id="department_id" onchange="filterStudyPrograms(true)"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/60 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition cursor-pointer">
                                    <option value="">-- Pilih Jurusan --</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->id }}" {{ (old('study_program_id') ? optional($departments->flatMap->studyPrograms->firstWhere('id', old('study_program_id')))->department_id : optional($profile->studyProgram)->department_id) == $dept->id ? 'selected' : '' }}>
                                            {{ $dept->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Program Studi -->
                            <div>
                                <label for="study_program_id" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                    Program Studi <span class="text-red-500">*</span>
                                </label>
                                <select name="study_program_id" id="study_program_id" onchange="filterAcademicClasses(true)" required
                                    class="w-full px-4 py-2.5 rounded-xl border @error('study_program_id') border-red-500 bg-red-50/30 dark:bg-red-950/30 @else border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/60 @enderror text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition cursor-pointer disabled:bg-slate-100/80 dark:disabled:bg-slate-800/40 disabled:cursor-not-allowed disabled:text-slate-400 dark:disabled:text-slate-500">
                                    <option value="" id="prodi-placeholder">-- Pilih Program Studi --</option>
                                    @foreach($departments as $dept)
                                        @foreach($dept->studyPrograms as $prog)
                                            <option value="{{ $prog->id }}" data-department-id="{{ $dept->id }}" {{ old('study_program_id', $profile->study_program_id) == $prog->id ? 'selected' : '' }}>
                                                {{ $prog->name }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                </select>
                                @error('study_program_id')
                                    <p class="text-xs text-red-600 dark:text-red-400 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Kelas & Asal SMA/SMK -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Kelas -->
                            <div>
                                <label for="academic_class_id" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                    Kelas <span class="text-red-500">*</span>
                                </label>
                                <select name="academic_class_id" id="academic_class_id" required
                                    class="w-full px-4 py-2.5 rounded-xl border @error('academic_class_id') border-red-500 bg-red-50/30 dark:bg-red-950/30 @else border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/60 @enderror text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition cursor-pointer disabled:bg-slate-100/80 dark:disabled:bg-slate-800/40 disabled:cursor-not-allowed disabled:text-slate-400 dark:disabled:text-slate-500">
                                    <option value="" id="kelas-placeholder">-- Pilih Kelas --</option>
                                    @foreach($departments as $dept)
                                        @foreach($dept->studyPrograms as $prog)
                                            @foreach($prog->academicClasses as $cls)
                                                <option value="{{ $cls->id }}" data-study-program-id="{{ $prog->id }}" {{ old('academic_class_id', $profile->academic_class_id) == $cls->id ? 'selected' : '' }}>
                                                    {{ $cls->name }}
                                                </option>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                </select>
                                @error('academic_class_id')
                                    <p class="text-xs text-red-600 dark:text-red-400 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Asal SMA/SMK -->
                            <div>
                                <label for="high_school" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                    Asal SMA / SMK / Sederajat <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="high_school" id="high_school" value="{{ old('high_school', $profile->high_school) }}" required
                                    placeholder="Contoh: SMAN 1 Indramayu"
                                    class="w-full px-4 py-2.5 rounded-xl border @error('high_school') border-red-500 bg-red-50/30 dark:bg-red-950/30 @else border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/60 @enderror text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition">
                                @error('high_school')
                                    <p class="text-xs text-red-600 dark:text-red-400 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                @else
                    <div class="p-5 rounded-2xl bg-gradient-to-r from-amber-50 to-orange-50/50 dark:from-amber-950/30 dark:to-orange-950/20 border border-amber-200/90 dark:border-amber-800/60 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-xs transition-colors">
                        <div class="flex items-center gap-3.5">
                            <div class="w-11 h-11 rounded-xl bg-amber-600 text-white flex items-center justify-center font-bold shrink-0 shadow-xs">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <span class="text-[10px] font-black uppercase tracking-widest text-amber-700 dark:text-amber-400">Kategori Keanggotaan</span>
                                <h2 class="text-sm sm:text-base font-extrabold text-slate-900 dark:text-white">Luar Polindra / Instansi Lain</h2>
                                <p class="text-[11px] text-slate-600 dark:text-slate-300 mt-0.5">Anggota dari sekolah luar atau instansi umum (Ditetapkan oleh Admin Dojo)</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-amber-600 text-white shadow-xs self-start sm:self-auto shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Luar Polindra
                        </span>
                    </div>

                    <!-- 2. Field Khusus Luar Polindra -->
                    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs p-6 space-y-4 transition-colors">
                        <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100 dark:border-slate-800">
                            <div class="w-8 h-8 rounded-lg bg-amber-50 dark:bg-slate-800 text-amber-600 dark:text-amber-400 flex items-center justify-center font-bold text-xs">
                                1
                            </div>
                            <div>
                                <h2 class="text-sm font-bold text-slate-800 dark:text-white">Data Asal Sekolah / Instansi</h2>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400">Khusus untuk anggota Kohai dari luar kampus Polindra</p>
                            </div>
                        </div>

                        <div>
                            <label for="institution" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                Asal Sekolah / Universitas / Instansi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="institution" id="institution" value="{{ old('institution', $profile->institution) }}" required
                                placeholder="Contoh: SMA Negeri 2 Cirebon / Universitas Swadaya Gunung Jati"
                                class="w-full px-4 py-2.5 rounded-xl border @error('institution') border-red-500 bg-red-50/30 dark:bg-red-950/30 @else border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/60 @enderror text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition">
                            @error('institution')
                                <p class="text-xs text-red-600 dark:text-red-400 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @endif

                <!-- 3. Informasi Pribadi & Kontak -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs overflow-hidden transition-colors">
                    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center gap-2.5 bg-slate-50/50 dark:bg-slate-800/40">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-slate-800 text-brand-primary dark:text-sky-400 flex items-center justify-center font-bold text-xs">
                            3
                        </div>
                        <div>
                            <h2 class="text-sm font-bold text-slate-800 dark:text-white">Informasi Pribadi & Kontak</h2>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">Data identitas diri dan alamat domisili</p>
                        </div>
                    </div>

                    <div class="p-6 space-y-4">
                        <!-- Nama Lengkap -->
                        <div>
                            <label for="name" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                placeholder="Masukkan nama lengkap"
                                class="w-full px-4 py-2.5 rounded-xl border @error('name') border-red-500 bg-red-50/30 dark:bg-red-950/30 @else border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/60 @enderror text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition">
                            @error('name')
                                <p class="text-xs text-red-600 dark:text-red-400 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email & Nomor HP -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="email" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                    Alamat Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                                    placeholder="nama@email.com"
                                    class="w-full px-4 py-2.5 rounded-xl border @error('email') border-red-500 bg-red-50/30 dark:bg-red-950/30 @else border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/60 @enderror text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition">
                                @error('email')
                                    <p class="text-xs text-red-600 dark:text-red-400 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                    No. WhatsApp / HP <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" required
                                    placeholder="Contoh: 08123456789"
                                    class="w-full px-4 py-2.5 rounded-xl border @error('phone') border-red-500 bg-red-50/30 dark:bg-red-950/30 @else border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/60 @enderror text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition">
                                @error('phone')
                                    <p class="text-xs text-red-600 dark:text-red-400 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Tempat & Tanggal Lahir -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="birth_place" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                    Tempat Lahir <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="birth_place" id="birth_place" value="{{ old('birth_place', $user->birth_place) }}" required
                                    placeholder="Contoh: Indramayu"
                                    class="w-full px-4 py-2.5 rounded-xl border @error('birth_place') border-red-500 bg-red-50/30 dark:bg-red-950/30 @else border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/60 @enderror text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition">
                                @error('birth_place')
                                    <p class="text-xs text-red-600 dark:text-red-400 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="birth_date" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                    Tanggal Lahir <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', $user->birth_date?->format('Y-m-d')) }}" required
                                    class="w-full px-4 py-2.5 rounded-xl border @error('birth_date') border-red-500 bg-red-50/30 dark:bg-red-950/30 @else border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/60 @enderror text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition">
                                @error('birth_date')
                                    <p class="text-xs text-red-600 dark:text-red-400 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div>
                            <label for="gender" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                Jenis Kelamin <span class="text-red-500">*</span>
                            </label>
                            <select name="gender" id="gender" required
                                class="w-full px-4 py-2.5 rounded-xl border @error('gender') border-red-500 bg-red-50/30 dark:bg-red-950/30 @else border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/60 @enderror text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition">
                                <option value="male" {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="female" {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('gender')
                                <p class="text-xs text-red-600 dark:text-red-400 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alamat Lengkap -->
                        <div>
                            <label for="address" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                Alamat Domisili Lengkap <span class="text-red-500">*</span>
                            </label>
                            <textarea name="address" id="address" rows="3" required
                                placeholder="Masukkan alamat domisili atau tempat tinggal sekarang..."
                                class="w-full px-4 py-2.5 rounded-xl border @error('address') border-red-500 bg-red-50/30 dark:bg-red-950/30 @else border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/60 @enderror text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition resize-none">{{ old('address', $user->address) }}</textarea>
                            @error('address')
                                <p class="text-xs text-red-600 dark:text-red-400 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- 4. Data Fisik & Kontak Darurat (Opsional) -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs overflow-hidden transition-colors">
                    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center gap-2.5 bg-slate-50/50 dark:bg-slate-800/40">
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-slate-800 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-bold text-xs">
                            4
                        </div>
                        <div>
                            <h2 class="text-sm font-bold text-slate-800 dark:text-white">Data Fisik & Kontak Darurat (Opsional)</h2>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">Membantu pelatih dalam penyesuaian porsi latihan & keselamatan</p>
                        </div>
                    </div>

                    <div class="p-6 space-y-4">
                        <!-- Berat & Tinggi Badan -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="weight" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                    Berat Badan (kg)
                                </label>
                                <div class="relative">
                                    <input type="number" step="0.1" name="weight" id="weight" value="{{ old('weight', $profile->weight) }}"
                                        placeholder="Contoh: 65.5"
                                        class="w-full pl-4 pr-10 py-2.5 rounded-xl border @error('weight') border-red-500 bg-red-50/30 dark:bg-red-950/30 @else border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/60 @enderror text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition">
                                    <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-xs text-slate-400 font-bold">kg</span>
                                </div>
                                @error('weight')
                                    <p class="text-xs text-red-600 dark:text-red-400 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="height" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                    Tinggi Badan (cm)
                                </label>
                                <div class="relative">
                                    <input type="number" step="0.1" name="height" id="height" value="{{ old('height', $profile->height) }}"
                                        placeholder="Contoh: 172"
                                        class="w-full pl-4 pr-10 py-2.5 rounded-xl border @error('height') border-red-500 bg-red-50/30 dark:bg-red-950/30 @else border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/60 @enderror text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition">
                                    <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-xs text-slate-400 font-bold">cm</span>
                                </div>
                                @error('height')
                                    <p class="text-xs text-red-600 dark:text-red-400 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Nama & Kontak Darurat -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="emergency_contact_name" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                    Nama Kontak Darurat (Orang Tua/Keluarga)
                                </label>
                                <input type="text" name="emergency_contact_name" id="emergency_contact_name" value="{{ old('emergency_contact_name', $profile->emergency_contact_name) }}"
                                    placeholder="Contoh: Budi Santoso (Ayah)"
                                    class="w-full px-4 py-2.5 rounded-xl border @error('emergency_contact_name') border-red-500 bg-red-50/30 dark:bg-red-950/30 @else border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/60 @enderror text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition">
                                @error('emergency_contact_name')
                                    <p class="text-xs text-red-600 dark:text-red-400 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="emergency_contact_phone" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                    Nomor HP Kontak Darurat
                                </label>
                                <input type="tel" name="emergency_contact_phone" id="emergency_contact_phone" value="{{ old('emergency_contact_phone', $profile->emergency_contact_phone) }}"
                                    placeholder="Contoh: 08129876543"
                                    class="w-full px-4 py-2.5 rounded-xl border @error('emergency_contact_phone') border-red-500 bg-red-50/30 dark:bg-red-950/30 @else border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/60 @enderror text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition">
                                @error('emergency_contact_phone')
                                    <p class="text-xs text-red-600 dark:text-red-400 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 5. Keamanan & Password (Opsional) -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs overflow-hidden transition-colors">
                    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center gap-2.5 bg-slate-50/50 dark:bg-slate-800/40">
                        <div class="w-8 h-8 rounded-lg bg-amber-50 dark:bg-slate-800 text-amber-600 dark:text-amber-400 flex items-center justify-center font-bold text-xs">
                            5
                        </div>
                        <div>
                            <h2 class="text-sm font-bold text-slate-800 dark:text-white">Keamanan Akun & Kata Sandi</h2>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">Kosongkan jika tidak ingin mengganti kata sandi. Wajib menyertakan kata sandi lama jika ingin memperbarui.</p>
                        </div>
                    </div>

                    <div class="p-6 space-y-4">
                        <div>
                            <label for="current_password" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                Kata Sandi Saat Ini (Lama)
                            </label>
                            <input type="password" name="current_password" id="current_password"
                                placeholder="Masukkan kata sandi lama Anda saat ini"
                                autocomplete="current-password"
                                class="w-full px-4 py-2.5 rounded-xl border @error('current_password') border-red-500 bg-red-50/30 dark:bg-red-950/30 @else border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/60 @enderror text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition">
                            @error('current_password')
                                <p class="text-xs text-red-600 dark:text-red-400 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="password" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                    Kata Sandi Baru
                                </label>
                                <input type="password" name="password" id="password"
                                    placeholder="Minimal 6 karakter"
                                    autocomplete="new-password"
                                    class="w-full px-4 py-2.5 rounded-xl border @error('password') border-red-500 bg-red-50/30 dark:bg-red-950/30 @else border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/60 @enderror text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition">
                                @error('password')
                                    <p class="text-xs text-red-600 dark:text-red-400 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                    Konfirmasi Kata Sandi Baru
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    placeholder="Ulangi kata sandi baru"
                                    autocomplete="new-password"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/60 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Rank / Tingkat Sabuk & Actions -->
            <div class="space-y-6">
                <!-- Tingkat Sabuk Card -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs overflow-hidden sticky top-24 transition-colors">
                    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center gap-2.5 bg-slate-50/50 dark:bg-slate-800/40">
                        <div class="w-8 h-8 rounded-lg bg-red-50 dark:bg-slate-800 text-red-600 dark:text-red-400 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-bold text-slate-800 dark:text-white">Tingkat Sabuk (Rank)</h2>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">Wajib ditentukan bagi Kohai <span class="text-red-500">*</span></p>
                        </div>
                    </div>

                    <div class="p-6 space-y-4">
                        <!-- 1. Pilihan Sabuk -->
                        <div>
                            <label for="belt_id" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                Sabuk Karate <span class="text-red-500">*</span>
                            </label>
                            <select id="belt_id" onchange="filterRanks(true)" required
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/60 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition cursor-pointer">
                                <option value="">-- Pilih Sabuk --</option>
                                @foreach($belts as $b)
                                    <option value="{{ $b->id }}" {{ (old('rank_id') ? optional($ranks->firstWhere('id', old('rank_id')))->belt_id : optional($profile->rank)->belt_id) == $b->id ? 'selected' : '' }}>
                                        {{ $b->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- 2. Pilihan Tingkatan (Rank) -->
                        <div>
                            <label for="rank_id" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                Tingkatan (Rank) <span class="text-red-500">*</span>
                            </label>
                            <select name="rank_id" id="rank_id" required
                                class="w-full px-4 py-2.5 rounded-xl border @error('rank_id') border-red-500 bg-red-50/30 dark:bg-red-950/30 @else border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/60 @enderror text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition cursor-pointer disabled:bg-slate-100/80 dark:disabled:bg-slate-800/40 disabled:cursor-not-allowed disabled:text-slate-400 dark:disabled:text-slate-500">
                                <option value="" id="rank-placeholder">-- Pilih Tingkatan --</option>
                                @foreach($belts as $b)
                                    @foreach($b->ranks as $r)
                                        <option value="{{ $r->id }}" data-belt-id="{{ $b->id }}" {{ old('rank_id', $profile->rank_id) == $r->id ? 'selected' : '' }}>
                                            {{ $r->name }}
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>
                            @error('rank_id')
                                <p class="text-xs text-red-600 dark:text-red-400 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="p-3.5 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200/80 dark:border-slate-700/60 text-xs text-slate-600 dark:text-slate-300 leading-relaxed space-y-1.5">
                            <p class="font-bold text-slate-800 dark:text-slate-200 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-brand-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Catatan Sabuk
                            </p>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">
                                Tingkatan sabuk menentukan materi latihan, ujian kenaikan tingkat, dan kategori pertandingan Kumite Anda di Dojo Karate Polindra.
                            </p>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="pt-2 space-y-3">
                            <button type="submit"
                                class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-brand-primary to-brand-secondary hover:from-brand-primary/90 hover:to-brand-secondary/90 text-white font-bold text-sm shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-brand-secondary focus:ring-offset-2 transition-all duration-200 flex items-center justify-center gap-2 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Simpan Biodata Kohai
                            </button>
                            <a href="{{ route('kohai.dashboard') }}"
                                class="w-full py-2.5 px-4 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 font-bold text-xs transition text-center block">
                                Kembali ke Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function filterStudyPrograms(isUserChange = false) {
        const deptSelect = document.getElementById('department_id');
        const progSelect = document.getElementById('study_program_id');
        const classSelect = document.getElementById('academic_class_id');
        const prodiPlaceholder = document.getElementById('prodi-placeholder');
        const kelasPlaceholder = document.getElementById('kelas-placeholder');

        if (!deptSelect || !progSelect) return;

        const selectedDeptId = deptSelect.value;
        const options = progSelect.querySelectorAll('option:not(#prodi-placeholder)');

        if (!selectedDeptId) {
            // Jurusan belum dipilih -> Prodi & Kelas disabled
            progSelect.disabled = true;
            progSelect.value = '';
            if (prodiPlaceholder) prodiPlaceholder.textContent = '-- Pilih Jurusan Terlebih Dahulu --';

            if (classSelect) {
                classSelect.disabled = true;
                classSelect.value = '';
                if (kelasPlaceholder) kelasPlaceholder.textContent = '-- Pilih Program Studi Terlebih Dahulu --';
            }

            options.forEach(opt => opt.style.display = 'none');
            return;
        }

        // Jurusan sudah dipilih -> Prodi enabled
        progSelect.disabled = false;
        if (prodiPlaceholder) prodiPlaceholder.textContent = '-- Pilih Program Studi --';

        let hasSelectedValidProdi = false;
        options.forEach(opt => {
            const deptId = opt.getAttribute('data-department-id');
            if (deptId === selectedDeptId) {
                opt.style.display = '';
                if (opt.value === progSelect.value) {
                    hasSelectedValidProdi = true;
                }
            } else {
                opt.style.display = 'none';
            }
        });

        if (isUserChange || !hasSelectedValidProdi) {
            progSelect.value = '';
        }

        filterAcademicClasses(isUserChange);
    }

    function filterAcademicClasses(isUserChange = false) {
        const progSelect = document.getElementById('study_program_id');
        const classSelect = document.getElementById('academic_class_id');
        const kelasPlaceholder = document.getElementById('kelas-placeholder');

        if (!classSelect) return;

        const selectedProgId = progSelect ? progSelect.value : '';
        const options = classSelect.querySelectorAll('option:not(#kelas-placeholder)');

        if (!selectedProgId) {
            // Prodi belum dipilih -> Kelas disabled
            classSelect.disabled = true;
            classSelect.value = '';
            if (kelasPlaceholder) kelasPlaceholder.textContent = '-- Pilih Program Studi Terlebih Dahulu --';
            options.forEach(opt => opt.style.display = 'none');
            return;
        }

        // Prodi sudah dipilih -> Kelas enabled
        classSelect.disabled = false;
        if (kelasPlaceholder) kelasPlaceholder.textContent = '-- Pilih Kelas --';

        let hasSelectedValidClass = false;
        options.forEach(opt => {
            const progId = opt.getAttribute('data-study-program-id');
            if (progId === selectedProgId) {
                opt.style.display = '';
                if (opt.value === classSelect.value) {
                    hasSelectedValidClass = true;
                }
            } else {
                opt.style.display = 'none';
            }
        });

        if (isUserChange || !hasSelectedValidClass) {
            classSelect.value = '';
        }
    }

    function filterRanks(isUserChange = false) {
        const beltSelect = document.getElementById('belt_id');
        const rankSelect = document.getElementById('rank_id');
        const rankPlaceholder = document.getElementById('rank-placeholder');

        if (!beltSelect || !rankSelect) return;

        const selectedBeltId = beltSelect.value;
        const options = rankSelect.querySelectorAll('option:not(#rank-placeholder)');

        if (!selectedBeltId) {
            rankSelect.disabled = true;
            rankSelect.value = '';
            if (rankPlaceholder) rankPlaceholder.textContent = '-- Pilih Sabuk Terlebih Dahulu --';
            options.forEach(opt => opt.style.display = 'none');
            return;
        }

        rankSelect.disabled = false;
        if (rankPlaceholder) rankPlaceholder.textContent = '-- Pilih Tingkatan --';

        let hasSelectedValidRank = false;
        options.forEach(opt => {
            const beltId = opt.getAttribute('data-belt-id');
            if (beltId === selectedBeltId) {
                opt.style.display = '';
                if (opt.value === rankSelect.value) {
                    hasSelectedValidRank = true;
                }
            } else {
                opt.style.display = 'none';
            }
        });

        if (isUserChange || !hasSelectedValidRank) {
            rankSelect.value = '';
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        filterStudyPrograms(false);
        filterRanks(false);
    });
</script>
@endsection
