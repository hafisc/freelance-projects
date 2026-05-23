# DEPLOYMENT.md — Panduan Deploy Vercel

## Platform Deploy
Project ini ditargetkan deploy ke **Vercel**.

## Persiapan Sebelum Deploy
Pastikan command berikut berhasil:

```bash
npm run build
```

Pastikan tidak ada error TypeScript, error import, atau error asset.

## Deploy via Vercel Dashboard
1. Push project ke GitHub.
2. Buka Vercel.
3. Klik Add New Project.
4. Import repository.
5. Framework preset: Next.js.
6. Build command: `npm run build`.
7. Output directory: default Next.js.
8. Klik Deploy.

## Deploy via Vercel CLI
Install Vercel CLI:

```bash
npm install -g vercel
```

Login:

```bash
vercel login
```

Deploy preview:

```bash
vercel
```

Deploy production:

```bash
vercel --prod
```

## Catatan
Project ini tidak membutuhkan environment variable karena tidak memakai backend/API.

Jika nanti ada asset 3D tambahan, simpan di `public/assets/` agar mudah dibaca Next.js.
