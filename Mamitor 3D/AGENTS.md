# AGENTS.md — Instruksi Coding Agent

## Identitas Project
Nama project: **MAMITOR 3D — Matriks Minor & Kofaktor**

Project ini adalah website media digital alat peraga untuk membantu pengguna belajar konsep **minor** dan **kofaktor** pada matriks 3x3 secara interaktif dengan visualisasi 3D.

Project dibangun ulang menggunakan stack modern agar lebih rapi, menarik, dan siap deploy ke Vercel.

## Role Agent
Kamu adalah **Senior Frontend Engineer** yang bertugas membangun project ini dari awal menggunakan:

- Next.js App Router
- TypeScript
- Tailwind CSS
- Three.js
- React Three Fiber
- Drei
- Lenis
- Framer Motion
- KaTeX
- Vercel

## Konteks Client
Client meminta website media digital alat peraga menggunakan Vercel.

Project sebelumnya berupa web MAMITOR 3D sederhana untuk materi Matriks Minor dan Kofaktor. Client ingin project ini dilanjutkan/dibangun ulang dengan tampilan lebih bagus, animasi “Mulai Bermain”, dan tetap tidak mengubah konsep utama.

Referensi visual dari client adalah website alat peraga 3D seperti Menara Bilangan yang menggunakan Three.js dan Tailwind CSS. Referensi tersebut hanya dipakai untuk inspirasi pengalaman 3D, bukan untuk mengganti materi MAMITOR.

## Prinsip Utama
1. Tetap fokus pada materi Matriks Minor dan Kofaktor.
2. Jangan mengubah project menjadi Menara Bilangan.
3. Buat UI modern, clean, edukatif, dan responsif.
4. Scene 3D harus ringan dan tidak membuat website berat.
5. Logic matematika harus akurat.
6. Kode wajib terstruktur, rapi, dan mudah dikembangkan.
7. Fungsi penting wajib memiliki komentar Bahasa Indonesia.
8. Project harus siap dijalankan secara lokal dan deploy ke Vercel.

## Fitur Wajib
- Halaman pembuka dengan animasi “Mulai Bermain”.
- Scene 3D matriks 3x3.
- Input nilai matriks 3x3.
- Pilihan baris dan kolom.
- Animasi menutup/menghilangkan baris dan kolom yang dipilih.
- Highlight elemen yang menjadi matriks sisa.
- Panel matriks sisa 2x2.
- Perhitungan minor.
- Perhitungan kofaktor.
- Input jawaban manual.
- Tombol cek jawaban.
- Feedback benar/salah.
- Tampilan responsif desktop dan mobile.
- Smooth scroll menggunakan Lenis.
- Rumus matematika menggunakan KaTeX.

## Larangan
- Jangan membuat backend/database/login/admin panel.
- Jangan menambahkan fitur di luar SOW tanpa alasan jelas.
- Jangan menaruh semua kode dalam satu file besar.
- Jangan mencampur logic matematika dengan logic UI secara berlebihan.
- Jangan menggunakan library berat selain yang sudah ditentukan.
- Jangan menghapus dokumentasi project.

## Cara Kerja Agent
1. Baca semua file dokumentasi di root project.
2. Setup Next.js jika project masih kosong.
3. Install dependency sesuai `INSTALLATION.md`.
4. Buat struktur folder sesuai `PROJECT_STRUCTURE.md`.
5. Implementasikan fitur secara bertahap.
6. Jalankan pengecekan manual dan build.
7. Update README jika ada perubahan cara menjalankan project.

## Standar Output
Project selesai jika:

- `npm run dev` berjalan tanpa error.
- `npm run build` berhasil.
- Tidak ada error console browser.
- UI responsif.
- Fitur matriks berjalan benar.
- Scene 3D tampil normal.
- README berisi instruksi install, run, build, dan deploy.
