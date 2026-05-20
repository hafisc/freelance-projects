/**
 * Modul konfigurasi environment.
 * Membaca dan memvalidasi semua variabel dari file .env.
 */

import dotenv from 'dotenv';
import {
  DEFAULT_COMMAND_PREFIX,
  DEFAULT_MAX_CHARS,
  DEFAULT_MAX_REPLY_CHARS,
  DEFAULT_PICOCLAW_BIN,
  DEFAULT_BAILEYS_AUTH_DIR,
  DEFAULT_BOT_NAME,
  DEFAULT_LOG_LEVEL,
  DEFAULT_PICOCLAW_TIMEOUT_MS
} from '../constants/app.constant.js';

// Muat file .env ke process.env
dotenv.config();

/**
 * Validasi level logging yang diizinkan.
 * Jika tidak valid, gunakan default 'info'.
 */
const VALID_LOG_LEVELS = ['fatal', 'error', 'warn', 'info', 'debug', 'trace'];

function getLogLevel(value) {
  if (value && VALID_LOG_LEVELS.includes(value.toLowerCase())) {
    return value.toLowerCase();
  }
  return DEFAULT_LOG_LEVEL;
}

/**
 * Objek konfigurasi utama aplikasi.
 * Semua konfigurasi dibaca dari environment variable dengan fallback ke default.
 */
const config = {
  // Prefix command untuk trigger bot
  commandPrefix: process.env.COMMAND_PREFIX || DEFAULT_COMMAND_PREFIX,

  // Batas karakter input user
  maxChars: parseInt(process.env.MAX_CHARS, 10) || DEFAULT_MAX_CHARS,

  // Batas karakter balasan per segmen
  maxReplyChars: parseInt(process.env.MAX_REPLY_CHARS, 10) || DEFAULT_MAX_REPLY_CHARS,

  // Path binary PicoClaw
  picoClawBin: process.env.PICOCLAW_BIN || DEFAULT_PICOCLAW_BIN,

  // Folder session WhatsApp
  baileysAuthDir: process.env.BAILEYS_AUTH_DIR || DEFAULT_BAILEYS_AUTH_DIR,

  // Daftar nomor yang diizinkan (array)
  allowedNumbers: process.env.ALLOWED_NUMBERS
    ? process.env.ALLOWED_NUMBERS.split(',').map(n => n.trim()).filter(Boolean)
    : [],

  // Nama bot
  botName: process.env.BOT_NAME || DEFAULT_BOT_NAME,

  // Level logging
  logLevel: getLogLevel(process.env.LOG_LEVEL),

  // Timeout PicoClaw dalam milidetik
  picoClawTimeoutMs: parseInt(process.env.PICOCLAW_TIMEOUT_MS, 10) || DEFAULT_PICOCLAW_TIMEOUT_MS
};

/**
 * Validasi konfigurasi wajib saat startup.
 * Jika ada yang kosong, tampilkan error dan keluar.
 */
export function validateConfig() {
  const missing = [];

  if (!config.picoClawBin) {
    missing.push('PICOCLAW_BIN');
  }

  if (missing.length > 0) {
    console.error(`[ERROR] Konfigurasi wajib tidak ditemukan: ${missing.join(', ')}`);
    console.error('[ERROR] Pastikan file .env sudah dibuat dari .env.example');
    process.exit(1);
  }
}

export default config;
