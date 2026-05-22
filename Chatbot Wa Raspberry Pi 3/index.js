import { connectToWhatsApp } from './src/bot/whatsapp.js';
import logger from './src/utils/logger.js';
import config from './src/config/env.js';

/**
 * Entry point utama untuk menjalankan AI WhatsApp Chatbot.
 * Fungsi ini bertugas memuat seluruh konfigurasi, menyambungkan bot,
 * dan menangani error fatal tingkat proses agar aplikasi tidak crash diam-diam.
 */
async function startApp() {
  try {
    logger.info('Memulai aplikasi AI Chatbot WhatsApp...');
    logger.info(`Nama Bot: ${config.botName}`);
    logger.info(`Prefix: ${config.commandPrefix}`);
    logger.info(`Whitelist Jumlah Nomor: ${config.allowedNumbers.length}`);

    // Menghubungkan ke WhatsApp
    await connectToWhatsApp();

  } catch (error) {
    logger.error('Gagal menjalankan aplikasi Chatbot:', error);
    process.exit(1);
  }
}

// Menangani error unhandled rejection (promise terabaikan)
process.on('unhandledRejection', (reason, promise) => {
  logger.error('Terjadi Unhandled Rejection di level proses:', reason);
});

// Menangani error uncaught exception (error tak tertangkap)
process.on('uncaughtException', (error) => {
  logger.error('Terjadi Uncaught Exception di level proses:', error);
  // Memberikan jeda singkat agar log pino sempat ditulis ke console/file sebelum shutdown
  setTimeout(() => {
    process.exit(1);
  }, 1000);
});

// Memulai aplikasi
startApp();
