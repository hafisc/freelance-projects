'use client';

import React, { useState, useEffect } from 'react';
import { Matrix3x3 } from '@/types/matrix';

interface MatrixInputGridProps {
  matrix: Matrix3x3;
  onCellChange: (rowIdx: number, colIdx: number, val: number) => void;
  disabled?: boolean;
}

/**
 * Komponen Input Grid 3x3.
 * Memungkinkan pengguna untuk memasukkan nilai angka pada matriks utama.
 */
export const MatrixInputGrid: React.FC<MatrixInputGridProps> = ({
  matrix,
  onCellChange,
  disabled = false,
}) => {
  // State lokal untuk menyimpan string input mentah agar user bisa mengetik tanda minus "-" tanpa tereset
  const [localMatrix, setLocalMatrix] = useState<string[][]>(() =>
    matrix.map(row => row.map(val => val === 0 ? '' : val.toString()))
  );

  // Menyimpan posisi sel yang sedang mendapatkan fokus untuk menampilkan tombol +/-
  const [focusedCell, setFocusedCell] = useState<{ r: number; c: number } | null>(null);

  // Sinkronisasi state lokal jika ada perubahan eksternal pada matrix (misalnya saat game di-reset)
  useEffect(() => {
    setLocalMatrix(
      matrix.map(row => row.map(val => val === 0 ? '' : val.toString()))
    );
  }, [matrix]);

  // Fungsi penanganan perubahan nilai input sel matriks
  const handleChange = (rIdx: number, cIdx: number, textVal: string) => {
    // Validasi input: hanya izinkan string kosong, tanda minus, angka bulat, atau desimal
    if (textVal === '' || textVal === '-' || /^-?\d*\.?\d*$/.test(textVal)) {
      // 1. Update state lokal string
      const newLocal = localMatrix.map((row, ri) =>
        row.map((cell, ci) => (ri === rIdx && ci === cIdx ? textVal : cell))
      );
      setLocalMatrix(newLocal);

      // 2. Kirim nilai numerik ke parent
      let numVal = 0;
      if (textVal !== '' && textVal !== '-') {
        numVal = Number(textVal);
      }
      // Pastikan kita tidak mengirim NaN ke parent
      if (!isNaN(numVal)) {
        onCellChange(rIdx, cIdx, numVal);
      }
    }
  };

  return (
    <div className="flex flex-col gap-3">
      <label className="text-xs font-display font-bold tracking-wider text-slate-400 uppercase">
        Matriks Input 3x3
      </label>
      
      <div className={`grid grid-cols-3 gap-3 p-4 bg-slate-950/40 rounded-2xl border border-white/5 max-w-[280px] md:max-w-[300px] transition-all duration-300 ${disabled ? 'opacity-40 select-none' : ''}`}>
        {localMatrix.map((row, rIdx) =>
          row.map((val, cIdx) => (
            <input
              key={`${rIdx}-${cIdx}`}
              type="text"
              inputMode="text"
              value={val}
              placeholder="0"
              disabled={disabled}
              onFocus={() => setFocusedCell({ r: rIdx, c: cIdx })}
              onBlur={() => {
                // Beri sedikit jeda agar jika menekan tombol +/- event klik tetap terpicu sebelum focus hilang
                setTimeout(() => setFocusedCell(null), 150);
              }}
              onChange={(e) => handleChange(rIdx, cIdx, e.target.value)}
              className="w-full aspect-square bg-slate-900/40 border border-slate-800 hover:border-slate-700 focus:border-blue-500 focus:bg-slate-900/80 rounded-xl text-center font-display text-xl font-bold text-white outline-none transition-all duration-300 shadow-[inset_0_1px_0_rgba(255,255,255,0.02)] focus:ring-1 focus:ring-blue-500 disabled:cursor-not-allowed"
            />
          ))
        )}
      </div>

      {focusedCell && !disabled && (
        <div className="flex justify-center -mt-1 animate-fade-in">
          <button
            type="button"
            onMouseDown={(e) => e.preventDefault()} // Mencegah input kehilangan fokus saat diklik
            onClick={() => {
              const { r, c } = focusedCell;
              const currentVal = localMatrix[r][c];
              let newVal = '';
              if (currentVal.startsWith('-')) {
                newVal = currentVal.substring(1);
              } else if (currentVal !== '') {
                newVal = '-' + currentVal;
              } else {
                newVal = '-';
              }
              handleChange(r, c, newVal);
            }}
            className="flex items-center gap-1.5 px-3 py-1.5 bg-blue-600/10 hover:bg-blue-600/20 border border-blue-500/20 hover:border-blue-500/40 text-blue-400 font-display font-bold text-xs rounded-lg transition-all duration-200 cursor-pointer shadow-sm select-none active:scale-95"
          >
            <span>± Ubah Tanda Sel</span>
          </button>
        </div>
      )}

      <span className="text-[11px] text-slate-500 italic max-w-[280px] leading-relaxed">
        *Edit sel di atas untuk mengubah nilai awal matriks utama. Sel akan dikunci saat proses pengerjaan.
      </span>
    </div>
  );
};
export default MatrixInputGrid;
