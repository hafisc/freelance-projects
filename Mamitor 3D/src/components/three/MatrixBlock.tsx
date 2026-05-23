'use client';

import React, { useRef, Suspense, useState, useEffect } from 'react';
import { useFrame } from '@react-three/fiber';
import { Text } from '@react-three/drei';
import * as THREE from 'three';

interface MatrixBlockProps {
  position: [number, number, number];
  value: number;
  isCrossed: boolean;
  isHighlighted: boolean;
  isClosed: boolean;
}

/**
 * Komponen Blok Matriks 3D (MatrixBlock).
 * Merepresentasikan sebuah sel dalam matriks 3x3 sebagai kubus 3D.
 * Menggunakan useFrame untuk animasi pergeseran, peredupan, dan glow secara halus (lerp).
 */
export const MatrixBlock: React.FC<MatrixBlockProps> = ({
  position,
  value,
  isCrossed,
  isHighlighted,
  isClosed,
}) => {
  const meshRef = useRef<THREE.Mesh>(null);
  const textRef = useRef<any>(null);

  // Status URL Font absolut untuk mendukung worker fetch
  const [fontUrl, setFontUrl] = useState<string>('/fonts/roboto.woff');

  useEffect(() => {
    if (typeof window !== 'undefined') {
      setFontUrl(`${window.location.origin}/fonts/roboto.woff`);
    }
  }, []);

  // Parameter target animasi berdasarkan status penutupan baris/kolom (Tema Biru & Hitam Minimalis)
  // 1. Posisi Z: kubus sisa maju ke depan (+0.6), kubus tercoret mundur ke belakang (-1.2)
  const targetZ = isClosed ? (isCrossed ? -1.2 : 0.6) : 0;
  // 2. Skala: kubus sisa membesar sedikit (1.1), kubus tercoret mengecil (0.75)
  const targetScale = isClosed ? (isCrossed ? 0.75 : 1.1) : 1.0;
  // 3. Warna: kubus sisa berwarna biru terang, kubus tercoret abu-abu gelap, normal berwarna biru sedang
  const targetColor = isClosed ? (isCrossed ? '#1e293b' : '#2563eb') : '#1d4ed8';
  // 4. Opacity: kubus tercoret dibuat sangat transparan (0.15)
  const targetOpacity = isClosed ? (isCrossed ? 0.15 : 1.0) : 1.0;
  // 5. Emissive (Glow): Dinonaktifkan untuk tema tanpa glow
  const targetEmissive = '#000000';
  // 6. Intensitas Emissive: 0 (mati)
  const targetEmissiveIntensity = 0;

  useFrame((state, delta) => {
    if (!meshRef.current) return;

    // Animasi pergeseran posisi sumbu Z secara halus (lerp)
    meshRef.current.position.z = THREE.MathUtils.lerp(
      meshRef.current.position.z,
      position[2] + targetZ,
      0.1
    );

    // Animasi perubahan skala secara halus
    const currentScale = meshRef.current.scale.x;
    const nextScale = THREE.MathUtils.lerp(currentScale, targetScale, 0.1);
    meshRef.current.scale.set(nextScale, nextScale, nextScale);

    // Animasi properti material secara halus
    const material = meshRef.current.material as THREE.MeshStandardMaterial;
    if (material) {
      // Lerp warna dasar
      material.color.lerp(new THREE.Color(targetColor), 0.1);
      // Lerp warna emisi (glow)
      material.emissive.lerp(new THREE.Color(targetEmissive), 0.1);
      // Lerp intensitas glow
      material.emissiveIntensity = THREE.MathUtils.lerp(
        material.emissiveIntensity,
        targetEmissiveIntensity,
        0.1
      );
      // Lerp transparansi
      material.opacity = THREE.MathUtils.lerp(material.opacity, targetOpacity, 0.1);
      material.transparent = material.opacity < 0.99;
    }
  });

  return (
    <mesh ref={meshRef} position={position}>
      {/* Geometri Kubus (Box) dengan ketebalan tipis */}
      <boxGeometry args={[1.1, 1.1, 0.35]} />
      
      {/* Material dengan dukungan pencahayaan tanpa emisi cahaya (glow) */}
      <meshStandardMaterial
        color="#1d4ed8"
        roughness={0.4}
        metalness={0.1}
        emissive="#000000"
        emissiveIntensity={0}
        transparent={true}
        opacity={1.0}
      />

      {/* Render angka di permukaan depan kubus menggunakan Text Drei */}
      <Suspense fallback={null}>
        <Text
          ref={textRef}
          position={[0, 0, 0.19]} // Letakkan teks sedikit di depan permukaan kubus
          fontSize={0.45}
          color="#ffffff"
          anchorX="center"
          anchorY="middle"
          font={fontUrl}
        >
          {value.toString()}
        </Text>
      </Suspense>
    </mesh>
  );
};
export default MatrixBlock;
