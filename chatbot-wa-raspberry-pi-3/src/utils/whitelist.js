import config from '../config/env.js';

/**
 * Mengambil nomor pengirim dari JID WhatsApp.
 * Fungsi ini dipakai untuk mencocokkan nomor dengan whitelist.
 * 
 * @param {string} jid - JID pengirim WhatsApp (contoh: '6281234567890@s.whatsapp.net').
 * @returns {string} Nomor telepon bersih tanpa domain JID.
 */
export function getSenderNumber(jid = '') {
  if (!jid) return '';
  return jid.split('@')[0].split(':')[0];
}

/**
 * Memeriksa apakah nomor pengirim terdaftar di dalam whitelist.
 * Jika whitelist kosong, maka semua nomor diperbolehkan (untuk testing).
 * 
 * @param {string} jid - JID pengirim WhatsApp.
 * @returns {boolean} True jika diperbolehkan, false jika tidak.
 */
export function isWhitelisted(jid) {
  // Jika whitelist kosong, maka semua nomor diperbolehkan
  if (!config.allowedNumbers || config.allowedNumbers.length === 0) {
    return true;
  }
  const senderNumber = getSenderNumber(jid);
  return config.allowedNumbers.includes(senderNumber);
}

export default {
  getSenderNumber,
  isWhitelisted
};
