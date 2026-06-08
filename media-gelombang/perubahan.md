# Catatan Perubahan (Changelog) - Refaktor Frontend & Sidebar Responsif

Pekerjaan refaktor frontend pada website Media Pembelajaran Gelombang telah selesai dilakukan sesuai dengan scope pengerjaan yang disepakati. Fokus utama perbaikan adalah perapian tampilan, optimasi responsive design untuk perangkat mobile/tablet, pembuatan sidebar dinamis, dan perbaikan minor bug pada kode frontend.

## 1. Ringkasan Perbaikan & Penyesuaian Scope
* **Sidebar Dinamis (Desktop)**: Sidebar sekarang bersifat *collapsible* (bisa disembunyikan dan dibuka kembali) lewat tombol hamburger di bagian header. Status collapse terakhir akan disimpan di penyimpanan browser (`localStorage`) agar posisinya konsisten saat halaman dimuat ulang.
* **Sidebar Responsif (Mobile/HP)**: Di perangkat HP, sidebar tidak lagi disembunyikan permanen melainkan berfungsi sebagai *drawer* overlay yang bergeser masuk dari kiri layar. Dilengkapi dengan overlay backdrop gelap untuk memudahkan menutup menu dengan sekali ketuk.
* **Perapian Tata Letak Header**: Menyelaraskan posisi tombol hamburger menu dengan nama aplikasi "FisiTera" secara horizontal pada satu baris sehingga tata letak di mobile rapi dan tidak tumpang tindih.
* **Perbaikan Sintaksis (Bug Fix)**: Memperbaiki error sintaksis JavaScript di halaman materi yang sebelumnya memicu error konsol browser.
* **Keamanan Fitur Eksisting**: Semua fungsionalitas backend (logic login, database, route, controller, kuis, evaluasi, dan rekapitulasi data guru) **aman dan tidak diubah sama sekali**.

## 2. Rincian File yang Diubah

### Layout & Tampilan (Blade View)
* **layouts/app.blade.php**
  * Menambahkan tombol toggle hamburger menu (`#sidebarToggle`) di header atas (`topbar-left`) khusus untuk pengguna yang sudah login.
  * Menambahkan elemen overlay mask (`#sidebarBackdrop`) untuk area luar sidebar di perangkat mobile.
* **pengantar_gelombang.blade.php**
  * Memperbaiki syntax error JavaScript pada blok penutup `DOMContentLoaded` yang sebelumnya menghentikan script lain di halaman tersebut.

### Styling & Tampilan (CSS)
* **style_gelombang.css**
  * Menambahkan properti `transition` (`0.3s ease`) pada class `.sidebar` dan `.main-content` agar pergeseran menu terlihat mulus.
  * Menambahkan style untuk `.sidebar-toggle-btn` (tombol hamburger) dan `.sidebar-backdrop` (efek blur & gelap di belakang sidebar mobile).
  * Menambahkan status kelas `.sidebar-collapsed` untuk merapatkan konten saat sidebar ditutup di desktop.
  * Menyesuaikan baris `.topbar-left` menggunakan flexbox agar tombol hamburger dan nama aplikasi sejajar di tengah secara vertikal dan tidak menumpuk.
  * Memperbaiki instruksi `@media` screen mobile (ukuran 768px dan 880px) dari semula `display: none !important` menjadi `left: -240px` agar menu dapat ditransisikan masuk dengan efek animasi geser.
  * Memperbaiki margin atas wrapper halaman (`.layout-wrapper`) pada perangkat mobile agar berjarak `60px` di bawah header, sehingga judul halaman (seperti "Data Siswa") tidak tertutup/terpotong oleh topbar.
  * Memperbaiki tampilan tabel DataTables di perangkat mobile agar dapat digeser secara horizontal (*horizontal scroll*) dan kolom-kolomnya tidak saling bertumpuk atau terhimpit.
  * Menyembunyikan tombol hamburger menu secara otomatis pada halaman yang tidak memiliki sidebar (seperti halaman Kuis dan Evaluasi) untuk menghindari tombol kosong yang tidak berfungsi.

### Logika Interaksi (JavaScript)
* **app.js**
  * Menambahkan logika deteksi lebar layar untuk membagi perilaku tombol toggle (collapse/expand untuk desktop, dan overlay drawer untuk mobile).
  * Menambahkan event handler untuk menutup menu drawer mobile saat area luar (backdrop) disentuh.
  * Menambahkan event listener `resize` untuk otomatis membersihkan kelas mobile jika layar diputar atau diperlebar di atas batas responsif.
  * Menambahkan fungsi pengecekan keberadaan elemen `.sidebar` sebelum mendaftarkan event listener toggle button, untuk otomatis menyembunyikan tombol hamburger jika sidebar tidak ada.

## 3. Hasil Pengujian
Semua pengujian pada akun **Siswa** (`221013` / `123456`) dan akun **Guru** (`guru` / `123456`) telah divalidasi dan berjalan dengan baik pada emulator peramban (desktop, tablet, dan handphone) tanpa ada error baru.
