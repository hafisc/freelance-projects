/**
 * Service untuk menjalankan PicoClaw CLI.
 * Menggunakan execFile (bukan exec) untuk keamanan dari command injection.
 * Mengirim prompt ke PicoClaw dan mengembalikan respons AI.
 */

import { execFile } from 'node:child_process';
import { promisify } from 'node:util';
import config from '../config/env.js';
import logger from '../utils/logger.js';

const execFileAsync = promisify(execFile);

/**
 * Kirim pertanyaan ke PicoClaw CLI dan dapatkan respons AI.
 * Command yang dijalankan: picoclaw agent -m "<prompt>"
 *
 * @param {string} userPrompt - Pertanyaan dari user yang sudah disanitasi
 * @returns {Promise<{ success: boolean, response: string }>}
 */
export async function askPicoClaw(userPrompt) {
  try {
    // Bungkus prompt dengan instruksi sistem untuk PicoClaw
    const systemPrompt = buildSystemPrompt(userPrompt);

    // Jalankan PicoClaw CLI menggunakan execFile (aman dari shell injection)
    // Argumen dikirim sebagai array terpisah, bukan string gabungan
    const { stdout, stderr } = await execFileAsync(
      config.picoClawBin,
      ['agent', '-m', systemPrompt],
      {
        timeout: config.picoClawTimeoutMs,
        maxBuffer: 1024 * 1024, // 1MB buffer
        encoding: 'utf-8'
      }
    );

    // Jika stdout ada isinya, gunakan sebagai jawaban
    if (stdout && stdout.trim().length > 0) {
      return {
        success: true,
        response: stdout.trim()
      };
    }

    // Jika stdout kosong, cek stderr
    if (stderr && stderr.trim().length > 0) {
      logger.error('PicoClaw mengembalikan stdout kosong dengan stderr');
      return {
        success: false,
        response: '⚠️ Maaf, AI tidak dapat menghasilkan respons saat ini. Silakan coba lagi.'
      };
    }

    // Stdout dan stderr kosong
    return {
      success: false,
      response: '⚠️ Maaf, AI tidak menghasilkan respons. Silakan coba pertanyaan lain.'
    };

  } catch (error) {
    // Handle timeout
    if (error.killed || error.code === 'ETIMEDOUT') {
      logger.error('PicoClaw timeout - proses dihentikan');
      return {
        success: false,
        response: '⏱️ Maaf, AI membutuhkan waktu terlalu lama. Silakan coba pertanyaan yang lebih singkat.'
      };
    }

    // Handle error lainnya (non-zero exit code, binary tidak ditemukan, dll)
    logger.error({ code: error.code }, 'PicoClaw error saat eksekusi');
    return {
      success: false,
      response: '⚠️ Maaf, terjadi kesalahan pada AI. Silakan coba lagi nanti.'
    };
  }
}

/**
 * Bangun prompt sistem yang membungkus pertanyaan user.
 * Instruksi ini memastikan AI menjawab dalam bahasa Indonesia,
 * singkat, jelas, dan tidak memberikan instruksi berbahaya.
 *
 * @param {string} userPrompt - Pertanyaan asli dari user
 * @returns {string} Prompt lengkap dengan instruksi sistem
 */
function buildSystemPrompt(userPrompt) {
  return `Kamu adalah asisten AI yang membantu menjawab pertanyaan via WhatsApp.

Aturan menjawab:
- Jawab dalam bahasa Indonesia.
- Jawab singkat, jelas, praktis, dan sopan.
- Jika diminta langkah kerja, gunakan format bernomor.
- Jangan memberi instruksi berbahaya atau ilegal.
- Jangan menyebutkan bahwa kamu adalah AI kecuali ditanya.

Pertanyaan user:
${userPrompt}`;
}
