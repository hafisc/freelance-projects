import React from 'react';
import { cn } from '@/lib/utils';

interface CardProps extends React.HTMLAttributes<HTMLDivElement> {
  variant?: 'normal' | 'glass' | 'interactive';
}

/**
 * Komponen pembungkus (Card) dengan tema glassmorphism futuristik.
 */
export const Card: React.FC<CardProps> = ({
  children,
  className,
  variant = 'glass',
  ...props
}) => {
  return (
    <div
      className={cn(
        'rounded-3xl transition-all duration-300',
        {
          'bg-slate-900/50 backdrop-blur-md border border-slate-800 shadow-[0_8px_30px_rgba(0,0,0,0.3)]':
            variant === 'normal',
          'glass-panel': variant === 'glass',
          'glass-panel glass-panel-hover': variant === 'interactive',
        },
        className
      )}
      {...props}
    >
      {children}
    </div>
  );
};
export default Card;
