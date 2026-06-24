# Laura Printing - Aplikasi CRUD & POS Percetakan

Aplikasi desktop manajemen percetakan (CRUD & POS) berbasis Java Swing dan MySQL.

## Akun Login Default
Aplikasi memiliki 2 akun default dengan hak akses berbeda:

1. **Admin (Akses Penuh)**
   - Username: `admin`
   - Password: `admin123`

2. **Kasir (Akses Terbatas)**
   - Username: `cashier`
   - Password: `cashier123`

---

## Prasyarat Sebelum Menjalankan
1. **JDK 21** atau versi terbaru sudah terinstal di komputer.
2. **MySQL Server** (XAMPP / Laragon) aktif di port `3306` dengan username `root` dan tanpa password (`""`).

> **PENTING:** Anda tidak perlu mengimpor file database manual. Aplikasi otomatis mendeteksi, membuat database `laura_printing`, membuat tabel, dan mengisi data awal (seeding) saat pertama kali dijalankan.

---

## Cara Menjalankan Aplikasi

Double-click file **`run.bat`** di dalam folder project, atau jalankan perintah berikut lewat Command Prompt (CMD) di folder project:

```cmd
run.bat
```

*Script `run.bat` akan otomatis melakukan kompilasi ulang (memanggil `compile.bat`) jika ada perubahan kode, lalu menjalankan aplikasi.*
