<?php

namespace App\Http\Controllers\Senpai;

use App\Http\Controllers\Controller;
use App\Models\KumiteReport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KohaiOverviewController extends Controller
{
    /**
     * Tampilkan daftar seluruh murid berpangkat Kohai.
     */
    public function index(Request $request): View
    {
        $query = User::whereHas('role', fn($q) => $q->where('nama', 'Kohai'))
            ->withCount([
                'kumiteAsAka as matches_as_aka_count',
                'kumiteAsAo as matches_as_ao_count',
            ])
            ->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $kohais = $query->paginate(12)->withQueryString();

        return view('senpai.kohai.index', compact('kohais'));
    }

    /**
     * Tampilkan detail nilai dan grafik analisis performa Kohai (Attack & Accuracy).
     */
    public function show(User $kohai): View
    {
        // Pastikan user terkait ber-role Kohai
        if (!$kohai->hasRole('Kohai')) {
            abort(404, 'Pengguna bukan merupakan Kohai.');
        }

        // Ambil seluruh riwayat pertandingan Kumite (diurutkan kronologis)
        $reports = KumiteReport::with(['senpai', 'akaKohai', 'aoKohai', 'winner'])
            ->where(function ($q) use ($kohai) {
                $q->where('aka_kohai_id', $kohai->id)
                  ->orWhere('ao_kohai_id', $kohai->id);
            })
            ->orderBy('match_date', 'asc')
            ->orderBy('match_time', 'asc')
            ->get();

        $totalMatches = $reports->count();
        $wins = 0;
        $losses = 0;

        $chartLabels = [];
        $chartAttack = [];
        $chartAccuracy = [];

        $threeMonthsAgo = now()->subMonths(3)->startOfDay();
        $recentAttackTotal = 0;
        $recentAccuracyTotal = 0;
        $recentMatchesCount = 0;

        foreach ($reports as $index => $r) {
            $isAka = ($r->aka_kohai_id === $kohai->id);
            $attack = $isAka ? $r->aka_score_attack : $r->ao_score_attack;
            $accuracy = $isAka ? $r->aka_score_accuracy : $r->ao_score_accuracy;

            if ($r->winner_id === $kohai->id) {
                $wins++;
            } else {
                $losses++;
            }

            // Grafik & Rata-rata khusus 3 Bulan Terakhir
            if ($r->match_date >= $threeMonthsAgo) {
                $recentMatchesCount++;
                $recentAttackTotal += $attack;
                $recentAccuracyTotal += $accuracy;

                $chartLabels[] = 'Match #' . $recentMatchesCount . ' (' . $r->match_date->format('d M') . ')';
                $chartAttack[] = $attack;
                $chartAccuracy[] = $accuracy;
            }
        }

        $avgAttack = $recentMatchesCount > 0 ? round($recentAttackTotal / $recentMatchesCount, 1) : 0;
        $avgAccuracy = $recentMatchesCount > 0 ? round($recentAccuracyTotal / $recentMatchesCount, 1) : 0;

        // Urutkan kembali riwayat pertandingan terbaru di atas untuk tabel
        $reportsDesc = $reports->reverse();

        return view('senpai.kohai.show', compact(
            'kohai',
            'reportsDesc',
            'totalMatches',
            'wins',
            'losses',
            'avgAttack',
            'avgAccuracy',
            'chartLabels',
            'chartAttack',
            'chartAccuracy',
            'recentMatchesCount'
        ));
    }
}
