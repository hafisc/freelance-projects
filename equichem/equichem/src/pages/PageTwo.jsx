import React from 'react';

// ========================================================
// KOMPONEN: PageTwo
// DESKRIPSI: Halaman "Kata Pengantar" (Halaman 2 / Flipbook Hal 1)
// Desain berdasarkan 2.png
// ========================================================
const PageTwo = React.forwardRef((props, ref) => {
  return (
    <div className="page bg-white relative w-full h-full overflow-hidden flex flex-col font-sans" ref={ref} data-density="soft">
      
      {/* === BACKGROUND ELEMENTS === */}

      {/* --- Header Curves --- */}
      <div className="absolute top-0 left-0 w-full h-[18%] z-0 pointer-events-none">
        <svg viewBox="0 0 1000 180" preserveAspectRatio="none" className="w-full h-full">
          {/* Yellow accent curve */}
          <path d="M 0 0 L 0 110 C 100 80, 250 15, 450 15 C 650 15, 800 130, 1000 170 L 1000 0 Z" fill="#ffc107" />
          {/* Main Blue curve */}
          <path d="M 0 0 L 0 95 C 100 65, 250 0, 450 0 C 650 0, 800 115, 1000 155 L 1000 0 Z" fill="#002b80" />
        </svg>
      </div>

      {/* --- Molekul Background (Kanan atas sampai tengah) --- */}
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
          
          {/* Tambahan ke arah luar */}
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
      <div className="relative z-10 w-full h-full flex flex-col pt-[18%] px-[10%] pb-[10%]">
        
        {/* --- Judul: KATA PENGANTAR --- */}
        <div className="mb-6">
          <h1 className="font-extrabold text-[#002b80] text-[30px] m-0 leading-none tracking-tight" style={{ fontFamily: "'Poppins', sans-serif" }}>
            KATA PENGANTAR
          </h1>
          <div className="flex mt-2 gap-1">
            <div className="w-[45px] h-[3px] bg-[#002b80] rounded-full"></div>
            <div className="w-[30px] h-[3px] bg-[#ffc107] rounded-full"></div>
          </div>
        </div>

        {/* --- Teks Konten --- */}
        <div className="flex-1 text-[#333] text-[11.5px] leading-[1.85] font-medium pr-[2%]">
          
          <p className="mb-4 text-justify">
            Puji syukur kehadirat Allah SWT atas limpahan rahmat dan karunia-Nya sehingga micromodul interaktif <strong className="text-[#002b80] font-bold">EquiChem</strong> pada materi kesetimbangan kimia ini dapat disusun dan diselesaikan dengan baik. Micromodul ini dirancang sebagai sumber belajar digital yang dapat membantu siswa memahami konsep kesetimbangan kimia melalui pendekatan <strong className="text-[#002b80] font-bold italic">Problem Based Learning (PBL)</strong> dan meningkatkan literasi kimia secara mendalam.
          </p>

          <p className="mb-4 text-justify">
            Micromodul ini disusun secara sistematis dan interaktif agar siswa dapat belajar secara mandiri, aktif, dan menyenangkan. Selain memuat materi inti, micromodul ini juga dilengkapi dengan kegiatan pemecahan masalah, simulasi, serta evaluasi yang dapat mengukur pemahaman secara kontekstual.
          </p>

          <p className="text-justify w-[65%]">
            Penulis menyadari bahwa micromodul ini masih jauh dari sempurna. Oleh karena itu, kritik dan saran yang membangun sangat diharapkan demi perbaikan di masa mendatang. Semoga micromodul ini dapat memberikan manfaat bagi siswa, guru, dan semua pihak yang terlibat dalam proses pembelajaran.
          </p>

        </div>
        
      </div>
      
      {/* --- Ilustrasi Flask (Kanan Bawah) --- */}
      <div className="absolute right-[5%] bottom-[12%] w-[32%] z-[15] pointer-events-none drop-shadow-2xl">
        <svg viewBox="0 0 200 250" className="w-full h-auto">
          {/* Flask Shadow/Reflection */}
          <ellipse cx="100" cy="235" rx="50" ry="8" fill="rgba(0,0,0,0.15)" />
          <ellipse cx="100" cy="235" rx="30" ry="4" fill="rgba(0,0,0,0.25)" />
          
          {/* Liquid Outline / Back */}
          <path d="M 45 180 C 45 210, 65 230, 100 230 C 135 230, 155 210, 155 180 C 155 150, 115 90, 115 90 L 85 90 C 85 90, 45 150, 45 180 Z" fill="#ffc107" opacity="0.8"/>
          {/* Liquid Surface */}
          <ellipse cx="100" cy="165" rx="46.5" ry="12" fill="#ffca28" />
          <ellipse cx="100" cy="165" rx="46.5" ry="12" fill="none" stroke="#fbbf24" strokeWidth="2" />
          {/* Liquid Body Gradient feel (simplified) */}
          <path d="M 53 180 C 53 205, 70 225, 100 225 C 130 225, 147 205, 147 180 C 147 167, 100 167, 100 167 C 100 167, 53 167, 53 180 Z" fill="#eab308" opacity="0.6"/>
          
          {/* Bubbles */}
          <circle cx="95" cy="205" r="4" fill="#fff" opacity="0.6" />
          <circle cx="120" cy="195" r="2.5" fill="#fff" opacity="0.7" />
          <circle cx="85" cy="185" r="3" fill="#fff" opacity="0.5" />
          <circle cx="110" cy="175" r="3.5" fill="#fff" opacity="0.8" />
          <circle cx="100" cy="155" r="4.5" fill="#ffc107" opacity="0.9" />
          <circle cx="108" cy="135" r="3" fill="#ffc107" opacity="0.8" />
          <circle cx="92" cy="115" r="2" fill="#ffc107" opacity="0.8" />
          <circle cx="102" cy="95" r="3.5" fill="#ffc107" opacity="0.9" />

          {/* Flask Glass Outline */}
          {/* Neck lips */}
          <rect x="80" y="45" width="40" height="8" rx="4" fill="#f0f9ff" stroke="#94a3b8" strokeWidth="2" opacity="0.8"/>
          <rect x="83" y="53" width="34" height="6" rx="2" fill="#e0f2fe" stroke="#94a3b8" strokeWidth="1.5" opacity="0.6"/>
          {/* Body */}
          <path d="M 87 59 L 87 90 C 87 90, 42 150, 42 180 C 42 215, 65 235, 100 235 C 135 235, 158 215, 158 180 C 158 150, 113 90, 113 90 L 113 59" fill="none" stroke="#94a3b8" strokeWidth="3" opacity="0.7"/>
          <path d="M 87 59 L 87 90 C 87 90, 42 150, 42 180 C 42 215, 65 235, 100 235 C 135 235, 158 215, 158 180 C 158 150, 113 90, 113 90 L 113 59" fill="url(#glassGradient)" opacity="0.2"/>
          {/* Glass Highlights */}
          <path d="M 47 175 C 47 200, 60 220, 85 228" fill="none" stroke="#ffffff" strokeWidth="4" strokeLinecap="round" opacity="0.8"/>
          <path d="M 153 175 C 153 190, 145 205, 130 215" fill="none" stroke="#ffffff" strokeWidth="2" strokeLinecap="round" opacity="0.6"/>
          <line x1="91" y1="65" x2="91" y2="85" stroke="#ffffff" strokeWidth="3" strokeLinecap="round" opacity="0.7"/>
        </svg>
      </div>

      {/* --- Nomor Halaman (Kanan Bawah) --- */}
      <div className="absolute right-[6%] bottom-[4%] z-20 flex items-center justify-center gap-2">
        <div className="w-[12px] h-[3px] bg-[#ffc107] rounded-full"></div>
        <div className="w-[28px] h-[28px] bg-white border-[2.5px] border-[#002b80] rounded-lg flex items-center justify-center shadow-sm">
          <span className="font-extrabold text-[#002b80] text-[14px] leading-none mt-[1px]" style={{ fontFamily: "'Poppins', sans-serif" }}>1</span>
        </div>
        <div className="w-[12px] h-[3px] bg-[#ffc107] rounded-full"></div>
      </div>

    </div>
  );
});

export default PageTwo;
