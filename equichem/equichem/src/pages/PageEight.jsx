import React, { useState, useRef, useEffect } from 'react';

// ========================================================
// KOMPONEN: PageEight
// DESKRIPSI: Halaman Interaktif - Sidebar + Konten Dinamis
// Sidebar: Beranda | Materi | PBL | Evaluasi | Profil | Dashboard
// Klik sidebar → konten berubah di area kanan (tanpa pindah halaman flipbook)
// ========================================================
const PageEight = React.forwardRef((props, ref) => {
  const [activeTab, setActiveTab] = useState('materi');
  const contentBoxRef = useRef(null);

  // Blokir semua native events agar react-pageflip tidak flip saat klik di dalam konten
  useEffect(() => {
    const el = contentBoxRef.current;
    if (!el) return;
    const stop = (e) => e.stopPropagation();
    el.addEventListener('mousedown', stop, { capture: true });
    el.addEventListener('touchstart', stop, { capture: true });
    el.addEventListener('pointerdown', stop, { capture: true });
    return () => {
      el.removeEventListener('mousedown', stop, { capture: true });
      el.removeEventListener('touchstart', stop, { capture: true });
      el.removeEventListener('pointerdown', stop, { capture: true });
    };
  }, []);
  const [selectedAnswer, setSelectedAnswer] = useState(null);
  const [showResult, setShowResult] = useState(false);

  // ── SIDEBAR ITEMS ───────────────────────────────────────
  const sidebarItems = [
    {
      id: 'beranda',
      label: 'Beranda',
      icon: (
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round" className="w-[17px] h-[17px]">
          <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
          <polyline points="9 22 9 12 15 12 15 22" />
        </svg>
      ),
    },
    {
      id: 'materi',
      label: 'Materi',
      icon: (
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round" className="w-[17px] h-[17px]">
          <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
          <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
          <line x1="9" y1="7" x2="15" y2="7" />
          <line x1="9" y1="11" x2="15" y2="11" />
        </svg>
      ),
    },
    {
      id: 'pbl',
      label: 'PBL',
      icon: (
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round" className="w-[17px] h-[17px]">
          <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
          <circle cx="9" cy="7" r="4" />
          <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
          <path d="M16 3.13a4 4 0 0 1 0 7.75" />
        </svg>
      ),
    },
    {
      id: 'evaluasi',
      label: 'Evaluasi',
      icon: (
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round" className="w-[17px] h-[17px]">
          <path d="M9 3h6m-3 0v7l-5 9h10l-5-9V3" />
        </svg>
      ),
    },
    {
      id: 'profil',
      label: 'Profil',
      icon: (
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round" className="w-[17px] h-[17px]">
          <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
          <circle cx="12" cy="7" r="4" />
        </svg>
      ),
    },
  ];

  // ── DATA MATERI ─────────────────────────────────────────
  const materiUnits = [
    { num: 1, title: 'Konsep Kesetimbangan Kimia', desc: 'Reaksi bolak-balik dan kesetimbangan dinamis.' },
    { num: 2, title: 'Tetapan Kesetimbangan (Kc & Kp)', desc: 'Menentukan nilai tetapan dari data konsentrasi.' },
    { num: 3, title: 'Asas Le Chatelier', desc: 'Pengaruh perubahan kondisi terhadap kesetimbangan.' },
    { num: 4, title: 'Faktor yang Mempengaruhi', desc: 'Konsentrasi, tekanan, volume, suhu & katalis.' },
  ];

  // ── DATA PBL ────────────────────────────────────────────
  const pblSteps = [
    {
      num: 1, title: 'Orientasi Masalah',
      desc: 'Mengamati fenomena dan memahami masalah kontekstual.',
      icon: <svg viewBox="0 0 24 24" fill="none" stroke="#002b80" strokeWidth="1.5" className="w-5 h-5"><circle cx="10" cy="10" r="7" fill="#ffc107" fillOpacity="0.2" /><circle cx="10" cy="10" r="7" /><path d="M15 15l5 5" /></svg>,
    },
    {
      num: 2, title: 'Mengorganisasi Siswa',
      desc: 'Mengidentifikasi informasi yang dibutuhkan.',
      icon: <svg viewBox="0 0 24 24" fill="none" stroke="#002b80" strokeWidth="1.5" className="w-5 h-5"><path d="M17 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2" /><circle cx="10" cy="8" r="4" fill="#ffc107" fillOpacity="0.2" /><circle cx="10" cy="8" r="4" /><path d="M22 21v-2a4 4 0 0 0-3-3.87" /><path d="M17 4.13a4 4 0 0 1 0 7.75" /></svg>,
    },
    {
      num: 3, title: 'Investigasi',
      desc: 'Mencari informasi, melakukan eksperimen/observasi.',
      icon: <svg viewBox="0 0 24 24" fill="none" stroke="#002b80" strokeWidth="1.5" className="w-5 h-5"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z" /><path d="M13 2v7h7" /><circle cx="16.5" cy="16.5" r="3.5" fill="#ffc107" fillOpacity="0.2" /></svg>,
    },
    {
      num: 4, title: 'Mengembangkan & Menyajikan Solusi',
      desc: 'Menyusun solusi dan presentasi hasil.',
      icon: <svg viewBox="0 0 24 24" fill="none" stroke="#002b80" strokeWidth="1.5" className="w-5 h-5"><circle cx="12" cy="11" r="5" fill="#ffc107" fillOpacity="0.2" /><path d="M9 18h6" /><path d="M10 21h4" /><path d="M12 2v2" /></svg>,
    },
    {
      num: 5, title: 'Analisis & Evaluasi',
      desc: 'Mengevaluasi proses dan hasil pemecahan masalah.',
      icon: <svg viewBox="0 0 24 24" fill="none" stroke="#002b80" strokeWidth="1.5" className="w-5 h-5"><circle cx="17" cy="18" r="5" fill="#ffc107" fillOpacity="0.3" /><circle cx="17" cy="18" r="5" /><path d="M14.5 18.5l1.5 1.5 3-3" /></svg>,
    },
  ];

  // ── DATA EVALUASI ───────────────────────────────────────
  const evalOptions = ['0,64', '1,60', '2,56', '4,00', '16,00'];
  const correctAnswer = 3; // index ke-3 = '4,00' (jawaban benar: [NO2]²/[N2O4] = 0.16/0.1 = 1.6)

  // ── RENDER KONTEN ───────────────────────────────────────
  const renderContent = () => {
    switch (activeTab) {

      // ── BERANDA / DASHBOARD ─────────────────────────────
      case 'beranda':
      case 'dashboard':
        return (
          <div className="flex-1 flex flex-col justify-center items-center px-4 py-2">
            <div className="text-center mb-3">
              <div className="w-14 h-14 rounded-full bg-[#e8f0ff] flex items-center justify-center mx-auto mb-2 border-2 border-[#cce0ff]">
                <svg viewBox="0 0 24 24" fill="none" stroke="#002b80" strokeWidth="1.8" className="w-7 h-7">
                  <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                  <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
              </div>
              <h2 className="text-[#002b80] font-extrabold text-[16px] m-0 mb-1" style={{ fontFamily: "'Poppins', sans-serif" }}>
                Selamat Datang!
              </h2>
              <p className="text-[#555] text-[9.5px] leading-[1.5] m-0 font-medium">
                Ayo belajar Kesetimbangan Kimia secara interaktif.<br />
                Pilih menu di sidebar untuk memulai.
              </p>
            </div>
            <div className="grid grid-cols-2 gap-2 w-full mt-2">
              {[
                { label: 'Materi', count: '4 Unit', tab: 'materi', color: '#002b80' },
                { label: 'PBL', count: '5 Tahap', tab: 'pbl', color: '#0044cc' },
                { label: 'Evaluasi', count: '3 Tipe', tab: 'evaluasi', color: '#005ce6' },
                { label: 'Profil', count: 'Progress', tab: 'profil', color: '#1266f0' },
              ].map((item) => (
                <button
                  key={item.tab}
                  onClick={() => setActiveTab(item.tab)}
                  className="bg-white border border-[#eaf2ff] rounded-[8px] p-2 text-left shadow-sm cursor-pointer hover:border-[#002b80] transition-colors"
                  style={{ border: 'none', outline: 'none', cursor: 'pointer' }}
                >
                  <div className="w-5 h-5 rounded-full mb-1" style={{ background: item.color, opacity: 0.15, display: 'none' }} />
                  <p className="text-[#002b80] font-bold text-[10px] m-0" style={{ fontFamily: "'Poppins', sans-serif" }}>{item.label}</p>
                  <p className="text-[#888] text-[8px] m-0">{item.count}</p>
                </button>
              ))}
            </div>
            <div className="flex gap-1 mt-3">
              <div className="w-7 h-[2.5px] bg-[#002b80] rounded-full" />
              <div className="w-5 h-[2.5px] bg-[#ffc107] rounded-full" />
            </div>
          </div>
        );

      // ── MATERI ──────────────────────────────────────────
      case 'materi':
        return (
          <div className="flex-1 flex flex-col px-3 py-2" style={{ animation: 'fadeIn 0.2s ease' }}>
            {/* Header */}
            <div className="mb-1.5">
              <div className="inline-block bg-[#002b80] text-white font-bold text-[9px] px-2 py-0.5 rounded-[4px] mb-1">
                Unit 1 – 4
              </div>
              <h2 className="text-[#002b80] font-extrabold text-[14px] leading-tight m-0" style={{ fontFamily: "'Poppins', sans-serif" }}>
                Unit Materi
              </h2>
              <div className="w-5 h-[2.5px] bg-[#ffc107] rounded-full mt-1" />
            </div>

            {/* Intro Text */}
            <p className="text-[#444] text-[9px] leading-[1.4] font-medium m-0 mb-2">
              Kesetimbangan kimia terjadi dalam reaksi reversibel ketika laju reaksi maju = laju reaksi balik.
            </p>

            {/* Reaction equation */}
            <div className="flex items-center justify-center gap-2 text-[#002b80] font-bold text-[14px] mb-2" style={{ fontFamily: 'serif' }}>
              <span>aA + bB</span>
              <svg viewBox="0 0 100 40" className="w-10 h-4">
                <line x1="0" y1="12" x2="95" y2="12" stroke="#002b80" strokeWidth="4" />
                <polyline points="80,0 95,12" fill="none" stroke="#002b80" strokeWidth="4" strokeLinecap="round" />
                <line x1="5" y1="28" x2="100" y2="28" stroke="#002b80" strokeWidth="4" />
                <polyline points="20,40 5,28" fill="none" stroke="#002b80" strokeWidth="4" strokeLinecap="round" />
              </svg>
              <span>cC + dD</span>
            </div>

            {/* Unit list */}
            <div className="flex flex-col gap-1.5 flex-1">
              {materiUnits.map((unit) => (
                <div key={unit.num} className="flex items-center gap-2 bg-[#f8fbff] border border-dashed border-[#a3c7ff] rounded-[8px] px-2.5 py-1.5">
                  <div className="relative w-6 h-6 shrink-0">
                    <div className="absolute -left-[2px] top-[1.5px] w-full h-full rounded-full bg-[#ffc107]" />
                    <div className="absolute inset-0 rounded-full bg-[#002b80] flex items-center justify-center text-white font-extrabold text-[10px]" style={{ fontFamily: "'Poppins', sans-serif" }}>
                      {unit.num}
                    </div>
                  </div>
                  <div className="flex-1 min-w-0">
                    <p className="text-[#002b80] font-bold text-[9.5px] m-0 leading-tight truncate">{unit.title}</p>
                    <p className="text-[#666] text-[8px] m-0">{unit.desc}</p>
                  </div>
                  <svg viewBox="0 0 24 24" fill="none" stroke="#cce0ff" strokeWidth="2" className="w-3 h-3 shrink-0">
                    <path d="M9 18l6-6-6-6" />
                  </svg>
                </div>
              ))}
            </div>

            {/* Penjelasan box */}
            <div className="bg-[#f0f7ff] border border-[#cce0ff] rounded-[8px] p-2 flex items-center gap-2 mt-2">
              <div className="w-7 h-7 rounded-full bg-[#e6f0ff] flex items-center justify-center shrink-0 border border-[#b3d4ff]">
                <svg viewBox="0 0 24 24" fill="none" stroke="#002b80" strokeWidth="1.5" className="w-4 h-4">
                  <circle cx="12" cy="11" r="5" fill="#ffc107" fillOpacity="0.2" />
                  <path d="M9 18h6" /><path d="M10 22h4" /><path d="M12 2v1" />
                </svg>
              </div>
              <p className="text-[#333] text-[8px] leading-[1.35] m-0 font-medium flex-1">
                Pada kesetimbangan dinamis, konsentrasi reaktan & produk tetap konstan karena laju maju = laju balik.
              </p>
            </div>
          </div>
        );

      // ── PBL ─────────────────────────────────────────────
      case 'pbl':
        return (
          <div className="flex-1 flex flex-col px-3 py-2" style={{ animation: 'fadeIn 0.2s ease' }}>
            <div className="mb-2">
              <h2 className="text-[#002b80] font-extrabold text-[14px] leading-tight m-0" style={{ fontFamily: "'Poppins', sans-serif" }}>
                Tahapan PBL
              </h2>
              <div className="w-5 h-[2.5px] bg-[#ffc107] rounded-full mt-1" />
            </div>

            <div className="relative flex-1 flex flex-col justify-between pl-[2px]">
              {/* Vertical dashed line */}
              <div className="absolute left-[11px] top-3 bottom-3 w-[1.5px] border-l-[1.5px] border-dashed border-[#cce0ff] z-0" />

              {pblSteps.map((step) => (
                <div key={step.num} className="flex items-center gap-2 relative z-10">
                  <div className="w-[22px] h-[22px] rounded-full bg-[#ffc107] flex items-center justify-center font-extrabold text-[#002b80] text-[11px] shrink-0 shadow-sm border border-[#eab308]">
                    {step.num}
                  </div>
                  <div className="flex-1 bg-white border border-[#eaf2ff] rounded-[8px] p-1.5 flex items-center gap-2 shadow-sm">
                    <div className="w-8 h-8 rounded-full bg-[#fffcf0] flex items-center justify-center shrink-0 border border-[#fef3c7]">
                      {step.icon}
                    </div>
                    <div className="flex-1 pr-1">
                      <h4 className="text-[#002b80] font-bold text-[9.5px] leading-tight m-0 mb-0.5">{step.title}</h4>
                      <p className="text-[#666] text-[8px] leading-tight m-0">{step.desc}</p>
                    </div>
                  </div>
                </div>
              ))}
            </div>
          </div>
        );

      // ── EVALUASI ─────────────────────────────────────────
      case 'evaluasi':
        return (
          <div className="flex-1 flex flex-col px-3 py-2" style={{ animation: 'fadeIn 0.2s ease' }}>
            {/* Tab header */}
            <div className="flex gap-0 mb-2">
              {['Latihan', 'Kuis', 'Ujian'].map((t, i) => (
                <div
                  key={i}
                  className="flex-1 text-center text-[10px] font-bold py-1.5 rounded-t-[6px] cursor-pointer"
                  style={{
                    background: i === 0 ? '#002b80' : '#f0f4ff',
                    color: i === 0 ? '#fff' : '#002b80',
                    borderBottom: i === 0 ? 'none' : '1.5px solid #cce0ff',
                  }}
                >
                  {t}
                </div>
              ))}
            </div>

            {/* Question box */}
            <div className="bg-white border border-[#cce0ff] rounded-[8px] rounded-tl-none flex-1 flex flex-col p-2.5 shadow-sm">
              {/* Question */}
              <div className="flex gap-1.5 mb-2">
                <span className="text-[#002b80] font-extrabold text-[11px] shrink-0">1.</span>
                <div>
                  <p className="text-[#000] font-bold text-[10px] leading-snug m-0 mb-0.5">
                    Pada reaksi: N<sub className="text-[7px]">2</sub>O<sub className="text-[7px]">4(g)</sub>
                    {' ⇌ '}
                    2NO<sub className="text-[7px]">2(g)</sub>
                  </p>
                  <p className="text-[#333] text-[9px] leading-snug m-0">
                    Jika [N<sub className="text-[7px]">2</sub>O<sub className="text-[7px]">4</sub>] = 0,1 M dan [NO<sub className="text-[7px]">2</sub>] = 0,4 M, maka K<sub className="text-[7px]">c</sub> adalah ...
                  </p>
                </div>
              </div>

              {/* Options */}
              <div className="flex flex-col gap-2 flex-1">
                {evalOptions.map((opt, i) => {
                  let bg = '#f8fafc', border = '#93c5fd', textColor = '#002b80';
                  if (showResult && selectedAnswer === i) {
                    if (i === correctAnswer) { bg = '#dcfce7'; border = '#86efac'; textColor = '#166534'; }
                    else { bg = '#fee2e2'; border = '#fca5a5'; textColor = '#991b1b'; }
                  } else if (selectedAnswer === i) {
                    bg = '#eff6ff'; border = '#3b82f6';
                  }
                  return (
                    <button
                      key={i}
                      className="flex items-center gap-2.5 w-full rounded-[6px] px-2.5 py-1.5 cursor-pointer transition-all"
                      style={{ background: bg, border: `1.5px solid ${border}`, outline: 'none' }}
                      onClick={() => { setSelectedAnswer(i); setShowResult(false); }}
                    >
                      <div className="w-5 h-5 rounded-full border flex items-center justify-center font-bold text-[10px] shrink-0" style={{ borderColor: border, color: textColor, background: '#fff' }}>
                        {String.fromCharCode(65 + i)}
                      </div>
                      <span className="font-extrabold text-[11px]" style={{ color: textColor }}>{opt}</span>
                      {showResult && i === correctAnswer && (
                        <svg viewBox="0 0 24 24" fill="none" stroke="#16a34a" strokeWidth="2.5" className="w-3.5 h-3.5 ml-auto"><path d="M20 6L9 17l-5-5" /></svg>
                      )}
                    </button>
                  );
                })}
              </div>

              {/* Cek Jawaban button */}
              <button
                className="bg-[#002b80] text-white font-bold text-[10px] py-1.5 px-4 rounded-[6px] mt-2 w-full cursor-pointer border-none"
                style={{ fontFamily: "'Poppins', sans-serif" }}
                onClick={() => { if (selectedAnswer !== null) setShowResult(true); }}
              >
                {showResult
                  ? (selectedAnswer === correctAnswer ? '✓ Jawaban Benar!' : '✗ Coba Lagi')
                  : 'Cek Jawaban'
                }
              </button>
            </div>
          </div>
        );

      // ── PROFIL ───────────────────────────────────────────
      case 'profil':
        return (
          <div className="flex-1 flex flex-col px-3 py-2" style={{ animation: 'fadeIn 0.2s ease' }}>
            {/* Profile header */}
            <div className="flex items-center gap-2.5 mb-3 pb-2.5 border-b border-[#eaf2ff]">
              <div className="w-11 h-11 rounded-full bg-[#002b80] flex items-center justify-center shrink-0 shadow-md">
                <svg viewBox="0 0 24 24" fill="none" stroke="white" strokeWidth="1.8" className="w-5 h-5">
                  <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                  <circle cx="12" cy="7" r="4" />
                </svg>
              </div>
              <div>
                <p className="text-[#002b80] font-extrabold text-[12px] m-0" style={{ fontFamily: "'Poppins', sans-serif" }}>
                  Siswa EquiChem
                </p>
                <p className="text-[#888] text-[8.5px] m-0">XI IPA · Aktif</p>
              </div>
              <div className="ml-auto bg-[#e8f9f0] border border-[#86efac] rounded-[5px] px-1.5 py-0.5">
                <span className="text-[#16a34a] font-bold text-[7.5px]">● Online</span>
              </div>
            </div>

            {/* Progress donut */}
            <div className="flex items-center gap-4 mb-3">
              <svg viewBox="0 0 100 100" className="w-[75px] h-[75px] shrink-0">
                <circle cx="50" cy="50" r="34" fill="none" stroke="#dbeafe" strokeWidth="16" />
                <circle cx="50" cy="50" r="34" fill="none" stroke="#002b80" strokeWidth="16"
                  strokeDasharray="160 213" strokeDashoffset="0" transform="rotate(-90 50 50)" />
                <circle cx="50" cy="50" r="34" fill="none" stroke="#ffc107" strokeWidth="16"
                  strokeDasharray="53 213" strokeDashoffset="-160" transform="rotate(-90 50 50)" />
                <text x="50" y="48" textAnchor="middle" fill="#002b80" fontSize="20" fontWeight="900" fontFamily="'Poppins',sans-serif">75%</text>
                <text x="50" y="61" textAnchor="middle" fill="#555" fontSize="7" fontFamily="sans-serif">Selesai</text>
              </svg>
              <div className="flex flex-col gap-2 flex-1">
                <div className="flex items-center gap-2">
                  <div className="w-2 h-2 rounded-full bg-[#002b80]" />
                  <div>
                    <p className="text-[#002b80] font-bold text-[9px] m-0">Unit Selesai</p>
                    <p className="text-[#555] text-[8px] m-0">6 dari 8</p>
                  </div>
                </div>
                <div className="flex items-center gap-2">
                  <div className="w-2 h-2 rounded-full bg-[#ffc107]" />
                  <div>
                    <p className="text-[#002b80] font-bold text-[9px] m-0">Skor Evaluasi</p>
                    <p className="text-[#555] text-[8px] m-0">80 / 100</p>
                  </div>
                </div>
              </div>
            </div>

            {/* Pencapaian */}
            <div className="bg-[#f8fbff] border border-[#eaf2ff] rounded-[10px] p-2.5">
              <p className="text-[#002b80] font-bold text-[10px] m-0 mb-2" style={{ fontFamily: "'Poppins', sans-serif" }}>Pencapaian</p>
              <div className="flex justify-around">
                {[
                  { label: 'Konsisten', icon: '⭐' },
                  { label: 'Teliti', icon: '🔬' },
                  { label: 'Problem Solver', icon: '💡' },
                ].map((b, i) => (
                  <div key={i} className="flex flex-col items-center gap-1">
                    <div className="w-8 h-8 rounded-full bg-white border-2 border-[#cce0ff] flex items-center justify-center text-[14px] shadow-sm">
                      {b.icon}
                    </div>
                    <span className="text-[#002b80] font-bold text-[7px] text-center">{b.label}</span>
                  </div>
                ))}
              </div>
            </div>
          </div>
        );

      default:
        return null;
    }
  };

  return (
    <div className="page bg-white relative w-full h-full overflow-hidden flex flex-col font-sans" ref={ref} data-density="soft">

      {/* === BACKGROUND ELEMENTS === */}
      <div className="absolute top-0 left-0 w-full h-[18%] z-0 pointer-events-none">
        <svg viewBox="0 0 1000 180" preserveAspectRatio="none" className="w-full h-full">
          <path d="M 0 0 L 0 110 C 100 80, 250 15, 450 15 C 650 15, 800 130, 1000 170 L 1000 0 Z" fill="#ffc107" />
          <path d="M 0 0 L 0 95 C 100 65, 250 0, 450 0 C 650 0, 800 115, 1000 155 L 1000 0 Z" fill="#002b80" />
        </svg>
      </div>
      <div className="absolute top-[8%] right-[-10%] w-[50%] h-[55%] z-[1] pointer-events-none opacity-[0.05]">
        <svg viewBox="0 0 400 500" className="w-full h-full">
          <circle cx="200" cy="100" r="16" fill="none" stroke="#002b80" strokeWidth="4" />
          <circle cx="300" cy="180" r="16" fill="none" stroke="#002b80" strokeWidth="4" />
          <circle cx="120" cy="180" r="16" fill="none" stroke="#002b80" strokeWidth="4" />
          <circle cx="200" cy="260" r="16" fill="none" stroke="#002b80" strokeWidth="4" />
          <line x1="188" y1="112" x2="132" y2="168" stroke="#002b80" strokeWidth="3" />
          <line x1="212" y1="112" x2="288" y2="168" stroke="#002b80" strokeWidth="3" />
          <line x1="132" y1="192" x2="188" y2="248" stroke="#002b80" strokeWidth="3" />
          <line x1="288" y1="192" x2="212" y2="248" stroke="#002b80" strokeWidth="3" />
        </svg>
      </div>
      <div className="absolute bottom-0 left-0 w-full h-[18%] z-0 pointer-events-none">
        <svg viewBox="0 0 1000 180" preserveAspectRatio="none" className="w-full h-full">
          <path d="M 0 0 C 150 15, 300 45, 500 80 C 700 115, 850 145, 1000 150 L 1000 180 L 0 180 Z" fill="#ffc107" />
          <path d="M 0 45 C 150 60, 300 90, 500 120 C 700 150, 850 170, 1000 180 L 0 180 Z" fill="#002b80" />
        </svg>
      </div>

      {/* === KONTEN HALAMAN === */}
      <div className="relative z-10 w-full h-full flex flex-col pt-[15%] px-[4%] pb-[8%]">

        {/* Judul */}
        <div className="mb-1.5 text-center">
          <h1 className="font-extrabold text-[#002b80] text-[16px] m-0 tracking-wide" style={{ fontFamily: "'Poppins', sans-serif" }}>
            {activeTab === 'materi' && 'UNIT MATERI'}
            {activeTab === 'pbl' && 'AKTIVITAS PBL'}
            {activeTab === 'evaluasi' && 'EVALUASI'}
            {activeTab === 'profil' && 'HASIL & PROFIL'}
            {(activeTab === 'beranda' || activeTab === 'dashboard') && 'BERANDA'}
          </h1>
        </div>

        {/* Main Box: Sidebar + Content */}
        <div
          ref={contentBoxRef}
          className="flex-1 w-full bg-white rounded-[16px] shadow-[0_4px_20px_rgba(0,43,128,0.08)] border border-[#eaf2ff] flex overflow-hidden"
        >

          {/* Sidebar */}
          <div className="w-[22%] bg-[#0f2a5c] h-full flex flex-col py-2 z-20 shadow-md shrink-0">
            {sidebarItems.map((item) => {
              const isActive = activeTab === item.id;
              return (
                <button
                  key={item.id}
                  className="flex flex-col items-center justify-center py-2.5 w-full cursor-pointer transition-all duration-150 relative"
                  style={{
                    background: isActive ? '#ffc107' : 'transparent',
                    border: 'none',
                    outline: 'none',
                  }}
                  onClick={(e) => { e.stopPropagation(); setActiveTab(item.id); }}
                >
                  {/* Active pointer triangle */}
                  {isActive && (
                    <div className="absolute right-0 top-1/2 -translate-y-1/2 w-0 h-0"
                      style={{
                        borderTop: '5px solid transparent',
                        borderBottom: '5px solid transparent',
                        borderRight: '5px solid white',
                      }}
                    />
                  )}
                  <div style={{ color: isActive ? '#002b80' : 'rgba(255,255,255,0.85)' }}>
                    {item.icon}
                  </div>
                  <span
                    className="font-bold tracking-wide mt-0.5"
                    style={{
                      fontSize: '7.5px',
                      color: isActive ? '#002b80' : 'rgba(255,255,255,0.85)',
                    }}
                  >
                    {item.label}
                  </span>
                </button>
              );
            })}
          </div>

          {/* Content Area */}
          <div className="flex-1 flex flex-col overflow-hidden min-w-0">
            {renderContent()}
          </div>

        </div>
      </div>

      {/* Nomor Halaman */}
      <div className="absolute right-[6%] bottom-[4%] z-20 flex items-center justify-center gap-2">
        <div className="w-[12px] h-[3px] bg-[#ffc107] rounded-full" />
        <div className="w-[28px] h-[28px] bg-white border-[2.5px] border-[#002b80] rounded-lg flex items-center justify-center shadow-sm">
          <span className="font-extrabold text-[#002b80] text-[14px] leading-none mt-[1px]" style={{ fontFamily: "'Poppins', sans-serif" }}>7</span>
        </div>
        <div className="w-[12px] h-[3px] bg-[#ffc107] rounded-full" />
      </div>

      {/* Animation */}
      <style>{`
        @keyframes fadeIn {
          from { opacity: 0; transform: translateX(6px); }
          to   { opacity: 1; transform: translateX(0); }
        }
      `}</style>

    </div>
  );
});

export default PageEight;
