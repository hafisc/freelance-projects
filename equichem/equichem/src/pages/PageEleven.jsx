import React from 'react';

// ========================================================
// KOMPONEN: PageEleven
// DESKRIPSI: Halaman "Simulasi Interaktif" (Halaman 11 / Flipbook Hal 10)
// Desain berdasarkan 11.png
// ========================================================
const PageEleven = React.forwardRef((props, ref) => {
  
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
      active: true 
    },
    { 
      customIcon: (
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round" className="w-[18px] h-[18px] mb-0.5">
          <path d="M9 3h6m-3 0v7l-5 9h10l-5-9V3"></path>
        </svg>
      ), 
      label: 'Evaluasi', 
      active: false 
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

  const sliders = [
    {
      label: "Ubah konsentrasi A:",
      value: "1.0 M",
      percent: "80%",
      icon: (
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" className="w-3.5 h-3.5">
          <path d="M9 3h6"></path>
          <path d="M10 3v12a2 2 0 0 0 2 2h0a2 2 0 0 0 2-2V3"></path>
          <path d="M10 10h4"></path>
          <path d="M10 14h4"></path>
          <path d="M10 6h4"></path>
        </svg>
      )
    },
    {
      label: "Ubah suhu:",
      value: "298 K",
      percent: "75%",
      icon: (
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" className="w-3.5 h-3.5 text-red-600">
          <path d="M14 14.76V3.5a2.5 2.5 0 0 0-5 0v11.26a4.5 4.5 0 1 0 5 0z"></path>
          <path d="M12 11.5a2 2 0 1 0 0 4 2 2 0 0 0 0-4z" fill="currentColor"></path>
        </svg>
      )
    },
    {
      label: "Ubah tekanan:",
      value: "1.0 atm",
      percent: "80%",
      icon: (
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" className="w-3.5 h-3.5">
          <circle cx="12" cy="12" r="9"></circle>
          <path d="M12 12l2.5-2.5"></path>
          <path d="M8 12a4 4 0 1 1 8 0"></path>
          <path d="M12 6v1"></path>
          <path d="M6 12h1"></path>
          <path d="M18 12h-1"></path>
          <path d="M7.76 7.76l.71.71"></path>
          <path d="M16.24 7.76l-.71.71"></path>
        </svg>
      )
    },
    {
      label: "Ubah volume:",
      value: "1.0 L",
      percent: "85%",
      icon: (
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" className="w-3.5 h-3.5">
          <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
          <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
          <line x1="12" y1="22.08" x2="12" y2="12"></line>
        </svg>
      )
    }
  ];

  return (
    <div className="page bg-white relative w-full h-full overflow-hidden flex flex-col font-sans" ref={ref} data-density="soft">
      
      {/* Definisikan Gradient untuk Molekul */}
      <svg width="0" height="0">
        <defs>
          <radialGradient id="gradBlue2" cx="35%" cy="35%" r="65%">
            <stop offset="0%" stopColor="#60a5fa" />
            <stop offset="50%" stopColor="#2563eb" />
            <stop offset="100%" stopColor="#1e3a8a" />
          </radialGradient>
          <radialGradient id="gradOrange2" cx="35%" cy="35%" r="65%">
            <stop offset="0%" stopColor="#fca5a5" />
            <stop offset="50%" stopColor="#ea580c" />
            <stop offset="100%" stopColor="#9a3412" />
          </radialGradient>
        </defs>
      </svg>

      {/* === BACKGROUND ELEMENTS === */}
      <div className="absolute top-0 left-0 w-full h-[18%] z-0 pointer-events-none">
        <svg viewBox="0 0 1000 180" preserveAspectRatio="none" className="w-full h-full">
          <path d="M 0 0 L 0 110 C 100 80, 250 15, 450 15 C 650 15, 800 130, 1000 170 L 1000 0 Z" fill="#ffc107" />
          <path d="M 0 0 L 0 95 C 100 65, 250 0, 450 0 C 650 0, 800 115, 1000 155 L 1000 0 Z" fill="#002b80" />
        </svg>
      </div>
      
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

      <div className="absolute bottom-0 left-0 w-full h-[18%] z-0 pointer-events-none">
        <svg viewBox="0 0 1000 180" preserveAspectRatio="none" className="w-full h-full">
          <path d="M 0 0 C 150 15, 300 45, 500 80 C 700 115, 850 145, 1000 150 L 1000 180 L 0 180 Z" fill="#ffc107" />
          <path d="M 0 45 C 150 60, 300 90, 500 120 C 700 150, 850 170, 1000 180 L 0 180 Z" fill="#002b80" />
        </svg>
      </div>

      {/* === KONTEN HALAMAN === */}
      <div className="relative z-10 w-full h-full flex flex-col pt-[14%] px-[4%] pb-[8%]">
        
        {/* --- Judul Halaman --- */}
        <div className="mb-2 text-center">
          <h1 className="font-extrabold text-[#002b80] text-[20px] m-0 tracking-wide" style={{ fontFamily: "'Poppins', sans-serif" }}>
            SIMULASI INTERAKTIF
          </h1>
        </div>

        {/* --- Main Box w/ Sidebar --- */}
        <div className="flex-1 w-full bg-white rounded-[16px] shadow-[0_4px_20px_rgba(0,43,128,0.08)] border-[1.5px] border-[#eaf2ff] flex overflow-hidden relative z-10 h-[80%]">
          
          {/* --- Sidebar Kiri --- */}
          <div className="w-[18%] bg-[#0f2a5c] h-full flex flex-col py-3 z-20 shadow-md">
            {sidebarItems.map((item, idx) => (
              <div 
                key={idx} 
                className={`flex flex-col items-center justify-center py-2.5 w-full cursor-pointer transition-colors ${item.active ? 'bg-[#ffc107] text-[#002b80]' : 'hover:bg-[#1a3875] text-white'}`}
                onClick={() => {
                  const targetMap = { 'Beranda': 7, 'Materi': 8, 'PBL': 9, 'Evaluasi': 12, 'Profil': 13, 'Dashboard': 7 };
                  if (props.goToPage && targetMap[item.label] !== undefined) {
                    props.goToPage(targetMap[item.label]);
                  }
                }}
              >
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

          {/* --- Konten Kanan --- */}
          <div className="w-[82%] bg-white h-full pt-3 pb-2 px-3 relative flex flex-col">
            
            {/* Title / Instruction */}
            <h2 className="text-[#002b80] font-extrabold text-[12px] leading-tight m-0 mb-1 pl-2" style={{ fontFamily: "'Poppins', sans-serif" }}>
              Simulasi: Perubahan Konsentrasi
            </h2>

            {/* --- Ilustrasi Toples Gas & Reaksi --- */}
            <div className="flex flex-col items-center justify-center w-full mt-1">
              
              {/* Persamaan */}
              <div className="flex items-center gap-3 text-[#002b80] font-bold text-[14px] mb-1" style={{ fontFamily: "serif" }}>
                <span>aA + bB</span>
                <div className="flex flex-col justify-center items-center h-[20px] w-[40px]">
                  <svg viewBox="0 0 100 40" className="w-full h-full">
                    <line x1="0" y1="12" x2="95" y2="12" stroke="#002b80" strokeWidth="4.5" strokeLinecap="round"/>
                    <polyline points="80,0 95,12" fill="none" stroke="#002b80" strokeWidth="4.5" strokeLinecap="round" strokeLinejoin="round"/>
                    <line x1="5" y1="28" x2="100" y2="28" stroke="#002b80" strokeWidth="4.5" strokeLinecap="round"/>
                    <polyline points="20,40 5,28" fill="none" stroke="#002b80" strokeWidth="4.5" strokeLinecap="round" strokeLinejoin="round"/>
                  </svg>
                </div>
                <span>cC + dD</span>
              </div>

              <div className="flex justify-center items-center gap-3 w-full my-1">
                {/* Toples Kiri */}
                <svg viewBox="0 0 100 135" className="w-[90px] h-auto drop-shadow-md">
                  {/* Back of Glass */}
                  <path d="M 10 30 L 10 110 C 10 125, 90 125, 90 110 L 90 30" fill="#f1f5f9" opacity="0.8"/>
                  
                  {/* Molecules - Scattered Gas */}
                  <circle cx="28" cy="105" r="5.5" fill="url(#gradOrange2)" />
                  <circle cx="45" cy="85" r="5.5" fill="url(#gradOrange2)" />
                  <circle cx="75" cy="95" r="5.5" fill="url(#gradOrange2)" />
                  <circle cx="82" cy="70" r="5.5" fill="url(#gradOrange2)" />
                  <circle cx="20" cy="55" r="5.5" fill="url(#gradOrange2)" />
                  <circle cx="55" cy="115" r="5.5" fill="url(#gradOrange2)" />
                  
                  <circle cx="40" cy="105" r="5.5" fill="url(#gradBlue2)" />
                  <circle cx="50" cy="65" r="5.5" fill="url(#gradBlue2)" />
                  <circle cx="65" cy="50" r="5.5" fill="url(#gradBlue2)" />
                  <circle cx="22" cy="80" r="5.5" fill="url(#gradBlue2)" />
                  <circle cx="68" cy="82" r="5.5" fill="url(#gradBlue2)" />

                  {/* Glass Front Details */}
                  <path d="M 10 30 L 10 110 C 10 125, 90 125, 90 110 L 90 30" fill="none" stroke="#94a3b8" strokeWidth="1.5" opacity="0.8"/>
                  <ellipse cx="50" cy="115" rx="40" ry="10" fill="none" stroke="#94a3b8" strokeWidth="1.5" opacity="0.6"/>
                  <path d="M 16 40 L 16 105" fill="none" stroke="#fff" strokeWidth="3" opacity="0.8" strokeLinecap="round"/>
                  <path d="M 84 40 L 84 105" fill="none" stroke="#fff" strokeWidth="1.5" opacity="0.6" strokeLinecap="round"/>

                  {/* Lid (Tutup Toples) */}
                  <ellipse cx="50" cy="30" rx="42" ry="10" fill="#94a3b8" />
                  <path d="M 8 20 L 8 30 C 8 40, 92 40, 92 30 L 92 20 Z" fill="#cbd5e1" stroke="#94a3b8" strokeWidth="1.5"/>
                  <ellipse cx="50" cy="20" rx="42" ry="10" fill="#e2e8f0" stroke="#94a3b8" strokeWidth="1.5"/>
                  <ellipse cx="50" cy="18" rx="36" ry="7" fill="#f8fafc" opacity="0.8"/>
                </svg>

                {/* Tanda Panah Reversible Tengah */}
                <div className="w-[30px] h-[25px]">
                  <svg viewBox="0 0 100 40" className="w-full h-full">
                    <line x1="0" y1="12" x2="95" y2="12" stroke="#002b80" strokeWidth="5.5" strokeLinecap="round"/>
                    <polyline points="80,0 95,12" fill="none" stroke="#002b80" strokeWidth="5.5" strokeLinecap="round" strokeLinejoin="round"/>
                    <line x1="5" y1="28" x2="100" y2="28" stroke="#002b80" strokeWidth="5.5" strokeLinecap="round"/>
                    <polyline points="20,40 5,28" fill="none" stroke="#002b80" strokeWidth="5.5" strokeLinecap="round" strokeLinejoin="round"/>
                  </svg>
                </div>

                {/* Toples Kanan */}
                <svg viewBox="0 0 100 135" className="w-[90px] h-auto drop-shadow-md">
                  <path d="M 10 30 L 10 110 C 10 125, 90 125, 90 110 L 90 30" fill="#f1f5f9" opacity="0.8"/>
                  
                  {/* Molecules - Scattered Gas (Different arrangement) */}
                  <circle cx="65" cy="55" r="5.5" fill="url(#gradOrange2)" />
                  <circle cx="82" cy="90" r="5.5" fill="url(#gradOrange2)" />
                  <circle cx="35" cy="65" r="5.5" fill="url(#gradOrange2)" />
                  <circle cx="50" cy="110" r="5.5" fill="url(#gradOrange2)" />
                  <circle cx="75" cy="115" r="5.5" fill="url(#gradOrange2)" />
                  
                  <circle cx="22" cy="90" r="5.5" fill="url(#gradBlue2)" />
                  <circle cx="30" cy="115" r="5.5" fill="url(#gradBlue2)" />
                  <circle cx="55" cy="70" r="5.5" fill="url(#gradBlue2)" />
                  <circle cx="75" cy="55" r="5.5" fill="url(#gradBlue2)" />
                  <circle cx="60" cy="100" r="5.5" fill="url(#gradBlue2)" />

                  <path d="M 10 30 L 10 110 C 10 125, 90 125, 90 110 L 90 30" fill="none" stroke="#94a3b8" strokeWidth="1.5" opacity="0.8"/>
                  <ellipse cx="50" cy="115" rx="40" ry="10" fill="none" stroke="#94a3b8" strokeWidth="1.5" opacity="0.6"/>
                  <path d="M 16 40 L 16 105" fill="none" stroke="#fff" strokeWidth="3" opacity="0.8" strokeLinecap="round"/>
                  <path d="M 84 40 L 84 105" fill="none" stroke="#fff" strokeWidth="1.5" opacity="0.6" strokeLinecap="round"/>

                  <ellipse cx="50" cy="30" rx="42" ry="10" fill="#94a3b8" />
                  <path d="M 8 20 L 8 30 C 8 40, 92 40, 92 30 L 92 20 Z" fill="#cbd5e1" stroke="#94a3b8" strokeWidth="1.5"/>
                  <ellipse cx="50" cy="20" rx="42" ry="10" fill="#e2e8f0" stroke="#94a3b8" strokeWidth="1.5"/>
                  <ellipse cx="50" cy="18" rx="36" ry="7" fill="#f8fafc" opacity="0.8"/>
                </svg>
              </div>
            </div>

            {/* --- Sliders Controls --- */}
            <div className="flex flex-col gap-1.5 w-[90%] mt-1 ml-2 relative z-20">
              {sliders.map((slider, i) => (
                <div key={i} className="flex items-center gap-2">
                  <div className="w-[20px] h-[20px] rounded-full border-[1.5px] border-[#cce0ff] flex items-center justify-center text-[#002b80] shrink-0">
                    {slider.icon}
                  </div>
                  <div className="w-[85px] text-[#002b80] font-bold text-[10px]">{slider.label}</div>
                  
                  <div className="flex-1 h-[4.5px] bg-[#eaf2ff] rounded-full relative ml-1 border border-[#cce0ff] shadow-inner">
                    <div className="absolute left-0 top-0 h-full bg-[#0040cc] rounded-full" style={{ width: slider.percent }}></div>
                    <div className="absolute top-1/2 -translate-y-1/2 w-[10px] h-[10px] bg-[#002b80] rounded-full shadow-md cursor-pointer hover:scale-110 transition-transform" style={{ left: slider.percent, transform: 'translate(-50%, -50%)' }}></div>
                  </div>
                  
                  <div className="w-[45px] border-[1.5px] border-[#cce0ff] rounded-[6px] py-[3px] text-center text-[#002b80] font-bold text-[10px] ml-1 bg-white">
                    {slider.value}
                  </div>
                </div>
              ))}
            </div>

            {/* --- Buttons Row --- */}
            <div className="flex gap-2 mt-3 ml-2 relative z-20">
              <button className="bg-[#0052cc] hover:bg-[#0040a0] text-white font-bold text-[11px] py-1.5 px-6 rounded-[6px] shadow-sm transition-colors border-none cursor-pointer" style={{ fontFamily: "'Poppins', sans-serif" }}>
                Jalankan
              </button>
              <button className="bg-white hover:bg-[#f8fafc] text-[#002b80] font-bold text-[11px] py-1.5 px-7 rounded-[6px] shadow-sm transition-colors border-[1.5px] border-[#cce0ff] cursor-pointer" style={{ fontFamily: "'Poppins', sans-serif" }}>
                Reset
              </button>
            </div>
            
            {/* --- Footer Area (Illustration SVGs) --- */}
            <div className="absolute right-[-10px] bottom-[-5px] w-[150px] h-[90px] pointer-events-none z-0">
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
          <span className="font-extrabold text-[#002b80] text-[14px] leading-none mt-[1px]" style={{ fontFamily: "'Poppins', sans-serif" }}>10</span>
        </div>
        <div className="w-[12px] h-[3px] bg-[#ffc107] rounded-full"></div>
      </div>

    </div>
  );
});

export default PageEleven;
