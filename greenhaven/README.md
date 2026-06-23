# GreenHaven - Premium Plant Shop Website (PHP Native)

GreenHaven adalah aplikasi web toko tanaman hias premium berbasis **PHP Native** yang dirancang dengan visual bersih, estetik bergaya editorial, dan responsif. Proyek ini dibuat sebagai solusi terintegrasi yang terdiri dari landing page publik, alur checkout langsung ke WhatsApp admin, serta panel Dashboard Administrator (CRUD) lengkap.

---

## 🍃 Fitur Utama

### 1. Halaman Publik (Client Web)
*   **Hero Header**: Banner utama elegan bergaya editorial dengan visual tanaman resolusi tinggi.
*   **Filter Katalog Dinamis**: Menampilkan tanaman hias dengan tab kategori interaktif (Tanaman Indoor, Outdoor, Kaktus/Sukulen, Herbal) yang terhubung langsung ke database.
*   **Ulasan & Testimoni**: Testimoni pelanggan yang dikurasi secara dinamis melalui dashboard admin.
*   **Hubungi Kami Form**: Form kirim pesan interaktif yang menyimpan pesan pengunjung langsung ke database.
*   **Detail Tanaman**: Halaman detail spesifikasi tanaman, frekuensi penyiraman, kebutuhan cahaya, serta pengatur jumlah pembelian.
*   **Checkout via WhatsApp**: Form alamat pengiriman terstruktur yang secara otomatis memformulasikan pesan order dan mengarahkan pembeli ke WhatsApp API admin.

### 2. Panel Dashboard Admin
*   **Ringkasan Statistik (Overview)**: Widget jumlah produk, kategori, pesan masuk, dan testimoni aktif, lengkap dengan grafik garis (SVG kustom) tren kunjungan tahunan.
*   **CRUD Kategori Tanaman**: Manajemen tambah, edit, dan hapus kategori.
*   **CRUD Produk Tanaman**: Tambah dan edit produk tanaman lengkap dengan fitur upload gambar tanaman ke disk dan pengelolaan diskon promo/harga coret.
*   **Manajemen Pesan Masuk**: Membaca pesan/pertanyaan pelanggan serta opsi menghapusnya.
*   **Manajemen Ulasan**: Menambah testimoni manual, mengedit ulasan, dan mengaktifkan/menyembunyikan testimoni dari halaman publik (fitur toggle instan).

---

## 📂 Struktur Folder Proyek
Struktur file dalam proyek ini dirancang secara rapi dan modular:
```text
/ (root)
├── assets/                  # Aset statis halaman publik (CSS kustom & JS interaktif)
│   ├── css/style.css        # Desain visual utama publik
│   └── js/main.js           # Logika menu responsif, quantity, dll
├── config/
│   └── db.php               # File koneksi database MySQL menggunakan PDO
├── includes/                # Komponen modular halaman publik
│   ├── header.php           # Head HTML & Session Start
│   ├── navbar.php           # Bar navigasi
│   └── footer.php           # Bagian penutup & link Admin Portal
├── admin/                   # Folder khusus Dashboard Administrator
│   ├── assets/css/admin.css # Desain antarmuka panel admin
│   ├── includes/            # Komponen bilah samping (sidebar) & navigasi admin
│   ├── index.php            # Dashboard utama statistik
│   ├── login.php            # Autentikasi aman admin (hash bcrypt)
│   ├── logout.php           # Skrip keluar sistem
│   ├── categories.php       # Manajemen kategori (CRUD)
│   ├── products.php         # Manajemen produk & upload gambar (CRUD)
│   ├── messages.php         # Inbox pesan pelanggan
│   └── testimonials.php     # Kurasi ulasan pembeli (CRUD & Toggle)
├── detail.php               # Halaman detail produk
├── checkout.php             # Halaman checkout & formulir kirim WhatsApp
├── database.sql             # Skema & data awal (seeding) database
└── README.md                # Dokumentasi proyek
```

---

## 🛠️ Panduan Instalasi Lokal (XAMPP / Laragon)

1.  **Clone / Copy Proyek**:
    Letakkan seluruh isi folder proyek ini ke dalam direktori server lokal Anda (misal: `C:/xampp/htdocs/greenhaven/`).
    
2.  **Import Database**:
    *   Aktifkan MySQL di XAMPP Control Panel.
    *   Buka browser dan akses `http://localhost/phpmyadmin/`.
    *   Buat database baru bernama `greenhaven_db`.
    *   Pilih database tersebut, masuk ke tab **Import**, pilih file `database.sql` yang ada di root direktori proyek, lalu klik **Go/Import**.

3.  **Konfigurasi Koneksi Database**:
    *   Buka file [config/db.php](file:///config/db.php).
    *   Sesuaikan variabel `$db_host`, `$db_name`, `$db_user`, dan `$db_pass` dengan konfigurasi database server Anda (default XAMPP biasanya username `root` dan password dikosongkan `""`).

4.  **Akses Website**:
    *   Website Utama: Buka `http://localhost/greenhaven/index.php`.
    *   Panel Admin: Buka `http://localhost/greenhaven/admin/login.php` atau klik tautan **Panel Administrator** di pojok kanan bawah footer website utama.

---

## 🔑 Kredensial Login Admin Default
*   **Username**: `admin`
*   **Password**: `admin123`

*(Catatan Keamanan: Anda dapat mengedit akun admin atau menambahkan akun baru langsung di tabel `admins` menggunakan PHPMyAdmin).*
