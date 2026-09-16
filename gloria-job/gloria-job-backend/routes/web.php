<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\ApplicationManagementController;
use App\Http\Controllers\Admin\CompanyManagementController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JobManagementController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SystemInfoController;
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

    // CRUD Perusahaan (Companies)
    Route::get('/companies', [CompanyManagementController::class, 'index'])->name('companies.index');
    Route::get('/companies/create', [CompanyManagementController::class, 'create'])->name('companies.create');
    Route::post('/companies', [CompanyManagementController::class, 'store'])->name('companies.store');
    Route::get('/companies/{id}', [CompanyManagementController::class, 'show'])->name('companies.show');
    Route::get('/companies/{id}/edit', [CompanyManagementController::class, 'edit'])->name('companies.edit');
    Route::put('/companies/{id}', [CompanyManagementController::class, 'update'])->name('companies.update');
    Route::delete('/companies/{id}', [CompanyManagementController::class, 'destroy'])->name('companies.destroy');
    Route::post('/companies/{id}/share-applications', [CompanyManagementController::class, 'shareApplications'])->name('companies.share');

    // Manajemen Lamaran Masuk (Applications)
    Route::get('/applications', [ApplicationManagementController::class, 'index'])->name('applications.index');
    Route::get('/applications/export', [ApplicationManagementController::class, 'exportCsv'])->name('applications.export');
    Route::get('/applications/{id}', [ApplicationManagementController::class, 'show'])->name('applications.show');
    Route::get('/applications/{id}/cv', [ApplicationManagementController::class, 'downloadCv'])->name('applications.cv');
    Route::put('/applications/{id}/status', [ApplicationManagementController::class, 'updateStatus'])->name('applications.update-status');
    Route::post('/applications/{id}/share', [ApplicationManagementController::class, 'shareToCompany'])->name('applications.share');

    // Laporan (Reports)
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/statistics', [ReportController::class, 'statistics'])->name('reports.statistics');
    Route::get('/reports/export', [ReportController::class, 'exportExcel'])->name('reports.export');

    // Sistem Berjalan & Usulan Perbaikan
    Route::get('/system-info', [SystemInfoController::class, 'index'])->name('system.index');
});
