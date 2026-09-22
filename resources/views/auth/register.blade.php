@extends('layouts.auth')

@section('title', 'Tata Cara Registrasi Anggota Baru')
@section('card-width', 'max-w-3xl')

@section('content')
<div class="space-y-8">
    <!-- Header Banner -->
    <div class="text-center space-y-2 border-b border-slate-100 pb-6">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand-primary/10 text-brand-primary text-xs font-semibold tracking-wide">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Panduan Pendaftaran Akun
        </div>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
            Tata Cara Registrasi Anggota
        </h2>
        <p class="text-xs sm:text-sm text-slate-500 max-w-xl mx-auto leading-relaxed">
            Untuk menjaga validitas data anggota, pendaftaran akun dikelola langsung oleh <strong>Admin Karate Polindra</strong>. Ikuti tahapan di bawah ini untuk mengajukan pembuatan akun.
        </p>
    </div>

    <!-- Steps Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- Step 1 -->
        <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-200/80 flex items-start gap-3.5 hover:border-brand-primary/30 transition-all">
            <div class="w-8 h-8 rounded-xl bg-brand-primary text-white font-bold text-sm flex items-center justify-center shrink-0 shadow-sm">
                1
            </div>
            <div>
                <h4 class="text-sm font-bold text-slate-900">Siapkan Data Diri</h4>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                    Siapkan data identitas seperti nama lengkap, tempat/tanggal lahir, kontak WhatsApp aktif, dan riwayat sabuk.
                </p>
            </div>
        </div>

        <!-- Step 2 -->
        <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-200/80 flex items-start gap-3.5 hover:border-brand-primary/30 transition-all">
            <div class="w-8 h-8 rounded-xl bg-brand-primary text-white font-bold text-sm flex items-center justify-center shrink-0 shadow-sm">
                2
            </div>
            <div>
                <h4 class="text-sm font-bold text-slate-900">Lengkapi Format Pesan</h4>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                    Gunakan template format email yang sudah disiapkan di bawah. Cukup sesuaikan bagian di dalam tanda <code class="bg-slate-200/80 px-1 py-0.5 rounded text-[11px] text-slate-700">[ ... ]</code>.
                </p>
            </div>
        </div>

        <!-- Step 3 -->
        <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-200/80 flex items-start gap-3.5 hover:border-brand-primary/30 transition-all">
            <div class="w-8 h-8 rounded-xl bg-brand-primary text-white font-bold text-sm flex items-center justify-center shrink-0 shadow-sm">
                3
            </div>
            <div>
                <h4 class="text-sm font-bold text-slate-900">Kirim Email ke Admin</h4>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                    Kirim pesan ke <strong class="text-slate-800">karatepolindra@gmail.com</strong> via tombol langsung Gmail atau salin format teks.
                </p>
            </div>
        </div>

        <!-- Step 4 -->
        <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-200/80 flex items-start gap-3.5 hover:border-brand-primary/30 transition-all">
            <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white font-bold text-sm flex items-center justify-center shrink-0 shadow-sm">
                4
            </div>
            <div>
                <h4 class="text-sm font-bold text-slate-900">Aktivasi & Mulai Login</h4>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                    Setelah admin memverifikasi data, Anda akan menerima email aktivasi untuk membuat password dan masuk ke sistem.
                </p>
            </div>
        </div>
    </div>

    <!-- Interactive Quick Form (Optional live editor) -->
    <div class="rounded-2xl border border-slate-200 bg-white overflow-hidden shadow-sm">
        <div class="p-4 sm:p-5 bg-gradient-to-r from-slate-900 to-slate-800 text-white flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center text-brand-secondary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-white">Format Email Pendaftaran</h3>
                    <p class="text-[11px] sm:text-xs text-slate-300">Tujuan: <span class="text-brand-secondary font-semibold">karatepolindra@gmail.com</span></p>
                </div>
            </div>

            <!-- Toggle Live Input Form Button -->
            <button type="button" id="toggle-form-btn" onclick="toggleQuickForm()"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-xs font-medium text-white transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <span id="toggle-form-text">Isi Data Langsung (Opsional)</span>
            </button>
        </div>

        <!-- Optional Live Input Fields -->
        <div id="quick-form-container" class="hidden p-5 bg-slate-50 border-b border-slate-200">
            <div class="mb-3">
                <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Form Pengisian Cepat</span>
                <p class="text-xs text-slate-500">Ketik data Anda di bawah ini untuk mengisi format pesan secara otomatis, atau biarkan kosong jika ingin mengubahnya langsung di Gmail.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Nama Lengkap</label>
                    <input type="text" id="input_name" oninput="updateMessagePreview()" placeholder="Contoh: Muhammad Ali"
                        class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-brand-primary">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">NIM (Bila Mahasiswa Polindra)</label>
                    <input type="text" id="input_nim" oninput="updateMessagePreview()" placeholder="Contoh: 2201001 / -"
                        class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-brand-primary">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Jurusan / Program Studi</label>
                    <input type="text" id="input_major" oninput="updateMessagePreview()" placeholder="Contoh: Teknik Informatika"
                        class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-brand-primary">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Kelas</label>
                    <input type="text" id="input_class" oninput="updateMessagePreview()" placeholder="Contoh: D4-RPL-1A / -"
                        class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-brand-primary">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Tempat, Tanggal Lahir</label>
                    <input type="text" id="input_birth" oninput="updateMessagePreview()" placeholder="Contoh: Indramayu, 15 Januari 2004"
                        class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-brand-primary">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Jenis Kelamin</label>
                    <select id="input_gender" onchange="updateMessagePreview()"
                        class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-brand-primary">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">No. WhatsApp Aktif</label>
                    <input type="text" id="input_phone" oninput="updateMessagePreview()" placeholder="Contoh: 081234567890"
                        class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-brand-primary">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Tingkatan Sabuk Saat Ini</label>
                    <input type="text" id="input_belt" oninput="updateMessagePreview()" placeholder="Contoh: Pemula / Sabuk Putih / Kuning"
                        class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-brand-primary">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Alamat Lengkap / Domisili</label>
                    <input type="text" id="input_address" oninput="updateMessagePreview()" placeholder="Contoh: Jl. Mayor Dasuki No. 12, Indramayu"
                        class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-brand-primary">
                </div>
            </div>
        </div>

        <!-- Message Body Preview Box -->
        <div class="p-5 space-y-4">
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Subjek Email:</label>
                    <span class="text-[11px] text-slate-400">Otomatis Terisi</span>
                </div>
                <div class="px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-medium text-slate-800 font-mono" id="subject-preview">
                    Pendaftaran Anggota Baru Karate Polindra - [Nama Anda]
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Pratinjau Isi Pesan:</label>
                    <button type="button" onclick="copyMessageTemplate()" id="copy-btn-top"
                        class="inline-flex items-center gap-1 text-xs font-bold text-brand-primary hover:text-brand-secondary transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        <span id="copy-btn-text">Salin Teks Pesan</span>
                    </button>
                </div>
                <div class="relative">
                    <textarea id="message-body" rows="12" readonly
                        class="w-full p-4 rounded-xl bg-slate-900 text-slate-100 font-mono text-xs leading-relaxed border border-slate-800 focus:outline-none focus:ring-2 focus:ring-brand-primary resize-none selection:bg-brand-primary selection:text-white"></textarea>
                </div>
            </div>
        </div>

        <!-- Action Buttons Section -->
        <div class="p-5 bg-slate-50/80 border-t border-slate-200/80 space-y-3">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <!-- Direct Gmail Web Compose Button -->
                <a id="btn-gmail-compose" href="#" target="_blank" rel="noopener noreferrer"
                    class="flex items-center justify-center gap-2.5 py-3.5 px-4 rounded-xl bg-gradient-to-r from-red-600 to-red-500 hover:from-red-500 hover:to-red-600 text-white font-bold text-xs sm:text-sm shadow-md hover:shadow-lg transition-all duration-200">
                    <svg class="w-5 h-5 fill-current shrink-0" viewBox="0 0 24 24">
                        <path d="M24 5.457v13.909c0 .904-.732 1.636-1.636 1.636h-3.819V11.73L12 16.64l-6.545-4.91v9.272H1.636A1.636 1.636 0 0 1 0 19.366V5.457c0-2.023 2.309-3.178 3.927-1.964L5.455 4.64 12 9.548l6.545-4.91 1.528-1.145C21.69 2.28 24 3.434 24 5.457z"/>
                    </svg>
                    <span>Buka Langsung di Gmail</span>
                </a>

                <!-- Fallback Mailto Client Button -->
                <a id="btn-mailto-compose" href="#"
                    class="flex items-center justify-center gap-2 py-3.5 px-4 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs sm:text-sm shadow-md hover:shadow-lg transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span>Buka di Aplikasi Email</span>
                </a>
            </div>

            <!-- Copy Action Full Width -->
            <button type="button" onclick="copyMessageTemplate()"
                class="w-full flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl bg-white hover:bg-slate-100 text-slate-700 font-semibold text-xs border border-slate-300 shadow-sm transition-all">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
                <span id="copy-btn-text-full">Salin Format Teks ke Papan Klip (Clipboard)</span>
            </button>
        </div>
    </div>

    <!-- Important Notice Box -->
    <div class="rounded-2xl bg-amber-50 border border-amber-200/80 p-4 sm:p-5 flex items-start gap-3.5">
        <div class="w-8 h-8 rounded-xl bg-amber-500 text-white flex items-center justify-center shrink-0 mt-0.5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
        <div class="space-y-1">
            <h4 class="text-xs sm:text-sm font-bold text-amber-900">Catatan Penting Pendaftaran:</h4>
            <ul class="text-xs text-amber-800 space-y-1 list-disc list-inside leading-relaxed">
                <li>Pastikan email pengirim yang Anda gunakan adalah email aktif, karena tautan aktivasi akun akan dikirimkan ke alamat tersebut.</li>
                <li>Proses pembuatan akun oleh Admin biasanya memerlukan waktu <strong>1x24 jam</strong> pada hari kerja.</li>
                <li>Jika sudah menerima email aktivasi, buka tautan tersebut untuk mengatur kata sandi awal akun Anda.</li>
            </ul>
        </div>
    </div>

    <!-- Navigation Footer -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-slate-200 text-xs">
        <a href="{{ route('landing') }}" class="inline-flex items-center gap-1 text-slate-500 hover:text-slate-800 transition-colors font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Beranda
        </a>

        <div class="text-slate-500">
            Sudah memiliki akun?
            <a href="{{ route('login') }}" class="font-bold text-brand-primary hover:text-brand-secondary transition-colors underline-offset-2 hover:underline ml-1">
                Masuk ke Sistem &rarr;
            </a>
        </div>
    </div>
</div>

<!-- Copy Notification Toast -->
<div id="copy-toast" class="fixed bottom-6 right-6 z-50 transform translate-y-20 opacity-0 transition-all duration-300 pointer-events-none">
    <div class="bg-slate-900 text-white px-4 py-3 rounded-xl shadow-2xl flex items-center gap-2.5 border border-slate-700">
        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <span class="text-xs font-semibold">Format pesan berhasil disalin ke clipboard!</span>
    </div>
</div>

<script>
    const targetEmail = "karatepolindra@gmail.com";

    function generateMessageText() {
        const nameVal = document.getElementById('input_name')?.value.trim() || '[Nama Anda]';
        const nimVal = document.getElementById('input_nim')?.value.trim() || '[NIM Anda / - jika Umum]';
        const majorVal = document.getElementById('input_major')?.value.trim() || '[Jurusan & Program Studi / -]';
        const classVal = document.getElementById('input_class')?.value.trim() || '[Kelas / -]';
        const birthVal = document.getElementById('input_birth')?.value.trim() || '[Kota Lahir, Tanggal-Bulan-Tahun]';
        const genderVal = document.getElementById('input_gender')?.value || '[Laki-laki / Perempuan]';
        const phoneVal = document.getElementById('input_phone')?.value.trim() || '[08xxxxxxxxxx]';
        const beltVal = document.getElementById('input_belt')?.value.trim() || '[Pemula / Putih / Kuning / Hijau / Biru / Coklat / Hitam]';
        const addressVal = document.getElementById('input_address')?.value.trim() || '[Alamat Lengkap Tempat Tinggal / Domisili]';

        const subject = `Pendaftaran Anggota Baru Karate Polindra - ${nameVal}`;

        const body = `Halo Admin Karate Polindra,

Saya bermaksud untuk mendaftar sebagai anggota baru Karate Polindra dan memohon pembuatan akun pada sistem Karate Tracker. Berikut adalah data diri saya:

• Nama Lengkap: ${nameVal}
• NIM (Mahasiswa Polindra): ${nimVal}
• Jurusan / Program Studi: ${majorVal}
• Kelas: ${classVal}
• Tempat, Tanggal Lahir: ${birthVal}
• Jenis Kelamin: ${genderVal}
• No. WhatsApp / HP Aktif: ${phoneVal}
• Alamat Lengkap / Domisili: ${addressVal}
• Tingkatan Sabuk Saat Ini: ${beltVal}
• Pengalaman / Riwayat Karate (jika ada): [Nama Dojo/Perguruan Sebelumnya / Pemula]

Catatan / Pesan Tambahan:
[Tuliskan catatan tambahan di sini jika ada]

Demikian data pendaftaran ini saya sampaikan dengan sebenar-benarnya. Mohon bantuannya untuk proses pendaftaran akun saya.
Terima kasih.

Salam hormat,
${nameVal}`;

        return { subject, body, nameVal };
    }

    function updateMessagePreview() {
        const { subject, body } = generateMessageText();
        
        // Update textarea preview
        document.getElementById('message-body').value = body;
        document.getElementById('subject-preview').innerText = subject;

        // Update URLs
        const encodedSubject = encodeURIComponent(subject);
        const encodedBody = encodeURIComponent(body);

        // Gmail compose web link
        const gmailUrl = `https://mail.google.com/mail/?view=cm&fs=1&to=${encodeURIComponent(targetEmail)}&su=${encodedSubject}&body=${encodedBody}`;
        document.getElementById('btn-gmail-compose').setAttribute('href', gmailUrl);

        // Mailto link
        const mailtoUrl = `mailto:${targetEmail}?subject=${encodedSubject}&body=${encodedBody}`;
        document.getElementById('btn-mailto-compose').setAttribute('href', mailtoUrl);
    }

    function toggleQuickForm() {
        const container = document.getElementById('quick-form-container');
        const textSpan = document.getElementById('toggle-form-text');
        if (container.classList.contains('hidden')) {
            container.classList.remove('hidden');
            textSpan.innerText = 'Sembunyikan Form';
        } else {
            container.classList.add('hidden');
            textSpan.innerText = 'Isi Data Langsung (Opsional)';
        }
    }

    function copyMessageTemplate() {
        const { body } = generateMessageText();
        navigator.clipboard.writeText(body).then(() => {
            showToast();
        }).catch(() => {
            // Fallback
            const textarea = document.getElementById('message-body');
            textarea.select();
            document.execCommand('copy');
            showToast();
        });
    }

    function showToast() {
        const toast = document.getElementById('copy-toast');
        toast.classList.remove('translate-y-20', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');

        setTimeout(() => {
            toast.classList.remove('translate-y-0', 'opacity-100');
            toast.classList.add('translate-y-20', 'opacity-0');
        }, 3000);
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', () => {
        updateMessagePreview();
    });
</script>
@endsection
