'use client';

import { useEffect } from 'react';
import Lenis from 'lenis';

/**
 * Hook untuk menginisialisasi Lenis smooth scroll pada halaman web.
 * Hook ini hanya berjalan di sisi klien (browser).
 */
export function useLenis() {
  useEffect(() => {
    // Inisialisasi Lenis dengan konfigurasi scroll yang halus
    const lenis = new Lenis({
      duration: 1.2,
      easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
      orientation: 'vertical',
      gestureOrientation: 'vertical',
      smoothWheel: true,
    });

    // Fungsi requestAnimationFrame untuk sinkronisasi scroll
    function raf(time: number) {
      lenis.raf(time);
      requestAnimationFrame(raf);
    }

    requestAnimationFrame(raf);

    // Bersihkan instance Lenis ketika komponen di-unmount
    return () => {
      lenis.destroy();
    };
  }, []);
}
