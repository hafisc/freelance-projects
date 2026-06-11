'use client';

import React from 'react';
import { motion } from 'framer-motion';
import { Button } from '@/components/ui/Button';
import { Card } from '@/components/ui/Card';
import { Play, Grid, HelpCircle, Award, Compass, Sparkles, BookOpen } from 'lucide-react';
import { LatexFormula } from '@/components/ui/LatexFormula';
import { GroupProfile } from './GroupProfile';

interface StartScreenProps {
  onStart: () => void;
}

/**
 * Komponen Landing Page (Start Screen) aplikasi MAMITOR 3D.
 * Menyediakan animasi penyambut, petunjuk belajar singkat, dan tombol mulai.
 */
export const StartScreen: React.FC<StartScreenProps> = ({ onStart }) => {
  return (
    <div className="flex-1 w-full flex flex-col justify-center items-center px-4 py-6 md:py-12 max-w-6xl mx-auto relative select-none">
      
      {/* Decorative Dots Pattern Background Overlay */}
      <div className="absolute inset-0 dots-pattern pointer-events-none -z-10" />

      {/* Large Glowing Ambient Orbs */}
      <div className="glow-sphere w-[350px] h-[350px] md:w-[450px] md:h-[450px] bg-blue-600/10 top-20 left-1/2 -translate-x-1/2" />
      <div className="glow-sphere w-[250px] h-[250px] md:w-[350px] md:h-[350px] bg-indigo-650/5 top-40 left-1/4" />

      {/* Floating Decorative Math Elements */}
      <div className="absolute top-32 left-8 text-slate-800 text-3xl font-display font-semibold select-none animate-float pointer-events-none hidden lg:block">
        M_ij
      </div>
      <div className="absolute top-44 right-12 text-slate-800 text-3xl font-display font-semibold select-none animate-float-reverse pointer-events-none hidden lg:block">
        C_ij
      </div>
      <div className="absolute top-[450px] left-16 text-slate-800/60 text-2xl font-mono select-none animate-float-slow pointer-events-none hidden lg:block">
        det(A)
      </div>
      <div className="absolute top-[380px] right-20 text-slate-800/60 text-4xl font-display font-bold select-none animate-float pointer-events-none hidden lg:block">
        + &minus; +
      </div>

      {/* Hero Section */}
      <div className="w-full text-center mb-16 flex flex-col items-center">
        
        {/* Floating 3D Matrix Mockup (Premium CSS 3D Transforms) */}
        <div className="w-full flex flex-col items-center mb-8">
          <div className="perspective-1000 flex justify-center w-full">
            <motion.div
            initial={{ opacity: 0, y: -30, rotateX: 35, rotateY: -35 }}
            animate={{ 
              opacity: 1, 
              y: 0, 
              rotateX: [25, 30, 25], 
              rotateY: [-20, -25, -20],
              rotateZ: [0, 1.5, 0]
            }}
            transition={{ 
              duration: 8, 
              repeat: Infinity, 
              repeatType: 'reverse', 
              ease: 'easeInOut' 
            }}
            className="transform-style-3d w-36 h-36 md:w-44 md:h-44 grid grid-cols-3 gap-2.5 md:gap-3.5 p-4 bg-slate-950/80 border border-slate-800 rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.9)] relative"
          >
            {/* 3x3 Mockup Tiles */}
            {[2, 3, 1, 0, 1, 4, 5, 6, 0].map((num, i) => {
              // Highlight some numbers dynamically to simulate matrix gameplay
              const isHighlight = [0, 2, 6, 8].includes(i); // remaining 2x2 elements
              return (
                <motion.div
                  key={i}
                  initial={{ scale: 0, translateZ: 0 }}
                  animate={{ 
                    scale: 1, 
                    translateZ: isHighlight ? 25 : 0 
                  }}
                  transition={{ 
                    delay: i * 0.05, 
                    type: 'spring', 
                    stiffness: 180,
                    translateZ: { duration: 2, repeat: Infinity, repeatType: 'reverse', ease: 'easeInOut', delay: i * 0.1 }
                  }}
                  className={cn(
                    "w-full h-full rounded-xl md:rounded-2xl flex items-center justify-center font-display font-bold text-lg md:text-xl border transition-all duration-300 transform-style-3d",
                    isHighlight 
                      ? "border-blue-500 bg-blue-950/40 text-blue-400 shadow-[0_0_15px_rgba(59,130,246,0.3)]"
                      : "border-slate-800 bg-slate-900/10 text-slate-600"
                  )}
                >
                  <span className="drop-shadow-[0_2px_4px_rgba(0,0,0,0.5)]">{num}</span>
                </motion.div>
              );
            })}
          </motion.div>
          </div>
          <span className="text-[11px] text-slate-500 mt-5 italic tracking-wide font-medium text-center block">
            Simulasi 3D: Pilihan Baris &amp; Kolom dieliminasi secara visual
          </span>
        </div>

        {/* Title with Blue Gradient (No Drop Glows) */}
        <motion.h1
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8, ease: 'easeOut' }}
          className="text-5xl md:text-7xl font-display font-extrabold tracking-tight mb-5 select-none"
        >
          <span className="bg-gradient-to-r from-blue-600 via-blue-500 to-blue-400 bg-clip-text text-transparent">
            MAMITOR 3D
          </span>
        </motion.h1>
        
        {/* Description */}
        <motion.p
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8, delay: 0.2, ease: 'easeOut' }}
          className="text-base md:text-xl text-slate-400 font-medium max-w-2xl mb-10 leading-relaxed px-4"
        >
          Media digital alat peraga interaktif untuk memvisualisasikan cara menghitung <span className="text-blue-500 font-semibold underline decoration-blue-500/30 decoration-2 underline-offset-4">Minor</span> &amp; <span className="text-blue-400 font-semibold underline decoration-blue-400/30 decoration-2 underline-offset-4">Kofaktor</span> matriks 3x3 secara nyata.
        </motion.p>

        {/* Start Button (No animate-glow) */}
        <motion.div
          initial={{ opacity: 0, scale: 0.9 }}
          animate={{ opacity: 1, scale: 1 }}
          transition={{ duration: 0.8, delay: 0.4, type: 'spring' }}
        >
          <Button
            variant="primary"
            size="lg"
            className="group relative overflow-hidden px-10 py-5 rounded-2xl flex items-center gap-3 text-lg md:text-xl font-bold tracking-wider"
            onClick={onStart}
          >
            <Play className="w-5.5 h-5.5 fill-current group-hover:scale-105 transition-transform duration-300" />
            MULAI BERMAIN
            <span className="absolute inset-0 w-full h-full bg-gradient-to-r from-white/5 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000 ease-out" />
          </Button>
        </motion.div>
      </div>

      {/* Group Profile Section */}
      <GroupProfile />

      {/* Info Section (Interactive Grid) */}
      <div className="w-full mt-20 border-t border-slate-900/60 pt-16 grid md:grid-cols-2 gap-8 px-2 overflow-hidden relative">
        {/* Ambient background glows for info section */}
        <div className="glow-sphere w-[300px] h-[300px] bg-blue-600/5 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2" />
        
        {/* Fitur Utama */}
        <motion.div
          initial={{ opacity: 0, x: -35 }}
          whileInView={{ opacity: 1, x: 0 }}
          viewport={{ once: true, margin: "-100px" }}
          transition={{ duration: 0.8, ease: "easeOut" }}
          className="w-full flex flex-col"
        >
          <Card id="fitur-unggulan" variant="interactive" className="group p-8 h-full flex flex-col justify-between relative overflow-hidden">
            {/* Top light glow border line */}
            <div className="absolute top-0 left-0 right-0 h-[2px] bg-gradient-to-r from-transparent via-blue-500/50 to-transparent" />
            
            <h3 className="text-lg md:text-xl font-display font-bold mb-6 flex items-center gap-3 text-blue-400">
              <Compass className="w-5.5 h-5.5 text-blue-400 animate-pulse" /> Fitur Unggulan Alat Peraga
            </h3>
            
            <div className="space-y-6">
              <div className="flex gap-4.5 items-start group/item">
                <div className="p-3 rounded-2xl bg-blue-950/40 border border-blue-900/50 text-blue-400 shrink-0 transition-all duration-300 group-hover/item:scale-105 group-hover/item:border-blue-500/40 group-hover/item:bg-blue-950/60 shadow-inner">
                  <Grid className="w-5 h-5" />
                </div>
                <div>
                  <h4 className="font-display font-bold text-white mb-1 group-hover/item:text-blue-400 transition-colors duration-200">Visualisasi 3D Real-Time</h4>
                  <p className="text-slate-400 text-sm leading-relaxed">
                    Elemen baris dan kolom yang ditutup bergeser ke belakang, memunculkan matriks sisa 2x2 yang bersih dalam koordinat 3D yang interaktif.
                  </p>
                </div>
              </div>
              
              <div className="flex gap-4.5 items-start group/item">
                <div className="p-3 rounded-2xl bg-blue-950/40 border border-blue-900/50 text-blue-300 shrink-0 transition-all duration-300 group-hover/item:scale-105 group-hover/item:border-blue-500/40 group-hover/item:bg-blue-950/60 shadow-inner">
                  <Sparkles className="w-5 h-5" />
                </div>
                <div>
                  <h4 className="font-display font-bold text-white mb-1 group-hover/item:text-blue-400 transition-colors duration-200">Evaluasi &amp; Feedback Langsung</h4>
                  <p className="text-slate-400 text-sm leading-relaxed">
                    Masukkan jawaban hitunganmu pada worksheet, periksa jawaban dengan tombol evaluasi, dan dapatkan koreksi otomatis pada bagian yang keliru.
                  </p>
                </div>
              </div>
            </div>
          </Card>
        </motion.div>

        {/* Petunjuk Bermain */}
        <motion.div
          initial={{ opacity: 0, x: 35 }}
          whileInView={{ opacity: 1, x: 0 }}
          viewport={{ once: true, margin: "-100px" }}
          transition={{ duration: 0.8, ease: "easeOut" }}
          className="w-full flex flex-col"
        >
          <Card id="langkah-belajar" variant="interactive" className="p-8 h-full flex flex-col justify-between relative overflow-hidden">
            {/* Top light glow border line */}
            <div className="absolute top-0 left-0 right-0 h-[2px] bg-gradient-to-r from-transparent via-indigo-500/50 to-transparent" />
            
            <h3 className="text-lg md:text-xl font-display font-bold mb-6 flex items-center gap-3 text-blue-400">
              <HelpCircle className="w-5.5 h-5.5 text-blue-400 animate-pulse" /> Langkah Belajar
            </h3>
            
            <div className="relative space-y-5 font-medium text-slate-350 z-10 pl-1.5">
              {/* Timeline Connector Line */}
              <div className="absolute left-[17px] top-6 bottom-6 w-[2px] bg-gradient-to-b from-blue-500/40 via-blue-500/20 to-transparent border-dashed border-l border-blue-500/30" />
              
              <div className="flex gap-4 items-center p-1.5 rounded-xl hover:bg-slate-900/30 transition-colors duration-200 group">
                <span className="w-7 h-7 rounded-xl bg-blue-950/40 border border-blue-900/40 text-blue-400 text-sm font-bold flex items-center justify-center shrink-0 z-10 group-hover:bg-blue-600 group-hover:text-white group-hover:border-blue-400 group-hover:scale-105 group-hover:shadow-[0_0_15px_rgba(59,130,246,0.4)] transition-all duration-300">1</span>
                <p className="text-sm group-hover:text-slate-200 transition-colors duration-200">Isi atau sesuaikan nilai matriks 3x3 sesukamu.</p>
              </div>
              
              <div className="flex gap-4 items-center p-1.5 rounded-xl hover:bg-slate-900/30 transition-colors duration-200 group">
                <span className="w-7 h-7 rounded-xl bg-blue-950/40 border border-blue-900/40 text-blue-400 text-sm font-bold flex items-center justify-center shrink-0 z-10 group-hover:bg-blue-600 group-hover:text-white group-hover:border-blue-400 group-hover:scale-105 group-hover:shadow-[0_0_15px_rgba(59,130,246,0.4)] transition-all duration-300">2</span>
                <p className="text-sm group-hover:text-slate-200 transition-colors duration-200">Pilih Baris &amp; Kolom target untuk dieliminasi.</p>
              </div>
              
              <div className="flex gap-4 items-center p-1.5 rounded-xl hover:bg-slate-900/30 transition-colors duration-200 group">
                <span className="w-7 h-7 rounded-xl bg-blue-950/40 border border-blue-900/40 text-blue-400 text-sm font-bold flex items-center justify-center shrink-0 z-10 group-hover:bg-blue-600 group-hover:text-white group-hover:border-blue-400 group-hover:scale-105 group-hover:shadow-[0_0_15px_rgba(59,130,246,0.4)] transition-all duration-300">3</span>
                <p className="text-sm group-hover:text-slate-200 transition-colors duration-200">Hitung matriks sisa, determinan (Minor), dan Kofaktor.</p>
              </div>
              
              <div className="flex gap-4 items-center p-1.5 rounded-xl hover:bg-slate-900/30 transition-colors duration-200 group">
                <span className="w-7 h-7 rounded-xl bg-blue-950/40 border border-blue-900/40 text-blue-400 text-sm font-bold flex items-center justify-center shrink-0 z-10 group-hover:bg-blue-600 group-hover:text-white group-hover:border-blue-400 group-hover:scale-105 group-hover:shadow-[0_0_15px_rgba(59,130,246,0.4)] transition-all duration-300">4</span>
                <p className="text-sm group-hover:text-slate-200 transition-colors duration-200">Klik <strong>Cek Jawaban</strong> untuk melihat evaluasi akhir.</p>
              </div>
            </div>
          </Card>
        </motion.div>
      </div>

      {/* Quick Math Concept Section */}
      <div
        id="konsep-dasar"
        className="w-full mt-20 border-t border-slate-900/60 pt-16 relative"
      >
        {/* Ambient glow sphere */}
        <div className="glow-sphere w-[300px] h-[300px] bg-indigo-600/5 bottom-0 right-1/4" />
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          transition={{ duration: 0.6, ease: "easeOut" }}
          className="text-center mb-10 flex flex-col items-center"
        >
          <div className="flex items-center gap-2 mb-2">
            <BookOpen className="w-5 h-5 text-blue-500" />
            <h2 className="text-xl md:text-2xl font-display font-extrabold text-white">
              Sekilas Materi &amp; Konsep Dasar
            </h2>
          </div>
          <p className="text-xs md:text-sm text-slate-400 max-w-lg leading-relaxed">
            Sebelum menekan tombol bermain, yuk pelajari atau ingat kembali bagaimana Minor dan Kofaktor dihitung dari matriks 3x3.
          </p>
        </motion.div>

        <div className="grid md:grid-cols-2 gap-8 w-full">
          {/* Minor Card */}
          <motion.div
            initial={{ opacity: 0, y: 35 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true, margin: "-80px" }}
            transition={{ duration: 0.8, ease: "easeOut" }}
            className="flex flex-col h-full"
          >
            <Card className="p-6 md:p-8 border-l-4 border-l-blue-600 bg-slate-950/15 flex flex-col justify-between h-full">
            <div>
              <div className="flex justify-between items-start mb-4">
                <div>
                  <span className="text-[10px] font-display font-bold tracking-widest text-blue-400 uppercase block mb-1">Konsep 1</span>
                  <h3 className="text-lg font-display font-bold text-white">Minor Elemen (M_ij)</h3>
                </div>
                <span className="px-2.5 py-1 rounded-lg bg-blue-950/20 border border-blue-900/30 text-[10px] font-mono font-bold text-blue-400">
                  M_ij = det(A_ij)
                </span>
              </div>
              
              <p className="text-xs md:text-sm text-slate-400 leading-relaxed mb-6">
                {"Minor dari suatu elemen matriks baris ke-$i$ dan kolom ke-$j$ (ditulis $M_{ij}$) diperoleh dengan menghitung determinan dari matriks sisa 2x2 setelah Anda menghapus seluruh baris ke-$i$ dan kolom ke-$j$ pada matriks utama."}
              </p>
            </div>

            <div className="bg-slate-950 border border-slate-900 shadow-[0_0_15px_rgba(59,130,246,0.03)] rounded-2xl p-4 flex flex-col gap-2.5">
              <span className="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Rumus Determinan 2x2:</span>
              <div className="flex justify-center py-2 bg-slate-900/40 rounded-xl border border-white/5">
                <LatexFormula math="\\det \\begin{pmatrix} a & b \\\\ c & d \\end{pmatrix} = ad - bc" block />
              </div>
              <span className="text-[10px] text-slate-500 italic mt-1 leading-normal">
                * Keterangan: Kalikan elemen diagonal utama (a &times; d) lalu kurangi dengan hasil kali diagonal samping (b &times; c).
              </span>
            </div>
          </Card>
        </motion.div>

          {/* Cofactor Card */}
          <motion.div
            initial={{ opacity: 0, y: 35 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true, margin: "-80px" }}
            transition={{ duration: 0.8, delay: 0.1, ease: "easeOut" }}
            className="flex flex-col h-full"
          >
            <Card className="p-6 md:p-8 border-l-4 border-l-blue-600 bg-slate-950/15 flex flex-col justify-between h-full">
              <div>
              <div className="flex justify-between items-start mb-4">
                <div>
                  <span className="text-[10px] font-display font-bold tracking-widest text-blue-400 uppercase block mb-1">Konsep 2</span>
                  <h3 className="text-lg font-display font-bold text-white">Kofaktor Elemen (C_ij)</h3>
                </div>
                <span className="px-2.5 py-1 rounded-lg bg-blue-950/20 border border-blue-900/30 text-[10px] font-mono font-bold text-blue-400">
                  {"C_ij = (-1)^{i+j} · M_ij"}
                </span>
              </div>

              <p className="text-xs md:text-sm text-slate-400 leading-relaxed mb-6">
                {"Kofaktor ($C_{ij}$) diperoleh dengan cara mengalikan hasil Minor ($M_{ij}$) dengan tanda positif/negatif yang ditentukan oleh kedudukan elemen tersebut (berdasarkan pangkat bilangan $(-1)^{i+j}$)."}
              </p>
            </div>

            <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div className="bg-slate-950 border border-slate-900 shadow-[0_0_15px_rgba(59,130,246,0.03)] rounded-2xl p-4 flex flex-col justify-between">
                <div>
                  <span className="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-2">Pola Tanda Matriks 3x3:</span>
                  <div className="grid grid-cols-3 gap-1 w-24 mx-auto py-0.5">
                    {['+', '-', '+', '-', '+', '-', '+', '-', '+'].map((sign, idx) => {
                      const isPlus = sign === '+';
                      return (
                        <div 
                          key={idx} 
                          className={`h-6 w-6 rounded border flex items-center justify-center font-display font-bold text-[10px] ${
                            isPlus 
                              ? 'border-blue-500 bg-blue-950/30 text-blue-400 shadow-[0_0_10px_rgba(59,130,246,0.2)]' 
                              : 'border-slate-800 bg-slate-950/10 text-slate-500'
                          }`}
                        >
                          {sign}
                        </div>
                      );
                    })}
                  </div>
                </div>
              </div>

              <div className="bg-slate-950 border border-slate-900 shadow-[0_0_15px_rgba(59,130,246,0.03)] rounded-2xl p-4 flex flex-col justify-center gap-1">
                <span className="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Aturan Tanda:</span>
                <div className="py-2 px-2 bg-slate-900/40 rounded-xl border border-white/5 text-center text-[10px] font-medium text-slate-350 leading-relaxed">
                  Jika <code className="text-blue-400">i+j</code> Genap &rarr; <strong className="text-emerald-400 font-bold">(+)</strong> Tetap
                  <br />
                  Jika <code className="text-blue-400">i+j</code> Ganjil &rarr; <strong className="text-rose-400 font-bold">(&minus;)</strong> Berubah
                </div>
              </div>
            </div>
          </Card>
        </motion.div>
      </div>
    </div>
    </div>
  );
};

// Helper conditional classname merge
function cn(...classes: any[]) {
  return classes.filter(Boolean).join(' ');
}

export default StartScreen;
