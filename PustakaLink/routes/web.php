<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\DocsController;

// Rute Halaman Awal / Pengalihan Login
Route::get('/', function () {
    return redirect()->route('login');
});

// Rute Autentikasi Admin/Petugas
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rute yang Dilindungi Sesi Login
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD Anggota
    Route::resource('members', MemberController::class);

    // CRUD Buku / Koleksi
    Route::resource('books', BookController::class);

    // Katalog Buku
    Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');

    // Transaksi Peminjaman & Pengembalian Buku
    Route::get('/borrowings/history', [BorrowingController::class, 'history'])->name('borrowings.history');
    Route::resource('borrowings', BorrowingController::class)->only(['index', 'create', 'store', 'show']);
    Route::patch('/borrowings/{borrowing}/return', [BorrowingController::class, 'returnBook'])->name('borrowings.return');

    // Dokumentasi & Testing
    Route::get('/docs', [DocsController::class, 'index'])->name('docs.index');
});
