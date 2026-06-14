# Gloria Job

Sistem pencarian lowongan kerja yang terdiri dari **Backend & Admin Panel (Laravel)** dan **Aplikasi Mobile (Flutter)**.

---

## 1. Backend & Admin Panel (Laravel)

### Prasyarat
- PHP >= 8.3
- Composer
- MySQL / MariaDB
- Node.js & NPM

### Cara Menjalankan

1. **Masuk ke direktori backend:**
   ```bash
   cd gloria-job-backend
   ```

2. **Salin file konfigurasi environment:**
   ```bash
   copy .env.example .env
   ```
   *(Gunakan `cp` jika menggunakan Git Bash atau terminal Linux/macOS)*

3. **Install dependensi PHP & Node.js:**
   ```bash
   composer install
   npm install
   ```

4. **Buat database** baru di MySQL dengan nama `gloria_job`.

5. **Sesuaikan konfigurasi database** pada file `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=gloria_job
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Generate Application Key & hubungkan Storage:**
   ```bash
   php artisan key:generate
   php artisan storage:link
   ```

7. **Jalankan migrasi database dan seeder data dummy:**
   ```bash
   php artisan migrate:fresh --seed
   ```

8. **Jalankan server backend:**
   ```bash
   php artisan serve
   ```
   Server backend akan berjalan di `http://127.0.0.1:8000`.

---

## 2. Aplikasi Mobile (Flutter)

### Prasyarat
- Flutter SDK
- Android Studio / VS Code + Flutter Extension
- Emulator Android / Device Fisik

### Cara Menjalankan

1. **Masuk ke direktori aplikasi mobile:**
   ```bash
   cd gloria_job_app
   ```

2. **Ambil dependensi Flutter:**
   ```bash
   flutter pub get
   ```

3. **Konfigurasi URL API:**
   Secara default, URL mengarah ke localhost emulator Android (`http://10.0.2.2:8000/api`). Jika menggunakan device fisik, sesuaikan IP laptop Anda pada file:
   [api_constants.dart](file:///c:/Users/USER/AndroidStudioProjects/Gloria%20Job/gloria_job_app/lib/core/constants/api_constants.dart)
   ```dart
   static const String baseUrl = 'http://<IP-LAPTOP-ANDA>:8000/api';
   ```

4. **Jalankan aplikasi:**
   ```bash
   flutter run
   ```

---

## 3. Akun Login Default (Data Seeder)

Setelah menjalankan seeder database, Anda dapat login menggunakan akun berikut:

### Admin Panel (Akses Web di http://localhost:8000/admin/login)
- **Email:** `admin@gmail.com`
- **Password:** `password`

### Pencari Kerja / Pelamar (Akses Aplikasi Mobile)
- **Email:** `user@gloria.com`
- **Password:** `password`
