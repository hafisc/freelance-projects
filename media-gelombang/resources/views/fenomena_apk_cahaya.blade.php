@extends('layouts.siswa')

@section('title', 'Fenomena & Aplikasi Cahaya')

@section('style')

  <style>
    .modal-lks {
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, .6);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 9999;
      padding: 20px;
      overflow-y: auto;
    }

    .modal-lks-content {
      width: 95%;
      max-width: 950px;
      background: white;
      border-radius: 16px;
      max-height: 95vh;
      overflow-y: auto;
    }

    #area-pdf-difraksi {
      background: white;
      padding: 30px;
      border-radius: 16px;
    }

    .identitas {
      border: 2px solid #cbd5e1;
      border-radius: 12px;
      padding: 16px;
      width: 350px;
      background: #f8fafc;
      line-height: 1.8;
      font-size: 18px;
    }

    .petunjuk-lks {
      background: #eff6ff;
      border-left: 5px solid #2563eb;
      padding: 15px 20px;
      border-radius: 10px;
      margin: 25px 0;
    }

    .petunjuk-lks ol {
      padding-left: 20px;
      line-height: 1.8;
    }

    .tabel-lks {
      width: 100%;
      border-collapse: collapse;
      border-radius: 16px;
      overflow: hidden;
      table-layout: fixed;
    }

    /* KOLOM */

    .tabel-lks th:nth-child(1),
    .tabel-lks td:nth-child(1) {
      width: 70px;
      text-align: center;
    }

    .tabel-lks th:nth-child(2),
    .tabel-lks td:nth-child(2) {
      width: 55%;
    }

    .tabel-lks th:nth-child(3),
    .tabel-lks td:nth-child(3) {
      width: 30%;
    }

    /* HEADER */

    .tabel-lks th {
      background: #2563eb;
      color: white;
      padding: 16px;
      text-align: center;
      font-size: 16px;
    }

    /* ISI */

    .tabel-lks td {
      background: #dbeafe;
      padding: 18px;
      vertical-align: middle;
      line-height: 1.7;
      word-wrap: break-word;
    }

    .tabel-lks tr:nth-child(even) td {
      background: #bfdbfe;
    }

    /* SELECT */

    .tabel-lks select {
      width: 100%;
      padding: 12px;
      border-radius: 10px;
      border: 1px solid #94a3b8;
      background: white;
      font-size: 14px;
    }

    /* RESPONSIVE */

    @media(max-width:768px) {

      .tabel-lks {
        font-size: 13px;
      }

      .tabel-lks th,
      .tabel-lks td {
        padding: 10px;
      }

      .tabel-lks th:nth-child(1),
      .tabel-lks td:nth-child(1) {
        width: 45px;
      }

      .tabel-lks th:nth-child(2),
      .tabel-lks td:nth-child(2) {
        width: 50%;
      }

      .tabel-lks th:nth-child(3),
      .tabel-lks td:nth-child(3) {
        width: 35%;
      }

    }

    .lks-kesimpulan {
      margin-top: 25px;
    }

    .lks-kesimpulan textarea {
      width: 100%;
      border: 1px solid #cbd5e1;
      border-radius: 8px;
      padding: 12px;
      resize: none;
    }

    .lks-actions {
      margin-top: 30px;
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .action-top,
    .action-bottom {
      text-align: center;
    }

    .action-middle {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 12px;
      flex-wrap: wrap;
    }

    @media(max-width:768px) {

      .modal-lks-content {
        width: 100%;
        max-height: 100vh;
        border-radius: 0;
      }

      #area-pdf-difraksi {
        padding: 15px;
      }

      .identitas {
        width: 100%;
        font-size: 15px;
      }

      .tabel-lks {
        font-size: 13px;
      }

      .tabel-lks th,
      .tabel-lks td {
        padding: 10px;
      }

    }
  </style>

@endsection

@section('siswa-content')

  <div class="materi-gelombang">

    {{-- ==================== KONTEN ==================== --}}
    <main class="content">

      <h1>Fenomena & Aplikasi Cahaya</h1>

      <div class="box">

        {{-- ===== PAGE 1 ===== --}}
        <section id="page-fenomena" class="subpage">
          <h3>Fenomena Cahaya</h3>

          <p>
            Cahaya tidak hanya memungkinkan manusia melihat benda,
            tetapi juga menimbulkan berbagai fenomena alam yang dapat diamati
            dalam kehidupan sehari-hari.
          </p>

          <p>
            Fenomena cahaya terjadi karena cahaya berinteraksi dengan medium
            seperti udara, air, kaca, atau permukaan benda.
          </p>

          <div class="box-diff">
            Fenomena cahaya terjadi karena cahaya dapat
            <b>dipantulkan, dibiaskan, diserap, dan diuraikan</b>.
          </div>

          <p>
            Ketika cahaya mengenai suatu benda, sebagian cahaya akan dipantulkan,
            sebagian dapat menembus benda (dibiaskan), dan sebagian lagi diserap.
          </p>

          <p>
            Bayangan terbentuk karena cahaya merambat lurus dan terhalang benda.
            Pelangi terbentuk karena cahaya Matahari dibiaskan, dipantulkan,
            lalu diuraikan oleh butiran air hujan.
          </p>

          <!-- GAMBAR DI TENGAH BAWAH -->
          <div class="example-row" style="display:flex; flex-direction:column; align-items:flex-start; margin-top:24px;">
            <div class="example-image" style="text-align:center;">
              <img src="{{ asset('images/fenomena_cahaya.png') }}" alt="Fenomena cahaya" style="max-width:540px;">
              <p class="image-caption">Contoh fenomena cahaya dalam kehidupan sehari-hari.</p>
            </div>
          </div>
        </section>



        {{-- ===== PAGE 2 ===== --}}
        <section id="page-aplikasi" class="subpage" style="display:none;">
          <h3>Aplikasi Cahaya</h3>

          <p>
            Cahaya dimanfaatkan dalam berbagai bidang teknologi modern,
            mulai dari komunikasi hingga kesehatan.
          </p>

          <div class="box-diff">
            Cahaya digunakan dalam bidang <b>komunikasi, medis, industri, dan energi</b>.
          </div>

          <p>
            Dalam bidang komunikasi, cahaya digunakan dalam serat optik
            untuk mengirimkan data dengan kecepatan tinggi.
          </p>

          <p>
            Dalam bidang kesehatan, cahaya dimanfaatkan melalui
            sinar laser dan sinar-X untuk membantu diagnosis dan operasi.
          </p>

          <div class="example-row">
            <div class="example-image">
              <img src="{{ asset('images/aplikasi_cahaya.png') }}" alt="Aplikasi cahaya">
              <p class="image-caption">Pemanfaatan cahaya dalam teknologi.</p>
            </div>

            <div class="example-text">
              <p><b>Contoh aplikasi cahaya:</b></p>
              <ul>
                <li>Serat optik untuk internet</li>
                <li>Laser untuk operasi medis</li>
                <li>Lampu LED hemat energi</li>
                <li>Kamera dan sensor optik</li>
              </ul>
            </div>
          </div>
        </section>


        {{-- ===== PAGE 3 (BARU) ===== --}}
        <section id="page-difraksi" class="subpage" style="display:none;">

          <h3>Percobaan Difraksi Cahaya</h3>

          <div class="box-diff" style="margin-top:18px;">

            <h3>Apa Itu Difraksi Cahaya?</h3>

            <p>
              <strong>Difraksi cahaya</strong> adalah peristiwa penyebaran atau pembelokan
              gelombang cahaya ketika melewati celah sempit atau penghalang.
            </p>

            <p>
              Cahaya yang melewati celah sempit tidak hanya bergerak lurus,
              tetapi juga menyebar sehingga membentuk pola terang dan gelap
              pada layar pengamatan.
            </p>

            <p>
              Pola tersebut terjadi karena gelombang cahaya saling bertumpuk
              dan menghasilkan interferensi. Semakin sempit celah yang digunakan,
              maka pola difraksi akan terlihat semakin jelas.
            </p>

            <div class="note-box" style="margin-top:12px;">
              Difraksi menunjukkan bahwa cahaya memiliki sifat sebagai gelombang.
            </div>

          </div>

          <p>
            Video berikut menunjukkan percobaan difraksi cahaya menggunakan laser.
            Perhatikan dengan seksama agar kamu dapat mengerjakan lembar kerja setelah video selesai.
          </p>

          <div style="text-align:center; margin-top:20px;">
            <div id="playerDifraksi"></div>
          </div>
          <!-- Navigasi bagian video -->
          <div style="margin-top:15px; text-align:center;">

            <button class="next-btn" onclick="gotoVideoDifraksi(0)">
              Pendahuluan
            </button>

            <button class="next-btn" onclick="gotoVideoDifraksi(4)">
              Konsep Difraksi
            </button>

            <button class="next-btn" onclick="gotoVideoDifraksi(80)">
              Alat dan Bahan
            </button>

            <button class="next-btn" onclick="gotoVideoDifraksi(107)">
              Percobaan 1
            </button>

            <button class="next-btn" id="btn-lks-difraksi" onclick="openLKSDifraksi()" disabled>
              🔒 Kerjakan LKS
            </button>

          </div>

        </section>

        {{-- ===== PAGE 4 ===== --}}
        <section id="page-keterkaitan" class="subpage" style="display:none;">
          <h3>Keterkaitan Cahaya dengan Spektrum Elektromagnetik</h3>

          <p>
            Cahaya tampak hanyalah sebagian kecil dari spektrum gelombang elektromagnetik.
          </p>

          <div class="box-diff">
            Semakin kecil panjang gelombang, semakin besar energi gelombang.
          </div>

          <p>
            Gelombang elektromagnetik mencakup berbagai jenis gelombang
            yang digunakan dalam teknologi modern.
          </p>

          <p>
            Setiap jenis gelombang memiliki karakteristik dan pemanfaatan yang berbeda.
          </p>

          <div class="example-row">
            <div class="example-text">
              <p><b>Contoh spektrum dan manfaat:</b></p>
              <ul>
                <li>Radio → komunikasi</li>
                <li>Inframerah → kamera termal</li>
                <li>Cahaya tampak → penglihatan</li>
                <li>Sinar-X → medis</li>
              </ul>
            </div>

            <div class="example-image">
              <img src="{{ asset('images/spektrum_elektromagnetik.png') }}" alt="Spektrum EM">
              <p class="image-caption">Posisi cahaya tampak dalam spektrum elektromagnetik.</p>
            </div>
          </div>
        </section>


      </div>

      {{-- ===== NAVIGASI ===== --}}
      <div class="inner-navigation">
        <button id="inner-prev" class="next-btn">Previous</button>
        <button class="next-btn inner-nav-btn" data-target="page-fenomena">1</button>
        <button class="next-btn inner-nav-btn" data-target="page-aplikasi">2</button>
        <button class="next-btn inner-nav-btn" data-target="page-difraksi">3</button>
        <button class="next-btn inner-nav-btn" data-target="page-keterkaitan">4</button>
        <button id="inner-next" class="next-btn">Next</button>
      </div>

      <button class="next-btn" onclick="location.href='{{ url('spektrum_cahaya') }}'">← Materi Sebelumnya</button>
      <button class="next-btn" onclick="location.href='{{ url('kuis_cahaya') }}'">Kuis Cahaya →</button>

    </main>
  </div>

  <div id="lksDifraksiModal" class="modal-lks">

    <div class="modal-lks-content">

      <div id="area-pdf-difraksi">

        <h2>LEMBAR KERJA SISWA</h2>

        <div style="display:flex; justify-content:center;">
          <div class="identitas">
            Nama: {{ auth()->user()->name }} <br>
            NISN: {{ auth()->user()->username ?? '-' }} <br>
            Kelas: {{ auth()->user()->kelas ?? '-' }}
          </div>
        </div>

        <div class="petunjuk-lks">

          <h3>Petunjuk Pengerjaan</h3>

          <ol>
            <li>Amati video percobaan difraksi cahaya dengan seksama.</li>
            <li>Pilih jawaban berdasarkan hasil pengamatan video.</li>
            <li>Jawab seluruh soal sebelum download PDF.</li>
            <li>Tuliskan kesimpulan hasil percobaan.</li>
            <li>Upload PDF hasil jawaban.</li>
          </ol>

        </div>


        <h3 style="text-align:center;">Tabel Pengamatan</h3>

        <table class="tabel-lks">

          <tr>
            <th>Percobaan</th>
            <th>Kondisi Pengamatan</th>
            <th>Hasil yang Terjadi</th>
          </tr>

          <tr>
            <td>1</td>
            <td>Laser diarahkan melewati celah sempit</td>
            <td>
              <select id="difraksi1">
                <option value="">--pilih jawaban--</option>
                <option value="1a">Cahaya menyebar setelah melewati celah</option>
                <option value="1b">Cahaya berhenti total</option>
                <option value="1c">Cahaya dipantulkan kembali</option>
              </select>
            </td>
          </tr>

          <tr>
            <td>2</td>
            <td>Celah dibuat semakin sempit</td>
            <td>
              <select id="difraksi2">
                <option value="">--pilih jawaban--</option>
                <option value="2a">Pola difraksi terlihat semakin jelas</option>
                <option value="2b">Pola cahaya menghilang</option>
                <option value="2c">Cahaya menjadi redup tanpa pola</option>
              </select>
            </td>
          </tr>

          <tr>
            <td>3</td>
            <td>Cahaya laser diarahkan ke layar setelah melewati celah</td>
            <td>
              <select id="difraksi3">
                <option value="">--pilih jawaban--</option>
                <option value="3a">Terbentuk pola terang dan gelap</option>
                <option value="3b">Tidak terbentuk pola apapun</option>
                <option value="3c">Cahaya berubah warna</option>
              </select>
            </td>
          </tr>

          <tr>
            <td>4</td>
            <td>Celah dibuat lebih lebar</td>
            <td>
              <select id="difraksi4">
                <option value="">--pilih jawaban--</option>
                <option value="4a">Pola difraksi menjadi kurang jelas</option>
                <option value="4b">Pola difraksi semakin jelas</option>
                <option value="4c">Cahaya menyebar lebih besar</option>
              </select>
            </td>
          </tr>

          <tr>
            <td>5</td>
            <td>Laser diarahkan tanpa melewati celah</td>
            <td>
              <select id="difraksi5">
                <option value="">--pilih jawaban--</option>
                <option value="5a">Tidak terbentuk pola difraksi</option>
                <option value="5b">Muncul pola terang dan gelap</option>
                <option value="5c">Cahaya menyebar ke segala arah</option>
              </select>
            </td>
          </tr>

        </table>

        <div class="lks-kesimpulan">

          <h3>Kesimpulan</h3>

          <textarea id="kesimpulan-difraksi" rows="5"
            placeholder="Tuliskan kesimpulan hasil percobaan difraksi cahaya..."></textarea>

        </div>

        <div class="lks-actions">

          <div class="action-top">
            <button class="next-btn" onclick="cekJawabanDifraksi()">
              Cek Jawaban
            </button>
          </div>

          <div class="action-middle">

            <button id="btn-download-difraksi" class="next-btn">
              📄 Download PDF
            </button>

            <form action="{{ url('/pengumpulan-gelombang') }}" method="POST" enctype="multipart/form-data">

              @csrf

              <input type="hidden" name="latihan_code" value="L25">

              <input type="file" name="file" accept="application/pdf" required>

              <button type="submit" class="next-btn">
                Upload Jawaban
              </button>

            </form>

          </div>

          <div class="action-bottom">

            <button class="next-btn" onclick="closeLKSDifraksi()">
              Tutup
            </button>

          </div>
        </div>
      </div>
    </div>
</div> @endsection

</div>

</div>

<script src="https://www.youtube.com/iframe_api"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

@section('scripts')
  <script>
    document.addEventListener("DOMContentLoaded", () => {

      const pages = document.querySelectorAll(".subpage");
      const navBtns = document.querySelectorAll(".inner-nav-btn");
      const prevBtn = document.getElementById("inner-prev");
      const nextBtn = document.getElementById("inner-next");

      const order = [
        "page-fenomena",
        "page-aplikasi",
        "page-difraksi",
        "page-keterkaitan"
      ];
      let index = 0;

      function showPage(id) {
        pages.forEach(p => p.style.display = (p.id === id) ? "block" : "none");
        navBtns.forEach(b => {
          const active = b.dataset.target === id;
          b.style.backgroundColor = active ? "#0f766e" : "";
          b.style.color = active ? "#ffffff" : "";
        });
        index = order.indexOf(id);
        prevBtn.disabled = index === 0;
        nextBtn.disabled = index === order.length - 1;
      }

      navBtns.forEach(b => b.onclick = () => showPage(b.dataset.target));
      prevBtn.onclick = () => index > 0 && showPage(order[index - 1]);
      nextBtn.onclick = () => index < order.length - 1 && showPage(order[index + 1]);

      showPage(order[0]);
    });
  </script>

  <script>
    let videoDifraksiSelesai = false;

    const modalDifraksi = document.getElementById("lksDifraksiModal");

    window.openLKSDifraksi = function () {

      if (!videoDifraksiSelesai) {
        alert("Selesaikan video terlebih dahulu!");
        return;
      }

      modalDifraksi.style.display = "flex";
    }

    window.closeLKSDifraksi = function () {
      modalDifraksi.style.display = "none";
    }

    videoDifraksi.addEventListener("ended", () => {

      videoDifraksiSelesai = true;

      const btn = document.getElementById("btn-lks-difraksi");

      btn.disabled = false;
      btn.textContent = "Kerjakan LKS";
    });

    /* =========================
       CEK JAWABAN
    ========================= */

    window.cekJawabanDifraksi = function () {

      let benar = 0;

      if (document.getElementById("difraksi1").value === "1a") benar++;

      if (document.getElementById("difraksi2").value === "2a") benar++;

      if (document.getElementById("difraksi3").value === "3a") benar++;

      if (document.getElementById("difraksi4").value === "4a") benar++;

      if (document.getElementById("difraksi5").value === "5a") benar++;

      alert("Jawaban benar: " + benar + " dari 5");
    }

    const btnDownloadDifraksi = document.getElementById("btn-download-difraksi");

    btnDownloadDifraksi?.addEventListener("click", () => {

      const textarea = document.getElementById("kesimpulan-difraksi");

      if (!textarea.value.trim()) {
        alert("Isi kesimpulan dulu!");
        return;
      }

      const tempDiv = document.createElement("div");

      tempDiv.style.whiteSpace = "pre-wrap";
      tempDiv.style.marginTop = "10px";
      tempDiv.innerText = textarea.value;

      textarea.style.display = "none";

      textarea.parentNode.appendChild(tempDiv);

      const element = document.getElementById("area-pdf-difraksi");

      html2canvas(element, { scale: 2 }).then(canvas => {

        const imgData = canvas.toDataURL("image/png");

        const { jsPDF } = window.jspdf;

        const pdf = new jsPDF("p", "mm", "a4");

        const imgWidth = 210;
        const imgHeight = canvas.height * imgWidth / canvas.width;

        const pdfHeight = pdf.internal.pageSize.getHeight();

        if (imgHeight > pdfHeight) {

          let heightLeft = imgHeight;
          let position = 0;

          pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);

          heightLeft -= pdfHeight;

          while (heightLeft > 0) {

            position = heightLeft - imgHeight;

            pdf.addPage();

            pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);

            heightLeft -= pdfHeight;
          }

        } else {

          pdf.addImage(imgData, 'PNG', 0, 0, imgWidth, imgHeight);

        }

        pdf.save("LKS_Difraksi_Cahaya.pdf");

        textarea.style.display = "block";

        tempDiv.remove();

      });

    });

    window.addEventListener("beforeunload", function () {
      kirimProgress("fenomena_apk_cahaya", 15);
    });
  </script>

  <script>
    let playerDifraksi;

    window.onYouTubeIframeAPIReady = function () {

      playerDifraksi = new YT.Player('playerDifraksi', {

        width: '100%',
        height: '500',

        videoId: 'ekGMJmOQ36s',

        playerVars: {
          rel: 0,
          modestbranding: 1
        },

        events: {

          onStateChange: function (event) {

            if (event.data === YT.PlayerState.ENDED) {

              videoDifraksiSelesai = true;

              const btn = document.getElementById("btn-lks-difraksi");

              btn.disabled = false;
              btn.textContent = "Kerjakan LKS";
            }
          }
        }
      });

    };

    window.gotoVideoDifraksi = function (seconds) {

      if (!playerDifraksi) return;

      playerDifraksi.seekTo(seconds, true);
      playerDifraksi.playVideo();
    };
  </script>

@endsection