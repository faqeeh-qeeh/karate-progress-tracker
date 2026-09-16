@extends('layouts.senpai')

@section('title', 'Biodata Senpai')

@section('content')
<div class="space-y-6">
    <!-- Page Header Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-brand-primary text-white flex items-center justify-center font-black text-lg shadow-md shrink-0">
                {{ $user->initials }}
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Biodata Pelatih / Senpai</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Kelola data pribadi dan tingkatan sabuk dojo Anda</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            @if($profile->rank)
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-bold bg-slate-900 text-white shadow-xs">
                    <span class="w-2.5 h-2.5 rounded-full" style="background-color: {{ $profile->rank->belt->color_code ?? '#2563eb' }}"></span>
                    {{ $profile->rank->belt->name ?? 'Sabuk' }} - {{ $profile->rank->name }}
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    Sabuk Belum Diatur
                </span>
            @endif
        </div>
    </div>

    <!-- Main Biodata Form -->
    <form action="{{ route('senpai.profile.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: User Data & Password -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Data Pribadi Card -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-2.5 bg-slate-50/50">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 text-brand-primary flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-bold text-slate-800">Informasi Pribadi & Kontak</h2>
                            <p class="text-[11px] text-slate-500">Data identitas utama akun Senpai</p>
                        </div>
                    </div>

                    <div class="p-6 space-y-4">
                        <!-- Nama Lengkap -->
                        <div>
                            <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                placeholder="Masukkan nama lengkap beserta gelar jika ada"
                                class="w-full px-4 py-2.5 rounded-xl border @error('name') border-red-500 bg-red-50/30 @else border-slate-200 bg-slate-50/50 @enderror text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white transition">
                            @error('name')
                                <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email & Nomor HP (Grid 2 Kolom) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Alamat Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                                    placeholder="nama@email.com"
                                    class="w-full px-4 py-2.5 rounded-xl border @error('email') border-red-500 bg-red-50/30 @else border-slate-200 bg-slate-50/50 @enderror text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white transition">
                                @error('email')
                                    <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    No. WhatsApp / HP <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" required
                                    placeholder="Contoh: 08123456789"
                                    class="w-full px-4 py-2.5 rounded-xl border @error('phone') border-red-500 bg-red-50/30 @else border-slate-200 bg-slate-50/50 @enderror text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white transition">
                                @error('phone')
                                    <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Tempat & Tanggal Lahir -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="birth_place" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Tempat Lahir <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="birth_place" id="birth_place" value="{{ old('birth_place', $user->birth_place) }}" required
                                    placeholder="Contoh: Indramayu"
                                    class="w-full px-4 py-2.5 rounded-xl border @error('birth_place') border-red-500 bg-red-50/30 @else border-slate-200 bg-slate-50/50 @enderror text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white transition">
                                @error('birth_place')
                                    <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="birth_date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Tanggal Lahir <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', $user->birth_date?->format('Y-m-d')) }}" required
                                    class="w-full px-4 py-2.5 rounded-xl border @error('birth_date') border-red-500 bg-red-50/30 @else border-slate-200 bg-slate-50/50 @enderror text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white transition text-slate-700">
                                @error('birth_date')
                                    <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div>
                            <label for="gender" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Jenis Kelamin <span class="text-red-500">*</span>
                            </label>
                            <select name="gender" id="gender" required
                                class="w-full px-4 py-2.5 rounded-xl border @error('gender') border-red-500 bg-red-50/30 @else border-slate-200 bg-slate-50/50 @enderror text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white transition">
                                <option value="male" {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="female" {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('gender')
                                <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alamat Lengkap -->
                        <div>
                            <label for="address" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Alamat Domisili Lengkap <span class="text-red-500">*</span>
                            </label>
                            <textarea name="address" id="address" rows="3" required
                                placeholder="Masukkan alamat domisili atau tempat tinggal sekarang..."
                                class="w-full px-4 py-2.5 rounded-xl border @error('address') border-red-500 bg-red-50/30 @else border-slate-200 bg-slate-50/50 @enderror text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white transition resize-none">{{ old('address', $user->address) }}</textarea>
                            @error('address')
                                <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Ubah Password (Opsional) -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-2.5 bg-slate-50/50">
                        <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-bold text-slate-800">Keamanan & Kata Sandi</h2>
                            <p class="text-[11px] text-slate-500">Kosongkan jika tidak ingin mengubah kata sandi akun</p>
                        </div>
                    </div>

                    <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Kata Sandi Baru
                            </label>
                            <input type="password" name="password" id="password"
                                placeholder="Minimal 6 karakter"
                                class="w-full px-4 py-2.5 rounded-xl border @error('password') border-red-500 bg-red-50/30 @else border-slate-200 bg-slate-50/50 @enderror text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white transition">
                            @error('password')
                                <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Konfirmasi Kata Sandi Baru
                            </label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                placeholder="Ulangi kata sandi baru"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/50 text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white transition">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Rank / Tingkat Sabuk & Actions -->
            <div class="space-y-6">
                <!-- Tingkat Sabuk Card -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-2.5 bg-slate-50/50">
                        <div class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-bold text-slate-800">Tingkat Sabuk Senpai</h2>
                            <p class="text-[11px] text-slate-500">Tingkatan sabuk dojo (opsional)</p>
                        </div>
                    </div>

                    <div class="p-6 space-y-4">
                        <!-- 1. Pilihan Sabuk -->
                        <div>
                            <label for="belt_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Sabuk Karate
                            </label>
                            <select id="belt_id" onchange="filterRanks(true)"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/50 text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white transition cursor-pointer">
                                <option value="">-- Belum Menentukan Sabuk --</option>
                                @foreach($belts as $b)
                                    <option value="{{ $b->id }}" {{ (old('rank_id') ? optional($ranks->firstWhere('id', old('rank_id')))->belt_id : optional($profile->rank)->belt_id) == $b->id ? 'selected' : '' }}>
                                        {{ $b->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- 2. Pilihan Tingkatan (Rank) -->
                        <div>
                            <label for="rank_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Tingkatan (Rank)
                            </label>
                            <select name="rank_id" id="rank_id"
                                class="w-full px-4 py-2.5 rounded-xl border @error('rank_id') border-red-500 bg-red-50/30 @else border-slate-200 bg-slate-50/50 @enderror text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white transition cursor-pointer disabled:bg-slate-100/80 disabled:cursor-not-allowed disabled:text-slate-400">
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
                                <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 text-xs text-slate-600 leading-relaxed space-y-1.5">
                            <p class="font-bold text-slate-800 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Informasi Tingkatan
                            </p>
                            <p class="text-[11px] text-slate-500">
                                Tingkatan sabuk Senpai/Pelatih akan dicantumkan pada riwayat raport kumite dan sesi latihan resmi Dojo Karate Polindra.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Submit Button Card -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs space-y-3">
                    <button type="submit"
                        class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-brand-primary to-blue-600 hover:from-brand-primary/90 hover:to-blue-600/90 text-white font-bold text-sm shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-brand-primary focus:ring-offset-2 transition-all duration-200 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Perubahan Biodata
                    </button>
                    <a href="{{ route('senpai.dashboard') }}"
                        class="w-full py-2.5 px-4 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 font-bold text-xs transition text-center block">
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
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
        filterRanks(false);
    });
</script>
@endsection
