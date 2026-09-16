<?php

namespace App\Http\Controllers\Kohai;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceSession;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Tampilkan halaman scanner QR & Riwayat Presensi Kohai
     */
    public function index()
    {
        $kohaiId = auth()->id();

        $myAttendances = Attendance::with(['session.senpai'])
            ->where('kohai_id', $kohaiId)
            ->orderBy('scanned_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('kohai.attendance.index', compact('myAttendances'));
    }

    /**
     * Proses hasil scan QR Code oleh Kohai
     */
    public function scan(Request $request)
    {
        $validated = $request->validate([
            'qr_token' => 'required|string',
        ]);

        return $this->processScanToken($validated['qr_token']);
    }

    /**
     * Direct link handler jika Kohai scan via aplikasi kamera smartphone standar
     */
    public function directScan(string $token)
    {
        return $this->processScanToken($token);
    }

    /**
     * Logika utama verifikasi & pencatatan absensi Kohai
     */
    protected function processScanToken(string $token)
    {
        $token = trim($token);

        // Jika user mempaste URL lengkap, ambil bagian token saja
        if (str_contains($token, '/direct-scan/')) {
            $parts = explode('/direct-scan/', $token);
            $token = end($parts);
        }

        $token = strtoupper(trim($token));

        // Cari sesi absensi berdasarkan token (case-insensitive)
        $session = AttendanceSession::with('senpai')
            ->whereRaw('UPPER(qr_token) = ?', [$token])
            ->first();

        // 1. Cek keberadaan sesi
        if (!$session) {
            return redirect()->route('kohai.attendance.index')
                ->with('error', 'Kode QR tidak valid atau tidak terdaftar di sistem dojo.');
        }

        // 2. Cek apakah sesi masih aktif
        if (!$session->is_active) {
            return redirect()->route('kohai.attendance.index')
                ->with('error', 'Kode QR ini sudah TIDAK BERLAKU / KADALUARSA! Senpai telah membuat QR baru atau menutup sesi absensi ini.');
        }

        // 3. Cek apakah Kohai ini sudah absen sebelumnya pada sesi ini
        $alreadyAttended = Attendance::where('attendance_session_id', $session->id)
            ->where('kohai_id', auth()->id())
            ->exists();

        if ($alreadyAttended) {
            return redirect()->route('kohai.attendance.index')
                ->with('error', 'Anda sudah tercatat melakukan absensi untuk sesi "' . $session->title . '" ini.');
        }

        // 4. Catat presensi Kohai
        Attendance::create([
            'attendance_session_id' => $session->id,
            'kohai_id' => auth()->id(),
            'scanned_at' => now(),
            'status' => 'Hadir',
        ]);

        return redirect()->route('kohai.attendance.index')
            ->with('success', 'OSU! Absensi Berhasil. Anda telah terdaftar pada sesi "' . $session->title . '" oleh Senpai ' . $session->senpai->name . '.');
    }
}
