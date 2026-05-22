import { getElement } from './dom.js';

/**
 * Menghilangkan halaman awal (intro overlay) dengan animasi fade-out.
 */
export function startGameAnimation() {
  const intro = getElement('.intro-overlay');
  if (intro) {
    intro.classList.add('hidden');
  }
}

/**
 * Mereset status class visual pada semua blok grid matriks 3D.
 */
export function resetMatrixBlocks() {
  const blocks = document.querySelectorAll('.matrix-grid .block');
  blocks.forEach(block => {
    block.className = 'block';
  });
}

/**
 * Menganimasikan penutupan baris & kolom terpilih, serta menyorot elemen sisa.
 * Menggunakan efek stagger agar transisi terasa hidup dan premium.
 * @param {number} row - Baris terpilih (1, 2, atau 3).
 * @param {number} col - Kolom terpilih (1, 2, atau 3).
 */
export function highlightSelectedMatrix(row, col) {
  // Reset terlebih dahulu
  resetMatrixBlocks();

  // Animasi dengan stagger delay pada setiap baris dan kolom
  for (let i = 1; i <= 3; i++) {
    for (let j = 1; j <= 3; j++) {
      const block = document.getElementById(`b${i}${j}`);
      if (!block) continue;

      // Stagger delay berdasarkan baris & kolom untuk efek gelombang visual yang halus
      const delay = (i + j) * 40; 
      
      setTimeout(() => {
        if (i === row || j === col) {
          block.classList.add('crossed');
        } else {
          block.classList.add('highlight');
        }
      }, delay);
    }
  }
}

/**
 * Menampilkan panel lembar kerja (worksheet) secara bertahap (fade-in).
 */
export function showWorksheetPanel() {
  const panel = document.getElementById('resultPanel');
  if (panel) {
    panel.classList.add('visible');
  }
}

/**
 * Menyembunyikan panel lembar kerja.
 */
export function hideWorksheetPanel() {
  const panel = document.getElementById('resultPanel');
  if (panel) {
    panel.classList.remove('visible');
  }
}
