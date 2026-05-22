# MAMITOR 3D - Matriks Minor & Kofaktor

MAMITOR 3D adalah website media digital alat peraga interaktif yang dirancang khusus untuk membantu pembelajaran matematika, khususnya dalam menentukan **Minor** dan **Kofaktor** dari matriks 3x3. 

Aplikasi ini menggunakan visualisasi grid 3D interaktif yang memberikan pengalaman belajar secara visual dan menyenangkan bagi siswa.

---

## 🚀 Fitur Utama

1. **Halaman Intro "Mulai Bermain"**: Tampilan awal pembuka yang interaktif untuk menyambut pengguna sebelum masuk ke alat peraga.
2. **Input Matriks 3x3 Dinamis**: Pengguna dapat memasukkan angka bebas pada matriks 3x3 (mendukung angka negatif dan desimal).
3. **Pilihan Baris & Kolom**: Dropdown interaktif untuk memilih baris dan kolom mana yang ingin ditutup.
4. **Visualisasi 3D Interaktif**:
   - Grid matriks dapat miring secara dinamis mengikuti arah kursor mouse (efek depth 3D).
   - Animasi *crossed* (memudar ke belakang) untuk elemen baris/kolom yang ditutup.
   - Animasi *highlight* (glowing hijau) untuk elemen matriks sisa yang terpilih.
5. **Lembar Kerja Manual (Worksheet)**:
   - Form pengisian nilai matriks sisa 2x2.
   - Rumus determinan minor dengan langkah perkalian $(a \times d) - (b \times c)$.
   - Perhitungan kofaktor menggunakan KaTeX untuk merender rumus matematika secara presisi.
6. **Sistem Validasi & Feedback**:
   - Menilai jawaban secara real-time saat tombol "Cek Jawaban" diklik.
   - Kolom yang benar akan berwarna **hijau**, sedangkan kolom yang salah akan berwarna **merah**.
   - Dilengkapi pesan feedback interaktif.
7. **Desain Modern & Responsif**: Menggunakan tema *dark glassmorphism* dengan penyesuaian tata letak (responsive layout) agar nyaman digunakan di laptop, tablet, maupun HP.

---

## 🛠️ Tech Stack

- **Core**: HTML5, CSS3, JavaScript Native (ES Modules)
- **Bundler**: [Vite](https://vitejs.dev/) (cepat, ringan, dan modern)
- **Math Renderer**: [KaTeX CDN](https://katex.org/) (untuk rendering simbol matematika berkinerja tinggi)
- **Hosting**: [Vercel](https://vercel.com/)

---

## 💻 Cara Menjalankan Project di Local

Pastikan Anda telah menginstal [Node.js](https://nodejs.org/) di perangkat Anda.

### 1. Jalankan Install Dependency
Unduh dan pasang modul-modul yang diperlukan (terutama Vite):
```bash
npm install
```

### 2. Jalankan Development Server
Jalankan aplikasi di mode local server:
```bash
npm run dev
```
Setelah dijalankan, buka browser di alamat yang tertera di terminal (secara default `http://localhost:3000`).

### 3. Build untuk Production
Untuk mengompilasi dan mengoptimalkan aset aplikasi agar siap di-deploy:
```bash
npm run build
```
Hasil kompilasi akan berada di dalam folder `dist/`.

### 4. Preview Hasil Build
Untuk menguji hasil build production secara lokal sebelum deploy:
```bash
npm run preview
```

---

## ☁️ Panduan Deploy ke Vercel

Aplikasi ini sudah dikonfigurasi menggunakan Vite dan sangat siap dideploy ke **Vercel** dengan langkah mudah berikut:

### Metode 1: Deploy lewat GitHub (Rekomendasi)
1. Unggah kode project ini ke repositori baru di GitHub.
2. Masuk ke dashboard [Vercel](https://vercel.com/).
3. Klik **Add New** > **Project**.
4. Import repositori GitHub Anda.
5. Pada bagian **Build & Development Settings**, Vercel akan otomatis mendeteksi konfigurasi Vite:
   - **Framework Preset**: Vite
   - **Build Command**: `npm run build`
   - **Output Directory**: `dist`
6. Klik tombol **Deploy**.

### Metode 2: Deploy lewat Vercel CLI
Jika Anda ingin men-deploy langsung dari terminal lokal Anda:
1. Pastikan Vercel CLI sudah terinstal secara global:
   ```bash
   npm install -g vercel
   ```
2. Jalankan perintah login (jika belum):
   ```bash
   vercel login
   ```
3. Deploy project langsung dari root folder:
   ```bash
   vercel
   ```
4. Untuk deploy langsung ke production:
   ```bash
   vercel --prod
   ```
