import React, { useRef, useState } from 'react';
import HTMLFlipBook from 'react-pageflip';
import PageCover from './pages/PageCover';
import PageTwo from './pages/PageTwo';
import PageThree from './pages/PageThree';
import PageFour from './pages/PageFour';
import PageFive from './pages/PageFive';
import PageSix from './pages/PageSix';
import PageSeven from './pages/PageSeven';
import PageEight from './pages/PageEight';
import PageNine from './pages/PageNine';
import PageTen from './pages/PageTen';
import PageEleven from './pages/PageEleven';
import PageTwelve from './pages/PageTwelve';
import PageThirteen from './pages/PageThirteen';
import PageFourteen from './pages/PageFourteen';
import PageFifteen from './pages/PageFifteen';

// ========================================================
// KOMPONEN: App
// DESKRIPSI: Routing dan Wrapper Utama FlipBook
// ========================================================
function App() {
  const bookRef = useRef();
  const [currentPage, setCurrentPage] = useState(0);

  const onPage = (e) => {
    setCurrentPage(e.data);
  };

  const goToPage = (pageIndex) => {
    if (bookRef.current) {
      bookRef.current.pageFlip().flip(pageIndex);
    }
  };

  return (
    <div className="flipbook-container">
      <div className={`flipbook-wrapper ${currentPage === 0 ? 'book-closed-front' : ''} ${currentPage === 17 ? 'book-closed-back' : ''}`}>
        <HTMLFlipBook
          width={500}
          height={750}
          size="stretch"
          minWidth={315}
          maxWidth={1000}
          minHeight={420}
          maxHeight={1350}
          maxShadowOpacity={0.5}
          showCover={true}
          mobileScrollSupport={true}
          className="book-wrapper mx-auto"
          ref={bookRef}
          onFlip={onPage}
        >
          {/* Halaman 1 - Cover (Index 0) */}
          <PageCover goToPage={goToPage} />

          {/* Halaman 2 - Kosong (Index 1) */}
          <div className="page" data-density="hard">
            <div className="p-5 d-flex align-items-center justify-content-center h-100 bg-white">
              {/* Kosong */}
            </div>
          </div>

          {/* Halaman 3 - Kata Pengantar (Index 2) */}
          <PageTwo goToPage={goToPage} />

          {/* Halaman 4 - Daftar Isi (Index 3) */}
          <PageThree goToPage={goToPage} />

          {/* Halaman 5 - Petunjuk Penggunaan (Index 4) */}
          <PageFour goToPage={goToPage} />

          {/* Halaman 6 - Peta Konsep (Index 5) */}
          <PageFive goToPage={goToPage} />

          {/* Halaman 7 - Tujuan Pembelajaran (Index 6) */}
          <PageSix goToPage={goToPage} />

          {/* Halaman 8 - Selamat Datang (Index 7) */}
          <PageSeven goToPage={goToPage} />

          {/* Halaman 9 - Unit Materi (Index 8) */}
          <PageEight goToPage={goToPage} />

          {/* Halaman 10 - Tahapan PBL (Index 9) */}
          <PageNine goToPage={goToPage} />

          {/* Halaman 11 - Aktivitas / LKPD (Index 10) */}
          <PageTen goToPage={goToPage} />

          {/* Halaman 12 - Simulasi (Index 11) */}
          <PageEleven goToPage={goToPage} />

          {/* Halaman 13 - Evaluasi (Index 12) */}
          <PageTwelve goToPage={goToPage} />

          {/* Halaman 14 - Progress (Index 13) */}
          <PageThirteen goToPage={goToPage} />

          {/* Halaman 15 - Feedback (Index 14) */}
          <PageFourteen goToPage={goToPage} />

          {/* Halaman 16 - Glosarium (Index 15) */}
          <PageFifteen goToPage={goToPage} />

          {/* Halaman 17 - Kosong (Index 16) */}
          <div className="page" data-density="hard">
            <div className="p-5 flex items-center justify-center h-full w-full bg-white">
            </div>
          </div>

          {/* Halaman 18 - Cover Belakang (Index 17) */}
          <div className="page page-cover" data-density="hard">
            <div className="bg-[#002b80] h-full w-full flex flex-col items-center justify-center relative overflow-hidden">
              <svg viewBox="0 0 400 400" className="absolute top-0 right-0 w-[80%] opacity-10">
                <circle cx="200" cy="100" r="150" fill="none" stroke="#fff" strokeWidth="20" />
                <circle cx="200" cy="100" r="100" fill="none" stroke="#fff" strokeWidth="15" />
              </svg>
              <h2 className="font-extrabold text-white text-[32px] tracking-wide" style={{ fontFamily: "'Poppins', sans-serif" }}>EquiChem</h2>
              <p className="text-[#ffc107] font-medium text-[13px] mt-2 tracking-widest uppercase">Micromodul Interaktif</p>
            </div>
          </div>
        </HTMLFlipBook>
      </div>
    </div>
  );
}

export default App;
