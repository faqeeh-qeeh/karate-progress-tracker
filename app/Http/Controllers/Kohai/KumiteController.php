<?php

namespace App\Http\Controllers\Kohai;

use App\Http\Controllers\Controller;
use App\Models\KumiteReport;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KumiteController extends Controller
{
    /**
     * Tampilkan riwayat Raport Kumite milik Kohai yang sedang login.
     */
    public function index(): View
    {
        $userId = auth()->id();

        $reports = KumiteReport::with(['senpai', 'akaKohai', 'aoKohai', 'winner'])
            ->where(function ($q) use ($userId) {
                $q->where('aka_kohai_id', $userId)
                  ->orWhere('ao_kohai_id', $userId);
            })
            ->latest('match_date')
            ->latest('match_time')
            ->paginate(10)
            ->withQueryString();

        return view('kohai.kumite.index', compact('reports'));
    }

    /**
     * Tampilkan detail Rincian Raport Kumite milik Kohai dengan proteksi keamanan ketat.
     */
    public function show(KumiteReport $kumiteReport): View
    {
        $userId = auth()->id();

        // Keamanan Ketat: Hanya izinkan jika Kohai yang sedang login merupakan peserta (AKA atau AO)
        if ($kumiteReport->aka_kohai_id !== $userId && $kumiteReport->ao_kohai_id !== $userId) {
            abort(403, 'Akses Ditolak. Anda hanya dapat melihat Raport Kumite untuk pertandingan yang Anda ikuti.');
        }

        $kumiteReport->load(['senpai', 'akaKohai', 'aoKohai', 'winner']);

        return view('kohai.kumite.show', compact('kumiteReport'));
    }
}
