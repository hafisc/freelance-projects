'use client';

import React, { useState } from 'react';
import { UserAnswers, AnswerStatus } from '@/types/matrix';
import { LatexFormula } from '@/components/ui/LatexFormula';
import { Button } from '@/components/ui/Button';
import { Check, RotateCcw, AlertTriangle, Lightbulb } from 'lucide-react';

interface MatrixFormulaPanelProps {
  selectedRow: number;
  selectedCol: number;
  userAnswers: UserAnswers;
  onAnswerChange: (
    category: 'subMatrix' | 'detElements' | 'minor' | 'cofactor',
    value: string,
    row?: number,
    col?: number,
    field?: 'a' | 'b' | 'c' | 'd'
  ) => void;
  answerStatus: AnswerStatus;
  isSubmitted: boolean;
  onCheck: () => void;
  onReset: () => void;
}

/**
 * Komponen Panel Rumus & Lembar Kerja.
 * Berisi input pengisian matriks sisa, determinan (Minor), dan Kofaktor.
 */
export const MatrixFormulaPanel: React.FC<MatrixFormulaPanelProps> = ({
  selectedRow,
  selectedCol,
  userAnswers,
  onAnswerChange,
  answerStatus,
  isSubmitted,
  onCheck,
  onReset,
}) => {
  // State untuk melacak input mana yang sedang aktif (fokus) untuk tombol +/-
  const [focusedInput, setFocusedInput] = useState<{
    category: 'subMatrix' | 'detElements' | 'minor' | 'cofactor';
    row?: number;
    col?: number;
    field?: 'a' | 'b' | 'c' | 'd';
  } | null>(null);

  // Wrapper untuk memvalidasi pengetikan karakter angka/minus
  const handleTextChange = (
    category: 'subMatrix' | 'detElements' | 'minor' | 'cofactor',
    val: string,
    row?: number,
    col?: number,
    field?: 'a' | 'b' | 'c' | 'd'
  ) => {
    if (val === '' || val === '-' || /^-?\d*\.?\d*$/.test(val)) {
      onAnswerChange(category, val, row, col, field);
    }
  };

  // Helper untuk menentukan warna border input berdasarkan kebenaran jawaban
  const getInputClass = (status: boolean | null) => {
    if (status === null) {
      return 'border-slate-800 hover:border-slate-700 focus:border-blue-500 focus:bg-slate-900/60 bg-slate-950/40 text-white';
    }
    return status
      ? 'border-emerald-500 bg-emerald-950/20 text-emerald-400 focus:border-emerald-500'
      : 'border-rose-500 bg-rose-950/20 text-rose-400 focus:border-rose-500';
  };

  return (
    <div className="flex flex-col gap-6 animate-fade-in">
      
      {/* 1. Matriks Sisa (A_ij) Card */}
      <div className="p-5 rounded-2xl bg-slate-950/25 border-l-4 border-slate-700 border border-slate-900 flex flex-col gap-4">
        <div className="flex items-center justify-between">
          <h3 className="font-display font-bold text-slate-100 flex items-center gap-2">
            Matriks Sisa <LatexFormula math={`(A_{${selectedRow}${selectedCol}})`} />
          </h3>
          <span className="text-[10px] font-display font-bold tracking-wider text-slate-500 uppercase">Langkah 1</span>
        </div>
        <p className="text-xs text-slate-400 -mt-2 leading-relaxed">
          Tuliskan 4 angka yang tersisa setelah baris {selectedRow} dan kolom {selectedCol} ditutup:
        </p>
        
        <div className="flex items-center gap-6 mt-1">
          <div className="text-lg font-bold text-slate-300">
            <LatexFormula math={`A_{${selectedRow}${selectedCol}} =`} />
          </div>
          
          {/* Matriks 2x2 Input */}
          <div className="relative flex items-center">
            {/* Tanda kurung matriks kiri */}
            <div className="w-2.5 h-16 border-t-2 border-b-2 border-l-2 border-slate-400 rounded-l-md mr-3" />
            
            <div className="grid grid-cols-2 gap-2.5">
              <input
                type="text"
                inputMode="text"
                placeholder="?"
                value={userAnswers.subMatrix[0][0]}
                onFocus={() => setFocusedInput({ category: 'subMatrix', row: 0, col: 0 })}
                onBlur={() => setTimeout(() => setFocusedInput(null), 150)}
                onChange={(e) => handleTextChange('subMatrix', e.target.value, 0, 0)}
                className={`w-11 h-9 border rounded-lg text-center font-display font-bold text-base outline-none transition-all duration-300 ${getInputClass(
                  answerStatus.subMatrix[0][0]
                )}`}
              />
              <input
                type="text"
                inputMode="text"
                placeholder="?"
                value={userAnswers.subMatrix[0][1]}
                onFocus={() => setFocusedInput({ category: 'subMatrix', row: 0, col: 1 })}
                onBlur={() => setTimeout(() => setFocusedInput(null), 150)}
                onChange={(e) => handleTextChange('subMatrix', e.target.value, 0, 1)}
                className={`w-11 h-9 border rounded-lg text-center font-display font-bold text-base outline-none transition-all duration-300 ${getInputClass(
                  answerStatus.subMatrix[0][1]
                )}`}
              />
              <input
                type="text"
                inputMode="text"
                placeholder="?"
                value={userAnswers.subMatrix[1][0]}
                onFocus={() => setFocusedInput({ category: 'subMatrix', row: 1, col: 0 })}
                onBlur={() => setTimeout(() => setFocusedInput(null), 150)}
                onChange={(e) => handleTextChange('subMatrix', e.target.value, 1, 0)}
                className={`w-11 h-9 border rounded-lg text-center font-display font-bold text-base outline-none transition-all duration-300 ${getInputClass(
                  answerStatus.subMatrix[1][0]
                )}`}
              />
              <input
                type="text"
                inputMode="text"
                placeholder="?"
                value={userAnswers.subMatrix[1][1]}
                onFocus={() => setFocusedInput({ category: 'subMatrix', row: 1, col: 1 })}
                onBlur={() => setTimeout(() => setFocusedInput(null), 150)}
                onChange={(e) => handleTextChange('subMatrix', e.target.value, 1, 1)}
                className={`w-11 h-9 border rounded-lg text-center font-display font-bold text-base outline-none transition-all duration-300 ${getInputClass(
                  answerStatus.subMatrix[1][1]
                )}`}
              />
            </div>
            
            {/* Tanda kurung matriks kanan */}
            <div className="w-2.5 h-16 border-t-2 border-b-2 border-r-2 border-slate-400 rounded-r-md ml-3" />
          </div>
        </div>
      </div>

      {/* 2. Perhitungan Minor (M_ij) Card */}
      <div className="p-5 rounded-2xl bg-slate-950/25 border-l-4 border-blue-600 border border-slate-900 flex flex-col gap-4">
        <div className="flex items-center justify-between">
          <h3 className="font-display font-bold text-blue-400 flex items-center gap-2">
            Minor <LatexFormula math={`(M_{${selectedRow}${selectedCol}})`} />
          </h3>
          <span className="text-[10px] font-display font-bold tracking-wider text-blue-500 uppercase">Langkah 2</span>
        </div>
        <p className="text-xs text-slate-400 -mt-2 leading-relaxed">
          Hitung determinan matriks sisa di atas menggunakan rumus perkalian silang <code className="text-blue-400 bg-slate-900/50 px-1.5 py-0.5 rounded font-mono">(a &times; d) &minus; (b &times; c)</code>:
        </p>

        <div className="flex flex-col gap-4 mt-1">
          <div className="text-sm font-semibold text-slate-300">
            <LatexFormula math={`M_{${selectedRow}${selectedCol}} = \\det(A_{${selectedRow}${selectedCol}})`} />
          </div>

          {/* ad - bc element inputs */}
          <div className="flex items-center gap-2 text-slate-300 flex-wrap">
            <LatexFormula math={`M_{${selectedRow}${selectedCol}} =`} />
            
            <div className="flex items-center gap-1 bg-slate-950/40 px-2.5 py-1.5 rounded-xl border border-white/5">
              <span className="text-slate-500">(</span>
              <input
                type="text"
                inputMode="text"
                placeholder="a"
                value={userAnswers.detElements.a}
                onFocus={() => setFocusedInput({ category: 'detElements', field: 'a' })}
                onBlur={() => setTimeout(() => setFocusedInput(null), 150)}
                onChange={(e) => handleTextChange('detElements', e.target.value, undefined, undefined, 'a')}
                className={`w-10 h-7.5 border rounded-md text-center font-display font-bold text-sm outline-none transition-all duration-300 ${getInputClass(
                  answerStatus.detElements.a
                )}`}
              />
              <span className="text-slate-500 font-extrabold text-xs mx-0.5">&times;</span>
              <input
                type="text"
                inputMode="text"
                placeholder="d"
                value={userAnswers.detElements.d}
                onFocus={() => setFocusedInput({ category: 'detElements', field: 'd' })}
                onBlur={() => setTimeout(() => setFocusedInput(null), 150)}
                onChange={(e) => handleTextChange('detElements', e.target.value, undefined, undefined, 'd')}
                className={`w-10 h-7.5 border rounded-md text-center font-display font-bold text-sm outline-none transition-all duration-300 ${getInputClass(
                  answerStatus.detElements.d
                )}`}
              />
              <span className="text-slate-500">)</span>
              
              <span className="text-blue-500 font-extrabold mx-1.5">&minus;</span>
              
              <span className="text-slate-500">(</span>
              <input
                type="text"
                inputMode="text"
                placeholder="b"
                value={userAnswers.detElements.b}
                onFocus={() => setFocusedInput({ category: 'detElements', field: 'b' })}
                onBlur={() => setTimeout(() => setFocusedInput(null), 150)}
                onChange={(e) => handleTextChange('detElements', e.target.value, undefined, undefined, 'b')}
                className={`w-10 h-7.5 border rounded-md text-center font-display font-bold text-sm outline-none transition-all duration-300 ${getInputClass(
                  answerStatus.detElements.b
                )}`}
              />
              <span className="text-slate-500 font-extrabold text-xs mx-0.5">&times;</span>
              <input
                type="text"
                inputMode="text"
                placeholder="c"
                value={userAnswers.detElements.c}
                onFocus={() => setFocusedInput({ category: 'detElements', field: 'c' })}
                onBlur={() => setTimeout(() => setFocusedInput(null), 150)}
                onChange={(e) => handleTextChange('detElements', e.target.value, undefined, undefined, 'c')}
                className={`w-10 h-7.5 border rounded-md text-center font-display font-bold text-sm outline-none transition-all duration-300 ${getInputClass(
                  answerStatus.detElements.c
                )}`}
              />
              <span className="text-slate-500">)</span>
            </div>
          </div>

          {/* Minor Final Value */}
          <div className="flex items-center gap-3 mt-1">
            <LatexFormula math={`M_{${selectedRow}${selectedCol}} =`} />
            <input
              type="text"
              inputMode="text"
              placeholder="Hasil Minor"
              value={userAnswers.minor}
              onFocus={() => setFocusedInput({ category: 'minor' })}
              onBlur={() => setTimeout(() => setFocusedInput(null), 150)}
              onChange={(e) => handleTextChange('minor', e.target.value)}
              className={`w-32 h-10 border rounded-xl text-center font-display font-extrabold text-base outline-none transition-all duration-300 ${getInputClass(
                answerStatus.minor
              )}`}
            />
          </div>
        </div>
      </div>

      {/* 3. Perhitungan Kofaktor (C_ij) Card */}
      <div className="p-5 rounded-2xl bg-slate-950/25 border-l-4 border-blue-600 border border-slate-900 flex flex-col gap-4">
        <div className="flex items-center justify-between">
          <h3 className="font-display font-bold text-blue-400 flex items-center gap-2">
            Kofaktor <LatexFormula math={`(C_{${selectedRow}${selectedCol}})`} />
          </h3>
          <span className="text-[10px] font-display font-bold tracking-wider text-blue-500 uppercase">Langkah 3</span>
        </div>
        <p className="text-xs text-slate-400 -mt-2 leading-relaxed">
          Tentukan tanda positif/negatif kofaktor berdasarkan letak baris &amp; kolom menggunakan rumus:
        </p>

        <div className="flex flex-col gap-3 mt-1">
          <div className="text-sm font-semibold text-slate-300">
            <LatexFormula math={`C_{${selectedRow}${selectedCol}} = (-1)^{i+j} \\cdot M_{${selectedRow}${selectedCol}}`} />
          </div>

          <div className="text-xs text-slate-405 flex items-center gap-1.5 bg-slate-950/30 px-3 py-2 rounded-xl w-fit">
            <Lightbulb className="w-4 h-4 text-blue-400 shrink-0" />
            <span>
              Tanda kofaktor: (-1) dipangkatkan <strong className="text-white">({selectedRow} + {selectedCol} = {selectedRow + selectedCol})</strong> adalah{' '}
              <strong className="text-white">{(selectedRow + selectedCol) % 2 === 0 ? '+' : '-'}</strong>.
            </span>
          </div>

          {/* Kofaktor Final Value */}
          <div className="flex items-center gap-3 mt-2">
            <LatexFormula math={`C_{${selectedRow}${selectedCol}} =`} />
            <input
              type="text"
              inputMode="text"
              placeholder="Hasil Kofaktor"
              value={userAnswers.cofactor}
              onFocus={() => setFocusedInput({ category: 'cofactor' })}
              onBlur={() => setTimeout(() => setFocusedInput(null), 150)}
              onChange={(e) => handleTextChange('cofactor', e.target.value)}
              className={`w-32 h-10 border rounded-xl text-center font-display font-extrabold text-base outline-none transition-all duration-300 ${getInputClass(
                answerStatus.cofactor
              )}`}
            />
          </div>
        </div>
      </div>

      {focusedInput && !isSubmitted && (
        <div className="flex justify-center -mt-2 animate-fade-in">
          <button
            type="button"
            onMouseDown={(e) => e.preventDefault()} // Mencegah input kehilangan fokus saat diklik
            onClick={() => {
              const { category, row, col, field } = focusedInput;
              let currentVal = '';
              if (category === 'subMatrix' && row !== undefined && col !== undefined) {
                currentVal = userAnswers.subMatrix[row][col];
              } else if (category === 'detElements' && field) {
                currentVal = userAnswers.detElements[field];
              } else if (category === 'minor') {
                currentVal = userAnswers.minor;
              } else if (category === 'cofactor') {
                currentVal = userAnswers.cofactor;
              }

              let newVal = '';
              if (currentVal.startsWith('-')) {
                newVal = currentVal.substring(1);
              } else if (currentVal !== '') {
                newVal = '-' + currentVal;
              } else {
                newVal = '-';
              }

              handleTextChange(category, newVal, row, col, field);
            }}
            className="flex items-center gap-1.5 px-4 py-2 bg-blue-600/10 hover:bg-blue-600/20 border border-blue-500/20 hover:border-blue-500/40 text-blue-400 font-display font-bold text-xs rounded-lg transition-all duration-200 cursor-pointer shadow-sm select-none active:scale-95"
          >
            <span>± Ubah Tanda Sel Aktif</span>
          </button>
        </div>
      )}

      {/* Button Actions */}
      <div className="flex gap-4 mt-2">
        <Button
          variant="success"
          className="flex-1 py-4 flex items-center justify-center gap-2 text-base font-bold shadow-md"
          onClick={onCheck}
        >
          <Check className="w-5 h-5" /> Cek Jawaban
        </Button>
        
        <Button
          variant="outline"
          className="py-4 px-5 rounded-2xl hover:border-rose-500/40 hover:text-rose-400"
          onClick={onReset}
          title="Reset Jawaban"
        >
          <RotateCcw className="w-5 h-5" />
        </Button>
      </div>

    </div>
  );
};
export default MatrixFormulaPanel;
