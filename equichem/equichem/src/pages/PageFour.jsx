import React from 'react';

const PageFour = React.forwardRef((props, ref) => {
  const instructions = [
    { num: 1, title: 'Bacalah tujuan pembelajaran.', desc: 'Pahami tujuan yang ingin dicapai sebelum memulai kegiatan belajar.' },
    { num: 2, title: 'Pelajari materi dan sumber belajar interaktif yang tersedia.', desc: 'Gunakan materi, video, gambar, dan referensi lain untuk memahami konsep dengan lebih baik.' },
    { num: 3, title: 'Kerjakan aktivitas PBL pada setiap unit.', desc: 'Lakukan kegiatan sesuai langkah-langkah yang disediakan untuk melatih keterampilan berpikir kritis dan kreatif.' },
    { num: 4, title: 'Lakukan evaluasi untuk mengukur pemahaman.', desc: 'Kerjakan soal evaluasi di akhir setiap unit untuk mengetahui tingkat pemahaman Anda.' },
    { num: 5, title: 'Gunakan menu navigasi di samping untuk berpindah halaman.', desc: 'Pilih tombol navigasi di bagian bawah untuk memudahkan Anda menjelajahi micromodul ini.' },
  ];

  const navigations = [
    { icon: 'bi-house-door-fill', title: 'Beranda', desc: 'Kembali ke halaman utama.' },
    { icon: 'bi-book-fill', title: 'Materi', desc: 'Lihat dan pelajari materi pembelajaran.' },
    { icon: 'bi-puzzle-fill', title: 'PBL', desc: 'Kerjakan aktivitas berbasis masalah.' },
    { icon: 'bi-clipboard-check-fill', title: 'Evaluasi', desc: 'Kerjakan soal evaluasi untuk mengukur pemahaman.' },
    { icon: 'bi-person-fill', title: 'Profil', desc: 'Lihat informasi pengembang micromodul.' },
  ];

  return (
    <div className="page bg-white relative w-full h-full overflow-hidden flex flex-col font-sans" ref={ref} data-density="soft">

      {/* === BACKGROUND === */}

      {/* Header Curves */}
      <div className="absolute top-0 left-0 w-full h-[18%] z-0 pointer-events-none">
        <svg viewBox="0 0 1000 180" preserveAspectRatio="none" className="w-full h-full">
          <path d="M 0 0 L 0 110 C 100 80, 250 15, 450 15 C 650 15, 800 130, 1000 170 L 1000 0 Z" fill="#ffc107" />
          <path d="M 0 0 L 0 95 C 100 65, 250 0, 450 0 C 650 0, 800 115, 1000 155 L 1000 0 Z" fill="#002b80" />
        </svg>
      </div>

      {/* Molekul dekoratif */}
      <div className="absolute top-[8%] right-[-10%] w-[50%] h-[55%] z-[1] pointer-events-none opacity-[0.06]">
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
        </svg>
      </div>

      {/* Footer Curves */}
      <div className="absolute bottom-0 left-0 w-full h-[18%] z-0 pointer-events-none">
        <svg viewBox="0 0 1000 180" preserveAspectRatio="none" className="w-full h-full">
          <path d="M 0 0 C 150 15, 300 45, 500 80 C 700 115, 850 145, 1000 150 L 1000 180 L 0 180 Z" fill="#ffc107" />
          <path d="M 0 45 C 150 60, 300 90, 500 120 C 700 150, 850 170, 1000 180 L 0 180 Z" fill="#002b80" />
        </svg>
      </div>

      {/* === KONTEN === */}
      {/* Gunakan absolute positioning agar tidak pernah overlap dengan footer wave */}
      <div style={{
        position: 'absolute',
        top: '19%',
        left: '8%',
        right: '8%',
        bottom: '18%',
        display: 'flex',
        flexDirection: 'column',
        zIndex: 10,
        overflow: 'hidden',
      }}>

        {/* Judul */}
        <div style={{ marginBottom: '8px', flexShrink: 0 }}>
          <h1 style={{
            fontFamily: "'Poppins', sans-serif",
            fontSize: '28px',
            fontWeight: 800,
            color: '#002b80',
            margin: 0,
            lineHeight: 1,
            letterSpacing: '-0.01em',
          }}>
            PETUNJUK PENGGUNAAN
          </h1>
          <div style={{ display: 'flex', gap: '4px', marginTop: '6px' }}>
            <div style={{ width: '45px', height: '3px', background: '#002b80', borderRadius: '2px' }}></div>
            <div style={{ width: '30px', height: '3px', background: '#ffc107', borderRadius: '2px' }}></div>
          </div>
        </div>

        {/* Intro */}
        <p style={{
          color: '#333',
          fontSize: '11px',
          lineHeight: 1.6,
          fontWeight: 500,
          margin: '0 0 10px 0',
          width: '68%',
          flexShrink: 0,
        }}>
          Micromodul ini dirancang agar dapat digunakan dengan mudah dan efektif. Ikuti langkah-langkah berikut untuk mendapatkan pengalaman belajar yang optimal.
        </p>

        {/* List 5 item — ukuran natural, tidak pakai flex-1 */}
        <div style={{ display: 'flex', flexDirection: 'column', gap: '8px', flexShrink: 0 }}>
          {instructions.map((item) => (
            <div key={item.num} style={{ display: 'flex', alignItems: 'flex-start' }}>
              {/* Nomor */}
              <div style={{
                width: '24px', height: '24px', borderRadius: '50%',
                background: '#002b80',
                display: 'flex', alignItems: 'center', justifyContent: 'center',
                color: 'white', fontWeight: 700, fontSize: '12px',
                flexShrink: 0, marginTop: '2px',
                fontFamily: "'Poppins', sans-serif",
              }}>
                {item.num}
              </div>
              {/* Teks */}
              <div style={{ marginLeft: '10px' }}>
                <p style={{ color: '#000', fontWeight: 700, fontSize: '11px', lineHeight: 1.35, margin: '0 0 1px 0' }}>
                  {item.title}
                </p>
                <p style={{ color: '#555', fontWeight: 400, fontSize: '11px', lineHeight: 1.4, margin: 0 }}>
                  {item.desc}
                </p>
              </div>
            </div>
          ))}
        </div>

        {/* Navigation Box */}
        <div style={{
          background: '#f8f9fa',
          border: '1px solid #e5e7eb',
          borderRadius: '12px',
          padding: '8px 6px',
          display: 'flex',
          alignItems: 'stretch',
          flexShrink: 0,
          boxShadow: '0 2px 8px rgba(0,0,0,0.06)',
          marginTop: '16px',
        }}>
          {navigations.map((nav, i) => (
            <div key={i} style={{
              flex: 1,
              display: 'flex',
              flexDirection: 'column',
              alignItems: 'center',
              textAlign: 'center',
              padding: '0 4px',
              borderRight: i < 4 ? '1px solid #e5e7eb' : 'none',
            }}>
              <div style={{
                width: '34px', height: '34px',
                background: '#002b80', borderRadius: '50%',
                display: 'flex', alignItems: 'center', justifyContent: 'center',
                marginBottom: '5px', flexShrink: 0,
              }}>
                <i className={`bi ${nav.icon}`} style={{ fontSize: '15px', color: 'white' }}></i>
              </div>
              <p style={{ fontWeight: 800, color: '#002b80', fontSize: '10px', margin: '0 0 2px 0', lineHeight: 1.2, fontFamily: "'Poppins', sans-serif" }}>
                {nav.title}
              </p>
              <p style={{ color: '#555', fontSize: '8.5px', lineHeight: 1.35, margin: 0, fontWeight: 400 }}>
                {nav.desc}
              </p>
            </div>
          ))}
        </div>

      </div>

      {/* Nomor Halaman */}
      <div className="absolute right-[6%] bottom-[4%] z-20 flex items-center justify-center gap-2">
        <div className="w-[12px] h-[3px] bg-[#ffc107] rounded-full"></div>
        <div className="w-[28px] h-[28px] bg-white border-[2.5px] border-[#002b80] rounded-lg flex items-center justify-center shadow-sm">
          <span className="font-extrabold text-[#002b80] text-[14px] leading-none mt-[1px]" style={{ fontFamily: "'Poppins', sans-serif" }}>3</span>
        </div>
        <div className="w-[12px] h-[3px] bg-[#ffc107] rounded-full"></div>
      </div>

    </div>
  );
});

export default PageFour;
