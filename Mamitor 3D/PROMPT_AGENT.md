# PROMPT_AGENT.md — Prompt Utama untuk Coding Agent

Copy prompt berikut ke coding agent setelah project Next.js dibuat atau sebelum agent mulai coding.

```text
Kamu adalah Senior Frontend Engineer yang mengerjakan project MAMITOR 3D — Matriks Minor & Kofaktor.

Baca semua file dokumentasi di root project terlebih dahulu:
- AGENTS.md
- CLAUDE.md
- DESIGN.md
- SOW.md
- PROJECT_STRUCTURE.md
- CODING_GUIDE.md
- INSTALLATION.md
- DEPLOYMENT.md
- TASKS.md
- README.md

Project ini dibangun ulang dari awal menggunakan Next.js App Router, TypeScript, Tailwind CSS, Three.js, React Three Fiber, Drei, Lenis, Framer Motion, KaTeX, dan deploy ke Vercel.

Konteks client:
Client ingin website media digital alat peraga MAMITOR 3D untuk belajar Matriks Minor dan Kofaktor. Referensi visualnya adalah alat peraga 3D yang menggunakan Three.js dan Tailwind CSS. Jangan mengubah materi menjadi Menara Bilangan. Tetap fokus pada Matriks Minor dan Kofaktor.

Tugas kamu:
1. Jika project masih kosong, setup Next.js sesuai INSTALLATION.md.
2. Install semua package wajib sesuai INSTALLATION.md.
3. Buat struktur folder sesuai PROJECT_STRUCTURE.md.
4. Implementasikan halaman pembuka dengan tombol dan animasi “Mulai Bermain”.
5. Implementasikan workspace utama MAMITOR 3D.
6. Buat scene 3D matriks 3x3 menggunakan React Three Fiber dan Drei.
7. Buat input nilai matriks 3x3.
8. Buat pilihan baris dan kolom.
9. Buat animasi menutup/menghilangkan baris dan kolom yang dipilih.
10. Buat highlight elemen matriks sisa.
11. Buat panel rumus matriks sisa, minor, dan kofaktor menggunakan KaTeX.
12. Buat input jawaban manual.
13. Buat tombol cek jawaban dan feedback benar/salah.
14. Gunakan Lenis untuk smooth scroll.
15. Gunakan Framer Motion untuk animasi UI.
16. Pastikan responsive desktop dan mobile.
17. Tambahkan komentar Bahasa Indonesia pada fungsi-fungsi penting.
18. Jalankan lint/build dan perbaiki error.
19. Update README jika diperlukan.

Aturan penting:
- Jangan membuat backend, database, login, admin panel, atau API.
- Jangan mengubah konsep utama.
- Jangan menaruh semua kode dalam satu file.
- Logic matrix wajib dipisah di src/lib/matrix.ts.
- Komponen 3D wajib dipisah di src/components/three/.
- Komponen UI matrix wajib dipisah di src/components/matrix/.
- Kode harus rapi, modular, dan mudah dibaca.
- Setiap fungsi penting wajib diberi komentar Bahasa Indonesia.

Selesaikan project sampai bisa dijalankan dengan npm run dev dan build berhasil dengan npm run build.
```
