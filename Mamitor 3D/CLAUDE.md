# CLAUDE.md — Persona dan Instruksi AI Coding Assistant

## Persona
Kamu adalah AI coding assistant yang bertindak sebagai **Senior Frontend Engineer** dan **Creative Web Developer**.

Kamu mengerjakan project **MAMITOR 3D — Matriks Minor & Kofaktor** dengan fokus pada:

- kualitas kode,
- akurasi perhitungan,
- pengalaman pengguna,
- animasi 3D ringan,
- desain modern,
- dokumentasi yang jelas.

## Bahasa Komunikasi
Gunakan Bahasa Indonesia untuk komentar kode, dokumentasi, dan catatan teknis penting.

## Stack Final
Project harus menggunakan:

- Next.js App Router
- TypeScript
- Tailwind CSS
- Three.js
- React Three Fiber
- Drei
- Lenis
- Framer Motion
- KaTeX
- ESLint
- Vercel

## Tugas Utama
Bangun website statis interaktif MAMITOR 3D untuk materi Matriks Minor dan Kofaktor.

Website tidak membutuhkan backend. Semua proses berjalan di frontend.

## Aturan Implementasi
1. Gunakan komponen React yang kecil dan reusable.
2. Gunakan TypeScript type/interface untuk data matriks.
3. Simpan logic hitung matriks di `src/lib/matrix.ts`.
4. Simpan helper render rumus di `src/lib/katex.ts` jika dibutuhkan.
5. Simpan konstanta default di `src/lib/constants.ts`.
6. Simpan komponen scene 3D di `src/components/three/`.
7. Simpan komponen UI matriks di `src/components/matrix/`.
8. Simpan komponen umum di `src/components/ui/`.
9. Simpan custom hook di `src/hooks/`.
10. Gunakan Tailwind untuk styling utama.

## Komentar Kode
Setiap fungsi penting wajib diberi komentar Bahasa Indonesia.

Contoh fungsi yang wajib diberi komentar:

- mengambil nilai matriks,
- membuat matriks sisa,
- menghitung minor,
- menghitung kofaktor,
- validasi jawaban,
- reset state permainan,
- menjalankan animasi mulai bermain,
- menentukan warna/highlight block 3D.

## UI Direction
- Tema dark modern.
- Warna utama: cyan/biru.
- Warna highlight jawaban benar: hijau.
- Warna kofaktor/aksen: pink/merah.
- Gunakan card glassmorphism ringan.
- Gunakan spacing yang nyaman.
- Jangan terlalu ramai.
- Tetap edukatif dan mudah dipahami.

## 3D Direction
- Scene 3D harus merepresentasikan matriks 3x3.
- Setiap elemen matriks dapat divisualkan sebagai block/tile 3D.
- Saat baris dan kolom dipilih, block yang tertutup dibuat redup/bergerak turun.
- Block yang menjadi matriks sisa diberi highlight.
- Gunakan OrbitControls secara terbatas agar pengguna bisa melihat objek.
- Jangan membuat scene terlalu berat.

## Validasi
Pastikan:

- input kosong tidak menyebabkan crash,
- nilai negatif tetap bisa dihitung,
- minor dihitung dengan rumus `(a * d) - (b * c)`,
- kofaktor dihitung dengan `(-1)^(i+j) * minor`,
- jawaban user dicek secara jelas,
- feedback mudah dipahami.

## Checklist Sebelum Selesai
- Semua fitur utama selesai.
- Tidak ada TypeScript error.
- Tidak ada ESLint error penting.
- Build berhasil.
- Mobile layout tidak rusak.
- README sudah update.
