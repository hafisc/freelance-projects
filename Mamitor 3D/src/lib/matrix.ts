import { Matrix3x3, Matrix2x2 } from '@/types/matrix';

/**
 * Membuat matriks sisa 2x2 dengan mengeliminasi baris dan kolom terpilih.
 * @param matrix Matriks 3x3 input
 * @param row Baris yang ditutup (1-indexed, yaitu 1, 2, atau 3)
 * @param col Kolom yang ditutup (1-indexed, yaitu 1, 2, atau 3)
 * @returns Matriks sisa 2x2
 */
export function createSubMatrix(matrix: Matrix3x3, row: number, col: number): Matrix2x2 {
  const result: number[][] = [];
  const targetRowIdx = row - 1;
  const targetColIdx = col - 1;

  for (let r = 0; r < 3; r++) {
    // Lewati baris yang ditutup
    if (r === targetRowIdx) continue;
    
    const newRow: number[] = [];
    for (let c = 0; c < 3; c++) {
      // Lewati kolom yang ditutup
      if (c === targetColIdx) continue;
      newRow.push(matrix[r][c]);
    }
    result.push(newRow);
  }

  return result as Matrix2x2;
}

/**
 * Menghitung nilai minor dari matriks sisa 2x2.
 * Menggunakan rumus determinan matriks 2x2: det(A) = (a * d) - (b * c)
 * @param subMatrix Matriks sisa 2x2
 * @returns Nilai Minor (determinan)
 */
export function calculateMinor(subMatrix: Matrix2x2): number {
  const a = subMatrix[0][0];
  const b = subMatrix[0][1];
  const c = subMatrix[1][0];
  const d = subMatrix[1][1];
  
  // Rumus Minor = ad - bc
  return (a * d) - (b * c);
}

/**
 * Menghitung nilai kofaktor berdasarkan minor dan letak baris/kolom terpilih.
 * Rumus Kofaktor: C_ij = (-1)^(i + j) * M_ij
 * @param minor Nilai minor matriks
 * @param row Baris (1-indexed)
 * @param col Kolom (1-indexed)
 * @returns Nilai Kofaktor
 */
export function calculateCofactor(minor: number, row: number, col: number): number {
  const power = row + col;
  // Rumus Kofaktor = (-1)^(i+j) * Minor
  return Math.pow(-1, power) * minor;
}

/**
 * Memvalidasi apakah jawaban input angka dari pengguna sesuai dengan kunci jawaban.
 * @param userInput Nilai input berupa string dari user
 * @param correctValue Nilai kunci jawaban berupa number
 * @returns boolean | null (true jika benar, false jika salah, null jika kosong)
 */
export function validateNumberAnswer(userInput: string, correctValue: number): boolean | null {
  if (userInput.trim() === '') return null;
  const parsedVal = Number(userInput);
  return !isNaN(parsedVal) && parsedVal === correctValue;
}
