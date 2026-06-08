<h1 align="center">🌊 FisiTera: Media Pembelajaran Gelombang, Bunyi, & Cahaya</h1>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.0-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12" />
  <img src="https://img.shields.io/badge/Tailwind_CSS-v4.0-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="Tailwind CSS v4" />
  <img src="https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+" />
  <img src="https://img.shields.io/badge/Database-SQLite-003B57?style=for-the-badge&logo=sqlite&logoColor=white" alt="SQLite" />
  <img src="https://img.shields.io/badge/Vite-7.0-646CFF?style=for-the-badge&logo=vite&logoColor=white" alt="Vite 7" />
</p>

---

## 📖 Ringkasan Aplikasi

**FisiTera** adalah website media pembelajaran fisika interaktif materi **Gelombang, Bunyi, dan Cahaya** yang dirancang khusus untuk meningkatkan pemahaman siswa melalui materi interaktif, simulasi visual, dan kuis evaluasi. Aplikasi ini juga dilengkapi dengan panel khusus guru untuk memantau kemajuan belajar siswa (progress tracking), mengelola data nilai kuis/evaluasi, serta mengunduh rekapitulasi nilai.

Website ini telah direfaktor agar memiliki tampilan yang modern, transisi antarmuka yang mulus, sidebar yang dinamis di desktop, menu drawer responsif di mobile, serta optimasi layout di perangkat tablet dan handphone.

---

## ✨ Fitur Utama

### 1. 📖 Modul Pembelajaran Fisika Interaktif
* **Gelombang**: Definisi gelombang, klasifikasi jenis-jenis gelombang, prinsip-prinsip dasar gelombang, dan beda fase gelombang.
* **Bunyi**: Pengantar gelombang bunyi, sumber & karakteristik bunyi, konsep perambatan bunyi, serta simulasi visual fenomena aplikasi bunyi.
* **Cahaya**: Pengantar gelombang cahaya, sifat-sifat cahaya, spektrum cahaya, serta simulasi visual fenomena aplikasi cahaya.

### 2. 📝 Evaluasi & Kuis Topik
* **Kuis Per Topik**: Latihan soal khusus untuk topik Gelombang, Bunyi, dan Cahaya.
* **Evaluasi Akhir**: Tes komprehensif untuk menguji pemahaman keseluruhan materi.
* **Sistem Kuis Fleksibel**: Mendukung batas KKM (Kriteria Ketuntasan Minimum), batas durasi pengerjaan kuis, dan pencatatan riwayat percobaan siswa (*Quiz Attempts*).

### 3. 👨‍🏫 Panel Dashboard Guru (Teacher Panel)
* **Student Management (CRUD)**: Mengelola data siswa, tahun ajaran, dan kelas secara terpusat.
* **Real-time Progress Tracker**: Memantau topik mana saja yang sudah dibaca/diselesaikan oleh siswa secara real-time.
* **Grade Management (Rekap Nilai)**: Melihat riwayat nilai kuis & evaluasi siswa secara detail beserta visualisasi status kelulusan (KKM).
* **Ekspor Laporan**: Fitur unduh rekap nilai siswa dan analisis ketercapaian kelas dalam format spreadsheet Excel (`.xlsx`).

### 4. 📱 UI/UX Modern & Sidebar Responsif (Refactored)
* **Collapsible Desktop Sidebar**: Sidebar dapat ditutup-buka lewat tombol hamburger, dengan memori posisi otomatis yang disimpan di penyimpanan lokal (`localStorage`).
* **Mobile Drawer Navigation**: Di perangkat mobile/HP, sidebar otomatis bertransisi menjadi drawer geser dengan overlay mask backdrop (klik di luar menu untuk menutup).
* **Mobile-friendly Tables**: Semua tabel data (termasuk DataTables) dapat digulirkan secara horizontal di HP agar kolom tidak saling tumpang tindih.

---

## 🛠️ Stack Teknologi

* **Backend**: Laravel 12 (PHP >= 8.2)
* **Frontend Build Tool**: Vite 7
* **Styling**: Tailwind CSS v4 & Custom CSS transitions
* **Database**: SQLite (default) / MySQL
* **Libraries**: Maatwebsite Excel (untuk ekspor file Excel), Concurrently (untuk menjalankan server development secara paralel)

---

## 🚀 Instalasi & Konfigurasi Lokal

Ikuti langkah-langkah berikut untuk menjalankan proyek di komputer lokal Anda:

### Prasyarat (Prerequisites)
Pastikan Anda sudah menginstal:
* PHP >= 8.2
* Composer
* Node.js & NPM

### Langkah-langkah Pengaturan:

1. **Buka direktori proyek**:
   ```bash
   cd media-gelombang
   ```

2. **Salin konfigurasi environment**:
   ```bash
   copy .env.example .env
   ```

3. **Buat file database SQLite** (karena default konfigurasi menggunakan SQLite):
   ```bash
   # Di Windows (PowerShell)
   New-Item -ItemType File -Path database\database.sqlite -Force
   
   # Di Windows (CMD)
   type nul > database\database.sqlite
   ```

4. **Instal dependensi PHP**:
   ```bash
   composer install
   ```

5. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```

6. **Jalankan migrasi database & seeder data awal**:
   ```bash
   php artisan migrate --seed
   ```
   *Perintah ini akan membuat semua tabel dan mengisinya dengan bank soal kuis, data kuis awal, akun guru, admin, serta siswa demo.*

7. **Instal dependensi Javascript (NPM)**:
   ```bash
   npm install
   ```

8. **Jalankan Server Development**:
   Untuk menjalankan server backend Laravel dan server frontend Vite secara bersamaan secara otomatis:
   ```bash
   composer dev
   ```
   *Setelah server berjalan, Anda dapat mengakses website melalui browser di alamat yang tertera (biasanya `http://127.0.5.1:8000` atau `http://localhost:8000`).*

9. **Build Aset Produksi (Opsional)**:
   Jika Anda ingin mem-build aset untuk produksi tanpa server development:
   ```bash
   npm run build
   ```

---

## 🔐 Akun Demo (Default Credentials)

Setelah menjalankan database seeder, Anda dapat login menggunakan beberapa akun demo berikut:

| Peran (Role) | Username | Password | Deskripsi |
| :--- | :--- | :--- | :--- |
| **Guru** | `guru` | `123456` | Mengakses dashboard guru, mengelola nilai, melihat progres, dan mengekspor laporan. |
| **Siswa Demo** | `siswa` | `123456` | Mengakses modul materi pembelajaran, simulasi, kuis, dan evaluasi. |
| **Admin** | `admin` | `123456` | Mengakses hak akses administrator sistem. |
