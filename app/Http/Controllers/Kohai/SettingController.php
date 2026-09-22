<?php

namespace App\Http\Controllers\Kohai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Display the Kohai Settings & Appearance Preferences Page.
     */
    public function index(): View
    {
        $user = auth()->user()->load([
            'kohaiProfile.rank.belt',
            'kohaiProfile.studyProgram.department',
            'kohaiProfile.academicClass',
        ]);

        $systemInfo = [
            'app_name' => config('app.name', 'karate-progress-tracker-Polindra'),
            'timezone' => config('app.timezone', 'Asia/Jakarta'),
            'role' => 'Kohai / Murid Dojo',
        ];

        return view('kohai.settings.index', compact('user', 'systemInfo'));
    }
}
