<?php

namespace App\Http\Controllers\Senpai;

use App\Http\Controllers\Controller;
use App\Models\KumiteReport;
use App\Models\KumiteSenshuLog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KumiteController extends Controller
{
    /**
     * Tampilkan daftar seluruh Raport Kumite yang pernah dinilai.
     */
    public function index(): View
    {
        $reports = KumiteReport::with(['senpai', 'akaKohai', 'aoKohai', 'winner'])
            ->latest('match_date')
            ->latest('match_time')
            ->paginate(10)
            ->withQueryString();

        return view('senpai.kumite.index', compact('reports'));
    }

    /**
     * Tampilkan form pembuatan Raport Kumite WKF baru.
     */
    public function create(): View
    {
        // Hanya ambil pengguna dengan role Kohai
        $kohais = User::whereHas('role', fn($q) => $q->where('nama', 'Kohai'))
            ->orderBy('name', 'asc')
            ->get();

        return view('senpai.kumite.create', compact('kohais'));
    }

    /**
     * Simpan Raport Kumite ke basis data.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'aka_kohai_id' => ['required', 'exists:users,id'],
            'ao_kohai_id' => ['required', 'exists:users,id', 'different:aka_kohai_id'],
            'match_date' => ['required', 'date'],
            'match_time' => ['required'],
            'duration_minutes' => ['nullable', 'integer', 'min:0', 'max:60'],
            'duration_seconds' => ['nullable', 'integer', 'min:0', 'max:59'],
            
            // Senshu Selection (Bisa aka, ao, none, atau null)
            'senshu_corner' => ['nullable', 'string', 'in:aka,ao,none'],
            'senshu_logs' => ['nullable', 'array'],

            // Stats AKA
            'aka_ippon' => ['required', 'integer', 'min:0'],
            'aka_wazaari' => ['required', 'integer', 'min:0'],
            'aka_yuko' => ['required', 'integer', 'min:0'],
            'aka_fouls' => ['required', 'integer', 'min:0', 'max:5'],
            'aka_score_attack' => ['required', 'integer', 'min:0'],
            'aka_score_accuracy' => ['nullable', 'numeric', 'min:0'],
            'aka_evaluation_notes' => ['nullable', 'string', 'max:2000'],

            // Stats AO
            'ao_ippon' => ['required', 'integer', 'min:0'],
            'ao_wazaari' => ['required', 'integer', 'min:0'],
            'ao_yuko' => ['required', 'integer', 'min:0'],
            'ao_fouls' => ['required', 'integer', 'min:0', 'max:5'],
            'ao_score_attack' => ['required', 'integer', 'min:0'],
            'ao_score_accuracy' => ['nullable', 'numeric', 'min:0'],
            'ao_evaluation_notes' => ['nullable', 'string', 'max:2000'],
        ], [
            'aka_kohai_id.required' => 'Kohai sudut Merah (AKA) wajib dipilih.',
            'ao_kohai_id.required' => 'Kohai sudut Biru (AO) wajib dipilih.',
            'ao_kohai_id.different' => 'Kohai sudut Biru (AO) tidak boleh sama dengan Kohai sudut Merah (AKA).',
            'match_date.required' => 'Tanggal pertandingan wajib diisi.',
            'match_time.required' => 'Jam pertandingan wajib diisi.',
            'aka_fouls.required' => 'Poin Pelanggaran AKA wajib dipilih.',
            'ao_fouls.required' => 'Poin Pelanggaran AO wajib dipilih.',
            'aka_score_attack.required' => 'Nilai Attack / Serangan AKA wajib diisi.',
            'ao_score_attack.required' => 'Nilai Attack / Serangan AO wajib diisi.',
        ]);

        // Hitung Otomatis Total Skor Poin WKF
        $akaTotal = KumiteReport::calculatePoints(
            (int) $validated['aka_ippon'],
            (int) $validated['aka_wazaari'],
            (int) $validated['aka_yuko']
        );

        $aoTotal = KumiteReport::calculatePoints(
            (int) $validated['ao_ippon'],
            (int) $validated['ao_wazaari'],
            (int) $validated['ao_yuko']
        );

        // Hitung Otomatis Akurasi (Jumlah Poin Masuk : Jumlah Serangan * 100%)
        $akaHits = (int) $validated['aka_ippon'] + (int) $validated['aka_wazaari'] + (int) $validated['aka_yuko'];
        $akaAttack = (int) $validated['aka_score_attack'];
        $akaAccuracy = $akaAttack > 0 ? round(($akaHits / $akaAttack) * 100, 1) : 0;

        $aoHits = (int) $validated['ao_ippon'] + (int) $validated['ao_wazaari'] + (int) $validated['ao_yuko'];
        $aoAttack = (int) $validated['ao_score_attack'];
        $aoAccuracy = $aoAttack > 0 ? round(($aoHits / $aoAttack) * 100, 1) : 0;

        // Tentukan Final Senshu Corner
        $rawSenshu = $validated['senshu_corner'] ?? null;
        $senshuCorner = ($rawSenshu === 'none') ? null : $rawSenshu;

        // Jika terdapat riwayat Senshu Cancelling dari form, evaluasi peraih aktif terakhir
        $senshuLogsInput = $request->input('senshu_logs', []);
        if (!empty($senshuLogsInput) && is_array($senshuLogsInput)) {
            // Ambil item terakhir
            $lastLog = end($senshuLogsInput);
            if (isset($lastLog['status']) && $lastLog['status'] === 'active' && in_array($lastLog['corner'], ['aka', 'ao'])) {
                $senshuCorner = $lastLog['corner'];
            } else {
                $senshuCorner = null;
            }
        }

        $akaFouls = (int) $validated['aka_fouls'];
        $aoFouls = (int) $validated['ao_fouls'];
        $akaDisqualified = ($akaFouls >= 4);
        $aoDisqualified = ($aoFouls >= 4);

        // Tentukan Pemenang:
        // 1. Aturan Hansoku (Pelanggaran >= 4 otomatis kalah jika lawan belum terkena Hansoku)
        if ($akaDisqualified && !$aoDisqualified) {
            $winnerId = $validated['ao_kohai_id'];
        } elseif ($aoDisqualified && !$akaDisqualified) {
            $winnerId = $validated['aka_kohai_id'];
        } elseif ($akaTotal > $aoTotal) {
            // 2. Berdasarkan Poin Tertinggi WKF
            $winnerId = $validated['aka_kohai_id'];
        } elseif ($aoTotal > $akaTotal) {
            $winnerId = $validated['ao_kohai_id'];
        } else {
            // 3. Jika poin sama (draw point), pemenang ditentukan oleh peraih SENSHU Aktif
            if ($senshuCorner === 'aka') {
                $winnerId = $validated['aka_kohai_id'];
            } elseif ($senshuCorner === 'ao') {
                $winnerId = $validated['ao_kohai_id'];
            } else {
                // Tidak ada Senshu aktif -> Hasil Seri (Draw / Hantei)
                $winnerId = null;
            }
        }

        // Hitung Total Durasi Pertandingan (Detik)
        $durationMinutes = isset($validated['duration_minutes']) ? (int) $validated['duration_minutes'] : 3;
        $durationSecs = isset($validated['duration_seconds']) ? (int) $validated['duration_seconds'] : 0;
        $totalDuration = ($durationMinutes * 60) + $durationSecs;
        if ($totalDuration <= 0) {
            $totalDuration = 180; // Default WKF 3 Menit
        }

        // Simpan Data Kumite Report
        $report = KumiteReport::create([
            'senpai_id' => auth()->id(),
            'aka_kohai_id' => $validated['aka_kohai_id'],
            'ao_kohai_id' => $validated['ao_kohai_id'],
            'match_date' => $validated['match_date'],
            'match_time' => $validated['match_time'],
            'duration_seconds' => $totalDuration,

            'senshu_corner' => $senshuCorner,

            'aka_ippon' => $validated['aka_ippon'],
            'aka_wazaari' => $validated['aka_wazaari'],
            'aka_yuko' => $validated['aka_yuko'],
            'aka_fouls' => $validated['aka_fouls'],
            'aka_score_attack' => $akaAttack,
            'aka_score_accuracy' => $akaAccuracy,
            'aka_total_score' => $akaTotal,
            'aka_evaluation_notes' => $validated['aka_evaluation_notes'] ?? null,

            'ao_ippon' => $validated['ao_ippon'],
            'ao_wazaari' => $validated['ao_wazaari'],
            'ao_yuko' => $validated['ao_yuko'],
            'ao_fouls' => $validated['ao_fouls'],
            'ao_score_attack' => $aoAttack,
            'ao_score_accuracy' => $aoAccuracy,
            'ao_total_score' => $aoTotal,
            'ao_evaluation_notes' => $validated['ao_evaluation_notes'] ?? null,

            'winner_id' => $winnerId,
        ]);

        // Simpan Log Senshu & Riwayat Senshu Cancelling
        if (!empty($senshuLogsInput) && is_array($senshuLogsInput)) {
            foreach ($senshuLogsInput as $index => $logItem) {
                $corner = in_array($logItem['corner'] ?? '', ['aka', 'ao']) ? $logItem['corner'] : null;
                $status = in_array($logItem['status'] ?? '', ['active', 'cancelled', 'none']) ? $logItem['status'] : 'active';
                KumiteSenshuLog::create([
                    'kumite_report_id' => $report->id,
                    'sequence' => $index + 1,
                    'corner' => $corner,
                    'status' => $status,
                    'notes' => $logItem['notes'] ?? null,
                ]);
            }
        } elseif ($senshuCorner) {
            // Senshu tunggal tanpa pembatalan
            KumiteSenshuLog::create([
                'kumite_report_id' => $report->id,
                'sequence' => 1,
                'corner' => $senshuCorner,
                'status' => 'active',
                'notes' => 'Senshu Awal Pertandingan',
            ]);
        }

        return redirect()->route('senpai.kumite.index')
            ->with('success', 'Raport Kumite WKF berhasil disimpan!');
    }

    /**
     * Tampilkan detail Raport Kumite dari sudut pandang Senpai.
     */
    public function show(KumiteReport $kumiteReport): View
    {
        $kumiteReport->load(['senpai', 'akaKohai', 'aoKohai', 'winner', 'senshuLogs']);

        return view('senpai.kumite.show', compact('kumiteReport'));
    }
}
