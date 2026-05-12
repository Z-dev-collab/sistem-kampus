<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ValidationController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;

// Auth Routes
Route::get('/', fn() => redirect()->route('login'));
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// Authenticated Routes
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // === SISWA Routes ===
    Route::middleware('role:siswa')->group(function () {
        Route::resource('journals', JournalController::class);
        Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::get('/attendance/checkin', [AttendanceController::class, 'checkin'])->name('attendance.checkin');
        Route::post('/attendance/checkin', [AttendanceController::class, 'storeCheckin'])->name('attendance.store.checkin');
        Route::post('/attendance/checkout', [AttendanceController::class, 'storeCheckout'])->name('attendance.store.checkout');
    });

    // === PEMBIMBING INDUSTRI Routes ===
    Route::middleware('role:pembimbing_industri')->prefix('validation')->name('validation.')->group(function () {
        Route::get('/', [ValidationController::class, 'index'])->name('index');
        Route::get('/{journal}', [ValidationController::class, 'review'])->name('review');
        Route::post('/{journal}/approve', [ValidationController::class, 'approve'])->name('approve');
        Route::post('/{journal}/reject', [ValidationController::class, 'reject'])->name('reject');
    });

    // === GURU PEMBIMBING Routes ===
    Route::middleware('role:guru_pembimbing')->group(function () {
        Route::get('/assessments', [AssessmentController::class, 'index'])->name('assessments.index');
        Route::get('/assessments/{student}/create', [AssessmentController::class, 'create'])->name('assessments.create');
        Route::post('/assessments', [AssessmentController::class, 'store'])->name('assessments.store');
    });

    // === REPORTS (guru & admin) ===
    Route::middleware('role:guru_pembimbing,admin,siswa')->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/{student}', [ReportController::class, 'studentReport'])->name('reports.student');
    });

    // === ADMIN Routes ===
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserManagementController::class)->except('show');
        Route::resource('industries', IndustryController::class)->except('show');
        Route::resource('periods', PeriodController::class)->except('show');
    });
});
