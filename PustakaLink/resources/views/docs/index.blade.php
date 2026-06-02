@extends('layouts.app')

@section('page_title', 'Dokumentasi Sistem & Status Testing')

@section('content')
<div class="space-y-8">
    
    <!-- Header -->
    <div class="bg-white p-6 rounded-lg border border-libborder shadow-sm">
        <h2 class="text-base font-bold text-libnavy">Dokumentasi Sistem & Status Testing</h2>
        <p class="text-xs text-libmuted mt-1">Panduan lengkap arsitektur sistem informasi perpustakaan PustakaLink.</p>
    </div>

    <!-- Layout Grid 2 Kolom -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Kolom Kiri: Panduan & Pengujian -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Panduan Pengujian -->
            <div class="bg-white rounded-lg border border-libborder shadow-sm p-6 md:p-8 space-y-4">
                <h3 class="text-sm font-bold text-libnavy flex items-center space-x-2">
                    <svg class="w-5 h-5 text-libgold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Status & Panduan Unit Testing</span>
                </h3>
                <p class="text-xs text-libmuted leading-relaxed">
                    Aplikasi PustakaLink dilengkapi dengan pengujian otomatis menggunakan PHPUnit untuk memastikan kestabilan fitur sirkulasi buku, mutasi stok, dan pembatasan jatuh tempo otomatis.
                </p>
                <div class="bg-libcream p-4 rounded border border-libgold/20 space-y-2">
                    <span class="block text-[10px] font-bold text-libnavy uppercase tracking-wider">Perintah Menjalankan Pengujian</span>
                    <code class="block text-xs font-mono text-libdark bg-white p-2.5 rounded border border-libborder select-all">php artisan test</code>
                </div>
                <div class="space-y-2">
                    <span class="block text-[10px] font-bold text-libdark uppercase tracking-wider">Fitur yang Diuji dalam Unit/Feature Testing:</span>
                    <ul class="list-disc pl-5 text-xs text-libdark space-y-1.5">
                        <li><strong>Book CRUD</strong>: Memastikan admin/petugas dapat mengelola data buku bibliografi perpustakaan.</li>
                        <li><strong>Member CRUD</strong>: Memastikan pendaftaran dan perubahan data anggota tervalidasi dengan benar.</li>
                        <li><strong>Borrowing Creation & Due Date</strong>: Menguji apakah transaksi peminjaman berhasil disimpan dan tanggal kembali diatur <strong>otomatis 7 hari</strong> ke depan.</li>
                        <li><strong>Stock Decrement</strong>: Menguji apakah stok buku berkurang secara otomatis ketika peminjaman sukses dicatat.</li>
                        <li><strong>Stock Increment on Return</strong>: Menguji apakah stok buku kembali bertambah utuh ketika buku dikembalikan.</li>
                        <li><strong>Status Transition</strong>: Memastikan status peminjaman berubah tepat dari <code>borrowed</code> menjadi <code>returned</code>.</li>
                    </ul>
                </div>
            </div>

            <!-- Detail Alur Sirkulasi -->
            <div class="bg-white rounded-lg border border-libborder shadow-sm p-6 md:p-8 space-y-4">
                <h3 class="text-sm font-bold text-libnavy flex items-center space-x-2">
                    <svg class="w-5 h-5 text-libgold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                    <span>Alur Sirkulasi Peminjaman & Pengembalian</span>
                </h3>
                
                <!-- Timeline Alur -->
                <div class="space-y-4 text-xs text-libdark">
                    <div class="flex space-x-3 items-start">
                        <div class="w-5 h-5 rounded-full bg-libnavy text-white text-[10px] font-bold flex items-center justify-center flex-shrink-0 mt-0.5">1</div>
                        <div>
                            <strong class="text-libnavy block">Pencatatan Peminjaman</strong>
                            <p class="text-libmuted mt-0.5 leading-relaxed">Petugas memilih Anggota dan Buku yang tersedia (stok > 0), lalu mengisi tanggal pinjam. Sistem secara otomatis menghitung jatuh tempo 7 hari ke depan dengan pustaka Carbon.</p>
                        </div>
                    </div>
                    
                    <div class="flex space-x-3 items-start">
                        <div class="w-5 h-5 rounded-full bg-libnavy text-white text-[10px] font-bold flex items-center justify-center flex-shrink-0 mt-0.5">2</div>
                        <div>
                            <strong class="text-libnavy block">Mutasi Stok Pinjam</strong>
                            <p class="text-libmuted mt-0.5 leading-relaxed">Setelah disimpan, record transaksi dibuat di tabel <code>borrowings</code> dan <code>borrowing_details</code>, status diatur <code>borrowed</code>, dan stok buku dikurangi 1.</p>
                        </div>
                    </div>

                    <div class="flex space-x-3 items-start">
                        <div class="w-5 h-5 rounded-full bg-libnavy text-white text-[10px] font-bold flex items-center justify-center flex-shrink-0 mt-0.5">3</div>
                        <div>
                            <strong class="text-libnavy block">Proses Pengembalian</strong>
                            <p class="text-libmuted mt-0.5 leading-relaxed">Saat buku dikembalikan oleh anggota, petugas menekan tombol kembalikan. Sistem mengisi tanggal kembali hari ini, merubah status menjadi <code>returned</code>, dan menambah stok kembali.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Kolom Kanan: Detail Tabel / Database ERD -->
        <div class="lg:col-span-1 space-y-6">
            
            <!-- Info Kredensial -->
            <div class="bg-white rounded-lg border border-libborder shadow-sm p-6 space-y-4">
                <h3 class="text-sm font-bold text-libnavy flex items-center space-x-2">
                    <svg class="w-5 h-5 text-libgold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m-5-3a2 2 0 00-2 2v7a2 2 0 002 2h3a2 2 0 002-2V9a2 2 0 00-2-2h-3z"></path>
                    </svg>
                    <span>Kredensial Sesi Default</span>
                </h3>
                <div class="text-xs space-y-2 text-libdark">
                    <div class="flex justify-between py-1.5 border-b border-libborder">
                        <span class="text-libmuted">Email Sesi:</span>
                        <span class="font-semibold font-mono">admin@pustakalink.com</span>
                    </div>
                    <div class="flex justify-between py-1.5">
                        <span class="text-libmuted">Kata Sandi:</span>
                        <span class="font-semibold font-mono">password</span>
                    </div>
                </div>
            </div>

            <!-- Rancangan Tabel Database -->
            <div class="bg-white rounded-lg border border-libborder shadow-sm p-6 space-y-4">
                <h3 class="text-sm font-bold text-libnavy flex items-center space-x-2">
                    <svg class="w-5 h-5 text-libgold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                    </svg>
                    <span>Struktur Tabel Database</span>
                </h3>
                
                <div class="space-y-4 text-xs">
                    <!-- Users -->
                    <div class="space-y-1 bg-libcream p-3 rounded border border-libgold/10">
                        <strong class="text-libnavy block font-semibold">1. users (Kredensial Auth)</strong>
                        <span class="text-libmuted block font-mono text-[10px]">id, name, email, password, role, timestamps</span>
                    </div>

                    <!-- Members -->
                    <div class="space-y-1 bg-libcream p-3 rounded border border-libgold/10">
                        <strong class="text-libnavy block font-semibold">2. members (Data Anggota)</strong>
                        <span class="text-libmuted block font-mono text-[10px]">id, member_code (unique), name, gender, phone, address, timestamps</span>
                    </div>

                    <!-- Books -->
                    <div class="space-y-1 bg-libcream p-3 rounded border border-libgold/10">
                        <strong class="text-libnavy block font-semibold">3. books (Koleksi Buku)</strong>
                        <span class="text-libmuted block font-mono text-[10px]">id, book_code (unique), title, author, publisher, publication_year, category, stock, description, timestamps</span>
                    </div>

                    <!-- Borrowings -->
                    <div class="space-y-1 bg-libcream p-3 rounded border border-libgold/10">
                        <strong class="text-libnavy block font-semibold">4. borrowings (Sirkulasi Utama)</strong>
                        <span class="text-libmuted block font-mono text-[10px]">id, member_id (FK), borrow_date, due_date, return_date (nullable), status, notes, timestamps</span>
                    </div>

                    <!-- Borrowing Details -->
                    <div class="space-y-1 bg-libcream p-3 rounded border border-libgold/10">
                        <strong class="text-libnavy block font-semibold">5. borrowing_details (Sirkulasi Detail)</strong>
                        <span class="text-libmuted block font-mono text-[10px]">id, borrowing_id (FK cascade), book_id (FK restrict), quantity, timestamps</span>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
