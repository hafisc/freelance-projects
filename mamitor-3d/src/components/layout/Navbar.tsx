'use client';

import React, { useState } from 'react';
import { Grid, Play, ArrowLeft, Menu, X, HelpCircle, BookOpen, Compass } from 'lucide-react';
import { Button } from '@/components/ui/Button';
import { motion } from 'framer-motion';

interface NavbarProps {
  gamePhase: 'START' | 'PLAYING';
  onStartGame: () => void;
  onGoToStart: () => void;
  onResetGame: () => void;
  isClosed: boolean;
}

/**
 * Komponen Navbar Adaptif untuk MAMITOR 3D.
 * Menampilkan menu navigasi interaktif yang menyesuaikan dengan fase permainan saat ini.
 */
export const Navbar: React.FC<NavbarProps> = ({
  gamePhase,
  onStartGame,
  onGoToStart,
  onResetGame,
  isClosed,
}) => {
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

  // Helper untuk melakukan scroll ke section target di landing page
  const scrollToSection = (id: string) => {
    setMobileMenuOpen(false);
    if (gamePhase !== 'START') {
      onGoToStart();
      // Beri sedikit delay agar halaman berpindah sebelum scroll
      setTimeout(() => {
        const element = document.getElementById(id);
        if (element) {
          element.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      }, 300);
    } else {
      const element = document.getElementById(id);
      if (element) {
        element.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    }
  };

  return (
    <motion.nav
      initial={{ y: -70, opacity: 0 }}
      animate={{ y: 0, opacity: 1 }}
      transition={{ duration: 0.6, ease: [0.16, 1, 0.3, 1] }}
      className="fixed top-0 left-0 right-0 z-50 w-full bg-[#020c1b]/35 backdrop-blur-md border-b border-white/5 select-none"
    >
      <div className="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
        
        {/* Logo Brand */}
        <div 
          onClick={onGoToStart}
          className="flex items-center gap-2.5 cursor-pointer hover:opacity-90 transition-opacity">
          <span className="font-display font-bold text-white tracking-wide text-base">MAMITOR 3D</span>
        </div>

        {/* Menu Tautan Tengah (Hanya Tampil di Desktop & Fase START / Menuju Section) */}
        <div className="hidden md:flex items-center gap-6">
          <button 
            onClick={() => scrollToSection('fitur-unggulan')}
            className="text-xs font-semibold text-slate-400 hover:text-blue-400 transition-colors flex items-center gap-1.5"
          >
            <Compass className="w-3.5 h-3.5" /> Fitur
          </button>
          <button 
            onClick={() => scrollToSection('langkah-belajar')}
            className="text-xs font-semibold text-slate-400 hover:text-blue-400 transition-colors flex items-center gap-1.5"
          >
            <HelpCircle className="w-3.5 h-3.5" /> Panduan
          </button>
          <button 
            onClick={() => scrollToSection('konsep-dasar')}
            className="text-xs font-semibold text-slate-400 hover:text-blue-400 transition-colors flex items-center gap-1.5"
          >
            <BookOpen className="w-3.5 h-3.5" /> Materi Dasar
          </button>
        </div>

        {/* Tombol Aksi Kanan (Desktop) */}
        <div className="hidden md:flex items-center gap-3">
          {gamePhase === 'START' ? (
            <Button
              variant="primary"
              size="sm"
              onClick={onStartGame}
              className="flex items-center gap-1.5 px-4.5 py-2 text-xs rounded-xl"
            >
              <Play className="w-3.5 h-3.5 fill-current" /> MULAI BERMAIN
            </Button>
          ) : (
            <div className="flex items-center gap-2">
              <Button
                variant="outline"
                size="sm"
                onClick={onGoToStart}
                className="flex items-center gap-1.5 px-4 py-2 text-xs rounded-xl hover:border-blue-500/30"
              >
                <ArrowLeft className="w-3.5 h-3.5" /> Beranda
              </Button>
              {isClosed && (
                <Button
                  variant="glass"
                  size="sm"
                  onClick={onResetGame}
                  className="px-4 py-2 text-xs rounded-xl border border-slate-800 text-slate-300 hover:text-white"
                >
                  Reset Matriks
                </Button>
              )}
            </div>
          )}
        </div>

        {/* Tombol Menu Mobile */}
        <div className="md:hidden flex items-center">
          <button
            onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
            className="p-1.5 rounded-lg border border-slate-900 text-slate-400 hover:text-white hover:bg-slate-950 transition-colors"
          >
            {mobileMenuOpen ? <X className="w-5 h-5" /> : <Menu className="w-5 h-5" />}
          </button>
        </div>
      </div>

      {/* Menu Dropdown Mobile */}
      {mobileMenuOpen && (
        <div className="md:hidden w-full bg-[#020c1b]/95 backdrop-blur-lg border-b border-white/5 py-4 px-4 flex flex-col gap-4 animate-fade-in">
          <div className="flex flex-col gap-3">
            <button 
              onClick={() => scrollToSection('fitur-unggulan')}
              className="text-left py-2 px-3 rounded-lg text-sm font-semibold text-slate-400 hover:text-blue-400 hover:bg-slate-900/50 transition-colors flex items-center gap-2"
            >
              <Compass className="w-4 h-4" /> Fitur Utama
            </button>
            <button 
              onClick={() => scrollToSection('langkah-belajar')}
              className="text-left py-2 px-3 rounded-lg text-sm font-semibold text-slate-400 hover:text-blue-400 hover:bg-slate-900/50 transition-colors flex items-center gap-2"
            >
              <HelpCircle className="w-4 h-4" /> Langkah Belajar
            </button>
            <button 
              onClick={() => scrollToSection('konsep-dasar')}
              className="text-left py-2 px-3 rounded-lg text-sm font-semibold text-slate-400 hover:text-blue-400 hover:bg-slate-900/50 transition-colors flex items-center gap-2"
            >
              <BookOpen className="w-4 h-4" /> Materi &amp; Rumus
            </button>
          </div>

          <div className="border-t border-slate-900 pt-3">
            {gamePhase === 'START' ? (
              <Button
                variant="primary"
                fullWidth
                onClick={() => {
                  setMobileMenuOpen(false);
                  onStartGame();
                }}
                className="flex items-center justify-center gap-1.5 py-3 text-sm rounded-xl"
              >
                <Play className="w-4 h-4 fill-current" /> MULAI BERMAIN
              </Button>
            ) : (
              <div className="flex flex-col gap-2">
                <Button
                  variant="outline"
                  fullWidth
                  onClick={() => {
                    setMobileMenuOpen(false);
                    onGoToStart();
                  }}
                  className="flex items-center justify-center gap-1.5 py-3 text-sm rounded-xl"
                >
                  <ArrowLeft className="w-4 h-4" /> Kembali ke Beranda
                </Button>
                {isClosed && (
                  <Button
                    variant="glass"
                    fullWidth
                    onClick={() => {
                      setMobileMenuOpen(false);
                      onResetGame();
                    }}
                    className="py-3 text-sm rounded-xl border border-slate-800 text-slate-350"
                  >
                    Reset Worksheet
                  </Button>
                )}
              </div>
            )}
          </div>
        </div>
      )}
    </motion.nav>
  );
};

export default Navbar;
