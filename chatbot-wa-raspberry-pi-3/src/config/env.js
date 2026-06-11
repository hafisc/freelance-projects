import dotenv from 'dotenv';

// Mengisi process.env dengan variabel dari file .env
dotenv.config();

/**
 * Memecah string nomor whitelist menjadi array.
 * @param {string} rawNumbers - String mentah dari ALLOWED_NUMBERS.
 * @returns {string[]} Array berisi nomor yang diperbolehkan.
 */
function parseAllowedNumbers(rawNumbers) {
  if (!rawNumbers || rawNumbers.trim() === '') {
    return [];
  }
  return rawNumbers.split(',').map(num => num.trim()).filter(num => num.length > 0);
}

/**
 * Konfigurasi Global Aplikasi
 * Berisi konfigurasi yang dibaca dari variabel environment (.env)
 * dengan default value yang aman.
 */
export const config = {
  // Command prefix untuk memicu respons bot, default '!ai'
  commandPrefix: process.env.COMMAND_PREFIX || '!ai',

  // Batas maksimal karakter input dari user untuk dikirim ke AI, default 1500
  maxChars: parseInt(process.env.MAX_CHARS || '1500', 10),

  // Batas maksimal karakter balasan dari AI sebelum dipecah, default 3500
  maxReplyChars: parseInt(process.env.MAX_REPLY_CHARS || '3500', 10),

  // API Key Groq untuk pemrosesan AI
  groqApiKey: process.env.GROQ_API_KEY || '',

  // Model Groq yang digunakan, default 'llama-3.3-70b-versatile'
  groqModel: process.env.GROQ_MODEL || 'llama-3.3-70b-versatile',

  // Direktori penyimpanan session/auth Baileys
  baileysAuthDir: process.env.BAILEYS_AUTH_DIR || './auth_info_baileys',

  // Daftar nomor WhatsApp yang diperbolehkan memakai bot (whitelist)
  allowedNumbers: parseAllowedNumbers(process.env.ALLOWED_NUMBERS),

  // Nama chatbot WhatsApp
  botName: process.env.BOT_NAME || 'AI WhatsApp Assistant',

  // Tingkat logging aplikasi (e.g., info, debug, error, warn)
  logLevel: process.env.LOG_LEVEL || 'info',

  // Batas waktu timeout pemanggilan Groq API (milidetik), default 120000 (2 menit)
  groqTimeoutMs: parseInt(process.env.GROQ_TIMEOUT_MS || '120000', 10),
};

export default config;
