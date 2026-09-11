@extends('layouts.admin')

@section('title', 'Manajemen Akun Pengguna')

@section('content')
<div class="space-y-5 sm:space-y-6">
    <!-- Top Action & Title Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-4 sm:p-6 rounded-2xl border border-gray-100 shadow-xs">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-brand-black">Manajemen Akun Pengguna</h1>
            <p class="text-xs text-gray-500 mt-1">Kelola seluruh daftar akun, penetapan role, penyuntingan data, dan pendaftaran pengguna baru</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-brand-primary hover:bg-brand-primary/90 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md transition whitespace-nowrap">
            <svg class="w-5 h-5 text-brand-secondary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Tambah Akun Baru</span>
        </a>
    </div>

    <!-- Search & Filter Form -->
    <div class="bg-white p-3.5 sm:p-4 rounded-2xl border border-gray-100 shadow-xs">
        <form action="{{ route('admin.users.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <!-- Search Keyword Input -->
            <div class="sm:col-span-6">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama pengguna atau email..."
                    class="w-full px-3.5 py-2 rounded-xl border border-gray-300 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary bg-gray-50/50">
            </div>

            <!-- Role Filter Select -->
            <div class="sm:col-span-4">
                <select name="role_id" onchange="this.form.submit()" class="w-full px-3.5 py-2 rounded-xl border border-gray-300 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary bg-gray-50/50">
                    <option value="">Semua Role</option>
                    @foreach($roles as $r)
                        <option value="{{ $r->id }}" {{ request('role_id') == $r->id ? 'selected' : '' }}>
                            Role: {{ $r->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Submit & Reset Buttons -->
            <div class="sm:col-span-2 flex items-center gap-2">
                <button type="submit" class="w-full py-2 px-3 bg-brand-black text-white text-xs font-bold rounded-xl hover:bg-gray-900 transition">
                    Cari
                </button>
                @if(request('search') || request('role_id'))
                    <a href="{{ route('admin.users.index') }}" class="py-2 px-3 bg-gray-200 text-gray-700 text-xs font-bold rounded-xl hover:bg-gray-300 transition whitespace-nowrap">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- User Table Card -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
        <div class="overflow-x-auto min-w-0">
            <table class="w-full text-left text-sm text-gray-600 min-w-full">
                <thead class="bg-brand-light text-brand-black text-[11px] sm:text-xs uppercase font-bold tracking-wider border-b border-gray-200 whitespace-nowrap">
                    <tr>
                        <th class="py-3.5 px-4 sm:px-6">ID</th>
                        <th class="py-3.5 px-4 sm:px-6">Nama Pengguna</th>
                        <th class="py-3.5 px-4 sm:px-6">Alamat Email</th>
                        <th class="py-3.5 px-4 sm:px-6">Role / Jabatan</th>
                        <th class="py-3.5 px-4 sm:px-6">Tanggal Dibuat</th>
                        <th class="py-3.5 px-4 sm:px-6 text-center">Aksi Administrator</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 whitespace-nowrap">
                    @forelse($users as $u)
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="py-3.5 px-4 sm:px-6 font-mono text-xs text-gray-400">#{{ $u->id }}</td>
                            <td class="py-3.5 px-4 sm:px-6 font-bold text-brand-black flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-brand-black text-white flex items-center justify-center text-xs font-bold shrink-0">
                                    {{ substr($u->name, 0, 2) }}
                                </div>
                                <div>
                                    <p class="text-xs sm:text-sm font-bold text-brand-black leading-tight">{{ $u->name }}</p>
                                    @if($u->id === auth()->id())
                                        <span class="inline-block text-[10px] text-emerald-600 font-extrabold">(Akun Anda)</span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3.5 px-4 sm:px-6 text-gray-600 text-xs font-medium">{{ $u->email }}</td>
                            <td class="py-3.5 px-4 sm:px-6">
                                @php
                                    $rName = $u->role->nama ?? 'N/A';
                                    $bStyle = match(strtolower($rName)) {
                                        'admin' => 'bg-red-100 text-red-700 border-red-200',
                                        'senpai' => 'bg-blue-100 text-brand-primary border-blue-200',
                                        'kohai' => 'bg-cyan-100 text-cyan-800 border-cyan-200',
                                        default => 'bg-gray-100 text-gray-700 border-gray-200'
                                    };
                                @endphp
                                <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-extrabold rounded-full border {{ $bStyle }}">
                                    {{ $rName }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 sm:px-6 text-xs text-gray-500">
                                {{ $u->created_at ? $u->created_at->format('d M Y, H:i') : '-' }}
                            </td>
                            <td class="py-3.5 px-4 sm:px-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Edit Button -->
                                    <a href="{{ route('admin.users.edit', $u->id) }}" class="p-2 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200 transition" title="Edit Akun">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>

                                    <!-- Delete Button -->
                                    @if($u->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $u->name }}? Action ini tidak dapat dibatalkan.');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 rounded-lg bg-red-50 text-red-700 hover:bg-red-100 border border-red-200 transition" title="Hapus Akun">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    @else
                                        <button disabled class="p-2 rounded-lg bg-gray-100 text-gray-400 cursor-not-allowed" title="Tidak dapat menghapus akun sendiri">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-gray-400 text-sm">
                                Tidak ditemukan data akun pengguna.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t border-gray-100">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
