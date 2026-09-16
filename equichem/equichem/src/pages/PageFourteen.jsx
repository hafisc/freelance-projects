import React from 'react';

// ========================================================
// KOMPONEN: PageFourteen
// DESKRIPSI: Halaman "Umpan Balik / Feedback" (Halaman 14 / Flipbook Hal 13)
// Desain berdasarkan 14.png
// ========================================================
const PageFourteen = React.forwardRef((props, ref) => {
  
  return (
    <div className="page bg-[#f8fafc] relative w-full h-full flex flex-col font-sans p-4" ref={ref} data-density="soft">
      
      {/* Container Utama */}
      <div className="bg-white w-full h-full rounded-[16px] border-[1px] border-[#e2e8f0] shadow-sm flex flex-col p-5 relative overflow-hidden">
        
        {/* Header Section */}
        <div className="flex items-center gap-4 mb-4">
          <div className="w-[36px] h-[36px] bg-[#002b80] rounded-[6px] shadow-sm shrink-0"></div>
          <h1 className="font-extrabold text-[#002b80] text-[18px] m-0 tracking-wide" style={{ fontFamily: "'Poppins', sans-serif" }}>
            UMPAN BALIK / FEEDBACK
          </h1>
        </div>

        {/* Main Content Box */}
        <div className="flex-1 w-full border-[1.5px] border-[#e2e8f0] rounded-[16px] flex flex-col items-center pt-8 px-5 pb-5 bg-white relative z-10">
          
          <h2 className="text-[#002b80] font-bold text-[18px] mb-2 text-center" style={{ fontFamily: "'Poppins', sans-serif" }}>
            Berikan Umpan Balik Anda
          </h2>
          <p className="text-[#002b80] text-[13px] font-medium mb-8 text-center">
            Bagaimana pendapat Anda tentang progres belajar?
          </p>

          {/* Emojis Rating */}
          <div className="flex justify-between w-full px-2 mb-8">
            
            {/* 1. Sangat Baik */}
            <div className="flex flex-col items-center gap-3 cursor-pointer group">
              <svg viewBox="0 0 100 100" className="w-[50px] h-[50px] drop-shadow-md group-hover:scale-110 transition-transform">
                <defs>
                  <radialGradient id="gradFace1" cx="30%" cy="30%" r="70%">
                    <stop offset="0%" stopColor="#fef08a" />
                    <stop offset="100%" stopColor="#f59e0b" />
                  </radialGradient>
                </defs>
                <circle cx="50" cy="50" r="46" fill="url(#gradFace1)" />
                <circle cx="35" cy="40" r="4.5" fill="#1e293b"/>
                <circle cx="65" cy="40" r="4.5" fill="#1e293b"/>
                <path d="M 25 55 C 25 85, 75 85, 75 55 Z" fill="#1e293b" />
                <path d="M 35 60 C 50 68, 50 68, 65 60" fill="none" stroke="#fff" strokeWidth="3" strokeLinecap="round" opacity="0.8"/>
              </svg>
              <span className="text-[#002b80] text-[11px] font-medium">Sangat Baik</span>
            </div>

            {/* 2. Baik */}
            <div className="flex flex-col items-center gap-3 cursor-pointer group">
              <svg viewBox="0 0 100 100" className="w-[50px] h-[50px] drop-shadow-md group-hover:scale-110 transition-transform">
                <circle cx="50" cy="50" r="46" fill="url(#gradFace1)" />
                <circle cx="35" cy="40" r="4.5" fill="#1e293b"/>
                <circle cx="65" cy="40" r="4.5" fill="#1e293b"/>
                <path d="M 30 60 Q 50 75 70 60" fill="none" stroke="#1e293b" strokeWidth="5.5" strokeLinecap="round"/>
              </svg>
              <span className="text-[#002b80] text-[11px] font-medium">Baik</span>
            </div>

            {/* 3. Cukup */}
            <div className="flex flex-col items-center gap-3 cursor-pointer group">
              <svg viewBox="0 0 100 100" className="w-[50px] h-[50px] drop-shadow-md group-hover:scale-110 transition-transform">
                <defs>
                  <radialGradient id="gradFace2" cx="30%" cy="30%" r="70%">
                    <stop offset="0%" stopColor="#fde68a" />
                    <stop offset="100%" stopColor="#f59e0b" />
                  </radialGradient>
                </defs>
                <circle cx="50" cy="50" r="46" fill="url(#gradFace2)" />
                <line x1="25" y1="30" x2="42" y2="38" stroke="#1e293b" strokeWidth="3.5" strokeLinecap="round"/>
                <line x1="75" y1="30" x2="58" y2="38" stroke="#1e293b" strokeWidth="3.5" strokeLinecap="round"/>
                <circle cx="35" cy="45" r="4.5" fill="#1e293b"/>
                <circle cx="65" cy="45" r="4.5" fill="#1e293b"/>
                <path d="M 35 70 Q 50 60 65 70" fill="none" stroke="#1e293b" strokeWidth="5" strokeLinecap="round"/>
              </svg>
              <span className="text-[#002b80] text-[11px] font-medium">Cukup</span>
            </div>

            {/* 4. Kurang */}
            <div className="flex flex-col items-center gap-3 cursor-pointer group">
              <svg viewBox="0 0 100 100" className="w-[50px] h-[50px] drop-shadow-md group-hover:scale-110 transition-transform">
                <circle cx="50" cy="50" r="46" fill="url(#gradFace2)" />
                <circle cx="35" cy="40" r="4.5" fill="#1e293b"/>
                <circle cx="65" cy="40" r="4.5" fill="#1e293b"/>
                <path d="M 30 65 Q 50 50 70 65" fill="none" stroke="#1e293b" strokeWidth="5" strokeLinecap="round"/>
              </svg>
              <span className="text-[#002b80] text-[11px] font-medium">Kurang</span>
            </div>

            {/* 5. Sangat Kurang */}
            <div className="flex flex-col items-center gap-3 cursor-pointer group">
              <svg viewBox="0 0 100 100" className="w-[50px] h-[50px] drop-shadow-md group-hover:scale-110 transition-transform">
                <circle cx="50" cy="50" r="46" fill="url(#gradFace2)" />
                <line x1="25" y1="40" x2="42" y2="32" stroke="#1e293b" strokeWidth="3.5" strokeLinecap="round"/>
                <line x1="75" y1="40" x2="58" y2="32" stroke="#1e293b" strokeWidth="3.5" strokeLinecap="round"/>
                <circle cx="35" cy="45" r="4.5" fill="#1e293b"/>
                <circle cx="65" cy="45" r="4.5" fill="#1e293b"/>
                <path d="M 30 70 Q 50 50 70 70" fill="none" stroke="#1e293b" strokeWidth="5.5" strokeLinecap="round"/>
              </svg>
              <span className="text-[#002b80] text-[11px] font-medium">Sangat Kurang</span>
            </div>
            
          </div>

          {/* Text Area */}
          <textarea 
            className="w-full h-[150px] border-[1.5px] border-[#cbd5e1] rounded-[12px] p-4 text-[12px] text-[#475569] font-sans resize-none outline-none focus:border-[#002b80] transition-colors shadow-inner"
            placeholder="Komentar / Saran Anda..."
          ></textarea>

          {/* Button */}
          <div className="flex justify-end w-full mt-4">
            <button className="bg-[#ffc107] hover:bg-[#eab308] text-[#002b80] font-bold text-[14px] py-2 px-8 rounded-[8px] shadow-sm transition-colors border-none cursor-pointer" style={{ fontFamily: "'Poppins', sans-serif" }}>
              Kirim
            </button>
          </div>

        </div>
      </div>
      
    </div>
  );
});

export default PageFourteen;
