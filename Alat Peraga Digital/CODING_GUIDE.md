# CODING_GUIDE.md

## Panduan Kode

Project ini harus ditulis dengan kode yang rapi, mudah dibaca, dan mudah diperbaiki. Gunakan JavaScript Native dan pisahkan logic berdasarkan tanggung jawab file.

## Naming Convention

Gunakan nama function yang jelas:

```js
getMatrixValues()
getRemainingMatrix()
calculateMinor()
calculateCofactor()
checkUserAnswers()
showFeedbackMessage()
```

Gunakan nama variable yang jelas:

```js
selectedRow
selectedCol
remainingMatrix
minorValue
cofactorValue
correctAnswers
userAnswers
```

## Komentar Bahasa Indonesia

Setiap fungsi utama wajib diberi komentar Bahasa Indonesia.

Contoh:

```js
/**
 * Menghitung nilai minor dari matriks sisa 2x2.
 * Rumus yang digunakan adalah (a × d) - (b × c).
 */
export function calculateMinor(remainingMatrix) {
  const [[a, b], [c, d]] = remainingMatrix;
  return (a * d) - (b * c);
}
```

## Contoh Logic Matriks

```js
/**
 * Mengambil semua nilai matriks 3x3 dari input user.
 * Jika input kosong, nilai akan dianggap 0.
 */
export function getMatrixValues() {
  const matrix = [];

  for (let row = 1; row <= 3; row++) {
    const rowValues = [];

    for (let col = 1; col <= 3; col++) {
      const input = document.getElementById(`m${row}${col}`);
      const value = Number(input?.value || 0);
      rowValues.push(value);
    }

    matrix.push(rowValues);
  }

  return matrix;
}

/**
 * Membuat matriks sisa 2x2 dengan menghapus baris dan kolom yang dipilih.
 */
export function getRemainingMatrix(matrix, selectedRow, selectedCol) {
  return matrix
    .filter((_, rowIndex) => rowIndex !== selectedRow - 1)
    .map((row) => row.filter((_, colIndex) => colIndex !== selectedCol - 1));
}

/**
 * Menghitung nilai kofaktor berdasarkan rumus (-1)^(i+j) × minor.
 */
export function calculateCofactor(minorValue, selectedRow, selectedCol) {
  const sign = Math.pow(-1, selectedRow + selectedCol);
  return sign * minorValue;
}
```

## Validasi Jawaban

Validasi minimal:

1. Cek semua nilai matriks sisa.
2. Cek nilai perkalian `a`, `b`, `c`, `d` jika input disediakan.
3. Cek hasil minor.
4. Cek hasil kofaktor.
5. Beri class `correct` jika benar.
6. Beri class `wrong` jika salah.

## Error Handling

Pastikan:

1. Jika input kosong, tidak membuat error.
2. Jika KaTeX gagal render, tampilkan text biasa atau console warning.
3. Jika DOM belum ditemukan, jangan membuat aplikasi crash.
4. Jangan ada undefined variable.
5. Jangan ada syntax error.

## Testing Manual

Test minimal:

1. Jalankan `npm run dev`.
2. Buka website di browser.
3. Klik “Mulai Bermain”.
4. Ubah nilai matriks.
5. Pilih baris dan kolom.
6. Klik tombol tutup baris dan kolom.
7. Isi jawaban matriks sisa.
8. Isi jawaban minor.
9. Isi jawaban kofaktor.
10. Klik cek jawaban.
11. Pastikan feedback benar/salah sesuai.
12. Test di mobile view browser.

## Larangan

1. Jangan menulis semua logic di `index.html`.
2. Jangan memakai variable global terlalu banyak.
3. Jangan hardcode hasil minor/kofaktor.
4. Jangan menghapus fitur utama.
5. Jangan mengubah konsep MAMITOR 3D.
