<?php

use App\Http\Controllers\AccountActivationController;
use App\Http\Controllers\Admin\AcademicClassController;
use App\Http\Controllers\Admin\BeltController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\RankController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\StudyProgramController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\Kohai\AttendanceController as KohaiAttendanceController;
use App\Http\Controllers\Kohai\DashboardController as KohaiDashboardController;
use App\Http\Controllers\Kohai\KumiteController as KohaiKumiteController;
use App\Http\Controllers\Kohai\ProfileController as KohaiProfileController;
use App\Http\Controllers\Kohai\SettingController as KohaiSettingController;
use App\Http\Controllers\Senpai\AttendanceController as SenpaiAttendanceController;
use App\Http\Controllers\Senpai\DashboardController as SenpaiDashboardController;
use App\Http\Controllers\Senpai\KohaiOverviewController;
use App\Http\Controllers\Senpai\KumiteController as SenpaiKumiteController;
use App\Http\Controllers\Senpai\ProfileController as SenpaiProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Redirect Root to Login or Role Dashboard
Route::get('/', function () {
    if (Auth::check()) {
        return redirect(Auth::user()->getDashboardRoute());
    }

    return redirect()->route('login');
});

// Guest Routes (Auth Manual & OAuth)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    // Google OAuth Routes
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

    // Lupa Kata Sandi & Verifikasi OTP (5 Menit) + Reset Sandi (2 Jam)
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])->name('password.email');
    Route::get('/verify-otp', [ForgotPasswordController::class, 'showVerifyOtpForm'])->name('password.otp.show');
    Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('password.otp.verify');
    Route::post('/resend-otp', [ForgotPasswordController::class, 'resendOtp'])->name('password.otp.resend');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('password.reset.form');
    Route::post('/reset-password/{token}', [ForgotPasswordController::class, 'resetPassword'])->name('password.reset.submit');
});

// Aktivasi Akun & Pengaturan Kata Sandi Pengguna Baru (Signed URL)
Route::get('/activate-account/{id}/{hash}', [AccountActivationController::class, 'show'])->name('account.activate');
Route::post('/activate-account/{id}/{hash}', [AccountActivationController::class, 'activate'])->name('account.activate.post');

// Authenticated Logout Route
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Role: Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::post('users/{user}/resend-activation', [UserController::class, 'resendActivation'])->name('users.resend-activation');
    Route::resource('users', UserController::class);
    Route::resource('belts', BeltController::class);
    Route::resource('ranks', RankController::class)->only(['store', 'update', 'destroy']);
    Route::resource('departments', DepartmentController::class);
    Route::resource('study-programs', StudyProgramController::class)->only(['store', 'update', 'destroy']);
    Route::resource('academic-classes', AcademicClassController::class)->only(['store', 'update', 'destroy']);
});

// Role: Senpai Routes
Route::middleware(['auth', 'role:Senpai'])->prefix('senpai')->name('senpai.')->group(function () {
    Route::get('/dashboard', [SenpaiDashboardController::class, 'index'])->name('dashboard');
    
    // Biodata & Profil Senpai
    Route::get('/profile', [SenpaiProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [SenpaiProfileController::class, 'update'])->name('profile.update');

    // Daftar & Detail Performa Kohai
    Route::get('/kohai', [KohaiOverviewController::class, 'index'])->name('kohai.index');
    Route::get('/kohai/{kohai}', [KohaiOverviewController::class, 'show'])->name('kohai.show');

    // Raport Kumite Senpai Routes
    Route::get('/kumite', [SenpaiKumiteController::class, 'index'])->name('kumite.index');
    Route::get('/kumite/create', [SenpaiKumiteController::class, 'create'])->name('kumite.create');
    Route::post('/kumite', [SenpaiKumiteController::class, 'store'])->name('kumite.store');
    Route::get('/kumite/{kumiteReport}', [SenpaiKumiteController::class, 'show'])->name('kumite.show');

    // Absensi QR Senpai Routes
    Route::get('/attendance', [SenpaiAttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance', [SenpaiAttendanceController::class, 'store'])->name('attendance.store');
    Route::get('/attendance/{attendanceSession}', [SenpaiAttendanceController::class, 'show'])->name('attendance.show');
    Route::post('/attendance/{attendanceSession}/close', [SenpaiAttendanceController::class, 'close'])->name('attendance.close');
    Route::post('/attendance/{attendanceSession}/reactivate', [SenpaiAttendanceController::class, 'reactivate'])->name('attendance.reactivate');
    Route::get('/attendance/{attendanceSession}/attendees', [SenpaiAttendanceController::class, 'attendees'])->name('attendance.attendees');
});

// Role: Kohai Routes
Route::middleware(['auth', 'role:Kohai'])->prefix('kohai')->name('kohai.')->group(function () {
    Route::get('/dashboard', [KohaiDashboardController::class, 'index'])->name('dashboard');

    // Biodata & Profil Kohai
    Route::get('/profile', [KohaiProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [KohaiProfileController::class, 'update'])->name('profile.update');

    // Raport Kumite Kohai Routes
    Route::get('/kumite', [KohaiKumiteController::class, 'index'])->name('kumite.index');
    Route::get('/kumite/{kumiteReport}', [KohaiKumiteController::class, 'show'])->name('kumite.show');

    // Absensi QR Kohai Routes
    Route::get('/attendance', [KohaiAttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance/scan', [KohaiAttendanceController::class, 'scan'])->name('attendance.scan');
    Route::get('/attendance/direct-scan/{token}', [KohaiAttendanceController::class, 'directScan'])->name('attendance.direct_scan');

    // Pengaturan & Preferensi Tampilan Kohai
    Route::get('/settings', [KohaiSettingController::class, 'index'])->name('settings.index');
});
