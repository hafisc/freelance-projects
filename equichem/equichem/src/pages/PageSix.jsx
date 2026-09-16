import React from 'react';

// ========================================================
// KOMPONEN: PageSix
// DESKRIPSI: Halaman "Tujuan Pembelajaran" (Halaman 6 / Flipbook Hal 5)
// Desain berdasarkan 6.png
// ========================================================
const PageSix = React.forwardRef((props, ref) => {
  
  const objectives = [
    {
      num: 1,
      text: 'Menjelaskan konsep kesetimbangan dinamis dalam reaksi kimia.',
      icon: (
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round" className="w-5 h-5 text-[#002b80]">
          <path d="M9 3h6"></path>
          <path d="M10 3v5l-5 9a2 2 0 0 0 2 3h10a2 2 0 0 0 2-3l-5-9V3"></path>
          <path d="M7 16h10"></path>
          <circle cx="10" cy="14" r="1" fill="currentColor" stroke="none"></circle>
          <circle cx="13" cy="18" r="1" fill="currentColor" stroke="none"></circle>
          <circle cx="14" cy="13" r="0.5" fill="currentColor" stroke="none"></circle>
        </svg>
      )
    },
    {
      num: 2,
      text: <>Menentukan nilai tetapan kesetimbangan (<i>K<sub>c</sub>, K<sub>p</sub></i>).</>,
      icon: (
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round" className="w-5 h-5 text-[#002b80]">
          <path d="M3 21h18"></path>
          <rect x="5" y="14" width="4" height="7" fill="#002b80" fillOpacity="0.2"></rect>
          <rect x="11" y="10" width="4" height="11" fill="#002b80" fillOpacity="0.2"></rect>
          <rect x="17" y="6" width="4" height="15" fill="#002b80" fillOpacity="0.2"></rect>
          <path d="M4 15l6-6 4 4 7-7"></path>
          <path d="M17 6h4v4"></path>
        </svg>
      )
    },
    {
      num: 3,
      text: 'Menganalisis faktor-faktor yang mempengaruhi kesetimbangan.',
      icon: (
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round" className="w-5 h-5 text-[#002b80]">
          <path d="M12 3v18"></path>
          <path d="M8 21h8"></path>
          <path d="M4 9h16"></path>
          <path d="M4 9l-2 6c0 1.5 1 2 2 2s2-.5 2-2l-2-6z" fill="#002b80" fillOpacity="0.1"></path>
          <path d="M20 9l-2 6c0 1.5 1 2 2 2s2-.5 2-2l-2-6z" fill="#002b80" fillOpacity="0.1"></path>
          <circle cx="12" cy="4" r="1" fill="currentColor"></circle>
        </svg>
      )
    },
    {
      num: 4,
      text: 'Menyelesaikan masalah kontekstual yang berkaitan dengan kesetimbangan kimia.',
      icon: (
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round" className="w-5 h-5 text-[#002b80]">
          <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
          <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
          <path d="M9 7h6"></path>
          <path d="M9 11h6"></path>
          <path d="M15 3c-1.5 0-3-1-3-3 0 2-1.5 3-3 3 1.5 0 3 1 3 3 0-2 1.5-3 3-3z" fill="#002b80" fillOpacity="0.2"></path>
        </svg>
      )
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
      <div className="relative z-10 w-full h-full flex flex-col pt-[18%] px-[6%] pb-[8%]">
        
        {/* --- Judul: TUJUAN PEMBELAJARAN --- */}
        <div className="mb-4">
          <h1 className="font-extrabold text-[#002b80] text-[26px] m-0 leading-none tracking-tight" style={{ fontFamily: "'Poppins', sans-serif" }}>
            TUJUAN PEMBELAJARAN
          </h1>
          <div className="flex mt-2 gap-1">
            <div className="w-[45px] h-[3px] bg-[#002b80] rounded-full"></div>
            <div className="w-[30px] h-[3px] bg-[#ffc107] rounded-full"></div>
          </div>
        </div>

        {/* --- Main Box --- */}
        <div className="flex-1 w-full bg-[#fcfdff] border-[1.5px] border-[#cce0ff] rounded-[16px] shadow-sm flex flex-col p-4 relative z-10">
          
          {/* Header Row: Target Icon + Text */}
          <div className="flex items-center mb-4 pl-1">
            {/* Target Icon SVG */}
            <div className="w-10 h-10 shrink-0 flex items-center justify-center mr-3">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.2" strokeLinecap="round" strokeLinejoin="round" className="w-full h-full text-[#002b80]">
                <circle cx="12" cy="12" r="10"></circle>
                <circle cx="12" cy="12" r="6"></circle>
                <circle cx="12" cy="12" r="2" fill="#002b80"></circle>
                <path d="M22 2l-8 8"></path>
                <path d="M18 2h4v4"></path>
              </svg>
            </div>
            {/* Text */}
            <p className="text-[#002b80] font-bold text-[11px] leading-[1.3] m-0">
              Setelah mempelajari micromodul ini,<br/>
              diharapkan kalian dapat:
            </p>
          </div>

          {/* List of Objectives */}
          <div className="flex flex-col gap-2.5 w-full">
            {objectives.map((obj, i) => (
              <div key={i} className="w-full bg-[#f8fbff] border-[1.5px] border-dashed border-[#a3c7ff] rounded-[12px] p-2.5 flex items-center shadow-sm">
                
                {/* Number Circle with Yellow Crescent */}
                <div className="relative w-8 h-8 shrink-0 mr-3 ml-1">
                  {/* Yellow Offset Crescent */}
                  <div className="absolute -left-[2.5px] top-[1.5px] w-full h-full rounded-full bg-[#ffc107]"></div>
                  {/* Main Blue Circle */}
                  <div className="absolute inset-0 rounded-full bg-[#002b80] flex items-center justify-center text-white font-extrabold text-[15px]" style={{ fontFamily: "'Poppins', sans-serif" }}>
                    {obj.num}
                  </div>
                </div>

                {/* Text */}
                <p className="flex-1 text-[#002b80] font-bold text-[11px] leading-[1.3] m-0 pr-3">
                  {obj.text}
                </p>

                {/* Icon Circle */}
                <div className="w-9 h-9 rounded-full bg-[#e3eeff] flex items-center justify-center shrink-0 mr-1">
                  {obj.icon}
                </div>

              </div>
            ))}
          </div>

        </div>
      </div>
      
      {/* --- Nomor Halaman (Kanan Bawah) --- */}
      <div className="absolute right-[6%] bottom-[4%] z-20 flex items-center justify-center gap-2">
        <div className="w-[12px] h-[3px] bg-[#ffc107] rounded-full"></div>
        <div className="w-[28px] h-[28px] bg-white border-[2.5px] border-[#002b80] rounded-lg flex items-center justify-center shadow-sm">
          <span className="font-extrabold text-[#002b80] text-[14px] leading-none mt-[1px]" style={{ fontFamily: "'Poppins', sans-serif" }}>5</span>
        </div>
        <div className="w-[12px] h-[3px] bg-[#ffc107] rounded-full"></div>
      </div>

    </div>
  );
});

export default PageSix;
