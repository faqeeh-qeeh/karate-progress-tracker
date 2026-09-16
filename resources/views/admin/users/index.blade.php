@extends('layouts.admin')

@section('title', 'Manajemen Akun Pengguna')

@section('content')
<div class="space-y-6">
    <!-- Top Action & Title Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-sm">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Manajemen Akun Pengguna</h1>
            <p class="text-xs text-slate-500 mt-1 font-medium">Kelola seluruh akun, penetapan role, penyuntingan data, dan pendaftaran pengguna baru</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3 bg-gradient-to-r from-brand-primary to-brand-secondary hover:from-brand-primary/90 hover:to-brand-secondary/90 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md shadow-brand-primary/20 hover:shadow-lg transition-all active:scale-[0.99] whitespace-nowrap">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Tambah Akun Baru</span>
        </a>
    </div>

    <!-- Search & Filter Form Card -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm">
        <form action="{{ route('admin.users.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <!-- Search Keyword Input -->
            <div class="sm:col-span-6 relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama pengguna atau email..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary bg-slate-50/50 placeholder:text-slate-400 transition">
            </div>

            <!-- Role Filter Select -->
            <div class="sm:col-span-4 relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                </div>
                <select name="role_id" onchange="this.form.submit()" class="w-full pl-10 pr-8 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary bg-slate-50/50 text-slate-700 cursor-pointer appearance-none transition">
                    <option value="">Semua Role</option>
                    @foreach($roles as $r)
                        <option value="{{ $r->id }}" {{ request('role_id') == $r->id ? 'selected' : '' }}>
                            Role: {{ $r->nama }}
                        </option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>

            <!-- Submit & Reset Buttons -->
            <div class="sm:col-span-2 flex items-center gap-2">
                <button type="submit" class="w-full py-2.5 px-4 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl transition shadow-xs">
                    Cari
                </button>
                @if(request('search') || request('role_id'))
                    <a href="{{ route('admin.users.index') }}" class="py-2.5 px-3.5 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold rounded-xl transition whitespace-nowrap">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Mobile View: User Card Roster List (Shown on mobile screens < md) -->
    <div class="block md:hidden space-y-4">
        @forelse($users as $u)
            @php
                $rName = $u->role->nama ?? 'N/A';
                $bStyle = match(strtolower($rName)) {
                    'admin' => 'bg-red-50 text-red-700 border-red-200',
                    'senpai' => 'bg-blue-50 text-brand-primary border-blue-200',
                    'kohai' => 'bg-cyan-50 text-cyan-800 border-cyan-200',
                    default => 'bg-slate-100 text-slate-700 border-slate-200'
                };
            @endphp
            <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm hover:shadow-md transition-all space-y-3.5">
                <!-- User Header Info -->
                <div class="flex items-start justify-between gap-3 border-b border-slate-100 pb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center text-xs font-extrabold shrink-0 shadow-xs">
                            {{ $u->initials }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <h3 class="text-sm font-extrabold text-slate-900 leading-tight">{{ $u->name }}</h3>
                                @if($u->id === auth()->id())
                                    <span class="inline-block text-[10px] text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-full font-extrabold">Akun Anda</span>
                                @endif
                            </div>
                            <span class="font-mono text-[11px] text-slate-400">ID: #{{ $u->id }}</span>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 inline-flex text-[11px] font-extrabold rounded-full border {{ $bStyle }} shrink-0">
                        {{ $rName }}
                    </span>
                </div>

                <!-- User Details -->
                <div class="space-y-2">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        <div class="flex items-center gap-2.5 text-xs text-slate-600 bg-slate-50/80 p-2.5 rounded-xl border border-slate-100">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span class="truncate font-medium">{{ $u->email }}</span>
                        </div>
                        <div class="flex items-center justify-between gap-2 text-xs text-slate-600 bg-slate-50/80 p-2.5 rounded-xl border border-slate-100">
                            <div class="flex items-center gap-2 truncate">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                <span class="truncate font-medium">{{ $u->phone }}</span>
                            </div>
                            <span class="text-[10px] font-extrabold px-1.5 py-0.5 rounded bg-slate-200 text-slate-700 shrink-0 uppercase">
                                {{ $u->gender === 'male' ? 'L' : 'P' }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs text-slate-500 pt-0.5 px-1">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>TTL / Dibuat:</span>
                        </span>
                        <span class="font-bold text-slate-700">{{ $u->birth_place }}, {{ $u->birth_date ? $u->birth_date->format('d M Y') : '-' }}</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="pt-2 border-t border-slate-100 flex items-center gap-2">
                    <!-- Detail Biodata Button -->
                    <a href="{{ route('admin.users.show', $u->id) }}" class="flex-1 py-2.5 px-3 bg-blue-50 hover:bg-blue-100 text-brand-primary border border-blue-200/80 text-xs font-bold rounded-xl transition-all shadow-xs flex items-center justify-center gap-1.5">
                        <svg class="w-4 h-4 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <span>Lihat Biodata</span>
                    </a>

                    <!-- Edit Button -->
                    <a href="{{ route('admin.users.edit', $u->id) }}" class="flex-1 py-2.5 px-3 bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200/80 text-xs font-bold rounded-xl transition-all shadow-xs flex items-center justify-center gap-1.5">
                        <svg class="w-4 h-4 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        <span>Edit</span>
                    </a>

                    <!-- Delete Button -->
                    @if($u->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $u->name }}? Tindakan ini tidak dapat dibatalkan.');" class="shrink-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="py-2.5 px-3 bg-red-50 hover:bg-red-100 text-red-700 border border-red-200/80 text-xs font-bold rounded-xl transition-all shadow-xs flex items-center justify-center" title="Hapus Akun">
                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl p-8 text-center text-slate-400 border border-slate-200/80 shadow-sm space-y-2">
                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto text-xl font-bold">👥</div>
                <p class="text-sm font-medium">Tidak ditemukan data akun pengguna.</p>
            </div>
        @endforelse

        <div class="pt-2">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Desktop View: Table Format (Hidden on mobile < md) -->
    <div class="hidden md:block bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto min-w-0">
            <table class="w-full text-left text-sm text-slate-600 min-w-full">
                <thead class="bg-slate-50 text-slate-700 text-[11px] uppercase font-bold tracking-wider border-b border-slate-200/80 whitespace-nowrap">
                    <tr>
                        <th class="py-3.5 px-4 sm:px-6">ID</th>
                        <th class="py-3.5 px-4 sm:px-6">Nama Pengguna</th>
                        <th class="py-3.5 px-4 sm:px-6">Alamat Email</th>
                        <th class="py-3.5 px-4 sm:px-6">Role / Jabatan</th>
                        <th class="py-3.5 px-4 sm:px-6">Tanggal Dibuat</th>
                        <th class="py-3.5 px-4 sm:px-6 text-center">Aksi Administrator</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 whitespace-nowrap font-medium">
                    @forelse($users as $u)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-4 sm:px-6 font-mono text-xs text-slate-400">#{{ $u->id }}</td>
                            <td class="py-4 px-4 sm:px-6 font-bold text-slate-900 flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-slate-900 text-white flex items-center justify-center text-xs font-extrabold shrink-0 shadow-xs">
                                    {{ $u->initials }}
                                </div>
                                <div>
                                    <p class="text-xs sm:text-sm font-bold text-slate-900 leading-tight">{{ $u->name }}</p>
                                    @if($u->id === auth()->id())
                                        <span class="inline-block text-[10px] text-emerald-600 font-extrabold">(Akun Anda)</span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 px-4 sm:px-6 text-slate-600 text-xs">
                                <p class="font-bold text-slate-800">{{ $u->email }}</p>
                                <p class="text-[11px] text-slate-500 font-mono flex items-center gap-1.5 mt-0.5">
                                    <span>📞 {{ $u->phone }}</span>
                                    <span>•</span>
                                    <span class="font-sans font-semibold text-slate-600">{{ $u->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</span>
                                </p>
                            </td>
                            <td class="py-4 px-4 sm:px-6">
                                @php
                                    $rName = $u->role->nama ?? 'N/A';
                                    $bStyle = match(strtolower($rName)) {
                                        'admin' => 'bg-red-50 text-red-700 border-red-200',
                                        'senpai' => 'bg-blue-50 text-brand-primary border-blue-200',
                                        'kohai' => 'bg-cyan-50 text-cyan-800 border-cyan-200',
                                        default => 'bg-slate-100 text-slate-700 border-slate-200'
                                    };
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs leading-none font-extrabold rounded-full border {{ $bStyle }}">
                                    {{ $rName }}
                                </span>
                            </td>
                            <td class="py-4 px-4 sm:px-6 text-xs text-slate-500">
                                {{ $u->created_at ? $u->created_at->format('d M Y, H:i') : '-' }}
                            </td>
                            <td class="py-4 px-4 sm:px-6 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- View Detail Biodata Button -->
                                    <a href="{{ route('admin.users.show', $u->id) }}" class="p-2 rounded-xl bg-blue-50 text-brand-primary hover:bg-blue-100 border border-blue-200/80 transition-colors" title="Lihat Biodata Lengkap">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>

                                    <!-- Edit Button -->
                                    <a href="{{ route('admin.users.edit', $u->id) }}" class="p-2 rounded-xl bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200/80 transition-colors" title="Edit Akun">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>

                                    <!-- Delete Button -->
                                    @if($u->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $u->name }}? Tindakan ini tidak dapat dibatalkan.');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 rounded-xl bg-red-50 text-red-700 hover:bg-red-100 border border-red-200/80 transition-colors" title="Hapus Akun">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    @else
                                        <button disabled class="p-2 rounded-xl bg-slate-100 text-slate-300 cursor-not-allowed" title="Tidak dapat menghapus akun sendiri">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400 text-sm font-medium">
                                Tidak ditemukan data akun pengguna.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t border-slate-100">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
