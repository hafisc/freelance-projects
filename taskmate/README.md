# TaskMate

TaskMate adalah aplikasi task management berbasis website untuk membantu mahasiswa dan pekerja mengatur tugas, deadline, prioritas, status pekerjaan, kalender aktivitas, dan progres produktivitas.

## Stack
- Laravel
- MySQL
- Blade
- Tailwind CSS
- Laravel Breeze

## Fitur
1. Register dan login pengguna.
2. Dashboard ringkasan tugas.
3. Tambah, edit, dan hapus tugas.
4. Status tugas.
5. Prioritas tugas.
6. Deadline tugas.
7. Reminder sederhana.
8. Kalender aktivitas.
9. Profil pengguna.
10. Tampilan responsif.

## Cara Menjalankan Project
1. Clone atau extract project.
2. Masuk ke folder project.
3. Install dependency PHP.

```bash
composer install
```

4. Install dependency frontend.

```bash
npm install
```

5. Copy file environment.

```bash
cp .env.example .env
```

6. Generate key Laravel.

```bash
php artisan key:generate
```

7. Buat database MySQL dengan nama:

```text
taskmate_db
```

8. Atur koneksi database di file `.env`.

```env
DB_DATABASE=taskmate_db
DB_USERNAME=root
DB_PASSWORD=
```

9. Jalankan migration.

```bash
php artisan migrate
```

10. Jalankan server Laravel.

```bash
php artisan serve
```

11. Jalankan Vite.

```bash
npm run dev
```

12. Buka aplikasi di browser.

```text
http://127.0.0.1:8000
```

## Alur Aplikasi
1. User membuka aplikasi.
2. User login atau register.
3. User masuk ke dashboard.
4. User mengelola daftar tugas.
5. User melihat kalender aktivitas.
6. User melihat progres tugas di dashboard.
7. User logout.

## Catatan Pengembangan
- Gunakan middleware auth untuk halaman dashboard, tasks, calendar, dan profile.
- Pastikan data tugas hanya tampil untuk user yang sedang login.
- Gunakan komentar bahasa Indonesia pada fungsi penting.
- Jaga tampilan tetap rapi dan mudah digunakan.
