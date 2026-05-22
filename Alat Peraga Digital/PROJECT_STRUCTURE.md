# PROJECT_STRUCTURE.md

## Struktur Folder Final Yang Disarankan

```txt
mamitor-3d/
├── index.html
├── package.json
├── package-lock.json
├── vite.config.js
├── README.md
├── AGENTS.md
├── CLAUDE.md
├── DESIGN.md
├── SOW.md
├── PROJECT_STRUCTURE.md
├── CODING_GUIDE.md
├── DEPLOYMENT.md
├── TASKS.md
├── public/
│   └── favicon.svg
└── src/
    ├── main.js
    ├── styles/
    │   ├── base.css
    │   ├── layout.css
    │   ├── components.css
    │   └── responsive.css
    ├── js/
    │   ├── dom.js
    │   ├── matrix.js
    │   ├── katex-renderer.js
    │   ├── animation.js
    │   └── validation.js
    └── assets/
        └── images/
```

## Penjelasan Folder dan File

### `index.html`

File utama HTML. Berisi root layout, CDN KaTeX, dan koneksi ke `src/main.js`.

### `src/main.js`

Entry point JavaScript. Berisi inisialisasi event listener dan penghubung antar module.

### `src/styles/base.css`

Berisi reset CSS, CSS variable, font, body, dan style global.

### `src/styles/layout.css`

Berisi layout utama seperti app container, visual panel, controls panel, dan worksheet panel.

### `src/styles/components.css`

Berisi style komponen seperti button, input, matrix block, feedback, dan start screen.

### `src/styles/responsive.css`

Berisi media query untuk tablet dan mobile.

### `src/js/dom.js`

Helper DOM agar kode utama tidak terlalu penuh selector.

### `src/js/matrix.js`

Logic utama matriks, termasuk mengambil nilai matriks, mencari matriks sisa, menghitung minor, dan menghitung kofaktor.

### `src/js/katex-renderer.js`

Helper render rumus matematika menggunakan KaTeX.

### `src/js/animation.js`

Logic animasi seperti start screen, highlight matriks, crossed block, dan tampilkan worksheet.

### `src/js/validation.js`

Logic pengecekan jawaban user dan pemberian feedback benar/salah.

## Rekomendasi Import CSS

Di `src/main.js`:

```js
import './styles/base.css';
import './styles/layout.css';
import './styles/components.css';
import './styles/responsive.css';
```

## Rekomendasi Script Package

Di `package.json`:

```json
{
  "scripts": {
    "dev": "vite",
    "build": "vite build",
    "preview": "vite preview"
  }
}
```
