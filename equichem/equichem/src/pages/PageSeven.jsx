import React from 'react';

// ========================================================
// KOMPONEN: PageSeven
// DESKRIPSI: Halaman "Menu Utama / Selamat Datang" (Halaman 7 / Flipbook Hal 6)
// Desain berdasarkan 7.png
// ========================================================
const PageSeven = React.forwardRef((props, ref) => {

  const menuCards = [
    {
      title: 'Materi',
      desc: 'Pelajari materi kesetimbangan kimia secara terstruktur.',
      targetIndex: 8,
      icon: (
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round" className="w-full h-full">
          <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
          <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
          <line x1="9" y1="10" x2="15" y2="10"></line>
          <line x1="9" y1="14" x2="15" y2="14"></line>
          <line x1="9" y1="18" x2="13" y2="18"></line>
        </svg>
      )
    },
    {
      title: 'PBL',
      desc: 'Kerjakan masalah kontekstual dengan pendekatan PBL.',
      targetIndex: 9,
      icon: (
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round" className="w-full h-full">
          <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
          <path d="M14 2v6h6"></path>
          <circle cx="12" cy="13" r="3"></circle>
          <path d="M12 10v-1"></path>
          <path d="M12 17v1"></path>
          <path d="M15 13h1"></path>
          <path d="M8 13h1"></path>
        </svg>
      )
    },
    {
      title: 'Evaluasi',
      desc: 'Uji pemahamanmu melalui latihan dan evaluasi interaktif.',
      targetIndex: 12,
      icon: (
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round" className="w-full h-full">
          <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
          <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
          <path d="M15.5 9.5L10 15l-2-2"></path>
        </svg>
      )
    },
    {
      title: 'Profil',
      desc: 'Lihat informasi profil dan progres belajarmu.',
      targetIndex: 13,
      icon: (
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round" className="w-full h-full">
          <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
          <circle cx="12" cy="7" r="4"></circle>
        </svg>
      )
    }
  ];

  // Komponen Helper untuk menggambar Flask (Labu) SVG
  const FlaskSVG = ({ hasLiquid = true, className = "" }) => (
    <svg viewBox="0 0 200 250" className={className}>
      {/* Liquid Outline / Back */}
      {hasLiquid && <path d="M 45 180 C 45 210, 65 230, 100 230 C 135 230, 155 210, 155 180 C 155 150, 115 90, 115 90 L 85 90 C 85 90, 45 150, 45 180 Z" fill="#0284c7" opacity="0.9" />}
      {/* Liquid Surface */}
      {hasLiquid && <ellipse cx="100" cy="165" rx="46.5" ry="12" fill="#38bdf8" />}
      {hasLiquid && <ellipse cx="100" cy="165" rx="46.5" ry="12" fill="none" stroke="#0ea5e9" strokeWidth="2" />}
      {/* Liquid Body Gradient feel */}
      {hasLiquid && <path d="M 53 180 C 53 205, 70 225, 100 225 C 130 225, 147 205, 147 180 C 147 167, 100 167, 100 167 C 100 167, 53 167, 53 180 Z" fill="#0ea5e9" opacity="0.8" />}

      {/* Bubbles */}
      {hasLiquid && (
        <>
          <circle cx="95" cy="205" r="4" fill="#fff" opacity="0.6" />
          <circle cx="120" cy="195" r="3" fill="#fff" opacity="0.7" />
          <circle cx="85" cy="185" r="3.5" fill="#fff" opacity="0.5" />
          <circle cx="110" cy="175" r="4" fill="#fff" opacity="0.8" />
          <circle cx="100" cy="155" r="4.5" fill="#bae6fd" opacity="0.9" />
        </>
      )}

      {/* Flask Glass Outline */}
      <rect x="80" y="45" width="40" height="8" rx="4" fill="#f0f9ff" stroke="#94a3b8" strokeWidth="3" opacity="0.8" />
      <rect x="83" y="53" width="34" height="6" rx="2" fill="#e0f2fe" stroke="#94a3b8" strokeWidth="2" opacity="0.6" />
      <path d="M 87 59 L 87 90 C 87 90, 42 150, 42 180 C 42 215, 65 235, 100 235 C 135 235, 158 215, 158 180 C 158 150, 113 90, 113 90 L 113 59" fill="none" stroke="#94a3b8" strokeWidth="3.5" opacity="0.7" />
      <path d="M 87 59 L 87 90 C 87 90, 42 150, 42 180 C 42 215, 65 235, 100 235 C 135 235, 158 215, 158 180 C 158 150, 113 90, 113 90 L 113 59" fill="rgba(255,255,255,0.3)" opacity="0.3" />
      {/* Glass Highlights */}
      <path d="M 47 175 C 47 200, 60 220, 85 228" fill="none" stroke="#ffffff" strokeWidth="5" strokeLinecap="round" opacity="0.8" />
      <path d="M 153 175 C 153 190, 145 205, 130 215" fill="none" stroke="#ffffff" strokeWidth="3" strokeLinecap="round" opacity="0.6" />
      <line x1="91" y1="65" x2="91" y2="85" stroke="#ffffff" strokeWidth="4" strokeLinecap="round" opacity="0.7" />
    </svg>
  );

  return (
    <div className="page bg-white relative w-full h-full overflow-hidden flex flex-col font-sans" ref={ref} data-density="soft">

      {/* === BACKGROUND ELEMENTS === */}
      {/* --- Header Curves --- */}
      <div className="absolute top-0 left-0 w-full h-[18%] z-0 pointer-events-none">
        <svg viewBox="0 0 1000 180" preserveAspectRatio="none" className="w-full h-full">
          <path d="M 0 0 L 0 110 C 100 80, 250 15, 450 15 C 650 15, 800 130, 1000 170 L 1000 0 Z" fill="#ffc107" />
          <path d="M 0 0 L 0 95 C 100 65, 250 0, 450 0 C 650 0, 800 115, 1000 155 L 1000 0 Z" fill="#002b80" />
        </svg>
      </div>

      {/* --- Molekul Background --- */}
      <div className="absolute top-[8%] right-[-10%] w-[50%] h-[55%] z-[1] pointer-events-none opacity-[0.07]">
        <svg viewBox="0 0 400 500" className="w-full h-full">
          {/* Molekul SVG Sama dengan sebelumnya */}
          <circle cx="200" cy="100" r="16" fill="none" stroke="#002b80" strokeWidth="4" />
          <circle cx="300" cy="180" r="16" fill="none" stroke="#002b80" strokeWidth="4" />
          <circle cx="120" cy="180" r="16" fill="none" stroke="#002b80" strokeWidth="4" />
          <circle cx="200" cy="260" r="16" fill="none" stroke="#002b80" strokeWidth="4" />
          <circle cx="120" cy="340" r="16" fill="none" stroke="#002b80" strokeWidth="4" />
          <circle cx="300" cy="340" r="16" fill="none" stroke="#002b80" strokeWidth="4" />
          <circle cx="200" cy="420" r="16" fill="none" stroke="#002b80" strokeWidth="4" />
          <line x1="188" y1="112" x2="132" y2="168" stroke="#002b80" strokeWidth="3" />
          <line x1="212" y1="112" x2="288" y2="168" stroke="#002b80" strokeWidth="3" />
          <line x1="120" y1="196" x2="120" y2="324" stroke="#002b80" strokeWidth="3" />
          <line x1="300" y1="196" x2="300" y2="324" stroke="#002b80" strokeWidth="3" />
          <line x1="132" y1="192" x2="188" y2="248" stroke="#002b80" strokeWidth="3" />
          <line x1="288" y1="192" x2="212" y2="248" stroke="#002b80" strokeWidth="3" />
          <line x1="132" y1="328" x2="188" y2="272" stroke="#002b80" strokeWidth="3" />
          <line x1="288" y1="328" x2="212" y2="272" stroke="#002b80" strokeWidth="3" />
          <line x1="132" y1="352" x2="188" y2="408" stroke="#002b80" strokeWidth="3" />
          <line x1="288" y1="352" x2="212" y2="408" stroke="#002b80" strokeWidth="3" />
          <circle cx="40" cy="120" r="16" fill="none" stroke="#002b80" strokeWidth="4" />
          <line x1="108" y1="172" x2="52" y2="132" stroke="#002b80" strokeWidth="3" />
          <circle cx="380" cy="120" r="16" fill="none" stroke="#002b80" strokeWidth="4" />
          <line x1="312" y1="172" x2="368" y2="132" stroke="#002b80" strokeWidth="3" />
          <circle cx="380" cy="260" r="16" fill="none" stroke="#002b80" strokeWidth="4" />
          <line x1="316" y1="188" x2="368" y2="252" stroke="#002b80" strokeWidth="3" />
        </svg>
      </div>

      {/* --- Footer Curves --- */}
      <div className="absolute bottom-0 left-0 w-full h-[18%] z-0 pointer-events-none">
        <svg viewBox="0 0 1000 180" preserveAspectRatio="none" className="w-full h-full">
          <path d="M 0 0 C 150 15, 300 45, 500 80 C 700 115, 850 145, 1000 150 L 1000 180 L 0 180 Z" fill="#ffc107" />
          <path d="M 0 45 C 150 60, 300 90, 500 120 C 700 150, 850 170, 1000 180 L 0 180 Z" fill="#002b80" />
        </svg>
      </div>

      {/* === KONTEN HALAMAN === */}
      <div className="relative z-10 w-full h-full flex flex-col pt-[18%] px-[4%] pb-[8%]">

        {/* --- Main Welcome Card --- */}
        <div className="bg-[#fcfdff] rounded-[16px] shadow-[0_4px_15px_rgba(0,43,128,0.06)] border-[1.5px] border-[#eaf2ff] w-full flex flex-col overflow-hidden relative z-10">

          {/* Header */}
          <div className="flex justify-between items-center p-3 px-5 border-b-[1.5px] border-[#eaf2ff]">
            {/* Logo */}
            <div className="flex items-center gap-2">
              <svg viewBox="0 0 100 100" className="w-7 h-7">
                <circle cx="50" cy="50" r="40" fill="none" stroke="#002b80" strokeWidth="4" />
                <circle cx="50" cy="50" r="46" fill="none" stroke="#ffc107" strokeWidth="1.5" strokeDasharray="4,3" />
                <path d="M 20 85 L 80 85" stroke="#002b80" strokeWidth="4" strokeLinecap="round" />
                <circle cx="50" cy="85" r="3.5" fill="#ffc107" />
                <path d="M 45 35 L 45 45 C 45 45, 30 65, 30 75 C 30 85, 40 95, 50 95 C 60 95, 70 85, 70 75 C 70 65, 55 45, 55 45 L 55 35" fill="none" stroke="#002b80" strokeWidth="3" />
                <path d="M 33 70 C 33 80, 40 92, 50 92 C 60 92, 67 80, 67 70 Z" fill="#0ea5e9" />
                <circle cx="45" cy="80" r="2.5" fill="#fff" />
                <circle cx="55" cy="75" r="1.5" fill="#fff" />
              </svg>
              <h2 className="text-[15px] font-extrabold m-0 tracking-tight"><span className="text-[#002b80]">Equi</span><span className="text-[#ffc107]">Chem</span></h2>
            </div>
            {/* Greeting */}
            <div className="text-[#002b80] font-bold text-[10px] flex items-center gap-1.5" style={{ fontFamily: "'Poppins', sans-serif" }}>
              Halo, Siswa <span className="text-[12px]">👋</span>
            </div>
          </div>

          {/* Body */}
          <div className="flex p-4 px-5 relative h-[145px]">
            {/* Text Left */}
            <div className="w-[50%] flex flex-col justify-center z-20">
              <h1 className="text-[#002b80] font-extrabold text-[22px] leading-[1.1] mb-2 tracking-tight" style={{ fontFamily: "'Poppins', sans-serif" }}>Selamat Datang!</h1>
              <p className="text-[#444] text-[10.5px] leading-[1.4] font-medium w-[95%] mb-4">
                Ayo belajar Kesetimbangan Kimia secara interaktif dan menyenangkan!
              </p>
              <div className="flex gap-1">
                <div className="w-[30px] h-[3px] bg-[#002b80] rounded-full"></div>
                <div className="w-[20px] h-[3px] bg-[#ffc107] rounded-full"></div>
              </div>
            </div>

            {/* Illustration Right */}
            <div className="w-[50%] absolute right-0 bottom-0 h-[130px] overflow-hidden rounded-br-[16px]">

              {/* Waves Background */}
              <svg className="absolute bottom-0 right-0 w-full h-full pointer-events-none" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M 0 100 C 20 60, 50 80, 100 40 L 100 100 Z" fill="#e3efff" />
                <path d="M 0 100 C 30 75, 70 95, 100 45 L 100 100 Z" fill="#cbe0ff" opacity="0.7" />
              </svg>

              {/* Line Chart Dots */}
              <svg className="absolute top-[10%] right-0 w-full h-[60%] z-10 pointer-events-none" viewBox="0 0 100 100" preserveAspectRatio="none">
                {/* Connecting Lines */}
                <polyline points="15,95 25,65 35,45 45,55 55,20 70,30 90,5" fill="none" stroke="#64748b" strokeWidth="1.5" />
                <polyline points="15,95 25,65 35,45 45,55 55,20 70,30 90,5" fill="none" stroke="#e2e8f0" strokeWidth="4" opacity="0.3" />

                {/* Dots with white borders */}
                <circle cx="15" cy="95" r="3.5" fill="#002b80" stroke="#fff" strokeWidth="1" />
                <circle cx="25" cy="65" r="3.5" fill="#002b80" stroke="#fff" strokeWidth="1" />
                <circle cx="35" cy="45" r="3.5" fill="#002b80" stroke="#fff" strokeWidth="1" />
                <circle cx="45" cy="55" r="3.5" fill="#002b80" stroke="#fff" strokeWidth="1" />
                <circle cx="55" cy="20" r="3.5" fill="#002b80" stroke="#fff" strokeWidth="1" />
                <circle cx="70" cy="30" r="3.5" fill="#002b80" stroke="#fff" strokeWidth="1" />
                <circle cx="90" cy="5" r="3.5" fill="#002b80" stroke="#fff" strokeWidth="1" />
              </svg>

              {/* Shelf */}
              <div className="absolute bottom-2 left-6 right-2 h-[5px] bg-[#002b80] rounded-full z-20"></div>
              <div className="absolute bottom-0 left-8 right-4 h-[4px] bg-[#00184a] rounded-full z-10 opacity-30 blur-[2px]"></div>

              {/* Flasks */}
              <div className="absolute bottom-[10px] left-[15%] w-[85%] h-[75px] z-30 flex items-end justify-between px-2">
                <FlaskSVG hasLiquid={true} className="w-[30%] h-auto drop-shadow-md" />
                <FlaskSVG hasLiquid={true} className="w-[30%] h-auto drop-shadow-md" />
                <FlaskSVG hasLiquid={false} className="w-[28%] h-auto drop-shadow-sm opacity-90 mr-1" />
              </div>

            </div>
          </div>
        </div>

        {/* --- Navigation Cards --- */}
        <div className="flex justify-between w-full mt-4 gap-2.5 relative z-10">
          {menuCards.map((card, idx) => (
            <div
              key={idx}
              className="flex-1 bg-white rounded-[12px] shadow-[0_4px_12px_rgba(0,0,0,0.03)] border-[1.5px] border-[#eaf2ff] p-2.5 flex flex-col items-center text-center cursor-pointer hover:shadow-md hover:border-[#cce0ff] transition-all duration-300"
              onClick={() => props.goToPage && props.goToPage(card.targetIndex)}
            >
              {/* Icon */}
              <div className="w-[26px] h-[26px] text-[#002b80] mb-2.5">
                {card.icon}
              </div>
              {/* Title */}
              <h3 className="text-[#002b80] font-bold text-[10px] m-0 tracking-wide" style={{ fontFamily: "'Poppins', sans-serif" }}>{card.title}</h3>
              {/* Underline */}
              <div className="flex mt-1 mb-2 gap-[3px]">
                <div className="w-[12px] h-[2.5px] bg-[#002b80] rounded-full"></div>
                <div className="w-[12px] h-[2.5px] bg-[#ffc107] rounded-full"></div>
              </div>
              {/* Text */}
              <p className="text-[8.5px] text-[#555] m-0 leading-[1.35] font-medium px-0.5">
                {card.desc}
              </p>
            </div>
          ))}
        </div>

      </div>

      {/* --- Nomor Halaman (Kanan Bawah) --- */}
      <div className="absolute right-[6%] bottom-[4%] z-20 flex items-center justify-center gap-2">
        <div className="w-[12px] h-[3px] bg-[#ffc107] rounded-full"></div>
        <div className="w-[28px] h-[28px] bg-white border-[2.5px] border-[#002b80] rounded-lg flex items-center justify-center shadow-sm">
          <span className="font-extrabold text-[#002b80] text-[14px] leading-none mt-[1px]" style={{ fontFamily: "'Poppins', sans-serif" }}>6</span>
        </div>
        <div className="w-[12px] h-[3px] bg-[#ffc107] rounded-full"></div>
      </div>

    </div>
  );
});

export default PageSeven;
