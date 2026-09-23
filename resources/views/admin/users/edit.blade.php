@extends('layouts.admin')

@section('title', 'Edit Akun Pengguna')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Back Header -->
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Edit Akun Pengguna</h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">Perbarui informasi profil, alamat email, role, atau data pribadi pengguna</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-200 hover:bg-slate-300 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs font-bold rounded-xl transition whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Edit User Form Card -->
    <div class="bg-white dark:bg-slate-900 p-6 sm:p-8 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- User Info Badge Header -->
            <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-700 flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-slate-900 dark:bg-blue-600 text-white flex items-center justify-center font-extrabold text-sm shrink-0 shadow-xs">
                    {{ substr($user->name, 0, 2) }}
                </div>
                <div class="min-w-0">
                    <p class="text-[11px] font-bold text-slate-400 dark:text-slate-400 uppercase tracking-wider">Mengedit Akun ID #{{ $user->id }}</p>
                    <p class="text-sm font-extrabold text-slate-900 dark:text-white truncate">{{ $user->name }} <span class="text-slate-500 dark:text-slate-400 font-normal">({{ $user->email }})</span></p>
                </div>
            </div>

            <!-- Name Field -->
            <div>
                <label for="name" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Nama Lengkap Pengguna</label>
                <div class="relative rounded-xl">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                        class="w-full pl-10 pr-4 py-3 rounded-xl border @error('name') border-red-500 bg-red-50/30 text-red-900 dark:text-red-400 @else border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/80 text-slate-900 dark:text-white @enderror text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition">
                </div>
                @error('name')
                    <p class="text-xs text-red-600 dark:text-red-400 mt-1.5 font-medium flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Alamat Email</label>
                <div class="relative rounded-xl">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                        class="w-full pl-10 pr-4 py-3 rounded-xl border @error('email') border-red-500 bg-red-50/30 text-red-900 dark:text-red-400 @else border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/80 text-slate-900 dark:text-white @enderror text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition">
                </div>
                @error('email')
                    <p class="text-xs text-red-600 dark:text-red-400 mt-1.5 font-medium flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Role Selection -->
            <div>
                <label for="role_id" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Role / Hak Akses</label>
                <div class="relative rounded-xl">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <select name="role_id" id="role_id" required onchange="handleRoleChange(this)"
                        class="w-full pl-10 pr-10 py-3 rounded-xl border @error('role_id') border-red-500 bg-red-50/30 text-red-900 dark:text-red-400 @else border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/80 text-slate-900 dark:text-white @enderror text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition appearance-none cursor-pointer">
                        @foreach($roles as $r)
                            <option value="{{ $r->id }}" data-role-name="{{ strtolower($r->nama) }}" class="dark:bg-slate-800 dark:text-white" {{ old('role_id', $user->role_id) == $r->id ? 'selected' : '' }}>
                                Role: {{ $r->nama }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>
                @error('role_id')
                    <p class="text-xs text-red-600 dark:text-red-400 mt-1.5 font-medium flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Opsi Kategori Asal Kohai (Dinamis Muncul Ketika Role Kohai Dipilih) -->
            @php
                $currentKohaiType = old('kohai_type', $user->kohaiProfile->type ?? 'polindra');
            @endphp
            <div id="kohai-type-container" class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/90 dark:border-slate-700 space-y-3 hidden transition-all">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-brand-primary"></span>
                    <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider">
                        Kategori Asal Keanggotaan Kohai <span class="text-red-500">*</span>
                    </label>
                </div>
                <p class="text-[11px] text-slate-500 dark:text-slate-400">
                    Tentukan apakah Kohai ini merupakan mahasiswa/sivitas Polindra atau berasal dari luar kampus (sekolah lain/instansi). Opsi ini akan menentukan formulir biodata yang diisi oleh Kohai.
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                    <label class="relative flex items-start gap-3 p-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 hover:border-brand-primary cursor-pointer transition has-[:checked]:border-brand-primary has-[:checked]:bg-blue-50/40 dark:has-[:checked]:bg-blue-950/30 has-[:checked]:ring-2 has-[:checked]:ring-brand-primary/20">
                        <input type="radio" name="kohai_type" value="polindra" {{ $currentKohaiType === 'polindra' ? 'checked' : '' }} class="mt-0.5 text-brand-primary focus:ring-brand-primary">
                        <div class="text-left">
                            <span class="block text-xs font-bold text-slate-900 dark:text-white">Mahasiswa / Sivitas Polindra</span>
                            <span class="block text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Wajib isi Prodi, Kelas, NIM, Tahun Angkatan & Asal SMA/SMK.</span>
                        </div>
                    </label>
                    <label class="relative flex items-start gap-3 p-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 hover:border-amber-500 cursor-pointer transition has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50/40 dark:has-[:checked]:bg-amber-950/30 has-[:checked]:ring-2 has-[:checked]:ring-amber-500/20">
                        <input type="radio" name="kohai_type" value="non_polindra" {{ $currentKohaiType === 'non_polindra' ? 'checked' : '' }} class="mt-0.5 text-amber-600 focus:ring-amber-500">
                        <div class="text-left">
                            <span class="block text-xs font-bold text-slate-900 dark:text-white">Luar Polindra / Instansi Lain</span>
                            <span class="block text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Wajib mengisi Asal Sekolah / Instansi luar.</span>
                        </div>
                    </label>
                </div>
                @error('kohai_type')
                    <p class="text-xs text-red-600 dark:text-red-400 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tempat & Tanggal Lahir (Grid 2 Kolom) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Birth Place -->
                <div>
                    <label for="birth_place" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Tempat Lahir</label>
                    <div class="relative rounded-xl">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <input type="text" name="birth_place" id="birth_place" value="{{ old('birth_place', $user->birth_place) }}" required
                            placeholder="Contoh: Indramayu"
                            class="w-full pl-10 pr-4 py-3 rounded-xl border @error('birth_place') border-red-500 bg-red-50/30 text-red-900 dark:text-red-400 @else border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/80 text-slate-900 dark:text-white @enderror text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition">
                    </div>
                    @error('birth_place')
                        <p class="text-xs text-red-600 dark:text-red-400 mt-1.5 font-medium flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Birth Date -->
                <div>
                    <label for="birth_date" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Tanggal Lahir</label>
                    <div class="relative rounded-xl">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', $user->birth_date ? $user->birth_date->format('Y-m-d') : '') }}" required
                            class="w-full pl-10 pr-4 py-3 rounded-xl border @error('birth_date') border-red-500 bg-red-50/30 text-red-900 dark:text-red-400 @else border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/80 text-slate-900 dark:text-white @enderror text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition text-slate-700 dark:text-slate-300">
                    </div>
                    @error('birth_date')
                        <p class="text-xs text-red-600 dark:text-red-400 mt-1.5 font-medium flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Jenis Kelamin & Kontak (Grid 2 Kolom) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Gender -->
                <div>
                    <label for="gender" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Jenis Kelamin</label>
                    <div class="relative rounded-xl">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <select name="gender" id="gender" required
                            class="w-full pl-10 pr-10 py-3 rounded-xl border @error('gender') border-red-500 bg-red-50/30 text-red-900 dark:text-red-400 @else border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/80 text-slate-900 dark:text-white @enderror text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition appearance-none cursor-pointer">
                            <option value="male" class="dark:bg-slate-800 dark:text-white" {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="female" class="dark:bg-slate-800 dark:text-white" {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                    @error('gender')
                        <p class="text-xs text-red-600 dark:text-red-400 mt-1.5 font-medium flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Phone / Contact -->
                <div>
                    <label for="phone" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">No. Kontak / WhatsApp</label>
                    <div class="relative rounded-xl">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <input type="tel" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" required
                            placeholder="Contoh: 08123456789"
                            class="w-full pl-10 pr-4 py-3 rounded-xl border @error('phone') border-red-500 bg-red-50/30 text-red-900 dark:text-red-400 @else border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/80 text-slate-900 dark:text-white @enderror text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition placeholder:text-slate-400 dark:placeholder:text-slate-500">
                    </div>
                    @error('phone')
                        <p class="text-xs text-red-600 dark:text-red-400 mt-1.5 font-medium flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Address Field -->
            <div>
                <label for="address" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Alamat Lengkap</label>
                <div class="relative rounded-xl">
                    <textarea name="address" id="address" rows="2" required
                        placeholder="Masukkan alamat domisili atau tempat tinggal lengkap..."
                        class="w-full px-4 py-3 rounded-xl border @error('address') border-red-500 bg-red-50/30 text-red-900 dark:text-red-400 @else border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/80 text-slate-900 dark:text-white @enderror text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white dark:focus:bg-slate-800 transition placeholder:text-slate-400 dark:placeholder:text-slate-500 resize-none">{{ old('address', $user->address) }}</textarea>
                </div>
                @error('address')
                    <p class="text-xs text-red-600 dark:text-red-400 mt-1.5 font-medium flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3">
                <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs font-bold transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-brand-primary to-brand-secondary hover:from-brand-primary/90 hover:to-brand-secondary/90 text-white font-bold text-sm shadow-md shadow-brand-primary/20 hover:shadow-lg transition-all active:scale-[0.99]">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function handleRoleChange(selectElement) {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const roleName = selectedOption ? selectedOption.getAttribute('data-role-name') : '';
        const kohaiContainer = document.getElementById('kohai-type-container');
        
        if (kohaiContainer) {
            if (roleName === 'kohai') {
                kohaiContainer.classList.remove('hidden');
            } else {
                kohaiContainer.classList.add('hidden');
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const roleSelect = document.getElementById('role_id');
        if (roleSelect) {
            handleRoleChange(roleSelect);
        }
    });
</script>
@endsection
