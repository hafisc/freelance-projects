'use client';

import React from 'react';
import { Card } from '@/components/ui/Card';
import { Button } from '@/components/ui/Button';
import { ArrowLeft, BookOpen, AlertCircle, Cpu } from 'lucide-react';
import { MamitorScene } from '@/components/three/MamitorScene';
import { MatrixInputGrid } from '@/components/matrix/MatrixInputGrid';
import { MatrixControls } from '@/components/matrix/MatrixControls';
import { MatrixFormulaPanel } from '@/components/matrix/MatrixFormulaPanel';
import { AnswerFeedback } from '@/components/matrix/AnswerFeedback';

interface MatrixWorkspaceProps {
  matrix: any;
  setMatrixValue: (row: number, col: number, val: number) => void;
  selectedRow: number;
  setSelectedRow: (row: number) => void;
  selectedCol: number;
  setSelectedCol: (col: number) => void;
  isClosed: boolean;
  startClosing: () => void;
  userAnswers: any;
  updateUserAnswer: any;
  answerStatus: any;
  checkAnswers: () => void;
  resetGame: () => void;
  isSubmitted: boolean;
  allCorrect: boolean;
  goToStart: () => void;
}

/**
 * Komponen utama Workspace Permainan MAMITOR 3D.
 * Mengatur tata letak halaman (kiri: Scene 3D + Input Grid, kanan: Dropdowns + Lembar Kerja).
 */
export const MatrixWorkspace: React.FC<MatrixWorkspaceProps> = ({
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
  goToStart,
}) => {
  return (
    <div className="flex-1 w-full max-w-6xl mx-auto px-4 py-4 md:py-8 flex flex-col gap-6 select-none">
      
      {/* Top Navigation */}
      <div className="flex justify-between items-center w-full bg-slate-950/20 backdrop-blur-md p-3 rounded-2xl border border-white/5 shadow-sm">
        <Button
          variant="outline"
          size="sm"
          onClick={goToStart}
          className="flex items-center gap-2 px-4 py-2 hover:border-blue-500/30"
        >
          <ArrowLeft className="w-4 h-4" /> Kembali ke Awal
        </Button>
        
        <div className="text-right">
          <span className="text-[10px] text-blue-500 font-display font-bold tracking-widest uppercase block">Alat Peraga Digital</span>
          <span className="text-sm font-display font-extrabold tracking-wide text-slate-100">Matriks Minor &amp; Kofaktor</span>
        </div>
      </div>

      {/* Grid Utama (Desktop: 2 kolom, Mobile: 1 kolom) */}
      <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start w-full">
        
        {/* Kolom Kiri: Visualisasi 3D & Input Grid (5/12 lebar) */}
        <div className="lg:col-span-5 flex flex-col gap-6 items-center w-full">
          <Card variant="interactive" className="p-6 w-full flex flex-col items-center gap-6">
            
            {/* Header Mini */}
            <div className="w-full text-left flex justify-between items-start border-b border-slate-800/80 pb-4">
              <div>
                <h2 className="text-base font-display font-bold text-white flex items-center gap-2">
                  <BookOpen className="w-5 h-5 text-blue-500" /> Visualisasi Matriks 3D
                </h2>
                <p className="text-[11px] text-slate-400 mt-1">Interaksi visualisasi 3D matriks 3x3 secara dinamis</p>
              </div>
              <span className="w-2.5 h-2.5 rounded-full bg-blue-600 animate-pulse" />
            </div>

            {/* Scene 3D */}
            <MamitorScene
              matrix={matrix}
              selectedRow={selectedRow}
              selectedCol={selectedCol}
              isClosed={isClosed}
            />

            {/* Input Grid 3x3 */}
            <div className="w-full border-t border-slate-800/60 pt-5">
              <MatrixInputGrid
                matrix={matrix}
                onCellChange={setMatrixValue}
                disabled={isClosed}
              />
            </div>
          </Card>
        </div>

        {/* Kolom Kanan: Kontrol & Lembar Kerja (7/12 lebar) */}
        <div className="lg:col-span-7 flex flex-col gap-6 w-full">
          
          {/* Card Kontrol Tereliminasi */}
          <Card className="p-6">
            <h2 className="text-base font-display font-bold text-white mb-4 flex items-center gap-2">
              <Cpu className="w-5 h-5 text-blue-500" /> Eliminasi Baris &amp; Kolom
            </h2>
            <MatrixControls
              selectedRow={selectedRow}
              setSelectedRow={setSelectedRow}
              selectedCol={selectedCol}
              setSelectedCol={setSelectedCol}
              onProcess={startClosing}
              isClosed={isClosed}
            />
          </Card>

          {/* Card Lembar Kerja (Hanya muncul jika isClosed true) */}
          <Card className="p-6 min-h-[140px] relative flex flex-col justify-center transition-all duration-300">
            {isClosed ? (
              <MatrixFormulaPanel
                selectedRow={selectedRow}
                selectedCol={selectedCol}
                userAnswers={userAnswers}
                onAnswerChange={updateUserAnswer}
                answerStatus={answerStatus}
                isSubmitted={isSubmitted}
                onCheck={checkAnswers}
                onReset={resetGame}
              />
            ) : (
              <div className="text-center py-12 flex flex-col items-center justify-center gap-4 text-slate-500">
                <div className="p-4 rounded-full bg-blue-950/20 border border-blue-900/30">
                  <AlertCircle className="w-9 h-9 text-blue-500/60 animate-pulse" />
                </div>
                <div>
                  <h4 className="font-display font-bold text-slate-300 text-sm">Lembar Kerja Belum Terbuka</h4>
                  <p className="text-[12px] text-slate-400 max-w-sm mt-1.5 mx-auto leading-relaxed">
                    Atur nilai angka matriks pada panel kiri, lalu tentukan Baris &amp; Kolom yang akan ditutup. Klik **Tutup Baris &amp; Kolom** untuk memicu visualisasi 3D dan membuka lembar kerja matematika.
                  </p>
                </div>
              </div>
            )}

            {/* Feedback Pop-up */}
            <AnswerFeedback
              isSubmitted={isSubmitted}
              allCorrect={allCorrect}
              onReset={resetGame}
            />
          </Card>
        </div>

      </div>

    </div>
  );
};
export default MatrixWorkspace;
