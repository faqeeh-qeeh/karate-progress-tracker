<?php

namespace App\Http\Controllers\Kohai;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceSession;
use App\Models\KumiteReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the Kohai (Student) Dashboard with real dynamic data.
     */
    public function index(): View
    {
        $kohai = Auth::user()->load([
            'kohaiProfile.rank.belt',
            'kohaiProfile.studyProgram.department',
            'kohaiProfile.academicClass',
        ]);
        $kohaiId = $kohai->id;

        // 1. Ambil seluruh riwayat pertandingan Kumite milik Kohai ini
        $allReports = KumiteReport::with(['senpai', 'akaKohai', 'aoKohai', 'winner', 'senshuLogs'])
            ->where(function ($q) use ($kohaiId) {
                $q->where('aka_kohai_id', $kohaiId)
                  ->orWhere('ao_kohai_id', $kohaiId);
            })
            ->orderBy('match_date', 'asc')
            ->orderBy('match_time', 'asc')
            ->get();

        $totalMatches = $allReports->count();
        $totalWins = 0;
        $totalLosses = 0;
        $totalDraws = 0;

        $totalAttack = 0;
        $totalAccuracy = 0;

        $chartMatchLabels = [];
        $chartAttack = [];
        $chartAccuracy = [];

        foreach ($allReports as $index => $r) {
            $isAka = ($r->aka_kohai_id === $kohaiId);
            $attack = $isAka ? (int) $r->aka_score_attack : (int) $r->ao_score_attack;
            $accuracy = $isAka ? (float) $r->aka_score_accuracy : (float) $r->ao_score_accuracy;

            $totalAttack += $attack;
            $totalAccuracy += $accuracy;

            if ($r->winner_id === $kohaiId) {
                $totalWins++;
            } elseif ($r->winner_id === null) {
                $totalDraws++;
            } else {
                $totalLosses++;
            }

            // Simpan 10 match terakhir untuk grafik
            $chartMatchLabels[] = 'Laga #' . ($index + 1) . ' (' . $r->match_date->format('d/m') . ')';
            $chartAttack[] = $attack;
            $chartAccuracy[] = $accuracy;
        }

        // Ambil maksimal 10 data terakhir untuk grafik agar tidak terlalu padat
        if (count($chartMatchLabels) > 10) {
            $chartMatchLabels = array_slice($chartMatchLabels, -10);
            $chartAttack = array_slice($chartAttack, -10);
            $chartAccuracy = array_slice($chartAccuracy, -10);
        }

        $winRate = $totalMatches > 0 ? round(($totalWins / $totalMatches) * 100, 1) : 0;
        $avgAttack = $totalMatches > 0 ? round($totalAttack / $totalMatches, 1) : 0;
        $avgAccuracy = $totalMatches > 0 ? round($totalAccuracy / $totalMatches, 1) : 0;

        // 2. 5 Pertandingan Kumite Terkini
        $recentKumiteReports = $allReports->reverse()->take(5);

        // 3. Statistik Presensi Kehadiran
        $totalAttendance = Attendance::where('kohai_id', $kohaiId)->count();
        $totalDojoSessions = AttendanceSession::count();
        $attendanceRate = $totalDojoSessions > 0 ? round(($totalAttendance / $totalDojoSessions) * 100, 1) : 0;

        // 4. Cek Sesi Absensi Aktif Hari Ini
        $activeSession = AttendanceSession::with('senpai')
            ->where('is_active', true)
            ->first();

        $hasAttendedActive = false;
        if ($activeSession) {
            $hasAttendedActive = Attendance::where('attendance_session_id', $activeSession->id)
                ->where('kohai_id', $kohaiId)
                ->exists();
        }

        // 5. Jadwal Latihan Mingguan Dojo
        $scheduleList = [
            [
                'hari' => 'Selasa',
                'jam' => '16:00 - 18:00 WIB',
                'materi' => 'Kihon & Kata (Heian & Bassai Dai)',
                'lokasi' => 'Dojo Utama Polindra',
            ],
            [
                'hari' => 'Jumat',
                'jam' => '16:00 - 18:00 WIB',
                'materi' => 'Kihon Ippon Kumite & Sparring WKF',
                'lokasi' => 'Dojo Utama Polindra',
            ],
            [
                'hari' => 'Minggu',
                'jam' => '07:30 - 10:00 WIB',
                'materi' => 'Latihan Fisik Stamina & Pengkondisian Tanding',
                'lokasi' => 'Dojo / Lapangan Terbuka',
            ],
        ];

        return view('kohai.dashboard', compact(
            'kohai',
            'totalMatches',
            'totalWins',
            'totalLosses',
            'totalDraws',
            'winRate',
            'avgAttack',
            'avgAccuracy',
            'recentKumiteReports',
            'totalAttendance',
            'attendanceRate',
            'activeSession',
            'hasAttendedActive',
            'chartMatchLabels',
            'chartAttack',
            'chartAccuracy',
            'scheduleList'
        ));
    }
}
