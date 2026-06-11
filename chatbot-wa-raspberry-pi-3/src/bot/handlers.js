import config from '../config/env.js';
import { MESSAGES } from '../constants/app.constant.js';
import { getMessageText, splitMessage } from '../utils/message.js';
import { isWhitelisted } from '../utils/whitelist.js';
import { cleanInput, isEmpty, isValidLength } from '../utils/validation.js';
import { askGroq } from '../services/picoclaw.service.js';
import logger from '../utils/logger.js';

// Map untuk menyimpan daftar user/pengirim yang pertanyaannya sedang diproses
// Key: JID pengirim, Value: boolean
const activeJobs = new Map();

/**
 * Handler utama untuk memproses event pesan WhatsApp masuk.
 * Fungsi ini bertugas memfilter, memvalidasi, dan mengkoordinasikan
 * panggilan ke PicoClaw CLI serta membalas pesan.
 * 
 * @param {object} sock - Socket client Baileys WhatsApp.
 * @param {object} upsert - Event object upsert dari Baileys.
 */
export async function handleMessagesUpsert(sock, upsert) {
  try {
    // Memastikan ada pesan baru yang masuk
    if (!upsert.messages || upsert.messages.length === 0) return;

    for (const message of upsert.messages) {
      // 1. Abaikan jika pesan dikirim oleh bot itu sendiri (fromMe: true)
      if (message.key.fromMe) continue;

      const remoteJid = message.key.remoteJid;
      
      // 2. Abaikan pesan dari status broadcast / siaran story WhatsApp
      if (remoteJid === 'status@broadcast') continue;

      // 3. Pastikan objek message berisi data konten pesan
      if (!message.message) continue;

      // Ekstrak teks pesan
      const rawText = getMessageText(message.message);
      const cleanedText = cleanInput(rawText);

      // 4. Periksa apakah pesan menggunakan command prefix (default: !ai)
      const prefix = config.commandPrefix;
      const lowerText = cleanedText.toLowerCase();
      
      if (!lowerText.startsWith(prefix.toLowerCase())) {
        // Abaikan jika tidak diawali prefix
        continue;
      }

      // Ambil JID pengirim yang sebenarnya (mendukung chat pribadi dan grup)
      const senderJid = message.key.participant || message.participant || remoteJid;

      // 5. Validasi Whitelist Nomor
      if (!isWhitelisted(senderJid)) {
        logger.warn(`Pesan dari ${senderJid} diabaikan karena tidak ada di whitelist.`);
        continue;
      }

      // Ekstrak pertanyaan setelah prefix
      const question = cleanInput(cleanedText.slice(prefix.length));

      // 6. Validasi jika pertanyaan kosong
      if (isEmpty(question)) {
        logger.info(`User ${senderJid} mengirim command kosong.`);
        await sock.sendMessage(remoteJid, { text: MESSAGES.USAGE(prefix) }, { quoted: message });
        continue;
      }

      // 7. Validasi panjang karakter input
      if (!isValidLength(question, config.maxChars)) {
        logger.warn(`Pertanyaan dari ${senderJid} melebihi batas maksimal karakter.`);
        await sock.sendMessage(remoteJid, { text: MESSAGES.INPUT_TOO_LONG(config.maxChars) }, { quoted: message });
        continue;
      }

      // 8. Cek dan hindari Request Dobel (Active Job) per user
      if (activeJobs.has(senderJid)) {
        logger.warn(`User ${senderJid} mengirim request baru ketika request sebelumnya masih diproses.`);
        await sock.sendMessage(remoteJid, { text: MESSAGES.BUSY }, { quoted: message });
        continue;
      }

      // Tandai user sedang memiliki proses aktif
      activeJobs.set(senderJid, true);

      try {
        logger.info(`Memproses pertanyaan dari ${senderJid}: "${question.substring(0, 50)}${question.length > 50 ? '...' : ''}"`);
        
        // 9. Kirim status typing/composing ke WhatsApp chat
        await sock.sendPresenceUpdate('composing', remoteJid);

        // 10. Hubungi Groq API
        const aiResponse = await askGroq(question);

        // 11. Potong balasan jika terlalu panjang
        const replyChunks = splitMessage(aiResponse, config.maxReplyChars);

        // 12. Kirim balasan kembali ke WhatsApp
        for (const chunk of replyChunks) {
          await sock.sendMessage(remoteJid, { text: chunk }, { quoted: message });
        }

      } catch (err) {
        logger.error(`Gagal memproses pesan untuk ${senderJid}:`, err);
        // Kirim pesan error umum tanpa membocorkan detail teknis demi keamanan
        await sock.sendMessage(remoteJid, { text: MESSAGES.ERROR_AI }, { quoted: message });
      } finally {
        // Hentikan status typing/composing
        await sock.sendPresenceUpdate('paused', remoteJid).catch(() => {});
        // Hapus penanda proses aktif user setelah selesai (baik sukses maupun error)
        activeJobs.delete(senderJid);
      }
    }
  } catch (error) {
    logger.error('Error fatal di dalam handler pesan:', error);
  }
}

export default {
  handleMessagesUpsert
};
