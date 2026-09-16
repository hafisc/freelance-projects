import React from 'react';

// ========================================================
// KOMPONEN: PageTwelve
// DESKRIPSI: Halaman "Evaluasi" (Halaman 12 / Flipbook Hal 11)
// Desain berdasarkan 12.png
// ========================================================
const PageTwelve = React.forwardRef((props, ref) => {
  
  const sidebarItems = [
    { icon: 'bi-house-door', label: 'Beranda', active: false },
    { icon: 'bi-book', label: 'Materi', active: false },
    { 
      customIcon: (
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round" className="w-[18px] h-[18px] mb-0.5">
          <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
          <circle cx="9" cy="7" r="4"></circle>
          <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
          <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
        </svg>
      ), 
      label: 'PBL', 
      active: false 
    },
    { 
      customIcon: (
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round" className="w-[18px] h-[18px] mb-0.5">
          <path d="M9 3h6m-3 0v7l-5 9h10l-5-9V3"></path>
          <circle cx="12" cy="13" r="1.5" fill="currentColor"></circle>
        </svg>
      ), 
      label: 'Evaluasi', 
      active: true 
    },
    { icon: 'bi-person', label: 'Profil', active: false },
    { 
      customIcon: (
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round" className="w-[18px] h-[18px] mb-0.5">
          <rect x="3" y="5" width="18" height="14" rx="2"></rect>
          <path d="M 7 14 L 11 9 L 14 12 L 18 6"></path>
          <circle cx="18" cy="6" r="1.5" fill="currentColor"></circle>
        </svg>
      ), 
      label: 'Dashboard', 
      active: false 
    },
  ];

  const options = ['0,64', '1,60', '2,56', '4,00', '16,00'];

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
      <div className="relative z-10 w-full h-full flex flex-col pt-[13%] px-[4%] pb-[8%]">
        
        {/* --- Judul Halaman --- */}
        <div className="mb-2 pl-4">
          <h1 className="font-extrabold text-[#002b80] text-[20px] m-0 tracking-wide" style={{ fontFamily: "'Poppins', sans-serif" }}>
            EVALUASI
          </h1>
        </div>

        {/* --- Main Box w/ Sidebar --- */}
        <div className="flex-1 w-full flex relative z-10 h-[80%]">
          
          {/* --- Sidebar Kiri (melayang sedikit dari border konten) --- */}
          <div className="w-[18%] bg-[#0f2a5c] h-full flex flex-col py-3 z-30 shadow-md rounded-l-[12px] overflow-visible">
            {sidebarItems.map((item, idx) => (
              <div 
                key={idx} 
                className={`relative flex flex-col items-center justify-center py-2.5 w-full cursor-pointer transition-colors ${item.active ? 'bg-[#ffc107] text-[#002b80]' : 'hover:bg-[#1a3875] text-white'}`}
                onClick={() => {
                  const targetMap = { 'Beranda': 7, 'Materi': 8, 'PBL': 9, 'Evaluasi': 12, 'Profil': 13, 'Dashboard': 7 };
                  if (props.goToPage && targetMap[item.label] !== undefined) {
                    props.goToPage(targetMap[item.label]);
                  }
                }}
              >
                {/* Segitiga pointer untuk item aktif */}
                {item.active && (
                  <div className="absolute left-[-5px] top-1/2 -translate-y-1/2 w-0 h-0 border-t-[5px] border-t-transparent border-b-[5px] border-b-transparent border-r-[5px] border-r-[#ffc107]"></div>
                )}
                
                {item.customIcon ? (
                  <div className={`mb-0.5 ${item.active ? 'opacity-100' : 'opacity-80'}`}>
                    {item.customIcon}
                  </div>
                ) : (
                  <i className={`bi ${item.icon} text-[16px] mb-0.5 ${item.active ? 'opacity-100' : 'opacity-80'}`}></i>
                )}
                <span className={`text-[8px] font-bold tracking-wide ${item.active ? 'opacity-100' : 'opacity-80'}`}>
                  {item.label}
                </span>
              </div>
            ))}
          </div>

          {/* --- Konten Kanan (Tabs + Box Pertanyaan) --- */}
          <div className="w-[82%] h-full relative flex flex-col">
            
            {/* Tabs Header */}
            <div className="flex w-[95%] mx-auto z-20">
              <div className="bg-[#0033a0] text-white font-bold text-[11px] py-2 px-6 rounded-t-[8px] cursor-pointer flex-1 text-center shadow-sm relative z-10 border-b-0 border-[#cce0ff]">
                Latihan
              </div>
              <div className="bg-[#f8fafc] text-[#002b80] font-bold text-[11px] py-2 px-6 rounded-t-[8px] cursor-pointer border-[1px] border-[#cce0ff] border-b-0 border-l-0 flex-1 text-center hover:bg-[#f1f5f9] relative top-[1px]">
                Kuis
              </div>
              <div className="bg-[#f8fafc] text-[#002b80] font-bold text-[11px] py-2 px-6 rounded-t-[8px] cursor-pointer border-[1px] border-[#cce0ff] border-b-0 border-l-0 flex-1 text-center hover:bg-[#f1f5f9] relative top-[1px]">
                Ujian
              </div>
            </div>

            {/* Main White Area for Question */}
            <div className="bg-white border-[1px] border-[#cce0ff] rounded-[10px] rounded-tl-none flex-1 relative z-10 flex flex-col pt-5 px-4 pb-4 shadow-sm w-[95%] mx-auto">
              
              {/* Soal */}
              <div className="flex gap-2">
                <span className="text-[#002b80] font-extrabold text-[12px]">1.</span>
                <div className="flex flex-col gap-2">
                  <div className="text-[#000] font-bold text-[12px] leading-snug flex items-center gap-1 flex-wrap">
                    <span>Pada reaksi: N<sub className="text-[9px] font-bold">2</sub>O<sub className="text-[9px] font-bold">4(g)</sub></span>
                    <div className="w-[24px] h-[12px] flex items-center justify-center mx-1">
                      <svg viewBox="0 0 100 40" className="w-full h-full">
                        <line x1="0" y1="12" x2="95" y2="12" stroke="#002b80" strokeWidth="6" strokeLinecap="round"/>
                        <polyline points="75,0 95,12" fill="none" stroke="#002b80" strokeWidth="6" strokeLinecap="round" strokeLinejoin="round"/>
                        <line x1="5" y1="28" x2="100" y2="28" stroke="#002b80" strokeWidth="6" strokeLinecap="round"/>
                        <polyline points="25,40 5,28" fill="none" stroke="#002b80" strokeWidth="6" strokeLinecap="round" strokeLinejoin="round"/>
                      </svg>
                    </div>
                    <span>2NO<sub className="text-[9px] font-bold">2(g)</sub></span>
                  </div>
                  <div className="text-[#000] font-bold text-[12px] leading-snug pr-2 mt-1">
                    Jika pada keadaan setimbang [N<sub className="text-[9px] font-bold">2</sub>O<sub className="text-[9px] font-bold">4</sub>] = 0,1 M dan [NO<sub className="text-[9px] font-bold">2</sub>] = 0,4 M, maka K<sub className="text-[9px] font-bold">c</sub> adalah ...
                  </div>
                </div>
              </div>

              {/* Pilihan Ganda */}
              <div className="flex flex-col gap-3.5 mt-5 ml-4 relative z-20">
                {options.map((opt, i) => (
                  <div key={i} className="flex items-center gap-3 cursor-pointer group">
                    <div className="w-[20px] h-[20px] rounded-full border-[1px] border-[#93c5fd] flex items-center justify-center text-[#002b80] font-bold text-[11px] group-hover:bg-[#eff6ff] transition-colors shadow-sm bg-[#f8fafc]">
                      {String.fromCharCode(65 + i)}
                    </div>
                    <span className="text-[#000] font-extrabold text-[12px]">{opt}</span>
                  </div>
                ))}
              </div>

              {/* Button Cek Jawaban */}
              <div className="absolute bottom-4 left-1/2 -translate-x-[20%] z-30">
                <button className="bg-[#0033a0] hover:bg-[#002b80] text-white font-bold text-[11.5px] py-2 px-5 rounded-[6px] shadow-md transition-colors border-none cursor-pointer" style={{ fontFamily: "'Poppins', sans-serif" }}>
                  Cek Jawaban
                </button>
              </div>

              {/* --- Background Decorative Elements inside Card --- */}
              <div className="absolute bottom-[20px] left-[10px] w-[50px] h-[50px] pointer-events-none opacity-50">
                <svg viewBox="0 0 100 100">
                  <circle cx="20" cy="80" r="15" fill="none" stroke="#bfdbfe" strokeWidth="2"/>
                  <circle cx="80" cy="20" r="10" fill="none" stroke="#bfdbfe" strokeWidth="2"/>
                  <line x1="25" y1="70" x2="75" y2="28" stroke="#bfdbfe" strokeWidth="2"/>
                  <circle cx="50" cy="50" r="5" fill="#bfdbfe"/>
                </svg>
              </div>

            </div>
            
            {/* --- Footer Area (Illustration SVGs) OVERLAPPING THE CARD --- */}
            <div className="absolute right-[-5px] bottom-[-5px] w-[150px] h-[90px] pointer-events-none z-40">
              <svg viewBox="0 0 200 120" className="w-full h-full">
                {/* Background Leaves / Abstract shapes */}
                <path d="M 170 80 Q 185 65, 195 90 Q 180 100, 170 80" fill="#bae6fd" opacity="0.6"/>
                <path d="M 145 60 Q 165 40, 160 80 Q 140 90, 145 60" fill="#bae6fd" opacity="0.4"/>
                <path d="M 40 85 Q 20 60, 45 50 Q 60 70, 40 85" fill="#bae6fd" opacity="0.6"/>
                
                {/* Table line */}
                <line x1="10" y1="110" x2="190" y2="110" stroke="#002b80" strokeWidth="4" strokeLinecap="round"/>
                <line x1="20" y1="115" x2="180" y2="115" stroke="#001a4d" strokeWidth="2" strokeLinecap="round" opacity="0.2"/>
                
                {/* Erlenmeyer (Left) */}
                <g transform="translate(30, 20)">
                  <path d="M 25 80 C 25 90, 30 90, 40 90 C 50 90, 55 90, 55 80 L 48 45 L 32 45 Z" fill="#38bdf8"/>
                  <path d="M 40 10 L 40 30 L 20 80 C 15 90, 25 90, 40 90 C 55 90, 65 90, 60 80 L 40 30 L 40 10" fill="none" stroke="#64748b" strokeWidth="3.5" opacity="0.8"/>
                  <rect x="34" y="8" width="12" height="4" rx="2" fill="#e0f2fe" stroke="#64748b" strokeWidth="2"/>
                  <circle cx="35" cy="70" r="2.5" fill="#fff"/>
                  <circle cx="45" cy="80" r="2" fill="#fff"/>
                  <path d="M 27 75 C 27 85, 33 85, 40 85" fill="none" stroke="#fff" strokeWidth="3" strokeLinecap="round" opacity="0.7"/>
                </g>

                {/* Round Flask (Middle) */}
                <g transform="translate(90, 40)">
                  <path d="M 18 60 C 18 75, 42 75, 42 60 C 42 45, 35 45, 30 45 C 25 45, 18 50, 18 60 Z" fill="#ffc107"/>
                  <path d="M 30 10 L 30 35 C 15 40, 12 65, 30 68 C 48 65, 45 40, 30 35 L 30 10" fill="none" stroke="#64748b" strokeWidth="3.5" opacity="0.8"/>
                  <rect x="24" y="8" width="12" height="4" rx="2" fill="#e0f2fe" stroke="#64748b" strokeWidth="2"/>
                  <circle cx="25" cy="55" r="2" fill="#fff"/>
                  <path d="M 22 60 C 22 65, 26 65, 30 65" fill="none" stroke="#fff" strokeWidth="3" strokeLinecap="round" opacity="0.7"/>
                </g>

                {/* Test Tube (Right) */}
                <g transform="translate(145, 45)">
                  <path d="M 10 55 L 10 30 L 20 30 L 20 55 C 20 62, 10 62, 10 55 Z" fill="#0284c7"/>
                  <path d="M 10 10 L 10 55 C 10 65, 20 65, 20 55 L 20 10" fill="none" stroke="#64748b" strokeWidth="3.5" opacity="0.8"/>
                  <rect x="7" y="8" width="16" height="4" rx="2" fill="#e0f2fe" stroke="#64748b" strokeWidth="2"/>
                  <circle cx="13" cy="45" r="1.5" fill="#fff"/>
                  <line x1="13" y1="20" x2="13" y2="40" stroke="#fff" strokeWidth="2" strokeLinecap="round" opacity="0.5"/>
                </g>

                {/* Decorative Bubbles around */}
                <circle cx="20" cy="50" r="3" fill="#bae6fd" opacity="0.8"/>
                <circle cx="35" cy="30" r="1.5" fill="#bae6fd" opacity="0.8"/>
                <circle cx="160" cy="30" r="4.5" fill="#bae6fd" opacity="0.7"/>
                <circle cx="140" cy="20" r="2" fill="#bae6fd" opacity="0.8"/>
                <circle cx="85" cy="35" r="2.5" fill="#bae6fd" opacity="0.8"/>
                <circle cx="105" cy="25" r="1.5" fill="#bae6fd" opacity="0.8"/>
              </svg>
            </div>

          </div>
        </div>

      </div>
      
      {/* --- Nomor Halaman (Kanan Bawah) --- */}
      <div className="absolute right-[6%] bottom-[4%] z-20 flex items-center justify-center gap-2">
        <div className="w-[12px] h-[3px] bg-[#ffc107] rounded-full"></div>
        <div className="w-[28px] h-[28px] bg-white border-[2.5px] border-[#002b80] rounded-lg flex items-center justify-center shadow-sm">
          <span className="font-extrabold text-[#002b80] text-[14px] leading-none mt-[1px]" style={{ fontFamily: "'Poppins', sans-serif" }}>11</span>
        </div>
        <div className="w-[12px] h-[3px] bg-[#ffc107] rounded-full"></div>
      </div>

    </div>
  );
});

export default PageTwelve;
