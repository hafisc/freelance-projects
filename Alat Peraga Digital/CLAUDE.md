# CLAUDE.md

## Peran Claude / Coding Agent

Bertindak sebagai frontend developer yang mengerjakan lanjutan website media digital alat peraga MAMITOR 3D. Fokus utama adalah melanjutkan kode yang sudah diberikan client, merapikan struktur project, memperbaiki error, menambahkan animasi “Mulai Bermain”, memperbagus tampilan, dan memastikan fitur matriks minor-kofaktor berjalan benar.

## Konteks Client

Client meminta website media digital alat peraga menggunakan Vercel. Project disebut sebagai lanjutan, bukan project yang benar-benar baru dari awal. Client memberi contoh kode HTML/CSS/JavaScript dan meminta:

1. Kasih animasi “Mulai Bermain”.
2. Lebih bagus lagi tampilannya.
3. Jangan mengubah konsep utama.
4. Deadline bebas, tetapi jangan lebih dari 1 minggu.

Karena kode client masih berupa potongan HTML/CSS/JS, project perlu dirapikan menjadi struktur yang lebih proper.

## Tech Stack Yang Dipakai

Gunakan:

- Vite
- HTML
- CSS
- JavaScript Native
- KaTeX
- Vercel

Jangan gunakan React, Vue, Laravel, atau backend karena scope project ini hanya website interaktif frontend.

## Instruksi Pengerjaan

1. Buat project menggunakan Vite Vanilla JS.
2. Buat struktur folder rapi.
3. Pindahkan layout HTML ke `index.html` dan/atau komponen render di JavaScript.
4. Pisahkan styling ke folder `src/styles`.
5. Pisahkan logic matriks ke folder `src/js`.
6. Pastikan kode mudah dibaca.
7. Tambahkan komentar Bahasa Indonesia pada fungsi-fungsi penting.
8. Pastikan logic perhitungan minor dan kofaktor benar.
9. Pastikan KaTeX berjalan untuk render rumus.
10. Pastikan semua tombol bisa digunakan.
11. Pastikan tampilan mobile tidak rusak.
12. Jangan mengubah nama konsep “MAMITOR 3D”.

## Struktur Folder Yang Disarankan

```txt
mamitor-3d/
├── index.html
├── package.json
├── vite.config.js
├── README.md
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

## Detail Fungsi Yang Perlu Dibuat

### `src/js/dom.js`

Berisi helper untuk mengambil elemen DOM.

Fungsi yang disarankan:

- `getElement(selector)`
- `getInputValue(id)`
- `setInputState(input, status)`
- `resetManualInputs()`

### `src/js/matrix.js`

Berisi logic matriks.

Fungsi yang disarankan:

- `getMatrixValues()`
- `getRemainingMatrix(matrix, selectedRow, selectedCol)`
- `calculateMinor(remainingMatrix)`
- `calculateCofactor(minor, selectedRow, selectedCol)`

### `src/js/katex-renderer.js`

Berisi fungsi render rumus menggunakan KaTeX.

Fungsi yang disarankan:

- `renderFormula(element, formula)`
- `renderAllFormulas(selectedRow, selectedCol)`

### `src/js/animation.js`

Berisi animasi UI.

Fungsi yang disarankan:

- `startGameAnimation()`
- `highlightSelectedMatrix(row, col)`
- `showWorksheetPanel()`
- `resetMatrixBlocks()`

### `src/js/validation.js`

Berisi validasi jawaban.

Fungsi yang disarankan:

- `collectManualAnswers()`
- `checkAnswers(userAnswers, correctAnswers)`
- `showFeedback(isCorrect)`

## Rumus Yang Harus Dipakai

Untuk matriks sisa 2x2:

```txt
| a  b |
| c  d |
```

Minor:

```txt
Mij = (a × d) - (b × c)
```

Kofaktor:

```txt
Cij = (-1)^(i+j) × Mij
```

Catatan:

- `i` adalah baris yang dipilih.
- `j` adalah kolom yang dipilih.
- Index baris dan kolom memakai 1, 2, 3 agar sesuai dengan pembelajaran matematika.

## Aturan UI/UX

1. Tampilan harus modern, rapi, dan tetap sederhana.
2. Gunakan tema dark glassmorphism seperti kode awal.
3. Tetap gunakan nuansa warna biru, hijau, dan merah muda sebagai aksen.
4. Tambahkan halaman awal atau overlay “Mulai Bermain”.
5. Animasi jangan terlalu berlebihan.
6. User harus langsung paham alurnya.
7. Responsive wajib aman.
8. Jangan membuat tampilan terlalu ramai.

## Output Akhir

Output project harus berisi:

1. Source code lengkap.
2. README cara menjalankan project.
3. Website berhasil dijalankan di local.
4. Website siap deploy ke Vercel.
