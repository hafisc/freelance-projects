@extends('layouts.siswa')

@section('title', 'Definisi Getaran dan Gelombang')

@section('siswa-content')

  <div class="materi-gelombang">


    <!-- ====================
                             KONTEN UTAMA
                             ==================== -->
    <main class="content">

      <h2>Definisi dan Konsep Dasar: Getaran dan Gelombang</h2>

      <div class="box">

        <!-- ===== HALAMAN 1 ===== -->
        <section id="page-getaran" class="subpage">
          <h3>Apa itu Getaran?</h3>
          <p>
            Sebelum membahas gelombang, kita perlu memahami <b>getaran</b>.
            <b>Getaran</b> adalah <b>gerak bolak–balik secara periodik</b> di sekitar posisi setimbang.
            Benda yang bergetar bergerak <i>ulang–ulang</i> melalui lintasan yang sama.
          </p>
          <p>
            Contoh getaran dalam kehidupan sehari-hari:
          </p>
          <ul>
            <li>Pendulum (bandul) jam dinding yang bergerak ke kiri dan ke kanan.</li>
            <li>Ujung penggaris plastik yang dijepit di meja lalu digetarkan.</li>
            <li>Massa yang digantung pada pegas dan bergerak naik–turun.</li>
          </ul>

          <p>
            Perhatikan animasi berikut. Sebuah massa digantung pada <b>pegas</b> dan bergerak naik–turun.
            Gerak ini adalah <b>getaran</b> karena:
          </p>
          <ul>
            <li>Geraknya bolak–balik melewati posisi setimbang.</li>
            <li>Pola geraknya <b>berulang secara teratur</b>.</li>
            <li>Tidak ada bagian medium lain yang ikut bergerak jauh; hanya massa di ujung pegas yang berosilasi.</li>
          </ul>

          <div class="image-container">
            <canvas id="vibrationDemo" width="760" height="220"></canvas>
            <div class="caption">
              Animasi getaran massa pada pegas.
            </div>
          </div>

          <p>
            Pada getaran, kita mengenal beberapa besaran utama:
          </p>
          <ul>
            <li><b>Amplitudo (A)</b>: simpangan maksimum dari posisi setimbang.</li>
            <li><b>Periode (T)</b>: waktu yang dibutuhkan untuk satu getaran penuh.</li>
            <li><b>Frekuensi (f)</b>: banyaknya getaran setiap detik, dengan hubungan <b>f = 1/T</b>.</li>
          </ul>
        </section>


        <!-- ===== HALAMAN 2 ===== -->
        <section id="page-dari-getaran" class="subpage" style="display:none;">
          <h3>Getaran & Gelombang</h3>
          <p>
            Jika hanya <b>satu benda</b> yang bergetar (misalnya ujung pegas), kita hanya memiliki <b>getaran</b>.
            Namun, jika getaran itu <b>menyebabkan titik-titik lain di sekitarnya juga ikut bergetar</b>
            dan <b>pola getaran tersebut merambat</b> ke tempat lain, maka terbentuklah <b>gelombang</b>.
          </p>
          <p>
            Jadi, secara konsep:
          </p>
          <ul>
            <li><b>Getaran</b> → gerak bolak–balik di satu titik.</li>
            <li><b>Gelombang</b> → getaran yang <b>merambat</b> dari satu titik ke titik lain.</li>
          </ul>
          <p>
            Contoh transisi dari getaran ke gelombang:
          </p>
          <ul>
            <li>Memetik senar gitar: awalnya senar bergetar, lalu getaran itu merambat sebagai <b>gelombang bunyi</b> di
              udara.</li>
            <li>Menjatuhkan batu ke air: titik tumbukan bergetar, lalu pola gangguan merambat sebagai <b>riak
                gelombang</b> di permukaan air.</li>
          </ul>

          <h3>Apa itu Gelombang?</h3>
          <p>
            Secara sederhana, <b>gelombang adalah getaran yang merambat</b> dari satu tempat ke tempat lain.
            Gelombang membawa <b>energi</b>, bukan membawa benda atau zatnya secara permanen.
          </p>
          <p>
            Contoh:
          </p>
          <ul>
            <li>Suara yang kamu dengar adalah <b>gelombang bunyi</b> yang merambat melalui udara.</li>
            <li>Cahaya dari lampu atau matahari adalah <b>gelombang cahaya</b>.</li>
            <li>Riak di permukaan air ketika kamu melempar batu kecil adalah <b>gelombang permukaan air</b>.</li>
          </ul>
          <p>
            Pada riak air, partikel air hanya <b>naik–turun di tempat</b>, tetapi energi getarannya merambat ke luar.
            Jadi, <b>gelombang memindahkan energi, bukan memindahkan materi</b>.
          </p>
        </section>


        <!-- ===== HALAMAN 3 ===== -->
        <section id="page-gelombang-air" class="subpage" style="display:none;">
          <h3>Gelombang Permukaan Air</h3>
          <p>
            Sekarang perhatikan animasi berikut. Saat kamu menjatuhkan batu ke air,
            titik yang terkena batu akan <b>terganggu terlebih dahulu</b>.
            Setelah itu, gangguan ini <b>merambat ke samping</b> sehingga permukaan air di tempat lain
            juga naik–turun. Inilah yang kita sebut sebagai <b>gelombang permukaan air</b>.
          </p>

          <div class="image-container">
            <canvas id="waveCanvas" width="760" height="260"></canvas>
            <div class="caption">
              Klik area air untuk menjatuhkan batu.
            </div>
          </div>

          <audio id="splashSound" src="{{ asset('audio/splash.mp3') }}"></audio>

          <h3>Muka Gelombang dan Panjang Gelombang</h3>
          <p>
            Jika kamu melihat riak air dari atas, kamu akan melihat lingkaran-lingkaran yang menyebar.
            Lingkaran ini disebut <b>muka gelombang</b>, yaitu kumpulan titik yang <b>bergetar dengan fase yang sama</b>.
          </p>
          <p>
            <b>Panjang gelombang (λ)</b> adalah <b>jarak antara dua muka gelombang yang berdekatan</b>
            atau dua puncak (atau dua lembah) gelombang yang berurutan.
          </p>
          <p>
            Arah perambatan gelombang (misalnya ke luar menjauhi titik tumbukan batu) disebut <b>sinar gelombang</b>.
            Secara prinsip, <b>sinar gelombang selalu tegak lurus dengan muka gelombang</b>.
          </p>
        </section>


        <!-- ===== HALAMAN 4 ===== -->
        <section id="page-besaran" class="subpage" style="display:none;">

          <h3>Besaran-Besaran Gelombang</h3>

          <div class="example-row">

            <!-- ================= KIRI (TEKS) ================= -->
            <div class="example-text">

              <p>Pada gelombang, terdapat beberapa besaran fisika yang penting untuk dipahami:</p>

              <ul>
                <li>
                  <b>Amplitudo (A)</b> — dibaca: <i>a</i><br>
                  Simpangan maksimum dari posisi setimbang.
                </li>

                <li>
                  <b>Periode (T)</b> — dibaca: <i>te</i><br>
                  Waktu yang diperlukan untuk satu getaran penuh.
                </li>

                <li>
                  <b>Frekuensi (f)</b> — dibaca: <i>ef</i><br>
                  Banyaknya getaran tiap detik.
                </li>

                <li>
                  <b>Panjang Gelombang (λ)</b> — dibaca: <i>lambda</i><br>
                  Jarak antara dua puncak atau dua lembah yang berurutan.
                </li>

                <li>
                  <b>Cepat Rambat (v)</b> — dibaca: <i>ve</i><br>
                  Kecepatan perambatan gelombang dalam suatu medium.
                </li>
              </ul>

            </div>

            <!-- ================= KANAN (GAMBAR) ================= -->
            <div class="example-image">
              <img src="{{ asset('images/besaran_gelombang.png') }}" style="width: 500px; height: 260px;"
                alt="Ilustrasi besaran gelombang">

              <p class="caption">
                Ilustrasi amplitudo (A), panjang gelombang (λ), dan arah rambat gelombang.
              </p>
            </div>

          </div>


          <h3 style="margin-top:24px;">Hubungan Antar Besaran</h3>

          <p>Besaran-besaran tersebut saling berhubungan melalui persamaan berikut:</p>

          <div class="rumus-wrapper">
            <span class="rumus">f = 1 / T</span>
          </div>

          <p>
            Artinya, semakin kecil periode (T), maka frekuensi (f) semakin besar.
          </p>

          <div class="rumus-wrapper">
            <span class="rumus">v = λ × f</span>
          </div>

          <p>
            Artinya, cepat rambat gelombang dipengaruhi oleh panjang gelombang dan frekuensinya.
          </p>


          <h3 style="margin-top:20px;">Ringkasan</h3>
          <ul>
            <li>Getaran adalah gerak bolak–balik di sekitar posisi setimbang.</li>
            <li>Gelombang adalah getaran yang merambat dan membawa energi.</li>
            <li>Simbol λ dibaca <b>lambda</b>, simbol f dibaca <b>ef</b>, dan simbol v dibaca <b>ve</b>.</li>
            <li>Rumus utama gelombang adalah <b>f = 1/T</b> dan <b>v = λ f</b>.</li>
          </ul>

        </section>

        <!-- ===== HALAMAN 5 ===== -->
        <section id="page-latihan" class="subpage" style="display: none;">
          <h3>Latihan 1.1 : Besaran-Besaran Gelombang</h3>
          <p>
            Kerjakan soal berikut menggunakan rumus <b>f = 1/T</b> dan <b>v = λ f</b>.
            Pilih tab <b>Frekuensi dari Periode</b>, <b>Cepat Rambat Gelombang</b>,
            atau <b>Mencari Panjang Gelombang</b>, isi jawaban, lalu klik
            <b>Cek Jawaban</b>.
          </p>

          <!-- ========================
                                  TAB LATIHAN (3 HALAMAN)
                                  ======================== -->
          <div class="latihan-tabs-wrapper">

            <!-- HEADER TAB -->
            <div class="latihan-tabs-header">
              <button type="button" class="latihan-tab-btn latihan-tab-active" data-target="latihan-1">
                Frekuensi dari Periode
              </button>

              <button type="button" class="latihan-tab-btn" data-target="latihan-2">
                Cepat Rambat Gelombang
              </button>

              <button type="button" class="latihan-tab-btn" data-target="latihan-3">
                Mencari Panjang Gelombang
              </button>
            </div>

            <!-- ========================
                                    HALAMAN LATIHAN 1
                                    ======================== -->
            <div id="latihan-1" class="latihan-tab-page latihan-tab-page-active">

              <div class="box-diff" style="margin-top:12px;">
                <p><b>Contoh Soal – Frekuensi dari Periode</b></p>
                <p>
                  Sebuah gelombang pada tali memiliki periode <b>T = 0,25 s</b>.
                  Hitung <b>frekuensi (f)</b> gelombang tersebut.
                </p>

                <p><b>Penyelesaian:</b></p>
                <p>
                  Diketahui: T = 0,25 s<br>
                  Ditanyakan: f = ... ?
                </p>

                <p>
                  Kita gunakan rumus: <b>f = 1/T</b><br>
                  f = 1 / 0,25 = 4 Hz
                </p>

                <p>
                  Jadi, frekuensi gelombang tersebut adalah <b>4 Hz</b>.
                </p>
              </div>

              <div class="box-diff" style="margin-top:12px;">
                <p><b>Latihan 1 – Frekuensi dari Periode</b></p>
                <p>
                  Sebuah gelombang permukaan air memiliki periode <b>T = 0,5 s</b>.
                  Hitung <b>frekuensi (f)</b> gelombang tersebut.
                </p>

                <p><b>Diketahui:</b></p>
                <p>
                  T =
                  <input type="number" id="g-lat1-T" style="width:80px;" step="0.01"> s
                </p>

                <p><b>Ditanyakan:</b></p>
                <p>f = ... ?</p>

                <p><b>Jawaban:</b></p>
                <p>
                  f =
                  <input type="number" id="g-lat1" style="width:80px;" step="0.01"> Hz
                  <button type="button" class="next-btn" id="g-lat1-btn" style="margin-left:8px;">
                    Cek Jawaban
                  </button>
                </p>

                <p id="g-lat1-feedback" style="margin-top:6px;"></p>

              </div>
            </div>

            <!-- ========================
                                    HALAMAN LATIHAN 2
                                    ======================== -->
            <div id="latihan-2" class="latihan-tab-page">

              <div class="box-diff" style="margin-top:12px;">
                <p><b>Contoh Soal – Cepat Rambat Gelombang</b></p>
                <p>
                  Suatu gelombang pada tali memiliki panjang gelombang <b>λ = 0,5 m</b>
                  dan frekuensi <b>f = 10 Hz</b>.
                  Hitung <b>cepat rambat</b> gelombang tersebut.
                </p>

                <p><b>Penyelesaian:</b></p>
                <p>
                  Diketahui: λ = 0,5 m, f = 10 Hz<br>
                  Ditanyakan: v = ... ?
                </p>

                <p>
                  Gunakan rumus: <b>v = λ · f</b><br>
                  v = 0,5 m × 10 Hz = 5 m/s
                </p>

                <p>
                  Jadi, cepat rambat gelombang tersebut adalah <b>5 m/s</b>.
                </p>
              </div>

              <div class="box-diff" style="margin-top:12px;">
                <p><b>Latihan 2 – Cepat Rambat Gelombang</b></p>
                <p>
                  Suatu gelombang pada tali memiliki panjang gelombang <b>λ = 0,8 m</b>
                  dan frekuensi <b>f = 5 Hz</b>.
                  Hitung <b>cepat rambat</b> gelombang tersebut.
                </p>

                <p><b>Diketahui:</b></p>
                <p>
                  λ =
                  <input type="number" id="g-lat2-l" style="width:80px;" step="0.01"> m
                </p>
                <p>
                  f =
                  <input type="number" id="g-lat2-f" style="width:80px;" step="0.01"> Hz
                </p>

                <p><b>Ditanyakan:</b></p>
                <p>v = ... ?</p>

                <p><b>Jawaban:</b></p>
                <p>
                  v =
                  <input type="number" id="g-lat2" style="width:80px;" step="0.01"> m/s
                  <button type="button" class="next-btn" id="g-lat2-btn" style="margin-left:8px;">
                    Cek Jawaban
                  </button>
                </p>

                <p id="g-lat2-feedback" style="margin-top:6px;"></p>

              </div>
            </div>

            <!-- ========================
                                    HALAMAN LATIHAN 3
                                    ======================== -->
            <div id="latihan-3" class="latihan-tab-page">

              <div class="box-diff" style="margin-top:12px;">
                <p><b>Contoh Soal – Mencari Panjang Gelombang</b></p>
                <p>
                  Gelombang bunyi merambat di udara dengan cepat rambat
                  <b>v = 300 m/s</b>.
                  Jika frekuensinya <b>f = 150 Hz</b>,
                  berapa <b>panjang gelombang (λ)</b> bunyi tersebut?
                </p>

                <p><b>Penyelesaian:</b></p>
                <p>
                  Diketahui: v = 300 m/s, f = 150 Hz<br>
                  Ditanyakan: λ = ... ?
                </p>

                <p>
                  Rumus: <b>v = λ f</b> → <b>λ = v / f</b><br>
                  λ = 300 ÷ 150 = 2 m
                </p>

                <p>
                  Jadi, panjang gelombangnya adalah <b>2 m</b>.
                </p>
              </div>

              <div class="box-diff" style="margin-top:12px;">
                <p><b>Latihan 3 – Mencari Panjang Gelombang</b></p>
                <p>
                  Gelombang bunyi merambat di udara dengan cepat rambat
                  <b>v = 340 m/s</b>.
                  Jika frekuensinya <b>f = 170 Hz</b>,
                  berapa <b>panjang gelombang (λ)</b> bunyi tersebut?
                </p>

                <p><b>Diketahui:</b></p>

                <p>v =<input type="number" id="g-lat3-v" style="width:80px;"> m/s</p>
                <p>f =<input type="number" id="g-lat3-f" style="width:80px;"> Hz</p>
                <p><b>Ditanyakan:</b></p>
                <p>λ = ... ?</p>

                <p><b>Jawaban:</b></p>
                <p style="margin-top:6px;">
                  λ =
                  <input type="number" id="g-lat3" style="width:80px;" step="0.01"> m

                  <button type="button" class="next-btn" id="g-lat3-btn" style="margin-left:8px;">
                    Cek Jawaban
                  </button>
                </p>

                <p id="g-lat3-feedback" style="margin-top:6px;"></p>

              </div>
            </div>

          </div>

          <div style="margin-top:20px; text-align:center;">

            <button id="download-pdf-btn" class="next-btn" style="display:none;">
              📄 Download Hasil Jawaban (PDF)
            </button>

            <br>
            <p style="margin-top:10px; font-size:14px; color:#64748b;">
              Setelah mendownload file, klik tombol Kumpulkan PDF untuk mengupload tugas.
            </p>
            <br>

            <button id="kumpulkan-btn" class="next-btn" style="display:none;">
              📤 Kumpulkan PDF
            </button>
            <form action="{{ url('/pengumpulan-gelombang') }}" method="POST" enctype="multipart/form-data">
              @csrf

              <input type="hidden" name="latihan_code" value="L11">

              <input type="file" name="file" accept="application/pdf" required>

              <button type="submit">Upload Jawaban</button>
            </form>

          </div>

        </section>


      </div>

      <!-- ===== NAVIGASI DALAM ===== -->
      <div class="inner-navigation">
        <button id="inner-prev" class="next-btn">Previous</button>

        <button class="next-btn inner-nav-btn" data-target="page-getaran">1</button>
        <button class="next-btn inner-nav-btn" data-target="page-dari-getaran">2</button>
        <button class="next-btn inner-nav-btn" data-target="page-gelombang-air">3</button>
        <button class="next-btn inner-nav-btn" data-target="page-besaran">4</button>
        <button class="next-btn inner-nav-btn" data-target="page-latihan">5</button>

        <button id="inner-next" class="next-btn">Next</button>
      </div>

      <button class="next-btn" onclick="location.href='{{ url('pengantar_gelombang') }}'" style="margin-top:10px;">←
        Materi Sebelumnya</button>
      <button class="next-btn" onclick="location.href='{{ url('jenis_gelombang') }}'" style="margin-top:10px;">Materi
        Selanjutnya →</button>

    </main>
  </div>

@endsection

@section('scripts')

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

  <script>
    /* ==========================================
       SIMPAN JAWABAN + DOWNLOAD PDF
       ========================================== */
    document.addEventListener("DOMContentLoaded", () => {

      const hasil = {
        latihan1: null,
        latihan2: null,
        latihan3: null
      };

      const downloadBtn = document.getElementById("download-pdf-btn");
      const kumpulkanBtn = document.getElementById("kumpulkan-btn");

      const uploadForm = document.getElementById("upload-form");

      kumpulkanBtn?.addEventListener("click", () => {
        uploadForm.style.display = "block";
      });

      function cekSelesai() {
        if (hasil.latihan1 && hasil.latihan2 && hasil.latihan3) {
          downloadBtn.style.display = "inline-block";
          kumpulkanBtn.style.display = "inline-block";
        }
      }

      /* =============================
         TANGKAP HASIL LATIHAN 1
         ============================= */
      document.getElementById("g-lat1-btn")?.addEventListener("click", () => {
        const T = document.getElementById("g-lat1-T").value;
        const f = document.getElementById("g-lat1").value;

        if (T && f) {
          hasil.latihan1 = {
            judul: "Latihan 1 – Frekuensi dari Periode",
            soal: "Sebuah gelombang permukaan air memiliki periode T = 0,5 s. Hitung frekuensi (f) gelombang tersebut.",
            diketahui: "T = 0,5 s",
            ditanyakan: "f = ... ?",
            jawabanSiswa: f + " Hz",
            jawabanBenar: "2 Hz"
          };

          cekSelesai();
        }
      });

      /* =============================
         TANGKAP HASIL LATIHAN 2
         ============================= */
      document.getElementById("g-lat2-btn")?.addEventListener("click", () => {
        const l = document.getElementById("g-lat2-l").value;
        const f = document.getElementById("g-lat2-f").value;
        const v = document.getElementById("g-lat2").value;

        if (l && f && v) {
          hasil.latihan2 = {
            judul: "Latihan 2 – Cepat Rambat Gelombang",
            soal: "Gelombang pada tali memiliki panjang gelombang λ = 0,8 m dan frekuensi f = 5 Hz. Hitung cepat rambat gelombang.",
            diketahui: "λ = 0,8 m, f = 5 Hz",
            ditanyakan: "v = ... ?",
            jawabanSiswa: v + " m/s",
            jawabanBenar: "4 m/s"
          };

          cekSelesai();
        }
      });

      /* =============================
         TANGKAP HASIL LATIHAN 3
         ============================= */
      document.getElementById("g-lat3-btn")?.addEventListener("click", () => {
        const v = document.getElementById("g-lat3-v").value;
        const f = document.getElementById("g-lat3-f").value;
        const lambda = document.getElementById("g-lat3").value;

        if (v && f && lambda) {
          hasil.latihan3 = {
            judul: "Latihan 3 – Panjang Gelombang",
            soal: "Gelombang bunyi merambat di udara dengan cepat rambat v = 340 m/s dan frekuensi f = 170 Hz. Hitung panjang gelombang.",
            diketahui: "v = 340 m/s, f = 170 Hz",
            ditanyakan: "λ = ... ?",
            jawabanSiswa: lambda + " m",
            jawabanBenar: "2 m"
          };

          cekSelesai();
        }
      });

      /* =============================
         GENERATE PDF
         ============================= */
      downloadBtn?.addEventListener("click", () => {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF();

        let y = 15;

        pdf.setFontSize(15);
        pdf.text("HASIL LATIHAN GELOMBANG", 14, y);
        y += 10;

        pdf.setFontSize(11);
        pdf.text("Materi: Getaran dan Gelombang", 14, y);
        y += 10;

        Object.values(hasil).forEach((item, index) => {

          pdf.setFont(undefined, "bold");
          pdf.text(`${index + 1}. ${item.judul}`, 14, y);
          y += 7;

          pdf.setFont(undefined, "normal");
          pdf.text("Soal:", 14, y);
          y += 5;
          pdf.text(item.soal, 18, y, { maxWidth: 170 });
          y += 8;

          pdf.text("Diketahui:", 14, y);
          y += 5;
          pdf.text(item.diketahui, 18, y);
          y += 6;

          pdf.text("Ditanyakan:", 14, y);
          y += 5;
          pdf.text(item.ditanyakan, 18, y);
          y += 6;

          pdf.text("Jawaban Siswa:", 14, y);
          y += 5;
          pdf.text(item.jawabanSiswa, 18, y);
          y += 6;

          pdf.text("Jawaban Benar:", 14, y);
          y += 5;
          pdf.text(item.jawabanBenar, 18, y);
          y += 10;

          if (y > 260) {
            pdf.addPage();
            y = 15;
          }
        });

        pdf.save("hasil_latihan_gelombang.pdf");
      });

    });
  </script>


  <script>
    /* ====================================
       ANIMASI GETARAN: MASSA PADA PEGAS
       ==================================== */
    (function () {
      const cv = document.getElementById('vibrationDemo');
      if (!cv) return;

      const ctx = cv.getContext('2d');

      const W = cv.width;
      const H = cv.height;

      const anchorY = 40;                 // titik gantung pegas
      const massX = W * 0.5;
      const restY = 130;                // posisi setimbang massa
      const A = 35;                 // amplitudo getaran
      const omega = 2 * Math.PI * 0.7;  // frekuensi sudut
      const damping = 0.02;               // redaman kecil

      let t = 0;
      let last = performance.now();

      function drawBackground() {
        ctx.clearRect(0, 0, W, H);

        // background atas
        ctx.fillStyle = '#e2e8f0';
        ctx.fillRect(0, 0, W, 70);

        // balok gantung
        ctx.fillStyle = '#94a3b8';
        ctx.fillRect(massX - 60, anchorY - 10, 120, 10);

        ctx.fillStyle = '#475569';
        ctx.font = '13px "Segoe UI", sans-serif';
        ctx.fillText(
          'Getaran: massa pada pegas bergerak naik–turun di sekitar posisi setimbang.',
          20,
          H - 20
        );
      }

      function drawSpring(y) {
        const turns = 10;
        const topY = anchorY;
        const bottomY = y - 25;
        const springHeight = bottomY - topY;
        const step = springHeight / turns;

        ctx.strokeStyle = '#64748b';
        ctx.lineWidth = 2;
        ctx.beginPath();
        ctx.moveTo(massX, topY);

        for (let i = 1; i <= turns; i++) {
          const xx = (i % 2 === 0) ? massX + 18 : massX - 18;
          const yy = topY + i * step;
          ctx.lineTo(xx, yy);
        }

        ctx.lineTo(massX, bottomY);
        ctx.stroke();
      }

      function drawMass(y) {
        const w = 70;
        const h = 40;

        ctx.fillStyle = '#0f172a';
        ctx.fillRect(massX - w / 2, y - h / 2, w, h);

        ctx.strokeStyle = '#e5e7eb';
        ctx.lineWidth = 2;
        ctx.strokeRect(massX - w / 2, y - h / 2, w, h);
      }

      function loop(now) {
        const dt = Math.min(0.033, (now - last) / 1000);
        last = now;
        t += dt;

        drawBackground();

        const ampNow = A * Math.exp(-damping * t);
        const y = restY + ampNow * Math.sin(omega * t);

        drawSpring(y);
        drawMass(y);

        requestAnimationFrame(loop);
      }

      requestAnimationFrame(loop);
    })();
  </script>

  <script>
    /* =================================================
       ANIMASI GELOMBANG: BATU JATUH + RIAK AIR
       ================================================= */
    (function () {
      const cv = document.getElementById('waveCanvas');
      if (!cv) return;

      const ctx = cv.getContext('2d');

      const W = cv.width;
      const H = cv.height;

      const waterY = H * 0.68;

      // batu
      const gravity = 900; // px/s^2
      const stoneRadius = 10;

      // parameter gelombang
      const cWave = 200;
      const lambda = 80;
      const omega = (2 * Math.PI) * 1.4;
      const k = 2 * Math.PI / lambda;
      const timeDamp = 0.8;
      const frontWidth = 40;
      const baseAmp = 15;

      const waterColor = '#cfe8ff';
      const surfaceLine = '#111827';

      const SURF_SAMPLES = 260;

      const stones = [];
      const sources = [];

      let lastTime = performance.now();

      function spawnStone(x) {
        stones.push({
          x: x,
          y: -stoneRadius - 5,
          vy: 0,
          r: stoneRadius,
          state: 'fall'
        });
      }

      function addSource(x, tSec) {
        sources.push({ x0: x, t0: tSec });
      }

      function drawBackground() {
        const sky = ctx.createLinearGradient(0, 0, 0, H);
        sky.addColorStop(0, '#eef2ff');
        sky.addColorStop(1, '#e2e8f0');

        ctx.fillStyle = sky;
        ctx.fillRect(0, 0, W, H);

        ctx.fillStyle = waterColor;
        ctx.fillRect(0, waterY, W, H - waterY);

        // label AIR berulang
        ctx.fillStyle = "#374151";
        ctx.font = "18px Segoe UI";
        ctx.textAlign = "center";

        const jumlahLabel = 3; // jumlah tulisan air
        const jarak = W / (jumlahLabel + 1);

        for (let i = 1; i <= jumlahLabel; i++) {
          ctx.fillText("air", jarak * i, waterY + 40);
        }

        ctx.textAlign = "left";

        ctx.fillStyle = '#334155';
        ctx.font = '13px "Segoe UI", sans-serif';
        ctx.fillText('Klik di area air untuk menjatuhkan batu.', 20, 26);
        ctx.fillText('Riak merambat menjauhi titik tumbukan.', 20, 44);
      }

      function updateAndDrawStones(dt, tSec) {
        for (let i = 0; i < stones.length; i++) {
          const s = stones[i];

          if (s.state === 'fall') {
            s.vy += gravity * dt;
            s.y += s.vy * dt;

            if (s.y + s.r >= waterY) {
              s.y = waterY - s.r;
              s.state = 'sink';
              addSource(s.x, tSec);

              const snd = document.getElementById('splashSound');
              if (snd) {
                try {
                  snd.currentTime = 0;
                  snd.volume = 0.8;
                  snd.play();
                } catch (e) { }
              }
            }
          } else if (s.state === 'sink') {
            s.y += 80 * dt;
          }
        }

        for (let i = stones.length - 1; i >= 0; i--) {
          if (stones[i].y - stones[i].r > H + 40) {
            stones.splice(i, 1);
          }
        }

        stones.forEach(s => {
          if (s.y + s.r <= waterY + 2) {
            const grad = ctx.createRadialGradient(
              s.x - 4, s.y - 4, 2,
              s.x, s.y, s.r + 3
            );
            grad.addColorStop(0, '#64748b');
            grad.addColorStop(1, '#0f172a');

            ctx.fillStyle = grad;
            ctx.beginPath();
            ctx.arc(s.x, s.y, s.r, 0, Math.PI * 2);
            ctx.fill();
          }
        });
      }

      function cleanupSources(tSec) {
        for (let i = sources.length - 1; i >= 0; i--) {
          if (tSec - sources[i].t0 > 5) {
            sources.splice(i, 1);
          }
        }
      }

      function computeAndDrawSurface(tSec) {
        const dx = W / (SURF_SAMPLES - 1);
        const yValues = new Array(SURF_SAMPLES).fill(waterY);

        for (let i = 0; i < SURF_SAMPLES; i++) {
          const x = i * dx;
          let offset = 0;

          for (let s = 0; s < sources.length; s++) {
            const src = sources[s];
            const dt = tSec - src.t0;
            if (dt <= 0) continue;

            const R = cWave * dt;
            const dist = Math.abs(x - src.x0);
            const diff = dist - R;

            const envelopeFront = Math.exp(
              -(diff * diff) / (2 * frontWidth * frontWidth)
            );
            const envelopeTime = Math.exp(-timeDamp * dt);

            const phase = k * (R - dist) - omega * dt;
            const A = baseAmp * envelopeTime * envelopeFront;

            offset += A * Math.sin(phase);
          }

          yValues[i] = waterY - offset;
        }

        ctx.strokeStyle = surfaceLine;
        ctx.lineWidth = 2.2;
        ctx.beginPath();
        ctx.moveTo(0, yValues[0]);
        for (let i = 1; i < SURF_SAMPLES; i++) {
          ctx.lineTo(i * dx, yValues[i]);
        }
        ctx.stroke();
      }

      function loop(nowMs) {
        const dt = Math.min(0.033, (nowMs - lastTime) / 1000);
        lastTime = nowMs;
        const tSec = nowMs / 1000;

        drawBackground();
        cleanupSources(tSec);
        computeAndDrawSurface(tSec);
        updateAndDrawStones(dt, tSec);

        requestAnimationFrame(loop);
      }

      cv.addEventListener('click', (e) => {
        const rect = cv.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        if (y >= waterY - 10) {
          spawnStone(x);
        }
      });

      requestAnimationFrame(loop);
    })();
  </script>

  <script>
    /* =============================
       SIDEBAR + NAVIGASI HALAMAN
       ============================= */
    document.addEventListener("DOMContentLoaded", () => {


      /* =============================
         NAVIGASI SUB HALAMAN
         ============================= */
      const pages = document.querySelectorAll(".subpage");
      const navBtns = document.querySelectorAll(".inner-nav-btn");
      const prevBtn = document.getElementById("inner-prev");
      const nextBtn = document.getElementById("inner-next");

      const order = [
        "page-getaran",
        "page-dari-getaran",
        "page-gelombang-air",
        "page-besaran",
        "page-latihan"
      ];

      let currentIndex = 0;

      function showPageById(targetId) {
        pages.forEach(p => {
          p.style.display = (p.id === targetId) ? "block" : "none";
        });

        navBtns.forEach(btn => {
          btn.classList.toggle(
            "inner-nav-active",
            btn.dataset.target === targetId
          );
        });

        currentIndex = order.indexOf(targetId);
        if (currentIndex < 0) currentIndex = 0;

        prevBtn.disabled = currentIndex === 0;
        nextBtn.disabled = currentIndex === order.length - 1;
      }



      // klik angka
      navBtns.forEach(btn => {
        btn.addEventListener("click", () => {
          const targetId = btn.getAttribute("data-target");
          showPageById(targetId);
        });
      });

      // prev
      prevBtn?.addEventListener("click", () => {
        if (currentIndex > 0) {
          showPageById(order[currentIndex - 1]);
        }
      });

      // next
      nextBtn?.addEventListener("click", () => {
        if (currentIndex < order.length - 1) {
          showPageById(order[currentIndex + 1]);
        }
      });

      // halaman awal
      showPageById(order[0]);


    });
  </script>


  <script>
    /* =============================
       TAB LATIHAN (1–3)
       ============================= */
    document.addEventListener("DOMContentLoaded", () => {

      const tabBtns = document.querySelectorAll(".latihan-tab-btn");
      const tabPages = document.querySelectorAll(".latihan-tab-page");

      function showLatihanPage(targetId) {
        tabPages.forEach(page => {
          page.classList.toggle(
            "latihan-tab-page-active",
            page.id === targetId
          );
        });

        tabBtns.forEach(btn => {
          btn.classList.toggle(
            "latihan-tab-active",
            btn.getAttribute("data-target") === targetId
          );
        });
      }

      tabBtns.forEach(btn => {
        btn.addEventListener("click", () => {
          showLatihanPage(btn.getAttribute("data-target"));
        });
      });

      // default tab
      showLatihanPage("latihan-1");

      /* =============================
         FUNGSI FEEDBACK
         ============================= */
      function setFeedback(id, benar, pesan) {
        const el = document.getElementById(id);
        if (!el) return;

        el.textContent = pesan;
        el.style.fontWeight = "600";
        el.style.color = benar ? "#059669" : "#b91c1c";
      }

      /* =============================
         LATIHAN 1
         T = 0.5 → f = 2 Hz
         ============================= */
      document.getElementById("g-lat1-btn")?.addEventListener("click", () => {

        const T = parseFloat(document.getElementById("g-lat1-T")?.value);
        const f = parseFloat(document.getElementById("g-lat1")?.value);

        if (isNaN(T) || isNaN(f)) {
          setFeedback("g-lat1-feedback", false,
            "Lengkapi nilai T dan f terlebih dahulu.");
          return;
        }

        if (T !== 0.5) {
          setFeedback("g-lat1-feedback", false,
            "Periksa kembali nilai periode (T).");
          return;
        }

        const kunci = 1 / T;

        Math.abs(f - kunci) < 0.01
          ? setFeedback("g-lat1-feedback", true,
            "Benar! f = 1 / T = 1 / 0,5 = 2 Hz.")
          : setFeedback("g-lat1-feedback", false,
            "Gunakan rumus f = 1 / T.");
      });

      /* =============================
         LATIHAN 2
         λ = 0.8, f = 5 → v = 4
         ============================= */
      document.getElementById("g-lat2-btn")?.addEventListener("click", () => {

        const l = parseFloat(document.getElementById("g-lat2-l")?.value);
        const f = parseFloat(document.getElementById("g-lat2-f")?.value);
        const v = parseFloat(document.getElementById("g-lat2")?.value);

        if (isNaN(l) || isNaN(f) || isNaN(v)) {
          setFeedback("g-lat2-feedback", false,
            "Lengkapi nilai λ, f, dan v terlebih dahulu.");
          return;
        }

        if (l !== 0.8 || f !== 5) {
          setFeedback("g-lat2-feedback", false,
            "Periksa kembali nilai yang diketahui.");
          return;
        }

        const kunci = l * f;

        Math.abs(v - kunci) < 0.01
          ? setFeedback("g-lat2-feedback", true,
            "Tepat! v = λ × f = 0,8 × 5 = 4 m/s.")
          : setFeedback("g-lat2-feedback", false,
            "Gunakan rumus v = λ × f.");
      });

      /* =============================
         LATIHAN 3
         v = 340, f = 170 → λ = 2
         ============================= */
      document.getElementById("g-lat3-btn")?.addEventListener("click", () => {

        const v = parseFloat(document.getElementById("g-lat3-v")?.value);
        const f = parseFloat(document.getElementById("g-lat3-f")?.value);
        const lambda = parseFloat(document.getElementById("g-lat3")?.value);

        if (isNaN(v) || isNaN(f) || isNaN(lambda)) {
          setFeedback("g-lat3-feedback", false,
            "Lengkapi nilai v, f, dan λ terlebih dahulu.");
          return;
        }

        if (v !== 340 || f !== 170) {
          setFeedback("g-lat3-feedback", false,
            "Periksa kembali nilai yang diketahui.");
          return;
        }

        const kunci = v / f;

        Math.abs(lambda - kunci) < 0.01
          ? setFeedback("g-lat3-feedback", true,
            "Benar! λ = v / f = 340 / 170 = 2 m.")
          : setFeedback("g-lat3-feedback", false,
            "Hasil λ belum tepat. Gunakan λ = v / f.");
      });


    });
  </script>


  <script>
    window.addEventListener("beforeunload", function () {
      kirimProgress("definisi_gelombang", 2);
    });
  </script>

@endsection