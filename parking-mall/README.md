# Aplikasi Desktop Parking Mall

Aplikasi desktop sederhana untuk pengelolaan parkir mall menggunakan Java NetBeans dan MySQL/phpMyAdmin.

## Fitur Utama

1. Login 3 role: admin, petugas, dan pengguna.
2. Dashboard admin.
3. Dashboard petugas.
4. Dashboard pengguna.
5. Kelola petugas.
6. Kelola lantai parkir.
7. Kelola slot parkir berdasarkan lantai.
8. Booking parkir oleh pengguna.
9. Status booking.
10. Verifikasi booking oleh petugas.
11. Kendaraan masuk.
12. Kendaraan keluar.
13. Generate kode booking atau karcis.
14. Cetak atau preview karcis sederhana.
15. Laporan parkir.
16. Database MySQL melalui phpMyAdmin.

## Teknologi

- Java
- Java Swing
- NetBeans
- MySQL
- phpMyAdmin
- JDBC MySQL Connector

## Struktur Folder

```text
parking-mall/
├── src/
│   └── parkingmall/
│       ├── Main.java
│       ├── config/
│       ├── model/
│       ├── dao/
│       ├── view/
│       └── helper/
├── database/
│   └── parking_mall.sql
├── docs/
│   ├── PANDUAN_INSTALL.md
│   └── PANDUAN_TESTING.md
├── AGENTS.md
├── CLAUDE.md
├── DESIGN.md
├── SOW.md
└── README.md
```

## Akun Dummy

Admin:

```text
Username: admin
Password: admin123
```

Petugas:

```text
Username: petugas
Password: petugas123
```

Pengguna:

```text
Username: pengguna
Password: pengguna123
```

## Cara Menjalankan

1. Buka XAMPP.
2. Start Apache dan MySQL.
3. Buka phpMyAdmin.
4. Buat database `parking_mall`.
5. Import file `database/parking_mall.sql`.
6. Buka project di NetBeans.
7. Tambahkan MySQL Connector/J jika belum ada.
8. Sesuaikan konfigurasi database di file `DatabaseConnection.java`.
9. Run project dari NetBeans.

## Konfigurasi Database

Contoh konfigurasi:

```java
private static final String URL = "jdbc:mysql://localhost:3306/parking_mall";
private static final String USER = "root";
private static final String PASSWORD = "";
```

Sesuaikan password jika MySQL lokal memakai password.

## Catatan

Project ini dibuat sederhana sesuai kebutuhan client. Tampilan difokuskan agar rapi, mudah digunakan, dan mengikuti warna referensi.
