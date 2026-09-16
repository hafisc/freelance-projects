import React from 'react';

// ========================================================
// KOMPONEN: PageTen
// DESKRIPSI: Halaman "Contoh Aktivitas / LKPD Digital" (Halaman 10 / Flipbook Hal 9)
// Desain berdasarkan 10.png
// ========================================================
const PageTen = React.forwardRef((props, ref) => {
  
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

  return (
    <div className="page bg-white relative w-full h-full overflow-hidden flex flex-col font-sans" ref={ref} data-density="soft">
      
      {/* Definisikan Gradient untuk Molekul */}
      <svg width="0" height="0">
        <defs>
          <radialGradient id="gradBlue" cx="35%" cy="35%" r="65%">
            <stop offset="0%" stopColor="#60a5fa" />
            <stop offset="50%" stopColor="#2563eb" />
            <stop offset="100%" stopColor="#1e3a8a" />
          </radialGradient>
          <radialGradient id="gradOrange" cx="35%" cy="35%" r="65%">
            <stop offset="0%" stopColor="#fca5a5" />
            <stop offset="50%" stopColor="#ea580c" />
            <stop offset="100%" stopColor="#9a3412" />
          </radialGradient>
        </defs>
      </svg>

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
      <div className="relative z-10 w-full h-full flex flex-col pt-[14%] px-[4%] pb-[8%]">
        
        {/* --- Judul Halaman (Luar Box) --- */}
        <div className="mb-2 text-center">
          <h1 className="font-extrabold text-[#002b80] text-[18px] m-0 tracking-wide" style={{ fontFamily: "'Poppins', sans-serif" }}>
            CONTOH AKTIVITAS / LKPD DIGITAL
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
                  <div className={`mb-0.5 ${item.active ? 'opacity-100 text-[#002b80]' : 'opacity-80 text-white'}`}>
                    {item.customIcon}
                  </div>
                ) : (
                  <i className={`bi ${item.icon} text-[16px] mb-0.5 ${item.active ? 'opacity-100 text-[#ffc107]' : 'opacity-80 text-white'}`}></i>
                )}
                
                <span className={`text-[8px] font-medium tracking-wide ${item.active ? 'opacity-100 text-[#ffc107]' : 'opacity-80 text-white'}`}>
                  {item.label}
                </span>
              </div>
            ))}
          </div>

          {/* --- Konten Kanan --- */}
          <div className="w-[82%] bg-white h-full pt-4 pb-2 px-4 relative flex flex-col">
            
            {/* Title / Instruction */}
            <h2 className="text-[#002b80] font-bold text-[12px] leading-tight m-0 mb-3 pl-1" style={{ fontFamily: "'Poppins', sans-serif" }}>
              <span className="font-extrabold text-[#002b80]">Aktivitas 1:</span> <span className="text-[#333] font-medium">Perhatikan gambar reaksi berikut!</span>
            </h2>

            {/* --- Ilustrasi Gelas Kimia & Reaksi --- */}
            <div className="flex justify-center items-center gap-3 w-full my-2">
              
              {/* Gelas Kiri */}
              <svg viewBox="0 0 100 125" className="w-[85px] h-auto drop-shadow-md">
                {/* Back of Glass */}
                <path d="M 10 20 L 10 110 C 10 120, 90 120, 90 110 L 90 20" fill="#f8fafc" opacity="0.6"/>
                {/* Liquid */}
                <path d="M 12 60 L 12 110 C 12 118, 88 118, 88 110 L 88 60 Z" fill="#bae6fd" opacity="0.5"/>
                <ellipse cx="50" cy="60" rx="38" ry="10" fill="#7dd3fc" opacity="0.6"/>
                <ellipse cx="50" cy="60" rx="38" ry="10" fill="none" stroke="#0ea5e9" strokeWidth="1" opacity="0.5"/>
                
                {/* Molecules */}
                {/* Orange */}
                <circle cx="28" cy="98" r="5.5" fill="url(#gradOrange)" />
                <circle cx="45" cy="110" r="5.5" fill="url(#gradOrange)" />
                <circle cx="75" cy="100" r="5.5" fill="url(#gradOrange)" />
                <circle cx="78" cy="80" r="5.5" fill="url(#gradOrange)" />
                <circle cx="20" cy="72" r="5.5" fill="url(#gradOrange)" />
                
                {/* Blue */}
                <circle cx="35" cy="85" r="5.5" fill="url(#gradBlue)" />
                <circle cx="50" cy="95" r="5.5" fill="url(#gradBlue)" />
                <circle cx="65" cy="85" r="5.5" fill="url(#gradBlue)" />
                <circle cx="22" cy="88" r="5.5" fill="url(#gradBlue)" />
                <circle cx="55" cy="75" r="5.5" fill="url(#gradBlue)" />
                <circle cx="42" cy="65" r="5.5" fill="url(#gradBlue)" />
                <circle cx="68" cy="68" r="5.5" fill="url(#gradBlue)" />

                {/* Glass Front Details */}
                <path d="M 10 20 L 10 110 C 10 120, 90 120, 90 110 L 90 20" fill="none" stroke="#94a3b8" strokeWidth="1.5" opacity="0.8"/>
                <ellipse cx="50" cy="20" rx="40" ry="10" fill="none" stroke="#94a3b8" strokeWidth="1.5" opacity="0.8"/>
                <ellipse cx="50" cy="110" rx="40" ry="10" fill="none" stroke="#94a3b8" strokeWidth="1.5" opacity="0.5"/>
                <path d="M 16 35 L 16 100" fill="none" stroke="#fff" strokeWidth="3" opacity="0.7" strokeLinecap="round"/>
                <path d="M 84 35 L 84 100" fill="none" stroke="#fff" strokeWidth="1.5" opacity="0.5" strokeLinecap="round"/>
              </svg>

              {/* Tanda Panah Reversible */}
              <div className="w-[50px] h-[30px]">
                <svg viewBox="0 0 100 40" className="w-full h-full">
                  {/* Top Right Arrow */}
                  <line x1="0" y1="12" x2="95" y2="12" stroke="#002b80" strokeWidth="4.5" strokeLinecap="round"/>
                  <polyline points="80,0 95,12" fill="none" stroke="#002b80" strokeWidth="4.5" strokeLinecap="round" strokeLinejoin="round"/>
                  {/* Bottom Left Arrow */}
                  <line x1="5" y1="28" x2="100" y2="28" stroke="#002b80" strokeWidth="4.5" strokeLinecap="round"/>
                  <polyline points="20,40 5,28" fill="none" stroke="#002b80" strokeWidth="4.5" strokeLinecap="round" strokeLinejoin="round"/>
                </svg>
              </div>

              {/* Gelas Kanan */}
              <svg viewBox="0 0 100 125" className="w-[85px] h-auto drop-shadow-md">
                {/* Back of Glass */}
                <path d="M 10 20 L 10 110 C 10 120, 90 120, 90 110 L 90 20" fill="#f8fafc" opacity="0.6"/>
                {/* Liquid */}
                <path d="M 12 60 L 12 110 C 12 118, 88 118, 88 110 L 88 60 Z" fill="#bae6fd" opacity="0.5"/>
                <ellipse cx="50" cy="60" rx="38" ry="10" fill="#7dd3fc" opacity="0.6"/>
                <ellipse cx="50" cy="60" rx="38" ry="10" fill="none" stroke="#0ea5e9" strokeWidth="1" opacity="0.5"/>
                
                {/* Molecules */}
                {/* Pairs and Singles */}
                
                {/* Bonded Blue-Blue */}
                <circle cx="35" cy="85" r="5.5" fill="url(#gradBlue)" />
                <circle cx="43" cy="80" r="5.5" fill="url(#gradBlue)" />
                <line x1="35" y1="85" x2="43" y2="80" stroke="#002b80" strokeWidth="2" opacity="0.5" />

                <circle cx="65" cy="82" r="5.5" fill="url(#gradBlue)" />
                <circle cx="58" cy="74" r="5.5" fill="url(#gradBlue)" />
                <line x1="65" y1="82" x2="58" y2="74" stroke="#002b80" strokeWidth="2" opacity="0.5" />

                <circle cx="32" cy="68" r="5.5" fill="url(#gradBlue)" />
                <circle cx="25" cy="75" r="5.5" fill="url(#gradBlue)" />
                <line x1="32" y1="68" x2="25" y2="75" stroke="#002b80" strokeWidth="2" opacity="0.5" />

                {/* Bonded Blue-Orange or Mixed cluster */}
                <circle cx="70" cy="65" r="5.5" fill="url(#gradBlue)" />
                
                <circle cx="60" cy="95" r="5.5" fill="url(#gradBlue)" />
                <circle cx="52" cy="102" r="5.5" fill="url(#gradBlue)" />
                
                <circle cx="75" cy="100" r="5.5" fill="url(#gradOrange)" />
                <circle cx="25" cy="100" r="5.5" fill="url(#gradOrange)" />
                <circle cx="40" cy="108" r="5.5" fill="url(#gradOrange)" />
                <circle cx="80" cy="85" r="5.5" fill="url(#gradOrange)" />

                {/* Glass Front Details */}
                <path d="M 10 20 L 10 110 C 10 120, 90 120, 90 110 L 90 20" fill="none" stroke="#94a3b8" strokeWidth="1.5" opacity="0.8"/>
                <ellipse cx="50" cy="20" rx="40" ry="10" fill="none" stroke="#94a3b8" strokeWidth="1.5" opacity="0.8"/>
                <ellipse cx="50" cy="110" rx="40" ry="10" fill="none" stroke="#94a3b8" strokeWidth="1.5" opacity="0.5"/>
                <path d="M 16 35 L 16 100" fill="none" stroke="#fff" strokeWidth="3" opacity="0.7" strokeLinecap="round"/>
                <path d="M 84 35 L 84 100" fill="none" stroke="#fff" strokeWidth="1.5" opacity="0.5" strokeLinecap="round"/>
              </svg>

            </div>

            {/* --- Form Pertanyaan --- */}
            <div className="flex flex-col mt-2 w-[95%] mx-auto relative z-20">
              
              {/* Question a */}
              <div className="flex gap-2 mb-1.5 items-start">
                <span className="text-[#002b80] font-extrabold text-[11px] pt-[0.5px]">a.</span>
                <span className="text-[#333] text-[11px] font-medium pt-[1px] leading-snug">Jelaskan apa yang terjadi pada sistem tersebut!</span>
              </div>
              
              {/* Question b */}
              <div className="flex gap-2 mb-2.5 items-start">
                <span className="text-[#002b80] font-extrabold text-[11px] pt-[0.5px]">b.</span>
                <span className="text-[#333] text-[11px] font-medium pt-[1px] leading-snug">Bagaimana kondisi kesetimbangan tercapai?</span>
              </div>
              
              {/* Text Area */}
              <textarea 
                className="w-full h-[55px] border-[1.5px] border-[#cce0ff] rounded-[8px] p-2.5 text-[10px] text-[#555] font-sans resize-none outline-none focus:border-[#002b80] bg-[#fafcff] shadow-inner"
                placeholder="Ketik jawaban Anda di sini..."
              ></textarea>
              
              {/* Button */}
              <div className="flex justify-end w-full mt-2">
                <button className="bg-[#ffc107] hover:bg-[#eab308] text-[#002b80] font-bold text-[10px] py-2 px-5 rounded-[6px] shadow-sm transition-colors border-none cursor-pointer w-fit" style={{ fontFamily: "'Poppins', sans-serif" }}>
                  Kirim Jawaban
                </button>
              </div>
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
          <span className="font-extrabold text-[#002b80] text-[14px] leading-none mt-[1px]" style={{ fontFamily: "'Poppins', sans-serif" }}>9</span>
        </div>
        <div className="w-[12px] h-[3px] bg-[#ffc107] rounded-full"></div>
      </div>

    </div>
  );
});

export default PageTen;
