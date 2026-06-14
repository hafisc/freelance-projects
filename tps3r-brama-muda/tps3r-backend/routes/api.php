<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EducationController;
use App\Http\Controllers\Api\ReportController; // Tambahkan import ini
use App\Http\Controllers\Api\MemberController; // Import MemberController
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ==========================================
// Authentication Routes
// ==========================================

// Public Authentication Routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
});

// Protected Authentication Routes
Route::prefix('auth')->middleware('auth:sanctum')->group(function () {
    // Profile
    Route::get('/profile', [AuthController::class, 'profile'])->name('auth.profile');
    Route::put('/profile/update', [AuthController::class, 'updateProfile'])->name('auth.profile.update');
    Route::put('/profile/change-password', [AuthController::class, 'changePassword'])->name('auth.profile.change-password');
    Route::post('/profile/upload-avatar', [AuthController::class, 'uploadAvatar'])->name('auth.profile.upload-avatar');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::post('/logout-all', [AuthController::class, 'logoutAll'])->name('auth.logout-all');
});

// ==========================================
// Education Routes
// ==========================================

// Public Education Routes (for member app)
Route::get('/educations', [EducationController::class, 'index'])->name('educations.index');
Route::get('/educations/{education}', [EducationController::class, 'show'])->name('educations.show');

// Protected Education Routes (admin only)
Route::middleware('auth:sanctum')->prefix('educations')->group(function () {
    Route::post('/', [EducationController::class, 'store'])->name('educations.store');
    Route::put('/{education}', [EducationController::class, 'update'])->name('educations.update');
    Route::delete('/{education}', [EducationController::class, 'destroy'])->name('educations.destroy');
});

// ==========================================
// Waste Report / Verification Routes (Member & Admin)
// ==========================================
Route::middleware('auth:sanctum')->group(function () {
    // Mobile App: Member mengirimkan laporan sampah baru
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');

    // Admin App: Mengambil daftar laporan untuk halaman Verifikasi
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    // Admin App: Memverifikasi laporan (terima/tolak)
    Route::put('/reports/{id}/verify', [ReportController::class, 'verify'])->name('reports.verify');

    // Member Management Routes
    Route::get('/members', [MemberController::class, 'index'])->name('members.index');
    Route::post('/members', [MemberController::class, 'store'])->name('members.store');
    Route::put('/members/{id}', [MemberController::class, 'update'])->name('members.update');
    Route::delete('/members/{id}', [MemberController::class, 'destroy'])->name('members.destroy');
});

// ==========================================
// Default Sanctum Route (Optional)
// ==========================================
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});