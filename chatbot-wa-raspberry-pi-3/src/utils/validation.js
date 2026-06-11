/**
 * Membersihkan input teks dari spasi kosong di awal dan akhir.
 * 
 * @param {string} text - Teks mentah dari user.
 * @returns {string} Teks yang sudah dibersihkan.
 */
export function cleanInput(text = '') {
  if (typeof text !== 'string') return '';
  return text.trim();
}

/**
 * Memeriksa apakah input kosong.
 * 
 * @param {string} text - Teks yang akan dicek.
 * @returns {boolean} True jika kosong, false jika terisi.
 */
export function isEmpty(text = '') {
  return cleanInput(text).length === 0;
}

/**
 * Validasi panjang karakter input agar tidak melebihi kapasitas maksimal.
 * 
 * @param {string} text - Teks yang akan divalidasi.
 * @param {number} maxChars - Batas maksimal karakter.
 * @returns {boolean} True jika panjang teks valid, false jika melebihi batas.
 */
export function isValidLength(text = '', maxChars = 1500) {
  return cleanInput(text).length <= maxChars;
}

export default {
  cleanInput,
  isEmpty,
  isValidLength
};
