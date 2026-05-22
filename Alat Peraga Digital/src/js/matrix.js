/**
 * Mengambil semua nilai matriks 3x3 dari input user di halaman.
 * Jika input kosong atau tidak valid, nilai akan otomatis dianggap 0.
 * @returns {number[][]} Matriks 3x3 berisi angka-angka.
 */
export function getMatrixValues() {
  const matrix = [];
  for (let i = 1; i <= 3; i++) {
    const rowValues = [];
    for (let j = 1; j <= 3; j++) {
      const input = document.getElementById(`m${i}${j}`);
      const val = input ? parseInt(input.value) : 0;
      rowValues.push(isNaN(val) ? 0 : val);
    }
    matrix.push(rowValues);
  }
  return matrix;
}

/**
 * Membuat matriks sisa 2x2 dengan menghapus baris dan kolom terpilih (1-based index).
 * @param {number[][]} matrix - Matriks awal 3x3.
 * @param {number} selectedRow - Nomor baris terpilih (1, 2, atau 3).
 * @param {number} selectedCol - Nomor kolom terpilih (1, 2, atau 3).
 * @returns {number[][]} Matriks sisa 2x2.
 */
export function getRemainingMatrix(matrix, selectedRow, selectedCol) {
  // Filter baris yang tidak sama dengan selectedRow (dikurangi 1 untuk 0-based index)
  // Kemudian filter kolom yang tidak sama dengan selectedCol (dikurangi 1)
  return matrix
    .filter((_, rowIndex) => rowIndex !== selectedRow - 1)
    .map(row => row.filter((_, colIndex) => colIndex !== selectedCol - 1));
}

/**
 * Menghitung nilai minor dari matriks sisa 2x2.
 * Rumus determinan 2x2: (a * d) - (b * c).
 * @param {number[][]} remainingMatrix - Matriks sisa 2x2.
 * @returns {number} Hasil perhitungan minor.
 */
export function calculateMinor(remainingMatrix) {
  const a = remainingMatrix[0][0];
  const b = remainingMatrix[0][1];
  const c = remainingMatrix[1][0];
  const d = remainingMatrix[1][1];
  return (a * d) - (b * c);
}

/**
 * Menghitung nilai kofaktor berdasarkan nilai minor, baris, dan kolom terpilih.
 * Rumus kofaktor: (-1)^(i + j) * Minor.
 * @param {number} minorValue - Nilai minor.
 * @param {number} selectedRow - Baris (1-based).
 * @param {number} selectedCol - Kolom (1-based).
 * @returns {number} Hasil perhitungan kofaktor.
 */
export function calculateCofactor(minorValue, selectedRow, selectedCol) {
  const power = selectedRow + selectedCol;
  const sign = Math.pow(-1, power);
  return sign * minorValue;
}
