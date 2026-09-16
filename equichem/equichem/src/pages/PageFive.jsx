import React from 'react';

const PageFive = React.forwardRef((props, ref) => {
  return (
    <div className="page bg-white relative w-full h-full overflow-hidden flex flex-col font-sans" ref={ref} data-density="soft">

      {/* === BACKGROUND === */}
      <div className="absolute top-0 left-0 w-full h-[18%] z-0 pointer-events-none">
        <svg viewBox="0 0 1000 180" preserveAspectRatio="none" className="w-full h-full">
          <path d="M 0 0 L 0 110 C 100 80, 250 15, 450 15 C 650 15, 800 130, 1000 170 L 1000 0 Z" fill="#ffc107" />
          <path d="M 0 0 L 0 95 C 100 65, 250 0, 450 0 C 650 0, 800 115, 1000 155 L 1000 0 Z" fill="#002b80" />
        </svg>
      </div>

      <div className="absolute top-[8%] right-[-10%] w-[50%] h-[55%] z-[1] pointer-events-none opacity-[0.05]">
        <svg viewBox="0 0 400 500" className="w-full h-full">
          <circle cx="200" cy="100" r="16" fill="none" stroke="#002b80" strokeWidth="4"/>
          <circle cx="300" cy="180" r="16" fill="none" stroke="#002b80" strokeWidth="4"/>
          <circle cx="120" cy="180" r="16" fill="none" stroke="#002b80" strokeWidth="4"/>
          <circle cx="200" cy="260" r="16" fill="none" stroke="#002b80" strokeWidth="4"/>
          <line x1="188" y1="112" x2="132" y2="168" stroke="#002b80" strokeWidth="3"/>
          <line x1="212" y1="112" x2="288" y2="168" stroke="#002b80" strokeWidth="3"/>
          <line x1="120" y1="196" x2="120" y2="324" stroke="#002b80" strokeWidth="3"/>
          <line x1="300" y1="196" x2="300" y2="324" stroke="#002b80" strokeWidth="3"/>
        </svg>
      </div>

      <div className="absolute bottom-0 left-0 w-full h-[18%] z-0 pointer-events-none">
        <svg viewBox="0 0 1000 180" preserveAspectRatio="none" className="w-full h-full">
          <path d="M 0 0 C 150 15, 300 45, 500 80 C 700 115, 850 145, 1000 150 L 1000 180 L 0 180 Z" fill="#ffc107" />
          <path d="M 0 45 C 150 60, 300 90, 500 120 C 700 150, 850 170, 1000 180 L 0 180 Z" fill="#002b80" />
        </svg>
      </div>

      {/* === KONTEN === */}
      <div className="relative z-10 w-full h-full flex flex-col pt-[18%] px-[5%] pb-[18%]">

        {/* Judul */}
        <div style={{ marginBottom: '6px', flexShrink: 0 }}>
          <h1 className="font-extrabold text-[#002b80] text-[28px] m-0 leading-none tracking-tight" style={{ fontFamily: "'Poppins', sans-serif" }}>
            PETA KONSEP
          </h1>
          <div className="flex mt-1.5 gap-1">
            <div className="w-[45px] h-[3px] bg-[#002b80] rounded-full"></div>
            <div className="w-[30px] h-[3px] bg-[#ffc107] rounded-full"></div>
          </div>
        </div>

        {/* ═══ PURE SVG MIND MAP ═══ */}
        {/* Semua elemen (kotak, teks, garis) dalam 1 SVG → tidak ada mismatch posisi */}
        <div className="flex-1 w-full">
          <svg
            viewBox="0 0 430 340"
            preserveAspectRatio="xMidYMid meet"
            className="w-full h-full"
            style={{ display: 'block' }}
          >
            <defs>
              <marker id="arr5" viewBox="0 0 8 8" refX="7" refY="4" markerWidth="5" markerHeight="5" orient="auto">
                <path d="M 0 0 L 8 4 L 0 8 z" fill="#002b80" />
              </marker>
            </defs>

            {/* ──────── TOP NODE ──────── */}
            <rect x="150" y="2" width="130" height="40" rx="8" fill="#002b80" />
            <text x="215" y="17" textAnchor="middle" fill="white" fontSize="9" fontWeight="bold" fontFamily="Poppins,sans-serif">Kesetimbangan</text>
            <text x="215" y="31" textAnchor="middle" fill="white" fontSize="9" fontWeight="bold" fontFamily="Poppins,sans-serif">Kimia</text>

            {/* ──────── GARIS TOP → CABANG ──────── */}
            <line x1="215" y1="42" x2="215" y2="56" stroke="#002b80" strokeWidth="1.8" />
            {/* Horizontal branch line */}
            <line x1="46" y1="56" x2="384" y2="56" stroke="#002b80" strokeWidth="1.8" />

            {/* Drop ke N1 */}
            <line x1="46" y1="56" x2="46" y2="66" stroke="#002b80" strokeWidth="1.8" markerEnd="url(#arr5)" />
            {/* Drop ke N2 */}
            <line x1="132" y1="56" x2="132" y2="66" stroke="#002b80" strokeWidth="1.8" markerEnd="url(#arr5)" />
            {/* Drop ke N3 (Le Chatelier) - lebih panjang, lewat bawah outer nodes */}
            <line x1="215" y1="56" x2="215" y2="106" stroke="#002b80" strokeWidth="1.8" markerEnd="url(#arr5)" />
            {/* Drop ke N4 */}
            <line x1="298" y1="56" x2="298" y2="66" stroke="#002b80" strokeWidth="1.8" markerEnd="url(#arr5)" />
            {/* Drop ke N5 */}
            <line x1="384" y1="56" x2="384" y2="66" stroke="#002b80" strokeWidth="1.8" markerEnd="url(#arr5)" />

            {/* ──────── NODES ──────── */}
            {/* N1: Konsep Kesetimbangan */}
            <rect x="8" y="68" width="76" height="38" rx="6" fill="#f8faff" stroke="#002b80" strokeWidth="1.5" />
            <text x="46" y="83" textAnchor="middle" fill="#002b80" fontSize="7.5" fontWeight="bold">Konsep</text>
            <text x="46" y="96" textAnchor="middle" fill="#002b80" fontSize="7.5" fontWeight="bold">Kesetimbangan</text>

            {/* N2: Tetapan Kesetimbangan */}
            <rect x="94" y="68" width="76" height="46" rx="6" fill="#f8faff" stroke="#002b80" strokeWidth="1.5" />
            <text x="132" y="82" textAnchor="middle" fill="#002b80" fontSize="7.5" fontWeight="bold">Tetapan</text>
            <text x="132" y="93" textAnchor="middle" fill="#002b80" fontSize="7.5" fontWeight="bold">Kesetimbangan</text>
            <text x="132" y="107" textAnchor="middle" fill="#002b80" fontSize="7">(K&#x2c; K&#x2093;)</text>

            {/* N3: Asas Le Chatelier */}
            <rect x="177" y="108" width="76" height="36" rx="6" fill="#f8faff" stroke="#002b80" strokeWidth="1.5" />
            <text x="215" y="122" textAnchor="middle" fill="#002b80" fontSize="7.5" fontWeight="bold">Asas</text>
            <text x="215" y="135" textAnchor="middle" fill="#002b80" fontSize="7.5" fontWeight="bold">Le Chatelier</text>

            {/* N4: Kesetimbangan Heterogen */}
            <rect x="260" y="68" width="76" height="38" rx="6" fill="#f8faff" stroke="#002b80" strokeWidth="1.5" />
            <text x="298" y="83" textAnchor="middle" fill="#002b80" fontSize="7.5" fontWeight="bold">Kesetimbangan</text>
            <text x="298" y="96" textAnchor="middle" fill="#002b80" fontSize="7.5" fontWeight="bold">Heterogen</text>

            {/* N5: Faktor yang Mempengaruhi */}
            <rect x="346" y="68" width="76" height="38" rx="6" fill="#f8faff" stroke="#002b80" strokeWidth="1.5" />
            <text x="384" y="83" textAnchor="middle" fill="#002b80" fontSize="7.5" fontWeight="bold">Faktor yang</text>
            <text x="384" y="96" textAnchor="middle" fill="#002b80" fontSize="7.5" fontWeight="bold">Mempengaruhi</text>

            {/* ──────── GARIS NODES → CONTENT BOXES ──────── */}
            <line x1="46" y1="106" x2="46" y2="118" stroke="#002b80" strokeWidth="1.8" markerEnd="url(#arr5)" />
            <line x1="132" y1="114" x2="132" y2="126" stroke="#002b80" strokeWidth="1.8" markerEnd="url(#arr5)" />
            <line x1="215" y1="144" x2="215" y2="156" stroke="#002b80" strokeWidth="1.8" markerEnd="url(#arr5)" />
            <line x1="298" y1="106" x2="298" y2="118" stroke="#002b80" strokeWidth="1.8" markerEnd="url(#arr5)" />
            <line x1="384" y1="106" x2="384" y2="118" stroke="#002b80" strokeWidth="1.8" markerEnd="url(#arr5)" />

            {/* ──────── CONTENT BOXES ──────── */}

            {/* B1: Konsep Kesetimbangan */}
            <rect x="8" y="120" width="76" height="88" rx="6" fill="#f8faff" stroke="#002b80" strokeWidth="1.5" />
            <circle cx="16" cy="135" r="2.2" fill="#002b80" />
            <text x="21" y="138" fill="#002b80" fontSize="6.5">Reaksi bolak-balik</text>
            <text x="21" y="148" fill="#002b80" fontSize="6.5">dan dinamis</text>
            <circle cx="16" cy="159" r="2.2" fill="#002b80" />
            <text x="21" y="162" fill="#002b80" fontSize="6.5">Kesetimbangan</text>
            <text x="21" y="172" fill="#002b80" fontSize="6.5">dinamis</text>
            <circle cx="16" cy="183" r="2.2" fill="#002b80" />
            <text x="21" y="186" fill="#002b80" fontSize="6.5">Keadaan setimbang</text>

            {/* B2: Tetapan Kesetimbangan */}
            <rect x="94" y="128" width="76" height="102" rx="6" fill="#f8faff" stroke="#002b80" strokeWidth="1.5" />
            <circle cx="102" cy="143" r="2.2" fill="#002b80" />
            <text x="107" y="146" fill="#002b80" fontSize="6.5">Tetapan</text>
            <text x="107" y="156" fill="#002b80" fontSize="6.5">kesetimbangan (Kc)</text>
            <circle cx="102" cy="167" r="2.2" fill="#002b80" />
            <text x="107" y="170" fill="#002b80" fontSize="6.5">Tetapan</text>
            <text x="107" y="180" fill="#002b80" fontSize="6.5">kesetimbangan (Kp)</text>
            <circle cx="102" cy="191" r="2.2" fill="#002b80" />
            <text x="107" y="194" fill="#002b80" fontSize="6.5">Hubungan Kc &amp; Kp</text>
            <text x="107" y="204" fill="#002b80" fontSize="6.5">(Kp=Kc(RT)&#x394;&#x207F;)</text>

            {/* B3: Asas Le Chatelier description */}
            <rect x="177" y="158" width="76" height="72" rx="6" fill="#f8faff" stroke="#002b80" strokeWidth="1.5" />
            <text x="215" y="172" textAnchor="middle" fill="#002b80" fontSize="6.5">Sistem akan bergeser</text>
            <text x="215" y="183" textAnchor="middle" fill="#002b80" fontSize="6.5">untuk mengurangi</text>
            <text x="215" y="194" textAnchor="middle" fill="#002b80" fontSize="6.5">pengaruh perubahan</text>
            <text x="215" y="205" textAnchor="middle" fill="#002b80" fontSize="6.5">yang diberikan.</text>

            {/* B4: Kesetimbangan Heterogen */}
            <rect x="260" y="120" width="76" height="88" rx="6" fill="#f8faff" stroke="#002b80" strokeWidth="1.5" />
            <circle cx="268" cy="135" r="2.2" fill="#002b80" />
            <text x="273" y="138" fill="#002b80" fontSize="6.5">Kesetimbangan</text>
            <text x="273" y="148" fill="#002b80" fontSize="6.5">padat-cair</text>
            <circle cx="268" cy="159" r="2.2" fill="#002b80" />
            <text x="273" y="162" fill="#002b80" fontSize="6.5">Kesetimbangan</text>
            <text x="273" y="172" fill="#002b80" fontSize="6.5">gas-cair</text>
            <circle cx="268" cy="183" r="2.2" fill="#002b80" />
            <text x="273" y="186" fill="#002b80" fontSize="6.5">Kesetimbangan</text>
            <text x="273" y="196" fill="#002b80" fontSize="6.5">gas-padat</text>

            {/* B5: Faktor yang Mempengaruhi */}
            <rect x="346" y="120" width="76" height="88" rx="6" fill="#f8faff" stroke="#002b80" strokeWidth="1.5" />
            <circle cx="354" cy="133" r="2.2" fill="#002b80" />
            <text x="359" y="136" fill="#002b80" fontSize="6.5">Perubahan</text>
            <text x="359" y="146" fill="#002b80" fontSize="6.5">konsentrasi</text>
            <circle cx="354" cy="157" r="2.2" fill="#002b80" />
            <text x="359" y="160" fill="#002b80" fontSize="6.5">Perubahan tekanan/</text>
            <text x="359" y="170" fill="#002b80" fontSize="6.5">volume</text>
            <circle cx="354" cy="181" r="2.2" fill="#002b80" />
            <text x="359" y="184" fill="#002b80" fontSize="6.5">Perubahan suhu</text>
            <circle cx="354" cy="195" r="2.2" fill="#002b80" />
            <text x="359" y="198" fill="#002b80" fontSize="6.5">Katalis</text>

            {/* ──────── MERGE LINES → PENERAPAN ──────── */}
            {/* Lines from bottom of each box down to horizontal merge */}
            <line x1="46" y1="208" x2="46" y2="242" stroke="#002b80" strokeWidth="1.8" />
            <line x1="132" y1="230" x2="132" y2="242" stroke="#002b80" strokeWidth="1.8" />
            <line x1="215" y1="230" x2="215" y2="242" stroke="#002b80" strokeWidth="1.8" />
            <line x1="298" y1="208" x2="298" y2="242" stroke="#002b80" strokeWidth="1.8" />
            <line x1="384" y1="208" x2="384" y2="242" stroke="#002b80" strokeWidth="1.8" />
            {/* Horizontal merge */}
            <line x1="46" y1="242" x2="384" y2="242" stroke="#002b80" strokeWidth="1.8" />
            {/* Center drop arrow */}
            <line x1="215" y1="242" x2="215" y2="256" stroke="#002b80" strokeWidth="1.8" markerEnd="url(#arr5)" />

            {/* ──────── BOTTOM: PENERAPAN DALAM KEHIDUPAN ──────── */}
            <rect x="120" y="258" width="190" height="68" rx="8" fill="#f8faff" stroke="#002b80" strokeWidth="1.5" />
            <text x="215" y="274" textAnchor="middle" fill="#002b80" fontSize="9" fontWeight="bold" fontFamily="Poppins,sans-serif">Penerapan dalam</text>
            <text x="215" y="287" textAnchor="middle" fill="#002b80" fontSize="9" fontWeight="bold" fontFamily="Poppins,sans-serif">Kehidupan</text>
            <text x="215" y="302" textAnchor="middle" fill="#555" fontSize="6.5">Kesetimbangan kimia dimanfaatkan</text>
            <text x="215" y="313" textAnchor="middle" fill="#555" fontSize="6.5">dalam berbagai bidang seperti industri,</text>
            <text x="215" y="324" textAnchor="middle" fill="#555" fontSize="6.5">lingkungan, farmasi, dan proses biologis.</text>
          </svg>
        </div>

      </div>

      {/* Nomor Halaman */}
      <div className="absolute right-[6%] bottom-[4%] z-20 flex items-center justify-center gap-2">
        <div className="w-[12px] h-[3px] bg-[#ffc107] rounded-full"></div>
        <div className="w-[28px] h-[28px] bg-white border-[2.5px] border-[#002b80] rounded-lg flex items-center justify-center shadow-sm">
          <span className="font-extrabold text-[#002b80] text-[14px] leading-none mt-[1px]" style={{ fontFamily: "'Poppins', sans-serif" }}>4</span>
        </div>
        <div className="w-[12px] h-[3px] bg-[#ffc107] rounded-full"></div>
      </div>

    </div>
  );
});

export default PageFive;
