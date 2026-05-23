# DESIGN.md — Desain MAMITOR 3D

## Tujuan Desain
Membuat website media digital alat peraga yang modern, interaktif, dan mudah digunakan untuk belajar materi Matriks Minor dan Kofaktor.

Project harus terasa seperti alat peraga digital 3D, bukan sekadar kalkulator matriks biasa.

## Target Pengguna
- Siswa/mahasiswa yang belajar matriks.
- Guru/dosen yang ingin memakai media bantu pembelajaran.
- Pengguna umum yang ingin memahami minor dan kofaktor secara visual.

## Konsep Utama
Website menampilkan matriks 3x3 sebagai objek visual 3D. Pengguna memilih baris dan kolom, lalu website menampilkan elemen yang ditutup serta elemen yang tersisa untuk menghitung minor dan kofaktor.

## Alur Pengguna
1. Pengguna membuka website.
2. Pengguna melihat halaman pembuka dengan judul MAMITOR 3D.
3. Pengguna klik tombol “Mulai Bermain”.
4. Pengguna masuk ke area permainan/pembelajaran.
5. Pengguna mengisi nilai matriks 3x3.
6. Pengguna memilih baris dan kolom.
7. Website menampilkan animasi baris/kolom yang tertutup.
8. Website menampilkan matriks sisa.
9. Pengguna mengisi jawaban minor dan kofaktor.
10. Pengguna klik “Cek Jawaban”.
11. Website memberi feedback benar/salah.

## Struktur Halaman
### 1. Start Screen
Berisi:

- Judul: MAMITOR 3D
- Subtitle: Matriks Minor dan Kofaktor
- Deskripsi singkat
- Tombol “Mulai Bermain”
- Background animasi ringan

### 2. Workspace
Berisi:

- Scene 3D matriks 3x3
- Panel input nilai matriks
- Dropdown pilih baris
- Dropdown pilih kolom
- Tombol proses
- Panel rumus dan jawaban

### 3. Formula Panel
Berisi:

- Matriks sisa 2x2
- Rumus minor
- Input jawaban minor
- Rumus kofaktor
- Input jawaban kofaktor
- Tombol cek jawaban
- Feedback

## Gaya Visual
Tema: dark futuristic educational.

Warna utama:

- Background: `#020617`, `#0f172a`
- Card: `rgba(15, 23, 42, 0.7)`
- Primary: cyan/biru `#38bdf8`, `#0ea5e9`
- Success: hijau `#10b981`
- Accent/Kofaktor: pink/merah `#f43f5e`
- Text utama: `#f8fafc`
- Text sekunder: `#94a3b8`

## UI Rules
- Gunakan border halus.
- Gunakan radius besar untuk card.
- Gunakan shadow lembut.
- Gunakan spacing lega.
- Button harus jelas dan punya hover state.
- Panel rumus harus mudah dibaca.
- Mobile layout harus satu kolom.

## 3D Visual Rules
- Matrix divisualkan sebagai 9 tile/block 3D.
- Tile normal memakai warna cyan gelap.
- Tile tertutup dibuat redup/transparan.
- Tile matriks sisa diberi glow hijau.
- Animasi pilih baris/kolom harus halus.
- Kamera scene tidak boleh membuat objek sulit dilihat.

## Animasi
Gunakan Framer Motion untuk:

- start screen,
- tombol “Mulai Bermain”,
- card masuk,
- feedback jawaban,
- transisi panel.

Gunakan React Three Fiber untuk:

- animasi block 3D,
- highlight,
- perubahan posisi/opacity.

Gunakan Lenis untuk smooth scroll.

## Responsiveness
Desktop:

- Scene 3D di kiri.
- Panel rumus dan kontrol di kanan.

Mobile:

- Start screen tetap full screen.
- Scene 3D di atas.
- Kontrol dan rumus di bawah.
- Ukuran font dan block disesuaikan.

## Hal yang Tidak Boleh Diubah
- Materi tetap Matriks Minor dan Kofaktor.
- Matriks utama tetap 3x3.
- Fitur hitung minor dan kofaktor tetap menjadi inti.
- Referensi Menara Bilangan tidak boleh dijiplak sebagai materi.
