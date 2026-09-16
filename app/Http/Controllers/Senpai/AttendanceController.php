<?php

namespace App\Http\Controllers\Senpai;

use App\Http\Controllers\Controller;
use App\Models\AttendanceSession;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Tampilkan halaman utama Absensi Senpai (QR Aktif + Riwayat)
     */
    public function index()
    {
        $senpaiId = auth()->id();

        // Sesi absensi yang sedang aktif saat ini
        $activeSession = AttendanceSession::with(['attendances.kohai', 'senpai'])
            ->where('senpai_id', $senpaiId)
            ->where('is_active', true)
            ->first();

        // Riwayat sesi absensi sebelumnya
        $pastSessions = AttendanceSession::withCount('attendances')
            ->where('senpai_id', $senpaiId)
            ->where('is_active', false)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('senpai.attendance.index', compact('activeSession', 'pastSessions'));
    }

    /**
     * Buat sesi absensi baru atau lanjutkan sesi pada tanggal yang sama
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'action_choice' => 'nullable|string|in:reactivate,create_new',
        ]);

        $senpaiId = auth()->id();
        $existingSession = AttendanceSession::findExistingForDate($senpaiId, $validated['date']);

        // Jika pernah ada sesi pada tanggal ini dan belum dikonfirmasi tindakan:
        if ($existingSession && !$request->filled('action_choice')) {
            return redirect()->route('senpai.attendance.index')
                ->with('existing_session_warning', [
                    'session_id' => $existingSession->id,
                    'title' => $existingSession->title,
                    'date' => \Carbon\Carbon::parse($existingSession->date)->format('d F Y'),
                    'attendee_count' => $existingSession->attendances()->count(),
                    'new_title' => $validated['title'],
                    'new_date' => $validated['date'],
                ]);
        }

        // Jika Senpai memilih untuk melanjutkan sesi sebelumnya pada tanggal ini:
        if ($existingSession && $request->input('action_choice') === 'reactivate') {
            $existingSession->reactivate();

            return redirect()->route('senpai.attendance.index')
                ->with('success', 'Sesi absensi tanggal ' . \Carbon\Carbon::parse($existingSession->date)->format('d F Y') . ' ("' . $existingSession->title . '") berhasil DILANJUTKAN! Data presensi Kohai sebelumnya tetap tersimpan.');
        }

        // Jika Senpai memilih untuk membuat sesi baru dari nol:
        $session = AttendanceSession::createNewSession(
            $senpaiId,
            $validated['title'],
            $validated['date']
        );

        return redirect()->route('senpai.attendance.index')
            ->with('success', 'Sesi absensi baru berhasil dibuat! QR Code baru telah aktif dan QR sebelumnya otomatis di-nonaktifkan.');
    }

    /**
     * Tutup/nonaktifkan sesi absensi aktif
     */
    public function close(AttendanceSession $attendanceSession)
    {
        if ($attendanceSession->senpai_id !== auth()->id()) {
            abort(403, 'Akses ditolak.');
        }

        $attendanceSession->update(['is_active' => false]);

        return redirect()->route('senpai.attendance.index')
            ->with('success', 'Sesi absensi telah berhasil ditutup.');
    }

    /**
     * Lanjutkan kembali (reactivate) sesi absensi dari tabel riwayat
     */
    public function reactivate(AttendanceSession $attendanceSession)
    {
        if ($attendanceSession->senpai_id !== auth()->id()) {
            abort(403, 'Akses ditolak.');
        }

        $attendanceSession->reactivate();

        return redirect()->route('senpai.attendance.index')
            ->with('success', 'Sesi absensi "' . $attendanceSession->title . '" (' . \Carbon\Carbon::parse($attendanceSession->date)->format('d F Y') . ') berhasil DILANJUTKAN! Presensi Kohai sebelumnya tetap tersimpan.');
    }

    /**
     * Detail riwayat sesi absensi
     */
    public function show(AttendanceSession $attendanceSession)
    {
        if ($attendanceSession->senpai_id !== auth()->id()) {
            abort(403, 'Akses ditolak.');
        }

        $attendanceSession->load(['attendances.kohai', 'senpai']);

        return view('senpai.attendance.show', compact('attendanceSession'));
    }

    /**
     * Endpoint API JSON untuk live polling daftar Kohai yang sudah absen
     */
    public function attendees(AttendanceSession $attendanceSession)
    {
        if ($attendanceSession->senpai_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $attendees = $attendanceSession->attendances()
            ->with('kohai')
            ->orderBy('scanned_at', 'desc')
            ->get()
            ->map(function ($att) {
                return [
                    'id' => $att->id,
                    'kohai_name' => $att->kohai->name,
                    'kohai_email' => $att->kohai->email,
                    'scanned_at' => $att->scanned_at->setTimezone('Asia/Jakarta')->format('H:i:s - d M Y'),
                    'status' => $att->status,
                ];
            });

        return response()->json([
            'is_active' => $attendanceSession->is_active,
            'count' => $attendees->count(),
            'attendees' => $attendees,
        ]);
    }
}
