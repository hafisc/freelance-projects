import config from '../config/env.js';
import logger from '../utils/logger.js';

/**
 * Menyusun prompt terstruktur bahasa Indonesia sebelum dikirim ke AI.
 * 
 * @param {string} userQuestion - Pertanyaan/input mentah dari user.
 * @returns {string} Prompt lengkap yang dibungkus instruksi sistem.
 */
export function buildSystemPrompt(userQuestion) {
  return `Kamu adalah AI personal assistant teknis berbahasa Indonesia.
Jawab singkat, jelas, praktis, dan sopan.
Jika diminta membuat langkah kerja, gunakan urutan bernomor.
Jangan membuat instruksi berbahaya.

Pertanyaan user:
${userQuestion}`;
}

/**
 * Memanggil Groq API menggunakan fetch untuk memproses pertanyaan user.
 * Diposisikan di picoclaw.service.js agar menjaga integritas struktur folder SOW
 * setelah migrasi dari PicoClaw ke Groq API langsung.
 * 
 * @param {string} userQuestion - Pertanyaan dari user WhatsApp.
 * @returns {Promise<string>} Jawaban dari AI chatbot.
 * @throws {Error} Jika API Key kosong, API gagal, atau timeout.
 */
export async function askGroq(userQuestion) {
  const apiKey = config.groqApiKey;
  if (!apiKey) {
    logger.error('Groq API Key tidak ditemukan di konfigurasi!');
    throw new Error('Groq API Key belum dikonfigurasi di file .env');
  }

  const prompt = buildSystemPrompt(userQuestion);
  
  // Menggunakan AbortController untuk membatasi durasi request (timeout)
  const controller = new AbortController();
  const timeoutId = setTimeout(() => controller.abort(), config.groqTimeoutMs);

  try {
    logger.info('Menghubungi Groq API...', {
      model: config.groqModel,
      timeoutMs: config.groqTimeoutMs
    });

    const response = await fetch('https://api.groq.com/openai/v1/chat/completions', {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${apiKey}`,
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        model: config.groqModel,
        messages: [
          {
            role: 'user',
            content: prompt
          }
        ],
        temperature: 0.7
      }),
      signal: controller.signal
    });

    // Menghapus timer karena request berhasil diselesaikan
    clearTimeout(timeoutId);

    if (!response.ok) {
      const errorData = await response.json().catch(() => ({}));
      throw new Error(`Groq API Error: ${response.status} - ${JSON.stringify(errorData)}`);
    }

    const data = await response.json();
    const answer = data.choices?.[0]?.message?.content;
    
    if (!answer) {
      throw new Error('Groq API mengembalikan respons kosong.');
    }

    logger.info('Groq API berhasil memproses respons.');
    return answer.trim();

  } catch (error) {
    // Memastikan timer dibersihkan jika terjadi error sebelum timeout
    clearTimeout(timeoutId);
    
    if (error.name === 'AbortError') {
      logger.error(`Groq API Request timeout setelah ${config.groqTimeoutMs} ms.`);
      throw new Error('Groq API Request Timeout');
    }
    
    logger.error('Error saat menghubungi Groq API:', error);
    throw error;
  }
}

/**
 * Alias untuk askGroq demi kompatibilitas fungsionalitas PicoClaw yang diwariskan.
 */
export const askPicoClaw = askGroq;

export default {
  askGroq,
  askPicoClaw,
  buildSystemPrompt
};
