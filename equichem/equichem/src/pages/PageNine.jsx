import React from 'react';

// ========================================================
// KOMPONEN: PageNine
// DESKRIPSI: Halaman "Aktivitas PBL (Tahapan)" (Halaman 9 / Flipbook Hal 8)
// Desain berdasarkan 9.png
// ========================================================
const PageNine = React.forwardRef((props, ref) => {
  
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

  const pblSteps = [
    {
      num: 1,
      title: 'Orientasi Masalah',
      desc: 'Mengamati fenomena dan memahami masalah.',
      icon: (
        <svg viewBox="0 0 24 24" fill="none" stroke="#002b80" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" className="w-6 h-6">
          <circle cx="10" cy="10" r="7" fill="#ffc107" fillOpacity="0.25" stroke="none"></circle>
          <circle cx="10" cy="10" r="7"></circle>
          <path d="M15 15l5 5"></path>
          <path d="M10 7a3 3 0 0 1 2.5 4.5 1.5 1.5 0 0 0-1 1.5" strokeWidth="1.2"></path>
          <circle cx="10" cy="14" r="0.8" fill="#002b80" stroke="none"></circle>
          <line x1="16" y1="16" x2="19.5" y2="19.5" stroke="#ffc107" strokeWidth="4"></line>
        </svg>
      )
    },
    {
      num: 2,
      title: 'Mengorganisasi Siswa',
      desc: 'Mengidentifikasi informasi yang dibutuhkan.',
      icon: (
        <svg viewBox="0 0 24 24" fill="none" stroke="#002b80" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" className="w-6 h-6">
          <rect x="4" y="4" width="12" height="12" rx="1" fill="#fff" stroke="#ffc107" strokeWidth="1.5"></rect>
          <path d="M17 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"></path>
          <circle cx="10" cy="8" r="4" fill="#ffc107" fillOpacity="0.25"></circle>
          <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
          <path d="M17 4.13a4 4 0 0 1 0 7.75"></path>
        </svg>
      )
    },
    {
      num: 3,
      title: 'Investigasi',
      desc: 'Mencari informasi, melakukan eksperimen/observasi.',
      icon: (
        <svg viewBox="0 0 24 24" fill="none" stroke="#002b80" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" className="w-5 h-5">
          <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
          <path d="M13 2v7h7"></path>
          <line x1="8" y1="13" x2="13" y2="13"></line>
          <line x1="8" y1="17" x2="11" y2="17"></line>
          <circle cx="16.5" cy="16.5" r="3.5" fill="#ffc107" fillOpacity="0.25"></circle>
          <line x1="19" y1="19" x2="22" y2="22" strokeWidth="2"></line>
          <circle cx="8" cy="9" r="1" fill="#ffc107" stroke="none"></circle>
          <line x1="10" y1="9" x2="13" y2="9"></line>
        </svg>
      )
    },
    {
      num: 4,
      title: 'Mengembangkan & Menyajikan Solusi',
      desc: 'Menyusun solusi dan presentasi.',
      icon: (
        <svg viewBox="0 0 24 24" fill="none" stroke="#002b80" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" className="w-6 h-6">
          <circle cx="12" cy="11" r="5" fill="#ffc107" fillOpacity="0.25"></circle>
          <path d="M9 18h6"></path>
          <path d="M10 21h4"></path>
          <path d="M15.09 14.5A4.5 4.5 0 0 0 12 4.5a4.5 4.5 0 0 0-4.5 4.5c0 1.2.4 2.2 1.4 3"></path>
          <line x1="12" y1="18" x2="12" y2="21"></line>
          <line x1="12" y1="1" x2="12" y2="2.5"></line>
          <line x1="19" y1="8" x2="20.5" y2="8"></line>
          <line x1="5" y1="8" x2="3.5" y2="8"></line>
          <line x1="17" y1="3" x2="18" y2="2"></line>
          <line x1="7" y1="3" x2="6" y2="2"></line>
        </svg>
      )
    },
    {
      num: 5,
      title: 'Analisis & Evaluasi',
      desc: 'Mengevaluasi proses dan hasil pemecahan masalah.',
      icon: (
        <svg viewBox="0 0 24 24" fill="none" stroke="#002b80" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" className="w-6 h-6">
          <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
          <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
          <line x1="8" y1="11" x2="14" y2="11"></line>
          <line x1="8" y1="15" x2="11" y2="15"></line>
          <path d="M7 7.5c0-.8.6-1.5 1.5-1.5s1.5.7 1.5 1.5c0 1.5-1.5 2-1.5 2s-1.5-.5-1.5-2z" fill="#ffc107" stroke="none"></path>
          
          <circle cx="17" cy="18" r="5" fill="#ffc107" stroke="none"></circle>
          <circle cx="17" cy="18" r="5"></circle>
          <path d="M14.5 18.5l1.5 1.5 3-3"></path>
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
        {/* Menggunakan SVG Molekul sama dengan halaman sebelumnya */}
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
      <div className="relative z-10 w-full h-full flex flex-col pt-[15%] px-[4%] pb-[8%]">
        
        {/* --- Judul Halaman (Luar Box) --- */}
        <div className="mb-2 text-center">
          <h1 className="font-extrabold text-[#002b80] text-[20px] m-0 tracking-wide" style={{ fontFamily: "'Poppins', sans-serif" }}>
            AKTIVITAS PBL (TAHAPAN)
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
                {/* Support Custom SVG Icons or Bootstrap Icons */}
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
          <div className="w-[82%] bg-white h-full pt-4 pb-2 px-4 relative flex flex-col">
            
            {/* Title */}
            <h2 className="text-[#002b80] font-extrabold text-[15px] leading-tight m-0 mb-1 pl-1" style={{ fontFamily: "'Poppins', sans-serif" }}>
              Tahapan PBL
            </h2>
            
            {/* Underline */}
            <div className="flex gap-1 mb-3 pl-1">
              <div className="w-[20px] h-[2.5px] bg-[#ffc107] rounded-full"></div>
            </div>

            {/* --- Timeline Tahapan PBL --- */}
            <div className="relative flex-1 w-full flex flex-col justify-between pl-[3px] py-1">
              {/* Vertical Dashed Line */}
              <div className="absolute left-[13px] top-[20px] bottom-[20px] w-[2px] border-l-[1.5px] border-dashed border-[#cce0ff] z-0"></div>
              
              {pblSteps.map((step, idx) => (
                <div className="flex items-center relative z-10" key={idx}>
                  {/* Circle Number */}
                  <div className="w-6 h-6 rounded-full bg-[#ffc107] flex items-center justify-center font-extrabold text-[#002b80] text-[13px] shrink-0 mr-3 shadow-sm border border-[#eab308]">
                    {step.num}
                  </div>
                  
                  {/* Content Box */}
                  <div className="flex-1 bg-white border-[1px] border-[#eaf2ff] rounded-[10px] p-2 flex items-center shadow-[0_2px_8px_rgba(0,0,0,0.03)] w-full">
                    {/* Icon Circle */}
                    <div className="w-9 h-9 rounded-full bg-[#fffcf0] flex items-center justify-center shrink-0 mr-3 border border-[#fef3c7]">
                      {step.icon}
                    </div>
                    {/* Text */}
                    <div className="flex flex-col flex-1 pr-1">
                      <h4 className="text-[#002b80] font-bold text-[10.5px] leading-tight m-0 mb-0.5">{step.title}</h4>
                      <p className="text-[#444] text-[9px] leading-[1.3] m-0 font-medium">
                        {step.desc}
                      </p>
                    </div>
                  </div>
                </div>
              ))}
            </div>
            
            {/* --- Footer Area (Illustration SVGs) --- */}
            {/* Abstact Flask Illustration di sudut kanan bawah */}
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
          <span className="font-extrabold text-[#002b80] text-[14px] leading-none mt-[1px]" style={{ fontFamily: "'Poppins', sans-serif" }}>8</span>
        </div>
        <div className="w-[12px] h-[3px] bg-[#ffc107] rounded-full"></div>
      </div>

    </div>
  );
});

export default PageNine;
