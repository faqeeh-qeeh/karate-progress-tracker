<?php

namespace App\Http\Controllers\Senpai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Display the Senpai Settings & Appearance Preferences Page.
     */
    public function index(): View
    {
        $user = auth()->user()->load([
            'senpaiProfile.rank.belt',
        ]);

        $systemInfo = [
            'app_name' => config('app.name', 'karate-progress-tracker-Polindra'),
            'timezone' => config('app.timezone', 'Asia/Jakarta'),
            'role' => 'Senpai / Pelatih Dojo',
        ];

        return view('senpai.settings.index', compact('user', 'systemInfo'));
    }
}
