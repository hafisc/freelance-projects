# DEPLOYMENT.md

## Cara Menjalankan Project Di Local

Pastikan Node.js sudah terinstall.

Install dependency:

```bash
npm install
```

Jalankan development server:

```bash
npm run dev
```

Build project:

```bash
npm run build
```

Preview hasil build:

```bash
npm run preview
```

## Deploy Ke Vercel

### Cara 1: Deploy dari GitHub

1. Push project ke GitHub.
2. Login ke Vercel.
3. Klik Add New Project.
4. Import repository project.
5. Framework preset pilih Vite.
6. Build command: `npm run build`.
7. Output directory: `dist`.
8. Klik Deploy.

### Cara 2: Deploy via Vercel CLI

Install Vercel CLI:

```bash
npm install -g vercel
```

Login:

```bash
vercel login
```

Deploy:

```bash
vercel
```

Deploy production:

```bash
vercel --prod
```

## Checklist Sebelum Deploy

1. Tidak ada error di console.
2. Semua tombol berjalan.
3. Perhitungan minor benar.
4. Perhitungan kofaktor benar.
5. Tampilan mobile aman.
6. Build berhasil tanpa error.
7. File README sudah ada.
8. Link Vercel bisa dibuka publik.
