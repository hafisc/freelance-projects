/**
 * Modul utilitas pesan WhatsApp.
 * Mengambil teks dari berbagai jenis pesan dan memecah balasan panjang.
 */

import config from '../config/env.js';
import { MAX_MESSAGE_SEGMENTS } from '../constants/app.constant.js';

/**
 * Ambil teks dari pesan WhatsApp.
 * Mendukung: conversation, extendedTextMessage, imageMessage caption, videoMessage caption.
 *
 * @param {object} message - Objek pesan dari Baileys
 * @returns {string|null} Teks pesan atau null jika tidak ada
 */
export function extractMessageText(message) {
  if (!message) return null;

  const msg = message.message;
  if (!msg) return null;

  // Conversation biasa
  if (msg.conversation) {
    return msg.conversation;
  }

  // Extended text message (reply, link preview, dll)
  if (msg.extendedTextMessage?.text) {
    return msg.extendedTextMessage.text;
  }

  // Caption gambar
  if (msg.imageMessage?.caption) {
    return msg.imageMessage.caption;
  }

  // Caption video
  if (msg.videoMessage?.caption) {
    return msg.videoMessage.caption;
  }

  return null;
}

/**
 * Pecah teks panjang menjadi beberapa segmen berdasarkan MAX_REPLY_CHARS.
 * Prioritas pemecahan: newline > spasi > hard split.
 *
 * @param {string} text - Teks yang akan dipecah
 * @returns {string[]} Array segmen teks
 */
export function splitLongMessage(text) {
  const maxLen = config.maxReplyChars;

  // Jika teks tidak melebihi batas, kembalikan langsung
  if (text.length <= maxLen) {
    return [text];
  }

  const segments = [];
  let remaining = text;

  while (remaining.length > 0) {
    // Cek batas segmen
    if (segments.length >= MAX_MESSAGE_SEGMENTS) {
      segments.push('⚠️ Balasan terlalu panjang. Sebagian respons tidak dapat ditampilkan.');
      break;
    }

    // Jika sisa teks muat dalam satu segmen
    if (remaining.length <= maxLen) {
      segments.push(remaining);
      break;
    }

    // Cari titik potong terbaik
    let splitIndex = -1;

    // Prioritas 1: Cari newline terakhir dalam batas
    const lastNewline = remaining.lastIndexOf('\n', maxLen);
    if (lastNewline > 0) {
      splitIndex = lastNewline;
    }

    // Prioritas 2: Cari spasi terakhir dalam batas
    if (splitIndex === -1) {
      const lastSpace = remaining.lastIndexOf(' ', maxLen);
      if (lastSpace > 0) {
        splitIndex = lastSpace;
      }
    }

    // Prioritas 3: Hard split di batas karakter
    if (splitIndex === -1) {
      splitIndex = maxLen;
    }

    // Potong dan simpan segmen
    segments.push(remaining.substring(0, splitIndex));
    remaining = remaining.substring(splitIndex).trimStart();
  }

  return segments;
}
