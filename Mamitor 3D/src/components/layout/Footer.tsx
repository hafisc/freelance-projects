'use client';

import React from 'react';
import { Grid, BookOpen, Compass, Award } from 'lucide-react';

interface FooterProps {
  onGoToStart?: () => void;
}

/**
 * Komponen Footer untuk MAMITOR 3D.
 * Menyediakan referensi link cepat, informasi kurikulum, dan credit pembuat.
 */
export const Footer: React.FC<FooterProps> = ({ onGoToStart }) => {
  return (
    <footer className="w-full bg-[#000000] border-t border-slate-900 py-10 px-4 mt-auto select-none">
      <div className="max-w-6xl mx-auto flex flex-col gap-8">
        
        {/* Konten Utama Grid */}
        <div className="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
          
          {/* Sisi Kiri: Brand & Deskripsi */}
          <div className="md:col-span-6 flex flex-col gap-4">
            <div 
              onClick={onGoToStart}
              className="flex items-center gap-2.5 cursor-pointer hover:opacity-90 transition-opacity w-fit"
            >
              <div className="p-1.5 bg-blue-950/40 border border-blue-900/40 rounded-xl">
                <Grid className="w-5 h-5 text-blue-500" />
              </div>
              <span className="font-display font-bold text-white tracking-wide text-base">MAMITOR 3D</span>
            </div>
            
            <p className="text-slate-400 text-xs md:text-sm leading-relaxed max-w-md">
              MAMITOR 3D adalah media digital alat peraga interaktif berbasis 3D yang dirancang khusus untuk memvisualisasikan penutupan baris dan kolom dalam penentuan Minor dan Kofaktor matriks 3x3 secara konkret.
            </p>
          </div>

          {/* Sisi Tengah: Tautan Cepat */}
          <div className="md:col-span-3 flex flex-col gap-3">
            <h4 className="text-xs font-display font-bold uppercase tracking-wider text-slate-350 flex items-center gap-1.5">
              <Compass className="w-3.5 h-3.5 text-blue-500" /> Referensi Belajar
            </h4>
            <ul className="text-xs text-slate-500 flex flex-col gap-2 font-medium">
              <li>
                <span className="hover:text-slate-300 transition-colors cursor-pointer">Matriks Minor 3x3</span>
              </li>
              <li>
                <span className="hover:text-slate-300 transition-colors cursor-pointer">Kofaktor &amp; Adjoin</span>
              </li>
              <li>
                <span className="hover:text-slate-300 transition-colors cursor-pointer">Ekspansi Kofaktor Laplace</span>
              </li>
              <li>
                <span className="hover:text-slate-300 transition-colors cursor-pointer">Determinan Matriks 3x3</span>
              </li>
            </ul>
          </div>

          {/* Sisi Kanan: Kurikulum & Info */}
          <div className="md:col-span-3 flex flex-col gap-3">
            <h4 className="text-xs font-display font-bold uppercase tracking-wider text-slate-350 flex items-center gap-1.5">
              <Award className="w-3.5 h-3.5 text-blue-500" /> Kurikulum
            </h4>
            <div className="text-xs text-slate-450 leading-relaxed font-medium">
              <p className="text-slate-400 mb-1">Kurikulum Merdeka</p>
              <p className="text-slate-500">Materi Matematika Tingkat Lanjut - Aljabar Linear Elementer &amp; Matriks.</p>
            </div>
          </div>

        </div>

        {/* Garis Pembatas Bawah */}
        <div className="border-t border-slate-900 pt-6 flex flex-col sm:flex-row justify-between items-center gap-4">
          <p className="text-[11px] text-slate-650 font-medium">
            © {new Date().getFullYear()} MAMITOR 3D. Hak Cipta Dilindungi Undang-Undang.
          </p>
        </div>

      </div>
    </footer>
  );
};

export default Footer;
