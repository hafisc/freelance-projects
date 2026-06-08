@extends('layouts.siswa')

@section('title', 'Pengantar Gelombang')

@section('siswa-content')

  <div class="materi-gelombang">


    <!-- ====================
         KONTEN UTAMA
         ==================== -->
    <main class="content">
      <h1>Pengantar Materi Gelombang</h1>

      <div class="box">

        <!-- ===== TUJUAN PEMBELAJARAN ===== -->
        <section id="page-tp" class="subpage" style="display:block;">
          <h3>Capaian Pembelajaran</h3>

          <p>
            Peserta didik mampu menerapkan konsep dan prinsip
            gejala gelombang bunyi dan gelombang cahaya dalam
            menyelesaikan masalah serta mengaitkannya dengan
            fenomena dan penerapannya dalam kehidupan sehari-hari.
          </p>

          <h3>Tujuan Pembelajaran</h3>
          <p>Setelah mempelajari materi gelombang, peserta didik diharapkan mampu:</p>
          <ol>
            <li>Menjelaskan pengertian dan konsep dasar gelombang dengan tepat.</li>
            <li>Mengidentifikasi besaran-besaran gelombang (amplitudo, panjang gelombang, frekuensi, periode, dan cepat
              rambat) secara benar.</li>
            <li>Mengklasifikasikan jenis gelombang berdasarkan arah getar, arah rambat, dan mediumnya dengan tepat.</li>
            <li>Menjelaskan konsep fase dan beda fase gelombang sesuai konsep fisika.</li>
            <li>Menjelaskan prinsip dasar gelombang (superposisi, interferensi, difraksi, dan refleksi) dengan benar.</li>
          </ol>
        </section>

        <hr style="margin:30px 0; border:1px dashed #c7d2fe;">

        <!-- ===== PENGANTAR ===== -->
        <section id="page-apersepsi" class="subpage" style="display:block;">
          <h3 style="text-align:center; color:#1e3a8a;">Pengantar</h3>

          <p>
            Pernahkah kamu memperhatikan riak air ketika sebuah batu dilempar ke kolam?
            Riak tersebut menyebar ke segala arah, menandakan adanya gangguan yang merambat.
          </p>

          <p>
            Contoh lain adalah bunyi petir yang terdengar meskipun sumbernya jauh.
            Hal ini menunjukkan bahwa bunyi merambat melalui udara.
          </p>

          <p>
            Fenomena perambatan gangguan ini merupakan kajian utama dalam materi gelombang.
          </p>

          <p>
            Pemahaman gelombang menjadi dasar untuk memahami bunyi, cahaya,
            gelombang radio, serta teknologi modern.
          </p>

        </section>

      </div>

      <!-- ===== TOMBOL LANJUT ===== -->
      <button class="next-btn main-next" onclick="location.href='{{ url('definisi_gelombang') }}'">
        Mulai Materi Gelombang →
      </button>

    </main>

  </div>


  <script>
    document.addEventListener("DOMContentLoaded", () => {

      /* =========================
         SIDEBAR ACCORDION
      ========================== */
      document.querySelectorAll(".menu-item.has-toggle").forEach(item => {
        item.addEventListener("click", () => {
          const targetId = item.dataset.menu;
          const submenu = document.getElementById(targetId);

          if (!submenu) return;

          const open = submenu.classList.contains("open");

          document.querySelectorAll(".submenu").forEach(s => s.classList.remove("open"));
          document.querySelectorAll(".menu-item").forEach(i => i.classList.remove("menu-item-open"));

          if (!open) {
            submenu.classList.add("open");
            item.classList.add("menu-item-open");
          }
        });
      });

      // auto-open active link
      const activeLink = document.querySelector(".submenu-item a.active-link");
      if (activeLink) {
        const submenu = activeLink.closest(".submenu");
        submenu.classList.add("open");
        submenu.previousElementSibling.classList.add("menu-item-open");
      }

      /* =========================
         NAVIGASI SUB HALAMAN
      ========================== */
      const pages = document.querySelectorAll(".subpage");
      const navBtns = document.querySelectorAll(".inner-nav-btn");
      const prevBtn = document.getElementById("inner-prev");
      const nextBtn = document.getElementById("inner-next");

      let current = 0;
    });
  </script>

  <script>
    window.addEventListener("beforeunload", function () {
      kirimProgress("pengantar_gelombang", 1);
    });
  </script>

@endsection