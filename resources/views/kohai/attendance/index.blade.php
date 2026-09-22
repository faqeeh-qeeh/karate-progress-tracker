@extends('layouts.kohai')

@section('title', 'Scan Absensi QR')

@section('content')
<div class="space-y-6">
    <!-- Header Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-brand-secondary via-sky-800 to-slate-900 p-6 sm:p-8 text-white shadow-xl">
        <div class="relative z-10 space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-[11px] font-bold text-white">
                <span>📸</span> PRESENSI ANGGOTA KOHAI
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight leading-tight">Scan QR Absensi Latihan 🔥</h1>
            <p class="text-sky-100 text-xs sm:text-sm max-w-xl font-medium leading-relaxed">
                Arahkan kamera smartphone atau perangkat Anda ke layar QR Code yang ditampilkan oleh Senpai untuk mencatat absensi kehadiran secara otomatis.
            </p>
        </div>
        <div class="absolute -right-8 -bottom-8 w-56 h-56 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- SCANNER & MANUAL FORM GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Live QR Scanner Box -->
        <div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 p-6 shadow-sm space-y-4 transition-colors">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                    <span>📷</span> Scanner Kamera Browser
                </h3>
                <span id="scan-status-badge" class="px-3 py-1 bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800/60 rounded-full text-xs font-bold">
                    Siap Memindai
                </span>
            </div>

            <!-- HTML5 QR Code Scanner Viewport Container -->
            <div class="relative bg-slate-950 rounded-2xl overflow-hidden min-h-[280px] flex items-center justify-center border border-slate-800 shadow-inner">
                <div id="reader" class="w-full h-full text-white"></div>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500 dark:text-slate-400 font-medium bg-slate-50 dark:bg-slate-800/50 p-3.5 rounded-2xl border border-slate-200/80 dark:border-slate-700/60">
                <p class="text-slate-600 dark:text-slate-300">📍 Jika kamera live disekat HTTP, gunakan tombol <b>Foto QR Kamera HP</b>.</p>
                <div class="flex flex-wrap gap-2">
                    <!-- Input File Kamera Native HP (Fallback Kerja 100% di HTTP IP) -->
                    <input type="file" id="qr-file-input" accept="image/*" capture="environment" class="hidden">
                    <button type="button" onclick="document.getElementById('qr-file-input').click()" class="px-3.5 py-1.5 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold rounded-xl text-xs hover:brightness-110 transition shadow-xs flex items-center gap-1 cursor-pointer">
                        <span>📸</span> Ambil Foto QR (Kamera HP)
                    </button>
                    <button type="button" id="btn-start-camera" class="px-3.5 py-1.5 bg-brand-secondary text-slate-900 font-bold rounded-xl text-xs hover:brightness-105 transition shadow-xs cursor-pointer">
                        Aktifkan Live Stream
                    </button>
                    <button type="button" id="btn-stop-camera" class="px-3.5 py-1.5 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold rounded-xl text-xs hover:bg-slate-300 dark:hover:bg-slate-600 transition hidden cursor-pointer">
                        Matikan Stream
                    </button>
                </div>
            </div>
        </div>

        <!-- Manual QR Code Input Box -->
        <div class="lg:col-span-1 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 p-6 shadow-sm flex flex-col justify-between space-y-4 transition-colors">
            <div class="space-y-3">
                <div class="border-b border-slate-100 dark:border-slate-800 pb-3">
                    <h3 class="text-base font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                        <span>⌨️</span> Input Kode Manual
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Gunakan form ini jika kamera tidak bisa diakses.</p>
                </div>

                <form id="scan-form" action="{{ route('kohai.attendance.scan') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="space-y-1.5">
                        <label for="qr_token" class="block text-xs font-bold text-slate-700 dark:text-slate-300">Token Absensi / Kode QR</label>
                        <input type="text" id="qr_token" name="qr_token" required placeholder="Tempel / ketik token QR di sini" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-primary focus:border-brand-primary outline-none transition font-mono">
                    </div>

                    <button type="submit" class="w-full py-3 bg-brand-primary hover:bg-brand-primary/90 text-white rounded-xl font-bold text-xs shadow-md transition flex items-center justify-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Kirim Absensi</span>
                    </button>
                </form>
            </div>

            <div class="bg-blue-50 dark:bg-sky-950/30 p-4 rounded-2xl border border-blue-200/80 dark:border-sky-800/60 text-xs text-blue-900 dark:text-sky-200 space-y-1 font-medium">
                <p class="font-bold flex items-center gap-1 text-brand-primary dark:text-sky-400">💡 Catatan Presensi:</p>
                <p class="text-[11px] leading-relaxed text-slate-600 dark:text-slate-400">
                    QR Code hanya berlaku untuk sesi aktif saat ini. Jika Senpai meng-generate QR baru, QR sebelumnya akan langsung kadaluarsa.
                </p>
            </div>
        </div>
    </div>

    <!-- MY ATTENDANCE HISTORY TABLE -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 p-6 shadow-sm space-y-4 transition-colors">
        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4">
            <div>
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                    <span>📜</span> Riwayat Presensi Kehadiran Saya
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Catatan sesi latihan yang telah Anda ikuti.</p>
            </div>
        </div>

        <!-- Mobile View: Card Roster List (Shown on mobile screens < md) -->
        <div class="block md:hidden space-y-4">
            @forelse($myAttendances as $att)
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 p-4 shadow-sm hover:shadow-md transition-all space-y-3">
                    <!-- Header Card Info -->
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-2.5">
                        <div class="flex items-center gap-2">
                            <span class="p-1.5 rounded-lg bg-blue-50 dark:bg-slate-800 text-brand-primary dark:text-sky-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </span>
                            <span class="text-xs font-bold text-slate-800 dark:text-slate-200">
                                {{ \Carbon\Carbon::parse($att->session->date)->format('d F Y') }}
                            </span>
                        </div>
                        <span class="px-3 py-0.5 text-xs font-extrabold rounded-full bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/60">
                            {{ $att->status }}
                        </span>
                    </div>

                    <!-- Title & Details -->
                    <div class="space-y-1.5">
                        <h4 class="text-sm font-extrabold text-slate-900 dark:text-white leading-snug">
                            {{ $att->session->title ?? 'Sesi Latihan' }}
                        </h4>
                        <div class="flex flex-col gap-1 text-xs text-slate-500 dark:text-slate-400 font-medium pt-1 border-t border-slate-100 dark:border-slate-800">
                            <p class="flex items-center justify-between">
                                <span>Penanggungjawab:</span>
                                <strong class="text-brand-primary dark:text-sky-400">Senpai {{ $att->session->senpai->name ?? '-' }}</strong>
                            </p>
                            <p class="flex items-center justify-between font-mono text-[11px] text-slate-600 dark:text-slate-400">
                                <span>Waktu Scan Absen:</span>
                                <span>{{ \Carbon\Carbon::parse($att->scanned_at)->setTimezone('Asia/Jakarta')->format('H:i:s - d M Y') }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 text-center text-slate-400 dark:text-slate-500 text-xs font-medium border border-slate-200/80 dark:border-slate-800 shadow-sm">
                    Anda belum memiliki riwayat presensi latihan.
                </div>
            @endforelse

            <div class="pt-2">
                {{ $myAttendances->links() }}
            </div>
        </div>

        <!-- Desktop View: Table Format (Hidden on mobile < md) -->
        <div class="hidden md:block">
            <div class="overflow-x-auto min-w-0 border border-slate-200/80 dark:border-slate-800 rounded-2xl">
                <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                    <thead class="bg-slate-50 dark:bg-slate-800/60 text-slate-700 dark:text-slate-300 text-[11px] uppercase font-bold tracking-wider border-b border-slate-200/80 dark:border-slate-800 whitespace-nowrap">
                        <tr>
                            <th class="py-3 px-4">Judul Sesi Absensi</th>
                            <th class="py-3 px-4">Penanggungjawab Senpai</th>
                            <th class="py-3 px-4">Tanggal Sesi</th>
                            <th class="py-3 px-4">Waktu Scan Absen</th>
                            <th class="py-3 px-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 whitespace-nowrap font-medium">
                        @forelse($myAttendances as $att)
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors">
                                <td class="py-3.5 px-4 font-bold text-slate-900 dark:text-white">{{ $att->session->title ?? 'Sesi Latihan' }}</td>
                                <td class="py-3.5 px-4 text-xs font-bold text-brand-primary dark:text-sky-400">
                                    Senpai {{ $att->session->senpai->name ?? '-' }}
                                </td>
                                <td class="py-3.5 px-4 text-xs text-slate-600 dark:text-slate-400">
                                    {{ \Carbon\Carbon::parse($att->session->date)->format('d F Y') }}
                                </td>
                                <td class="py-3.5 px-4 text-xs font-mono text-slate-700 dark:text-slate-300">
                                    {{ \Carbon\Carbon::parse($att->scanned_at)->setTimezone('Asia/Jakarta')->format('H:i:s - d M Y') }}
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <span class="px-3 py-1 text-xs font-extrabold rounded-full bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/60">
                                        {{ $att->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400 dark:text-slate-500 text-xs font-medium">
                                    Anda belum memiliki riwayat presensi latihan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pt-4">
                {{ $myAttendances->links() }}
            </div>
        </div>
    </div>
</div>

<!-- HTML5 QRCode Scanner Script -->
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
    let html5QrCode = null;
    const badge = document.getElementById('scan-status-badge');
    const startBtn = document.getElementById('btn-start-camera');
    const stopBtn = document.getElementById('btn-stop-camera');
    const tokenInput = document.getElementById('qr_token');
    const scanForm = document.getElementById('scan-form');

    function onScanSuccess(decodedText, decodedResult) {
        // Hentikan scanner setelah berhasil membaca
        if (html5QrCode) {
            html5QrCode.stop().catch(err => console.error(err));
        }

        badge.textContent = "QR Terbaca!";
        badge.className = "px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-xs font-bold";

        // Extract token jika decodedText berupa URL lengkap
        let token = decodedText;
        if (decodedText.includes('/direct-scan/')) {
            const parts = decodedText.split('/direct-scan/');
            token = parts[parts.length - 1];
        }

        tokenInput.value = token;
        
        // Auto-submit form
        scanForm.submit();
    }

    function onScanFailure(error) {
        // Abaikan kegagalan per frame biasa saat belum menemukan QR
    }

    startBtn?.addEventListener('click', () => {
        html5QrCode = new Html5Qrcode("reader");
        const config = { fps: 10, qrbox: { width: 220, height: 220 } };

        html5QrCode.start(
            { facingMode: "environment" },
            config,
            onScanSuccess,
            onScanFailure
        ).then(() => {
            badge.textContent = "Kamera Aktif • Pindai QR";
            badge.className = "px-3 py-1 bg-blue-50 text-brand-primary border border-blue-200 rounded-full text-xs font-bold animate-pulse";
            startBtn.classList.add('hidden');
            stopBtn.classList.remove('hidden');
        }).catch(err => {
            alert("Gagal mengaktifkan kamera stream HTTP: " + err + "\n\nSolusi: Gunakan tombol '📸 Ambil Foto QR (Kamera HP)' di bawah atau input kode token secara manual!");
            console.error(err);
        });
    });

    stopBtn?.addEventListener('click', () => {
        if (html5QrCode) {
            html5QrCode.stop().then(() => {
                badge.textContent = "Kamera Dimatikan";
                badge.className = "px-3 py-1 bg-amber-50 text-amber-700 border border-amber-200 rounded-full text-xs font-bold";
                startBtn.classList.remove('hidden');
                stopBtn.classList.add('hidden');
            }).catch(err => console.error(err));
        }
    });

    // Handle Foto Kamera HP (Input File)
    const fileInput = document.getElementById('qr-file-input');
    fileInput?.addEventListener('change', e => {
        if (e.target.files.length === 0) return;
        const imageFile = e.target.files[0];
        
        badge.textContent = "Membaca Foto QR...";
        badge.className = "px-3 py-1 bg-blue-50 text-brand-primary border border-blue-200 rounded-full text-xs font-bold animate-pulse";

        const scanner = new Html5Qrcode("reader");
        scanner.scanFile(imageFile, true)
            .then(decodedText => {
                onScanSuccess(decodedText);
            })
            .catch(err => {
                badge.textContent = "Gagal Membaca Foto";
                badge.className = "px-3 py-1 bg-red-50 text-red-700 border border-red-200 rounded-full text-xs font-bold";
                alert("QR Code tidak dapat terbaca dari gambar ini. Harap ambil foto yang lebih jelas dan dekat!");
            });
    });
</script>
@endsection
