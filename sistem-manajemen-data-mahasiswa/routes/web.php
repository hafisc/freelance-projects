<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\MahasiswaController;

// Rute Halaman Utama (Mengarahkan ke halaman login)
Route::redirect('/', '/login');

// Rute Autentikasi Admin
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute yang Dilindungi oleh Middleware Auth
Route::middleware(['auth'])->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // CRUD Data Jurusan (Menggunakan Resource Controller)
    Route::resource('jurusan', JurusanController::class);

    // CRUD Data Mahasiswa (Menggunakan Resource Controller)
    Route::resource('mahasiswa', MahasiswaController::class);
});
