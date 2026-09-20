<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Display the Admin Settings & Preferences Page.
     */
    public function index(): View
    {
        $systemInfo = [
            'app_name' => config('app.name', 'karate-progress-tracker-Polindra'),
            'app_env' => config('app.env', 'local'),
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'timezone' => config('app.timezone', 'Asia/Jakarta'),
        ];

        return view('admin.settings.index', compact('systemInfo'));
    }
}
