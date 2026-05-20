/**
 * Entry point utama aplikasi WhatsApp AI Chatbot.
 * Menjalankan validasi konfigurasi dan memulai koneksi WhatsApp.
 */

import { validateConfig } from './src/config/env.js';
import config from './src/config/env.js';
import logger from './src/utils/logger.js';
import { startWhatsApp } from './src/bot/whatsapp.js';

/**
 * Fungsi utama untuk menjalankan bot.
 * Melakukan validasi konfigurasi, lalu memulai koneksi WhatsApp.
 */
async function main() {
  try {
    // Tampilkan info startup
    logger.info({ botName: config.botName }, 'Memulai WhatsApp AI Chatbot...');

    // Validasi konfigurasi wajib
    validateConfig();

    // Tampilkan konfigurasi aktif (tanpa data sensitif)
    logger.info({
      prefix: config.commandPrefix,
      maxChars: config.maxChars,
      maxReplyChars: config.maxReplyChars,
      whitelistCount: config.allowedNumbers.length,
      authDir: config.baileysAuthDir
    }, 'Konfigurasi dimuat');

    // Mulai koneksi WhatsApp
    await startWhatsApp();

  } catch (error) {
    logger.fatal({ err: error.message }, 'Bot gagal dijalankan');
    process.exit(1);
  }
}

// Tangani error yang tidak tertangkap agar bot tidak crash
process.on('uncaughtException', (error) => {
  logger.fatal({ err: error.message }, 'Uncaught exception - bot tetap berjalan');
});

process.on('unhandledRejection', (reason) => {
  logger.error({ reason: String(reason) }, 'Unhandled promise rejection');
});

// Jalankan bot
main();
