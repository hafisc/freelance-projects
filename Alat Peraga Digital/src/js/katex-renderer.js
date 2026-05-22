/**
 * Merender rumus matematika ke dalam elemen menggunakan KaTeX.
 * Jika KaTeX tidak tersedia atau gagal merender, akan menampilkan teks biasa.
 * @param {string} elementId - ID dari elemen HTML tujuan.
 * @param {string} latexStr - Rumus dalam format LaTeX.
 */
export function renderFormula(elementId, latexStr) {
  const element = document.getElementById(elementId);
  if (!element) return;

  if (typeof window.katex !== 'undefined') {
    try {
      window.katex.render(latexStr, element, {
        throwOnError: false,
        displayMode: false
      });
    } catch (err) {
      console.warn(`KaTeX render error for "${latexStr}":`, err);
      element.textContent = latexStr;
    }
  } else {
    // Fallback jika library KaTeX belum ter-load
    console.warn(`KaTeX is not loaded. Fallback for: ${latexStr}`);
    element.textContent = latexStr.replace(/\\/g, ''); // bersihkan backslash sederhana
  }
}

/**
 * Merender semua label rumus matematika yang ada di worksheet secara dinamis
 * sesuai dengan baris dan kolom yang dipilih.
 * @param {number} row - Baris terpilih (1, 2, atau 3).
 * @param {number} col - Kolom terpilih (1, 2, atau 3).
 */
export function renderAllFormulas(row, col) {
  // Label matriks sisa
  renderFormula('label_submatrix', `A_{${row}${col}} =`);
  
  // Label Minor
  renderFormula('label_m0', `M_{${row}${col}} = \\det(A_{${row}${col}})`);
  renderFormula('label_m1', `M_{${row}${col}} =`);
  renderFormula('label_m2', `M_{${row}${col}} =`);
  
  // Label Kofaktor
  renderFormula('label_c1', `C_{${row}${col}} = (-1)^{${row}+${col}} M_{${row}${col}}`);
  renderFormula('label_c2', `C_{${row}${col}} =`);
}
