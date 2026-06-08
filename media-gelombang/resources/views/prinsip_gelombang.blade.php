@extends('layouts.siswa')

@section('title', 'Prinsip-Prinsip Gelombang')

@section('siswa-content')

  <div class="materi-gelombang">


    {{-- ====================
    KONTEN UTAMA
    ==================== --}}
    <main class="content">

      <h1>Prinsip-Prinsip Gelombang</h1>

      <div class="box">

        {{-- PAGE 1 --}}
        <section id="page-superposisi" class="subpage">

          <p>
            Banyak fenomena yang kita nikmati setiap hari—seperti musik, pola cahaya,
            hingga sinyal internet—dapat dijelaskan melalui <b>prinsip dasar gelombang</b>.
          </p>

          <h3>a. Prinsip Superposisi</h3>

          <div class="example-row">

            <!-- KIRI: TEKS -->
            <div class="example-text">

              <p>
                <b>Prinsip superposisi</b> menyatakan bahwa jika dua atau lebih gelombang
                bertemu di suatu titik, maka simpangan total di titik tersebut adalah
                <b>jumlah aljabar</b> dari simpangan masing-masing gelombang.
              </p>

              <p>
                Akibatnya, gelombang dapat:
              </p>

              <ul>
                <li><b>Menguatkan</b> → disebut <b>interferensi konstruktif</b></li>
                <li><b>Melemahkan</b> → disebut <b>interferensi destruktif</b></li>
              </ul>

              <div class="box-diff" style="margin-top:12px;">
                <b>Koheren</b> adalah dua sumber gelombang yang memiliki:
                <ul style="margin-top:6px;">
                  <li>Frekuensi yang sama</li>
                  <li>Beda fase yang tetap terhadap waktu</li>
                </ul>
                <p style="margin-top:6px;">
                  Biasanya gelombang koheren berasal dari satu sumber yang sama.
                </p>
              </div>

            </div>

            <!-- KANAN: GAMBAR -->
            <div class="example-image">
              <img src="{{ asset('images/interferensi_gelombang.png') }}"
                alt="Ilustrasi interferensi konstruktif dan destruktif">
              <p class="caption">
                Interferensi konstruktif (menguatkan) dan destruktif (melemahkan).
              </p>
            </div>

          </div>

        </section>

        {{-- PAGE 2 --}}
        <section id="page-huygens" class="subpage" style="display:none;">
          <h3>b. Prinsip Huygens–Fresnel</h3>

          <div class="hugens-container">
            <div class="image-container">
              <canvas id="huygensCanvas" width="700" height="380" aria-label="Animasi Huygens"></canvas>
              <div class="caption">
                Animasi Prinsip Huygens–Fresnel. Lingkaran biru tipis = <b>gelombang sekunder</b>,
                garis hijau = <b>muka gelombang baru</b>. Klik kanvas untuk <b>Play/Jeda</b>.
              </div>
              <div style="margin-top:10px; display:flex; gap:8px; justify-content:center; flex-wrap:wrap;">
                <button id="huygensModeBtn" class="next-btn">Mode: Muka Gelombang Lurus</button>
                <button id="resetHuygensBtn" class="next-btn">Reset Animasi</button>
              </div>
            </div>

            <div class="text-container">
              <p>
                Menurut <b>Prinsip Huygens</b>, setiap titik pada suatu muka gelombang dapat dianggap sebagai
                <b>sumber gelombang kecil baru</b> (disebut <i>Huygens wavelets</i>). Gelombang kecil ini menyebar ke
                segala arah
                dan setelah beberapa saat membentuk <b>muka gelombang baru</b> yang merupakan <u>selubung</u> semua
                gelombang kecil tadi.
              </p>
              <p>Pada animasi:</p>
              <ul>
                <li>Garis biru di kiri = <b>muka gelombang lama</b>.</li>
                <li>Titik-titik di garis biru memancarkan <b>gelombang kecil berbentuk lingkaran</b>.</li>
                <li>
                  Di daerah tempat lingkaran-lingkaran ini <b>tumpang tindih</b>, terbentuk garis hijau
                  yang menunjukkan <b>muka gelombang baru</b>.
                </li>
              </ul>
              <p>
                Fresnel menambahkan bahwa dengan memperhatikan <b>tumpang tindih (interferensi)</b> dari
                gelombang-gelombang kecil ini, kita bisa menjelaskan:
              </p>
              <div class="box-diff">
                <ul>
                  <li><b>Interferensi</b>: pola penguatan dan pelemahan akibat tumpang tindih gelombang.</li>
                  <li><b>Difraksi</b>: gelombang tampak <u>membelok dan menyebar</u> setelah melewati celah sempit.</li>
                </ul>
              </div>
              <p>Coba perhatikan:</p>
              <ul>
                <li>
                  Mode <b>“Muka Gelombang Lurus”</b>: garis hijau lurus menandai gelombang merambat ke kanan.
                </li>
                <li>
                  Mode <b>“Celah Sempit (Difraksi)”</b>: hanya titik-titik di celah yang memancarkan gelombang sekunder,
                  sehingga muka gelombang di belakang celah menjadi <b>melengkung dan menyebar</b>.
                </li>
              </ul>
            </div>
          </div>
        </section>

        {{-- PAGE 3 --}}
        <section id="page-intensitas" class="subpage" style="display:none;">

          <h3>c. Intensitas Gelombang</h3>

          <div class="intensitas-split">

            <div class="example-row">

              <!-- KOLOM 1 -->
              <div class="example-text">
                <h4>1) Energi & Amplitudo</h4>

                <p>
                  Energi gelombang bergantung pada besar amplitudonya.
                  Semakin besar amplitudo, semakin besar energi yang dibawa.
                </p>

                <p class="rumus-wrapper">
                  <span class="rumus">E ∝ A²</span>
                </p>

                <p><b>Keterangan:</b></p>
                <ul>
                  <li><b>E</b> = Energi</li>
                  <li><b>A</b> = Amplitudo</li>
                  <li><b>∝</b> dibaca "berbanding lurus dengan"</li>
                </ul>

                <p><i>Dibaca:</i>
                  "Energi berbanding lurus dengan amplitudo kuadrat."</p>
              </div>


              <!-- KOLOM 2 -->
              <div class="example-text"
                style="border-left:2px solid #6c6e70; border-right:2px solid #6c6e70; padding:0 20px;">

                <h4>2) Intensitas</h4>

                <p>
                  Intensitas adalah banyaknya energi gelombang
                  yang melewati setiap satuan luas tiap satuan waktu.
                </p>

                <p class="rumus-wrapper">
                  <span class="rumus">I = P / A</span>
                </p>

                <p><b>Keterangan:</b></p>
                <ul>
                  <li><b>I</b> = Intensitas</li>
                  <li><b>P</b> = Daya (energi per detik)</li>
                  <li><b>A</b> = Luas permukaan</li>
                </ul>

                <p><i>Dibaca:</i>
                  "Intensitas sama dengan daya dibagi luas."</p>
              </div>


              <!-- KOLOM 3 -->
              <div class="example-text">
                <h4>3) Hukum 1/r²</h4>

                <p>
                  Jika gelombang menyebar ke segala arah,
                  intensitasnya akan berkurang saat menjauh dari sumber.
                </p>

                <p class="rumus-wrapper">
                  <span class="rumus">I ∝ 1 / r²</span>
                </p>

                <p><b>Keterangan:</b></p>
                <ul>
                  <li><b>r</b> = Jarak dari sumber</li>
                  <li><b>∝</b> = berbanding lurus dengan</li>
                </ul>

                <p><i>Dibaca:</i>
                  "Intensitas berbanding terbalik dengan kuadrat jarak."</p>

                <p>
                  Jika jarak menjadi 2 kali, maka intensitas menjadi 1/4 kali.
                </p>
              </div>

            </div>

          </div>

        </section>

        {{-- PAGE 4 --}}
        <section id="page-latihan" class="subpage" style="display:none;">

          <h3>Latihan 1.3: Prinsip Intensitas Gelombang</h3>

          <p>
            Kerjakan latihan berikut. Pilih tab soal,
            isi jawaban, lalu klik <b>Cek Jawaban</b>.
          </p>

          <!-- ================= TAB HEADER ================= -->
          <div class="latihan-tabs-wrapper">

            <div class="latihan-tabs-header">
              <button class="latihan-tab-btn latihan-tab-active" data-target="latihan-1">
                Energi & Amplitudo
              </button>

              <button class="latihan-tab-btn" data-target="latihan-2">
                Intensitas Gelombang
              </button>

              <button class="latihan-tab-btn" data-target="latihan-3">
                Hukum Kuadrat Terbalik
              </button>
            </div>

            <!-- ================= TAB 1 ================= -->
            <div id="latihan-1" class="latihan-tab-page latihan-tab-page-active">
              <div class="box-diff" style="margin-top:16px;">
                <p><b>Contoh – Energi dan Amplitudo</b></p>
                <p>
                  Diketahui sebuah gelombang memiliki amplitudo <b>A = 3 satuan</b> dan
                  konstanta <b>k = 2</b>. Energi gelombang dinyatakan dengan:
                  <br><b>E = k · A²</b>.
                </p>
                <p><b>Penyelesaian:</b></p>
                <ul>
                  <li>E = k · A² = 2 × 3² = 2 × 9 = <b>18 satuan energi</b>.</li>
                </ul>
                <p>Jadi energi gelombang tersebut adalah <b>18 satuan energi</b>.</p>
              </div>

              <div class="box-diff" style="margin-top:16px;">
                <p><b>Soal 1 – Energi dan Amplitudo (E ∝ A²)</b></p>
                <p>
                  Diketahui suatu gelombang memiliki amplitudo <b>A = 2 satuan</b>.
                  Energi gelombang sebanding dengan kuadrat amplitudo:
                  <br><b>E = k · A²</b>, dengan <b>k = 3</b>.
                </p>
                <p>Hitung nilai <b>E</b>:</p>
                <p><b>Diketahui:</b></p>
                <p>
                  A =
                  <input type="number" id="lat1-A" style="width:80px;"> satuan
                </p>
                <p>
                  k =
                  <input type="number" id="lat1-k" style="width:80px;">
                </p>

                <p><b>Ditanyakan:</b></p>
                <p>E = ... ?</p>

                <p><b>Jawaban:</b></p>
                <p>
                  E =
                  <input type="number" id="lat1-jawaban" style="width:80px;" step="0.01">
                  <button type="button" class="next-btn" id="lat1-btn" style="margin-left:8px;">
                    Cek Jawaban
                  </button>
                </p>

                <p id="lat1-feedback" style="margin-top:6px;"></p>

              </div>
            </div>

            <!-- ================= TAB 2 ================= -->
            <div id="latihan-2" class="latihan-tab-page">
              <div class="box-diff" style="margin-top:16px;">
                <p><b>Contoh – Intensitas Gelombang (I = P / A)</b></p>
                <p>
                  Sebuah sumber suara memancarkan daya <b>P = 200 W</b> yang tersebar merata pada
                  permukaan seluas <b>A = 5 m²</b>.
                </p>
                <p><b>Penyelesaian:</b></p>
                <ul>
                  <li>Gunakan rumus I = P / A</li>
                  <li>I = 200 W / 5 m² = <b>40 W/m²</b></li>
                </ul>
                <p>Jadi intensitas gelombang bunyi tersebut adalah <b>40 W/m²</b>.</p>
              </div>

              <div class="box-diff" style="margin-top:16px;">
                <p><b>Soal 2 – Intensitas Gelombang (I = P / A)</b></p>
                <p>
                  Sebuah sumber bunyi memancarkan daya <b>P = 120 W</b>.
                  Daya ini tersebar merata pada permukaan seluas <b>A = 6 m²</b>.
                </p>
                <p>Hitung intensitas gelombang bunyi tersebut:</p>
                <p><b>Diketahui:</b></p>
                <p>
                  P =
                  <input type="number" id="lat2-P" style="width:80px;"> W
                </p>
                <p>
                  A =
                  <input type="number" id="lat2-A" style="width:80px;"> m²
                </p>

                <p><b>Ditanyakan:</b></p>
                <p>I = ... ?</p>

                <p><b>Jawaban:</b></p>
                <p>
                  I =
                  <input type="number" id="lat2-jawaban" style="width:80px;" step="0.01"> W/m²
                  <button type="button" class="next-btn" id="lat2-btn" style="margin-left:8px;">
                    Cek Jawaban
                  </button>
                </p>

                <p id="lat2-feedback" style="margin-top:6px;"></p>

              </div>
            </div>

            <!-- ================= TAB 3 ================= -->
            <div id="latihan-3" class="latihan-tab-page">
              <div class="box-diff" style="margin-top:16px;">
                <p><b>Contoh – Hukum Kuadrat Terbalik (I ∝ 1 / r²)</b></p>
                <p>
                  Pada jarak <b>r₁ = 1 m</b> dari sebuah sumber titik, intensitas bunyi
                  tercatat sebesar <b>I₁ = 100 W/m²</b>. Berapa intensitas pada jarak
                  <b>r₂ = 2 m</b>?
                </p>
                <p><b>Penyelesaian:</b></p>
                <ul>
                  <li>Gunakan rumus: I₂ = I₁ · (r₁² / r₂²)</li>
                  <li>I₂ = 100 · (1² / 2²) = 100 · (1 / 4) = <b>25 W/m²</b></li>
                </ul>
                <p>Jadi intensitas pada jarak 2 m adalah <b>25 W/m²</b>.</p>
              </div>

              <div class="box-diff" style="margin-top:16px;">
                <p><b>Soal 3 – Hukum Kuadrat Terbalik (I ∝ 1 / r²)</b></p>
                <p>
                  Pada jarak <b>r₁ = 2 m</b> dari sebuah sumber titik, intensitas gelombang tercatat
                  sebesar <b>I₁ = 36 W/m²</b>. Berapa intensitas pada jarak <b>r₂ = 4 m</b>
                  dari sumber yang sama?
                </p>
                <p>
                  Gunakan hubungan: <b>I ∝ 1 / r²</b>, atau
                  <br><b>I₂ = I₁ · (r₁² / r₂²)</b>.
                </p>
                <p><b>Diketahui:</b></p>
                <p>
                  r₁ =
                  <input type="number" id="lat3-r1" style="width:80px;"> m
                </p>
                <p>
                  I₁ =
                  <input type="number" id="lat3-I1" style="width:80px;"> W/m²
                </p>
                <p>
                  r₂ =
                  <input type="number" id="lat3-r2" style="width:80px;"> m
                </p>

                <p><b>Ditanyakan:</b></p>
                <p>I₂ = ... ?</p>

                <p><b>Jawaban:</b></p>
                <p>
                  I₂ =
                  <input type="number" id="lat3-jawaban" style="width:80px;" step="0.01"> W/m²
                  <button type="button" class="next-btn" id="lat3-btn" style="margin-left:8px;">
                    Cek Jawaban
                  </button>
                </p>

                <p id="lat3-feedback" style="margin-top:6px;"></p>

              </div>
            </div>

          </div>
          <div style="margin-top:24px; text-align:center;">
            <button id="download-pdf-btn" class="next-btn" style="display:none;">
              📄 Download Hasil Latihan (PDF)
            </button>
          </div>

          <div style="margin-top:20px; text-align:center;">
            <form action="{{ url('/pengumpulan-gelombang') }}" method="POST" enctype="multipart/form-data">
              @csrf

              <input type="hidden" name="latihan_code" value="L12">

              <input type="file" name="file" accept="application/pdf" required>

              <button type="submit" class="next-btn">
                Upload Jawaban (PDF)
              </button>

            </form>
          </div>
        </section>


      </div>

      {{-- NAVIGASI DALAM --}}
      <div class="inner-navigation">
        <button id="inner-prev" class="next-btn">Previous</button>

        <button class="next-btn inner-nav-btn" data-target="page-superposisi">1</button>
        <button class="next-btn inner-nav-btn" data-target="page-huygens">2</button>
        <button class="next-btn inner-nav-btn" data-target="page-intensitas">3</button>
        <button class="next-btn inner-nav-btn" data-target="page-latihan">4</button>

        <button id="inner-next" class="next-btn">Next</button>
      </div>

      <button class="next-btn" onclick="location.href='{{ url('beda_fase_gelombang') }}'">
        ← Materi Sebelumnya
      </button>

      <button class="next-btn" onclick="location.href='{{ url('kuis_gelombang') }}'">
        Materi Selanjutnya →
      </button>

    </main>
  </div>

@endsection

@section('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

  <script>
    /* =================================================
       PDF HASIL LATIHAN – PRINSIP GELOMBANG
       ================================================= */
    document.addEventListener("DOMContentLoaded", () => {

      const hasil = {
        soal1: null,
        soal2: null,
        soal3: null
      };

      const downloadBtn = document.getElementById("download-pdf-btn");

      function cekSelesai() {
        if (hasil.soal1 && hasil.soal2 && hasil.soal3) {
          downloadBtn.style.display = "inline-block";
        }
      }

      /* ================= SOAL 1 ================= */
      document.getElementById("lat1-btn")?.addEventListener("click", () => {

        const jawaban = document.getElementById("lat1-jawaban").value;
        if (!jawaban) return;

        hasil.soal1 = {
          judul: "Soal 1 – Energi dan Amplitudo",
          soal:
            "Suatu gelombang memiliki amplitudo A = 2 satuan. Energi gelombang sebanding dengan kuadrat amplitudo (E = k · A²) dengan k = 3.",
          diketahui: "A = 2 satuan, k = 3",
          ditanyakan: "E = ... ?",
          jawabanSiswa: jawaban + " satuan energi",
          jawabanBenar: "12 satuan energi"
        };

        cekSelesai();
      });

      /* ================= SOAL 2 ================= */
      document.getElementById("lat2-btn")?.addEventListener("click", () => {

        const jawaban = document.getElementById("lat2-jawaban").value;
        if (!jawaban) return;

        hasil.soal2 = {
          judul: "Soal 2 – Intensitas Gelombang",
          soal:
            "Sumber bunyi memancarkan daya P = 120 W yang tersebar merata pada permukaan seluas A = 6 m².",
          diketahui: "P = 120 W, A = 6 m²",
          ditanyakan: "I = ... ?",
          jawabanSiswa: jawaban + " W/m²",
          jawabanBenar: "20 W/m²"
        };

        cekSelesai();
      });

      /* ================= SOAL 3 ================= */
      document.getElementById("lat3-btn")?.addEventListener("click", () => {

        const jawaban = document.getElementById("lat3-jawaban").value;
        if (!jawaban) return;

        hasil.soal3 = {
          judul: "Soal 3 – Hukum Kuadrat Terbalik",
          soal:
            "Pada jarak r₁ = 2 m dari sumber titik, intensitas tercatat I₁ = 36 W/m². Tentukan intensitas pada jarak r₂ = 4 m.",
          diketahui: "r₁ = 2 m, I₁ = 36 W/m², r₂ = 4 m",
          ditanyakan: "I₂ = ... ?",
          jawabanSiswa: jawaban + " W/m²",
          jawabanBenar: "9 W/m²"
        };

        cekSelesai();
      });

      /* ================= GENERATE PDF ================= */
      downloadBtn?.addEventListener("click", () => {

        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF();

        let y = 15;

        pdf.setFontSize(15);
        pdf.text("HASIL LATIHAN – PRINSIP GELOMBANG", 14, y);
        y += 8;

        pdf.setFontSize(11);
        pdf.text("Materi: Prinsip-Prinsip Gelombang", 14, y);
        y += 10;

        Object.values(hasil).forEach((item, i) => {

          pdf.setFont(undefined, "bold");
          pdf.text(`${i + 1}. ${item.judul}`, 14, y);
          y += 7;

          pdf.setFont(undefined, "normal");
          pdf.text("Soal:", 14, y); y += 5;
          pdf.text(item.soal, 18, y, { maxWidth: 170 });
          y += 8;

          pdf.text("Diketahui:", 14, y); y += 5;
          pdf.text(item.diketahui, 18, y);
          y += 6;

          pdf.text("Ditanyakan:", 14, y); y += 5;
          pdf.text(item.ditanyakan, 18, y);
          y += 6;

          pdf.text("Jawaban Siswa:", 14, y); y += 5;
          pdf.text(item.jawabanSiswa, 18, y);
          y += 6;

          pdf.text("Jawaban Benar:", 14, y); y += 5;
          pdf.text(item.jawabanBenar, 18, y);
          y += 10;

          if (y > 260) {
            pdf.addPage();
            y = 15;
          }
        });

        pdf.save("hasil_latihan_prinsip_gelombang.pdf");
      });

    });
  </script>

  <script>
    document.addEventListener("DOMContentLoaded", () => {

      const pages = document.querySelectorAll(".subpage");
      const navBtns = document.querySelectorAll(".inner-nav-btn");
      const prevBtn = document.getElementById("inner-prev");
      const nextBtn = document.getElementById("inner-next");

      const order = [
        "page-superposisi",
        "page-huygens",
        "page-intensitas",
        "page-latihan"
      ];

      let currentIndex = 0;

      function showPageById(id) {
        pages.forEach(p => {
          p.style.display = (p.id === id) ? "block" : "none";
        });

        navBtns.forEach(btn => {
          btn.classList.toggle(
            "inner-nav-active",
            btn.dataset.target === id
          );
        });

        currentIndex = order.indexOf(id);
        prevBtn.disabled = currentIndex === 0;
        nextBtn.disabled = currentIndex === order.length - 1;

        // 🔥 START HUYGENS SAAT HALAMAN 2 AKTIF
        if (id === "page-huygens") {
          startHuygens();
        }
      }


      navBtns.forEach(btn => {
        btn.addEventListener("click", () => {
          showPageById(btn.dataset.target);
        });
      });

      prevBtn.addEventListener("click", () => {
        if (currentIndex > 0) showPageById(order[currentIndex - 1]);
      });

      nextBtn.addEventListener("click", () => {
        if (currentIndex < order.length - 1) showPageById(order[currentIndex + 1]);
      });

      showPageById(order[0]);

    });
  </script>

  <script>
    /* =================================================
       HUYGENS–FRESNEL ANIMATION (CLEAN & SAFE)
       ================================================= */

    let huygensStarted = false;

    function startHuygens() {

      if (huygensStarted) return;
      huygensStarted = true;

      const canvas = document.getElementById("huygensCanvas");
      if (!canvas) return;

      const ctx = canvas.getContext("2d");

      const W = canvas.width;
      const H = canvas.height;

      const sourceX = 120;
      const padding = 30;
      const speed = 70;

      let t = 0;
      let running = true;
      let mode = "plane";
      let last = performance.now();

      function buildSources() {
        const src = [];
        if (mode === "plane") {
          for (let y = padding; y <= H - padding; y += 18) {
            src.push({ x: sourceX, y });
          }
        } else {
          const mid = H / 2;
          for (let y = mid - 45; y <= mid + 45; y += 18) {
            src.push({ x: sourceX, y });
          }
        }
        return src;
      }

      let sources = buildSources();

      function drawBackground() {
        const g = ctx.createLinearGradient(0, 0, 0, H);
        g.addColorStop(0, "#eef2ff");
        g.addColorStop(1, "#e2e8f0");
        ctx.fillStyle = g;
        ctx.fillRect(0, 0, W, H);
      }

      function drawSourceLine() {
        ctx.strokeStyle = "#2563eb";
        ctx.lineWidth = 3;
        ctx.beginPath();
        ctx.moveTo(sourceX, padding);
        ctx.lineTo(sourceX, H - padding);
        ctx.stroke();
      }

      function drawWavelets(radius) {
        ctx.globalAlpha = 0.25;
        ctx.strokeStyle = "#60a5fa";
        ctx.lineWidth = 1.4;

        sources.forEach(s => {
          ctx.beginPath();
          ctx.arc(s.x, s.y, radius, 0, Math.PI * 2);
          ctx.stroke();
        });

        ctx.globalAlpha = 1;
      }

      function drawEnvelope(radius) {
        ctx.strokeStyle = "#10b981";
        ctx.lineWidth = 3;

        if (mode === "plane") {
          const x = sourceX + radius;
          ctx.beginPath();
          ctx.moveTo(x, padding);
          ctx.lineTo(x, H - padding);
          ctx.stroke();
        } else {
          ctx.beginPath();
          ctx.arc(sourceX, H / 2, radius, -1, 1);
          ctx.stroke();
        }
      }

      function render() {
        drawBackground();
        drawSourceLine();

        const maxR = Math.max(W, H);
        let radius = (t * speed) % maxR;

        // JAGA SUPAYA TIDAK NEGATIF
        if (radius < 0) radius = 0;

        drawWavelets(radius);
        drawEnvelope(radius);
      }

      function loop(now) {
        const dt = (now - last) / 1000;
        last = now;

        if (running && dt > 0) t += dt;
        render();

        requestAnimationFrame(loop);
      }

      // === INTERAKSI ===
      canvas.addEventListener("click", () => {
        running = !running;
      });

      document.getElementById("huygensModeBtn")?.addEventListener("click", () => {
        mode = (mode === "plane") ? "slit" : "plane";
        sources = buildSources();
        t = 0;

        document.getElementById("huygensModeBtn").textContent =
          "Mode: " + (mode === "plane"
            ? "Muka Gelombang Lurus"
            : "Celah Sempit (Difraksi)");
      });

      document.getElementById("resetHuygensBtn")?.addEventListener("click", () => {
        t = 0;
        running = true;
      });

      requestAnimationFrame(loop);
    }

    /* =================================================
       HUBUNGKAN DENGAN NAVIGASI HALAMAN
       ================================================= */
  </script>

  <script>
    /* =================================================
       LATIHAN PAGE SCRIPT (ISOLATED & CLEAN)
       ================================================= */

    document.addEventListener("DOMContentLoaded", () => {

      /* ================= TAB SWITCH ================= */
      const tabBtns = document.querySelectorAll(".latihan-tab-btn");
      const tabPages = document.querySelectorAll(".latihan-tab-page");

      function showTab(targetId) {
        tabPages.forEach(p =>
          p.classList.toggle(
            "latihan-tab-page-active",
            p.id === targetId
          )
        );

        tabBtns.forEach(b =>
          b.classList.toggle(
            "latihan-tab-active",
            b.dataset.target === targetId
          )
        );
      }

      tabBtns.forEach(btn => {
        btn.addEventListener("click", () => {
          showTab(btn.dataset.target);
        });
      });

      /* ================= FEEDBACK HELPER ================= */
      function setFeedback(id, benar, pesan) {
        const el = document.getElementById(id);
        if (!el) return;

        el.textContent = pesan;
        el.style.fontWeight = "600";
        el.style.color = benar ? "#059669" : "#b91c1c";
      }

      /* ================= SOAL 1 ================= */
      document.getElementById("lat1-btn")?.addEventListener("click", () => {
        const val = parseFloat(
          document.getElementById("lat1-jawaban").value
        );
        const kunci = 12;

        if (isNaN(val)) {
          setFeedback("lat1-feedback", false, "Isi jawaban terlebih dahulu.");
          return;
        }

        Math.abs(val - kunci) < 0.01
          ? setFeedback("lat1-feedback", true,
            "Benar! E = 3 × 2² = 12.")
          : setFeedback("lat1-feedback", false,
            "Belum tepat. Gunakan E = k · A².");
      });

      /* ================= SOAL 2 ================= */
      document.getElementById("lat2-btn")?.addEventListener("click", () => {
        const val = parseFloat(
          document.getElementById("lat2-jawaban").value
        );
        const kunci = 20;

        if (isNaN(val)) {
          setFeedback("lat2-feedback", false, "Isi jawaban terlebih dahulu.");
          return;
        }

        Math.abs(val - kunci) < 0.01
          ? setFeedback("lat2-feedback", true,
            "Tepat! I = 120 / 6 = 20 W/m².")
          : setFeedback("lat2-feedback", false,
            "Gunakan rumus I = P / A.");
      });

      /* ================= SOAL 3 ================= */
      document.getElementById("lat3-btn")?.addEventListener("click", () => {
        const val = parseFloat(
          document.getElementById("lat3-jawaban").value
        );
        const kunci = 9;

        if (isNaN(val)) {
          setFeedback("lat3-feedback", false, "Isi jawaban terlebih dahulu.");
          return;
        }

        Math.abs(val - kunci) < 0.01
          ? setFeedback("lat3-feedback", true,
            "Benar! Intensitas berkurang sesuai 1/r².")
          : setFeedback("lat3-feedback", false,
            "Coba gunakan perbandingan kuadrat jarak.");
      });

    });
  </script>

  <script>
    window.addEventListener("beforeunload", function () {
      kirimProgress("prinsip_gelombang", 5);
    });
  </script>

@endsection