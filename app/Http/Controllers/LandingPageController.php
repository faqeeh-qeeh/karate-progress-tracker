<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\LandingSetting;
use App\Models\TrainingSchedule;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class LandingPageController extends Controller
{
    /**
     * Tampilkan Landing Page atau redirect jika sudah login.
     */
    public function index(): View|Response
    {
        if (Auth::check()) {
            return redirect(Auth::user()->getDashboardRoute());
        }

        $settings = LandingSetting::getAllSettings();

        // ── Hitung Angka Statistik Dinamis ───────────────────
        $membersMode = $settings['stat_members_mode'] ?? 'auto_polindra';
        $membersCount = match ($membersMode) {
            'auto_polindra' => User::whereHas('role', fn($q) => $q->where('nama', 'Kohai'))
                ->whereHas('kohaiProfile', fn($q) => $q->where('type', 'polindra'))
                ->count(),
            'auto_all' => User::whereHas('role', fn($q) => $q->where('nama', 'Kohai'))->count(),
            default => (int) ($settings['stat_members_custom_value'] ?? 80),
        };

        // Jika count otomatis adalah 0 (misal di awal instalasi sebelum ada user banyak), berikan fallback minimal atau sesuai data real
        if (in_array($membersMode, ['auto_polindra', 'auto_all']) && $membersCount === 0) {
            $membersCount = (int) ($settings['stat_members_custom_value'] ?? 80);
        }

        $medalsMode = $settings['stat_medals_mode'] ?? 'manual';
        $medalsCount = match ($medalsMode) {
            'auto' => Achievement::published()->count(),
            default => (int) ($settings['stat_medals_custom_value'] ?? 50),
        };
        if ($medalsMode === 'auto' && $medalsCount === 0) {
            $medalsCount = (int) ($settings['stat_medals_custom_value'] ?? 50);
        }

        $eventsMode = $settings['stat_events_mode'] ?? 'manual';
        $eventsCount = match ($eventsMode) {
            'auto' => Achievement::published()->distinct('event_name')->count('event_name'),
            default => (int) ($settings['stat_events_value'] ?? 20),
        };
        if ($eventsMode === 'auto' && $eventsCount === 0) {
            $eventsCount = (int) ($settings['stat_events_value'] ?? 20);
        }

        $stats = [
            'founded' => [
                'active' => (bool) ($settings['stat_founded_active'] ?? true),
                'year' => (int) ($settings['stat_founded_year'] ?? 2016),
                'label' => $settings['stat_founded_label'] ?? 'Tahun Berdiri',
            ],
            'members' => [
                'active' => (bool) ($settings['stat_members_active'] ?? true),
                'count' => $membersCount,
                'suffix' => $settings['stat_members_suffix'] ?? '+',
                'label' => $settings['stat_members_label'] ?? ($membersMode === 'auto_polindra' ? 'Anggota Polindra' : 'Anggota Aktif'),
                'mode' => $membersMode,
            ],
            'medals' => [
                'active' => (bool) ($settings['stat_medals_active'] ?? true),
                'count' => $medalsCount,
                'suffix' => $settings['stat_medals_suffix'] ?? '+',
                'label' => $settings['stat_medals_label'] ?? 'Medali Kejuaraan',
                'mode' => $medalsMode,
            ],
            'events' => [
                'active' => (bool) ($settings['stat_events_active'] ?? true),
                'count' => $eventsCount,
                'suffix' => $settings['stat_events_suffix'] ?? '+',
                'label' => $settings['stat_events_label'] ?? 'Event Diikuti',
                'mode' => $eventsMode,
            ],
        ];

        // ── Ambil Prestasi Kejuaraan ─────────────────────────
        $achievements = Achievement::published()->ordered()->get();

        // ── Ambil Jadwal Latihan Aktif (Opsional) ─────────────
        $trainingSchedules = TrainingSchedule::where('is_active', true)->orderBy('start_time')->get();

        return view('landing', compact('settings', 'stats', 'achievements', 'trainingSchedules'));
    }
}
