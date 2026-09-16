@extends('layouts.admin')

@section('title', 'Profil Administrator')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-red-600 text-white flex items-center justify-center font-black text-lg shadow-md shrink-0">
                {{ $user->initials }}
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Profil Administrator</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Kelola informasi akun pengelola sistem Karate Polindra</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-200">
                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                Akun Administrator
            </span>
        </div>
    </div>

    <!-- Main Profile Form -->
    <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Data Pribadi & Kontak -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-2.5 bg-slate-50/50">
                        <div class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-bold text-slate-800">Informasi Pribadi & Kontak</h2>
                            <p class="text-[11px] text-slate-500">Data identitas diri Administrator</p>
                        </div>
                    </div>

                    <div class="p-6 space-y-4">
                        <!-- Nama Lengkap -->
                        <div>
                            <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                placeholder="Masukkan nama lengkap"
                                class="w-full px-4 py-2.5 rounded-xl border @error('name') border-red-500 bg-red-50/30 @else border-slate-200 bg-slate-50/50 @enderror text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white transition">
                            @error('name')
                                <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email & Nomor HP -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Alamat Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                                    placeholder="admin@email.com"
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
                                Alamat Domisili <span class="text-red-500">*</span>
                            </label>
                            <textarea name="address" id="address" rows="3" required
                                placeholder="Masukkan alamat lengkap..."
                                class="w-full px-4 py-2.5 rounded-xl border @error('address') border-red-500 bg-red-50/30 @else border-slate-200 bg-slate-50/50 @enderror text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white transition resize-none">{{ old('address', $user->address) }}</textarea>
                            @error('address')
                                <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Keamanan & Password -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-2.5 bg-slate-50/50">
                        <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-bold text-slate-800">Keamanan & Kata Sandi</h2>
                            <p class="text-[11px] text-slate-500">Kosongkan jika tidak ingin mengubah kata sandi. Wajib menyertakan kata sandi lama jika ingin memperbarui.</p>
                        </div>
                    </div>

                    <div class="p-6 space-y-4">
                        <div>
                            <label for="current_password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Kata Sandi Saat Ini (Lama)
                            </label>
                            <input type="password" name="current_password" id="current_password"
                                placeholder="Masukkan kata sandi lama Anda saat ini"
                                autocomplete="current-password"
                                class="w-full px-4 py-2.5 rounded-xl border @error('current_password') border-red-500 bg-red-50/30 @else border-slate-200 bg-slate-50/50 @enderror text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white transition">
                            @error('current_password')
                                <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Kata Sandi Baru
                                </label>
                                <input type="password" name="password" id="password"
                                    placeholder="Minimal 6 karakter"
                                    autocomplete="new-password"
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
                                    autocomplete="new-password"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/50 text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white transition">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Summary Card & Action -->
            <div class="space-y-6">
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-4">
                    <div class="text-center space-y-2 pb-4 border-b border-slate-100">
                        <div class="w-16 h-16 rounded-2xl bg-red-600 text-white flex items-center justify-center font-black text-2xl mx-auto shadow-md">
                            {{ $user->initials }}
                        </div>
                        <h3 class="text-sm font-bold text-slate-800">{{ $user->name }}</h3>
                        <p class="text-xs text-slate-500">{{ $user->email }}</p>
                        <span class="inline-block px-3 py-1 rounded-full text-[10px] font-bold bg-slate-900 text-white uppercase tracking-wider">
                            Super Administrator
                        </span>
                    </div>

                    <div class="space-y-3">
                        <button type="submit"
                            class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-brand-primary to-brand-secondary hover:from-brand-primary/90 hover:to-brand-secondary/90 text-white font-bold text-sm shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-brand-primary focus:ring-offset-2 transition-all duration-200 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Simpan Perubahan Profil
                        </button>
                        <a href="{{ route('admin.dashboard') }}"
                            class="w-full py-2.5 px-4 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 font-bold text-xs transition text-center block">
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
