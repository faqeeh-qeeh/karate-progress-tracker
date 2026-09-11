<?php

namespace App\Http\Controllers\Senpai;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the Senpai (Instructor) Dashboard.
     */
    public function index(): View
    {
        $kohaiList = User::whereHas('role', fn($q) => $q->where('nama', 'Kohai'))->latest()->get();

        $schedules = [
            [
                'hari' => 'Selasa',
                'jam' => '16:00 - 18:00',
                'materi' => 'Kihon & Kata (Heian & Bassai Dai)',
                'lokasi' => 'Dojo Utama',
            ],
            [
                'hari' => 'Jumat',
                'jam' => '16:00 - 18:00',
                'materi' => 'Kumite & Sparring Drill',
                'lokasi' => 'Dojo Utama',
            ],
        ];

        return view('senpai.dashboard', compact('kohaiList', 'schedules'));
    }
}
