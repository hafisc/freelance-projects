import { setInputState } from './dom.js';

/**
 * Memeriksa seluruh jawaban manual user dengan kunci jawaban yang benar.
 * Memberikan feedback warna hijau pada kolom input yang benar dan merah jika salah.
 * Menampilkan pesan feedback interaktif di bawah tombol Cek Jawaban.
 * 
 * @param {Object} correctData - Kunci jawaban yang dihitung sistem.
 * @returns {boolean} True jika semua jawaban benar.
 */
export function checkUserAnswers(correctData) {
  if (!correctData || Object.keys(correctData).length === 0) {
    console.warn("Kunci jawaban tidak tersedia. Jalankan proses tutup baris/kolom terlebih dahulu.");
    return false;
  }

  // 1. Ambil elemen input DOM
  const inputs = {
    m11: document.getElementById('inp_m11'),
    m12: document.getElementById('inp_m12'),
    m21: document.getElementById('inp_m21'),
    m22: document.getElementById('inp_m22'),
    a: document.getElementById('inp_a'),
    d: document.getElementById('inp_d'),
    b: document.getElementById('inp_b'),
    c: document.getElementById('inp_c'),
    minor: document.getElementById('inp_minor'),
    cofactor: document.getElementById('inp_cofaktor')
  };

  // 2. Ambil nilai input dari user (kosong dianggap NaN)
  const userAnswers = {
    m11: parseInt(inputs.m11.value),
    m12: parseInt(inputs.m12.value),
    m21: parseInt(inputs.m21.value),
    m22: parseInt(inputs.m22.value),
    a: parseInt(inputs.a.value),
    d: parseInt(inputs.d.value),
    b: parseInt(inputs.b.value),
    c: parseInt(inputs.c.value),
    minor: parseInt(inputs.minor.value),
    cofactor: parseInt(inputs.cofactor.value)
  };

  let allCorrect = true;

  // Helper untuk memvalidasi satu field
  const validateField = (inputEl, userVal, correctVal) => {
    if (!isNaN(userVal) && userVal === correctVal) {
      setInputState(inputEl, 'correct');
    } else {
      setInputState(inputEl, 'wrong');
      allCorrect = false;
    }
  };

  // 3. Validasi Matriks Sisa 2x2
  validateField(inputs.m11, userAnswers.m11, correctData.m11);
  validateField(inputs.m12, userAnswers.m12, correctData.m12);
  validateField(inputs.m21, userAnswers.m21, correctData.m21);
  validateField(inputs.m22, userAnswers.m22, correctData.m22);

  // 4. Validasi Komponen Perkalian Determinant (a*d - b*c)
  // Kita beri fleksibilitas posisi jika murid menukar letak perkalian, 
  // namun untuk media alat peraga MAMITOR ini disesuaikan dengan posisi visualnya.
  validateField(inputs.a, userAnswers.a, correctData.mul_a);
  validateField(inputs.d, userAnswers.d, correctData.mul_d);
  validateField(inputs.b, userAnswers.b, correctData.mul_b);
  validateField(inputs.c, userAnswers.c, correctData.mul_c);

  // 5. Validasi Hasil Akhir Minor & Kofaktor
  validateField(inputs.minor, userAnswers.minor, correctData.minor);
  validateField(inputs.cofactor, userAnswers.cofactor, correctData.cofactor);

  // 6. Tampilkan pesan feedback dengan style yang premium
  const feedbackEl = document.getElementById('feedback');
  if (feedbackEl) {
    if (allCorrect) {
      feedbackEl.style.color = 'var(--highlight)';
      feedbackEl.innerHTML = `
        <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid var(--highlight); padding: 12px; border-radius: 10px; width: 100%;">
          🎉 Luar biasa! Semua jawaban kamu benar!
        </div>
      `;
    } else {
      feedbackEl.style.color = 'var(--accent)';
      feedbackEl.innerHTML = `
        <div style="background: rgba(244, 63, 94, 0.1); border: 1px solid var(--accent); padding: 12px; border-radius: 10px; width: 100%;">
          ❌ Ada jawaban yang masih salah atau kosong. Coba cek kembali ya!
        </div>
      `;
    }
  }

  return allCorrect;
}
