/**
 * Mengekstrak teks dari objek pesan Baileys.
 * Fungsi ini menangani berbagai tipe pesan WhatsApp (teks biasa, extended, caption gambar/video, dll).
 * 
 * @param {object} msg - Objek pesan dari Baileys (biasanya message.message atau webMessageInfo.message)
 * @returns {string} Teks pesan yang berhasil diekstrak atau string kosong.
 */
export function getMessageText(msg) {
  if (!msg) return '';

  let messageContent = msg;

  // Unpack jika dibungkus di dalam format ephemeral atau view once
  if (msg.ephemeralMessage?.message) {
    messageContent = msg.ephemeralMessage.message;
  }
  if (messageContent.viewOnceMessage?.message) {
    messageContent = messageContent.viewOnceMessage.message;
  }
  if (messageContent.viewOnceMessageV2?.message) {
    messageContent = messageContent.viewOnceMessageV2.message;
  }
  if (messageContent.documentWithCaptionMessage?.message) {
    messageContent = messageContent.documentWithCaptionMessage.message;
  }

  // Mengambil teks berdasarkan tipe pesan
  if (messageContent.conversation) {
    return messageContent.conversation;
  }
  if (messageContent.extendedTextMessage?.text) {
    return messageContent.extendedTextMessage.text;
  }
  if (messageContent.imageMessage?.caption) {
    return messageContent.imageMessage.caption;
  }
  if (messageContent.videoMessage?.caption) {
    return messageContent.videoMessage.caption;
  }
  if (messageContent.documentMessage?.caption) {
    return messageContent.documentMessage.caption;
  }

  return '';
}

/**
 * Memecah teks pesan yang terlalu panjang menjadi beberapa bagian.
 * Hal ini dilakukan agar pesan mematuhi batasan panjang pesan WhatsApp/PicoClaw.
 * 
 * @param {string} text - Teks panjang yang ingin dipecah.
 * @param {number} maxChars - Batas maksimal karakter per pesan.
 * @returns {string[]} Array berisi potongan teks.
 */
export function splitMessage(text, maxChars) {
  if (!text) return [];
  if (text.length <= maxChars) return [text];

  const chunks = [];
  let currentChunk = '';

  // Memecah berdasarkan baris agar pemotongan terlihat natural
  const lines = text.split('\n');

  for (const line of lines) {
    // Jika satu baris saja sudah melebihi batas maksimal, kita potong paksa per karakter
    if (line.length > maxChars) {
      if (currentChunk.trim() !== '') {
        chunks.push(currentChunk.trim());
        currentChunk = '';
      }

      let tempLine = line;
      while (tempLine.length > maxChars) {
        chunks.push(tempLine.slice(0, maxChars));
        tempLine = tempLine.slice(maxChars);
      }
      currentChunk = tempLine + '\n';
    } 
    // Jika ditambahkan baris baru melebihi batas, simpan chunk yang ada lalu buat baru
    else if ((currentChunk + line + '\n').length > maxChars) {
      if (currentChunk.trim() !== '') {
        chunks.push(currentChunk.trim());
      }
      currentChunk = line + '\n';
    } 
    // Tambahkan baris ke chunk saat ini
    else {
      currentChunk += line + '\n';
    }
  }

  if (currentChunk.trim() !== '') {
    chunks.push(currentChunk.trim());
  }

  return chunks;
}

export default {
  getMessageText,
  splitMessage
};
