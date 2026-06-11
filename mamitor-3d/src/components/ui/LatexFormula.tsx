'use client';

import React, { useEffect, useRef } from 'react';
import katex from 'katex';

interface LatexFormulaProps {
  math: string;
  block?: boolean;
  className?: string;
}

/**
 * Komponen untuk merender rumus matematika menggunakan KaTeX secara aman.
 * Menghindari hydration mismatch dengan melakukan rendering di dalam useEffect (sisi klien).
 */
export const LatexFormula: React.FC<LatexFormulaProps> = ({
  math,
  block = false,
  className,
}) => {
  const containerRef = useRef<HTMLSpanElement>(null);

  useEffect(() => {
    if (containerRef.current) {
      try {
        katex.render(math, containerRef.current, {
          displayMode: block,
          throwOnError: false,
        });
      } catch (error) {
        console.error('KaTeX rendering error:', error);
        containerRef.current.textContent = math; // Fallback jika gagal
      }
    }
  }, [math, block]);

  return <span ref={containerRef} className={className} />;
};
export default LatexFormula;
