# DESIGN.md

## Konsep Desain

Project ini menggunakan konsep media digital alat peraga bernama MAMITOR 3D. Desain harus mempertahankan konsep pembelajaran matriks minor dan kofaktor dengan visualisasi 3D, tetapi dibuat lebih rapi, modern, dan nyaman digunakan.

Desain tidak boleh mengubah konsep utama dari client. Yang diperbaiki hanya tampilan, struktur, animasi, spacing, responsive, dan kenyamanan penggunaan.

## Gaya Visual

Gaya yang digunakan:

- Dark mode.
- Glassmorphism.
- Visualisasi matriks 3D.
- Aksen warna biru, hijau, dan merah muda.
- Card dengan border halus.
- Shadow lembut.
- Rounded corner besar.
- Animasi ringan dan smooth.

## Warna Utama

Gunakan CSS variable agar mudah dirubah:

```css
:root {
  --color-bg: #0f172a;
  --color-surface: rgba(255, 255, 255, 0.06);
  --color-surface-strong: rgba(15, 23, 42, 0.72);
  --color-border: rgba(255, 255, 255, 0.12);
  --color-primary: #38bdf8;
  --color-primary-dark: #2563eb;
  --color-accent: #f43f5e;
  --color-success: #10b981;
  --color-warning: #f59e0b;
  --color-text: #f8fafc;
  --color-muted: #94a3b8;
}
```

## Layout Halaman

Layout utama terdiri dari:

1. Start screen / intro screen.
2. Visual panel matriks 3D.
3. Control panel untuk pemilihan baris dan kolom.
4. Worksheet panel untuk input jawaban.
5. Feedback jawaban.

### Desktop

Gunakan 2 kolom:

- Kiri: judul dan visual matriks 3D.
- Kanan: kontrol dan lembar kerja.

### Mobile

Gunakan 1 kolom:

- Judul.
- Visual matriks.
- Kontrol.
- Lembar kerja.

## Halaman Awal / Mulai Bermain

Tambahkan halaman awal atau overlay sebelum user masuk ke alat peraga.

Isi yang disarankan:

- Judul: MAMITOR 3D
- Subtitle: Matriks Minor dan Kofaktor
- Deskripsi singkat: Alat interaktif untuk belajar menghitung minor dan kofaktor matriks 3x3.
- Tombol: Mulai Bermain

Animasi:

- Card muncul dengan fade in.
- Tombol memiliki hover scale ringan.
- Saat diklik, overlay hilang dengan fade out.

## Visual Matriks 3D

Matriks 3x3 ditampilkan sebagai blok 3D.

State visual:

1. Normal: semua blok terlihat aktif.
2. Crossed: baris/kolom yang dipilih dibuat redup atau turun ke belakang.
3. Highlight: elemen matriks sisa dibuat lebih menyala.

Jangan membuat animasi terlalu berat agar tetap lancar di browser biasa.

## Form dan Input

Input nilai matriks:

- Harus jelas terlihat.
- Berisi angka default agar user bisa langsung mencoba.
- Support angka negatif.
- Jika kosong, sistem boleh menganggap nilai sebagai 0.

Input jawaban:

- Dibagi menjadi bagian matriks sisa, minor, dan kofaktor.
- Beri feedback visual benar/salah.
- Gunakan border hijau untuk benar.
- Gunakan border merah untuk salah.

## Button

Jenis button:

1. Primary button: Mulai Bermain, Tutup Baris & Kolom.
2. Success button: Cek Jawaban.
3. Secondary button: Reset jika dibuat.

Style:

- Rounded 10px - 14px.
- Padding nyaman.
- Hover smooth.
- Shadow tidak berlebihan.

## Typography

Gunakan font system agar ringan:

```css
font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
```

Ukuran:

- H1: 40px desktop, 32px mobile.
- Subtitle: 18px desktop, 16px mobile.
- Body: 16px.
- Input matriks: 22px - 24px.

## Responsive Rules

Breakpoint yang disarankan:

```css
@media (max-width: 900px) {
  /* layout jadi 1 kolom */
}

@media (max-width: 520px) {
  /* ukuran matriks dan padding diperkecil */
}
```

Pastikan:

1. Tidak ada horizontal scroll.
2. Matriks tetap muat di layar mobile.
3. Tombol tidak terlalu kecil.
4. Panel jawaban tetap mudah diisi.

## Hal Yang Tidak Boleh Dilakukan

1. Jangan mengubah konsep MAMITOR 3D.
2. Jangan menghapus fitur minor dan kofaktor.
3. Jangan membuat warna terlalu ramai.
4. Jangan membuat animasi yang mengganggu pembelajaran.
5. Jangan membuat UI terlalu kompleks.
6. Jangan mengganti project menjadi backend/fullstack.
