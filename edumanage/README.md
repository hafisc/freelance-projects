# EduManage - Sistem Manajemen Kegiatan Proses Belajar

EduManage adalah website sistem manajemen kegiatan pembelajaran akademik kampus berbasis Laravel, Blade, dan MySQL. Project ini dikembangkan dengan tujuan membantu administrasi kampus, dosen, mahasiswa, dan kepala program studi dalam mengelola serta memantau data perkuliahan, jadwal kelas, dan jurnal kegiatan belajar mengajar secara digital, dinamis, dan terstruktur.

---

## 🌟 Fitur Utama
1. **Autentikasi Multi-Role**: Pembatasan akses halaman & menu untuk 4 Level User (Admin, Dosen, Mahasiswa, Kaprodi) lengkap dengan fitur Autofill Kredensial untuk mempermudah pengujian.
2. **Dashboard Dinamis**: Statistik visual dan ringkasan data yang disesuaikan dengan kebutuhan masing-masing role.
3. **Manajemen Data Master (Admin)**:
   - CRUD Akun Pengguna (User) dengan enkripsi password
   - CRUD Mahasiswa (terintegrasi dengan akun login)
   - CRUD Dosen (terintegrasi dengan akun login)
   - CRUD Mata Kuliah (Kode MK, Nama MK, SKS, Semester)
   - CRUD Kelas (Nama Kelas, Prodi, Angkatan)
   - CRUD Jadwal Pembelajaran (mengaitkan Kelas, Dosen, Mata Kuliah, Hari, Waktu, Ruang)
4. **Jurnal & Absensi Kegiatan Belajar (Transaksi)**:
   - Dosen dapat mencatat jurnal pertemuan serta absensi ringkasan mahasiswa (Hadir, Sakit, Izin, Alfa).
   - Admin memiliki kontrol CRUD penuh terhadap jurnal.
   - Mahasiswa & Kaprodi memiliki hak akses memantau (read-only) jurnal kegiatan dan ringkasan absensi kelas.
5. **UI Kreatif, Modern & Responsive**: Halaman login yang kreatif dan dinamis (Tailwind CSS), serta halaman dalam yang bersih dengan tema biru akademik formal menggunakan Inter font, FontAwesome, dan responsive dasar.

---

## 🔑 Kredensial Login Akun Dummy
Gunakan akun di bawah ini untuk menguji hak akses masing-masing role:

| Role | Email | Password | Nama User |
| :--- | :--- | :--- | :--- |
| **Admin** | admin@edumanage.test | `password` | Admin Sistem |
| **Dosen** | dosen@edumanage.test | `password` | Admin Dosen |
| **Mahasiswa** | mahasiswa@edumanage.test | `password` | Admin Mahasiswa |
| **Kaprodi** | kaprodi@edumanage.test | `password` | Admin Kaprodi |

---

## ⚙️ Panduan Instalasi Lokal

Ikuti langkah-langkah berikut untuk menjalankan project di laptop/komputer Anda:

### 1. Prasyarat Sistem
Pastikan perangkat Anda sudah terinstall:
- PHP >= 8.2 (Direkomendasikan PHP 8.3)
- Composer
- MySQL Server (xampp / laragon / mysql native)

### 2. Persiapan Project
1. Extract file project ke direktori server lokal Anda (misal `htdocs` jika memakai XAMPP).
2. Buka Terminal / Command Prompt di folder project tersebut.

### 3. Install Dependency Laravel
Jalankan perintah berikut untuk mengunduh semua package PHP yang dibutuhkan:
```bash
composer install
```

### 4. Konfigurasi Environment (`.env`)
1. Duplikat file `.env.example` menjadi `.env`.
   - Di Windows, Anda bisa menduplikat manual atau lewat CLI:
     ```bash
     copy .env.example .env
     ```
2. Buat database baru bernama `edumanage` di phpMyAdmin atau MySQL Client Anda.
3. Buka file `.env` yang baru dibuat dan sesuaikan konfigurasi koneksi database Anda (biasanya user default MySQL adalah `root` tanpa password):
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=edumanage
   DB_USERNAME=root
   DB_PASSWORD=
   ```

### 5. Generate Key Application
Jalankan perintah untuk membuat unique encryption key aplikasi:
```bash
php artisan key:generate
```

### 6. Setup Database & Seeding Data
Anda dapat menyiapkan database dengan dua cara:

#### Opsi A: Menggunakan Migrasi & Seeder Laravel (Sangat Direkomendasikan)
Jalankan perintah berikut untuk membuat semua tabel database beserta seluruh data dummy login dan transaksi bawaan secara otomatis:
```bash
php artisan migrate --seed
```

#### Opsi B: Restore Manual dari File SQL Export
1. Masuk ke phpMyAdmin / MySQL client Anda.
2. Buat database `edumanage`.
3. Lakukan **Import** file database SQL yang sudah kami sediakan di folder project:
   `database/sql/edumanage.sql`

### 7. Jalankan Server Lokal
Mulai server development lokal aplikasi Anda:
```bash
php artisan serve
```
Buka web browser dan akses aplikasi melalui tautan:
[http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 📁 Struktur Database & Relasi Utama
Aplikasi ini memiliki 8 tabel utama yang saling berelasi:
- **roles**: Menyimpan hak akses.
- **users**: Menyimpan data login, berelasi ke `roles` (Many-to-One).
- **mahasiswa**: Menyimpan profil mahasiswa, berelasi ke `users` (One-to-One).
- **dosen**: Menyimpan profil dosen, berelasi ke `users` (One-to-One).
- **mata_kuliah**: Menyimpan daftar mata kuliah akademik.
- **kelas**: Menyimpan informasi kelas.
- **jadwal_pembelajaran**: Jadwal perkuliahan (Menghubungkan `kelas`, `dosen`, dan `mata_kuliah`).
- **kegiatan_belajar**: Transaksi jurnal perkuliahan, berelasi ke `jadwal_pembelajaran` (Many-to-One).
