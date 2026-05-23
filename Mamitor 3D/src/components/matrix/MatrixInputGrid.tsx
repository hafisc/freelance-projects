'use client';

import React from 'react';
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
  // Fungsi penanganan perubahan nilai input sel matriks
  const handleChange = (rIdx: number, cIdx: number, textVal: string) => {
    // Jika kosong, default ke 0
    const numVal = textVal === '' ? 0 : Number(textVal);
    onCellChange(rIdx, cIdx, numVal);
  };

  return (
    <div className="flex flex-col gap-3">
      <label className="text-xs font-display font-bold tracking-wider text-slate-400 uppercase">
        Matriks Input 3x3
      </label>
      
      <div className={`grid grid-cols-3 gap-3 p-4 bg-slate-950/40 rounded-2xl border border-white/5 max-w-[280px] md:max-w-[300px] transition-all duration-300 ${disabled ? 'opacity-40 select-none' : ''}`}>
        {matrix.map((row, rIdx) =>
          row.map((val, cIdx) => (
            <input
              key={`${rIdx}-${cIdx}`}
              type="number"
              value={val === 0 && matrix[rIdx][cIdx] === 0 ? '' : val}
              placeholder="0"
              disabled={disabled}
              onChange={(e) => handleChange(rIdx, cIdx, e.target.value)}
              className="w-full aspect-square bg-slate-900/40 border border-slate-800 hover:border-slate-700 focus:border-blue-500 focus:bg-slate-900/80 rounded-xl text-center font-display text-xl font-bold text-white outline-none transition-all duration-300 shadow-[inset_0_1px_0_rgba(255,255,255,0.02)] focus:ring-1 focus:ring-blue-500 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none disabled:cursor-not-allowed"
            />
          ))
        )}
      </div>
      <span className="text-[11px] text-slate-500 italic max-w-[280px] leading-relaxed">
        *Edit sel di atas untuk mengubah nilai awal matriks utama. Sel akan dikunci saat proses pengerjaan.
      </span>
    </div>
  );
};
export default MatrixInputGrid;
