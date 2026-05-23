import { type ClassValue, clsx } from 'clsx';
import { twMerge } from 'tailwind-merge';

/**
 * Menggabungkan nama-nama class Tailwind secara kondisional tanpa konflik class.
 * @param inputs Kumpulan class Tailwind
 * @returns String class name gabungan yang bersih
 */
export function cn(...inputs: ClassValue[]) {
  return twMerge(clsx(inputs));
}
