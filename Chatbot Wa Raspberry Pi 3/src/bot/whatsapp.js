import makeWASocket, {
  DisconnectReason,
  useMultiFileAuthState,
  fetchLatestBaileysVersion
} from '@whiskeysockets/baileys';
import qrcode from 'qrcode-terminal';
import { Boom } from '@hapi/boom';
import pino from 'pino';
import config from '../config/env.js';
import logger from '../utils/logger.js';
import { handleMessagesUpsert } from './handlers.js';

/**
 * Memulai dan memanage koneksi ke WhatsApp menggunakan Baileys.
 * Mengatur loading session, rendering QR Code, auto-reconnect,
 * dan mendaftarkan event handler pesan masuk.
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
        logger.info('Mencoba menyambungkan kembali ke WhatsApp dalam 5 detik...');
        setTimeout(() => connectToWhatsApp(), 5000);
      } else {
        logger.error('Sesi WhatsApp telah berakhir (Logged Out / Keluar).');
        logger.error(`Untuk menautkan kembali, harap hapus folder session: "${config.baileysAuthDir}" lalu restart bot.`);
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
