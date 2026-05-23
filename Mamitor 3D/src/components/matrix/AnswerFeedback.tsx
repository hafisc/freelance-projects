'use client';

import React from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { Sparkles, AlertCircle, RefreshCw } from 'lucide-react';
import { Button } from '@/components/ui/Button';

interface AnswerFeedbackProps {
  isSubmitted: boolean;
  allCorrect: boolean;
  onReset: () => void;
}

/**
 * Komponen Banner Feedback Jawaban.
 * Menampilkan pesan selamat jika semua jawaban benar, atau peringatan jika ada jawaban yang salah.
 */
export const AnswerFeedback: React.FC<AnswerFeedbackProps> = ({
  isSubmitted,
  allCorrect,
  onReset,
}) => {
  return (
    <AnimatePresence>
      {isSubmitted && (
        <motion.div
          initial={{ opacity: 0, height: 0, y: 15 }}
          animate={{ opacity: 1, height: 'auto', y: 0 }}
          exit={{ opacity: 0, height: 0, y: 15 }}
          transition={{ type: 'spring', stiffness: 200, damping: 20 }}
          className="overflow-hidden w-full"
        >
          {allCorrect ? (
            // Feedback jika semua benar (Sukses)
            <div className="p-5 mt-4 rounded-xl border border-emerald-500/30 bg-emerald-950/20 text-emerald-300 flex flex-col gap-4">
              <div className="flex items-start gap-3">
                <div className="p-2 rounded-lg bg-emerald-500/20 text-emerald-400">
                  <Sparkles className="w-5 h-5 animate-pulse" />
                </div>
                <div>
                  <h4 className="font-bold text-white text-base">Luar Biasa! Jawabanmu Benar Semua! 🎉</h4>
                  <p className="text-slate-300 text-sm mt-1">
                    Kamu telah berhasil mengidentifikasi matriks sisa, menghitung Minor, dan menentukan Kofaktor dengan sangat tepat.
                  </p>
                </div>
              </div>
              
              <Button
                variant="success"
                onClick={onReset}
                className="flex items-center gap-2 py-2.5 self-end text-sm"
              >
                <RefreshCw className="w-4 h-4" /> Coba Lagi / Reset
              </Button>
            </div>
          ) : (
            // Feedback jika masih ada yang salah (Warning)
            <div className="p-5 mt-4 rounded-xl border border-rose-500/30 bg-rose-950/20 text-rose-300 flex flex-col gap-3">
              <div className="flex items-start gap-3">
                <div className="p-2 rounded-lg bg-rose-500/20 text-rose-400">
                  <AlertCircle className="w-5 h-5" />
                </div>
                <div>
                  <h4 className="font-bold text-white text-base">Ups, Masih Ada Jawaban yang Kurang Tepat! 🔍</h4>
                  <p className="text-slate-300 text-sm mt-1">
                    Periksa kembali elemen matriks sisa yang kamu salin, pastikan rumus perkalian silang determinanmu benar <code className="text-white bg-slate-900/60 px-1.5 py-0.5 rounded">(ad - bc)</code>, dan cek kembali tanda kofaktormu <code className="text-white bg-slate-900/60 px-1.5 py-0.5 rounded">(-1)^(i+j)</code>.
                  </p>
                </div>
              </div>
            </div>
          )}
        </motion.div>
      )}
    </AnimatePresence>
  );
};
export default AnswerFeedback;
