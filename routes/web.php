<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Kohai\DashboardController as KohaiDashboardController;
use App\Http\Controllers\Kohai\KumiteController as KohaiKumiteController;
use App\Http\Controllers\Senpai\DashboardController as SenpaiDashboardController;
use App\Http\Controllers\Senpai\KohaiOverviewController;
use App\Http\Controllers\Senpai\KumiteController as SenpaiKumiteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Redirect Root to Login or Role Dashboard
Route::get('/', function () {
    if (Auth::check()) {
        return redirect(Auth::user()->getDashboardRoute());
    }

    return redirect()->route('login');
});

// Guest Routes (Auth Manual)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Authenticated Logout Route
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Role: Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
});

// Role: Senpai Routes
Route::middleware(['auth', 'role:Senpai'])->prefix('senpai')->name('senpai.')->group(function () {
    Route::get('/dashboard', [SenpaiDashboardController::class, 'index'])->name('dashboard');
    
    // Daftar & Detail Performa Kohai
    Route::get('/kohai', [KohaiOverviewController::class, 'index'])->name('kohai.index');
    Route::get('/kohai/{kohai}', [KohaiOverviewController::class, 'show'])->name('kohai.show');

    // Raport Kumite Senpai Routes
    Route::get('/kumite', [SenpaiKumiteController::class, 'index'])->name('kumite.index');
    Route::get('/kumite/create', [SenpaiKumiteController::class, 'create'])->name('kumite.create');
    Route::post('/kumite', [SenpaiKumiteController::class, 'store'])->name('kumite.store');
    Route::get('/kumite/{kumiteReport}', [SenpaiKumiteController::class, 'show'])->name('kumite.show');
});

// Role: Kohai Routes
Route::middleware(['auth', 'role:Kohai'])->prefix('kohai')->name('kohai.')->group(function () {
    Route::get('/dashboard', [KohaiDashboardController::class, 'index'])->name('dashboard');

    // Raport Kumite Kohai Routes
    Route::get('/kumite', [KohaiKumiteController::class, 'index'])->name('kumite.index');
    Route::get('/kumite/{kumiteReport}', [KohaiKumiteController::class, 'show'])->name('kumite.show');
});
