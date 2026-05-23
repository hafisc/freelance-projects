# CODING_GUIDE.md — Panduan Koding

## Bahasa
Gunakan TypeScript untuk seluruh komponen dan logic.

## Styling
Gunakan Tailwind CSS sebagai styling utama.

Custom CSS hanya digunakan untuk:

- style global,
- animasi khusus,
- override kecil yang tidak praktis dengan Tailwind.

## Komentar Kode
Setiap fungsi penting wajib memakai komentar Bahasa Indonesia.

Contoh:

```ts
// Fungsi ini mengambil nilai matriks dari state dan memastikan semua nilai berbentuk angka.
function normalizeMatrixValues(matrix: Matrix3x3): Matrix3x3 {
  return matrix.map((row) => row.map((value) => Number(value) || 0)) as Matrix3x3;
}
```

## Standar TypeScript
Gunakan type yang jelas.

Contoh:

```ts
export type Matrix3x3 = [
  [number, number, number],
  [number, number, number],
  [number, number, number]
];

export type Matrix2x2 = [
  [number, number],
  [number, number]
];
```

## Logic Matrix
Logic matrix harus berada di `src/lib/matrix.ts`.

Minimal fungsi:

- `createSubMatrix`
- `calculateMinor`
- `calculateCofactor`
- `isMatrixAnswerCorrect`
- `isNumberAnswerCorrect`

## State Management
Cukup gunakan React state/custom hook.

Tidak perlu Redux/Zustand karena project kecil.

Custom hook utama:

- `useMatrixGame`

Hook ini mengatur:

- nilai matriks,
- baris terpilih,
- kolom terpilih,
- matriks sisa,
- jawaban user,
- hasil minor,
- hasil kofaktor,
- feedback.

## Three.js / React Three Fiber
Gunakan React Three Fiber agar scene 3D rapi di React.

Aturan:

- Komponen scene ada di `MamitorScene.tsx`.
- Komponen tile/block ada di `MatrixBlock.tsx`.
- Lighting dipisah ke `SceneLights.tsx`.
- Jangan membuat geometry terlalu kompleks.
- Gunakan animasi ringan.

## Framer Motion
Gunakan untuk:

- entrance animation,
- tombol “Mulai Bermain”,
- card transition,
- feedback jawaban.

## KaTeX
Gunakan KaTeX untuk rumus:

- `A_{ij}`
- `M_{ij} = det(A_{ij})`
- `M_{ij} = (a \times d) - (b \times c)`
- `C_{ij} = (-1)^{i+j}M_{ij}`

Pastikan import CSS KaTeX di layout/global:

```ts
import 'katex/dist/katex.min.css';
```

## Lenis
Gunakan Lenis melalui hook `useLenis.ts`.

Pastikan hook hanya berjalan di client component.

## Error Handling
- Jika input kosong, gunakan nilai 0 atau validasi aman.
- Jika KaTeX gagal render, tampilkan fallback teks biasa.
- Jika user belum klik proses, panel hasil boleh menampilkan placeholder.

## Build Check
Sebelum selesai, jalankan:

```bash
npm run lint
npm run build
```
