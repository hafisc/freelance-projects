# TASKS.md — Checklist Pengerjaan

## Phase 1 — Setup Project
- [ ] Jalankan create-next-app.
- [ ] Install package wajib.
- [ ] Pastikan Tailwind aktif.
- [ ] Pastikan project bisa berjalan dengan `npm run dev`.
- [ ] Buat struktur folder sesuai `PROJECT_STRUCTURE.md`.

## Phase 2 — Base Layout
- [ ] Buat layout global.
- [ ] Import CSS KaTeX.
- [ ] Buat theme dark di `globals.css`.
- [ ] Buat PageShell.
- [ ] Buat komponen Button dan Card.

## Phase 3 — Start Screen
- [ ] Buat `StartScreen.tsx`.
- [ ] Tambahkan judul MAMITOR 3D.
- [ ] Tambahkan deskripsi singkat.
- [ ] Tambahkan tombol “Mulai Bermain”.
- [ ] Tambahkan animasi Framer Motion.
- [ ] Tombol mengarah ke workspace.

## Phase 4 — Logic Matrix
- [ ] Buat type Matrix3x3 dan Matrix2x2.
- [ ] Buat default matrix.
- [ ] Buat fungsi membuat matriks sisa.
- [ ] Buat fungsi menghitung minor.
- [ ] Buat fungsi menghitung kofaktor.
- [ ] Buat fungsi validasi jawaban.
- [ ] Tambahkan komentar Bahasa Indonesia pada fungsi penting.

## Phase 5 — Matrix UI
- [ ] Buat input nilai matriks 3x3.
- [ ] Buat dropdown baris.
- [ ] Buat dropdown kolom.
- [ ] Buat tombol proses.
- [ ] Buat panel matriks sisa.
- [ ] Buat panel minor.
- [ ] Buat panel kofaktor.
- [ ] Buat input jawaban manual.
- [ ] Buat feedback benar/salah.

## Phase 6 — 3D Scene
- [ ] Buat Canvas React Three Fiber.
- [ ] Buat 9 MatrixBlock.
- [ ] Buat lighting.
- [ ] Buat camera setup.
- [ ] Tambahkan OrbitControls.
- [ ] Block tertutup dibuat redup.
- [ ] Block matriks sisa diberi highlight.
- [ ] Tambahkan animasi ringan.

## Phase 7 — Polish UI
- [ ] Rapikan responsive desktop.
- [ ] Rapikan responsive mobile.
- [ ] Tambahkan hover state.
- [ ] Tambahkan empty state/placeholder.
- [ ] Tambahkan smooth scroll Lenis.
- [ ] Pastikan UI tidak terlalu ramai.

## Phase 8 — Testing
- [ ] Test input angka positif.
- [ ] Test input angka negatif.
- [ ] Test input kosong.
- [ ] Test semua kombinasi baris dan kolom.
- [ ] Test minor.
- [ ] Test kofaktor.
- [ ] Test cek jawaban benar.
- [ ] Test cek jawaban salah.
- [ ] Test mobile view.
- [ ] Test console browser.

## Phase 9 — Finalisasi
- [ ] Jalankan `npm run lint`.
- [ ] Jalankan `npm run build`.
- [ ] Update README.
- [ ] Siapkan deploy Vercel.
