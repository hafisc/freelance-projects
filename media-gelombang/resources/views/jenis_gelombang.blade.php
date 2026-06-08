@extends('layouts.siswa')

@section('title', 'Jenis-Jenis Gelombang')

@section('siswa-content')

  <div class="materi-gelombang">



    <main class="content">
      <h1>Jenis-Jenis Gelombang</h1>
      <div class="box">
        <section id="page-jenis-dasar" class="subpage">
          <p>
            Gelombang dapat diklasifikasikan berdasarkan <b>arah getar partikel</b>
            terhadap <b>arah rambat gelombang</b>.
          </p>

          <h3>Berdasarkan Arah Getar dan Arah Rambat</h3>

          <!-- ================= LONGITUDINAL ================= -->
          <div style="display:flex; flex-wrap:wrap; gap:18px; margin-top:12px;">

            <div style="flex:1 1 280px;">
              <h5>1) Gelombang Longitudinal</h5>
              <p>
                Gelombang longitudinal adalah gelombang yang arah getarnya
                <b>sejajar</b> dengan arah rambatnya.
              </p>

              <ul>
                <li>Terjadi peristiwa <b>rapatan</b> dan <b>renggangan</b>.</li>
                <li>Contoh: <b>gelombang bunyi di udara</b>.</li>
              </ul>

              <p><i>Sejajar artinya arah getar dan arah rambat berada pada satu garis yang sama.</i></p>
            </div>

            <div class="media-box">
              <img src="{{ asset('media/longitudinal.gif') }}" alt="Ilustrasi Gelombang Longitudinal" class="media-gif">
            </div>

          </div>

          <!-- ================= TRANSVERSAL ================= -->
          <div style="display:flex; flex-wrap:wrap; gap:18px; margin-top:22px;">

            <div style="flex:1 1 280px;">
              <h5>2) Gelombang Transversal</h5>
              <p>
                Gelombang transversal adalah gelombang yang arah getarnya
                <b>tegak lurus</b> terhadap arah rambatnya.
              </p>

              <ul>
                <li>Memiliki <b>Bukit</b> dan <b>lembah</b>.</li>
                <li>Contoh: gelombang pada tali dan gelombang cahaya.</li>
              </ul>

              <p><i>Tegak lurus artinya arah getar membentuk sudut 90° terhadap arah rambat.</i></p>
            </div>

            <div class="media-box">
              <img src="{{ asset('media/transversal.gif') }}" alt="Ilustrasi Gelombang Transversal" class="media-gif">
            </div>

          </div>

          <!-- ================= RINGKASAN ================= -->
          <div class="box-diff" style="margin-top:20px;">
            <h5>Perbedaan Utama</h5>
            <ul>
              <li><b>Longitudinal</b> → getar sejajar arah rambat.</li>
              <li><b>Transversal</b> → getar tegak lurus arah rambat.</li>
            </ul>
          </div>

        </section>

        <!-- =========================
                     HALAMAN 2 – MEDIUM
                     ========================= -->
        <section id="page-medium" class="subpage" style="display:none;">

          <h3>Berdasarkan Kebutuhan Medium Perantara</h3>

          <p>
            Gelombang juga dapat diklasifikasikan berdasarkan apakah gelombang tersebut
            memerlukan medium untuk merambat atau tidak.
          </p>

          <!-- ================= MEKANIK ================= -->
          <div style="display:flex; flex-wrap:wrap; gap:18px; margin-top:14px;">

            <div style="flex:1 1 280px;">
              <h5>1) Gelombang Mekanik</h5>
              <p>
                Gelombang mekanik adalah gelombang yang <b>memerlukan medium</b>
                (zat perantara) untuk merambat.
              </p>

              <ul>
                <li>Tidak dapat merambat di ruang hampa.</li>
                <li>Contoh: gelombang bunyi, gelombang air, gelombang gempa.</li>
              </ul>
            </div>

            <div class="media-box">
              <img src="{{ asset('images/gelombang_mekanik.png') }}" alt="Contoh Gelombang Mekanik"
                class="large-illustration">
            </div>

          </div>

          <!-- ================= ELEKTROMAGNETIK ================= -->
          <div style="display:flex; flex-wrap:wrap; gap:18px; margin-top:22px;">

            <div style="flex:1 1 280px;">
              <h5>2) Gelombang Elektromagnetik</h5>
              <p>
                Gelombang elektromagnetik adalah gelombang yang
                <b>tidak memerlukan medium</b> untuk merambat.
              </p>

              <ul>
                <li>Dapat merambat di ruang hampa.</li>
                <li>Contoh: cahaya matahari, gelombang radio, sinar-X.</li>
              </ul>
            </div>

            <div class="media-box">
              <img src="{{ asset('images/gelombang_elektromagnetik.png') }}" alt="Contoh Gelombang Elektromagnetik"
                class="media-gif">
            </div>

          </div>

          <!-- ================= FAKTA MENARIK ================= -->
          <div class="box-diff" style="margin-top:20px;">
            <h5>Fakta Menarik</h5>
            <p>
              Gelombang gempa terdiri dari:
            </p>
            <ul>
              <li><b>Gelombang P</b> → longitudinal (lebih cepat).</li>
              <li><b>Gelombang S</b> → transversal.</li>
            </ul>
          </div>

        </section>

        <!-- =========================
                     HALAMAN 3 – LATIHAN
                     ========================= -->
        <section id="page-latihan" class="subpage" style="display:none;">
          <div class="latihan" id="latihan">
            <h2>Latihan 1.2 Klasifikasi Gelombang</h2>
            <p>
              Pada halaman ini ada <b>dua tabel latihan</b>:
            </p>
            <ol>
              <li>Klasifikasi berdasarkan <b>arah getar dan arah rambat</b> (Longitudinal / Transversal).</li>
              <li>Klasifikasi berdasarkan <b>kebutuhan medium perantara</b> (Mekanik / Elektromagnetik).</li>
            </ol>
            <p>
              Pilih salah satu jenis gelombang di setiap baris, lalu klik <b>Cek Jawaban</b>.
            </p>

            <!-- =========================
                      TABEL 1 – LONGITUDINAL vs TRANSVERSAL
                      ========================= -->
            <div class="box-diff" style="margin-top:10px;">
              <h3>Latihan 1 – Berdasarkan Arah Getar dan Arah Rambat</h3>
              <form onsubmit="return false;">
                <table>
                  <thead>
                    <tr>
                      <th style="width:5%;">No</th>
                      <th style="width:45%;">Nama Gelombang</th>
                      <th style="width:20%;">Longitudinal</th>
                      <th style="width:20%;">Transversal</th>
                    </tr>
                  </thead>
                  <tbody id="soalArahBody">

                    <tr data-answer="longitudinal">
                      <td class="center">1</td>
                      <td class="name">Gelombang Bunyi di Udara</td>
                      <td class="center"><input type="checkbox" class="chk longitudinal"></td>
                      <td class="center"><input type="checkbox" class="chk transversal"></td>
                    </tr>

                    <tr data-answer="longitudinal">
                      <td class="center">2</td>
                      <td class="name">Gelombang pada Slinky (didorong–ditarik sepanjang arah pegas)</td>
                      <td class="center"><input type="checkbox" class="chk longitudinal"></td>
                      <td class="center"><input type="checkbox" class="chk transversal"></td>
                    </tr>

                    <tr data-answer="transversal">
                      <td class="center">3</td>
                      <td class="name">Gelombang pada Tali yang Digerakkan ke Atas–Bawah</td>
                      <td class="center"><input type="checkbox" class="chk longitudinal"></td>
                      <td class="center"><input type="checkbox" class="chk transversal"></td>
                    </tr>

                    <tr data-answer="transversal">
                      <td class="center">4</td>
                      <td class="name">Gelombang pada Permukaan Air (riak air)</td>
                      <td class="center"><input type="checkbox" class="chk longitudinal"></td>
                      <td class="center"><input type="checkbox" class="chk transversal"></td>
                    </tr>

                    <tr data-answer="transversal">
                      <td class="center">5</td>
                      <td class="name">Gelombang S pada Gempa Bumi</td>
                      <td class="center"><input type="checkbox" class="chk longitudinal"></td>
                      <td class="center"><input type="checkbox" class="chk transversal"></td>
                    </tr>

                  </tbody>
                </table>

                <div class="controls">
                  <button class="btn" id="cekArahBtn" type="button">Cek Jawaban</button>
                  <button class="btn reset" id="resetArahBtn" type="button">Reset</button>
                  <div class="hasil" id="hasilArahArea"></div>
                </div>
              </form>
            </div>

            <!-- =========================
                      TABEL 2 – MEKANIK vs ELEKTROMAGNETIK
                      ========================= -->
            <div class="box-diff" style="margin-top:16px;">
              <h3>Latihan 2 – Berdasarkan Kebutuhan Medium Perantara</h3>
              <form onsubmit="return false;">
                <table>
                  <thead>
                    <tr>
                      <th style="width:5%;">No</th>
                      <th style="width:45%;">Nama Gelombang</th>
                      <th style="width:20%;">Mekanik</th>
                      <th style="width:20%;">Elektromagnetik</th>
                    </tr>
                  </thead>
                  <tbody id="soalMediumBody">

                    <tr data-answer="mekanik">
                      <td class="center">1</td>
                      <td class="name">Gelombang Bunyi</td>
                      <td class="center"><input type="checkbox" class="chk mekanik"></td>
                      <td class="center"><input type="checkbox" class="chk elektromagnetik"></td>
                    </tr>

                    <tr data-answer="mekanik">
                      <td class="center">2</td>
                      <td class="name">Gelombang Air</td>
                      <td class="center"><input type="checkbox" class="chk mekanik"></td>
                      <td class="center"><input type="checkbox" class="chk elektromagnetik"></td>
                    </tr>

                    <tr data-answer="mekanik">
                      <td class="center">3</td>
                      <td class="name">Gelombang Gempa Bumi</td>
                      <td class="center"><input type="checkbox" class="chk mekanik"></td>
                      <td class="center"><input type="checkbox" class="chk elektromagnetik"></td>
                    </tr>

                    <tr data-answer="elektromagnetik">
                      <td class="center">4</td>
                      <td class="name">Cahaya Tampak</td>
                      <td class="center"><input type="checkbox" class="chk mekanik"></td>
                      <td class="center"><input type="checkbox" class="chk elektromagnetik"></td>
                    </tr>

                    <tr data-answer="elektromagnetik">
                      <td class="center">5</td>
                      <td class="name">Gelombang Radio</td>
                      <td class="center"><input type="checkbox" class="chk mekanik"></td>
                      <td class="center"><input type="checkbox" class="chk elektromagnetik"></td>
                    </tr>

                  </tbody>
                </table>

                <div class="controls">
                  <button class="btn" id="cekMediumBtn" type="button">Cek Jawaban</button>
                  <button class="btn reset" id="resetMediumBtn" type="button">Reset</button>
                  <div class="hasil" id="hasilMediumArea"></div>
                </div>
              </form>
            </div>
          </div>
        </section>

      </div>

      <!-- =========================
                   NAVIGASI DALAM HALAMAN
                   ========================= -->
      <div class="inner-navigation">
        <button id="inner-prev" class="next-btn">Previous</button>

        <button class="next-btn inner-nav-btn" data-target="page-jenis-dasar">1</button>
        <button class="next-btn inner-nav-btn" data-target="page-medium">2</button>
        <button class="next-btn inner-nav-btn" data-target="page-latihan">3</button>

        <button id="inner-next" class="next-btn">Next</button>
      </div>

      <button class="next-btn" onclick="location.href='{{ url('jenis_gelombang') }}'" style="margin-top:10px;">← Materi
        Sebelumnya</button>
      <button class="next-btn" onclick="location.href='{{ url('beda_fase_gelombang') }}'" style="margin-top:10px;">Materi
        Selanjutnya →</button>

    </main>
  </div>

@endsection

@section('scripts')
  {{--
  <script src="{{ asset(path: 'js/app.js') }}"></script> --}}
  <script>
    document.addEventListener("DOMContentLoaded", () => {


      /* ===========================
         NAVIGASI DALAM HALAMAN
         =========================== */
      const pages = document.querySelectorAll(".subpage");
      const navBtns = document.querySelectorAll(".inner-nav-btn");
      const prevBtn = document.getElementById("inner-prev");
      const nextBtn = document.getElementById("inner-next");

      const order = [
        "page-jenis-dasar",
        "page-medium",
        "page-latihan"
      ];

      let currentIndex = 0;

      function showPage(targetId) {
        pages.forEach(p => {
          p.style.display = (p.id === targetId) ? "block" : "none";
        });

        navBtns.forEach(btn => {
          const active = btn.dataset.target === targetId;
          btn.classList.toggle("active", active);
          btn.style.backgroundColor = active ? "#0f766e" : "";
          btn.style.color = active ? "#ffffff" : "";
        });

        currentIndex = order.indexOf(targetId);
        if (currentIndex < 0) currentIndex = 0;

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

    document.addEventListener("DOMContentLoaded", () => {

      function setupClassificationTable(
        tbodyId,
        classA,
        classB,
        cekBtnId,
        resetBtnId,
        hasilId
      ) {
        const rows = document.querySelectorAll(`#${tbodyId} tr`);
        if (!rows.length) return;

        // === BIKIN CHECKBOX SALING EKSKLUSIF ===
        rows.forEach(row => {
          const a = row.querySelector(`.${classA}`);
          const b = row.querySelector(`.${classB}`);

          a.addEventListener("change", () => {
            if (a.checked) b.checked = false;
          });

          b.addEventListener("change", () => {
            if (b.checked) a.checked = false;
          });
        });

        const cekBtn = document.getElementById(cekBtnId);
        const resetBtn = document.getElementById(resetBtnId);
        const hasil = document.getElementById(hasilId);

        // === CEK JAWABAN ===
        cekBtn.addEventListener("click", () => {
          let benar = 0;
          const total = rows.length;

          rows.forEach(row => {
            row.classList.remove("correct", "wrong");

            const jawaban = row.dataset.answer;
            const chkA = row.querySelector(`.${classA}`);
            const chkB = row.querySelector(`.${classB}`);

            let pilihan = null;
            if (chkA.checked) pilihan = classA;
            if (chkB.checked) pilihan = classB;

            if (pilihan === jawaban) {
              row.classList.add("correct");
              benar++;
            } else {
              row.classList.add("wrong");
            }
          });

          hasil.textContent = `Skor: ${benar} / ${total}`;
          hasil.style.color = (benar === total) ? "#15803d" : "#b91c1c";
          hasil.style.fontWeight = "700";
        });

        // === RESET ===
        resetBtn.addEventListener("click", () => {
          rows.forEach(row => {
            row.classList.remove("correct", "wrong");
            row.querySelectorAll("input[type=checkbox]").forEach(c => c.checked = false);
          });
          hasil.textContent = "";
        });
      }

      // ===== TABEL 1 =====
      setupClassificationTable(
        "soalArahBody",
        "longitudinal",
        "transversal",
        "cekArahBtn",
        "resetArahBtn",
        "hasilArahArea"
      );

      // ===== TABEL 2 =====
      setupClassificationTable(
        "soalMediumBody",
        "mekanik",
        "elektromagnetik",
        "cekMediumBtn",
        "resetMediumBtn",
        "hasilMediumArea"
      );

    });
  </script>

    <script>
    window.addEventListener("beforeunload", function () {
      kirimProgress("jenis_gelombang", 3);
    });
  </script>

@endsection