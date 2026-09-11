@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-5 sm:space-y-6">
    <!-- Header Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-brand-black via-gray-900 to-brand-primary p-5 sm:p-8 text-white shadow-xl">
        <div class="relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-600/80 border border-red-400/40 text-[11px] sm:text-xs font-bold text-white mb-2 sm:mb-3">
                <span class="w-2 h-2 rounded-full bg-red-400 animate-ping"></span>
                SYSTEM ADMINISTRATOR PANEL
            </div>
            <h1 class="text-xl sm:text-3xl font-extrabold tracking-tight leading-tight">Selamat Datang, Admin {{ auth()->user()->name }}! 👋</h1>
            <p class="text-gray-300 text-xs sm:text-sm mt-1 max-w-2xl">
                Kelola seluruh pengguna, hak akses role, serta monitoring aktivitas Karate Dojo Tracker dari satu panel utama.
            </p>
        </div>
        <div class="absolute -right-6 -bottom-6 w-48 h-48 bg-brand-secondary/10 rounded-full blur-2xl"></div>
    </div>

    <!-- Metrics Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6">
        <!-- Total Users -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-100 shadow-xs hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Total Pengguna</p>
                    <p class="text-xl sm:text-2xl font-black text-brand-black mt-1">{{ $totalUsers }}</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-gray-100 text-brand-black flex items-center justify-center font-bold text-lg sm:text-xl">
                    👥
                </div>
            </div>
            <p class="text-xs text-emerald-600 font-medium mt-2 sm:mt-3 flex items-center gap-1">
                <span>✓ Sistem Aktif & Terdaftar</span>
            </p>
        </div>

        <!-- Total Senpai -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-100 shadow-xs hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Total Senpai (Pelatih)</p>
                    <p class="text-xl sm:text-2xl font-black text-brand-primary mt-1">{{ $totalSenpai }}</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-brand-primary/10 text-brand-primary flex items-center justify-center font-bold text-lg sm:text-xl">
                    🥋
                </div>
            </div>
            <p class="text-xs text-brand-primary font-medium mt-2 sm:mt-3">Pelatih Dojo Utama</p>
        </div>

        <!-- Total Kohai -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-100 shadow-xs hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Total Kohai (Murid)</p>
                    <p class="text-xl sm:text-2xl font-black text-brand-secondary mt-1">{{ $totalKohai }}</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-brand-secondary/10 text-brand-secondary flex items-center justify-center font-bold text-lg sm:text-xl">
                    ⚪
                </div>
            </div>
            <p class="text-xs text-brand-secondary font-medium mt-2 sm:mt-3">Anggota Aktif Latihan</p>
        </div>

        <!-- Quick System Status -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-100 shadow-xs hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Status Auth</p>
                    <p class="text-lg sm:text-xl font-bold text-emerald-600 mt-1">Manual Auth</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-lg sm:text-xl">
                    🔒
                </div>
            </div>
            <p class="text-xs text-gray-500 font-medium mt-2 sm:mt-3">Dedicated Admin Layout</p>
        </div>
    </div>

    <!-- Main Content Table: User Management -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
        <div class="p-4 sm:p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h3 class="text-base sm:text-lg font-extrabold text-brand-black">Daftar Pengguna Sistem</h3>
                <p class="text-xs text-gray-500">Semua pengguna terdaftar beserta hak akses jabatannya</p>
            </div>
            <span class="inline-flex items-center px-3 py-1 rounded-full bg-brand-light text-brand-primary text-xs font-semibold border border-brand-primary/20 w-max">
                10 Pengguna Terbaru
            </span>
        </div>

        <div class="overflow-x-auto min-w-0">
            <table class="w-full text-left text-sm text-gray-600 min-w-full">
                <thead class="bg-brand-light text-brand-black text-[11px] sm:text-xs uppercase font-bold tracking-wider border-b border-gray-200 whitespace-nowrap">
                    <tr>
                        <th class="py-3 px-4 sm:px-6">ID</th>
                        <th class="py-3 px-4 sm:px-6">Nama Pengguna</th>
                        <th class="py-3 px-4 sm:px-6">Alamat Email</th>
                        <th class="py-3 px-4 sm:px-6">Role / Jabatan</th>
                        <th class="py-3 px-4 sm:px-6">Tanggal Bergabung</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 whitespace-nowrap">
                    @forelse($users as $u)
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="py-3.5 px-4 sm:px-6 font-mono text-xs text-gray-400">#{{ $u->id }}</td>
                            <td class="py-3.5 px-4 sm:px-6 font-bold text-brand-black flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gray-900 text-white flex items-center justify-center text-xs font-bold shrink-0">
                                    {{ substr($u->name, 0, 2) }}
                                </div>
                                <span>{{ $u->name }}</span>
                            </td>
                            <td class="py-3.5 px-4 sm:px-6 text-gray-600 text-xs">{{ $u->email }}</td>
                            <td class="py-3.5 px-4 sm:px-6">
                                @php
                                    $roleName = $u->role->nama ?? 'Tanpa Role';
                                    $badgeStyle = match(strtolower($roleName)) {
                                        'admin' => 'bg-red-100 text-red-700 border-red-200',
                                        'senpai' => 'bg-blue-100 text-brand-primary border-blue-200',
                                        'kohai' => 'bg-cyan-100 text-cyan-800 border-cyan-200',
                                        default => 'bg-gray-100 text-gray-700 border-gray-200'
                                    };
                                @endphp
                                <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-extrabold rounded-full border {{ $badgeStyle }}">
                                    {{ $roleName }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 sm:px-6 text-xs text-gray-500">
                                {{ $u->created_at ? $u->created_at->format('d M Y, H:i') : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-400 text-sm">
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
