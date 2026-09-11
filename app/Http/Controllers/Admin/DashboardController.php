<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the Admin Dashboard.
     */
    public function index(): View
    {
        $totalUsers = User::count();
        $totalSenpai = User::whereHas('role', fn($q) => $q->where('nama', 'Senpai'))->count();
        $totalKohai = User::whereHas('role', fn($q) => $q->where('nama', 'Kohai'))->count();
        $users = User::with('role')->latest()->take(10)->get();

        return view('admin.dashboard', compact('totalUsers', 'totalSenpai', 'totalKohai', 'users'));
    }
}
