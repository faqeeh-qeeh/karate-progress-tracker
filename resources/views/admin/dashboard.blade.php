@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">
    <!-- Header Hero Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-slate-800 to-brand-primary p-6 sm:p-8 text-white shadow-xl">
        <div class="relative z-10 space-y-2 sm:space-y-3">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-500/20 border border-red-500/30 text-[11px] font-bold text-red-300">
                <span class="w-2 h-2 rounded-full bg-red-400 animate-ping"></span>
                SYSTEM ADMINISTRATOR PANEL
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight leading-tight">Selamat Datang, Admin {{ auth()->user()->name }}! 👋</h1>
            <p class="text-slate-300 text-xs sm:text-sm max-w-2xl font-medium leading-relaxed">
                Kelola seluruh pengguna, hak akses role, serta monitoring aktivitas Karate Polindra Tracker secara terpusat.
            </p>
        </div>
        <div class="absolute -right-8 -bottom-8 w-56 h-56 bg-brand-secondary/15 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- Metrics Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <!-- Total Users -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pengguna</p>
                    <p class="text-2xl sm:text-3xl font-black text-slate-900 mt-1">{{ $totalUsers }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-800 flex items-center justify-center text-xl font-bold">
                    👥
                </div>
            </div>
            <p class="text-xs text-emerald-600 font-bold mt-3 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>Sistem Terdaftar & Aktif</span>
            </p>
        </div>

        <!-- Total Senpai -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Senpai (Pelatih)</p>
                    <p class="text-2xl sm:text-3xl font-black text-brand-primary mt-1">{{ $totalSenpai }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-brand-primary/10 text-brand-primary flex items-center justify-center text-xl font-bold">
                    🥋
                </div>
            </div>
            <p class="text-xs text-brand-primary font-bold mt-3">Pelatih & Instructor Dojo</p>
        </div>

        <!-- Total Kohai -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Kohai (Murid)</p>
                    <p class="text-2xl sm:text-3xl font-black text-brand-secondary mt-1">{{ $totalKohai }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-brand-secondary/10 text-brand-secondary flex items-center justify-center text-xl font-bold">
                    ⚪
                </div>
            </div>
            <p class="text-xs text-brand-secondary font-bold mt-3">Murid & Anggota Dojo</p>
        </div>

        <!-- Quick System Status -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Status Mode</p>
                    <p class="text-xl font-extrabold text-emerald-600 mt-1">Manual Auth</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold">
                    🔒
                </div>
            </div>
            <p class="text-xs text-slate-500 font-medium mt-3">Dedicated Admin Workspace</p>
        </div>
    </div>

    <!-- Main Content Table: Latest Users -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-5 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h3 class="text-base sm:text-lg font-extrabold text-slate-900 tracking-tight">Pengguna Terbaru</h3>
                <p class="text-xs text-slate-500 mt-0.5 font-medium">10 Pengguna yang baru terdaftar dalam sistem</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center justify-center gap-1.5 px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition w-max">
                <span>Kelola Semua User</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="overflow-x-auto min-w-0">
            <table class="w-full text-left text-sm text-slate-600 min-w-full">
                <thead class="bg-slate-50 text-slate-700 text-[11px] uppercase font-bold tracking-wider border-b border-slate-200/80 whitespace-nowrap">
                    <tr>
                        <th class="py-3.5 px-4 sm:px-6">ID</th>
                        <th class="py-3.5 px-4 sm:px-6">Nama Pengguna</th>
                        <th class="py-3.5 px-4 sm:px-6">Alamat Email</th>
                        <th class="py-3.5 px-4 sm:px-6">Role / Jabatan</th>
                        <th class="py-3.5 px-4 sm:px-6">Tanggal Bergabung</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 whitespace-nowrap font-medium">
                    @forelse($users as $u)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-4 sm:px-6 font-mono text-xs text-slate-400">#{{ $u->id }}</td>
                            <td class="py-4 px-4 sm:px-6 font-bold text-slate-900 flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-slate-900 text-white flex items-center justify-center text-xs font-extrabold shrink-0 shadow-xs">
                                    {{ substr($u->name, 0, 2) }}
                                </div>
                                <span class="text-xs sm:text-sm font-bold text-slate-900">{{ $u->name }}</span>
                            </td>
                            <td class="py-4 px-4 sm:px-6 text-slate-600 text-xs">{{ $u->email }}</td>
                            <td class="py-4 px-4 sm:px-6">
                                @php
                                    $roleName = $u->role->nama ?? 'Tanpa Role';
                                    $badgeStyle = match(strtolower($roleName)) {
                                        'admin' => 'bg-red-50 text-red-700 border-red-200',
                                        'senpai' => 'bg-blue-50 text-brand-primary border-blue-200',
                                        'kohai' => 'bg-cyan-50 text-cyan-800 border-cyan-200',
                                        default => 'bg-slate-100 text-slate-700 border-slate-200'
                                    };
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs leading-none font-extrabold rounded-full border {{ $badgeStyle }}">
                                    {{ $roleName }}
                                </span>
                            </td>
                            <td class="py-4 px-4 sm:px-6 text-xs text-slate-500">
                                {{ $u->created_at ? $u->created_at->format('d M Y, H:i') : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400 text-sm font-medium">
                                Belum ada data pengguna.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
