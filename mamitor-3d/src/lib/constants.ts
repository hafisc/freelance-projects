import { Matrix3x3, UserAnswers } from '@/types/matrix';

// Nilai default untuk matriks 3x3 diisi sesuai referensi awal dari client
export const DEFAULT_MATRIX: Matrix3x3 = [
  [2, 3, 1],
  [0, 1, 4],
  [5, 6, 0]
];

// Template kosong untuk jawaban pengguna agar mudah di-reset
export const EMPTY_USER_ANSWERS: UserAnswers = {
  subMatrix: [
    ['', ''],
    ['', '']
  ],
  detElements: {
    a: '',
    d: '',
    b: '',
    c: ''
  },
  minor: '',
  cofactor: ''
};
