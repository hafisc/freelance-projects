import React from 'react';
import { cn } from '@/lib/utils';

interface ButtonProps extends React.ButtonHTMLAttributes<HTMLButtonElement> {
  variant?: 'primary' | 'success' | 'danger' | 'outline' | 'glass';
  size?: 'sm' | 'md' | 'lg';
  fullWidth?: boolean;
}

/**
 * Komponen tombol UI yang dapat digunakan kembali.
 * Menyediakan varian warna solid minimalis tanpa efek glow.
 */
export const Button: React.FC<ButtonProps> = ({
  children,
  className,
  variant = 'primary',
  size = 'md',
  fullWidth = false,
  ...props
}) => {
  return (
    <button
      className={cn(
        'inline-flex items-center justify-center font-display font-bold tracking-wide rounded-xl transition-all duration-200 active:scale-[0.98] disabled:opacity-50 disabled:pointer-events-none disabled:active:scale-100 cursor-pointer select-none border',
        // Ukuran
        {
          'px-4 py-2 text-xs': size === 'sm',
          'px-6 py-3 text-sm': size === 'md',
          'px-8 py-4.5 text-base': size === 'lg',
        },
        // Varian Warna Solid Tanpa Glow
        {
          // Solid Blue (Primary)
          'bg-blue-600 hover:bg-blue-700 text-white border-blue-500 shadow-sm':
            variant === 'primary',
          // Solid Green (Success)
          'bg-emerald-600 hover:bg-emerald-700 text-white border-emerald-500 shadow-sm':
            variant === 'success',
          // Solid Red (Danger)
          'bg-rose-600 hover:bg-rose-700 text-white border-rose-500 shadow-sm':
            variant === 'danger',
          // Clean Border Outline
          'border-slate-800 bg-transparent hover:bg-slate-900 text-slate-300 hover:text-white':
            variant === 'outline',
          // Translucent Slate (Glass)
          'bg-slate-900/90 border-slate-800 hover:bg-slate-800 text-white':
            variant === 'glass',
        },
        fullWidth && 'w-full',
        className
      )}
      {...props}
    >
      {children}
    </button>
  );
};
export default Button;
