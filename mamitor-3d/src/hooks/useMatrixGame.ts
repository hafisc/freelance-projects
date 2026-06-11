'use client';

import { useState, useCallback, useMemo } from 'react';
import { Matrix3x3, Matrix2x2, UserAnswers, AnswerStatus, GamePhase } from '@/types/matrix';
import { DEFAULT_MATRIX, EMPTY_USER_ANSWERS } from '@/lib/constants';
import { createSubMatrix, calculateMinor, calculateCofactor, validateNumberAnswer } from '@/lib/matrix';

/**
 * Custom Hook untuk mengelola state utama permainan MAMITOR 3D.
 * Mengatur fase game, nilai matriks 3x3, baris/kolom terpilih, jawaban pengguna, dan validasi.
 */
export function useMatrixGame() {
  // State untuk fase permainan (START = Landing Page, PLAYING = Workspace)
  const [gamePhase, setGamePhase] = useState<GamePhase>('START');
  
  // State untuk nilai matriks 3x3
  const [matrix, setMatrix] = useState<Matrix3x3>(DEFAULT_MATRIX);
  
  // State untuk baris dan kolom yang dipilih (1-indexed)
  const [selectedRow, setSelectedRow] = useState<number>(1);
  const [selectedCol, setSelectedCol] = useState<number>(2); // Kolom 2 terpilih secara default
  
  // State apakah animasi penutupan baris/kolom sedang/sudah berjalan
  const [isClosed, setIsClosed] = useState<boolean>(false);
  
  // State untuk jawaban yang diinputkan pengguna di lembar kerja
  const [userAnswers, setUserAnswers] = useState<UserAnswers>(EMPTY_USER_ANSWERS);
  
  // State untuk status pemeriksaan jawaban (benar/salah/belum diisi)
  const [answerStatus, setAnswerStatus] = useState<AnswerStatus>({
    subMatrix: [
      [null, null],
      [null, null]
    ],
    detElements: { a: null, d: null, b: null, c: null },
    minor: null,
    cofactor: null
  });

  // State untuk status submit jawaban
  const [isSubmitted, setIsSubmitted] = useState<boolean>(false);

  // Status jika semua jawaban benar
  const allCorrect = useMemo(() => {
    if (!isSubmitted) return false;
    const subMatrixOk = answerStatus.subMatrix.every(row => row.every(val => val === true));
    const detOk = Object.values(answerStatus.detElements).every(val => val === true);
    return subMatrixOk && detOk && answerStatus.minor === true && answerStatus.cofactor === true;
  }, [answerStatus, isSubmitted]);

  // Pindah dari Landing Page ke Workspace
  const startGame = useCallback(() => {
    setGamePhase('PLAYING');
  }, []);

  // Kembali ke Landing Page
  const goToStart = useCallback(() => {
    setGamePhase('START');
    setIsClosed(false);
    setUserAnswers(EMPTY_USER_ANSWERS);
    setIsSubmitted(false);
    setAnswerStatus({
      subMatrix: [[null, null], [null, null]],
      detElements: { a: null, d: null, b: null, c: null },
      minor: null,
      cofactor: null
    });
  }, []);

  // Mengubah nilai salah satu sel pada matriks 3x3
  const setMatrixValue = useCallback((rowIdx: number, colIdx: number, value: number) => {
    setMatrix(prev => {
      const newMatrix = prev.map(r => [...r]) as Matrix3x3;
      newMatrix[rowIdx][colIdx] = value;
      return newMatrix;
    });
    // Jika matriks diubah, reset status worksheet
    setIsClosed(false);
    setIsSubmitted(false);
    setUserAnswers(EMPTY_USER_ANSWERS);
  }, []);

  // Menjalankan proses penutupan baris & kolom
  const startClosing = useCallback(() => {
    setIsClosed(true);
    setIsSubmitted(false);
    setUserAnswers(EMPTY_USER_ANSWERS);
    setAnswerStatus({
      subMatrix: [[null, null], [null, null]],
      detElements: { a: null, d: null, b: null, c: null },
      minor: null,
      cofactor: null
    });
  }, []);

  // Memperbarui jawaban input teks pengguna
  const updateUserAnswer = useCallback((
    category: 'subMatrix' | 'detElements' | 'minor' | 'cofactor',
    value: string,
    row?: number,
    col?: number,
    field?: 'a' | 'b' | 'c' | 'd'
  ) => {
    setUserAnswers(prev => {
      const newAnswers = { ...prev };
      
      if (category === 'subMatrix' && row !== undefined && col !== undefined) {
        const newSub = prev.subMatrix.map(r => [...r]) as [[string, string], [string, string]];
        newSub[row][col] = value;
        newAnswers.subMatrix = newSub;
      } else if (category === 'detElements' && field) {
        newAnswers.detElements = {
          ...prev.detElements,
          [field]: value
        };
      } else if (category === 'minor') {
        newAnswers.minor = value;
      } else if (category === 'cofactor') {
        newAnswers.cofactor = value;
      }

      return newAnswers;
    });
  }, []);

  // Menghitung jawaban yang benar berdasarkan state matriks saat ini
  const correctValues = useMemo(() => {
    if (!selectedRow || !selectedCol) return null;
    const sub = createSubMatrix(matrix, selectedRow, selectedCol);
    const minor = calculateMinor(sub);
    const cofactor = calculateCofactor(minor, selectedRow, selectedCol);
    return {
      subMatrix: sub,
      minor,
      cofactor
    };
  }, [matrix, selectedRow, selectedCol]);

  // Melakukan validasi jawaban pengguna terhadap kunci jawaban
  const checkAnswers = useCallback(() => {
    if (!correctValues) return;
    
    const { subMatrix: correctSub, minor: correctMinor, cofactor: correctCofactor } = correctValues;
    const [a, b, c, d] = [correctSub[0][0], correctSub[0][1], correctSub[1][0], correctSub[1][1]];

    // 1. Cek matriks sisa 2x2
    const statusSub: [[boolean | null, boolean | null], [boolean | null, boolean | null]] = [
      [
        validateNumberAnswer(userAnswers.subMatrix[0][0], correctSub[0][0]),
        validateNumberAnswer(userAnswers.subMatrix[0][1], correctSub[0][1])
      ],
      [
        validateNumberAnswer(userAnswers.subMatrix[1][0], correctSub[1][0]),
        validateNumberAnswer(userAnswers.subMatrix[1][1], correctSub[1][1])
      ]
    ];

    // 2. Cek elemen perkalian silang determinan (a * d - b * c)
    const statusDet = {
      a: validateNumberAnswer(userAnswers.detElements.a, a),
      d: validateNumberAnswer(userAnswers.detElements.d, d),
      b: validateNumberAnswer(userAnswers.detElements.b, b),
      c: validateNumberAnswer(userAnswers.detElements.c, c)
    };

    // 3. Cek hasil minor & kofaktor
    const statusMinor = validateNumberAnswer(userAnswers.minor, correctMinor);
    const statusCofactor = validateNumberAnswer(userAnswers.cofactor, correctCofactor);

    setAnswerStatus({
      subMatrix: statusSub,
      detElements: statusDet,
      minor: statusMinor,
      cofactor: statusCofactor
    });
    
    setIsSubmitted(true);
  }, [userAnswers, correctValues]);

  // Meriset lembar kerja dan pilihan baris/kolom
  const resetGame = useCallback(() => {
    setIsClosed(false);
    setIsSubmitted(false);
    setUserAnswers(EMPTY_USER_ANSWERS);
    setAnswerStatus({
      subMatrix: [[null, null], [null, null]],
      detElements: { a: null, d: null, b: null, c: null },
      minor: null,
      cofactor: null
    });
  }, []);

  return {
    gamePhase,
    startGame,
    goToStart,
    matrix,
    setMatrixValue,
    selectedRow,
    setSelectedRow,
    selectedCol,
    setSelectedCol,
    isClosed,
    startClosing,
    userAnswers,
    updateUserAnswer,
    answerStatus,
    checkAnswers,
    resetGame,
    isSubmitted,
    allCorrect,
    correctValues
  };
}
