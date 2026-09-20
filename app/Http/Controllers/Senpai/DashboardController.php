<?php

namespace App\Http\Controllers\Senpai;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceSession;
use App\Models\Belt;
use App\Models\KumiteReport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the Senpai (Instructor) Dashboard with real dynamic data.
     */
    public function index(): View
    {
        $senpai = Auth::user()->load(['senpaiProfile.rank.belt']);
        $senpaiId = $senpai->id;

        // 1. Core Summary Metrics
        $totalKohai = User::whereHas('role', fn($q) => $q->where('nama', 'Kohai'))->count();
        $totalSessions = AttendanceSession::where('senpai_id', $senpaiId)->count();
        $totalKumiteReports = KumiteReport::where('senpai_id', $senpaiId)->count();
        $totalAttendances = Attendance::whereHas('attendanceSession', fn($q) => $q->where('senpai_id', $senpaiId))->count();

        // 2. Sesi Absensi Aktif Saat Ini (jika ada)
        $activeSession = AttendanceSession::with(['attendances.kohai'])
            ->where('senpai_id', $senpaiId)
            ->where('is_active', true)
            ->first();

        // 3. 5 Evaluasi Raport Kumite WKF Terbaru
        $recentKumiteReports = KumiteReport::with([
                'akaKohai.kohaiProfile.rank.belt',
                'aoKohai.kohaiProfile.rank.belt',
                'winner',
                'senshuLogs',
            ])
            ->where('senpai_id', $senpaiId)
            ->latest('match_date')
            ->latest('match_time')
            ->take(5)
            ->get();

        // 4. Daftar Kohai Binaan Terkini (dengan Sabuk, Match count, dan Kehadiran riil)
        $kohaiList = User::whereHas('role', fn($q) => $q->where('nama', 'Kohai'))
            ->with([
                'kohaiProfile.rank.belt',
                'kohaiProfile.studyProgram.department',
                'kohaiProfile.academicClass',
            ])
            ->withCount([
                'kumiteAsAka as matches_as_aka_count',
                'kumiteAsAo as matches_as_ao_count',
                'attendancesAsKohai as attendance_count',
            ])
            ->latest()
            ->take(6)
            ->get();

        // 5. Data Chart Distribusi Sabuk Kohai Dojo
        $belts = Belt::with('ranks')->get();
        $beltDistribution = $belts->map(function ($belt) {
            $count = User::whereHas('role', fn($q) => $q->where('nama', 'Kohai'))
                ->whereHas('kohaiProfile.rank', fn($q) => $q->where('belt_id', $belt->id))
                ->count();
            return [
                'name' => $belt->name,
                'color' => $belt->color_code ?: '#146C94',
                'count' => $count,
            ];
        })->filter(fn($item) => $item['count'] > 0)->values();

        // 6. Data Chart Tren Evaluasi Kumite (Attack & Akurasi Rata-rata)
        $recentMatches = KumiteReport::where('senpai_id', $senpaiId)
            ->orderBy('match_date', 'asc')
            ->orderBy('match_time', 'asc')
            ->take(10)
            ->get();

        $chartMatchLabels = [];
        $chartAttack = [];
        $chartAccuracy = [];

        foreach ($recentMatches as $index => $m) {
            $chartMatchLabels[] = 'Laga #' . ($index + 1) . ' (' . $m->match_date->format('d/m') . ')';
            $chartAttack[] = round(($m->aka_score_attack + $m->ao_score_attack) / 2, 1);
            $chartAccuracy[] = round(($m->aka_score_accuracy + $m->ao_score_accuracy) / 2, 1);
        }

        // 7. Jadwal Latihan Mingguan Dojo
        $schedules = [
            [
                'hari' => 'Selasa',
                'jam' => '16:00 - 18:00 WIB',
                'materi' => 'Kihon & Kata (Heian & Bassai Dai)',
                'lokasi' => 'Dojo Utama Polindra',
                'fokus' => 'Teknik Dasar & Kerapian Gerakan',
            ],
            [
                'hari' => 'Jumat',
                'jam' => '16:00 - 18:00 WIB',
                'materi' => 'Kumite & Sparring Drill (WKF Rules)',
                'lokasi' => 'Dojo Utama Polindra',
                'fokus' => 'Timing, Senshu, & Strategi Bertanding',
            ],
            [
                'hari' => 'Minggu',
                'jam' => '07:30 - 10:00 WIB',
                'materi' => 'Fisik, Agilitas, & Pengkondisian Tanding',
                'lokasi' => 'Dojo / Lapangan Terbuka',
                'fokus' => 'Stamina & Kelincahan Langkah',
            ],
        ];

        return view('senpai.dashboard', compact(
            'senpai',
            'totalKohai',
            'totalSessions',
            'totalKumiteReports',
            'totalAttendances',
            'activeSession',
            'recentKumiteReports',
            'kohaiList',
            'beltDistribution',
            'chartMatchLabels',
            'chartAttack',
            'chartAccuracy',
            'schedules'
        ));
    }
}
