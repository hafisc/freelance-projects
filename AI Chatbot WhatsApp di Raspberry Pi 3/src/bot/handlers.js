/**
 * Handler pesan WhatsApp.
 * Memproses pesan masuk, validasi, dan mengirim ke AI.
 */

import config from '../config/env.js';
import logger from '../utils/logger.js';
import { extractMessageText, splitLongMessage } from '../utils/message.js';
import { isNumberAllowed } from '../utils/whitelist.js';
import { validateInputLength, sanitizeInput } from '../utils/validation.js';
import { askPicoClaw } from '../services/picoclaw.service.js';
import {
  MESSAGE_SPLIT_DELAY_MS,
  ACTIVE_JOB_SAFETY_MARGIN_MS
} from '../constants/app.constant.js';

// Map untuk tracking active job per user (anti-spam)
const activeJobs = new Map();

/**
 * Handler utama saat menerima pesan baru dari WhatsApp.
 * Memfilter pesan, validasi whitelist, cek prefix, dan proses AI.
 *
 * @param {object} sock - Instance socket Baileys
 * @param {object} messageUpdate - Event messages.upsert dari Baileys
 */
export async function handleIncomingMessage(sock, messageUpdate) {
  try {
    const { messages } = messageUpdate;

    for (const message of messages) {
      // Abaikan pesan dari diri sendiri
      if (message.key.fromMe) continue;

      // Abaikan status broadcast
      if (message.key.remoteJid === 'status@broadcast') continue;

      // Ambil teks dari pesan
      const text = extractMessageText(message);

      // Abaikan pesan kosong
      if (!text) continue;

      // Ambil ID chat dan nomor pengirim
      const chatId = message.key.remoteJid;
      const senderNumber = chatId.replace('@s.whatsapp.net', '');

      // Cek whitelist nomor
      if (!isNumberAllowed(chatId)) continue;

      // Cek apakah pesan diawali command prefix
      if (!text.startsWith(config.commandPrefix)) continue;

      // Log pesan masuk dengan prefix (tanpa isi pesan lengkap)
      logger.info({ chatType: chatId.includes('@g.us') ? 'group' : 'private', msgLength: text.length }, 'Pesan masuk dengan prefix command');

      // Ambil pertanyaan setelah prefix
      const query = text.slice(config.commandPrefix.length).trim();

      // Jika pertanyaan kosong, kirim petunjuk penggunaan
      if (!query) {
        await sock.sendMessage(chatId, {
          text: `📖 *Cara penggunaan:*\n\n${config.commandPrefix} <pertanyaan>\n\nContoh:\n${config.commandPrefix} jelaskan apa itu preventive maintenance`
        });
        continue;
      }

      // Cek anti-spam: apakah user masih punya active job
      if (activeJobs.has(senderNumber)) {
        await sock.sendMessage(chatId, {
          text: '⏳ Mohon tunggu, pertanyaan sebelumnya masih diproses.'
        });
        continue;
      }

      // Validasi panjang input
      const validation = validateInputLength(text);
      if (!validation.valid) {
        await sock.sendMessage(chatId, {
          text: `⚠️ Pesan terlalu panjang (${validation.length}/${validation.maxChars} karakter). Silakan persingkat pertanyaan Anda.`
        });
        continue;
      }

      // Proses pertanyaan AI
      await processAIQuery(sock, chatId, senderNumber, query);
    }
  } catch (error) {
    logger.error({ err: error.message }, 'Error saat memproses pesan masuk');
  }
}

/**
 * Proses pertanyaan AI: set active job, kirim ke PicoClaw, kirim balasan.
 *
 * @param {object} sock - Instance socket Baileys
 * @param {string} chatId - ID chat WhatsApp
 * @param {string} senderNumber - Nomor pengirim
 * @param {string} query - Pertanyaan user
 */
async function processAIQuery(sock, chatId, senderNumber, query) {
  // Tandai user sebagai sedang diproses (anti-spam)
  activeJobs.set(senderNumber, Date.now());

  // Safety-net: hapus active job jika melebihi timeout + margin
  const safetyTimeout = setTimeout(() => {
    activeJobs.delete(senderNumber);
  }, config.picoClawTimeoutMs + ACTIVE_JOB_SAFETY_MARGIN_MS);

  try {
    // Kirim status composing (sedang mengetik)
    await sock.presenceSubscribe(chatId);
    await sock.sendPresenceUpdate('composing', chatId);

    // Sanitasi input user
    const sanitizedQuery = sanitizeInput(query);

    // Kirim ke PicoClaw CLI
    const result = await askPicoClaw(sanitizedQuery);

    // Hentikan status composing
    await sock.sendPresenceUpdate('paused', chatId);

    // Kirim balasan ke WhatsApp
    if (result.success) {
      // Pecah pesan jika terlalu panjang
      const segments = splitLongMessage(result.response);

      for (let i = 0; i < segments.length; i++) {
        await sock.sendMessage(chatId, { text: segments[i] });

        // Delay antar segmen (kecuali segmen terakhir)
        if (i < segments.length - 1) {
          await delay(MESSAGE_SPLIT_DELAY_MS);
        }
      }
    } else {
      // Kirim pesan error
      await sock.sendMessage(chatId, { text: result.response });
    }

  } catch (error) {
    logger.error({ err: error.message }, 'Error saat memproses query AI');

    // Hentikan composing jika error
    try {
      await sock.sendPresenceUpdate('paused', chatId);
    } catch (_) { /* abaikan error presence */ }

    // Kirim pesan error ke user
    try {
      await sock.sendMessage(chatId, {
        text: '⚠️ Maaf, terjadi kesalahan saat memproses pertanyaan. Silakan coba lagi.'
      });
    } catch (_) { /* abaikan jika gagal kirim */ }

  } finally {
    // Hapus active job dan clear safety timeout
    activeJobs.delete(senderNumber);
    clearTimeout(safetyTimeout);
  }
}

/**
 * Fungsi delay sederhana menggunakan Promise.
 *
 * @param {number} ms - Waktu tunggu dalam milidetik
 * @returns {Promise<void>}
 */
function delay(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}
