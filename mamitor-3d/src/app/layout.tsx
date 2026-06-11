import type { Metadata } from 'next';
import './globals.css';
// Import CSS KaTeX secara global agar notasi matematika ter-render dengan benar
import 'katex/dist/katex.min.css';

export const metadata: Metadata = {
  title: 'MAMITOR 3D — Matriks Minor & Kofaktor',
  description: 'Alat peraga digital interaktif 3D untuk belajar menghitung Minor dan Kofaktor pada matriks 3x3 secara visual dan edukatif.',
  keywords: ['mamitor', 'mamitor 3d', 'matriks minor', 'kofaktor', 'alat peraga matematika', 'matriks 3x3'],
  authors: [{ name: 'Joki Proyek Team' }],
  icons: {
    icon: '/favicon.ico',
  },
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="id" className="scroll-smooth h-full antialiased" suppressHydrationWarning>
      <body className="min-h-full flex flex-col selection:bg-blue-500/30 selection:text-white" suppressHydrationWarning>
        {children}
      </body>
    </html>
  );
}
