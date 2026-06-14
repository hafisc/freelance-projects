# 📚 PustakaLink - Sistem Informasi Perpustakaan

**PustakaLink** adalah aplikasi sistem informasi perpustakaan berbasis web yang modern dan responsif. Dibangun menggunakan framework **Laravel (v13.x)** dan database **MySQL**, aplikasi ini dirancang secara khusus untuk mempermudah operasional sirkulasi buku pada perpustakaan internal sekolah, kampus, maupun instansi.

Aplikasi ini ditujukan untuk kebutuhan tugas praktik demonstrasi programmer dengan menerapkan penulisan kode terstruktur, modularitas logika bisnis (*Service Layer*), pengujian otomatis (*Unit Testing*), serta antarmuka visual premium bertema **Clean Academic Library System** (Harmoni Flat Navy, Cream, & Gold).

---

## 🚀 Fitur Utama & Alur Sistem

*   **Autentikasi Internal Tunggal**: Sistem login aman untuk petugas perpustakaan (**Admin/Petugas**) tanpa registrasi publik guna menjaga integritas data perpustakaan.
*   **Dashboard Statistik Real-time**: Memantau total judul buku, jumlah anggota aktif, sirkulasi peminjaman berjalan, dan total stok buku fisik yang siap sirkulasi.
*   **Manajemen Anggota (CRUD)**: Pengelolaan penuh data anggota dengan fitur generate otomatis kode anggota secara incremental (misal: `AGT-0005`).
*   **Manajemen Buku & Kategori (CRUD)**: Pengelolaan koleksi pustaka beserta pencatatan kuantitas stok fisik dan generate otomatis kode buku (misal: `BK-0006`).
*   **Katalog Buku Visual**: Tampilan grid koleksi buku modern dengan micro-animation hover, pencarian kata kunci dinamis, dan filter kategori.
*   **Pencatatan Peminjaman Otomatis**: Transaksi peminjaman 1 buku dengan kalkulasi tanggal jatuh tempo **otomatis 7 hari** ke depan menggunakan library Carbon.
*   **Proteksi Stok Kosong**: Validasi database yang mencegah peminjaman buku apabila stok fisik bernilai `0`.
*   **Pengembalian Cepat (Instant Return)**: Proses pengembalian buku sekali klik yang otomatis mengisi tanggal pengembalian hari ini, memperbarui status menjadi `returned`, dan mengembalikan (+1) kuantitas stok buku fisik.
*   **Log Riwayat Sirkulasi**: Menyimpan log sirkulasi lengkap seluruh transaksi perpustakaan untuk audit data.
*   **Dokumentasi & Status Test**: Halaman panduan terintegrasi di dalam aplikasi yang merangkum arsitektur database, kredensial demo, dan status pengujian.

---

## 🛠️ Spesifikasi Teknologi

*   **Framework Core**: Laravel 13.x
*   **Bahasa Pemrograman**: PHP 8.2+
*   **Database Engine**: MySQL / MariaDB (InnoDB)
*   **Antarmuka Visual (UI/UX)**: HTML Blade & Vanilla CSS + Tailwind CSS (Curated Color Palette: Navy `#1E3A5F`, Cream `#F8F5EF`, Gold `#D9A441`)
*   **Penanganan Waktu**: Carbon Library (Default timezone Asia/Jakarta)
*   **Unit Testing**: PHPUnit (Laravel Testing framework)

---

## 📁 Rancangan Desain & UML Sistem

Seluruh rancangan diagram sistem dan relasi database telah dikompilasi secara rapi ke dalam dokumen Excel yang ditujukan khusus untuk laporan klien:

*   **Berkas Desain UML**: [`docs/PustakaLink_UML.xlsx`](file:///c:/laragon/www/PustakaLink/docs/PustakaLink_UML.xlsx)
*   **Isi Sheet Laporan**:
    1.  **Use Case Diagram**: Hubungan aktor Admin/Petugas dengan 9 use case utama.
    2.  **Activity Diagram - Login**: Alur logis autentikasi petugas masuk ke dashboard.
    3.  **Activity Diagram - Peminjaman**: Alur langkah pencatatan transaksi dan validasi stok.
    4.  **Class Diagram**: Representasi Class OOP Laravel (`User`, `Member`, `Book`, `Borrowing`, `BorrowingDetail`) beserta method dan relasinya.
    5.  **Sequence Diagram**: Logika sekuensial penyimpanan data sirkulasi, manipulasi stok, dan Carbon date math.
    6.  **ERD Relasi Database**: Rancangan skema tabel MySQL lengkap dengan tipe data, Primary Key, Foreign Key, dan constraint.
    7.  **Catatan Spesifikasi**: Informasi arsitektur, parameter, dan ketentuan sirkulasi perpustakaan.

---

## 💻 Panduan Instalasi & Menjalankan Project

Ikuti langkah-langkah di bawah ini untuk memasang PustakaLink di lingkungan lokal Anda:

### 1. Persiapan Awal
Pastikan komputer Anda sudah terinstal **PHP (v8.2+)**, **Composer**, dan **MySQL Server** (direkomendasikan menggunakan Laragon atau XAMPP).

### 2. Memasang Dependensi
Buka terminal di root direktori project, lalu unduh pustaka dependensi Laravel:
```bash
composer install
```

### 3. Konfigurasi Database (.env)
Salin berkas template `.env.example` menjadi `.env`:
```bash
copy .env.example .env
```
Buka berkas `.env` tersebut dan sesuaikan kredensial koneksi database MySQL Anda. Contoh untuk Laragon/XAMPP:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pustakalink_db
DB_USERNAME=root
DB_PASSWORD=
```
> **Penting**: Pastikan Anda telah membuat database kosong bernama `pustakalink_db` di server MySQL (misalnya melalui phpMyAdmin atau Database Manager) sebelum melanjutkan ke tahap berikutnya.

### 4. Membuat Application Key
Lakukan generate enkripsi key bawaan Laravel:
```bash
php artisan key:generate
```

### 5. Migrasi & Seeding Database
Jalankan perintah berikut untuk mengonstruksi seluruh tabel database perpustakaan sekaligus mengimpor data sampel default (Petugas, Anggota, dan Buku):
```bash
php artisan migrate:fresh --seed
```

### 6. Menjalankan Server Lokal
Nyalakan server lokal Laravel:
```bash
php artisan serve
```
Setelah server aktif, buka web browser Anda dan akses tautan berikut:
```txt
http://127.0.0.1:8000
```

---

## 🔑 Kredensial Akses Default (Seeder)

Gunakan akun administrator tunggal di bawah ini untuk masuk ke dashboard PustakaLink:

| Peran (Role) | Alamat Email | Kata Sandi (Password) |
|---|---|---|
| **Admin/Petugas** | `admin@pustakalink.com` | `password` |

---

## 🧪 Validasi Kestabilan (Unit & Feature Testing)

Aplikasi ini dilengkapi 12 test case otomatis menggunakan PHPUnit untuk menjamin kebenaran logika bisnis sirkulasi dan CRUD. Jalankan pengujian dengan perintah:
```bash
php artisan test
```

Hasil pengujian yang berhasil akan ditandai dengan status **Passed (100% Green)**.
