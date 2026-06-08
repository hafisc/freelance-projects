@extends('layouts.siswa')

@section('title', 'Jenis-Jenis Gelombang')

@section('siswa-content')

  <div class="materi-gelombang">



    <main class="content">
      <h2>Konsep Dasar & Perambatan Bunyi</h2>

      <div class="box">

        <!-- ====================
                                           HALAMAN 1 – KONSEP DASAR BUNYI
                                           ==================== -->
        <section id="page-sumber" class="subpage">
          <h3>Sumber Bunyi</h3>

          <p>
            <b>Sumber bunyi</b> adalah <b>benda yang bergetar</b>.
            Getaran inilah yang menyebabkan gangguan pada medium di sekitarnya,
            sehingga gangguan tersebut merambat dan akhirnya dapat
            <b>didengar oleh telinga</b>.
          </p>

          <p>
            Semua bunyi yang kita dengar—baik suara manusia, alat musik,
            maupun bunyi alam—<b>selalu berasal dari getaran</b>.
            Jika tidak ada getaran, maka bunyi tidak akan dihasilkan.
          </p>

          <div class="box-diff">
            <b>Prinsip penting:</b><br>
            Tidak ada bunyi tanpa getaran.<br>
            Bunyi tidak muncul dengan sendirinya, tetapi selalu
            <b>dihasilkan oleh sumber yang bergetar</b>.
          </div>

          <!-- ====================
                                            CONTOH SUMBER BUNYI
                                            ==================== -->
          <div class="example-row">

            <!-- KIRI: TEKS -->
            <div class="example-text">
              <p><b>Contoh sumber bunyi dalam kehidupan sehari-hari:</b></p>
              <ul>
                <li>Suara manusia berasal dari <b>getaran pita suara</b>.</li>
                <li>Gitar menghasilkan bunyi karena <b>senarnya bergetar</b>.</li>
                <li>Speaker menghasilkan bunyi karena <b>membran bergetar</b>.</li>
                <li>Petir menghasilkan bunyi akibat <b>getaran udara</b> yang sangat kuat.</li>
              </ul>
            </div>

            <!-- KANAN: GAMBAR / VISUAL -->
            <div class="example-image">
              <!-- Ganti src sesuai aset kamu -->
              <img src="{{ asset('images/sumber_bunyi.png') }}" style="width: 500px; height: 260px;"
                alt="Contoh sumber bunyi yang bergetar">
              <p class="image-caption">
                Bunyi selalu berasal dari benda yang bergetar.
              </p>
            </div>

          </div>

          <div class="box-diff" style="margin-top:12px;">
            <b>Kesimpulan:</b><br>
            Getaran → mengganggu medium → bunyi merambat → bunyi terdengar.
          </div>
        </section>
        <!-- ====================
                                         HALAMAN 2 – GELOMBANG LONGITUDINAL
                                         ==================== -->
        <section id="page-frekuensi" class="subpage" style="display:none;">
          <h3>Frekuensi dan Tinggi Rendah Bunyi</h3>

          <div class="latihan-tabs-wrapper">

            <!-- TAB HEADER -->
            <div class="latihan-tabs-header">
              <button class="latihan-tab-btn latihan-tab-active" data-target="freq-materi">
                Materi
              </button>
              <button class="latihan-tab-btn" data-target="freq-latihan1">
                Latihan 1
              </button>
              <button class="latihan-tab-btn" data-target="freq-latihan2">
                Latihan 2
              </button>
            </div>

            <!-- ================= MATERI ================= -->
            <div id="freq-materi" class="latihan-tab-page latihan-tab-page-active">

              <p>
                Tinggi–rendah bunyi ditentukan oleh <b>frekuensi</b>.
                Frekuensi menunjukkan banyaknya getaran yang terjadi setiap detik.
                Semakin banyak getaran dalam satu detik, maka bunyi akan terdengar
                semakin tinggi.
              </p>

              <div class="box-diff">
                <b>Pengertian Frekuensi</b><br>
                Frekuensi adalah jumlah getaran tiap satuan waktu.
                Satuan frekuensi adalah <b>Hertz (Hz)</b>.
              </div>

              <h4>Hubungan Frekuensi dengan Bunyi</h4>
              <ul>
                <li>Frekuensi besar → bunyi bernada tinggi</li>
                <li>Frekuensi kecil → bunyi bernada rendah</li>
                <li>Frekuensi tidak mempengaruhi keras–lembut bunyi</li>
              </ul>

              <div class="box-diff">
                <b>Rumus Frekuensi</b><br><br>
                f = n / t
                <br><br>
                Keterangan:
                <ul>
                  <li>f = frekuensi (Hz)</li>
                  <li>n = jumlah getaran</li>
                  <li>t = waktu (s)</li>
                </ul>
              </div>

              <h4>Contoh dalam Kehidupan Sehari-hari</h4>
              <ul>
                <li>Suara anak kecil memiliki frekuensi lebih besar dibanding suara orang dewasa.</li>
                <li>Senar gitar yang lebih tegang menghasilkan frekuensi lebih tinggi.</li>
                <li>Peluit menghasilkan bunyi tinggi karena frekuensinya besar.</li>
              </ul>

              <div class="box-diff">
                <p><b>Contoh Soal</b></p>

                Sebuah sumber bunyi bergetar sebanyak <b>300 kali</b>
                dalam waktu <b>3 detik</b>.

                <br><br>
                Diketahui:
                <ul>
                  <li>n = 300 getaran</li>
                  <li>t = 3 s</li>
                </ul>

                Ditanyakan:
                <br>
                f = ... ?

                <br><br>
                Penyelesaian:
                <br>
                f = n / t
                <br>
                f = 300 / 3
                <br>
                <b>f = 100 Hz</b>
              </div>

              <div class="box-diff2" style="margin-top:12px;">
                <b>Catatan Penting:</b><br>
                Frekuensi menentukan tinggi bunyi (pitch),
                sedangkan amplitudo menentukan keras bunyi.
              </div>

            </div>


            <!-- ================= LATIHAN 1 ================= -->
            <div id="freq-latihan1" class="latihan-tab-page">

              <div class="box-diff">

                <p><b>Latihan 1</b></p>

                <p>
                  Sebuah sumber bunyi bergetar sebanyak <b>240 kali</b>
                  dalam waktu <b>2 detik</b>.
                  Tentukan frekuensi bunyi tersebut.
                </p>

                <p><b>Diketahui:</b></p>
                n = <input type="text" id="freq1-n" style="width:80px;"> getaran<br><br>
                t = <input type="text" id="freq1-t" style="width:80px;"> s

                <p><b>Ditanyakan:</b></p>
                <p>f = ... Hz</p>

                <p><b>Jawaban:</b></p>
                f =
                <input type="number" id="freq1-jawaban" style="width:120px;"> Hz

                <button class="next-btn" id="freq1-btn">Cek Jawaban</button>

                <p id="freq1-feedback"></p>

              </div>

            </div>



            <!-- ================= LATIHAN 2 ================= -->
            <div id="freq-latihan2" class="latihan-tab-page">

              <div class="box-diff">

                <p><b>Latihan 2</b></p>

                <p>
                  Sebuah alat musik menghasilkan bunyi dengan jumlah getaran
                  sebanyak <b>500 kali</b> dalam waktu <b>4 detik</b>.
                  Tentukan frekuensi bunyi tersebut.
                </p>

                <p><b>Diketahui:</b></p>
                n = <input type="text" id="freq2-n" style="width:80px;"> getaran<br><br>
                t = <input type="text" id="freq2-t" style="width:80px;"> s

                <p><b>Ditanyakan:</b></p>
                <p>f = ... Hz</p>

                <p><b>Jawaban:</b></p>
                f =
                <input type="number" id="freq2-jawaban" style="width:120px;"> Hz

                <button class="next-btn" id="freq2-btn">Cek Jawaban</button>

                <p id="freq2-feedback"></p>

              </div>

            </div>



          </div>
          <div style="margin-top:20px; text-align:center;">
            <button id="download-pdf-freq" class="next-btn" style="display:none;">
              📄 Download Hasil Latihan Frekuensi (PDF)
            </button>
          </div>

          {{-- ================= UPLOAD PDF JAWABAN ================= --}}
          <div style="margin-top:25px; text-align:center;">

            @if(session('success'))
              <div style="color:#059669; font-weight:600; margin-bottom:10px;">
                {{ session('success') }}
              </div>
            @endif

            <form id="upload-form-freq" action="{{ url('/pengumpulan-gelombang') }}" method="POST" enctype="multipart/form-data" style="display:none;">
              @csrf

              <input type="hidden" name="latihan_code" value="L22">

              <div style="margin-bottom:10px;">
                <input type="file" name="file" accept="application/pdf" required style="padding:6px;">
              </div>

              <button type="submit" class="next-btn">
                Upload Jawaban (PDF)
              </button>

            </form>

          </div>
        </section>


        <!-- ====================
                                         HALAMAN 3 – 
                                         ==================== -->
        <section id="page-amplitudo" class="subpage" style="display:none;">
          <h3>Amplitudo dan Kuat Lemah Bunyi</h3>

          <p>
            Selain tinggi–rendah bunyi, bunyi juga memiliki karakteristik
            <b>kuat–lemah</b>. Kuat–lemah bunyi ditentukan oleh
            <b>amplitudo</b> getaran sumber bunyi.
          </p>

          <p>
            <b>Amplitudo</b> adalah <b>simpangan maksimum</b> suatu getaran
            dari posisi keseimbangannya.
            Semakin besar amplitudo getaran, semakin besar energi yang dibawa
            oleh gelombang bunyi.
          </p>

          <div class="box-diff">
            <b>Hubungan penting:</b><br>
            Amplitudo besar → bunyi terdengar keras<br>
            Amplitudo kecil → bunyi terdengar lemah
          </div>

          <!-- ====================
                                            CONTOH DALAM KEHIDUPAN SEHARI-HARI
                                            ==================== -->
          <div class="example-row">

            <!-- KIRI: TEKS -->
            <div class="example-text">
              <p><b>Contoh perbedaan amplitudo:</b></p>
              <ul>
                <li>Memukul drum dengan kuat menghasilkan bunyi yang lebih keras.</li>
                <li>Berbicara pelan menghasilkan bunyi yang lebih lemah.</li>
                <li>Memetik senar gitar dengan kuat membuat bunyi terdengar lebih keras.</li>
              </ul>
            </div>

            <!-- KANAN: VISUAL -->
            <div class="example-image">
              <!-- Ganti dengan gambar / grafik amplitudo -->
              <img src="{{ asset('images/amplitudo_bunyi.png') }}" style="width: 600px; height: 350px;"
                alt="Perbandingan amplitudo besar dan kecil">
              <p class="image-caption">
                Gelombang dengan amplitudo besar membawa energi lebih besar.
              </p>
            </div>

          </div>

          <!-- ====================
                                            PENEGASAN KONSEP
                                            ==================== -->
          <div class="box-diff" style="margin-top:12px;">
            <b>Perlu diingat:</b><br>
            Kuat–lemah bunyi <b>tidak mempengaruhi</b> tinggi–rendah bunyi.<br>
            Amplitudo mempengaruhi keras bunyi, sedangkan frekuensi mempengaruhi pitch.
          </div>
        </section>
        <!-- ====================
                                         HALAMAN 4 – 
                                         ==================== -->
        <section id="page-warna" class="subpage" style="display:none;">
          <h3>Warna Bunyi (Timbre)</h3>

          <p>
            Dalam fisika bunyi, istilah <b>warna bunyi</b> atau <b>timbre</b>
            <b>bukan berarti warna seperti merah, biru, atau hijau</b>.
            Istilah ini digunakan untuk menjelaskan
            <b>keragaman karakter bunyi</b> yang dihasilkan oleh suatu sumber.
          </p>

          <p>
            Warna bunyi membuat kita dapat <b>membedakan sumber bunyi</b>,
            meskipun bunyi tersebut memiliki <b>tinggi nada (frekuensi)</b>
            dan <b>kuat bunyi (amplitudo)</b> yang sama.
          </p>

          <div class="box-diff">
            <b>Penting:</b><br>
            Kata <b>“warna”</b> pada warna bunyi hanya istilah,
            yang menunjukkan <b>perbedaan karakter atau ciri khas bunyi</b>,
            bukan warna visual seperti pada cahaya.
          </div>

          <!-- ====================
                                            CONTOH DALAM KEHIDUPAN SEHARI-HARI
                                            ==================== -->
          <div class="example-row">

            <!-- KIRI: TEKS -->
            <div class="example-text">
              <p><b>Contoh perbedaan warna bunyi:</b></p>
              <ul>
                <li>Nada “Do” pada piano terdengar berbeda dengan nada “Do” pada gitar.</li>
                <li>Suara setiap manusia memiliki ciri khas meskipun bernada sama.</li>
                <li>Peluit dan seruling tetap terdengar berbeda walau memainkan nada yang sama.</li>
              </ul>
            </div>

            <!-- KANAN: VISUAL -->
            <div class="example-image">
              <img src="{{ asset('images/warna_bunyi.png') }}" style="width: 600px; height: 300px;"
                alt="Perbedaan bentuk gelombang dan warna bunyi">
              <p class="image-caption">
                Perbedaan bentuk gelombang dan harmonik menghasilkan warna bunyi yang berbeda.
              </p>
            </div>

          </div>

          <!-- ====================
                                            PENJELASAN TAMBAHAN
                                            ==================== -->
          <div class="box-diff" style="margin-top:12px;">
            <p><b>Apa yang Menyebabkan Perbedaan Warna Bunyi?</b></p>
            <ul>
              <li><b>Bentuk sumber bunyi</b> (senar, membran, atau kolom udara).</li>
              <li><b>Jumlah dan kekuatan harmonik</b> yang menyertai nada dasar.</li>
              <li><b>Cara bunyi dihasilkan</b> (dipetik, ditiup, atau dipukul).</li>
            </ul>
          </div>

          <div class="box-diff" style="margin-top:12px;">
            <b>Kesimpulan:</b><br>
            Frekuensi menentukan <b>tinggi bunyi</b>, amplitudo menentukan <b>keras bunyi</b>,
            dan <b>warna bunyi menentukan variasi serta ciri khas bunyi</b>
            dari suatu sumber.
          </div>

          <hr style="margin:30px 0;">

        </section>

      </div>

      <div class="inner-navigation">
        <button id="inner-prev" class="next-btn">Previous</button>
        <button class="next-btn inner-nav-btn" data-target="page-sumber">1</button>
        <button class="next-btn inner-nav-btn" data-target="page-frekuensi">2</button>
        <button class="next-btn inner-nav-btn" data-target="page-amplitudo">3</button>
        <button class="next-btn inner-nav-btn" data-target="page-warna">4</button>
        <button id="inner-next" class="next-btn">Next</button>
      </div>

      <button class="next-btn" onclick="location.href='{{ url('konsep_perambatan_bunyi') }}'">
        ← Materi Sebelumnya
      </button>

      <button class="next-btn" onclick="location.href='{{ url('fenomena_apk_bunyi') }}'">
        Materi Selanjutnya →
      </button>
    </main>

@endsection

  @section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
      document.addEventListener("DOMContentLoaded", () => {

        /* ====================
           HELPER
           ==================== */
        const $ = id => document.getElementById(id);
        const $$$ = sel => document.querySelectorAll(sel);



        /* ====================
           STATE
           ==================== */
        const pages = $$$(".subpage");
        const navBtns = $$$(".inner-nav-btn");
        let index = 0;


        const hasilFreq = {
          latihan1: null,
          latihan2: null
        };

        const downloadFreqBtn = $("download-pdf-freq");

        function cekFreqSelesai() {
          document.getElementById("upload-form-freq").style.display = "block";
          if (hasilFreq.latihan1 && hasilFreq.latihan2) {
            downloadFreqBtn.style.display = "inline-block";
          }
        }

        /* ====================
           PAGE SWITCH
           ==================== */
        function showPage(id) {
          pages.forEach(p => p.style.display = "none");
          const target = $(id);
          if (target) target.style.display = "block";

          navBtns.forEach(b => b.classList.remove("active"));
          navBtns.forEach(b => {
            if (b.dataset.target === id) b.classList.add("active");
          });

          pages.forEach((p, i) => {
            if (p.id === id) index = i;
          });
        }

        /* ====================
           NAVIGATION
           ==================== */
        const prevBtn = $("inner-prev");
        const nextBtn = $("inner-next");

        if (prevBtn) {
          prevBtn.onclick = () => {
            if (index > 0) showPage(pages[index - 1].id);
          };
        }

        if (nextBtn) {
          nextBtn.onclick = () => {
            if (index < pages.length - 1) {
              showPage(pages[index + 1].id);
            }
          };
        }

        navBtns.forEach(btn => {
          btn.addEventListener("click", () => {
            showPage(btn.dataset.target);
          });
        });


        document.getElementById("frekuensi-btn")?.addEventListener("click", () => {

          const jawaban = parseFloat(
            document.getElementById("frekuensi-jawaban").value
          );

          const feedback = document.getElementById("frekuensi-feedback");
          const kunci = 120;

          if (isNaN(jawaban)) {
            feedback.textContent = "Masukkan jawaban terlebih dahulu.";
            feedback.style.color = "#b91c1c";
            return;
          }

          if (Math.abs(jawaban - kunci) < 1) {
            feedback.textContent = "Benar! Frekuensi = 120 Hz.";
            feedback.style.color = "#059669";
          } else {
            feedback.textContent = "Periksa kembali rumus f = n / t.";
            feedback.style.color = "#b91c1c";
          }

        });

        /* ================= TAB FREKUENSI ================= */
        document.querySelectorAll(".latihan-tab-btn").forEach(btn => {
          btn.addEventListener("click", () => {

            const id = btn.dataset.target;

            document.querySelectorAll(".latihan-tab-btn")
              .forEach(b => b.classList.remove("latihan-tab-active"));

            btn.classList.add("latihan-tab-active");

            document.querySelectorAll(".latihan-tab-page")
              .forEach(p => p.classList.remove("latihan-tab-page-active"));

            document.getElementById(id)
              .classList.add("latihan-tab-page-active");

          });
        });

        /* ====================
           INIT
           ==================== */
        if (pages.length) showPage(pages[0].id);


        $("freq1-btn")?.addEventListener("click", () => {

          const n = $("freq1-n").value.trim();
          const t = $("freq1-t").value.trim();
          const jawaban = parseFloat($("freq1-jawaban").value);

          const feedback = $("freq1-feedback");

          const nBenar = 240;
          const tBenar = 2;
          const fBenar = 120;

          let pesan = [];

          if (n != nBenar) {
            pesan.push("Nilai n (jumlah getaran) masih salah.");
          }

          if (t != tBenar) {
            pesan.push("Nilai t (waktu) masih salah.");
          }

          if (isNaN(jawaban)) {
            pesan.push("Masukkan jawaban frekuensi terlebih dahulu.");
          } else if (Math.abs(jawaban - fBenar) > 1) {
            pesan.push("Perhitungan frekuensi masih salah.");
          }

          if (pesan.length === 0) {
            feedback.textContent = "Benar! Semua bagian sudah tepat.";
            feedback.style.color = "#059669";
          } else {
            feedback.innerHTML = pesan.join("<br>");
            feedback.style.color = "#b91c1c";
          }

          hasilFreq.latihan1 = {
            judul: "Latihan 1 – Frekuensi Bunyi",
            soal: "Sumber bunyi bergetar 240 kali dalam 2 detik.",
            diketahui: `n = ${n} getaran, t = ${t} s`,
            ditanyakan: "f = ... Hz",
            jawabanSiswa: jawaban + " Hz",
            jawabanBenar: "120 Hz"
          };

          cekFreqSelesai();

        });


        $("freq2-btn")?.addEventListener("click", () => {

          const n = $("freq2-n").value.trim();
          const t = $("freq2-t").value.trim();
          const jawaban = parseFloat($("freq2-jawaban").value);

          const feedback = $("freq2-feedback");

          const nBenar = 500;
          const tBenar = 4;
          const fBenar = 125;

          let pesan = [];

          if (n != nBenar) {
            pesan.push("Nilai n (jumlah getaran) masih salah.");
          }

          if (t != tBenar) {
            pesan.push("Nilai t (waktu) masih salah.");
          }

          if (isNaN(jawaban)) {
            pesan.push("Masukkan jawaban frekuensi terlebih dahulu.");
          } else if (Math.abs(jawaban - fBenar) > 1) {
            pesan.push("Perhitungan frekuensi masih salah.");
          }

          if (pesan.length === 0) {
            feedback.textContent = "Benar! Semua bagian sudah tepat.";
            feedback.style.color = "#059669";
          } else {
            feedback.innerHTML = pesan.join("<br>");
            feedback.style.color = "#b91c1c";
          }

          hasilFreq.latihan2 = {
            judul: "Latihan 2 – Frekuensi Bunyi",
            soal: "Alat musik bergetar 500 kali dalam 4 detik.",
            diketahui: `n = ${n} getaran, t = ${t} s`,
            ditanyakan: "f = ... Hz",
            jawabanSiswa: jawaban + " Hz",
            jawabanBenar: "125 Hz"
          };

          cekFreqSelesai();

        });


        downloadFreqBtn?.addEventListener("click", () => {

          const { jsPDF } = window.jspdf;
          const pdf = new jsPDF();

          let y = 20;

          pdf.setFontSize(16);
          pdf.text("HASIL LATIHAN FREKUENSI BUNYI", 14, y);
          y += 10;

          Object.values(hasilFreq).forEach((item) => {

            pdf.text(item.judul, 14, y);
            y += 8;

            pdf.text("Diketahui: " + item.diketahui, 14, y);
            y += 8;

            pdf.text("Jawaban Siswa: " + item.jawabanSiswa, 14, y);
            y += 8;

            pdf.text("Jawaban Benar: " + item.jawabanBenar, 14, y);
            y += 12;

          });

          pdf.save("hasil_latihan_frekuensi.pdf");

        });

      });
    </script>

    <script>
      window.addEventListener("beforeunload", function () {
        kirimProgress("sumber_kar_bunyi", 9);
      });
    </script>
  @endsection