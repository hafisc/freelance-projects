/**
 * Modul koneksi WhatsApp menggunakan Baileys.
 * Menangani: koneksi, QR code, session persistence, dan auto-reconnect.
 */

import {
  makeWASocket,
  useMultiFileAuthState,
  DisconnectReason,
  makeCacheableSignalKeyStore,
  fetchLatestBaileysVersion
} from '@whiskeysockets/baileys';
import { Boom } from '@hapi/boom';
import qrcodeTerminal from 'qrcode-terminal';
import pino from 'pino';
import config from '../config/env.js';
import logger from '../utils/logger.js';
import { handleIncomingMessage } from './handlers.js';
import {
  RECONNECT_DELAY_MS,
  MAX_RECONNECT_ATTEMPTS,
  MAX_QR_REFRESH
} from '../constants/app.constant.js';

// Counter untuk percobaan reconnect dan refresh QR
let reconnectAttempts = 0;
let qrRefreshCount = 0;

/**
 * Inisialisasi dan jalankan koneksi WhatsApp.
 * Menggunakan useMultiFileAuthState untuk menyimpan session.
 * Menampilkan QR code di terminal jika belum terautentikasi.
 */
export async function startWhatsApp() {
  // Muat state autentikasi dari folder yang dikonfigurasi
  const { state, saveCreds } = await useMultiFileAuthState(config.baileysAuthDir);

  // Ambil versi WhatsApp Web terbaru (fix untuk error 405)
  const { version } = await fetchLatestBaileysVersion();
  logger.info({ version }, 'Menggunakan versi WhatsApp Web');

  // Buat logger khusus untuk Baileys (silent agar tidak terlalu verbose)
  const baileysLogger = pino({ level: 'silent' });

  // Buat instance socket WhatsApp
  const sock = makeWASocket({
    auth: {
      creds: state.creds,
      keys: makeCacheableSignalKeyStore(state.keys, baileysLogger)
    },
    version,
    logger: baileysLogger,
    browser: ['Ubuntu', 'Chrome', '20.0.04'],
    connectTimeoutMs: 60000,
    defaultQueryTimeoutMs: 0,
    keepAliveIntervalMs: 25000,
    markOnlineOnConnect: true
  });

  // Event: Connection update (QR, open, close)
  sock.ev.on('connection.update', async (update) => {
    const { connection, lastDisconnect, qr } = update;

    // Tampilkan QR code di terminal
    if (qr) {
      qrRefreshCount++;

      // Cek apakah sudah melebihi batas refresh QR
      if (qrRefreshCount > MAX_QR_REFRESH) {
        logger.error('QR code sudah di-refresh terlalu banyak kali. Sesi pairing expired.');
        logger.info('Silakan restart bot untuk mendapatkan QR baru.');
        process.exit(1);
        return;
      }

      // Reset reconnect counter saat QR muncul (berarti koneksi ke server berhasil)
      reconnectAttempts = 0;

      logger.info(`QR code muncul (refresh ke-${qrRefreshCount}/${MAX_QR_REFRESH}). Silakan scan dari WhatsApp > Linked Devices.`);
      qrcodeTerminal.generate(qr, { small: true });
    }

    // Koneksi berhasil terhubung
    if (connection === 'open') {
      reconnectAttempts = 0; // Reset counter reconnect
      qrRefreshCount = 0; // Reset counter QR

      // Masking nomor telepon untuk keamanan log
      const phoneNumber = sock.user?.id?.split(':')[0] || 'unknown';
      const maskedNumber = phoneNumber.length > 4
        ? '****' + phoneNumber.slice(-4)
        : phoneNumber;

      logger.info({ user: maskedNumber }, 'WhatsApp bot berhasil terhubung');
    }

    // Koneksi terputus
    if (connection === 'close') {
      const error = lastDisconnect?.error;
      const statusCode = new Boom(error)?.output?.statusCode;
      const shouldReconnect = statusCode !== DisconnectReason.loggedOut;

      logger.warn({ statusCode, shouldReconnect }, 'Koneksi WhatsApp terputus');

      if (shouldReconnect) {
        // Koneksi terputus sementara - coba reconnect
        reconnectAttempts++;

        if (reconnectAttempts <= MAX_RECONNECT_ATTEMPTS) {
          // Exponential backoff: 3s, 6s, 12s, 24s, 48s
          const backoffDelay = RECONNECT_DELAY_MS * Math.pow(2, reconnectAttempts - 1);

          logger.info(
            { attempt: reconnectAttempts, maxAttempts: MAX_RECONNECT_ATTEMPTS, delayMs: backoffDelay },
            'Mencoba reconnect...'
          );

          // Tunggu sebelum reconnect (exponential backoff)
          await delay(backoffDelay);
          startWhatsApp();
        } else {
          // Sudah melebihi batas reconnect
          logger.fatal('Gagal reconnect setelah maksimal percobaan. Bot dihentikan.');
          logger.info('Kemungkinan penyebab: rate limit WhatsApp, masalah jaringan, atau IP diblokir.');
          logger.info('Tunggu beberapa menit lalu coba lagi dengan: npm start');
          process.exit(1);
        }
      } else {
        // Logout permanen - beri instruksi
        logger.error('WhatsApp logout permanen (device dihapus dari HP).');
        logger.info(`Hapus folder "${config.baileysAuthDir}" dan jalankan ulang bot untuk scan QR baru.`);
        process.exit(1);
      }
    }
  });

  // Event: Simpan credentials saat diupdate
  sock.ev.on('creds.update', saveCreds);

  // Event: Pesan masuk
  sock.ev.on('messages.upsert', async (messageUpdate) => {
    // Hanya proses pesan baru (bukan history sync)
    if (messageUpdate.type !== 'notify') return;

    await handleIncomingMessage(sock, messageUpdate);
  });

  return sock;
}

/**
 * Fungsi delay sederhana.
 *
 * @param {number} ms - Waktu tunggu dalam milidetik
 * @returns {Promise<void>}
 */
function delay(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}
