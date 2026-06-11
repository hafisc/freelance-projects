'use client';

import React from 'react';

/**
 * Komponen pencahayaan untuk scene Three.js.
 * Menyediakan ambient light dan directional lights untuk efek kedalaman 3D yang premium.
 */
export const SceneLights: React.FC = () => {
  return (
    <>
      {/* Cahaya merata lingkungan */}
      <ambientLight intensity={0.6} />

      {/* Cahaya utama dari sudut atas depan */}
      <directionalLight
        position={[5, 8, 5]}
        intensity={1.2}
        castShadow={false} // Di-disable untuk optimasi performa di mobile
      />

      {/* Cahaya pengisi dari sudut kiri belakang */}
      <directionalLight
        position={[-5, 3, -5]}
        intensity={0.4}
      />

      {/* Cahaya pengisi netral (tanpa aksen neon) */}
      <pointLight
        position={[0, 0, 4]}
        intensity={0.4}
        color="#ffffff"
      />
    </>
  );
};
export default SceneLights;
