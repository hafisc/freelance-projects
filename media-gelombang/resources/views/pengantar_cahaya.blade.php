@extends('layouts.siswa')

@section('title', 'Pengantar Gelombang Cahaya')

@section('siswa-content')

  <div class="materi-gelombang">



    {{-- ====================
    KONTEN UTAMA
    ==================== --}}
    <main class="content">

      <h1>Pengantar Gelombang Cahaya</h1>

      <div class="box">

        {{-- PAGE 1 --}}
        <section id="page-tp" class="subpage">

          <h3>Capaian Pembelajaran</h3>

          <p>
            Peserta didik mampu menerapkan konsep dan prinsip
            gejala gelombang bunyi dan gelombang cahaya dalam
            menyelesaikan masalah serta mengaitkannya dengan
            fenomena dan penerapannya dalam kehidupan sehari-hari.
          </p>
          
          <h3>Tujuan Pembelajaran</h3>

          <p>Setelah mempelajari materi gelombang cahaya, peserta didik diharapkan mampu:</p>

          <ol>
            <!-- TP ini dituntaskan pada halaman Pengantar Gelombang Cahaya -->
            <li>Menjelaskan cahaya sebagai gelombang elektromagnetik yang tidak memerlukan medium untuk merambat dengan
              tepat.</li>

            <!-- TP ini dituntaskan pada halaman Sifat-Sifat Cahaya -->
            <li>Menjelaskan sifat-sifat cahaya seperti pemantulan, pembiasan, dan dispersi secara benar.</li>

            <!-- TP ini dituntaskan pada halaman Spektrum Gelombang Elektromagnetik -->
            <li>Mengidentifikasi spektrum cahaya berdasarkan panjang gelombang dan frekuensinya dengan tepat.</li>

            <!-- TP ini dituntaskan pada halaman Fenomena & Aplikasi Cahaya -->
            <li>Mengaitkan konsep gelombang cahaya dengan fenomena dan penerapannya dalam kehidupan sehari-hari secara
              tepat.</li>
          </ol>
        </section>

        {{-- PAGE 2 --}}
        <section id="page-apersepsi" class="subpage" style="display:none;">
          <h2 style="text-align:center; color:#1e3a8a;">Pengantar</h2>

          <p>
            Pada materi sebelumnya, kamu telah mempelajari
            <b>gelombang mekanik</b>, seperti gelombang pada tali
            dan gelombang bunyi. Gelombang tersebut
            <b>memerlukan medium</b> untuk dapat merambat.
          </p>

          <p>
            Sekarang, coba perhatikan sekelilingmu.
            Mengapa kita dapat melihat benda di sekitar kita?
            Bagaimana cahaya dari Matahari bisa sampai ke Bumi
            yang dipisahkan oleh ruang hampa?
          </p>

          <div class="box-diff">
            Cahaya dapat merambat tanpa medium.
            Hal ini menunjukkan bahwa cahaya memiliki sifat
            yang berbeda dengan gelombang mekanik.
          </div>

          <p>
            Pada subbab ini, kamu akan mempelajari
            <b>gelombang cahaya</b> sebagai salah satu bentuk
            <b>gelombang elektromagnetik</b>.
          </p>
        </section>

      </div>

      {{-- NAVIGASI DALAM --}}
      <div class="inner-navigation">
        <button id="inner-prev" class="next-btn">Previous</button>

        <button class="next-btn inner-nav-btn" data-target="page-tp">1</button>
        <button class="next-btn inner-nav-btn" data-target="page-apersepsi">2</button>

        <button id="inner-next" class="next-btn">Next</button>
      </div>

      <button class="next-btn" onclick="location.href='{{ url('sifat_cahaya') }}'">
        Mulai Materi Gelombang Cahaya →
      </button>

    </main>
  </div>

@endsection
@section('scripts')
  <script>
    document.addEventListener("DOMContentLoaded", () => {

      const pages = document.querySelectorAll(".subpage");
      const navBtns = document.querySelectorAll(".inner-nav-btn");
      const prevBtn = document.getElementById("inner-prev");
      const nextBtn = document.getElementById("inner-next");

      const order = ["page-tp", "page-apersepsi"];
      let currentIndex = 0;

      function showPage(targetId) {
        pages.forEach(p => {
          p.style.display = (p.id === targetId) ? "block" : "none";
        });

        navBtns.forEach(btn => {
          btn.style.backgroundColor =
            btn.dataset.target === targetId ? "#0f766e" : "";
          btn.style.color =
            btn.dataset.target === targetId ? "#ffffff" : "";
        });

        currentIndex = order.indexOf(targetId);
        prevBtn.disabled = currentIndex === 0;
        nextBtn.disabled = currentIndex === order.length - 1;
      }

      navBtns.forEach(btn => {
        btn.addEventListener("click", () => {
          showPage(btn.dataset.target);
        });
      });

      prevBtn.addEventListener("click", () => {
        if (currentIndex > 0) {
          showPage(order[currentIndex - 1]);
        }
      });

      nextBtn.addEventListener("click", () => {
        if (currentIndex < order.length - 1) {
          showPage(order[currentIndex + 1]);
        }
      });

      // halaman awal
      showPage(order[0]);

    });
  </script>

  <script>
    window.addEventListener("beforeunload", function () {
      kirimProgress("pengantar_cahaya", 12);
    });
  </script>
@endsection