/**
 * Modul whitelist nomor telepon.
 * Mengecek apakah nomor pengirim diizinkan menggunakan bot.
 */

import config from '../config/env.js';
import logger from './logger.js';

/**
 * Cek apakah nomor pengirim ada di whitelist.
 * Jika ALLOWED_NUMBERS kosong, semua nomor diizinkan (mode testing).
 * Format nomor: internasional tanpa tanda plus, contoh: 6281234567890
 *
 * @param {string} senderNumber - Nomor pengirim (format: 6281234567890)
 * @returns {boolean} true jika diizinkan, false jika ditolak
 */
export function isNumberAllowed(senderNumber) {
  // Jika whitelist kosong, izinkan semua (mode testing)
  if (config.allowedNumbers.length === 0) {
    return true;
  }

  // Bersihkan nomor pengirim dari suffix @s.whatsapp.net
  const cleanNumber = senderNumber.replace('@s.whatsapp.net', '');

  // Cek apakah nomor ada di whitelist
  const allowed = config.allowedNumbers.includes(cleanNumber);

  if (!allowed) {
    logger.debug({ chatType: 'private' }, 'Nomor tidak ada di whitelist, pesan diabaikan');
  }

  return allowed;
}
