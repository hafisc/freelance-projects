# EquiChem - React Website (Micromodul Kesetimbangan Kimia)

Ini adalah implementasi **React JS** untuk website EquiChem sesuai desain Canva (15 halaman). Proyek ini dibangun dengan Vite + React Router + Bootstrap.

## 🚀 Cara Menjalankan

1. **Clone / Download project** ke komputer.
2. Buka terminal di folder project.
3. Install dependencies:
   ```bash
   npm install
   ```
4. Jalankan development server:
   ```bash
   npm run dev
   ```
5. Buka browser di `http://localhost:5173`.

## 📦 Build untuk Production
```bash
npm run build
```
Hasil build ada di folder `dist/`.

## 📁 Struktur Folder (Singkat)
- `src/pages/` → 15 halaman utama.
- `src/components/` → Komponen reusable (Navbar, Slider, dll).
- `src/context/` → Global state (AppContext).
- `src/hooks/` → Custom hooks (useLocalStorage).
- `src/assets/` → CSS dan gambar.

## 📝 Catatan
- Semua komentar dalam Bahasa Indonesia.
- Gunakan `useAppContext()` untuk mengakses global state.
- Progress dan skor otomatis tersimpan di localStorage browser.


