# SI-PBM (Sistem Informasi Proses Belajar Mengajar)

Proyek ini dibuat untuk memenuhi tugas UAS Pemrograman Web (NIM Genap) tentang **Manajemen Kegiatan Proses Belajar Mengajar**. 

Website ini dibangun menggunakan **Laravel** dan **MySQL** dengan memisahkan halaman & fitur untuk **4 jenis user**: Admin, Operator, Dosen, dan Mahasiswa. Masing-masing user punya halaman login dan hak akses sendiri yang berbeda satu sama lain.

---

## 🔑 Hak Akses & Fitur Tiap User

### 1. Admin
* Kelola akun login pengguna (CRUD User).
* Melihat daftar hak akses/role sistem.
* Monitoring statistik umum di dashboard.

### 2. Operator
* Kelola data dasar (CRUD Mahasiswa, CRUD Dosen, dan CRUD Mata Kuliah).
* Input plotting KRS Mahasiswa.
* Kelola Kelas Kuliah (menentukan jadwal, jam, hari, ruangan, dan dosen pengampunya).
* Hanya bisa memantau (read-only) Jadwal pertemuan, Kegiatan belajar, dan Laporan Absensi.

### 3. Dosen
* Mengatur jadwal tatap muka/pertemuan khusus untuk kelas yang dia ajar.
* Mengunggah materi kuliah atau tugas (ada fitur upload file dan set deadline).
* Mengisi daftar hadir presensi mahasiswa (Hadir, Sakit, Izin, Alpha) untuk tiap pertemuan.

### 4. Mahasiswa
* Melihat jadwal kuliah hari ini dan jadwal lengkap kelas yang diikuti (berdasarkan KRS).
* Melihat dan mendownload materi atau tugas yang diunggah oleh dosen.
* Melihat rekap kehadiran/absensi pribadinya sepanjang semester.

---

## 🛠️ Cara Menjalankan Project

Ikuti langkah-langkah di bawah ini untuk menjalankan program di komputer lokal Anda:

1. **Ekstrak File & Buka Terminal:**
   Ekstrak file zip ke folder htdocs atau direktori kerja Anda, lalu buka terminal/cmd di folder tersebut.

2. **Install Package PHP:**
   ```bash
   composer install
   ```

3. **Install & Build Tampilan (Tailwind CSS):**
   ```bash
   npm install
   npm run build
   ```

4. **Konfigurasi Database (.env):**
   Ganti nama file `.env.example` menjadi `.env`. Kemudian buat database kosong baru di phpMyAdmin dengan nama `siakad_pbm`. Sesuaikan pengaturan database di file `.env` Anda:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=siakad_pbm
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Migrasi Database & Isi Data Demo (Seeder):**
   Jalankan perintah ini untuk membuat tabel otomatis dan mengisi data awal agar langsung bisa dicoba:
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Jalankan Aplikasi:**
   ```bash
   php artisan serve
   ```
   Buka browser Anda dan buka alamat: `http://127.0.0.1:8000`

---

## 👥 Akun untuk Uji Coba (Demo Login)

Gunakan akun di bawah ini untuk mencoba login ke masing-masing halaman user:

| Role / User | Email | Password | Keterangan |
|---|---|---|---|
| **Admin** | `admin@sipbm.ac.id` | `admin123` | Hak akses Admin utama |
| **Operator** | `operator@sipbm.ac.id` | `operator123` | Hak akses Operator akademik |
| **Dosen** | `dosen@sipbm.ac.id` | `111111` | Password menggunakan NIDN dosen (Dr. Budi Santoso) |
| **Mahasiswa** | `2024002@sipbm.ac.id` | `2024002` | Password menggunakan NIM mahasiswa (Ahmad Hidayat) |
