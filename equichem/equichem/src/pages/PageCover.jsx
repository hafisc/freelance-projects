import React from 'react';

// ========================================================
// KOMPONEN: PageCover
// DESKRIPSI: Halaman Cover (Halaman 1) dari micromodul
// Desain disesuaikan dengan referensi desain klien (1.png)
// ========================================================
const PageCover = React.forwardRef((props, ref) => {
  return (
    <div className="page page-cover bg-white relative w-full h-full overflow-hidden flex flex-col font-sans" ref={ref} data-density="hard">

      {/* === BACKGROUND ELEMENTS === */}

      {/* --- Background Header Curves (kanan atas) --- */}
      <div className="absolute top-0 right-0 w-[62%] h-[28%] z-0 pointer-events-none">
        <svg viewBox="0 0 620 280" preserveAspectRatio="none" className="w-full h-full">
          <defs>
            <pattern id="dotPatternCover" x="0" y="0" width="16" height="16" patternUnits="userSpaceOnUse">
              <circle cx="3" cy="3" r="2" fill="rgba(255,255,255,0.18)" />
            </pattern>
          </defs>
          {/* Garis kuning diagonal */}
          <path d="M 80 0 C 160 0, 260 40, 380 100 C 480 150, 580 220, 620 280 L 620 0 Z" fill="#ffc107" />
          {/* Bagian biru gelap utama */}
          <path d="M 160 0 C 240 0, 340 45, 450 105 C 540 155, 600 230, 620 280 L 620 0 Z" fill="#002b80" />
          {/* Pola titik di atas biru */}
          <path d="M 160 0 C 240 0, 340 45, 450 105 C 540 155, 600 230, 620 280 L 620 0 Z" fill="url(#dotPatternCover)" />
        </svg>
      </div>

      {/* --- Molekul Background dekoratif --- */}
      <div className="absolute top-[4%] right-[2%] w-[30%] h-[22%] z-[1] pointer-events-none opacity-[0.07]">
        <svg viewBox="0 0 400 280" className="w-full h-full">
          <circle cx="200" cy="80" r="18" fill="none" stroke="#fff" strokeWidth="3" />
          <circle cx="280" cy="140" r="14" fill="none" stroke="#fff" strokeWidth="3" />
          <circle cx="320" cy="55" r="12" fill="none" stroke="#fff" strokeWidth="3" />
          <circle cx="140" cy="150" r="16" fill="none" stroke="#fff" strokeWidth="3" />
          <circle cx="240" cy="195" r="10" fill="none" stroke="#fff" strokeWidth="3" />
          <circle cx="160" cy="220" r="14" fill="none" stroke="#fff" strokeWidth="3" />
          <line x1="214" y1="90" x2="270" y2="132" stroke="#fff" strokeWidth="2" />
          <line x1="210" y1="65" x2="310" y2="60" stroke="#fff" strokeWidth="2" />
          <line x1="186" y1="88" x2="148" y2="140" stroke="#fff" strokeWidth="2" />
          <line x1="270" y1="150" x2="248" y2="190" stroke="#fff" strokeWidth="2" />
          <line x1="230" y1="196" x2="174" y2="218" stroke="#fff" strokeWidth="2" />
        </svg>
      </div>



      {/* === KONTEN HALAMAN === */}
      <div className="relative z-10 w-full h-full flex flex-col" style={{ padding: '13% 8% 4% 8%' }}>

        {/* --- HEADER: Logo EquiChem --- */}
        <div className="flex items-center">
          <div className="w-[52px] h-[52px] mr-3 shrink-0">
            <svg viewBox="0 0 80 80" className="w-full h-full drop-shadow-sm">
              <circle cx="40" cy="40" r="36" fill="none" stroke="#002b80" strokeWidth="2" strokeDasharray="4 3" />
              <path d="M 32 20 L 32 32 L 22 52 C 20 56, 22 60, 26 60 L 54 60 C 58 60, 60 56, 58 52 L 48 32 L 48 20" fill="none" stroke="#002b80" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round" />
              <line x1="29" y1="20" x2="51" y2="20" stroke="#002b80" strokeWidth="2.5" strokeLinecap="round" />
              <path d="M 25 48 L 55 48 L 58 52 C 60 56, 58 60, 54 60 L 26 60 C 22 60, 20 56, 22 52 Z" fill="#3b82f6" opacity="0.6" />
              <circle cx="35" cy="52" r="2.5" fill="#60a5fa" opacity="0.7" />
              <circle cx="43" cy="47" r="2" fill="#93c5fd" opacity="0.7" />
              <circle cx="50" cy="53" r="3" fill="#ffc107" opacity="0.8" />
            </svg>
          </div>
          <div>
            <h2 className="font-extrabold text-[#002b80] leading-none m-0" style={{ fontFamily: "'Poppins', sans-serif", fontSize: '30px' }}>EquiChem</h2>
            <div className="flex items-center gap-1 mt-1">
              <div className="h-[1px] w-3 bg-gray-300"></div>
              <p className="font-semibold tracking-[0.14em] m-0 whitespace-nowrap" style={{ fontSize: '10.5px' }}>
                <span className="text-[#002b80]">Explore</span>
                <span className="text-[#ffc107] mx-1.5">•</span>
                <span className="text-[#002b80]">Understand</span>
                <span className="text-[#ffc107] mx-1.5">•</span>
                <span className="text-[#ffc107]">Balance</span>
              </p>
              <div className="h-[1px] w-3 bg-gray-300"></div>
            </div>
          </div>
        </div>

        {/* --- Badge --- */}
        <div className="mt-3 mb-1.5">
          <span className="inline-block bg-[#ffc107] text-[#002b80] font-extrabold px-4 py-[4px] rounded-full tracking-wide" style={{ fontFamily: "'Poppins', sans-serif", fontSize: '12px' }}>
            MICROMODUL INTERAKTIF
          </span>
        </div>

        {/* --- Title --- */}
        <div className="mb-1">
          <h1 className="font-extrabold text-[#002b80] leading-[0.95] m-0" style={{ fontFamily: "'Poppins', sans-serif", fontSize: '40px', letterSpacing: '-0.02em' }}>KESETIMBANGAN</h1>
          <h1 className="font-extrabold text-[#002b80] leading-[0.95] m-0 mt-0.5" style={{ fontFamily: "'Poppins', sans-serif", fontSize: '40px', letterSpacing: '-0.02em' }}>KIMIA</h1>
          <div className="w-9 h-[3px] bg-[#002b80] rounded-full mt-2 mb-2"></div>
        </div>

        {/* --- Middle Section: Desc + Hero (hanya deskripsi & ilustrasi) --- */}
        <div className="relative flex flex-col justify-start w-full" style={{ marginBottom: '8px' }}>

          <p className="text-gray-600 leading-relaxed m-0 w-[52%]" style={{ fontSize: '13px' }}>
            Materi ringkas, aktivitas interaktif,<br />
            dan evaluasi untuk memahami<br />
            kesetimbangan kimia secara mendalam.
          </p>

          {/* Hero Illustration - Timbangan Kimia */}
          <div className="absolute pointer-events-none" style={{ right: '-8%', top: '-20%', width: '56%', zIndex: 5 }}>
            <svg viewBox="0 0 400 340" className="w-full h-auto drop-shadow-xl">
              {/* Shadow */}
              <ellipse cx="200" cy="328" rx="50" ry="7" fill="rgba(0,0,0,0.12)" />

              {/* Tiang utama */}
              <rect x="194" y="175" width="12" height="155" rx="2.5" fill="#2d2d44" />
              {/* Alas */}
              <rect x="180" y="322" width="40" height="10" rx="3" fill="#1a1a2e" />
              {/* Lengan timbangan */}
              <rect x="68" y="170" width="264" height="6" rx="3" fill="#2d2d44" />
              {/* Pusat timbangan */}
              <circle cx="200" cy="173" r="9" fill="#3a3a5c" />
              <circle cx="200" cy="173" r="4.5" fill="#ffc107" />

              {/* Lengan kiri - tali */}
              <line x1="110" y1="176" x2="84" y2="213" stroke="#3a3a5c" strokeWidth="2" />
              <line x1="110" y1="176" x2="136" y2="213" stroke="#3a3a5c" strokeWidth="2" />
              {/* Piring kiri */}
              <ellipse cx="110" cy="217" rx="40" ry="6.5" fill="#1a1a2e" />
              <path d="M 70 217 Q 110 228 150 217" fill="#2d2d44" />

              {/* Lengan kanan - tali */}
              <line x1="290" y1="176" x2="264" y2="213" stroke="#3a3a5c" strokeWidth="2" />
              <line x1="290" y1="176" x2="316" y2="213" stroke="#3a3a5c" strokeWidth="2" />
              {/* Piring kanan */}
              <ellipse cx="290" cy="217" rx="40" ry="6.5" fill="#1a1a2e" />
              <path d="M 250 217 Q 290 228 330 217" fill="#2d2d44" />

              {/* Labu kiri (biru) - erlenmeyer */}
              <rect x="102" y="100" width="16" height="30" rx="2" fill="none" stroke="#4a90d9" strokeWidth="2" />
              <line x1="99" y1="100" x2="119" y2="100" stroke="#4a90d9" strokeWidth="2.5" strokeLinecap="round" />
              <path d="M 102 130 C 84 143, 70 163, 73 183 C 75 197, 87 213, 110 213 C 133 213, 145 197, 147 183 C 150 163, 136 143, 118 130" fill="none" stroke="#4a90d9" strokeWidth="2" />
              <path d="M 76 183 C 77 197, 88 211, 110 211 C 132 211, 143 197, 144 183 C 146 172, 137 159, 110 154 C 83 159, 74 172, 76 183 Z" fill="#2563eb" opacity="0.6" />
              <circle cx="95" cy="182" r="3" fill="#60a5fa" opacity="0.55" />
              <circle cx="105" cy="173" r="2" fill="#93c5fd" opacity="0.65" />
              <circle cx="115" cy="186" r="3.5" fill="#60a5fa" opacity="0.45" />
              <circle cx="122" cy="171" r="1.8" fill="#bfdbfe" opacity="0.75" />

              {/* Labu kanan (kuning/oranye) - erlenmeyer */}
              <rect x="282" y="100" width="16" height="30" rx="2" fill="none" stroke="#d4a017" strokeWidth="2" />
              <line x1="279" y1="100" x2="299" y2="100" stroke="#d4a017" strokeWidth="2.5" strokeLinecap="round" />
              <path d="M 282 130 C 264 143, 250 163, 253 183 C 255 197, 267 213, 290 213 C 313 213, 325 197, 327 183 C 330 163, 316 143, 298 130" fill="none" stroke="#d4a017" strokeWidth="2" />
              <path d="M 256 183 C 257 197, 268 211, 290 211 C 312 211, 323 197, 324 183 C 326 172, 317 159, 290 154 C 263 159, 254 172, 256 183 Z" fill="#f59e0b" opacity="0.65" />
              <circle cx="275" cy="182" r="3" fill="#fcd34d" opacity="0.55" />
              <circle cx="285" cy="172" r="2" fill="#fde68a" opacity="0.65" />
              <circle cx="295" cy="188" r="3.5" fill="#fcd34d" opacity="0.45" />
              <circle cx="303" cy="171" r="1.8" fill="#fef3c7" opacity="0.75" />
            </svg>
          </div>
        </div>

        {/* --- Footer: Info Box + Feature Cards + Button --- */}
        <div className="mt-auto relative z-20">

          {/* Info Box — dipindah ke sini agar tidak tertutup feature cards */}
          <div className="bg-gray-50 border border-gray-100 rounded-xl p-2 flex items-center gap-2 shadow-sm mb-2" style={{ width: '54%' }}>
            <div className="w-8 h-8 bg-[#002b80] rounded-lg flex items-center justify-center text-white shrink-0">
              <i className="bi bi-globe" style={{ fontSize: '13px' }}></i>
            </div>
            <p className="text-gray-500 m-0 leading-[1.3] italic" style={{ fontSize: '10.5px' }}>
              Dirancang membantu siswa menganalisis konsep, menyelesaikan masalah, dan menerapkannya dalam kehidupan nyata.
            </p>
          </div>

          {/* Feature Cards */}
          <div className="bg-white rounded-2xl border border-gray-100 p-2 flex items-stretch mb-3" style={{ boxShadow: '0 4px 14px rgba(0,43,128,0.07)' }}>
            {[
              { icon: 'bi-laptop', bg: 'bg-[#002b80]', title: 'Akses Fleksibel', desc: 'Belajar kapan saja di mana saja' },
              { icon: 'bi-lightbulb', bg: 'bg-[#ffc107]', title: 'Visual & Interaktif', desc: 'Konten menarik dengan animasi' },
              { icon: 'bi-people-fill', bg: 'bg-[#002b80]', title: 'Pendekatan PBL', desc: 'Aktivitas berbasis masalah kontekstual' },
              { icon: 'bi-book', bg: 'bg-[#ffc107]', title: 'Evaluasi Adaptif', desc: 'Latihan dan umpan balik otomatis' },
            ].map((f, i) => (
              <div key={i} className={`flex flex-col items-center text-center flex-1 px-1.5 py-1 ${i < 3 ? 'border-r border-gray-100' : ''}`}>
                <div className={`w-9 h-9 ${f.bg} rounded-full flex items-center justify-center mb-1.5 shadow-sm shrink-0`}>
                  <i className={`bi ${f.icon}`} style={{ fontSize: '15px', color: f.bg === 'bg-[#ffc107]' ? '#002b80' : 'white' }}></i>
                </div>
                <h4 className="font-extrabold text-[#002b80] m-0 leading-tight" style={{ fontSize: '11.5px' }}>{f.title}</h4>
                <p className="text-gray-500 m-0 leading-[1.3] font-medium mt-1" style={{ fontSize: '9.5px' }}>{f.desc}</p>
              </div>
            ))}
          </div>

          {/* Button & Quote */}
          <div className="flex items-center justify-between pb-1">

            <div className="bg-[#002b80] rounded-full flex items-center shrink-0" style={{ padding: '7px 18px 7px 7px', boxShadow: '0 4px 12px rgba(0,43,128,0.2)' }}>
              <div className="w-9 h-9 rounded-full border-2 border-white flex items-center justify-center text-white mr-3">
                <i className="bi bi-people-fill" style={{ fontSize: '15px' }}></i>
              </div>
              <div className="flex flex-col">
                <span className="text-white font-medium leading-none mb-1" style={{ fontSize: '12px' }}>Untuk Siswa</span>
                <span className="bg-[#ffc107] text-[#002b80] font-extrabold px-2.5 py-0.5 rounded-full leading-none text-center" style={{ fontSize: '10.5px' }}>SMA/MA Kelas XI</span>
              </div>
            </div>

            <div className="flex items-start" style={{ maxWidth: '55%' }}>
              <span className="text-[#ffc107] font-serif font-extrabold leading-none" style={{ fontSize: '30px' }}>"</span>
              <p className="text-[#002b80] font-bold leading-[1.3] m-0 italic px-2 pt-1" style={{ fontSize: '12px' }}>
                Pahami, analisis, dan terapkan konsep kesetimbangan kimia untuk dunia nyata.
              </p>
              <span className="text-[#ffc107] font-serif font-extrabold leading-none self-end" style={{ fontSize: '30px' }}>"</span>
            </div>

          </div>
        </div>

      </div>
    </div>
  );
});

export default PageCover;
