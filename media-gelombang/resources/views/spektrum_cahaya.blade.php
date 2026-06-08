@extends('layouts.siswa')

@section('title', 'Spektrum Cahaya')

@section('siswa-content')

<div class="materi-gelombang">

  {{-- ==================== KONTEN ==================== --}}
  <main class="content">

    <h1>Spektrum Cahaya</h1>

    <div class="box">

      {{-- ==================== HALAMAN 1 ==================== --}}
      <section id="page-pengertian" class="subpage">
        <h3>Pengertian Spektrum Cahaya</h3>

        <p>
          Cahaya yang kita lihat sehari-hari, seperti cahaya Matahari atau lampu,
          sebenarnya bukanlah cahaya dengan satu warna saja.
          Cahaya tersebut merupakan <b>cahaya putih</b> yang tersusun dari berbagai
          warna dengan panjang gelombang yang berbeda-beda.
        </p>

        <p>
          <b>Spektrum cahaya</b> adalah susunan warna-warna cahaya
          yang dihasilkan ketika cahaya putih diuraikan
          menjadi komponen-komponennya berdasarkan
          panjang gelombang atau frekuensinya.
          Penguraian cahaya ini disebut sebagai <b>dispersi</b>.
        </p>

        <p>
          Spektrum cahaya dapat diamati ketika cahaya putih
          melewati medium tertentu, seperti prisma kaca.
          Cahaya akan terurai menjadi warna merah, jingga, kuning,
          hijau, biru, nila, dan ungu.
        </p>

        <div class="box-diff">
          Spektrum cahaya menunjukkan bahwa setiap warna cahaya
          memiliki panjang gelombang dan frekuensi yang berbeda.
        </div>

        <p>
          Pemahaman tentang spektrum cahaya sangat penting
          karena menjadi dasar untuk mempelajari
          cahaya tampak, spektrum gelombang elektromagnetik,
          serta berbagai penerapannya dalam kehidupan sehari-hari.
        </p>
      </section>

      {{-- ==================== HALAMAN 2 ==================== --}}
      <section id="page-tampak" class="subpage" style="display:none;">
        <h3>Cahaya Tampak</h3>

        <p>
          <b>Cahaya tampak</b> adalah bagian dari spektrum cahaya
          yang dapat <b>ditangkap oleh mata manusia</b>.
          Tidak semua gelombang elektromagnetik dapat kita lihat,
          hanya cahaya dengan panjang gelombang tertentu saja
          yang termasuk dalam cahaya tampak.
        </p>

        <p>
          Cahaya tampak memiliki rentang panjang gelombang
          sekitar <b>400 nm hingga 700 nm</b>.
          Setiap warna dalam cahaya tampak
          memiliki panjang gelombang dan frekuensi yang berbeda,
          sehingga menghasilkan warna yang berbeda pula.
        </p>

        <div class="box-diff">
          Urutan warna cahaya tampak adalah:
          <b>merah – jingga – kuning – hijau – biru – nila – ungu</b>.
        </div>

        <p>
          Warna merah memiliki panjang gelombang paling besar
          dan frekuensi paling kecil,
          sedangkan warna ungu memiliki panjang gelombang paling kecil
          dan frekuensi paling besar.
        </p>

        <div class="example-row">

          <div class="example-text">
            <p><b>Contoh dalam kehidupan sehari-hari:</b></p>
            <ul>
              <li>Pelangi yang muncul setelah hujan.</li>
              <li>Cahaya putih yang melewati prisma kaca.</li>
              <li>Warna-warni pada gelembung sabun.</li>
            </ul>
          </div>

          <div class="example-image">
            <img src="{{ asset('images/spektrum_cahaya_tampak.png') }}" alt="Spektrum cahaya tampak">
            <p class="image-caption">
              Spektrum cahaya tampak dari merah hingga ungu.
            </p>
          </div>

        </div>

        <div class="box-diff" style="margin-top:12px;">
          Cahaya tampak merupakan bagian kecil dari
          spektrum gelombang elektromagnetik,
          tetapi memiliki peran sangat penting
          dalam penglihatan manusia dan teknologi optik.
        </div>

      </section>
      {{-- ==================== HALAMAN 3 ==================== --}}
      <section id="page-gelmag" class="subpage" style="display:none;">
        <h3>Spektrum Gelombang Elektromagnetik</h3>

        <p>
          Cahaya tampak hanyalah <b>sebagian kecil</b> dari keseluruhan
          <b>spektrum gelombang elektromagnetik</b>.
          Gelombang elektromagnetik adalah gelombang
          yang dapat merambat tanpa medium
          dan tersusun dari medan listrik dan medan magnet
          yang saling tegak lurus.
        </p>

        <p>
          Spektrum gelombang elektromagnetik mencakup
          berbagai jenis gelombang dengan
          panjang gelombang dan frekuensi yang berbeda-beda,
          mulai dari gelombang dengan panjang gelombang
          sangat besar hingga sangat kecil.
        </p>

        <div class="box-diff">
          Urutan spektrum gelombang elektromagnetik dari
          panjang gelombang terbesar ke terkecil adalah:
          <b>
            gelombang radio – gelombang mikro – inframerah –
            cahaya tampak – ultraviolet – sinar-X – sinar gamma
          </b>.
        </div>

        <p>
          Semakin kecil panjang gelombang suatu gelombang elektromagnetik,
          semakin besar frekuensinya dan semakin besar pula energi
          yang dibawa oleh gelombang tersebut.
        </p>

        <div class="example-row">

          <div class="example-text">
            <p><b>Contoh pemanfaatan gelombang elektromagnetik:</b></p>
            <ul>
              <li>Gelombang radio untuk siaran radio dan televisi.</li>
              <li>Gelombang mikro untuk oven microwave dan radar.</li>
              <li>Inframerah untuk kamera termal dan remote TV.</li>
              <li>Sinar-X untuk pemeriksaan medis.</li>
              <li>Sinar gamma untuk terapi kanker.</li>
            </ul>
          </div>

          <div class="example-image">
            <img src="{{ asset('images/spektrum_gelombang_elektromagnetik.png') }}"
                 alt="Spektrum gelombang elektromagnetik">
            <p class="image-caption">
              Spektrum gelombang elektromagnetik dan posisi
              cahaya tampak di dalam spektrum tersebut.
            </p>
          </div>

        </div>

        <div class="box-diff" style="margin-top:12px;">
          Cahaya tampak berada di antara inframerah dan ultraviolet
          dalam spektrum gelombang elektromagnetik.
        </div>

      </section>


      {{-- ==================== HALAMAN 4 ==================== --}}
      <section id="page-hubungan" class="subpage" style="display:none;">
        <h3>Hubungan Panjang Gelombang, Frekuensi, dan Energi</h3>

        <p>
          Setiap gelombang elektromagnetik, termasuk cahaya,
          memiliki <b>panjang gelombang</b> dan <b>frekuensi</b>.
          Kedua besaran ini saling berhubungan dan
          memengaruhi <b>energi</b> yang dibawa oleh gelombang tersebut.
        </p>

        <p>
          Panjang gelombang adalah jarak antara dua puncak gelombang
          yang berurutan, sedangkan frekuensi adalah banyaknya gelombang
          yang melewati suatu titik setiap detik.
        </p>

        <div class="box-diff">
          Hubungan panjang gelombang dan frekuensi bersifat berbanding terbalik:
          <b>panjang gelombang besar → frekuensi kecil</b><br>
          <b>panjang gelombang kecil → frekuensi besar</b>
        </div>

        <p>
          Energi gelombang elektromagnetik bergantung pada frekuensinya.
          Semakin besar frekuensi suatu gelombang,
          semakin besar pula energi yang dibawanya.
        </p>

        <div class="box-diff">
          <b>Artinya</b>, cahaya berwarna ungu memiliki energi lebih besar
          dibandingkan cahaya berwarna merah.
        </div>

        <div class="example-row">

          <div class="example-text">
            <p><b>Contoh dalam spektrum cahaya:</b></p>
            <ul>
              <li>Cahaya merah: λ besar, energi kecil.</li>
              <li>Cahaya ungu: λ kecil, energi besar.</li>
              <li>Sinar-X dan sinar gamma: energi sangat besar.</li>
            </ul>
          </div>

          <div class="example-image">
            <img src="{{ asset('images/hubungan_panjang_gelombang_frekuensi.png') }}"
                 alt="Hubungan panjang gelombang, frekuensi, dan energi">
            <p class="image-caption">
              Hubungan panjang gelombang, frekuensi,
              dan energi pada spektrum elektromagnetik.
            </p>
          </div>

        </div>

        <div class="box-diff" style="margin-top:12px;">
          Hubungan ini menjelaskan mengapa
          beberapa jenis radiasi elektromagnetik
          dapat berbahaya bagi tubuh manusia.
        </div>

      </section>

    </div>

    {{-- ==================== NAVIGASI ==================== --}}
    <div class="inner-navigation">
      <button id="inner-prev" class="next-btn">Previous</button>

      <button class="next-btn inner-nav-btn" data-target="page-pengertian">1</button>
      <button class="next-btn inner-nav-btn" data-target="page-tampak">2</button>
      <button class="next-btn inner-nav-btn" data-target="page-gelmag">3</button>
      <button class="next-btn inner-nav-btn" data-target="page-hubungan">4</button>

      <button id="inner-next" class="next-btn">Next</button>
    </div>

    <button class="next-btn" onclick="location.href='{{ url('sifat_cahaya') }}'">
      ← Materi Sebelumnya
    </button>
    <button class="next-btn" onclick="location.href='{{ url('fenomena_apk_cahaya') }}'">
      Materi Selanjutnya →
    </button>

  </main>
</div>

@endsection


@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", () => {

  const subpages = document.querySelectorAll(".subpage");
  const navBtns = document.querySelectorAll(".inner-nav-btn");
  const prevBtn = document.getElementById("inner-prev");
  const nextBtn = document.getElementById("inner-next");

  const order = [
    "page-pengertian",
    "page-tampak",
    "page-gelmag",
    "page-hubungan"
  ];

  let currentIndex = 0;

  function showPage(id) {
    subpages.forEach(p => {
      p.style.display = (p.id === id) ? "block" : "none";
    });

    navBtns.forEach(btn => {
      const active = btn.dataset.target === id;
      btn.style.backgroundColor = active ? "#0f766e" : "";
      btn.style.color = active ? "#ffffff" : "";
    });

    currentIndex = order.indexOf(id);
    prevBtn.disabled = currentIndex === 0;
    nextBtn.disabled = currentIndex === order.length - 1;
  }

  navBtns.forEach(btn => {
    btn.addEventListener("click", () => {
      showPage(btn.dataset.target);
    });
  });

  prevBtn.onclick = () => {
    if (currentIndex > 0) showPage(order[currentIndex - 1]);
  };

  nextBtn.onclick = () => {
    if (currentIndex < order.length - 1) showPage(order[currentIndex + 1]);
  };

  showPage(order[0]);
});
</script>

  <script>
    window.addEventListener("beforeunload", function () {
      kirimProgress("spektrum_cahaya", 14);
    });
  </script>

@endsection
