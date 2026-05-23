# INSTALLATION.md — Dependency dan Setup Project

## Setup Project Baru
Jika folder masih kosong, jalankan:

```bash
npx create-next-app@latest . --typescript --tailwind --eslint --app --src-dir --import-alias "@/*"
```

Saat muncul pertanyaan, gunakan pilihan berikut:

```txt
Would you like to use TypeScript? Yes
Would you like to use ESLint? Yes
Would you like to use Tailwind CSS? Yes
Would you like your code inside a `src/` directory? Yes
Would you like to use App Router? Yes
Would you like to use Turbopack? Yes
Would you like to customize the import alias? No
```

## Package yang Wajib Diinstall
Setelah Next.js selesai dibuat, install package berikut:

```bash
npm install three @react-three/fiber @react-three/drei lenis framer-motion katex clsx tailwind-merge lucide-react
```

Install type untuk Three.js:

```bash
npm install -D @types/three
```

## Fungsi Masing-Masing Package

### `three`
Library utama untuk render 3D di browser.

### `@react-three/fiber`
Wrapper React untuk Three.js agar scene 3D bisa dibuat sebagai component React.

### `@react-three/drei`
Helper untuk React Three Fiber, seperti OrbitControls, Text, Environment, dan utility lain.

### `lenis`
Smooth scroll modern.

### `framer-motion`
Animasi UI, transisi halaman, tombol, card, dan feedback.

### `katex`
Render rumus matematika.

### `clsx`
Membantu menggabungkan className secara kondisional.

### `tailwind-merge`
Membantu menghindari konflik class Tailwind.

### `lucide-react`
Icon modern untuk UI.

### `@types/three`
TypeScript type untuk Three.js.

## Script yang Harus Ada di `package.json`
Pastikan script berikut tersedia:

```json
{
  "scripts": {
    "dev": "next dev --turbopack",
    "build": "next build",
    "start": "next start",
    "lint": "next lint"
  }
}
```

Jika `next lint` tidak tersedia di versi Next.js yang dipakai, gunakan perintah lint bawaan yang dibuat oleh create-next-app.

## Jalankan Project
```bash
npm run dev
```

Buka:

```txt
http://localhost:3000
```

## Build Project
```bash
npm run build
```
