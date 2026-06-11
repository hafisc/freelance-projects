'use client';

import React from 'react';
import { motion, Variants } from 'framer-motion';
import { Users } from 'lucide-react';
import { Card } from '@/components/ui/Card';

interface Member {
  name: string;
  nim: string;
  initials: string;
}

const MEMBERS: Member[] = [
  { name: "Nada Qur'aniyah Afiatin", nim: "250210101094", initials: "NQ" },
  { name: "Fiola Zuwina Jasmine", nim: "250210101097", initials: "FZ" },
  { name: "Ayu Auliyah", nim: "250210101114", initials: "AA" },
  { name: "Moh Ali Reza", nim: "250210101123", initials: "MR" },
  { name: "Nazar Abid Ash Siddiqi", nim: "250210101126", initials: "NS" },
  { name: "Grace Remiana Siburian", nim: "250210101131", initials: "GS" },
  { name: "Rury Dinar Fajrina", nim: "250210101133", initials: "RF" },
];

/**
 * Komponen yang menampilkan profil kelompok pengembang (Kelompok 4).
 * Menampilkan nama dan NIM setiap anggota dengan styling glassmorphism yang premium.
 */
export const GroupProfile: React.FC = () => {
  // Animasi container untuk delay anak-anaknya secara berurutan
  const containerVariants: Variants = {
    hidden: { opacity: 0 },
    visible: {
      opacity: 1,
      transition: {
        staggerChildren: 0.08,
      },
    },
  };

  // Animasi untuk setiap card anggota kelompok
  const cardVariants: Variants = {
    hidden: { opacity: 0, y: 15 },
    visible: {
      opacity: 1,
      y: 0,
      transition: {
        type: 'spring',
        stiffness: 100,
        damping: 15,
      },
    },
  };

  return (
    <div
      id="profil-kelompok"
      className="w-full mt-20 border-t border-slate-900/60 pt-16 select-none relative"
    >
      {/* Decorative side glows */}
      <div className="absolute top-1/2 left-1/4 -translate-y-1/2 w-72 h-72 bg-blue-600/5 rounded-full blur-[100px] pointer-events-none -z-10" />
      <div className="absolute top-1/2 right-1/4 -translate-y-1/2 w-72 h-72 bg-indigo-650/5 rounded-full blur-[100px] pointer-events-none -z-10" />

      {/* Header Section */}
      <motion.div
        initial={{ opacity: 0, y: 20 }}
        whileInView={{ opacity: 1, y: 0 }}
        viewport={{ once: true }}
        transition={{ duration: 0.6, ease: "easeOut" }}
        className="text-center mb-12 flex flex-col items-center"
      >
        {/* Category Pill Tag */}
        <div className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full border border-blue-500/15 bg-blue-950/15 text-[10px] font-mono font-bold tracking-widest text-blue-400 uppercase mb-4 shadow-[0_0_15px_rgba(37,99,235,0.05)]">
          Proyek Kelompok 4
        </div>

        <div className="flex items-center gap-2 mb-2">
          <Users className="w-5 h-5 text-blue-500" />
          <h2 className="text-xl md:text-2xl font-display font-extrabold text-white">
            Tim Pengembang
          </h2>
        </div>
      </motion.div>

      {/* Members Grid */}
      <motion.div
        variants={containerVariants}
        initial="hidden"
        whileInView="visible"
        viewport={{ once: true, margin: "-60px" }}
        className="flex flex-wrap gap-4.5 justify-center w-full px-2"
      >
        {MEMBERS.map((member, index) => (
          <motion.div
            key={member.nim}
            variants={cardVariants}
            whileHover={{ y: -5, scale: 1.02 }}
            className="w-full sm:w-[280px] md:w-[320px]"
          >
            <Card
              variant="interactive"
              className="group p-4 flex items-center gap-4 h-full relative overflow-hidden bg-slate-950/30 border border-slate-900/60 hover:border-blue-500/30 transition-all duration-300 rounded-2xl"
            >
              {/* Sliding reflection glow */}
              <div className="absolute inset-0 bg-gradient-to-r from-blue-500/0 via-blue-500/5 to-indigo-500/0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000 ease-out pointer-events-none" />

              {/* Initials Avatar */}
              <div className="w-12 h-12 rounded-xl bg-slate-900 border border-slate-800 text-blue-400 group-hover:text-white group-hover:from-blue-600 group-hover:to-indigo-650 group-hover:border-blue-400 group-hover:scale-105 group-hover:shadow-[0_0_15px_rgba(59,130,246,0.3)] flex items-center justify-center font-display font-bold text-sm tracking-wider shrink-0 transition-all duration-300 bg-gradient-to-br">
                {member.initials}
              </div>

              {/* Member Info */}
              <div className="flex flex-col min-w-0 z-10">
                <span className="font-display font-bold text-slate-200 group-hover:text-white text-sm md:text-base leading-tight truncate transition-colors duration-200">
                  {member.name}
                </span>
                <span className="text-[10px] font-mono text-slate-500 group-hover:text-blue-400/80 mt-1 font-semibold tracking-widest transition-colors duration-200">
                  NIM: {member.nim}
                </span>
              </div>
            </Card>
          </motion.div>
        ))}
      </motion.div>
    </div>
  );
};

export default GroupProfile;
