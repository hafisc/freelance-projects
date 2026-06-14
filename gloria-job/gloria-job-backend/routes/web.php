<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\ApplicationManagementController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JobManagementController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect halaman utama ke dashboard/login admin
Route::get('/', function () {
    if (Auth::guard('admin')->check()) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('admin.login');
});

// Admin Auth Routes (Guest)
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

// Middleware untuk Autentikasi Admin
Route::middleware('admin.auth')->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Logout
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // CRUD Lowongan Kerja (Jobs)
    Route::get('/jobs', [JobManagementController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/create', [JobManagementController::class, 'create'])->name('jobs.create');
    Route::post('/jobs', [JobManagementController::class, 'store'])->name('jobs.store');
    Route::get('/jobs/{id}/edit', [JobManagementController::class, 'edit'])->name('jobs.edit');
    Route::put('/jobs/{id}', [JobManagementController::class, 'update'])->name('jobs.update');
    Route::delete('/jobs/{id}', [JobManagementController::class, 'destroy'])->name('jobs.destroy');

    // Manajemen Lamaran Masuk (Applications)
    Route::get('/applications', [ApplicationManagementController::class, 'index'])->name('applications.index');
    Route::get('/applications/{id}', [ApplicationManagementController::class, 'show'])->name('applications.show');
    Route::put('/applications/{id}/status', [ApplicationManagementController::class, 'updateStatus'])->name('applications.update-status');
});
