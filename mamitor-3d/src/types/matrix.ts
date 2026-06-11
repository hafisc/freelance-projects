// Type untuk Matriks 3x3
export type Matrix3x3 = [
  [number, number, number],
  [number, number, number],
  [number, number, number]
];

// Type untuk Matriks 2x2 (Matriks Sisa)
export type Matrix2x2 = [
  [number, number],
  [number, number]
];

// Status pengecekan jawaban untuk masing-masing field input
export interface AnswerStatus {
  subMatrix: [
    [boolean | null, boolean | null],
    [boolean | null, boolean | null]
  ];
  detElements: {
    a: boolean | null;
    d: boolean | null;
    b: boolean | null;
    c: boolean | null;
  };
  minor: boolean | null;
  cofactor: boolean | null;
}

// Status permainan MAMITOR
export type GamePhase = 'START' | 'PLAYING';

// Jawaban yang dimasukkan oleh pengguna
export interface UserAnswers {
  subMatrix: [
    [string, string],
    [string, string]
  ];
  detElements: {
    a: string;
    d: string;
    b: string;
    c: string;
  };
  minor: string;
  cofactor: string;
}
