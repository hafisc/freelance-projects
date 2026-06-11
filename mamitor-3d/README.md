# MAMITOR 3D — Matriks Minor & Kofaktor

MAMITOR 3D adalah website media digital alat peraga untuk belajar menghitung **Minor** dan **Kofaktor** pada matriks 3x3 menggunakan visualisasi interaktif 3D.

## Tech Stack
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

## Fitur
- Halaman pembuka dengan animasi “Mulai Bermain”.
- Visualisasi 3D matriks 3x3.
- Input nilai matriks.
- Pilih baris dan kolom.
- Highlight matriks sisa.
- Perhitungan minor.
- Perhitungan kofaktor.
- Input jawaban manual.
- Cek jawaban.
- Feedback benar/salah.
- Responsive desktop dan mobile.

## Instalasi
Buat project Next.js:

```bash
npx create-next-app@latest . --typescript --tailwind --eslint --app --src-dir --import-alias "@/*"
```

Install dependency:

```bash
npm install three @react-three/fiber @react-three/drei lenis framer-motion katex clsx tailwind-merge lucide-react
npm install -D @types/three
```

Jalankan development server:

```bash
npm run dev
```

Build production:

```bash
npm run build
```

## Deploy
Deploy menggunakan Vercel.

```bash
vercel --prod
```

## Catatan Pengembangan
- Project ini tidak menggunakan backend.
- Semua logic berjalan di frontend.
- Fungsi penting harus memiliki komentar Bahasa Indonesia.
- Logic matematika berada di `src/lib/matrix.ts`.
- Komponen 3D berada di `src/components/three/`.
