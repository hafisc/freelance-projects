import React from 'react';

// ========================================================
// KOMPONEN: PageFifteen
// DESKRIPSI: Halaman "Glosarium" (Halaman 15 / Flipbook Hal 14)
// Desain berdasarkan 15.png
// ========================================================
const PageFifteen = React.forwardRef((props, ref) => {
  
  const glossaryItems = [
    {
      term: "Kesetimbangan Dinamis",
      definition: "Keadaan ketika reaksi maju dan reaksi balik berlangsung dengan laju yang sama."
    },
    {
      term: "Tetapan Kesetimbangan (K)",
      definition: "Perbandingan hasil kali konsentrasi produk terhadap pereaksi pada keadaan setimbang."
    },
    {
      term: "Le Chatelier",
      definition: "Prinsip yang menyatakan bahwa sistem kesetimbangan akan bergeser untuk mengurangi pengaruh perubahan."
    }
  ];

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
      <div className="absolute top-[8%] right-[-10%] w-[50%] h-[55%] z-[1] pointer-events-none opacity-[0.08]">
        <svg viewBox="0 0 400 500" className="w-full h-full">
          <circle cx="200" cy="100" r="16" fill="none" stroke="#002b80" strokeWidth="4"/>
          <circle cx="300" cy="180" r="16" fill="none" stroke="#002b80" strokeWidth="4"/>
          <circle cx="120" cy="180" r="16" fill="none" stroke="#002b80" strokeWidth="4"/>
          <circle cx="200" cy="260" r="16" fill="none" stroke="#002b80" strokeWidth="4"/>
          <circle cx="120" cy="340" r="16" fill="none" stroke="#002b80" strokeWidth="4"/>
          <circle cx="300" cy="340" r="16" fill="none" stroke="#002b80" strokeWidth="4"/>
          <circle cx="200" cy="420" r="16" fill="none" stroke="#002b80" strokeWidth="4"/>
          <line x1="188" y1="112" x2="132" y2="168" stroke="#002b80" strokeWidth="3"/>
          <line x1="212" y1="112" x2="288" y2="168" stroke="#002b80" strokeWidth="3"/>
          <line x1="120" y1="196" x2="120" y2="324" stroke="#002b80" strokeWidth="3"/>
          <line x1="300" y1="196" x2="300" y2="324" stroke="#002b80" strokeWidth="3"/>
          <line x1="132" y1="192" x2="188" y2="248" stroke="#002b80" strokeWidth="3"/>
          <line x1="288" y1="192" x2="212" y2="248" stroke="#002b80" strokeWidth="3"/>
          <line x1="132" y1="328" x2="188" y2="272" stroke="#002b80" strokeWidth="3"/>
          <line x1="288" y1="328" x2="212" y2="272" stroke="#002b80" strokeWidth="3"/>
          <line x1="132" y1="352" x2="188" y2="408" stroke="#002b80" strokeWidth="3"/>
          <line x1="288" y1="352" x2="212" y2="408" stroke="#002b80" strokeWidth="3"/>
          <circle cx="40" cy="120" r="16" fill="none" stroke="#002b80" strokeWidth="4"/>
          <line x1="108" y1="172" x2="52" y2="132" stroke="#002b80" strokeWidth="3"/>
          <circle cx="380" cy="120" r="16" fill="none" stroke="#002b80" strokeWidth="4"/>
          <line x1="312" y1="172" x2="368" y2="132" stroke="#002b80" strokeWidth="3"/>
          <circle cx="380" cy="260" r="16" fill="none" stroke="#002b80" strokeWidth="4"/>
          <line x1="316" y1="188" x2="368" y2="252" stroke="#002b80" strokeWidth="3"/>
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
      <div className="relative z-10 w-full h-full flex flex-col pt-[15%] px-[10%] pb-[8%]">
        
        {/* --- Judul Halaman --- */}
        <div className="mb-6 w-full flex flex-col items-start">
          <h1 className="font-extrabold text-[#002b80] text-[24px] m-0 tracking-wide leading-tight" style={{ fontFamily: "'Poppins', sans-serif" }}>
            GLOSARIUM
          </h1>
          {/* Garis Bawah (Biru & Kuning) */}
          <div className="flex gap-2 mt-2">
            <div className="w-[30px] h-[3.5px] bg-[#002b80] rounded-full"></div>
            <div className="w-[20px] h-[3.5px] bg-[#ffc107] rounded-full"></div>
          </div>
        </div>

        {/* --- Kotak Pencarian --- */}
        <div className="relative w-full mb-8">
          <input 
            type="text" 
            placeholder="Cari istilah..."
            className="w-full border-[1.5px] border-[#93c5fd] rounded-[8px] py-2.5 px-4 text-[12px] text-[#333] outline-none focus:border-[#002b80] transition-colors bg-[#f8fafc] shadow-sm"
          />
          <div className="absolute right-[12px] top-1/2 -translate-y-1/2 text-[#002b80]">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round" className="w-4 h-4">
              <circle cx="11" cy="11" r="8"></circle>
              <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
          </div>
        </div>

        {/* --- Daftar Glosarium --- */}
        <div className="flex flex-col gap-6 w-full pr-[15%]">
          {glossaryItems.map((item, idx) => (
            <div key={idx} className="flex flex-col">
              <h3 className="text-[#002b80] font-bold text-[14px] m-0 mb-1.5" style={{ fontFamily: "'Poppins', sans-serif" }}>
                {item.term}
              </h3>
              <p className="text-[#333] font-medium text-[11px] leading-[1.6] m-0">
                {item.definition}
              </p>
            </div>
          ))}
        </div>

        {/* --- Ilustrasi Labu Erlenmeyer Bulat (Kanan Bawah) --- */}
        <div className="absolute right-[-15px] bottom-[30px] w-[180px] h-[220px] pointer-events-none z-20">
          <svg viewBox="0 0 100 140" className="w-full h-full drop-shadow-xl">
            <defs>
              <radialGradient id="gradLiquidYellow" cx="50%" cy="85%" r="60%">
                <stop offset="0%" stopColor="#fef08a" />
                <stop offset="50%" stopColor="#eab308" />
                <stop offset="100%" stopColor="#a16207" />
              </radialGradient>
              <radialGradient id="gradBubble" cx="30%" cy="30%" r="70%">
                <stop offset="0%" stopColor="#fff" />
                <stop offset="100%" stopColor="#facc15" />
              </radialGradient>
            </defs>

            {/* Back of Glass */}
            <path d="M 40 30 L 40 60 C 25 70, 10 90, 10 110 C 10 135, 90 135, 90 110 C 90 90, 75 70, 60 60 L 60 30" fill="#f8fafc" opacity="0.4" />
            
            {/* Liquid */}
            <path d="M 12 105 C 12 132, 88 132, 88 105 C 88 92, 70 85, 50 85 C 30 85, 12 92, 12 105 Z" fill="url(#gradLiquidYellow)" />
            <ellipse cx="50" cy="90" rx="36" ry="6" fill="#fde047" opacity="0.9" />
            <ellipse cx="50" cy="90" rx="36" ry="6" fill="none" stroke="#ca8a04" strokeWidth="1" />
            
            {/* Bubbles in liquid */}
            <circle cx="35" cy="115" r="3" fill="#fff" opacity="0.7"/>
            <circle cx="65" cy="110" r="2.5" fill="#fff" opacity="0.7"/>
            <circle cx="50" cy="120" r="2" fill="#fff" opacity="0.8"/>
            <circle cx="45" cy="105" r="1.5" fill="#fff" opacity="0.9"/>
            <circle cx="58" cy="122" r="1.5" fill="#fff" opacity="0.8"/>
            <circle cx="40" cy="100" r="1" fill="#fff" opacity="0.9"/>

            {/* Rising Bubbles */}
            <circle cx="50" cy="80" r="2.5" fill="url(#gradBubble)" />
            <circle cx="48" cy="70" r="2" fill="url(#gradBubble)" />
            <circle cx="53" cy="55" r="3" fill="url(#gradBubble)" />
            <circle cx="49" cy="42" r="2" fill="url(#gradBubble)" />
            
            {/* Floating Bubble Outside */}
            <circle cx="51" cy="20" r="3.5" fill="url(#gradBubble)" />
            
            {/* Front Glass */}
            <path d="M 40 30 L 40 60 C 25 70, 10 90, 10 110 C 10 135, 90 135, 90 110 C 90 90, 75 70, 60 60 L 60 30" fill="none" stroke="#94a3b8" strokeWidth="1.5" opacity="0.7" />
            
            {/* Flask Lip */}
            <ellipse cx="50" cy="30" rx="14" ry="3" fill="none" stroke="#94a3b8" strokeWidth="2" opacity="0.8" />
            <ellipse cx="50" cy="28" rx="14" ry="3" fill="none" stroke="#94a3b8" strokeWidth="1.5" opacity="0.5" />
            <path d="M 36 30 C 36 30, 50 33, 64 30" fill="none" stroke="#94a3b8" strokeWidth="2" opacity="0.7" />
            
            {/* Highlights */}
            <path d="M 18 95 C 13 110, 20 125, 40 132" fill="none" stroke="#fff" strokeWidth="5" strokeLinecap="round" opacity="0.6" />
            <path d="M 82 95 C 87 110, 80 125, 60 132" fill="none" stroke="#fff" strokeWidth="2.5" strokeLinecap="round" opacity="0.4" />
            <path d="M 43 35 L 43 55" fill="none" stroke="#fff" strokeWidth="2" strokeLinecap="round" opacity="0.7" />
            <path d="M 85 105 C 85 110, 83 115, 80 120" fill="none" stroke="#fff" strokeWidth="1.5" strokeLinecap="round" opacity="0.5" />
          </svg>
        </div>

      </div>
      
    </div>
  );
});

export default PageFifteen;
