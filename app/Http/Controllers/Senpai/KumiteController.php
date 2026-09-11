<?php

namespace App\Http\Controllers\Senpai;

use App\Http\Controllers\Controller;
use App\Models\KumiteReport;
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
            ->paginate(10);

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
            
            // Senshu Single Choice (Wajib Dipilih)
            'senshu_corner' => ['required', 'in:aka,ao'],

            // Stats AKA
            'aka_ippon' => ['required', 'integer', 'min:0'],
            'aka_wazaari' => ['required', 'integer', 'min:0'],
            'aka_yuko' => ['required', 'integer', 'min:0'],
            'aka_c1' => ['required', 'integer', 'min:0'],
            'aka_c2' => ['required', 'integer', 'min:0'],
            'aka_ce' => ['boolean'],
            'aka_hc' => ['boolean'],
            'aka_h' => ['boolean'],
            'aka_score_attack' => ['required', 'integer', 'between:1,10'],
            'aka_score_accuracy' => ['required', 'integer', 'between:1,10'],
            'aka_evaluation_notes' => ['nullable', 'string', 'max:2000'],

            // Stats AO
            'ao_ippon' => ['required', 'integer', 'min:0'],
            'ao_wazaari' => ['required', 'integer', 'min:0'],
            'ao_yuko' => ['required', 'integer', 'min:0'],
            'ao_c1' => ['required', 'integer', 'min:0'],
            'ao_c2' => ['required', 'integer', 'min:0'],
            'ao_ce' => ['boolean'],
            'ao_hc' => ['boolean'],
            'ao_h' => ['boolean'],
            'ao_score_attack' => ['required', 'integer', 'between:1,10'],
            'ao_score_accuracy' => ['required', 'integer', 'between:1,10'],
            'ao_evaluation_notes' => ['nullable', 'string', 'max:2000'],
        ], [
            'aka_kohai_id.required' => 'Kohai sudut Merah (AKA) wajib dipilih.',
            'ao_kohai_id.required' => 'Kohai sudut Biru (AO) wajib dipilih.',
            'ao_kohai_id.different' => 'Kohai sudut Biru (AO) tidak boleh sama dengan Kohai sudut Merah (AKA).',
            'match_date.required' => 'Tanggal pertandingan wajib diisi.',
            'match_time.required' => 'Jam pertandingan wajib diisi.',
            'senshu_corner.required' => 'SENSHU (Keunggulan Poin Pertama) wajib dipilih (AKA atau AO).',
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

        $senshuCorner = $validated['senshu_corner'];

        // Tentukan Pemenang Berdasarkan Aturan WKF (Skor tertinggi / SENSHU jika skor sama)
        if ($akaTotal > $aoTotal) {
            $winnerId = $validated['aka_kohai_id'];
        } elseif ($aoTotal > $akaTotal) {
            $winnerId = $validated['ao_kohai_id'];
        } else {
            // Jika poin sama (draw point), pemenang ditentukan oleh peraih SENSHU
            $winnerId = ($senshuCorner === 'aka') ? $validated['aka_kohai_id'] : $validated['ao_kohai_id'];
        }

        // Simpan Data
        KumiteReport::create([
            'senpai_id' => auth()->id(),
            'aka_kohai_id' => $validated['aka_kohai_id'],
            'ao_kohai_id' => $validated['ao_kohai_id'],
            'match_date' => $validated['match_date'],
            'match_time' => $validated['match_time'],

            'senshu_corner' => $senshuCorner,

            'aka_ippon' => $validated['aka_ippon'],
            'aka_wazaari' => $validated['aka_wazaari'],
            'aka_yuko' => $validated['aka_yuko'],
            'aka_c1' => $validated['aka_c1'],
            'aka_c2' => $validated['aka_c2'],
            'aka_ce' => $request->boolean('aka_ce'),
            'aka_hc' => $request->boolean('aka_hc'),
            'aka_h' => $request->boolean('aka_h'),
            'aka_score_attack' => $validated['aka_score_attack'],
            'aka_score_accuracy' => $validated['aka_score_accuracy'],
            'aka_total_score' => $akaTotal,
            'aka_evaluation_notes' => $validated['aka_evaluation_notes'] ?? null,

            'ao_ippon' => $validated['ao_ippon'],
            'ao_wazaari' => $validated['ao_wazaari'],
            'ao_yuko' => $validated['ao_yuko'],
            'ao_c1' => $validated['ao_c1'],
            'ao_c2' => $validated['ao_c2'],
            'ao_ce' => $request->boolean('ao_ce'),
            'ao_hc' => $request->boolean('ao_hc'),
            'ao_h' => $request->boolean('ao_h'),
            'ao_score_attack' => $validated['ao_score_attack'],
            'ao_score_accuracy' => $validated['ao_score_accuracy'],
            'ao_total_score' => $aoTotal,
            'ao_evaluation_notes' => $validated['ao_evaluation_notes'] ?? null,

            'winner_id' => $winnerId,
        ]);

        return redirect()->route('senpai.kumite.index')
            ->with('success', 'Raport Kumite WKF berhasil disimpan!');
    }

    /**
     * Tampilkan detail Raport Kumite dari sudut pandang Senpai.
     */
    public function show(KumiteReport $kumiteReport): View
    {
        $kumiteReport->load(['senpai', 'akaKohai', 'aoKohai', 'winner']);

        return view('senpai.kumite.show', compact('kumiteReport'));
    }
}
