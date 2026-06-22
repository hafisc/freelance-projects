# Langkah-Langkah Menjalankan Aplikasi Flutter (gloria_job_app) di VS Code dengan Emulator

Dokumen ini berisi panduan lengkap untuk menjalankan aplikasi mobile **gloria_job_app** menggunakan emulator Android di VS Code pada OS Windows.

---

## 1. Prasyarat Sistem
Sebelum memulai, pastikan perangkat Anda telah terinstall:
- **Flutter SDK** (Sudah terdaftar di Environment Variables / PATH).
- **VS Code** dengan ekstensi berikut:
  - **Flutter** (oleh Dart Code)
  - **Dart** (oleh Dart Code)
- **Android Studio** (untuk mengelola Android SDK dan membuat Emulator/AVD).
- **Android Emulator / AVD (Android Virtual Device)** yang sudah dibuat di Android Studio Device Manager.

---

## 2. Langkah-Langkah Menjalankan Emulator dan Aplikasi

### Langkah 1: Buka Proyek di VS Code
1. Buka **VS Code**.
2. Pilih menu **File > Open Folder...**
3. Arahkan dan buka folder aplikasi Flutter secara spesifik:
   `e:\Project\Freelance Projects\gloria-job\gloria_job_app`
   *(Catatan: Membuka folder `gloria_job_app` secara langsung akan memudahkan VS Code mengenali proyek sebagai proyek Flutter).*

### Langkah 2: Ambil Dependensi Proyek (Flutter Pub Get)
1. Setelah proyek terbuka, biasanya VS Code akan menjalankan `flutter pub get` otomatis.
2. Jika tidak, buka terminal di VS Code (`Ctrl + ~`).
3. Ketik perintah berikut lalu tekan Enter:
   ```bash
   flutter pub get
   ```

### Langkah 3: Jalankan Emulator Android dari VS Code
Ada dua cara mudah untuk memunculkan emulator dari VS Code:

#### Cara A: Melalui Status Bar (Paling Mudah)
1. Perhatikan bagian **pojok kanan bawah** jendela VS Code (di Status Bar).
2. Anda akan melihat nama perangkat yang sedang aktif (misalnya: `Windows (windows-x64)` atau `No Device`). **Klik tulisan tersebut**.
3. Di bagian atas layar (Command Palette) akan muncul daftar pilihan perangkat dan emulator.
4. Pilih nama emulator Android Anda (contoh: `Start Pixel_5_API_33` atau sejenisnya).
5. Tunggu beberapa saat sampai emulator Android muncul di layar dan melakukan booting selesai.

#### Cara B: Melalui Command Palette
1. Tekan tombol `Ctrl + Shift + P` secara bersamaan di VS Code.
2. Ketik `Flutter: Launch Emulator`.
3. Pilih emulator Android yang ingin Anda jalankan dari daftar yang muncul.

#### Cara C: Melalui Terminal VS Code (Command Line)
Jika Anda lebih suka menggunakan baris perintah (terminal) di VS Code:
1. Jalankan perintah berikut untuk melihat daftar emulator yang tersedia:
   ```bash
   flutter emulators
   ```
2. Untuk menyalakan emulator, jalankan perintah:
   ```bash
   flutter emulators --launch flutter_emulator
   ```
   *(Ganti `flutter_emulator` dengan ID emulator Anda jika berbeda).*

---

## 3. Menjalankan Aplikasi ke Emulator
Setelah emulator menyala dan terdeteksi di status bar VS Code (nama emulator akan muncul di pojok kanan bawah, misal: `sdk gphone64 x86_64`):

1. Pastikan file active di VS Code adalah salah satu file Dart (misal membuka `lib/main.dart`).
2. Tekan tombol **F5** pada keyboard Anda untuk memulai debugging (atau klik menu **Run > Start Debugging**).
3. Proses build pertama kali akan memakan waktu sedikit lebih lama. Harap tunggu hingga aplikasi terinstal dan terbuka secara otomatis di emulator.
4. Jika ingin menjalankan tanpa debugger melalui terminal, Anda juga bisa mengetikkan:
   ```bash
   flutter run
   ```

---

## 4. Menghubungkan ke Backend Laravel (Penting!)
Agar aplikasi Flutter dapat berinteraksi dengan API, pastikan Backend Laravel Anda sudah menyala:

1. Buka terminal baru di folder backend:
   `e:\Project\Freelance Projects\gloria-job\gloria-job-backend`
2. Jalankan server Laravel:
   ```bash
   php artisan serve
   ```
3. Secara default, aplikasi Flutter dikonfigurasi menggunakan alamat IP `10.0.2.2:8000` pada file [api_constants.dart](file:///e:/Project/Freelance%20Projects/gloria-job/gloria_job_app/lib/core/constants/api_constants.dart) agar dapat mengakses localhost laptop Anda dari dalam emulator Android.
