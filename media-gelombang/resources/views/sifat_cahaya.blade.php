@extends('layouts.siswa')

@section('title', 'Sifat-Sifat Cahaya')

@section("style")
    <style>
        .soal-card {
            background: #ffffff;
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            transition: 0.2s;
        }

        .soal-card:hover {
            transform: translateY(-2px);
        }

        select {
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            margin-top: 8px;
            font-size: 14px;
        }

        .inner-nav-btn.active {
            background: #0f766e !important;
            color: #fff !important;
        }

        .next-btn {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border: none;
            color: white;
            padding: 10px 18px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
        }

        .next-btn:hover {
            opacity: 0.9;
        }
    </style>
@endsection

@section('siswa-content')

    <div class="materi-gelombang">

        {{-- ==================== KONTEN ==================== --}}
        <main class="content">

            <h1>Sifat-Sifat Cahaya</h1>

            <div class="box">

                {{-- PAGE 1 --}}
                <section id="page-lurus" class="subpage">
                    <h3>Cahaya Merambat Lurus</h3>

                    <p>
                        Salah satu sifat utama cahaya adalah <b>merambat lurus</b>. Artinya, cahaya bergerak mengikuti
                        lintasan garis lurus selama merambat pada medium yang sama dan homogen.
                    </p>

                    <p>
                        Sifat ini dapat diamati dengan mudah dalam kehidupan sehari-hari. Ketika cahaya berasal dari suatu
                        sumber, seperti lampu atau Matahari, cahaya tersebut akan merambat lurus hingga mengenai suatu benda
                        atau penghalang.
                    </p>

                    <div class="box-diff">
                        <b>Inti konsep:</b><br>
                        Cahaya akan merambat lurus selama tidak mengalami pemantulan, pembiasan, atau hamburan.
                    </div>

                    <!-- ====================
                                                                                        CONTOH DALAM KEHIDUPAN SEHARI-HARI
                                                                                        ==================== -->
                    <div class="example-row">

                        <!-- KIRI: TEKS -->
                        <div class="example-text">
                            <p><b>Contoh peristiwa cahaya merambat lurus:</b></p>
                            <ul>
                                <li>Terbentuknya bayangan di belakang benda yang terkena cahaya.</li>
                                <li>Berkas cahaya senter tampak lurus saat diarahkan ke depan.</li>
                                <li>Sinar Matahari yang masuk melalui celah jendela membentuk garis lurus.</li>
                            </ul>
                        </div>

                        <!-- KANAN: VISUAL -->
                        <div class="example-image">
                            <!-- Ganti src sesuai aset kamu -->
                            <img src="{{ asset('images/merambat_lurus.png') }}" alt="Pita suara manusia bergetar"
                                style="max-width:380px; width:100%; height:auto;">
                            <p class="image-caption">
                                Cahaya merambat lurus dan membentuk bayangan ketika terhalang oleh benda.
                            </p>
                        </div>

                    </div>

                    <!-- ====================
                                                                                        PENJELASAN BAYANGAN
                                                                                        ==================== -->
                    <p style="margin-top:12px;">
                        Karena cahaya merambat lurus, benda yang tidak dapat ditembus cahaya akan menghalangi rambatan
                        cahaya tersebut. Akibatnya, terbentuk daerah gelap di belakang benda yang disebut <b>bayangan</b>.
                    </p>

                    <div class="box-doff">
                        <b>Kesimpulan:</b><br>
                        Sifat cahaya merambat lurus menyebabkan terbentuknya bayangan dan menjadi dasar berbagai fenomena
                        optik dalam kehidupan sehari-hari.
                    </div>
                </section>

                {{-- PAGE 2 --}}
                <section id="page-pantul" class="subpage" style="display:none;">
                    <h3>Pemantulan Cahaya</h3>

                    <p>
                        <b>Pemantulan cahaya</b> adalah peristiwa kembalinya cahaya ke medium semula setelah mengenai suatu
                        permukaan. Pemantulan terjadi ketika cahaya mengenai benda yang tidak dapat ditembus oleh cahaya,
                        seperti cermin atau permukaan logam.
                    </p>

                    <p>
                        Arah rambat cahaya sebelum dan sesudah pemantulan mengikuti aturan tertentu yang dikenal sebagai
                        <b>hukum pemantulan cahaya</b>.
                    </p>

                    <div class="box-diff">
                        <b>Hukum pemantulan cahaya:</b>
                        <ol>
                            <li>Sinar datang, sinar pantul, dan garis normal terletak pada satu bidang datar.</li>
                            <li>Sudut datang sama dengan sudut pantul.</li>
                        </ol>
                    </div>

                    <!-- ====================
                                                                                        JENIS PEMANTULAN
                                                                                        ==================== -->
                    <p style="margin-top:12px;">
                        Berdasarkan keadaan permukaannya, pemantulan cahaya dibedakan menjadi dua jenis, yaitu pemantulan
                        teratur dan pemantulan baur.
                    </p>

                    <div class="example-row">

                        <!-- KIRI: TEKS -->
                        <div class="example-text">
                            <p><b>1. Pemantulan Teratur</b></p>
                            <p>
                                Pemantulan teratur terjadi pada permukaan yang halus dan rata, seperti cermin datar. Berkas
                                cahaya yang datang sejajar akan dipantulkan kembali secara sejajar sehingga bayangan dapat
                                terlihat jelas.
                            </p>

                            <p><b>2. Pemantulan Baur</b></p>
                            <p>
                                Pemantulan baur terjadi pada permukaan yang kasar, seperti dinding atau kertas. Cahaya
                                dipantulkan ke berbagai arah sehingga bayangan tidak terlihat jelas.
                            </p>
                        </div>

                        <!-- KANAN: VISUAL -->
                        <div class="example-image">
                            <!-- Ganti src sesuai aset kamu -->
                            <img src="{{ asset('images/pemantulan_cahaya.png') }}"
                                alt="Pemantulan teratur dan pemantulan baur"
                                style="max-width:480px; width:100%; height:auto;">
                            <p class="image-caption">
                                Perbedaan pemantulan teratur dan pemantulan baur.
                            </p>
                        </div>

                    </div>

                    <!-- ====================
                                                                                        CONTOH DALAM KEHIDUPAN SEHARI-HARI
                                                                                        ==================== -->
                    <div class="box-diff" style="margin-top:12px;">
                        <p><b>Contoh pemantulan cahaya dalam kehidupan sehari-hari:</b></p>
                        <ul>
                            <li>Melihat bayangan wajah pada cermin.</li>
                            <li>Pantulan cahaya lampu pada permukaan air yang tenang.</li>
                            <li>Cahaya senter yang dipantulkan oleh permukaan logam.</li>
                        </ul>
                    </div>

                    <div class="note-box" style="margin-top:12px;">
                        <b>Kesimpulan:</b><br>
                        Pemantulan cahaya mengikuti hukum pemantulan dan bergantung pada jenis permukaan benda yang dikenai
                        cahaya.
                    </div>
                </section>

                {{-- PAGE 3 --}}
                <section id="page-bias" class="subpage" style="display:none;">
                    <h3>Pembiasan Cahaya</h3>

                    <p>
                        <b>Pembiasan cahaya</b> adalah peristiwa <b>pembelokan arah rambat cahaya</b> ketika cahaya
                        berpindah dari satu medium ke medium lain yang memiliki kerapatan optik berbeda.
                    </p>

                    <p>
                        Pembiasan terjadi karena <b>kecepatan cahaya berbeda</b> pada setiap medium. Saat cahaya memasuki
                        medium yang berbeda, arah rambatnya akan berubah.
                    </p>

                    <div class="note-box">
                        <b>Inti konsep:</b><br>
                        Pembiasan cahaya terjadi akibat perubahan kecepatan cahaya saat berpindah medium.
                    </div>

                    <!-- ====================
                                                                                        CONTOH DALAM KEHIDUPAN SEHARI-HARI
                                                                                        ==================== -->
                    <div class="example-row">

                        <!-- KIRI: TEKS -->
                        <div class="example-text">
                            <p><b>Contoh peristiwa pembiasan cahaya:</b></p>
                            <ul>
                                <li>Pensil di dalam air tampak bengkok atau patah.</li>
                                <li>Dasar kolam renang terlihat lebih dangkal dari kedalaman sebenarnya.</li>
                                <li>Terbentuknya pelangi akibat pembiasan dan dispersi cahaya Matahari.</li>
                            </ul>
                        </div>

                        <!-- KANAN: VISUAL -->
                        <div class="example-image">
                            <!-- Ganti src sesuai aset kamu -->
                            <img src="{{ asset('images/pembiasan_cahaya.png') }}"
                                alt="Pembiasan cahaya pada batas dua medium"
                                style="max-width:480px; width:100%; height:auto;">
                            <p class="image-caption">
                                Pembiasan cahaya pada batas dua medium yang berbeda.
                            </p>
                        </div>

                    </div>

                    <!-- ====================
                                                                                        ARAH PEMBIASAN
                                                                                        ==================== -->
                    <p style="margin-top:12px;">
                        Arah pembiasan cahaya bergantung pada medium yang dimasukinya. Jika cahaya masuk ke medium yang
                        lebih rapat secara optik, cahaya akan dibiaskan mendekati garis normal. Sebaliknya, jika cahaya
                        masuk ke medium yang lebih renggang, cahaya akan dibiaskan menjauhi garis normal.
                    </p>

                    <div class="note-box">
                        <b>Kesimpulan:</b><br>
                        Pembiasan cahaya menyebabkan benda tampak tidak pada posisi sebenarnya dan menjadi dasar berbagai
                        fenomena optik.
                    </div>
                </section>

                {{-- PAGE 4 --}}
                <section id="page-dispersi" class="subpage" style="display:none;">
                    <h3>Dispersi Cahaya</h3>

                    <p>
                        <b>Dispersi cahaya</b> adalah peristiwa <b>penguraian cahaya putih</b> menjadi berbagai warna
                        penyusunnya ketika cahaya tersebut mengalami pembiasan.
                    </p>

                    <p>
                        Peristiwa dispersi terjadi karena setiap warna cahaya memiliki <b>panjang gelombang dan kecepatan
                            rambat yang berbeda</b> di dalam suatu medium. Akibatnya, setiap warna cahaya dibiaskan dengan
                        sudut yang berbeda.
                    </p>

                    <div class="note-box">
                        <b>Inti konsep:</b><br>
                        Dispersi cahaya terjadi karena perbedaan pembiasan tiap warna cahaya.
                    </div>

                    <!-- ====================
                                                                                        SPEKTRUM WARNA CAHAYA
                                                                                        ==================== -->
                    <div class="box-diff" style="margin-top:12px; text-align:center;">
                        <p><b>Spektrum cahaya tampak terdiri atas tujuh warna, yaitu:</b></p>

                        <p style="font-weight:700; letter-spacing:0.5px;">
                            <span style="color:#dc2626;">Merah</span> –
                            <span style="color:#f97316;">Jingga</span> –
                            <span style="color:#facc15;">Kuning</span> –
                            <span style="color:#22c55e;">Hijau</span> –
                            <span style="color:#2563eb;">Biru</span> –
                            <span style="color:#4f46e5;">Nila</span> –
                            <span style="color:#9333ea;">Ungu</span>
                        </p>
                    </div>


                    <!-- ====================
                                                                                        CONTOH DALAM KEHIDUPAN SEHARI-HARI
                                                                                        ==================== -->
                    <div class="example-row">

                        <!-- KIRI: TEKS -->
                        <div class="example-text">
                            <p><b>Contoh peristiwa dispersi cahaya:</b></p>
                            <ul>
                                <li>Terbentuknya pelangi setelah hujan.</li>
                                <li>Cahaya putih yang dilewatkan melalui prisma kaca.</li>
                                <li>Pantulan cahaya pada tetesan air yang menghasilkan warna-warni.</li>
                            </ul>
                        </div>

                        <!-- KANAN: VISUAL -->
                        <div class="example-image">
                            <!-- Ganti src sesuai aset kamu -->
                            <img src="{{ asset('images/dispersi_cahaya.png') }}" alt="Dispersi cahaya oleh prisma"
                                style="max-width:480px; width:100%; height:auto;">
                            <p class="image-caption">
                                Cahaya putih terurai menjadi spektrum warna saat melewati prisma.
                            </p>
                        </div>

                    </div>

                    <!-- ====================
                                                                                        KETERKAITAN DENGAN PEMBIASAN
                                                                                        ==================== -->
                    <p style="margin-top:12px;">
                        Dispersi cahaya merupakan akibat dari pembiasan cahaya. Karena setiap warna memiliki panjang
                        gelombang yang berbeda, maka sudut pembiasannya pun berbeda. Hal inilah yang menyebabkan cahaya
                        putih dapat terurai menjadi berbagai warna.
                    </p>

                    <div class="note-box">
                        <b>Kesimpulan:</b><br>
                        Dispersi cahaya menjelaskan asal-usul spektrum warna dan menjadi dasar terjadinya pelangi.
                    </div>
                </section>


                {{-- PAGE 5 --}}
                <section id="page-latihan" class="subpage" style="display:none;">
                    <h3>Latihan 3.1 – Sifat Cahaya</h3>

                    <p><b>Petunjuk:</b> Pilih jawaban yang sesuai untuk setiap peristiwa!</p>

                    <div class="latihan-box">

                        <div class="soal-card">
                            <p>1. Bayangan terbentuk di belakang benda</p>
                            <select name="q1">
                                <option value="">Pilih jawaban</option>
                                <option value="pemantulan">Pemantulan</option>
                                <option value="pembiasan">Pembiasan</option>
                                <option value="dispersi">Dispersi</option>
                                <option value="lurus">Merambat lurus</option>
                            </select>
                        </div>

                        <div class="soal-card">
                            <p>2. Cahaya mengenai cermin dan kembali</p>
                            <select name="q2">
                                <option value="">Pilih jawaban</option>
                                <option value="pemantulan">Pemantulan</option>
                                <option value="pembiasan">Pembiasan</option>
                                <option value="dispersi">Dispersi</option>
                                <option value="lurus">Merambat lurus</option>
                            </select>
                        </div>

                        <div class="soal-card">
                            <p>3. Pensil terlihat bengkok di dalam air</p>
                            <select name="q3">
                                <option value="">Pilih jawaban</option>
                                <option value="pemantulan">Pemantulan</option>
                                <option value="pembiasan">Pembiasan</option>
                                <option value="dispersi">Dispersi</option>
                                <option value="lurus">Merambat lurus</option>
                            </select>
                        </div>

                        <div class="soal-card">
                            <p>4. Pelangi muncul setelah hujan</p>
                            <select name="q4">
                                <option value="">Pilih jawaban</option>
                                <option value="pemantulan">Pemantulan</option>
                                <option value="pembiasan">Pembiasan</option>
                                <option value="dispersi">Dispersi</option>
                                <option value="lurus">Merambat lurus</option>
                            </select>
                        </div>

                        <button onclick="cekJawaban()" class="next-btn" style="margin-top:15px;">
                            Cek Jawaban
                        </button>

                        <div id="feedback" style="margin-top:15px; font-weight:bold;"></div>

                    </div>
                    <div style="margin-top:25px;">
                        <button id="download-pdf-btn" class="next-btn" style="display:none;">
                            📄 Download PDF
                        </button>
                        <form action="{{ url('/pengumpulan-gelombang') }}" method="POST" enctype="multipart/form-data"
                            style="margin-top:15px;">
                            @csrf

                            <input type="hidden" name="latihan_code" value="L31">

                            <input type="file" name="file" accept="application/pdf" required>

                            <button type="submit" class="next-btn" style="margin-top:10px;">
                                📤 Upload Jawaban
                            </button>
                        </form>
                    </div>
                </section>
            </div>

            {{-- NAV --}}
            <div class="inner-navigation">
                <button id="inner-prev" class="next-btn">Previous</button>
                <button class="next-btn inner-nav-btn" data-target="page-lurus">1</button>
                <button class="next-btn inner-nav-btn" data-target="page-pantul">2</button>
                <button class="next-btn inner-nav-btn" data-target="page-bias">3</button>
                <button class="next-btn inner-nav-btn" data-target="page-dispersi">4</button>
                <button class="next-btn inner-nav-btn" data-target="page-latihan">5</button>
                <button id="inner-next" class="next-btn">Next</button>
            </div>

            <button class="next-btn" onclick="location.href='{{ url('pengantar_cahaya') }}'">← Materi Sebelumnya</button>
            <button class="next-btn" onclick="location.href='{{ url('spektrum_cahaya') }}'">Materi Selanjutnya →</button>

        </main>
    </div>

@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const pages = document.querySelectorAll(".subpage");
            const btns = document.querySelectorAll(".inner-nav-btn");
            const prev = document.getElementById("inner-prev");
            const next = document.getElementById("inner-next");

            const order = ["page-lurus", "page-pantul", "page-bias", "page-dispersi", "page-latihan"];
            let idx = 0;

            function show(id) {
                pages.forEach(p => p.style.display = p.id === id ? "block" : "none");
                btns.forEach(b => {
                    b.classList.remove("active");

                    if (b.dataset.target === id) {
                        b.classList.add("active");
                    }
                });
                idx = order.indexOf(id);
                prev.disabled = idx === 0;
                next.disabled = idx === order.length - 1;
            }

            btns.forEach(b => b.onclick = () => show(b.dataset.target));
            prev.onclick = () => idx > 0 && show(order[idx - 1]);
            next.onclick = () => idx < order.length - 1 && show(order[idx + 1]);
            show(order[0]);
        });
    </script>

    <script>
        window.addEventListener("beforeunload", function () {
            kirimProgress("sifat_cahaya", 13);
        });
    </script>

    <script>
        const namaSiswa = "{{ auth()->user()->name }}";
        const nisnSiswa = "{{ auth()->user()->nisn ?? '000000' }}";
    </script>

    <script>
        function cekJawaban() {
            const kunci = {
                q1: "lurus",
                q2: "pemantulan",
                q3: "pembiasan",
                q4: "dispersi"
            };

            window.skor = 0;
            window.total = 4;

            for (let i = 1; i <= total; i++) {
                const select = document.querySelector(`[name="q${i}"]`);
                const user = select.value;

                if (user === "") {
                    alert("Semua soal harus dijawab dulu ya!");
                    return;
                }

                if (user === kunci[`q${i}`]) {
                    skor++;
                    select.style.border = "2px solid green";
                } else {
                    select.style.border = "2px solid red";
                }
            }

            const feedback = document.getElementById("feedback");

            feedback.innerHTML = `Skor kamu: ${skor} / ${total}`;

            if (skor === total) {
                feedback.style.color = "green";
                feedback.innerHTML = `🎉 Skor kamu: ${skor}/${total}<br>Hebat! Semua benar!`;
            } else {
                feedback.style.color = "orange";
                feedback.innerHTML = `Skor kamu: ${skor}/${total}<br>Masih bisa diperbaiki ya 💪`;
            }

            document.getElementById("download-pdf-btn").style.display = "inline-block";
            document.getElementById("download-pdf-btn").addEventListener("click", () => {

                const { jsPDF } = window.jspdf;
                const pdf = new jsPDF();

                let y = 20;

                // ===== JUDUL =====
                pdf.setFontSize(16);
                pdf.text("HASIL LATIHAN SIFAT CAHAYA", 105, y, { align: "center" });
                y += 10;

                pdf.setLineWidth(0.5);
                pdf.line(20, y, 190, y);
                y += 10;

                // ===== DATA SISWA =====
                pdf.setFontSize(11);
                pdf.text(`Nama  : ${namaSiswa}`, 20, y);
                y += 7;
                pdf.text(`NISN  : ${nisnSiswa}`, 20, y);
                y += 7;
                pdf.text(`Skor  : ${window.skor} / ${window.total}`, 20, y);
                y += 10;

                pdf.line(20, y, 190, y);
                y += 10;

                // ===== JAWABAN =====
                for (let i = 1; i <= 4; i++) {
                    const select = document.querySelector(`[name="q${i}"]`);
                    const jawaban = select.value || "-";

                    pdf.text(`${i}. Jawaban: ${jawaban}`, 20, y);
                    y += 8;
                }

                y += 5;

                pdf.line(20, y, 190, y);
                y += 10;

                // ===== FOOTER =====
                pdf.setFontSize(10);
                pdf.text("Generated by FisiTera", 105, y, { align: "center" });

                pdf.save("hasil_latihan_sifat_cahaya.pdf");
            });
            document.querySelector("form").style.display = "block";
        }
        document.querySelectorAll("select").forEach(s => {
            s.addEventListener("change", () => {
                s.style.border = "1px solid #ccc";
            });
        });
    </script>
@endsection