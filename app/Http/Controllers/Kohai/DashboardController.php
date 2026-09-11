<?php

namespace App\Http\Controllers\Kohai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the Kohai (Student) Dashboard.
     */
    public function index(): View
    {
        $user = auth()->user();

        $scheduleList = [
            [
                'hari' => 'Selasa',
                'jam' => '16:00 - 18:00',
                'materi' => 'Kihon & Kata Heian Shodan',
            ],
            [
                'hari' => 'Jumat',
                'jam' => '16:00 - 18:00',
                'materi' => 'Kihon Ippon Kumite & Sparring',
            ],
        ];

        return view('kohai.dashboard', compact('user', 'scheduleList'));
    }
}
