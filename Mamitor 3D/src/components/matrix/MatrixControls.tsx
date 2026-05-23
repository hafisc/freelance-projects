'use client';

import React from 'react';
import { Button } from '@/components/ui/Button';

interface MatrixControlsProps {
  selectedRow: number;
  setSelectedRow: (row: number) => void;
  selectedCol: number;
  setSelectedCol: (col: number) => void;
  onProcess: () => void;
  isClosed: boolean;
}

/**
 * Komponen Kontrol Matriks.
 * Menyediakan dropdown untuk memilih Baris dan Kolom serta tombol aksi penutupan.
 */
export const MatrixControls: React.FC<MatrixControlsProps> = ({
  selectedRow,
  setSelectedRow,
  selectedCol,
  setSelectedCol,
  onProcess,
  isClosed,
}) => {
  return (
    <div className="flex flex-col gap-4">
      {/* Dropdown Pemilihan */}
      <div className="flex gap-4">
        {/* Pilih Baris */}
        <div className="flex-1 flex flex-col gap-1.5">
          <label htmlFor="row-select" className="text-sm font-semibold text-slate-300">
            Pilih Baris:
          </label>
          <select
            id="row-select"
            value={selectedRow}
            onChange={(e) => setSelectedRow(Number(e.target.value))}
            className="w-full bg-slate-900/80 border border-slate-700 focus:border-blue-500 rounded-xl px-4 py-3 font-medium text-white outline-none cursor-pointer transition-all duration-300"
          >
            <option value={1}>Baris 1</option>
            <option value={2}>Baris 2</option>
            <option value={3}>Baris 3</option>
          </select>
        </div>

        {/* Pilih Kolom */}
        <div className="flex-1 flex flex-col gap-1.5">
          <label htmlFor="col-select" className="text-sm font-semibold text-slate-300">
            Pilih Kolom:
          </label>
          <select
            id="col-select"
            value={selectedCol}
            onChange={(e) => setSelectedCol(Number(e.target.value))}
            className="w-full bg-slate-900/80 border border-slate-700 focus:border-blue-500 rounded-xl px-4 py-3 font-medium text-white outline-none cursor-pointer transition-all duration-300"
          >
            <option value={1}>Kolom 1</option>
            <option value={2}>Kolom 2</option>
            <option value={3}>Kolom 3</option>
          </select>
        </div>
      </div>

      {/* Tombol Tutup */}
      <Button
        variant={isClosed ? 'glass' : 'primary'}
        fullWidth
        onClick={onProcess}
        className="py-4 shadow-lg"
      >
        {isClosed ? 'Perbarui Baris & Kolom' : 'Tutup Baris & Kolom'}
      </Button>
    </div>
  );
};
export default MatrixControls;
