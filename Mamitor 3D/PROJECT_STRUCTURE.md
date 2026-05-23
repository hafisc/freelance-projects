# PROJECT_STRUCTURE.md — Struktur Folder Project

Gunakan struktur berikut agar project rapi dan mudah dikembangkan.

```txt
mamitor-3d/
├── public/
│   ├── assets/
│   │   ├── icons/
│   │   └── images/
│   └── favicon.ico
├── src/
│   ├── app/
│   │   ├── globals.css
│   │   ├── layout.tsx
│   │   └── page.tsx
│   ├── components/
│   │   ├── hero/
│   │   │   └── StartScreen.tsx
│   │   ├── layout/
│   │   │   └── PageShell.tsx
│   │   ├── matrix/
│   │   │   ├── MatrixWorkspace.tsx
│   │   │   ├── MatrixControls.tsx
│   │   │   ├── MatrixInputGrid.tsx
│   │   │   ├── MatrixFormulaPanel.tsx
│   │   │   └── AnswerFeedback.tsx
│   │   ├── three/
│   │   │   ├── MamitorScene.tsx
│   │   │   ├── MatrixBlock.tsx
│   │   │   └── SceneLights.tsx
│   │   └── ui/
│   │       ├── Button.tsx
│   │       ├── Card.tsx
│   │       └── SectionTitle.tsx
│   ├── hooks/
│   │   ├── useLenis.ts
│   │   └── useMatrixGame.ts
│   ├── lib/
│   │   ├── constants.ts
│   │   ├── katex.ts
│   │   ├── matrix.ts
│   │   └── utils.ts
│   └── types/
│       └── matrix.ts
├── .eslintrc.json
├── next.config.ts
├── package.json
├── postcss.config.mjs
├── tailwind.config.ts
├── tsconfig.json
├── README.md
├── AGENTS.md
├── CLAUDE.md
├── DESIGN.md
├── SOW.md
├── TASKS.md
├── CODING_GUIDE.md
├── INSTALLATION.md
└── DEPLOYMENT.md
```

## Penjelasan Folder

### `src/app`
Folder utama Next.js App Router.

### `src/components/hero`
Komponen halaman pembuka dan animasi “Mulai Bermain”.

### `src/components/matrix`
Komponen UI untuk input matriks, kontrol baris/kolom, panel rumus, dan feedback.

### `src/components/three`
Komponen khusus visualisasi 3D menggunakan React Three Fiber.

### `src/components/ui`
Komponen UI kecil yang reusable.

### `src/hooks`
Custom hook untuk state permainan dan integrasi Lenis.

### `src/lib`
Logic helper dan utility, termasuk perhitungan matematika.

### `src/types`
TypeScript type/interface untuk data matriks.

## Aturan Struktur
- Jangan menaruh semua komponen di `page.tsx`.
- Jangan menaruh logic perhitungan langsung di komponen UI.
- Jangan menaruh semua CSS custom di satu file jika bisa memakai Tailwind.
- File harus diberi nama jelas sesuai fungsinya.
