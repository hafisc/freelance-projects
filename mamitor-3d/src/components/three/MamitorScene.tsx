'use client';

import React, { useState, useEffect, Suspense } from 'react';
import { Canvas } from '@react-three/fiber';
import { OrbitControls } from '@react-three/drei';
import { Matrix3x3 } from '@/types/matrix';
import { MatrixBlock } from './MatrixBlock';
import { SceneLights } from './SceneLights';
import { Loader2 } from 'lucide-react';

interface MamitorSceneProps {
  matrix: Matrix3x3;
  selectedRow: number;
  selectedCol: number;
  isClosed: boolean;
}

/**
 * Komponen Scene 3D MAMITOR.
 * Membungkus Canvas React Three Fiber dan merender 9 blok MatrixBlock dalam susunan grid 3x3.
 * Menggunakan OrbitControls terbatas agar pengguna dapat memutar objek tanpa bingung.
 */
export const MamitorScene: React.FC<MamitorSceneProps> = ({
  matrix,
  selectedRow,
  selectedCol,
  isClosed,
}) => {
  const [mounted, setMounted] = useState(false);

  // Mencegah error Hydration Mismatch di Next.js dengan merender hanya setelah di-mount di browser
  useEffect(() => {
    setMounted(true);
  }, []);

  if (!mounted) {
    return (
      <div className="w-full aspect-square max-w-[420px] rounded-2xl bg-slate-950/20 border border-white/5 flex items-center justify-center text-slate-500">
        <Loader2 className="w-8 h-8 animate-spin text-blue-500 mr-2" />
        <span>Memuat Scene 3D...</span>
      </div>
    );
  }

  // Jarak antar blok dalam koordinat 3D
  const spacing = 1.35;

  return (
    <div className="w-full aspect-square max-w-[420px] bg-slate-950/30 border border-white/5 rounded-2xl overflow-hidden relative shadow-[inset_0_4px_30px_rgba(0,0,0,0.5)]">
      {/* Label Petunjuk Kamera */}
      <div className="absolute top-3 left-3 bg-slate-900/80 backdrop-blur-md px-2.5 py-1 rounded-md text-[10px] text-slate-400 font-semibold select-none z-10 border border-white/5 pointer-events-none">
        🖱️ Seret untuk Rotasi 3D
      </div>

      <Canvas
        camera={{ position: [0, 0, 4.5], fov: 60 }}
        className="absolute inset-0 w-full h-full cursor-grab active:cursor-grabbing"
      >
        {/* Lampu Scene */}
        <SceneLights />

        {/* Group Matriks dengan rotasi default miring (isometric-look) */}
        <group rotation={[0.4, -0.4, 0]}>
          {matrix.map((row, rIdx) =>
            row.map((val, cIdx) => {
              // Koordinat 3D untuk masing-masing blok
              // X: kiri ke kanan, Y: atas ke bawah (negatif untuk rIdx bertambah), Z: depan ke belakang
              const posX = (cIdx - 1) * spacing;
              const posY = (1 - rIdx) * spacing;
              const posZ = 0;

              // Cek apakah sel saat ini berada di baris/kolom terpilih (1-indexed)
              const isCellRow = rIdx + 1 === selectedRow;
              const isCellCol = cIdx + 1 === selectedCol;
              const isCrossed = isCellRow || isCellCol;

              // Cek apakah sel ini merupakan elemen sisa matriks (highlighted)
              const isHighlighted = !isCrossed;

              return (
                <MatrixBlock
                  key={`${rIdx}-${cIdx}`}
                  position={[posX, posY, posZ]}
                  value={val}
                  isCrossed={isCrossed}
                  isHighlighted={isHighlighted}
                  isClosed={isClosed}
                />
              );
            })
          )}
        </group>

        {/* OrbitControls dengan batasan sudut agar scene tidak terbalik */}
        <OrbitControls
          enableZoom={false}
          enablePan={false}
          minPolarAngle={Math.PI / 4}
          maxPolarAngle={Math.PI / 2 + Math.PI / 12}
          minAzimuthAngle={-Math.PI / 4}
          maxAzimuthAngle={Math.PI / 4}
        />
      </Canvas>
    </div>
  );
};
export default MamitorScene;
