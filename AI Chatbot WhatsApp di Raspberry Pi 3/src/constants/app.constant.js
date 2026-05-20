/**
 * Konstanta default aplikasi WhatsApp AI Chatbot.
 * Semua nilai default yang digunakan jika tidak ada konfigurasi di .env.
 */

// Prefix command default untuk trigger bot
export const DEFAULT_COMMAND_PREFIX = '!ai';

// Batas maksimal karakter input dari user
export const DEFAULT_MAX_CHARS = 1500;

// Batas maksimal karakter balasan AI per segmen pesan
export const DEFAULT_MAX_REPLY_CHARS = 3500;

// Path default binary PicoClaw CLI
export const DEFAULT_PICOCLAW_BIN = '/usr/local/bin/picoclaw';

// Folder default penyimpanan session WhatsApp
export const DEFAULT_BAILEYS_AUTH_DIR = './auth_info_baileys';

// Nama bot default
export const DEFAULT_BOT_NAME = 'AI WhatsApp Assistant';

// Level logging default
export const DEFAULT_LOG_LEVEL = 'info';

// Timeout eksekusi PicoClaw dalam milidetik (2 menit)
export const DEFAULT_PICOCLAW_TIMEOUT_MS = 120000;

// Delay antar segmen pesan saat splitting (milidetik)
export const MESSAGE_SPLIT_DELAY_MS = 500;

// Maksimal segmen pesan yang dikirim
export const MAX_MESSAGE_SEGMENTS = 10;

// Delay reconnect WhatsApp (milidetik)
export const RECONNECT_DELAY_MS = 3000;

// Maksimal percobaan reconnect
export const MAX_RECONNECT_ATTEMPTS = 5;

// Maksimal refresh QR code sebelum berhenti
export const MAX_QR_REFRESH = 5;

// Timeout safety-net untuk active job cleanup (tambahan dari PICOCLAW_TIMEOUT_MS)
export const ACTIVE_JOB_SAFETY_MARGIN_MS = 10000;
