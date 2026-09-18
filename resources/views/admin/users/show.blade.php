@extends('layouts.admin')

@section('title', 'Detail Biodata Pengguna - ' . $user->name)

@section('content')
<div class="space-y-6">
    <!-- Top Action & Navigation Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-sm">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.users.index') }}" class="p-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl transition shrink-0" title="Kembali ke Daftar Pengguna">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <div class="flex items-center gap-3 flex-wrap">
                    <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">{{ $user->name }}</h1>
                    @php
                        $rName = $user->role->nama ?? 'N/A';
                        $bStyle = match(strtolower($rName)) {
                            'admin' => 'bg-red-50 text-red-700 border-red-200',
                            'senpai' => 'bg-blue-50 text-brand-primary border-blue-200',
                            'kohai' => 'bg-cyan-50 text-cyan-800 border-cyan-200',
                            default => 'bg-slate-100 text-slate-700 border-slate-200'
                        };
                    @endphp
                    <span class="px-3 py-1 inline-flex text-xs font-extrabold rounded-full border {{ $bStyle }}">
                        {{ $rName }}
                    </span>
                    @if($user->id === auth()->id())
                        <span class="px-2.5 py-0.5 text-[11px] font-extrabold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                            Akun Anda
                        </span>
                    @endif
                </div>
                <p class="text-xs text-slate-500 mt-1 font-medium">Informasi biodata lengkap, data keanggotaan, dan atribut profil pengguna</p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            @if(! $user->hasVerifiedEmail())
                <form action="{{ route('admin.users.resend-activation', $user->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 text-xs font-bold rounded-xl transition shadow-xs">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>Kirim Ulang Email Aktivasi</span>
                    </button>
                </form>
            @endif
            <a href="{{ route('admin.users.edit', $user->id) }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 text-xs font-bold rounded-xl transition shadow-xs">
                <svg class="w-4 h-4 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span>Edit Akun</span>
            </a>
        </div>
    </div>

    <!-- Main Profile Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 sm:p-8">
        <!-- Identity Summary Header -->
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 pb-6 border-b border-slate-100">
            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-3xl bg-gradient-to-br from-slate-900 to-slate-800 text-white font-black text-2xl sm:text-3xl flex items-center justify-center shadow-lg shadow-slate-900/10 shrink-0 border-2 border-slate-100">
                {{ $user->initials }}
            </div>
            <div class="text-center sm:text-left space-y-1.5 flex-1">
                <h2 class="text-2xl font-black text-slate-900">{{ $user->name }}</h2>
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-3 text-xs text-slate-500 font-medium">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>{{ $user->email }}</span>
                    </span>
                    <span>•</span>
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span>{{ $user->phone ?? '-' }}</span>
                    </span>
                    <span>•</span>
                    <span class="font-mono text-slate-400">User ID: #{{ $user->id }}</span>
                </div>
            </div>
        </div>

        <!-- Details Grid Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6">
            <!-- Data Pribadi -->
            <div class="bg-slate-50/70 p-5 rounded-2xl border border-slate-100 space-y-4">
                <div class="flex items-center gap-2 border-b border-slate-200/60 pb-3">
                    <span class="w-2 h-2 rounded-full bg-brand-primary"></span>
                    <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">Biodata Pribadi</h3>
                </div>

                <div class="space-y-3 text-xs">
                    <div class="flex justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-500 font-medium">Nama Lengkap:</span>
                        <span class="font-bold text-slate-900 text-right">{{ $user->name }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-500 font-medium">Alamat Email:</span>
                        <span class="font-bold text-slate-900 text-right">{{ $user->email }}</span>
                    </div>
                    <div class="flex justify-between items-center py-1 border-b border-slate-100">
                        <span class="text-slate-500 font-medium">Status Konfirmasi Email:</span>
                        @if($user->hasVerifiedEmail())
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                ✓ Terverifikasi ({{ $user->email_verified_at->format('d/m/Y H:i') }})
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-extrabold bg-amber-50 text-amber-700 border border-amber-200">
                                ⏳ Belum Terverifikasi
                            </span>
                        @endif
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-500 font-medium">Tempat, Tanggal Lahir:</span>
                        <span class="font-bold text-slate-900 text-right">
                            {{ $user->birth_place ?? '-' }}, {{ $user->birth_date ? $user->birth_date->format('d F Y') : '-' }}
                            @if($user->birth_date)
                                <span class="text-slate-400 font-normal">({{ \Carbon\Carbon::parse($user->birth_date)->age }} tahun)</span>
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-500 font-medium">Jenis Kelamin:</span>
                        <span class="font-bold text-slate-900 text-right">
                            {{ $user->gender === 'male' ? 'Laki-laki' : ($user->gender === 'female' ? 'Perempuan' : '-') }}
                        </span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-500 font-medium">Nomor WhatsApp / HP:</span>
                        <span class="font-bold text-slate-900 text-right">{{ $user->phone ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-500 font-medium">Alamat Domisili:</span>
                        <span class="font-bold text-slate-900 text-right max-w-xs leading-relaxed">{{ $user->address ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span class="text-slate-500 font-medium">Terdaftar Sejak:</span>
                        <span class="font-bold text-slate-700 text-right">{{ $user->created_at ? $user->created_at->format('d M Y, H:i') : '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Role Specific Data Section -->
            @if($user->isKohai())
                @php
                    $kp = $user->kohaiProfile;
                @endphp
                <div class="bg-slate-50/70 p-5 rounded-2xl border border-slate-100 space-y-4">
                    <div class="flex items-center gap-2 border-b border-slate-200/60 pb-3">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">Biodata Kohai (Keanggotaan & Sabuk)</h3>
                    </div>

                    <div class="space-y-3 text-xs">
                        <div class="flex justify-between py-1 border-b border-slate-100">
                            <span class="text-slate-500 font-medium">Kategori Keanggotaan:</span>
                            @if($kp?->type === 'non_polindra')
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-purple-50 text-purple-700 border border-purple-200">
                                    Luar Polindra / Umum
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-50 text-brand-primary border border-blue-200">
                                    Mahasiswa Polindra
                                </span>
                            @endif
                        </div>

                        @if($kp?->type === 'non_polindra')
                            <div class="flex justify-between py-1 border-b border-slate-100">
                                <span class="text-slate-500 font-medium">Asal Sekolah / Instansi:</span>
                                <span class="font-bold text-slate-900 text-right">{{ $kp->school_origin ?? '-' }}</span>
                            </div>
                        @else
                            <div class="flex justify-between py-1 border-b border-slate-100">
                                <span class="text-slate-500 font-medium">NIM Polindra:</span>
                                <span class="font-bold text-slate-900 font-mono text-right">{{ $kp?->nim ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-slate-100">
                                <span class="text-slate-500 font-medium">Jurusan:</span>
                                <span class="font-bold text-slate-900 text-right">{{ $kp?->studyProgram?->department?->nama ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-slate-100">
                                <span class="text-slate-500 font-medium">Program Studi:</span>
                                <span class="font-bold text-slate-900 text-right">{{ $kp?->studyProgram?->nama ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-slate-100">
                                <span class="text-slate-500 font-medium">Kelas:</span>
                                <span class="font-bold text-slate-900 text-right">{{ $kp?->academicClass?->nama ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-slate-100">
                                <span class="text-slate-500 font-medium">Tahun Masuk / Angkatan:</span>
                                <span class="font-bold text-slate-900 text-right">{{ $kp?->entry_year ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-slate-100">
                                <span class="text-slate-500 font-medium">Asal SMA/SMK:</span>
                                <span class="font-bold text-slate-900 text-right">{{ $kp?->school_origin ?? '-' }}</span>
                            </div>
                        @endif

                        <div class="flex justify-between py-1 border-b border-slate-100">
                            <span class="text-slate-500 font-medium">Tingkat Sabuk:</span>
                            <span class="font-bold text-slate-900 text-right">
                                @if($kp?->rank?->belt)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-lg bg-slate-100 border border-slate-200">
                                        <span class="w-2.5 h-2.5 rounded-full border border-slate-400" style="background-color: {{ $kp->rank->belt->warna ?? '#e2e8f0' }}"></span>
                                        <span>Sabuk {{ $kp->rank->belt->nama }} - {{ $kp->rank->nama }}</span>
                                    </span>
                                @else
                                    <span class="text-slate-400 italic">Belum ditentukan</span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Data Fisik & Kontak Darurat -->
                <div class="bg-slate-50/70 p-5 rounded-2xl border border-slate-100 space-y-4">
                    <div class="flex items-center gap-2 border-b border-slate-200/60 pb-3">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">Data Fisik & Postur Tubuh</h3>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-white p-4 rounded-xl border border-slate-200/80 text-center">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Tinggi Badan</span>
                            <p class="text-xl font-black text-slate-900">{{ $kp?->height ?? '-' }} <span class="text-xs font-semibold text-slate-400">cm</span></p>
                        </div>
                        <div class="bg-white p-4 rounded-xl border border-slate-200/80 text-center">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Berat Badan</span>
                            <p class="text-xl font-black text-slate-900">{{ $kp?->weight ?? '-' }} <span class="text-xs font-semibold text-slate-400">kg</span></p>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50/70 p-5 rounded-2xl border border-slate-100 space-y-4">
                    <div class="flex items-center gap-2 border-b border-slate-200/60 pb-3">
                        <span class="w-2 h-2 rounded-full bg-red-500"></span>
                        <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">Kontak Darurat (Wali)</h3>
                    </div>

                    <div class="space-y-3 text-xs">
                        <div class="flex justify-between py-1 border-b border-slate-100">
                            <span class="text-slate-500 font-medium">Nama Kontak Darurat:</span>
                            <span class="font-bold text-slate-900 text-right">{{ $kp?->emergency_contact_name ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between py-1">
                            <span class="text-slate-500 font-medium">No. Telepon Kontak Darurat:</span>
                            <span class="font-bold text-slate-900 text-right font-mono">{{ $kp?->emergency_contact_phone ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            @elseif($user->isSenpai())
                @php
                    $sp = $user->senpaiProfile;
                @endphp
                <div class="bg-slate-50/70 p-5 rounded-2xl border border-slate-100 space-y-4">
                    <div class="flex items-center gap-2 border-b border-slate-200/60 pb-3">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                        <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">Profil & Tingkatan Senpai</h3>
                    </div>

                    <div class="space-y-3 text-xs">
                        <div class="flex justify-between py-1 border-b border-slate-100">
                            <span class="text-slate-500 font-medium">Tingkat Sabuk:</span>
                            <span class="font-bold text-slate-900 text-right">
                                @if($sp?->rank?->belt)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-lg bg-slate-100 border border-slate-200">
                                        <span class="w-2.5 h-2.5 rounded-full border border-slate-400" style="background-color: {{ $sp->rank->belt->warna ?? '#e2e8f0' }}"></span>
                                        <span>Sabuk {{ $sp->rank->belt->nama }} - {{ $sp->rank->nama }}</span>
                                    </span>
                                @else
                                    <span class="text-slate-400 italic">Belum ditentukan</span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-slate-50/70 p-5 rounded-2xl border border-slate-100 space-y-4">
                    <div class="flex items-center gap-2 border-b border-slate-200/60 pb-3">
                        <span class="w-2 h-2 rounded-full bg-red-500"></span>
                        <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">Hak Akses & Otoritas</h3>
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Akun ini memiliki hak akses penuh sebagai <strong>Administrator Sistem</strong> untuk mengelola master data dojo karate, kurikulum akademik, manajemen seluruh akun pengguna, serta melihat laporan aktivitas dojo.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
