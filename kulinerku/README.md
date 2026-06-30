# KulinerKu - Aplikasi Resep Masakan Nusantara

**KulinerKu** adalah aplikasi Android native (Java) untuk menjelajahi resep masakan khas Nusantara. Aplikasi ini mengambil data dari API lokal ter-intercept (OkHttp Interceptor) berbasis **TheMealDB** dan menggunakan database **SQLite** untuk menyimpan resep favorit secara offline.

Proyek ini dibuat untuk memenuhi tugas praktikum **Lab Mobile 2026**.

---

## 🚀 Fitur Utama

1. **Kategori "Semua" & Kategori Nusantara**:
   - Menampilkan tab kategori: **Semua**, **Daging**, **Ayam**, **Seafood**, **Mie & Sayur**, dan **Pencuci Mulut**.
   - Kategori "Semua" menampilkan seluruh 40 resep khas Indonesia sekaligus secara default.
2. **Pencarian Dinamis**: Mencari resep kuliner Indonesia berdasarkan nama secara real-time.
3. **Detail Resep Lengkap**: Menampilkan gambar, kategori, daftar bahan, takaran, dan petunjuk langkah memasak dalam Bahasa Indonesia.
4. **Resep Favorit (Offline)**: Menyimpan resep ke SQLite lokal agar tetap bisa dibaca tanpa koneksi internet.
5. **Dua Pilihan Tema**: Toggle dark/light mode pada toolbar dengan penyimpanan status di SharedPreferences.
6. **Gambar Cepat & Akurat**: Seluruh gambar masakan sesuai dengan nama menu dan dimuat dengan cepat menggunakan Glide.

---

## 🛠️ Tech Stack & Spesifikasi

- **Bahasa**: Java (Min SDK 24 / Android 7.0)
- **UI/Layout**: XML Layout, Material 3, View Binding, Glassmorphic Bottom Navigation
- **Koneksi Jaringan**: Retrofit 2 + OkHttp Interceptor (menyajikan 40 data statis lokal kuliner Indonesia)
- **Database Lokal**: SQLite (`SQLiteOpenHelper`)
- **Navigasi**: Jetpack Navigation Component
- **Pemuatan Gambar**: Glide (dengan disk caching offline)
- **Asynchronous**: `ExecutorService` untuk background thread dan `Handler` untuk UI thread.

---

## 📂 Struktur Folder Proyek

```text
app/src/main/java/com/labmobile/kulinerku/
├── activity/
│   ├── MainActivity.java       <- Kelola navigasi utama & toggle tema
│   └── DetailActivity.java     <- Detail resep, simpan favorit, & support offline
├── fragment/
│   ├── HomeFragment.java       <- Tampilan utama (kategori, daftar resep, search)
│   └── FavoriteFragment.java   <- Menampilkan resep favorit dari SQLite
├── adapter/
│   ├── CategoryAdapter.java    <- Adapter tab kategori horizontal
│   └── MealAdapter.java        <- Adapter grid daftar resep makanan
├── model/
│   ├── Category.java           <- Model data kategori
│   ├── MealSummary.java        <- Model ringkasan resep
│   └── MealDetail.java         <- Model detail lengkap resep
├── network/
│   ├── ApiClient.java          <- Konfigurasi Retrofit & database kustom 40 resep Indonesia
│   └── ApiService.java         <- Endpoint API & response wrapper
├── data/
│   ├── local/
│   │   ├── DatabaseHelper.java <- Schema tabel SQLite
│   │   └── FavoriteDao.java    <- Operasi CRUD resep favorit
│   └── prefs/
│       └── ThemePreference.java <- SharedPreferences status tema
└── util/
    ├── ThreadExecutor.java     <- Executor Service scheduler
    └── NetworkUtil.java        <- Validasi koneksi internet
```

---

## ⚙️ Cara Compile & Build APK

1. Pastikan target compiler minimal menggunakan JDK 17.
2. Jalankan perintah di bawah ini pada terminal root proyek:

```bash
# Windows
.\gradlew.bat assembleDebug

# macOS / Linux
chmod +x gradlew
./gradlew assembleDebug
```

3. APK hasil build dapat ditemukan di folder:
   `app/build/outputs/apk/debug/app-debug.apk`
