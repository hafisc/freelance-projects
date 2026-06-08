@extends('layouts.siswa')

@section('title', 'Konsep Dasar & Perambatan Bunyi')

@section('siswa-content')

  <div class="materi-gelombang">


    <main class="content">
      <h2>Konsep Dasar & Perambatan Bunyi</h2>

      <div class="box">

        <section id="page-konsep" class="subpage">
          <h3>Konsep Dasar Bunyi</h3>

          <p>
            <b>Bunyi</b> adalah salah satu bentuk <b>gelombang mekanik</b>, yaitu gelombang yang
            <b>memerlukan medium</b> (zat perantara) untuk merambat. Bunyi berasal dari
            <b>benda yang bergetar</b>. Getaran tersebut mengganggu medium di sekitarnya sehingga
            gangguan itu merambat dan dapat didengar oleh telinga.
          </p>

          <div class="box-diff">
            <b>Catatan penting:</b> Bunyi <b>tidak dapat merambat di ruang hampa</b> karena tidak ada medium
            yang dapat bergetar dan meneruskan gangguan.
          </div>

          <div class="example-row">

            <div class="example-text">
              <p><b>Contoh sederhana:</b></p>
              <ul>
                <li>Suara manusia terdengar karena pita suara bergetar dan menggetarkan udara.</li>
                <li>Suara gitar terdengar karena senar bergetar dan diteruskan ke udara melalui badan gitar.</li>
              </ul>
            </div>

            <div class="example-image">
              <img src="{{ asset('images/dasar_bunyi.png') }}" alt="Pita suara manusia bergetar"
                style="max-width:280px; width:100%; height:auto;">
              <p class="image-caption">
                Getaran pita suara menyebabkan udara bergetar dan menghasilkan bunyi.
              </p>
            </div>

          </div>
          <h3>Bunyi sebagai Gelombang Longitudinal</h3>

          <p>
            Bunyi pada umumnya merambat sebagai <b>gelombang longitudinal</b>.
            Pada gelombang longitudinal, arah getar partikel medium <b>sejajar</b> dengan arah rambat gelombang.
          </p>

          <p>
            Saat bunyi merambat di udara, partikel udara mengalami:
          </p>
          <ul>
            <li><b>Rapatan</b> (kompresi): daerah dengan partikel lebih rapat.</li>
            <li><b>Regangan</b> (renggangan): daerah dengan partikel lebih renggang.</li>
          </ul>

          <div class="note-box">
            <b>Intinya:</b> Yang berpindah adalah <b>energi bunyi</b>, bukan partikel mediumnya.
            Partikel medium hanya <b>berosilasi</b> di sekitar titik keseimbangannya.
          </div>

          <p style="margin-top:10px;">
            (Opsional untuk Anda tambahkan nanti: gambar/skema rapatan-regangan atau grafik tekanan vs posisi).
          </p>

        </section>



        <section id="page-medium" class="subpage" style="display:none;">
          <h3>Perambatan Bunyi dalam Medium</h3>

          <p>
            Bunyi dapat merambat melalui <b>zat padat</b>, <b>zat cair</b>, dan <b>gas</b>.
            Perbedaan medium menyebabkan <b>perbedaan kecepatan rambat bunyi</b>,
            meskipun sumber bunyinya sama.
          </p>

          <div class="note-box">
            Pada tabel berikut, sumber bunyi dianggap sama.
            Perbedaan yang terlihat hanya disebabkan oleh <b>jenis medium</b>.
          </div>

          <div style="overflow-x:auto; margin-top:12px;">
            <table style="
                width:100%;
                border-collapse:collapse;
                min-width:720px;
                font-size:0.95rem;
              ">
              <thead>
                <tr style="background:#0f766e; color:#ffffff;">
                  <th style="padding:10px; border:1px solid #0f766e;">Medium</th>
                  <th style="padding:10px; border:1px solid #0f766e;">Deskripsi Perambatan</th>
                  <th style="padding:10px; border:1px solid #0f766e;">Visual</th>
                </tr>
              </thead>

              <tbody>
                <!-- ===== ZAT PADAT ===== -->
                <tr>
                  <td style="padding:10px; border:1px solid #cbd5e1; font-weight:bold;">
                    Zat Padat
                  </td>
                  <td style="padding:10px; border:1px solid #cbd5e1;">
                    Partikel tersusun <b>sangat rapat</b> dan terikat kuat →
                    getaran <b>sangat cepat</b> diteruskan →
                    bunyi merambat <b>paling cepat</b>.
                  </td>
                  <td style="padding:10px; border:1px solid #cbd5e1; text-align:center;">
                    <!-- GANTI SRC DENGAN VIDEO / GIF CANVA -->
                    <img src="{{ asset('media/padat.gif') }}" controls muted loop
                      style="max-width:220px; border-radius:6px;">
                    </img>
                    <!-- atau <img src="padat.gif" style="max-width:220px;"> -->
                  </td>
                </tr>

                <!-- ===== ZAT CAIR ===== -->
                <tr style="background:#f8fafc;">
                  <td style="padding:10px; border:1px solid #cbd5e1; font-weight:bold;">
                    Zat Cair
                  </td>
                  <td style="padding:10px; border:1px solid #cbd5e1;">
                    Partikel <b>cukup rapat</b> namun tidak sekaku zat padat →
                    getaran diteruskan dengan <b>kecepatan sedang</b> →
                    lebih cepat daripada gas.
                  </td>
                  <td style="padding:10px; border:1px solid #cbd5e1; text-align:center;">
                    <img src="{{ asset('media/cair.gif') }}" controls muted loop
                      style="max-width:220px; border-radius:6px;">
                    </img>
                  </td>
                </tr>

                <!-- ===== GAS ===== -->
                <tr>
                  <td style="padding:10px; border:1px solid #cbd5e1; font-weight:bold;">
                    Gas
                  </td>
                  <td style="padding:10px; border:1px solid #cbd5e1;">
                    Partikel <b>berjauhan</b> dan jarang bertumbukan →
                    getaran <b>lambat</b> diteruskan →
                    bunyi merambat <b>paling lambat</b>.
                  </td>
                  <td style="padding:10px; border:1px solid #cbd5e1; text-align:center;">
                    <img src="{{ asset('media/gas.gif') }}" controls muted loop
                      style="max-width:220px; border-radius:6px;">
                    </img>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="note-box" style="margin-top:12px;">
            <b>Catatan:</b> Kecepatan pada video disederhanakan untuk menunjukkan
            perbedaan pengaruh medium, bukan nilai eksperimen sebenarnya.
          </div>
        </section>

        <!-- ====================
                                                     HALAMAN 4 – LATIHAN PEMAHAMAN KONSEP BUNYI
                                                     ==================== -->
        <section id="page-rumus" class="subpage" style="display:none;">

          <h3>Cepat Rambat Bunyi</h3>

          <p>
            <b>Cepat rambat bunyi</b> adalah kecepatan merambatnya gelombang bunyi
            melalui suatu medium (zat perantara).
            Yang merambat bukan partikel zatnya, melainkan <b>energi getaran</b>.
          </p>

          <div class="note-box">
            Cepat rambat bunyi <b>tidak dipengaruhi keras–lembut bunyi</b>,
            tetapi ditentukan oleh <b>sifat medium</b>.
          </div>

          <h4>Faktor yang Mempengaruhi</h4>
          <ul>
            <li><b>Elastisitas</b> besar → cepat rambat ↑</li>
            <li><b>Massa jenis</b> (ρ) besar → cepat rambat ↓</li>
          </ul>

          <!-- ================= TAB ================= -->
          <div class="latihan-tabs-wrapper">

            <!-- HEADER -->
            <div class="latihan-tabs-header">
              <button class="latihan-tab-btn latihan-tab-active" data-target="cepat-1">
                Zat Padat
              </button>
              <button class="latihan-tab-btn" data-target="cepat-2">
                Zat Cair
              </button>
              <button class="latihan-tab-btn" data-target="cepat-3">
                Gas
              </button>
            </div>

            <!-- ===================== -->
            <!-- TAB 1 : PADAT -->
            <!-- ===================== -->
            <div id="cepat-1" class="latihan-tab-page latihan-tab-page-active">

              <div class="box-diff">
                <h4>a) Bunyi pada Zat Padat</h4>

                <p>
                  Pada zat padat, partikel-partikelnya sangat rapat dan terikat kuat,
                  sehingga getaran dapat diteruskan sangat cepat.
                </p>

                <p><b>Rumus:</b></p>
                <div style="text-align:center; margin:8px 0;">
                  $$ v = \sqrt{\frac{E}{\rho}} $$
                </div>

                <p><b>Keterangan:</b></p>
                <ul>
                  <li>v = cepat rambat bunyi (m/s)</li>
                  <li>E = modulus elastisitas (Pa)</li>
                  <li>ρ = massa jenis (kg/m³)</li>
                </ul>

                <p>
                  Semakin elastis dan semakin ringan bahannya,
                  maka bunyi merambat semakin cepat.
                </p>
              </div>

            </div>

            <!-- ===================== -->
            <!-- TAB 2 : CAIR -->
            <!-- ===================== -->
            <div id="cepat-2" class="latihan-tab-page">

              <div class="box-diff">
                <h4>b) Bunyi pada Zat Cair</h4>

                <p>
                  Partikel zat cair lebih renggang dibanding padat,
                  sehingga bunyi merambat lebih lambat.
                </p>

                <p><b>Rumus:</b></p>
                <div style="text-align:center; margin:8px 0;">
                  $$ v = \sqrt{\frac{B}{\rho}} $$
                </div>

                <p><b>Keterangan:</b></p>
                <ul>
                  <li>v = cepat rambat bunyi (m/s)</li>
                  <li>B = modulus bulk (Pa)</li>
                  <li>ρ = massa jenis (kg/m³)</li>
                </ul>

                <p>
                  Semakin sulit zat cair dimampatkan,
                  maka bunyi merambat semakin cepat.
                </p>
              </div>

            </div>

            <!-- ===================== -->
            <!-- TAB 3 : GAS -->
            <!-- ===================== -->
            <div id="cepat-3" class="latihan-tab-page">

              <div class="box-diff">
                <h4>c) Bunyi pada Gas</h4>

                <p>
                  Pada gas, jarak antarpartikel sangat jauh,
                  sehingga bunyi merambat paling lambat.
                  Cepat rambat dipengaruhi suhu.
                </p>

                <p><b>Rumus (udara):</b></p>
                <div style="text-align:center; margin:8px 0;">
                  $$ v \approx 331 + 0{,}6T $$
                </div>

                <p><b>Keterangan:</b></p>
                <ul>
                  <li>v = cepat rambat bunyi (m/s)</li>
                  <li>T = suhu (°C)</li>
                </ul>

                <p>
                  Jika suhu naik, energi partikel bertambah,
                  sehingga bunyi merambat lebih cepat.
                </p>
              </div>

            </div>

          </div>
          <br>
          <div class="box-diff">
            <b>Ringkasan:</b><br>
            Padat → Cair → Gas<br>
            Suhu naik → cepat rambat naik
          </div>

          <hr style="margin:30px 0;">

        </section>


        <!-- ====================
                                             HALAMAN 4 – CEPAT RAMBAT BUNYI
                                            ==================== -->
        <section id="page-latihan" class="subpage" style="display:none;">
          <div id="area-pdf">
            <h3>Latihan Cepat Rambat Bunyi</h3>

            <p>
              Kerjakan latihan berikut setelah memahami rumus cepat rambat bunyi.
              Tuliskan besaran yang diketahui dan yang ditanyakan sebelum menghitung.
            </p>

            <div class="latihan-tabs-wrapper">

              <!-- ================= TAB HEADER ================= -->
              <div class="latihan-tabs-header">
                <button class="latihan-tab-btn latihan-tab-active" data-target="latihan-1">
                  Zat Padat
                </button>
                <button class="latihan-tab-btn" data-target="latihan-2">
                  Zat Cair
                </button>
                <button class="latihan-tab-btn" data-target="latihan-3">
                  Gas
                </button>
              </div>

              <!-- =================================================
                                                            TAB 1 — ZAT PADAT
                                                            ================================================= -->
              <div id="latihan-1" class="latihan-tab-page latihan-tab-page-active">

                <!-- CONTOH -->
                <div class="box-diff">
                  <p><b>Contoh Soal – Cepat Rambat Bunyi pada Zat Padat</b></p>

                  <!-- SOAL CONTOH -->
                  <p>
                    Sebuah batang logam memiliki modulus elastisitas
                    <b>E = 2 × 10¹¹ N/m²</b> dan massa jenis
                    <b>ρ = 8.000 kg/m³</b>.
                    Tentukan cepat rambat bunyi pada batang logam tersebut.
                  </p>

                  <p><b>Diketahui:</b></p>
                  <ul>
                    <li>E = 2 × 10¹¹ N/m²</li>
                    <li>ρ = 8.000 kg/m³</li>
                  </ul>

                  <p><b>Ditanyakan:</b></p>
                  <p>v = ... ?</p>

                  <p><b>Penyelesaian:</b></p>
                  <p>
                    Rumus cepat rambat bunyi pada zat padat:
                    <br><b>v = √(E / ρ)</b>
                  </p>
                  <p>
                    v = √(2 × 10¹¹ / 8000)
                    <br>v ≈ <b>5000 m/s</b>
                  </p>
                </div>


                <!-- LATIHAN -->
                <div class="box-diff" style="margin-top:16px;">
                  <p><b>Soal 1 – Zat Padat</b></p>

                  <!-- BLOK SOAL -->
                  <p>
                    Sebuah bahan padat memiliki modulus elastisitas
                    <b>E = 9 × 10¹⁰ N/m²</b> dan massa jenis
                    <b>ρ = 9000 kg/m³</b>.
                    Tentukan cepat rambat bunyi pada bahan tersebut.
                  </p>

                  <p><b>Diketahui:</b></p>
                  <p>
                    E =
                    <input type="text" id="padat-E" style="width:120px;">
                    N/m²
                  </p>
                  <p>
                    ρ =
                    <input type="text" id="padat-rho" style="width:120px;">
                    kg/m³
                  </p>

                  <p><b>Ditanyakan:</b></p>
                  <p>v = ... ?</p>

                  <p><b>Jawaban:</b></p>
                  <p>
                    v =
                    <input type="number" id="padat-jawaban" style="width:100px;"> m/s
                    <button class="next-btn" id="padat-btn">Cek Jawaban</button>
                  </p>

                  <p id="padat-feedback"></p>
                </div>

              </div>

              <!-- =================================================
                                                            TAB 2 — ZAT CAIR
                                                            ================================================= -->
              <div id="latihan-2" class="latihan-tab-page">

                <!-- CONTOH -->
                <div class="box-diff">
                  <p><b>Contoh Soal – Cepat Rambat Bunyi pada Zat Cair</b></p>
                  <p>
                    Sebuah zat cair memiliki modulus bulk
                    <b>B = 2,2 × 10⁹ N/m²</b> dan massa jenis
                    <b>ρ = 1000 kg/m³</b>.
                    Hitung cepat rambat bunyi pada zat cair tersebut.
                  </p>

                  <p><b>Diketahui:</b></p>
                  <ul>
                    <li>B = 2,2 × 10⁹ N/m²</li>
                    <li>ρ = 1000 kg/m³</li>
                  </ul>

                  <p><b>Ditanyakan:</b></p>
                  <p>v = ... ?</p>

                  <p><b>Penyelesaian:</b></p>
                  <p>
                    v = √(B / ρ)<br>
                    v ≈ <b>1480 m/s</b>
                  </p>
                </div>

                <!-- LATIHAN -->
                <div class="box-diff" style="margin-top:16px;">
                  <p><b>Soal 2 – Zat Cair</b></p>

                  <!-- KALIMAT SOAL -->
                  <p>
                    Sebuah zat cair memiliki modulus bulk
                    <b>B = 1,6 × 10⁹ N/m²</b>
                    dan massa jenis
                    <b>ρ = 1000 kg/m³</b>.
                    Tentukan cepat rambat bunyi pada zat cair tersebut.
                  </p>

                  <p><b>Diketahui:</b></p>

                  <p>
                    B =
                    <input type="text" id="cair-B" style="width:120px;">
                    N/m²
                  </p>

                  <p>
                    ρ =
                    <input type="text" id="cair-rho" style="width:120px;">
                    kg/m³
                  </p>

                  <p><b>Ditanyakan:</b></p>
                  <p>v = … ?</p>

                  <p><b>Jawaban:</b></p>
                  <p>
                    v =
                    <input type="number" id="cair-jawaban" style="width:100px;"> m/s
                    <button class="next-btn" id="cair-btn">Cek Jawaban</button>
                  </p>

                  <p id="cair-feedback"></p>
                </div>


              </div>


              <!-- =================================================
                TAB 3 — GAS
                ================================================= -->
              <div id="latihan-3" class="latihan-tab-page">

                <!-- CONTOH -->
                <div class="box-diff">
                  <p><b>Contoh Soal – Cepat Rambat Bunyi di Udara</b></p>
                  <p>
                    Suhu udara di suatu tempat adalah
                    <b>20°C</b>.
                    Tentukan cepat rambat bunyi di udara pada suhu tersebut.
                  </p>

                  <p><b>Diketahui:</b></p>
                  <ul>
                    <li>T = 20°C</li>
                  </ul>

                  <p><b>Ditanyakan:</b></p>
                  <p>v = ... ?</p>

                  <p><b>Penyelesaian:</b></p>
                  <p>
                    v ≈ 331 + 0,6T<br>
                    v = 331 + (0,6 × 20)<br>
                    v = <b>343 m/s</b>
                  </p>
                </div>

                <!-- LATIHAN -->
                <div class="box-diff" style="margin-top:16px;">
                  <p><b>Soal 3 – Gas</b></p>

                  <!-- KALIMAT SOAL -->
                  <p>
                    Suhu udara di suatu tempat adalah
                    <b>30°C</b>.
                    Tentukan cepat rambat bunyi di udara pada suhu tersebut.
                  </p>

                  <p><b>Diketahui:</b></p>

                  <p>
                    T =
                    <input type="text" id="gas-T" style="width:120px;">
                    °C
                  </p>

                  <p><b>Ditanyakan:</b></p>
                  <p>v = … ?</p>

                  <p><b>Jawaban:</b></p>
                  <p>
                    v =
                    <input type="number" id="gas-jawaban" style="width:100px;"> m/s
                    <button class="next-btn" id="gas-btn">Cek Jawaban</button>
                  </p>

                  <p id="gas-feedback"></p>
                </div>
              </div>

            </div>
            <div style="margin-top:20px; text-align:center;">
              <button id="download-pdf-btn" class="next-btn" style="display:none;">
                📄 Download Hasil Latihan Bunyi (PDF)
              </button>
            </div>
            <div style="margin-top:25px; text-align:center;">
              @if(session('success'))
                <div style="color:#059669; font-weight:600; margin-bottom:10px;">
                  {{ session('success') }}
                </div>
              @endif
              <form id="upload-form" action="{{ url('/pengumpulan-gelombang') }}" method="POST" enctype="multipart/form-data" style="display:none;">
                @csrf

                <input type="hidden" name="latihan_code" value="L21">

                <div style="margin-bottom:10px;">
                  <input type="file" name="file" accept="application/pdf" required style="padding:6px;">
                </div>

                <button type="submit" class="next-btn">
                  Upload Jawaban (PDF)
                </button>

              </form>

            </div>
          </div>
        </section>
      </div>
      <!-- =========================
                                                     NAVIGASI HALAMAN INTERNAL
                                                     ========================= -->
      <div class="inner-navigation">
        <button id="inner-prev" class="next-btn">Previous</button>

        <button class="next-btn inner-nav-btn" data-target="page-konsep">1</button>
        <button class="next-btn inner-nav-btn" data-target="page-medium">2</button>
        <button class="next-btn inner-nav-btn" data-target="page-rumus">3</button>
        <button class="next-btn inner-nav-btn" data-target="page-latihan">4</button>

        <button id="inner-next" class="next-btn">Next</button>
      </div>

      <button class="next-btn" onclick="location.href='{{ url('pengantar_bunyi') }}'">
        ← Materi Sebelumnya
      </button>

      <button class="next-btn" onclick="location.href='{{ url('sumber_kar_bunyi') }}'">
        Materi Selanjutnya →
      </button>

    </main>
  </div>

@endsection

@section('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", () => {

      const hasil = {
        padat: null,
        cair: null,
        gas: null
      };

      const downloadBtn = document.getElementById("download-pdf-btn");

      function cekSelesai() {
        document.getElementById("upload-form").style.display = "block";
        if (hasil.padat && hasil.cair && hasil.gas) {
          downloadBtn.style.display = "inline-block";
        }
      }


      /* =============================
         SIMPAN HASIL ZAT PADAT
         ============================= */
      document.getElementById("padat-btn")?.addEventListener("click", () => {
        const E = document.getElementById("padat-E").value;
        const rho = document.getElementById("padat-rho").value;
        const jawaban = document.getElementById("padat-jawaban").value;

        if (!E || !rho || !jawaban) return;

        hasil.padat = {
          judul: "Soal 1 – Cepat Rambat Bunyi pada Zat Padat",
          soal: "Bahan padat memiliki E = 9 × 10¹⁰ N/m² dan ρ = 9000 kg/m³.",
          diketahui: `E = ${E} N/m², ρ = ${rho} kg/m³`,
          ditanyakan: "v = ... ?",
          jawabanSiswa: jawaban + " m/s",
          jawabanBenar: "≈ 3160 m/s"
        };
        cekSelesai();
      });

      /* =============================
         SIMPAN HASIL ZAT CAIR
         ============================= */
      document.getElementById("cair-btn")?.addEventListener("click", () => {
        const jawaban = document.getElementById("cair-jawaban").value;

        if (!jawaban) return;

        hasil.cair = {
          judul: "Soal 2 – Cepat Rambat Bunyi pada Zat Cair",
          soal: "Zat cair memiliki B = 1,6 × 10⁹ N/m² dan ρ = 1000 kg/m³. Tentukan cepat rambat bunyi.",
          diketahui: "B = 1,6 × 10⁹ N/m², ρ = 1000 kg/m³",
          ditanyakan: "v = ... ?",
          jawabanSiswa: jawaban + " m/s",
          jawabanBenar: "≈ 1265 m/s"
        };

        cekSelesai();
      });

      /* =============================
         SIMPAN HASIL GAS
         ============================= */
      document.getElementById("gas-btn")?.addEventListener("click", () => {
        const jawaban = document.getElementById("gas-jawaban").value;

        if (!jawaban) return;

        hasil.gas = {
          judul: "Soal 3 – Cepat Rambat Bunyi di Udara",
          soal: "Suhu udara 30°C. Tentukan cepat rambat bunyi di udara.",
          diketahui: "T = 30°C",
          ditanyakan: "v = ... ?",
          jawabanSiswa: jawaban + " m/s",
          jawabanBenar: "349 m/s"
        };

        cekSelesai();
      });

      /* =============================
         GENERATE PDF
         ============================= */
      downloadBtn.addEventListener("click", () => {

        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF();

        let y = 15;

        pdf.setFontSize(16);
        pdf.text("HASIL LATIHAN CEPAT RAMBAT BUNYI", 14, y);
        y += 10;

        pdf.setFontSize(12);
        pdf.text("Materi: Konsep Dasar & Perambatan Bunyi", 14, y);
        y += 12;

        Object.values(hasil).forEach((item) => {

          pdf.setFont(undefined, "bold");
          pdf.text(item.judul, 14, y);
          y += 8;

          pdf.setFont(undefined, "normal");

          pdf.text("Soal:", 14, y);
          y += 6;
          pdf.text(item.soal, 18, y, { maxWidth: 170 });
          y += 10;

          pdf.text("Diketahui:", 14, y);
          y += 6;
          pdf.text(item.diketahui, 18, y);
          y += 8;

          pdf.text("Ditanyakan:", 14, y);
          y += 6;
          pdf.text(item.ditanyakan, 18, y);
          y += 8;

          pdf.text("Jawaban Siswa:", 14, y);
          y += 6;
          pdf.text(item.jawabanSiswa, 18, y);
          y += 8;

          pdf.text("Jawaban Benar:", 14, y);
          y += 6;
          pdf.text(item.jawabanBenar, 18, y);

          y += 12;

          if (y > 260) {
            pdf.addPage();
            y = 20;
          }

        });

        pdf.save("hasil_latihan_cepat_rambat_bunyi.pdf");
      });
    });
  </script>

  <script>
    /* ===== TAB LATIHAN ===== */
    document.querySelectorAll(".latihan-tab-btn").forEach(btn => {
      btn.addEventListener("click", () => {
        const id = btn.dataset.target;

        document.querySelectorAll(".latihan-tab-btn")
          .forEach(b => b.classList.remove("latihan-tab-active"));
        btn.classList.add("latihan-tab-active");

        document.querySelectorAll(".latihan-tab-page")
          .forEach(p => p.classList.remove("latihan-tab-page-active"));
        document.getElementById(id).classList.add("latihan-tab-page-active");
      });
    });

    /* ===== CEK JAWABAN ===== */
    function feedback(id, benar, teks) {
      const el = document.getElementById(id);
      if (!el) return;
      el.textContent = teks;
      el.style.fontWeight = "600";
      el.style.color = benar ? "#059669" : "#b91c1c";
    }

    // zat padat
    document.getElementById("padat-btn")?.addEventListener("click", () => {

      const E = document.getElementById("padat-E").value;
      const rho = document.getElementById("padat-rho").value;
      const v = parseFloat(document.getElementById("padat-jawaban").value);

      const kunci = 3162;

      if (!E || !rho || isNaN(v)) {
        feedback("padat-feedback", false, "Lengkapi semua nilai terlebih dahulu.");
        return;
      }

      Math.abs(v - kunci) < 50
        ? feedback("padat-feedback", true, "Benar! v ≈ 3162 m/s.")
        : feedback("padat-feedback", false, "Periksa kembali rumus v = √(E / ρ).");

    });

    // zat cair
    document.getElementById("cair-btn")?.addEventListener("click", () => {

      const B = document.getElementById("cair-B").value;
      const rho = document.getElementById("cair-rho").value;
      const v = parseFloat(document.getElementById("cair-jawaban").value);

      const kunci = 1265;

      if (!B || !rho || isNaN(v)) {
        feedback("cair-feedback", false, "Lengkapi semua nilai terlebih dahulu.");
        return;
      }

      Math.abs(v - kunci) < 30
        ? feedback("cair-feedback", true, "Benar! v ≈ 1265 m/s.")
        : feedback("cair-feedback", false, "Gunakan rumus v = √(B / ρ).");

    });

    // GAS
    document.getElementById("gas-btn")?.addEventListener("click", () => {

      const T = document.getElementById("gas-T").value;
      const v = parseFloat(document.getElementById("gas-jawaban").value);

      const kunci = 349;

      if (!T || isNaN(v)) {
        feedback("gas-feedback", false, "Lengkapi semua nilai terlebih dahulu.");
        return;
      }

      Math.abs(v - kunci) < 1
        ? feedback("gas-feedback", true, "Benar! v = 331 + 0,6 × 30 = 349 m/s.")
        : feedback("gas-feedback", false, "Gunakan rumus v ≈ 331 + 0,6T.");

    });


    const pages = document.querySelectorAll(".subpage");
    const navBtns = document.querySelectorAll(".inner-nav-btn");
    const prevBtn = document.getElementById("inner-prev");
    const nextBtn = document.getElementById("inner-next");

    const order = [
      "page-konsep",
      "page-medium",
      "page-rumus",
      "page-latihan"
    ];


    let currentIndex = 0;

    function showPage(id) {
      pages.forEach(p => {
        p.style.display = (p.id === id) ? "block" : "none";
      });

      navBtns.forEach(btn => {
        const active = btn.dataset.target === id;
        btn.classList.toggle("active", active);
      });

      currentIndex = order.indexOf(id);
      prevBtn.disabled = currentIndex === 0;
      nextBtn.disabled = currentIndex === order.length - 1;
    }

    navBtns.forEach(btn => {
      btn.addEventListener("click", () => showPage(btn.dataset.target));
    });

    prevBtn.addEventListener("click", () => {
      if (currentIndex > 0) showPage(order[currentIndex - 1]);
    });

    nextBtn.addEventListener("click", () => {
      if (currentIndex < order.length - 1) showPage(order[currentIndex + 1]);
    });

    // awal
    showPage(order[0]);


  </script>

  <script>
    window.addEventListener("beforeunload", function () {
      kirimProgress("konsep_perambatan_bunyi", 8);
    });
  </script>

@endsection