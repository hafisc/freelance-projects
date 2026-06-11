import pino from 'pino';
import config from '../config/env.js';

/**
 * Konfigurasi Logger Utama
 * Menggunakan pino logger untuk mencatatkan aktivitas bot.
 * Level log dibaca dari konfigurasi global (.env).
 */
const logger = pino({
  level: config.logLevel || 'info',
  // Format timestamp agar mudah dibaca di log console/systemd
  timestamp: pino.stdTimeFunctions.isoTime
});

/**
 * Log informasi umum aplikasi.
 * @param {string} msg - Pesan log info.
 * @param {object} [meta] - Data tambahan opsional (non-sensitif).
 */
export function logInfo(msg, meta = {}) {
  logger.info(meta, msg);
}

/**
 * Log peringatan/warning aplikasi.
 * @param {string} msg - Pesan log warning.
 * @param {object} [meta] - Data tambahan opsional.
 */
export function logWarn(msg, meta = {}) {
  logger.warn(meta, msg);
}

/**
 * Log error aplikasi.
 * @param {string} msg - Pesan log error.
 * @param {Error|object} [err] - Object error atau meta tambahan.
 */
export function logError(msg, err = {}) {
  if (err instanceof Error) {
    logger.error({ err: { message: err.message, stack: err.stack } }, msg);
  } else {
    logger.error(err, msg);
  }
}

/**
 * Log debug untuk troubleshooting detail.
 * @param {string} msg - Pesan log debug.
 * @param {object} [meta] - Data tambahan opsional.
 */
export function logDebug(msg, meta = {}) {
  logger.debug(meta, msg);
}

export default {
  info: logInfo,
  warn: logWarn,
  error: logError,
  debug: logDebug
};
