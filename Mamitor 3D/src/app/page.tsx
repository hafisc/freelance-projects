'use client';

import React from 'react';
import { AnimatePresence, motion } from 'framer-motion';
import { PageShell } from '@/components/layout/PageShell';
import { StartScreen } from '@/components/hero/StartScreen';
import { MatrixWorkspace } from '@/components/matrix/MatrixWorkspace';
import { useMatrixGame } from '@/hooks/useMatrixGame';
import { Navbar } from '@/components/layout/Navbar';
import { Footer } from '@/components/layout/Footer';

/**
 * Halaman Utama MAMITOR 3D.
 * Mengontrol perpindahan fase halaman antara StartScreen dan MatrixWorkspace.
 * Menggunakan AnimatePresence untuk transisi fade-in/fade-out yang mulus.
 */
export default function Home() {
  const game = useMatrixGame();

  return (
    <PageShell>
      {game.gamePhase === 'START' && (
        <Navbar
          gamePhase={game.gamePhase}
          onStartGame={game.startGame}
          onGoToStart={game.goToStart}
          onResetGame={game.resetGame}
          isClosed={game.isClosed}
        />
      )}

      <div className={`flex-1 flex flex-col w-full ${game.gamePhase === 'START' ? 'pt-16' : ''}`}>
        <AnimatePresence mode="wait">
          {game.gamePhase === 'START' ? (
            // Halaman Awal
            <motion.div
              key="start-screen"
              initial={{ opacity: 0, scale: 0.98 }}
              animate={{ opacity: 1, scale: 1 }}
              exit={{ opacity: 0, y: -20 }}
              transition={{ duration: 0.5, ease: 'easeInOut' }}
              className="flex-1 w-full flex flex-col justify-center items-center"
            >
              <StartScreen onStart={game.startGame} />
            </motion.div>
          ) : (
            // Halaman Lembar Kerja Permainan
            <motion.div
              key="workspace-screen"
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              exit={{ opacity: 0, scale: 0.98 }}
              transition={{ duration: 0.5, ease: 'easeInOut' }}
              className="flex-1 w-full"
            >
              <MatrixWorkspace
                matrix={game.matrix}
                setMatrixValue={game.setMatrixValue}
                selectedRow={game.selectedRow}
                setSelectedRow={game.setSelectedRow}
                selectedCol={game.selectedCol}
                setSelectedCol={game.setSelectedCol}
                isClosed={game.isClosed}
                startClosing={game.startClosing}
                userAnswers={game.userAnswers}
                updateUserAnswer={game.updateUserAnswer}
                answerStatus={game.answerStatus}
                checkAnswers={game.checkAnswers}
                resetGame={game.resetGame}
                isSubmitted={game.isSubmitted}
                allCorrect={game.allCorrect}
                goToStart={game.goToStart}
              />
            </motion.div>
          )}
        </AnimatePresence>
      </div>

      {game.gamePhase === 'START' && <Footer onGoToStart={game.goToStart} />}
    </PageShell>
  );
}
