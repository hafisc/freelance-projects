import React from 'react';

// ========================================================
// KOMPONEN: PageThirteen
// DESKRIPSI: Halaman "Hasil & Progress Belajar" (Halaman 13 / Flipbook Hal 12)
// Desain berdasarkan 13.png
// ========================================================
const PageThirteen = React.forwardRef((props, ref) => {
  
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
      <div className="absolute top-[5%] right-[-10%] w-[50%] h-[55%] z-[1] pointer-events-none opacity-[0.07]">
        <svg viewBox="0 0 400 500" className="w-full h-full">
          <circle cx="200" cy="100" r="16" fill="none" stroke="#002b80" strokeWidth="4"/>
          <circle cx="300" cy="180" r="16" fill="none" stroke="#002b80" strokeWidth="4"/>
          <circle cx="120" cy="180" r="16" fill="none" stroke="#002b80" strokeWidth="4"/>
          <circle cx="200" cy="260" r="16" fill="none" stroke="#002b80" strokeWidth="4"/>
          <line x1="188" y1="112" x2="132" y2="168" stroke="#002b80" strokeWidth="3"/>
          <line x1="212" y1="112" x2="288" y2="168" stroke="#002b80" strokeWidth="3"/>
          <line x1="132" y1="192" x2="188" y2="248" stroke="#002b80" strokeWidth="3"/>
          <line x1="288" y1="192" x2="212" y2="248" stroke="#002b80" strokeWidth="3"/>
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
        
        {/* --- Main Area w/ Sidebar --- */}
        <div className="flex-1 w-full flex relative z-10 h-full">
          
          {/* --- Sidebar Kiri --- */}
          <div className="w-[18%] bg-[#0f2a5c] h-[80%] flex flex-col py-3 z-30 shadow-md rounded-[12px] overflow-visible">
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
                  <div className="absolute right-[-6px] top-1/2 -translate-y-1/2 w-0 h-0 border-t-[6px] border-t-transparent border-b-[6px] border-b-transparent border-l-[6px] border-l-[#ffc107]"></div>
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

          {/* --- Konten Kanan --- */}
          <div className="w-[82%] h-full relative flex flex-col pl-4 pt-1">
            
            {/* Judul Halaman */}
            <div className="mb-3">
              <h1 className="font-extrabold text-[#002b80] text-[18px] m-0 tracking-wide" style={{ fontFamily: "'Poppins', sans-serif" }}>
                HASIL & PROGRESS BELAJAR
              </h1>
            </div>

            {/* Main White Area Card */}
            <div className="bg-white border-[1px] border-[#e2e8f0] rounded-[12px] flex-1 relative z-10 flex flex-col shadow-sm">
              
              {/* TOP HALF: Charts and Stats */}
              <div className="flex px-4 py-6 border-b-[1px] border-[#e2e8f0]">
                
                {/* Donut Chart */}
                <div className="w-[50%] flex justify-center items-center">
                  <svg viewBox="0 0 100 100" className="w-[120px] h-[120px] drop-shadow-sm">
                    {/* Light blue base circle (25%) */}
                    <circle cx="50" cy="50" r="34" fill="none" stroke="#dbeafe" strokeWidth="17" />
                    
                    {/* Yellow segment (37.5%) */}
                    <circle cx="50" cy="50" r="34" fill="none" stroke="#ffc107" strokeWidth="17" 
                            strokeDasharray="80.11 213.63" strokeDashoffset="-80.11" transform="rotate(-90 50 50)" />
                            
                    {/* Dark blue segment (37.5%) */}
                    <circle cx="50" cy="50" r="34" fill="none" stroke="#0033a0" strokeWidth="17" 
                            strokeDasharray="80.11 213.63" strokeDashoffset="0" transform="rotate(-90 50 50)" />
                            
                    <text x="50" y="53" textAnchor="middle" fill="#002b80" fontSize="20" fontWeight="900" fontFamily="'Poppins', sans-serif" letterSpacing="-0.5px">75%</text>
                    <text x="50" y="67" textAnchor="middle" fill="#002b80" fontSize="8" fontWeight="600" fontFamily="sans-serif">Selesai</text>
                  </svg>
                </div>

                {/* Stats & Button */}
                <div className="w-[50%] flex flex-col justify-center gap-4 pl-3">
                  
                  <div className="flex items-center gap-3">
                    <div className="w-[30px] h-[30px] rounded-full bg-[#eff6ff] flex items-center justify-center shrink-0 border border-[#dbeafe]">
                      <svg viewBox="0 0 24 24" fill="none" stroke="#0033a0" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" className="w-4 h-4">
                        <path d="M12 4L3 9l9 5 9-5-9-5z"></path>
                        <path d="M21 9v6.5a2 2 0 01-2 2h-1"></path>
                        <path d="M5 10v6a3 3 0 003 3h8a3 3 0 003-3v-6"></path>
                      </svg>
                    </div>
                    <div className="flex flex-col">
                      <span className="text-[#002b80] font-bold text-[11.5px] leading-tight">Unit Selesai</span>
                      <span className="text-[#475569] font-medium text-[10.5px] mt-[1px]">6 dari 8</span>
                    </div>
                  </div>
                  
                  <div className="flex items-center gap-3">
                    <div className="w-[30px] h-[30px] rounded-full bg-[#eff6ff] flex items-center justify-center shrink-0 border border-[#dbeafe]">
                      <svg viewBox="0 0 24 24" fill="none" stroke="#0033a0" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" className="w-4 h-4">
                        <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                        <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                        <path d="M9 10l1 1 2-2"></path>
                        <path d="M9 14l1 1 2-2"></path>
                        <path d="M14 10h3"></path>
                        <path d="M14 14h3"></path>
                      </svg>
                    </div>
                    <div className="flex flex-col">
                      <span className="text-[#002b80] font-bold text-[11.5px] leading-tight">Skor Evaluasi</span>
                      <span className="text-[#475569] font-medium text-[10.5px] mt-[1px]">80 / 100</span>
                    </div>
                  </div>

                  <button className="bg-[#ffc107] hover:bg-[#eab308] text-[#002b80] font-bold text-[11px] py-[6px] px-4 rounded-[6px] w-[90%] shadow-sm transition-colors border-none cursor-pointer mt-1" style={{ fontFamily: "'Poppins', sans-serif" }}>
                    Lihat Detail
                  </button>
                  
                </div>
              </div>

              {/* BOTTOM HALF: Pencapaian */}
              <div className="flex flex-col px-4 pt-3 pb-5 flex-1">
                <h3 className="text-[#002b80] font-bold text-[13px] m-0" style={{ fontFamily: "'Poppins', sans-serif" }}>
                  Pencapaian
                </h3>
                
                {/* Achievement Timeline */}
                <div className="relative flex justify-between items-center w-[85%] mx-auto mt-5 mb-2 h-[50px]">
                  {/* Background Line */}
                  <div className="absolute top-[35%] left-0 w-full h-[1.5px] bg-[#bfdbfe] z-0"></div>
                  
                  {/* Decorative Dots on line */}
                  <div className="absolute top-[35%] left-[25%] -translate-x-1/2 -translate-y-1/2 w-[5px] h-[5px] rounded-full border-[1px] border-[#93c5fd] bg-white z-10"></div>
                  <div className="absolute top-[35%] left-[75%] -translate-x-1/2 -translate-y-1/2 w-[5px] h-[5px] rounded-full border-[1px] border-[#93c5fd] bg-white z-10"></div>
                  
                  {/* Badge 1 */}
                  <div className="flex flex-col items-center relative z-20 gap-2 h-full justify-start">
                    <div className="w-[36px] h-[36px] rounded-full bg-[#eff6ff] border border-[#bfdbfe] flex items-center justify-center shadow-sm relative">
                       <svg viewBox="0 0 24 24" fill="none" stroke="#0033a0" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" className="w-5 h-5">
                         <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                       </svg>
                    </div>
                    <span className="text-[#002b80] font-extrabold text-[10px]">Konsisten</span>
                  </div>
                  
                  {/* Badge 2 */}
                  <div className="flex flex-col items-center relative z-20 gap-2 h-full justify-start">
                    <div className="w-[36px] h-[36px] rounded-full bg-[#eff6ff] border border-[#bfdbfe] flex items-center justify-center shadow-sm relative">
                       <svg viewBox="0 0 24 24" fill="none" stroke="#0033a0" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" className="w-5 h-5">
                         <circle cx="12" cy="8" r="5"></circle>
                         <path d="M8.5 11.5L7 22l5-3 5 3-1.5-10.5"></path>
                       </svg>
                    </div>
                    <span className="text-[#002b80] font-extrabold text-[10px]">Teliti</span>
                  </div>

                  {/* Badge 3 */}
                  <div className="flex flex-col items-center relative z-20 gap-2 h-full justify-start">
                    <div className="w-[36px] h-[36px] rounded-full bg-[#eff6ff] border border-[#bfdbfe] flex items-center justify-center shadow-sm relative">
                       <svg viewBox="0 0 24 24" fill="none" stroke="#0033a0" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" className="w-5 h-5">
                         <path d="M12 2l3 7 7 1-5 5 1.5 7.5L12 19l-6.5 3.5L7 15l-5-5 7-1 3-7z"></path>
                       </svg>
                    </div>
                    <span className="text-[#002b80] font-extrabold text-[10px]">Problem Solver</span>
                  </div>
                </div>

              </div>

            </div>

          </div>
        </div>

      </div>
      
      {/* --- Nomor Halaman (Kanan Bawah) --- */}
      <div className="absolute right-[6%] bottom-[4%] z-20 flex items-center justify-center gap-2">
        <div className="w-[12px] h-[3px] bg-[#ffc107] rounded-full"></div>
        <div className="w-[28px] h-[28px] bg-white border-[2.5px] border-[#002b80] rounded-lg flex items-center justify-center shadow-sm">
          <span className="font-extrabold text-[#002b80] text-[14px] leading-none mt-[1px]" style={{ fontFamily: "'Poppins', sans-serif" }}>12</span>
        </div>
        <div className="w-[12px] h-[3px] bg-[#ffc107] rounded-full"></div>
      </div>

    </div>
  );
});

export default PageThirteen;
