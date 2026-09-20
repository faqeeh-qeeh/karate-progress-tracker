<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicClass;
use App\Models\Attendance;
use App\Models\AttendanceSession;
use App\Models\Belt;
use App\Models\Department;
use App\Models\KumiteReport;
use App\Models\Rank;
use App\Models\StudyProgram;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the Admin Dashboard with comprehensive dynamic metrics.
     */
    public function index(): View
    {
        // 1. Metrik Statistik Pengguna Sistem
        $totalUsers = User::count();
        $totalAdmin = User::whereHas('role', fn($q) => $q->where('nama', 'admin'))->count();
        $totalSenpai = User::whereHas('role', fn($q) => $q->where('nama', 'Senpai'))->count();
        $totalKohai = User::whereHas('role', fn($q) => $q->where('nama', 'Kohai'))->count();

        // 2. Master Data Akademik & Tingkatan
        $totalBelts = Belt::count();
        $totalRanks = Rank::count();
        $totalDepartments = Department::count();
        $totalStudyPrograms = StudyProgram::count();
        $totalClasses = AcademicClass::count();

        // 3. Metrik Aktivitas Dojo (Kumite & Absensi QR)
        $totalKumiteReports = KumiteReport::count();
        $totalAttendanceSessions = AttendanceSession::count();
        $totalAttendances = Attendance::count();

        // 4. Sesi Absensi Dojo yang Sedang Berjalan (Aktif)
        $activeSession = AttendanceSession::with(['senpai', 'attendances.kohai'])
            ->where('is_active', true)
            ->first();

        // 5. 6 Pengguna yang Baru Terdaftar
        $recentUsers = User::with('role')->latest()->take(6)->get();

        // 6. 5 Evaluasi Raport Kumite WKF Terbaru di Sistem
        $recentKumiteReports = KumiteReport::with(['senpai', 'akaKohai', 'aoKohai', 'winner'])
            ->latest('match_date')
            ->latest('match_time')
            ->take(5)
            ->get();

        // 7. Data Chart Distribusi Role
        $roleChartData = [
            'labels' => ['Admin', 'Senpai (Pelatih)', 'Kohai (Murid)'],
            'data' => [$totalAdmin, $totalSenpai, $totalKohai],
            'colors' => ['#ef4444', '#146C94', '#19A7CE'],
        ];

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAdmin',
            'totalSenpai',
            'totalKohai',
            'totalBelts',
            'totalRanks',
            'totalDepartments',
            'totalStudyPrograms',
            'totalClasses',
            'totalKumiteReports',
            'totalAttendanceSessions',
            'totalAttendances',
            'activeSession',
            'recentUsers',
            'recentKumiteReports',
            'roleChartData'
        ));
    }
}

