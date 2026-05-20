/**
 * Modul logger menggunakan pino.
 * Logger terstruktur dengan level yang bisa dikonfigurasi via .env.
 * Tidak menampilkan data sensitif (API key, nomor telepon, isi pesan).
 */

import pino from 'pino';
import config from '../config/env.js';

// Buat instance logger dengan konfigurasi dari environment
const logger = pino({
  level: config.logLevel,
  transport: {
    target: 'pino/file',
    options: { destination: 1 } // stdout
  },
  formatters: {
    level(label) {
      return { level: label };
    }
  },
  timestamp: pino.stdTimeFunctions.isoTime
});

export default logger;
