@extends('layouts.siswa')

@section('title', 'Beda Fase Gelombang')

@section('siswa-content')


<div class="materi-gelombang">

<!-- Konten -->
<main class="content">
    
  <h1>Beda Fase Gelombang</h1>

<div class="box">

  <!-- ================= ATAS (FULL WIDTH) ================= -->
  <h3>Apa Itu Fase?</h3>

  <p>
    Karena gelombang adalah <b>rambatan getaran</b>, maka setiap titik pada gelombang 
    tidak selalu berada pada posisi yang sama dalam satu siklus getaran. 
    Untuk menyatakan posisi tersebut, digunakan konsep <b>fase (dibaca: fi)</b>.
  </p>

  <p>
    Fase menunjukkan keadaan suatu titik pada gelombang 
    (misalnya sedang di puncak, di lembah, atau di posisi setimbang).
  </p>

  <p style="text-align:center;">
    <span class="rumus">
      ϕ(x,t) = 2π ( t/T − x/λ )
    </span>
  </p>

  <p><b>Cara membaca:</b></p>
  <ul>
    <li>ϕ dibaca <b>phi</b></li>
    <li>λ dibaca <b>lambda</b></li>
    <li>π dibaca <b>pi</b></li>
  </ul>

  <hr class="fase-divider">

  <!-- ================= BAWAH (KIRI – KANAN) ================= -->
  <div class="fase-split">

    <!-- KIRI -->
    <div class="fase-left">
      <h3>Beda Fase Dua Titik</h3>

      <p>
        Pada tingkat SMP/SMA, kita biasanya fokus pada beda fase antara dua titik 
        pada waktu yang sama.
      </p>

      <p style="text-align:center;">
        <span class="rumus">Δϕ = 2π (Δx / λ)</span>
      </p>

      <p><b>Cara membaca:</b></p>
      <p>
        "Delta phi sama dengan dua pi dikali delta x dibagi lambda."
      </p>

      <p>
        Artinya, beda fase ditentukan oleh perbandingan jarak kedua titik terhadap panjang gelombang.
      </p>
    </div>

    <!-- KANAN -->
    <div class="fase-right">
      <h3>Sefase dan Berlawanan Fase</h3>

      <ul>
        <li>
          <b>Sefase</b>: dua titik berada pada keadaan getar yang sama 
          (misalnya sama-sama di puncak).
          <br>
          Terjadi jika:
          <p style="text-align: center">
            <span class="rumus">Δx = nλ</span>
          </p>
        </li>

        <li style="margin-top:10px;">
          <b>Berlawanan fase</b>: saat satu titik di puncak, titik lain di lembah.
          <br>
          Terjadi jika:
          <p style="text-align: center">
            <span class="rumus">Δx = (2n+1) λ/2</span>
          </p>
        </li>
      </ul>
    </div>

  </div>

</div>

  <!-- FITUR INTERAKTIF -->
  <div class="interaktif-box">
    <h2>Interaktif: Beda Fase Dua Titik pada Gelombang</h2>
    <p>
      Amati gelombang di bawah ini. Terdapat dua titik: <b>A</b> (di sebelah kiri) dan <b>B</b> (di sebelah kanan).  
      Geser slider untuk mengubah jarak <b>Δx</b> antara A dan B. Perhatikan bagaimana <b>beda fase (Δϕ)</b> dan kategori fasenya berubah.
    </p>

    <div class="wave-container">
      <canvas id="waveCanvas" width="700" height="260"></canvas>

      <div class="control-panel">
        <label for="sliderDx">
          Jarak antar titik (Δx) dalam satuan panjang gelombang (λ): 
          <span id="infoDx">0,50 λ</span>
        </label>
        <input type="range" id="sliderDx" min="0" max="2" step="0.05" value="0.50">
      </div>

      <div class="info-fase">
        <p>Δϕ = <b><span id="infoPhiDeg">0</span>°</b> &nbsp; (≈ <span id="infoPhiRad">0</span> rad)</p>
        <p>
          <b>Kategori:</b> 
          <span id="infoKategori" class="badge-kategori badge-biasanya">Beda fase biasa</span>
        </p>
        <p style="font-size:13px; color:#4b5563;">
          Tips: coba atur Δx = 0 λ, 0,5 λ, 1 λ, 1,5 λ, dan 2 λ lalu lihat jenis fasenya.
        </p>
      </div>
    </div>
  </div>

  <!-- Navigasi -->
  <button class="next-btn" onclick="location.href='{{ url('jenis_gelombang') }}'">← Materi Sebelumnya</button>
  <button class="next-btn" onclick="location.href='{{ url('prinsip_gelombang') }}'">Materi Selanjutnya →</button>
</div>
@endsection

@section('scripts')
{{-- <script src="{{ asset('js/app.js') }}"></script> --}}
<script>
document.addEventListener("DOMContentLoaded", () => {


  /* =============================
     INTERAKTIF: GEL. SINUS & BEDAF FASE
     ============================= */

  const canvas = document.getElementById("waveCanvas");
  if (!canvas) return; // JIKA HALAMAN TIDAK PUNYA CANVAS → STOP DI SINI

  const ctx = canvas.getContext("2d");

  const W = canvas.width;
  const H = canvas.height;

  const lambdaPx = 180;
  const A = 45;
  const baseY = H / 2;
  const xA = 80;

  const sliderDx = document.getElementById("sliderDx");
  const infoDx = document.getElementById("infoDx");
  const infoPhiDeg = document.getElementById("infoPhiDeg");
  const infoPhiRad = document.getElementById("infoPhiRad");
  const infoKategori = document.getElementById("infoKategori");

  let tAnim = 0;

  function drawBackground() {
    ctx.fillStyle = "#ffffff";
    ctx.fillRect(0, 0, W, H);

    ctx.strokeStyle = "#e5e7eb";
    ctx.beginPath();
    ctx.moveTo(0, baseY);
    ctx.lineTo(W, baseY);
    ctx.stroke();
  }

  function drawWave(dt) {
    tAnim += dt;

    ctx.strokeStyle = "#2563eb";
    ctx.lineWidth = 2;
    ctx.beginPath();

    for (let x = 0; x <= W; x += 2) {
      const phase = 2 * Math.PI * (x / lambdaPx - tAnim * 0.3);
      const y = baseY - A * Math.sin(phase);
      x === 0 ? ctx.moveTo(x, y) : ctx.lineTo(x, y);
    }
    ctx.stroke();

    const dxLambda = parseFloat(sliderDx.value);
    const xB = xA + dxLambda * lambdaPx;

    const phaseA = 2 * Math.PI * (xA / lambdaPx - tAnim * 0.3);
    const phaseB = 2 * Math.PI * (xB / lambdaPx - tAnim * 0.3);

    const yA = baseY - A * Math.sin(phaseA);
    const yB = baseY - A * Math.sin(phaseB);

    ctx.setLineDash([4, 4]);
    ctx.strokeStyle = "#9ca3af";
    ctx.beginPath();
    ctx.moveTo(xA, 10); ctx.lineTo(xA, H - 10);
    ctx.moveTo(xB, 10); ctx.lineTo(xB, H - 10);
    ctx.stroke();
    ctx.setLineDash([]);

    ctx.fillStyle = "#16a34a";
    ctx.beginPath(); ctx.arc(xA, yA, 6, 0, Math.PI * 2); ctx.fill();

    ctx.fillStyle = "#dc2626";
    ctx.beginPath(); ctx.arc(xB, yB, 6, 0, Math.PI * 2); ctx.fill();

    ctx.fillStyle = "#111827";
    ctx.font = "14px Segoe UI";
    ctx.fillText("A", xA - 4, yA - 10);
    ctx.fillText("B", xB - 4, yB - 10);
  }

  function updateInfo() {
    const dx = parseFloat(sliderDx.value);
    const deltaPhi = 2 * Math.PI * dx;
    const deg = deltaPhi * 180 / Math.PI;

    infoDx.textContent = dx.toFixed(2).replace(".", ",") + " λ";
    infoPhiDeg.textContent = deg.toFixed(0);
    infoPhiRad.textContent = deltaPhi.toFixed(2);

    const eps = 0.25;
    const norm = deltaPhi % (2 * Math.PI);

    infoKategori.className = "badge-kategori";

    if (Math.abs(norm) < eps || Math.abs(norm - 2 * Math.PI) < eps) {
      infoKategori.textContent = "Sefase (getarannya seirama)";
      infoKategori.classList.add("badge-sefase");
    } else if (Math.abs(norm - Math.PI) < eps) {
      infoKategori.textContent = "Berlawanan fase (puncak–lembah)";
      infoKategori.classList.add("badge-berlawan");
    } else {
      infoKategori.textContent = "Beda fase biasa";
      infoKategori.classList.add("badge-biasanya");
    }
  }

  function loop() {
    drawBackground();
    drawWave(0.016);
    updateInfo();
    requestAnimationFrame(loop);
  }

  sliderDx.addEventListener("input", updateInfo);
  updateInfo();
  requestAnimationFrame(loop);

});
</script>

  <script>
    window.addEventListener("beforeunload", function () {
      kirimProgress("beda_fase_gelombang", 4);
    });
  </script>
@endsection