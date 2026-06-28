<?php
 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    LoginController,
    DashboardController,
    MahasiswaController,
    DosenController,
    MatakuliahController,
    KrsController,
    UserController,
    HakAksesController,
    KelasController,
    JadwalController,
    KegiatanBelajarController,
    AbsensiController
};
 
// =========================================================================
// 1. GATEWAY UTAMA & AUTHENTICATION
// =========================================================================
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'autentikasi'])->name('login.auth');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('logout', [LoginController::class, 'logout']);
 
// =========================================================================
// 2. DASHBOARD ROUTES (Role Specific)
// =========================================================================
Route::middleware(['cekSesi:Admin'])->get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
Route::middleware(['cekSesi:Operator'])->get('/operator/dashboard', [DashboardController::class, 'operator'])->name('operator.dashboard');
Route::middleware(['cekSesi:Dosen'])->get('/dosen/dashboard', [DashboardController::class, 'dosen'])->name('dosen.dashboard');
Route::middleware(['cekSesi:Mahasiswa'])->get('/mahasiswa/dashboard', [DashboardController::class, 'mahasiswa'])->name('mahasiswa.dashboard');
 
// =========================================================================
// 3. ADMIN ONLY FITUR (Kelola User & Hak Akses)
// =========================================================================
Route::middleware(['cekSesi:Admin'])->group(function () {
    Route::resource('admin/users', UserController::class)->names([
        'index' => 'users.index',
        'store' => 'users.store',
        'update' => 'users.update',
        'destroy' => 'users.destroy',
    ]);
    Route::get('admin/hak-akses', [HakAksesController::class, 'index'])->name('hak-akses.index');
});
 
// =========================================================================
// 4. ADMIN & OPERATOR FITUR (Kelola Data Master & Akademik)
// =========================================================================
Route::middleware(['cekSesi:Admin,Operator'])->group(function () {
    // CRUD Mahasiswa (Tetap pakai name route existing agar view kompatibel)
    Route::get('data-mahasiswa', [MahasiswaController::class, 'index'])->name('data-mahasiswa');
    Route::get('create-mahasiswa', [MahasiswaController::class, 'create'])->name('create-mahasiswa');
    Route::post('simpan-mahasiswa', [MahasiswaController::class, 'store'])->name('store-mahasiswa');
    Route::get('edit-mahasiswa/{nim}', [MahasiswaController::class, 'edit'])->name('edit-mahasiswa');
    Route::put('update-mahasiswa/{nim}', [MahasiswaController::class, 'update'])->name('update-mahasiswa');
    Route::delete('hapus-mahasiswa/{nim}', [MahasiswaController::class, 'destroy'])->name('hapus-mahasiswa');
 
    // CRUD Dosen
    Route::resource('dosen', DosenController::class)->except(['create', 'show', 'edit']);
    
    // CRUD Matakuliah
    Route::resource('matakuliah', MatakuliahController::class)->except(['create', 'show', 'edit']);
    
    // CRUD KRS
    Route::resource('krs', KrsController::class)->only(['index', 'store', 'destroy']);
    
    // CRUD Kelas
    Route::resource('kelas', KelasController::class)->except(['create', 'show', 'edit']);
});
 
// =========================================================================
// 5. JADWAL PEMBELAJARAN (Admin, Operator & Dosen CRUD, Mahasiswa View)
// =========================================================================
Route::middleware(['cekSesi:Admin,Operator,Dosen,Mahasiswa'])->group(function () {
    Route::get('jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
});
 
Route::middleware(['cekSesi:Admin,Dosen'])->group(function () {
    Route::post('jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
    Route::put('jadwal/{id}', [JadwalController::class, 'update'])->name('jadwal.update');
    Route::delete('jadwal/{id}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');
});
 
// =========================================================================
// 6. KEGIATAN PROSES BELAJAR (Admin & Dosen CRUD, Operator & Mahasiswa View)
// =========================================================================
Route::middleware(['cekSesi:Admin,Operator,Dosen,Mahasiswa'])->group(function () {
    Route::get('kegiatan', [KegiatanBelajarController::class, 'index'])->name('kegiatan.index');
});
 
Route::middleware(['cekSesi:Admin,Dosen'])->group(function () {
    Route::post('kegiatan', [KegiatanBelajarController::class, 'store'])->name('kegiatan.store');
    Route::put('kegiatan/{id}', [KegiatanBelajarController::class, 'update'])->name('kegiatan.update');
    Route::delete('kegiatan/{id}', [KegiatanBelajarController::class, 'destroy'])->name('kegiatan.destroy');
});
 
// =========================================================================
// 7. ABSENSI MAHASISWA (Dosen CRUD/Input, Mahasiswa/Operator/Admin View)
// =========================================================================
Route::middleware(['cekSesi:Admin,Operator,Dosen,Mahasiswa'])->group(function () {
    Route::get('absensi', [AbsensiController::class, 'index'])->name('absensi.index');
});
 
Route::middleware(['cekSesi:Admin,Dosen'])->group(function () {
    Route::post('absensi', [AbsensiController::class, 'store'])->name('absensi.store');
});