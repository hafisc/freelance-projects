/**
 * Konstanta Pesan Standar Bot
 * Berisi template pesan balasan untuk berbagai kondisi interaksi dengan pengguna.
 */
export const MESSAGES = {
  // Pesan jika PicoClaw CLI gagal memproses AI (error/timeout)
  ERROR_AI: 'Maaf, terjadi kendala saat menghubungi AI. Coba lagi beberapa saat.',

  // Pesan jika user mengirimkan pertanyaan baru saat pertanyaan sebelumnya masih diproses
  BUSY: 'Mohon tunggu, pertanyaan sebelumnya masih diproses.',

  // Pesan petunjuk penggunaan jika user hanya mengirim command prefix saja tanpa pertanyaan
  USAGE: (prefix) => `Ketik pertanyaan setelah ${prefix}.\n\nContoh:\n${prefix} buat checklist maintenance panel listrik`,

  // Pesan jika input user melebihi kapasitas maksimal karakter (MAX_CHARS)
  INPUT_TOO_LONG: (maxChars) => `Maaf, pertanyaan Anda terlalu panjang. Maksimal ${maxChars} karakter.`
};

/**
 * Status Koneksi WhatsApp
 * Digunakan untuk identifikasi state koneksi Baileys
 */
export const CONNECTION_STATUS = {
  CONNECTING: 'menghubungkan',
  CONNECTED: 'terhubung',
  DISCONNECTED: 'terputus'
};
