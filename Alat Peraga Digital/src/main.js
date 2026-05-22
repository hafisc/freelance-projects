// Stylesheets are loaded via <link> tags in index.html to support direct browser/Live Server loading.

// Import modules
import { getElement, resetManualInputs } from './js/dom.js';
import { getMatrixValues, getRemainingMatrix, calculateMinor, calculateCofactor } from './js/matrix.js';
import { renderAllFormulas } from './js/katex-renderer.js';
import { startGameAnimation, highlightSelectedMatrix, showWorksheetPanel } from './js/animation.js';
import { checkUserAnswers } from './js/validation.js';

// Kunci jawaban state
let correctData = {};

/**
 * Menjalankan mode lembar kerja manual setelah user memilih baris & kolom.
 * Mengambil nilai matriks 3x3 dari input, menghitung matriks sisa 2x2, minor, dan kofaktor.
 * Menyimpan data jawaban benar dan menganimasikan grid 3D serta menampilkan panel lembar kerja.
 */
function startManualMode() {
  const rowSelect = getElement('#rowSelect');
  const colSelect = getElement('#colSelect');
  if (!rowSelect || !colSelect) return;

  const row = parseInt(rowSelect.value);
  const col = parseInt(colSelect.value);

  // 1. Kosongkan input manual sebelumnya
  resetManualInputs();

  // 2. Ambil nilai matriks 3x3 saat ini
  const matrix = getMatrixValues();

  // 3. Cari matriks sisa 2x2
  const remaining = getRemainingMatrix(matrix, row, col);

  // 4. Hitung Minor & Kofaktor
  const minorValue = calculateMinor(remaining);
  const cofactorValue = calculateCofactor(minorValue, row, col);

  // 5. Simpan kunci jawaban ke state global
  const a = remaining[0][0];
  const b = remaining[0][1];
  const c = remaining[1][0];
  const d = remaining[1][1];

  correctData = {
    m11: a,
    m12: b,
    m21: c,
    m22: d,
    mul_a: a,
    mul_d: d,
    mul_b: b,
    mul_c: c,
    minor: minorValue,
    cofactor: cofactorValue
  };

  // 6. Jalankan animasi coret (crossed out) baris & kolom
  highlightSelectedMatrix(row, col);

  // 7. Render rumus-rumus menggunakan KaTeX sesuai baris & kolom yang dipilih
  renderAllFormulas(row, col);

  // 8. Tampilkan panel lembar kerja dengan animasi fade-in
  setTimeout(() => {
    showWorksheetPanel();
  }, 500);
}

/**
 * Memanggil fungsi validasi untuk mengecek jawaban user.
 */
function handleCheckAnswers() {
  checkUserAnswers(correctData);
}

// Inisialisasi Event Listener saat DOM siap
document.addEventListener('DOMContentLoaded', () => {
  // Tombol Mulai Bermain (Halaman Intro)
  const btnStart = getElement('#btnStart');
  if (btnStart) {
    btnStart.addEventListener('click', startGameAnimation);
  }

  // Tombol Tutup Baris & Kolom
  const btnTutup = getElement('#btnTutup');
  if (btnTutup) {
    btnTutup.addEventListener('click', startManualMode);
  }

  // Tombol Cek Jawaban
  const btnCek = getElement('#btnCek');
  if (btnCek) {
    btnCek.addEventListener('click', handleCheckAnswers);
  }

  // Animasi hover mouse 3D ringan pada Grid Matriks
  const grid = getElement('#matrixGrid');
  const scene = getElement('.scene');
  if (grid && scene) {
    scene.addEventListener('mousemove', (e) => {
      const rect = scene.getBoundingClientRect();
      const x = e.clientX - rect.left - rect.width / 2;
      const y = e.clientY - rect.top - rect.height / 2;
      
      // Rotasi dinamis berdasarkan posisi mouse
      const rotX = 25 - (y / rect.height) * 30; // Max 15 deg tilt
      const rotY = -20 + (x / rect.width) * 30;
      
      grid.style.transform = `rotateX(${rotX}deg) rotateY(${rotY}deg)`;
    });

    scene.addEventListener('mouseleave', () => {
      // Kembalikan ke posisi semula
      grid.style.transform = 'rotateX(25deg) rotateY(-20deg)';
    });
  }
});
