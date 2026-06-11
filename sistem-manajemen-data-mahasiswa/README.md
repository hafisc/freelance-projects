# Sistem Manajemen Data Mahasiswa

Aplikasi web sederhana berbasis Laravel 13 untuk mengelola data mahasiswa dan jurusan.

## Fitur

1. Login admin.
2. Dashboard admin.
3. Kelola data mahasiswa.
4. Kelola data jurusan.
5. Pencarian data mahasiswa.
6. Detail data mahasiswa.
7. Validasi form.
8. Seeder data awal.
9. Tampilan admin sederhana dan rapi.

## Teknologi

1. Laravel 13
2. PHP minimal 8.3
3. MySQL
4. Blade
5. Bootstrap 5
6. CSS custom

## Cara Install

Clone atau ekstrak project terlebih dahulu.

Masuk ke folder project:

```bash
cd nama-project
```

Install dependency Laravel:

```bash
composer install
```

Salin file environment:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Atur database di file `.env`:

```env
DB_DATABASE=db_mahasiswa
DB_USERNAME=root
DB_PASSWORD=
```

Jalankan migration dan seeder:

```bash
php artisan migrate --seed
```

Jalankan project:

```bash
php artisan serve
```

Buka aplikasi di browser:

```txt
http://127.0.0.1:8000
```

## Akun Login Admin

```txt
Email: admin@gmail.com
Password: admin12345
```

## Struktur Fitur

### Dashboard

Menampilkan ringkasan jumlah mahasiswa, jumlah jurusan, dan data mahasiswa terbaru.

### Data Mahasiswa

Digunakan untuk menambah, melihat, mengedit, menghapus, dan mencari data mahasiswa.

### Data Jurusan

Digunakan untuk menambah, melihat, mengedit, dan menghapus data jurusan.

## Struktur Folder Penting

```txt
app/
├── Http/
│   ├── Controllers/
│   └── Requests/
├── Models/

resources/
├── views/
│   ├── auth/
│   ├── dashboard/
│   ├── jurusan/
│   ├── mahasiswa/
│   ├── layouts/
│   └── components/

public/
└── assets/
    ├── css/
    └── js/
```

## Catatan

Pastikan PHP yang digunakan sudah versi 8.3 atau lebih baru agar sesuai dengan kebutuhan Laravel 13.

Jika ada error database, cek kembali nama database, username, password, dan pastikan MySQL sudah berjalan.
