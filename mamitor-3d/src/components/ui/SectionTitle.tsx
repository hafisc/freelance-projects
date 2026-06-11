import React from 'react';
import { cn } from '@/lib/utils';

interface SectionTitleProps extends React.HTMLAttributes<HTMLHeadingElement> {
  subtitle?: string;
  gradient?: 'primary' | 'success' | 'danger' | 'none';
  align?: 'left' | 'center' | 'right';
}

/**
 * Komponen judul section yang konsisten dengan opsi gradient warna utama, sukses, atau kofaktor.
 */
export const SectionTitle: React.FC<SectionTitleProps> = ({
  children,
  subtitle,
  className,
  gradient = 'primary',
  align = 'left',
  ...props
}) => {
  return (
    <div
      className={cn('flex flex-col mb-4', {
        'items-start text-left': align === 'left',
        'items-center text-center': align === 'center',
        'items-end text-right': align === 'right',
      })}
    >
      <h2
        className={cn(
          'text-2xl md:text-3xl font-extrabold tracking-tight',
          {
            'bg-gradient-to-r from-blue-600 via-blue-500 to-blue-400 bg-clip-text text-transparent':
              gradient === 'primary',
            'bg-gradient-to-r from-emerald-400 to-teal-500 bg-clip-text text-transparent':
              gradient === 'success',
            'bg-gradient-to-r from-rose-400 to-pink-500 bg-clip-text text-transparent':
              gradient === 'danger',
            'text-white': gradient === 'none',
          },
          className
        )}
        {...props}
      >
        {children}
      </h2>
      {subtitle && (
        <span className="text-slate-400 text-sm md:text-base mt-1 font-medium">
          {subtitle}
        </span>
      )}
    </div>
  );
};
