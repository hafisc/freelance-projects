'use client';

import React from 'react';
import { useLenis } from '@/hooks/useLenis';

interface PageShellProps {
  children: React.ReactNode;
}

/**
 * Shell utama halaman untuk membungkus seluruh aplikasi.
 * Menginisialisasi smooth scroll menggunakan Lenis.
 */
export const PageShell: React.FC<PageShellProps> = ({ children }) => {
  // Aktifkan smooth scroll Lenis
  useLenis();

  return (
    <div className="relative min-h-screen w-full overflow-x-hidden text-slate-100 selection:bg-blue-500/30 selection:text-white">
      {/* Background radial gradient yang halus (gelap & futuristik - biru hitam) */}
      <div className="fixed inset-0 -z-50 bg-black bg-[radial-gradient(circle_at_50%_0%,#020c1b_0%,#000000_100%)]" />
      
      <main className="relative z-10 w-full min-h-screen flex flex-col">
        {children}
      </main>
    </div>
  );
};
export default PageShell;
