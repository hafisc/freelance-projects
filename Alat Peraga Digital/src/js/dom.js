/**
 * Mengambil elemen DOM berdasarkan selector.
 * @param {string} selector - Selector CSS untuk elemen.
 * @returns {HTMLElement|null}
 */
export function getElement(selector) {
  return document.querySelector(selector);
}

/**
 * Mengambil nilai integer dari input. Jika kosong atau tidak valid, default ke 0.
 * @param {string} id - ID element input.
 * @returns {number}
 */
export function getInputValue(id) {
  const el = document.getElementById(id);
  if (!el) return 0;
  const val = parseInt(el.value);
  return isNaN(val) ? 0 : val;
}

/**
 * Mengatur kelas status (correct atau wrong) pada elemen input jawaban.
 * @param {HTMLInputElement} input - Elemen input.
 * @param {'correct' | 'wrong' | 'reset'} status - Status validasi.
 */
export function setInputState(input, status) {
  if (!input) return;
  input.classList.remove('correct', 'wrong');
  if (status === 'correct') {
    input.classList.add('correct');
  } else if (status === 'wrong') {
    input.classList.add('wrong');
  }
}

/**
 * Mengosongkan semua kolom input jawaban manual dan menghapus status validasi.
 */
export function resetManualInputs() {
  const inputs = document.querySelectorAll('.math-input');
  inputs.forEach(inp => {
    inp.value = '';
    inp.classList.remove('correct', 'wrong');
  });
  
  const feedback = document.getElementById('feedback');
  if (feedback) {
    feedback.innerHTML = '';
  }
}
