<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\JadwalPembelajaranController;
use App\Http\Controllers\KegiatanBelajarController;

// Auth Routes
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.process');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Shared Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Dosen Routes
Route::middleware(['auth', 'role:Dosen'])->group(function () {
    Route::get('/dosen/jadwal', [JadwalPembelajaranController::class, 'jadwalDosen'])->name('dosen.jadwal');
    Route::get('/dosen/kegiatan', [KegiatanBelajarController::class, 'kegiatanDosen'])->name('dosen.kegiatan');
    Route::get('/dosen/kegiatan/create', [KegiatanBelajarController::class, 'createKegiatanDosen'])->name('dosen.kegiatan.create');
    Route::post('/dosen/kegiatan', [KegiatanBelajarController::class, 'storeKegiatanDosen'])->name('dosen.kegiatan.store');
    Route::get('/dosen/kegiatan/{kegiatan}/edit', [KegiatanBelajarController::class, 'editKegiatanDosen'])->name('dosen.kegiatan.edit');
    Route::put('/dosen/kegiatan/{kegiatan}', [KegiatanBelajarController::class, 'updateKegiatanDosen'])->name('dosen.kegiatan.update');
});

// Mahasiswa Routes
Route::middleware(['auth', 'role:Mahasiswa'])->group(function () {
    Route::get('/mahasiswa/jadwal', [JadwalPembelajaranController::class, 'jadwalMahasiswa'])->name('mahasiswa.jadwal');
    Route::get('/mahasiswa/kegiatan', [KegiatanBelajarController::class, 'kegiatanMahasiswa'])->name('mahasiswa.kegiatan');
});

// Kaprodi Routes
Route::middleware(['auth', 'role:Kaprodi'])->group(function () {
    Route::get('/kaprodi/jadwal', [JadwalPembelajaranController::class, 'monitoringJadwal'])->name('kaprodi.jadwal');
    Route::get('/kaprodi/kegiatan', [KegiatanBelajarController::class, 'monitoringKegiatan'])->name('kaprodi.kegiatan');
});

// Admin Routes
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::resource('/users', UserController::class);
    Route::resource('/mahasiswa', MahasiswaController::class);
    Route::resource('/dosen', DosenController::class);
    Route::resource('/mata-kuliah', MataKuliahController::class);
    Route::resource('/kelas', KelasController::class);
    Route::resource('/jadwal-pembelajaran', JadwalPembelajaranController::class);
    Route::resource('/kegiatan-belajar', KegiatanBelajarController::class)->except(['show']);
});

// Shared wildcard detail route (placed at the bottom to avoid route parameter collision)
Route::middleware(['auth'])->group(function () {
    Route::get('/kegiatan-belajar/{kegiatan}', [KegiatanBelajarController::class, 'show'])->name('kegiatan-belajar.show');
});
