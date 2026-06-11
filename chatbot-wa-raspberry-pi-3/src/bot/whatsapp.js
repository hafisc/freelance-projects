import makeWASocket, {
  DisconnectReason,
  useMultiFileAuthState,
  fetchLatestBaileysVersion
} from '@whiskeysockets/baileys';
import qrcode from 'qrcode-terminal';
import { Boom } from '@hapi/boom';
import pino from 'pino';
import fs from 'fs/promises';
import path from 'path';
import config from '../config/env.js';
import logger from '../utils/logger.js';
import { handleMessagesUpsert } from './handlers.js';

/**
 * Menghapus folder session Baileys secara rekursif.
 * Dipanggil otomatis saat sesi WhatsApp logout / expired
 * agar bot bisa generate QR Code baru tanpa restart manual.
 */
async function clearSessionFolder() {
  const authDir = path.resolve(config.baileysAuthDir);
  try {
    await fs.rm(authDir, { recursive: true, force: true });
    logger.info(`Folder session "${config.baileysAuthDir}" berhasil dihapus.`);
  } catch (err) {
    logger.error(`Gagal menghapus folder session: ${err.message}`);
  }
}

/**
 * Memulai dan memanage koneksi ke WhatsApp menggunakan Baileys.
 * Mengatur loading session, rendering QR Code, auto-reconnect,
 * dan mendaftarkan event handler pesan masuk.
 * 
 * Jika sesi WhatsApp berakhir (logged out / expired), bot akan
 * otomatis menghapus folder session dan generate QR Code baru.
 * 
 * @returns {Promise<object>} Socket client Baileys WhatsApp.
 */
export async function connectToWhatsApp() {
  // Load session dari folder yang didefinisikan di .env
  const { state, saveCreds } = await useMultiFileAuthState(config.baileysAuthDir);
  
  // Mengambil versi WhatsApp Web terbaru yang didukung Baileys
  const { version, isLatest } = await fetchLatestBaileysVersion();
  
  logger.info(`Menginisialisasi WhatsApp Bot menggunakan Baileys v${version.join('.')}`, {
    isLatestVersion: isLatest
  });

  // Membuat instance socket Baileys
  const sock = makeWASocket({
    version,
    auth: state,
    printQRInTerminal: false, // Dinonaktifkan agar rendering manual via qrcode-terminal lebih rapi
    logger: pino({ level: 'fatal' }) // Mencegah spam log internal Baileys di terminal
  });

  // Menyimpan kredensial session setiap kali ada pembaruan
  sock.ev.on('creds.update', saveCreds);

  // Menangani pembaruan status koneksi
  sock.ev.on('connection.update', async (update) => {
    const { connection, lastDisconnect, qr } = update;

    // Menampilkan QR Code jika terdeteksi meminta otorisasi baru
    if (qr) {
      logger.info('QR Code didapatkan. Silakan scan melalui menu Perangkat Tertaut / Linked Devices di WhatsApp Anda:');
      qrcode.generate(qr, { small: true });
    }

    // Menangani koneksi yang ditutup
    if (connection === 'close') {
      const statusCode = (lastDisconnect?.error instanceof Boom)
        ? lastDisconnect.error.output?.statusCode
        : null;

      // Reconnect jika bukan karena sengaja logout dari HP
      const shouldReconnect = statusCode !== DisconnectReason.loggedOut;

      logger.warn('Koneksi WhatsApp terputus.', {
        reason: lastDisconnect?.error?.message || lastDisconnect?.error,
        statusCode,
        shouldReconnect
      });

      if (shouldReconnect) {
        // Koneksi terputus sementara (network issue, dsb.) — reconnect biasa
        logger.info('Mencoba menyambungkan kembali ke WhatsApp dalam 5 detik...');
        setTimeout(() => connectToWhatsApp(), 5000);
      } else {
        // Sesi berakhir (logged out / expired) — otomatis hapus session & generate QR baru
        logger.warn('Sesi WhatsApp telah berakhir (Logged Out / Expired).');
        logger.info('Menghapus folder session dan menyiapkan QR Code baru...');
        await clearSessionFolder();
        logger.info('Memulai ulang koneksi dalam 5 detik untuk generate QR Code baru...');
        setTimeout(() => connectToWhatsApp(), 5000);
      }
    } 
    // Menangani koneksi berhasil dibuka
    else if (connection === 'open') {
      logger.info(`Chatbot WhatsApp "${config.botName}" berhasil TERHUBUNG dan SIAP digunakan!`);
    }
  });

  // Menangani event pesan masuk
  sock.ev.on('messages.upsert', async (m) => {
    await handleMessagesUpsert(sock, m);
  });

  return sock;
}

export default {
  connectToWhatsApp
};
