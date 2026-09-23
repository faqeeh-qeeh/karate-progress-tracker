@extends('layouts.auth')

@section('title', 'Tata Cara Registrasi')
@section('card-width', 'max-w-2xl')

@section('content')
<div class="flex flex-col gap-6 sm:gap-7">

    {{-- Header --}}
    <div>
        <div class="inline-flex items-center gap-2 mb-3">
            <div style="width:28px;height:2px;background:linear-gradient(to right,#c8102e,#1a56c9);"></div>
            <span style="font-size:11px;font-weight:700;letter-spacing:0.18em;text-transform:uppercase;color:#1a56c9;">
                Panduan Pendaftaran
            </span>
        </div>
        <h1 style="font-family:'Bebas Neue',sans-serif;font-size:clamp(28px,3.5vw,38px);letter-spacing:0.04em;color:#0a0a12;line-height:1.05;margin-bottom:8px;">
            TATA CARA<br>REGISTRASI ANGGOTA
        </h1>
        <p class="text-sm text-slate-500 leading-relaxed max-w-lg">
            Pendaftaran akun dikelola langsung oleh <strong class="text-slate-700">Admin Karate Polindra</strong> untuk menjaga validitas data anggota.
        </p>
    </div>

    {{-- Steps --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">

        {{-- Step 1 --}}
        <div class="flex items-start gap-3.5 p-4 rounded-xl border border-slate-200/80 bg-slate-50/70 hover:border-red-200 hover:bg-red-50/30 transition-all group">
            <div class="w-8 h-8 rounded-lg step-badge-red text-white font-bold text-sm flex items-center justify-center shrink-0 shadow-xs">
                1
            </div>
            <div>
                <h4 class="text-sm font-bold text-slate-800 group-hover:text-slate-900">Siapkan Data Diri</h4>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                    Nama lengkap, tempat/tanggal lahir, kontak WhatsApp aktif, dan riwayat sabuk.
                </p>
            </div>
        </div>

        {{-- Step 2 --}}
        <div class="flex items-start gap-3.5 p-4 rounded-xl border border-slate-200/80 bg-slate-50/70 hover:border-blue-200 hover:bg-blue-50/30 transition-all group">
            <div class="w-8 h-8 rounded-lg step-badge-blue text-white font-bold text-sm flex items-center justify-center shrink-0 shadow-xs">
                2
            </div>
            <div>
                <h4 class="text-sm font-bold text-slate-800 group-hover:text-slate-900">Lengkapi Format Pesan</h4>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                    Gunakan template di bawah. Sesuaikan bagian dalam tanda
                    <code class="bg-slate-200 px-1 py-0.5 rounded text-[10px] text-slate-700">[ ... ]</code>.
                </p>
            </div>
        </div>

        {{-- Step 3 --}}
        <div class="flex items-start gap-3.5 p-4 rounded-xl border border-slate-200/80 bg-slate-50/70 hover:border-red-200 hover:bg-red-50/30 transition-all group">
            <div class="w-8 h-8 rounded-lg step-badge-red text-white font-bold text-sm flex items-center justify-center shrink-0 shadow-xs">
                3
            </div>
            <div>
                <h4 class="text-sm font-bold text-slate-800 group-hover:text-slate-900">Kirim Email ke Admin</h4>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                    Kirim ke <strong class="text-slate-700">karatepolindra@gmail.com</strong> via tombol langsung Gmail atau salin format teks.
                </p>
            </div>
        </div>

        {{-- Step 4 --}}
        <div class="flex items-start gap-3.5 p-4 rounded-xl border border-slate-200/80 bg-slate-50/70 hover:border-blue-200 hover:bg-blue-50/30 transition-all group">
            <div class="w-8 h-8 rounded-lg step-badge-blue text-white font-bold text-sm flex items-center justify-center shrink-0 shadow-xs">
                ✓
            </div>
            <div>
                <h4 class="text-sm font-bold text-slate-800 group-hover:text-slate-900">Aktivasi & Mulai Login</h4>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                    Setelah admin verifikasi, Anda menerima email aktivasi untuk membuat password.
                </p>
            </div>
        </div>
    </div>

    {{-- Email Template Card --}}
    <div class="rounded-2xl border border-slate-200 bg-white overflow-hidden shadow-sm flex flex-col">

        {{-- Card header --}}
        <div class="px-5 py-4 flex flex-wrap items-center justify-between gap-3"
             style="background:#06080f;">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center"
                     style="background:rgba(200,16,46,0.15);">
                    <svg class="w-5 h-5" fill="none" stroke="#c8102e" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-white">Format Email Pendaftaran</h3>
                    <p style="font-size:11px;color:rgba(220,228,255,0.5);">
                        Tujuan: <span style="color:#4d8cff;font-weight:600;">karatepolindra@gmail.com</span>
                    </p>
                </div>
            </div>

            <button type="button" id="toggle-form-btn" onclick="toggleQuickForm()"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-white transition-all cursor-pointer"
                    style="background:rgba(255,255,255,0.08);"
                    onmouseover="this.style.background='rgba(255,255,255,0.14)'"
                    onmouseout="this.style.background='rgba(255,255,255,0.08)'">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                <span id="toggle-form-text">Isi Data Langsung (Opsional)</span>
            </button>
        </div>

        {{-- Optional Live Input Fields --}}
        <div id="quick-form-container" class="hidden p-5 border-b border-slate-100" style="background:#f8faff;">
            <p class="text-xs text-slate-500 mb-3">
                <strong class="text-slate-700">Form Pengisian Cepat</strong> —
                Ketik data Anda di bawah untuk mengisi template secara otomatis.
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @php
                $fields = [
                    ['id'=>'input_name',    'label'=>'Nama Lengkap',             'placeholder'=>'Contoh: Muhammad Ali'],
                    ['id'=>'input_nim',     'label'=>'NIM (Mahasiswa Polindra)', 'placeholder'=>'Contoh: 2201001 / -'],
                    ['id'=>'input_major',   'label'=>'Jurusan / Prodi',          'placeholder'=>'Contoh: Teknik Informatika'],
                    ['id'=>'input_class',   'label'=>'Kelas',                    'placeholder'=>'Contoh: D4-RPL-1A / -'],
                    ['id'=>'input_birth',   'label'=>'Tempat, Tanggal Lahir',    'placeholder'=>'Contoh: Indramayu, 15 Jan 2004'],
                    ['id'=>'input_phone',   'label'=>'No. WhatsApp Aktif',       'placeholder'=>'Contoh: 081234567890'],
                    ['id'=>'input_belt',    'label'=>'Tingkatan Sabuk',          'placeholder'=>'Contoh: Pemula / Putih / Kuning'],
                ];
                @endphp

                @foreach($fields as $f)
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-1">{{ $f['label'] }}</label>
                        <input type="text" id="{{ $f['id'] }}" oninput="updateMessagePreview()"
                               placeholder="{{ $f['placeholder'] }}"
                               class="w-full px-3 py-2 text-xs rounded-lg border border-slate-200 bg-white focus:outline-none transition"
                               style="color:#1e293b;"
                               onfocus="this.style.borderColor='#1a56c9';this.style.boxShadow='0 0 0 3px rgba(26,86,201,0.1)'"
                               onblur="this.style.borderColor='';this.style.boxShadow=''">
                    </div>
                @endforeach

                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Jenis Kelamin</label>
                    <select id="input_gender" onchange="updateMessagePreview()"
                            class="w-full px-3 py-2 text-xs rounded-lg border border-slate-200 bg-white focus:outline-none transition"
                            style="color:#1e293b;"
                            onfocus="this.style.borderColor='#1a56c9';this.style.boxShadow='0 0 0 3px rgba(26,86,201,0.1)'"
                            onblur="this.style.borderColor='';this.style.boxShadow=''">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option>Laki-laki</option>
                        <option>Perempuan</option>
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Alamat Lengkap / Domisili</label>
                    <input type="text" id="input_address" oninput="updateMessagePreview()"
                           placeholder="Contoh: Jl. Mayor Dasuki No. 12, Indramayu"
                           class="w-full px-3 py-2 text-xs rounded-lg border border-slate-200 bg-white focus:outline-none transition"
                           style="color:#1e293b;"
                           onfocus="this.style.borderColor='#1a56c9';this.style.boxShadow='0 0 0 3px rgba(26,86,201,0.1)'"
                           onblur="this.style.borderColor='';this.style.boxShadow=''">
                </div>
            </div>
        </div>

        {{-- Message Preview --}}
        <div class="p-5 flex flex-col gap-4">
            {{-- Subject --}}
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label class="text-xs font-bold text-slate-600 uppercase tracking-wider">Subjek Email</label>
                    <span class="text-[10px] text-slate-400">Otomatis Terisi</span>
                </div>
                <div id="subject-preview"
                     class="px-3.5 py-2.5 rounded-lg bg-slate-50 border border-slate-200 text-xs font-mono text-slate-700">
                    Pendaftaran Anggota Baru Karate Polindra - [Nama Anda]
                </div>
            </div>

            {{-- Body --}}
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label class="text-xs font-bold text-slate-600 uppercase tracking-wider">Isi Pesan</label>
                    <button type="button" onclick="copyMessageTemplate()" id="copy-btn-top"
                            class="inline-flex items-center gap-1 text-xs font-bold transition-colors link-ao hover:underline underline-offset-2 cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        <span id="copy-btn-text">Salin Teks</span>
                    </button>
                </div>
                <textarea id="message-body" rows="11" readonly
                          class="w-full p-4 rounded-xl font-mono text-xs leading-relaxed resize-none focus:outline-none border border-slate-800"
                          style="background:#06080f;color:#c8d3ef;selection:background:#c8102e;"></textarea>
            </div>
        </div>

        {{-- Action buttons --}}
        <div class="px-5 pb-5 pt-1 flex flex-col gap-2.5">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                {{-- Gmail --}}
                <a id="btn-gmail-compose" href="#" target="_blank" rel="noopener noreferrer"
                   class="flex items-center justify-center gap-2.5 py-3 px-4 rounded-xl text-white font-bold text-sm transition-all duration-200 shadow-sm"
                   style="background:#c8102e;"
                   onmouseover="this.style.background='#e0132f';this.style.boxShadow='0 6px 20px rgba(200,16,46,0.3)';this.style.transform='translateY(-1px)'"
                   onmouseout="this.style.background='#c8102e';this.style.boxShadow='';this.style.transform=''">
                    <svg class="fill-current shrink-0" width="18" height="18" viewBox="0 0 24 24">
                        <path d="M24 5.457v13.909c0 .904-.732 1.636-1.636 1.636h-3.819V11.73L12 16.64l-6.545-4.91v9.272H1.636A1.636 1.636 0 0 1 0 19.366V5.457c0-2.023 2.309-3.178 3.927-1.964L5.455 4.64 12 9.548l6.545-4.91 1.528-1.145C21.69 2.28 24 3.434 24 5.457z"/>
                    </svg>
                    Buka di Gmail
                </a>

                {{-- Mailto --}}
                <a id="btn-mailto-compose" href="#"
                   class="flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-white font-bold text-sm transition-all duration-200 shadow-sm"
                   style="background:#1a56c9;"
                   onmouseover="this.style.background='#1d4ed8';this.style.boxShadow='0 6px 20px rgba(26,86,201,0.3)';this.style.transform='translateY(-1px)'"
                   onmouseout="this.style.background='#1a56c9';this.style.boxShadow='';this.style.transform=''">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Buka di Aplikasi Email
                </a>
            </div>

            {{-- Copy full --}}
            <button type="button" onclick="copyMessageTemplate()"
                    class="w-full flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 font-semibold text-xs transition-all cursor-pointer">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
                <span id="copy-btn-text-full">Salin Format Teks ke Clipboard</span>
            </button>
        </div>
    </div>

    {{-- Notice --}}
    <div class="rounded-2xl border border-amber-200/90 bg-amber-50/90 p-4.5 flex items-start gap-3.5 shadow-2xs">
        <div class="w-8 h-8 rounded-lg bg-amber-500 text-white flex items-center justify-center shrink-0 mt-0.5 text-sm font-bold shadow-xs">!</div>
        <div>
            <h4 class="text-xs font-bold text-amber-900">Catatan Penting:</h4>
            <ul class="text-xs text-amber-800 space-y-1 list-disc list-inside leading-relaxed mt-1">
                <li>Gunakan email aktif — tautan aktivasi dikirim ke sana.</li>
                <li>Proses pembuatan akun biasanya <strong>1×24 jam</strong> hari kerja.</li>
                <li>Buka tautan aktivasi di email untuk mengatur password awal.</li>
            </ul>
        </div>
    </div>

    {{-- Navigation footer --}}
    <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-4 border-t border-slate-200 text-xs">
        <a href="{{ route('landing') }}" id="back-to-landing"
           class="inline-flex items-center gap-1.5 text-slate-400 hover:text-slate-700 transition-colors font-medium">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Beranda
        </a>
        <div class="text-slate-400">
            Sudah punya akun?
            <a href="{{ route('login') }}" id="goto-login-link"
               class="font-bold link-ao hover:underline underline-offset-2 transition-colors ml-1">
                Masuk ke Sistem →
            </a>
        </div>
    </div>

</div>

{{-- Toast --}}
<div id="copy-toast" class="fixed bottom-6 right-6 z-50 pointer-events-none"
     style="opacity:0;transform:translateY(20px);transition:all 0.3s cubic-bezier(0.16,1,0.3,1);">
    <div class="flex items-center gap-2.5 px-4 py-3 rounded-xl shadow-2xl border"
         style="background:#06080f;border-color:rgba(255,255,255,0.08);">
        <svg class="w-4 h-4" fill="none" stroke="#22c55e" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        <span class="text-xs font-semibold text-white">Format berhasil disalin!</span>
    </div>
</div>

<script>
const targetEmail = "karatepolindra@gmail.com";

function generateMessageText() {
    const v = (id, fallback) => document.getElementById(id)?.value.trim() || fallback;
    const nameVal    = v('input_name',    '[Nama Anda]');
    const nimVal     = v('input_nim',     '[NIM / - jika Umum]');
    const majorVal   = v('input_major',   '[Jurusan & Program Studi / -]');
    const classVal   = v('input_class',   '[Kelas / -]');
    const birthVal   = v('input_birth',   '[Kota, Tanggal-Bulan-Tahun]');
    const genderVal  = document.getElementById('input_gender')?.value || '[Laki-laki / Perempuan]';
    const phoneVal   = v('input_phone',   '[08xxxxxxxxxx]');
    const beltVal    = v('input_belt',    '[Pemula / Putih / Kuning / Hijau / Biru / Coklat / Hitam]');
    const addressVal = v('input_address', '[Alamat Lengkap / Domisili]');

    const subject = `Pendaftaran Anggota Baru Karate Polindra - ${nameVal}`;
    const body = `Halo Admin Karate Polindra,

Saya bermaksud untuk mendaftar sebagai anggota baru Karate Polindra dan memohon pembuatan akun pada sistem Karate Tracker. Berikut adalah data diri saya:

• Nama Lengkap              : ${nameVal}
• NIM (Mahasiswa Polindra)  : ${nimVal}
• Jurusan / Program Studi   : ${majorVal}
• Kelas                     : ${classVal}
• Tempat, Tanggal Lahir     : ${birthVal}
• Jenis Kelamin             : ${genderVal}
• No. WhatsApp / HP Aktif   : ${phoneVal}
• Alamat Lengkap / Domisili : ${addressVal}
• Tingkatan Sabuk Saat Ini  : ${beltVal}
• Pengalaman Karate (jika ada): [Nama Dojo/Perguruan / Pemula]

Catatan Tambahan:
[Tuliskan jika ada]

Demikian data ini saya sampaikan dengan sebenar-benarnya.
Terima kasih.

Salam hormat,
${nameVal}`;
    return { subject, body, nameVal };
}

function updateMessagePreview() {
    const { subject, body } = generateMessageText();
    document.getElementById('message-body').value = body;
    document.getElementById('subject-preview').innerText = subject;

    const enc = s => encodeURIComponent(s);
    const gmailUrl  = `https://mail.google.com/mail/?view=cm&fs=1&to=${enc(targetEmail)}&su=${enc(subject)}&body=${enc(body)}`;
    const mailtoUrl = `mailto:${targetEmail}?subject=${enc(subject)}&body=${enc(body)}`;
    document.getElementById('btn-gmail-compose').href  = gmailUrl;
    document.getElementById('btn-mailto-compose').href = mailtoUrl;
}

function toggleQuickForm() {
    const el   = document.getElementById('quick-form-container');
    const text = document.getElementById('toggle-form-text');
    const open = el.classList.toggle('hidden');
    text.innerText = open ? 'Isi Data Langsung (Opsional)' : 'Sembunyikan Form';
}

function copyMessageTemplate() {
    const { body } = generateMessageText();
    navigator.clipboard.writeText(body)
        .then(showToast)
        .catch(() => {
            const el = document.getElementById('message-body');
            el.select();
            document.execCommand('copy');
            showToast();
        });
}

function showToast() {
    const t = document.getElementById('copy-toast');
    t.style.opacity = '1';
    t.style.transform = 'translateY(0)';
    setTimeout(() => {
        t.style.opacity = '0';
        t.style.transform = 'translateY(20px)';
    }, 3000);
}

document.addEventListener('DOMContentLoaded', updateMessagePreview);
</script>
@endsection
