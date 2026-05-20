/**
 * Modul validasi input user.
 * Memvalidasi panjang pesan dan membersihkan input dari karakter berbahaya.
 */

import config from '../config/env.js';

/**
 * Cek apakah panjang pesan melebihi batas MAX_CHARS.
 *
 * @param {string} text - Teks pesan lengkap
 * @returns {{ valid: boolean, length: number, maxChars: number }}
 */
export function validateInputLength(text) {
  const length = text.length;
  return {
    valid: length <= config.maxChars,
    length,
    maxChars: config.maxChars
  };
}

/**
 * Bersihkan input user dari karakter shell metacharacter yang berbahaya.
 * Ini untuk keamanan tambahan sebelum dikirim ke PicoClaw CLI.
 * Tidak menghapus karakter umum yang diperlukan untuk pertanyaan normal.
 *
 * @param {string} input - Input mentah dari user
 * @returns {string} Input yang sudah dibersihkan
 */
export function sanitizeInput(input) {
  // Hapus karakter null byte
  let cleaned = input.replace(/\0/g, '');

  // Trim whitespace di awal dan akhir
  cleaned = cleaned.trim();

  return cleaned;
}
