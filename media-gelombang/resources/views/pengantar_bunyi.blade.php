@extends('layouts.siswa')

@section('title', 'Pengantar Gelombang Bunyi')

@section('siswa-content')

  <div class="materi-gelombang">

    {{-- ====================
    KONTEN
    ==================== --}}
    <main class="content">

      <h1>Pengantar Gelombang Bunyi</h1>

      <div class="box">

        {{-- ===== TUJUAN PEMBELAJARAN ===== --}}
        <section>

          <h3>Capaian Pembelajaran</h3>

          <p>
            Peserta didik mampu menerapkan konsep dan prinsip
            gejala gelombang bunyi dan gelombang cahaya dalam
            menyelesaikan masalah serta mengaitkannya dengan
            fenomena dan penerapannya dalam kehidupan sehari-hari.
          </p>

          <h3>Tujuan Pembelajaran</h3>

          <p>
            Setelah mempelajari materi gelombang bunyi, peserta didik diharapkan mampu:
          </p>

          <ol>
            <li>
              Menjelaskan bunyi sebagai gelombang mekanik yang memerlukan medium
              untuk merambat dengan tepat.
            </li>

            <li>
              Menjelaskan konsep perambatan bunyi dalam berbagai medium secara benar.
            </li>

            <li>
              Menganalisis sumber bunyi serta karakteristik bunyi
              (tinggi–rendah, kuat–lemah, dan warna bunyi)
              sesuai konsep fisika.
            </li>

            <li>
              Mengaitkan konsep gelombang bunyi dengan fenomena dan penerapannya
              dalam kehidupan sehari-hari secara tepat.
            </li>
          </ol>

        </section>


        <hr style="margin:35px 0;">


        {{-- ===== PENGANTAR ===== --}}
        <section>

          <center>
            <h2 style="color:#1e3a8a;">Pengantar</h2>
          </center>

          <p>
            Pada bab sebelumnya, kamu telah mempelajari bahwa <b>gelombang</b>
            adalah getaran yang <b>merambat</b> dan membawa <b>energi</b>
            tanpa memindahkan medium secara permanen.
          </p>

          <p>
            Kamu juga telah mengenal bahwa gelombang dapat dibedakan menjadi
            <b>gelombang mekanik</b> dan <b>gelombang elektromagnetik</b>.
            Gelombang mekanik memerlukan <b>medium</b> untuk dapat merambat.
          </p>

          <p>
            Sekarang, bayangkan jika tidak ada udara di sekitarmu.
            Apakah kamu masih bisa mendengar suara teman yang berbicara?
          </p>

          <p>
            Pertanyaan ini menunjukkan bahwa <b>bunyi merupakan gelombang mekanik</b>
            yang memerlukan medium untuk merambat.
          </p>

          <p>
            Pada bab ini, kamu akan mempelajari:
          </p>

          <ul>
            <li>Bagaimana bunyi dihasilkan.</li>
            <li>Bagaimana bunyi merambat melalui medium.</li>
            <li>Karakteristik bunyi.</li>
            <li>Fenomena serta penerapan gelombang bunyi dalam kehidupan.</li>
          </ul>

        </section>

      </div>


      {{-- ===== NAVIGASI KE MATERI BERIKUTNYA ===== --}}
      <button class="next-btn" onclick="location.href='{{ url('konsep_perambatan_bunyi') }}'" style="margin-top:15px;">
        Materi Selanjutnya →
      </button>

    </main>
  </div>

  <script>
    window.addEventListener("beforeunload", function () {
      kirimProgress("pengantar_bunyi", 7);
    });
  </script>

@endsection