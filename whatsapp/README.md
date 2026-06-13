# 🟢 WhatsApp Business Status

<p align="center">
  <img src="https://img.shields.io/badge/Platform-Multiplatform-blue?style=for-the-badge&logo=flutter&logoColor=white" alt="Platform" />
  <img src="https://img.shields.io/badge/Frontend-Flutter_/_Dart-02569B?style=for-the-badge&logo=flutter&logoColor=white" alt="Frontend" />
  <img src="https://img.shields.io/badge/Backend-PHP_Native-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="Backend" />
  <img src="https://img.shields.io/badge/Database-MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="Database" />
</p>

Klon aplikasi **WhatsApp Business** responsif (berjalan di Web, Desktop, dan Mobile) yang dikembangkan menggunakan **Flutter** dan **PHP Native API** sebagai backend, serta **MySQL** sebagai database penyimpan data. Fokus utama dari proyek ini adalah fitur **Status / Story** (unggah gambar/video) serta manajemen profil bisnis.

---

## ✨ Fitur Utama

1. **Autentikasi & Onboarding**:
   - Pendaftaran pengguna baru menggunakan nomor telepon.
   - Simulasi verifikasi OTP.
   - Pendaftaran profil bisnis lengkap (Nama Bisnis, Kategori, Jam Kerja, Jadwal Aktif, Alamat, Website, Deskripsi, dan Foto Profil).
   - Pembuatan **Kode Login** unik (8 digit) secara otomatis untuk masuk kembali di perangkat lain tanpa OTP.

2. **Manajemen Status (Stories)**:
   - Unggah status baru dalam bentuk **Gambar** atau **Video** langsung dari galeri atau kamera (menggunakan `image_picker` / `file_picker`).
   - Penambahan caption/teks pada status.
   - Menampilkan daftar status dari pengguna lain secara dinamis yang diambil dari database.
   - Pemutaran video status secara langsung (menggunakan `video_player`).

3. **Tata Letak Responsif (Responsive Layout)**:
   - Aplikasi otomatis mendeteksi ukuran layar secara real-time.
   - Layar lebar (lebar &ge; 800px) akan memuat antarmuka **WhatsApp Web/Desktop** dengan sidebar navigasi, daftar obrolan, dan panel status desktop.
   - Layar kecil (lebar < 800px) akan memuat antarmuka **WhatsApp Mobile** standar.

---

## 📁 Struktur Direktori

```bash
whatsapp/
├── backend/                  # API Backend (PHP Native)
│   ├── API/                  # Script Endpoint PHP untuk database dan auth
│   │   ├── db.php            # Konfigurasi koneksi database MySQL
│   │   ├── register.php      # Pendaftaran pengguna dan profil bisnis
│   │   ├── login.php         # Verifikasi login menggunakan Kode Login
│   │   ├── verify_otp.php    # Verifikasi OTP dan pembuatan Kode Login
│   │   ├── create_status.php # Endpoint unggah media status/story baru
│   │   └── get_statuses.php  # Mengambil daftar status aktif dari database
│   └── status/               # Penyimpanan berkas media status (images/video)
├── server_root/              # File identifikasi deployment lokal
├── whatsapp/                 # Aplikasi Frontend (Flutter Project)
│   ├── assets/               # Aset gambar, ikon, profil, dan media default
│   ├── lib/                  # Kode sumber Dart
│   │   ├── screens/          # Halaman utama responsif (desktop & mobile)
│   │   ├── status_desktop/   # Panel status untuk tampilan desktop web
│   │   ├── status_mobile/    # Halaman status untuk tampilan mobile
│   │   ├── widgets/          # Komponen UI reusable
│   │   └── main.dart         # Entry point aplikasi Flutter
│   └── pubspec.yaml          # Spesifikasi paket dependensi Flutter
└── backend_wa.sql            # Database schema dump (MySQL)
```

---

## 🛠️ Langkah Instalasi & Konfigurasi

### 1. Persiapan Database (MySQL)
1. Buka pengelola database Anda (phpMyAdmin / Laragon / XAMPP).
2. Buat database baru dengan nama `project_231006`.
3. Impor file database `backend_wa.sql` yang berada di root folder proyek ini ke dalam database baru tersebut.

### 2. Konfigurasi Backend (PHP)
1. Pindahkan folder `backend/` ke dalam direktori root server lokal Anda (misal `htdocs` di XAMPP, atau `www` di Laragon).
2. Buka file `backend/API/db.php` dan sesuaikan konfigurasi koneksi database:
   ```php
   $host = "localhost";
   $user = "root";
   $password = ""; // Sesuaikan dengan password database Anda
   $database = "project_231006";
   ```
3. Pastikan server web (Apache) dan MySQL Anda sudah berjalan.

### 3. Konfigurasi & Menjalankan Aplikasi Flutter
1. Buka terminal dan arahkan ke direktori project Flutter:
   ```bash
   cd whatsapp/whatsapp
   ```
2. Unduh paket dependensi Flutter yang dibutuhkan:
   ```bash
   flutter pub get
   ```
3. Sesuaikan URL API backend pada kode Flutter (misal pada service HTTP request) agar mengarah ke alamat server lokal Anda (misal: `http://localhost/backend/API/...` atau alamat IP lokal komputer Anda jika dites menggunakan emulator/perangkat fisik).
4. Jalankan aplikasi di browser, emulator, atau perangkat fisik:
   ```bash
   flutter run -d chrome  # Menjalankan di Google Chrome (Web/Desktop layout)
   # atau
   flutter run           # Menjalankan di perangkat default (Mobile layout)
   ```

---

<p align="center">
  <i>Proyek ini dirancang khusus untuk demonstrasi integrasi Flutter Multiplatform dengan PHP Native API ✨</i>
</p>
