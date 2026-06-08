@extends('layouts.siswa')

@section('title', 'Jenis-Jenis Gelombang')

@section('style')
    <style>
        .modal-lks {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);

            display: none;

            justify-content: center;

            align-items: flex-start;

            overflow-y: auto;

            padding: 30px 0;

            z-index: 9999;
        }


        .tabel-lks {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            border-radius: 12px;
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
            width: 58%;
        }

        .tabel-lks th:nth-child(3),
        .tabel-lks td:nth-child(3) {
            width: 28%;
        }

        /* HEADER */

        .tabel-lks th {
            background: #2563eb;
            color: white;
            padding: 14px;
            text-align: center;
            font-size: 16px;
        }

        /* ISI */

        .tabel-lks td {
            background: #dbeafe;
            padding: 16px;
            vertical-align: middle;
            line-height: 1.6;
            word-wrap: break-word;
        }

        /* SELANG SELING */

        .tabel-lks tr:nth-child(even) td {
            background: #bfdbfe;
        }

        /* SELECT */

        .tabel-lks select {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #94a3b8;
            font-size: 14px;
            background: white;
        }

        /* RESPONSIVE */

        @media (max-width: 768px) {

            .tabel-lks {
                font-size: 13px;
            }

            .tabel-lks th,
            .tabel-lks td {
                padding: 10px;
            }

            .tabel-lks th:nth-child(1),
            .tabel-lks td:nth-child(1) {
                width: 50px;
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

        /* =========================
                                                                                                                                       AREA PDF (LKS CETAK)
                                                                                                                                    ========================= */
        #area-pdf {
            background: white;
            padding: 30px;
            color: black;
        }

        #area-pdf h2 {
            text-align: center;
            margin-bottom: 20px;
        }


        /* =========================
                                                                                       LKS ACTION LAYOUT
                                                                                    ========================= */

        .lks-actions {
            margin-top: 30px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* tombol cek jawaban */
        .action-top {
            text-align: center;
        }

        /* area download + upload */
        .action-middle {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        /* tombol tutup */
        .action-bottom {
            text-align: center;
        }

        /* file input biar rapi */
        #file-lks {
            padding: 6px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            background: #f8fafc;
        }

        .lks-kesimpulan {
            margin-top: 25px;
        }

        .lks-kesimpulan textarea {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 10px;
            resize: none;
            font-family: inherit;
        }

        .lks-kesimpulan textarea:focus {
            outline: none;
            border-color: #2563eb;
        }

        .hover-info {
            position: relative;
            cursor: pointer;
        }

        .hover-info::after {
            content: attr(data-info);
            position: absolute;
            bottom: 120%;
            left: 50%;
            transform: translateX(-50%);
            background: #1e293b;
            color: #fff;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 12px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: 0.2s;
            z-index: 999;
        }

        .hover-info:hover::after {
            opacity: 1;
        }

        .hover-info::before {
            content: "";
            position: absolute;
            bottom: 110%;
            left: 50%;
            transform: translateX(-50%);
            border-width: 6px;
            border-style: solid;
            border-color: #1e293b transparent transparent transparent;
            opacity: 0;
            transition: 0.2s;
        }

        .hover-info:hover::before {
            opacity: 1;
        }

        /* =========================
                                           PETUNJUK LKS
                                        ========================= */

        .petunjuk-lks {
            background: #eff6ff;
            border-left: 5px solid #2563eb;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
        }

        .petunjuk-lks h3 {
            margin-bottom: 10px;
            color: #1e3a8a;
        }

        .petunjuk-lks ol {
            padding-left: 20px;
            line-height: 1.8;
        }

        /* =========================
                                           MODAL RESPONSIVE
                                        ========================= */

        .modal-lks-content {
            width: 95%;
            max-width: 950px;

            border-radius: 16px;

            margin-bottom: 30px;
        }

        #area-pdf {
            border-radius: 12px;
        }

        /* IDENTITAS */

        .identitas {
            border: 2px solid #cbd5e1;
            border-radius: 12px;
            padding: 16px;
            width: 350px;
            background: #f8fafc;
            line-height: 1.8;
            font-size: 18px;
        }

        /* RESPONSIVE */

        @media (max-width: 768px) {

            .tabel-lks {
                font-size: 13px;
            }

            .tabel-lks th,
            .tabel-lks td {
                padding: 10px;
            }

            .identitas {
                width: 100%;
                font-size: 15px;
            }

        }
    </style>
@endsection

@section('siswa-content')

    <div class="materi-gelombang">


        <main class="content">
            <h2>Fenomena & Aplikasi Bunyi</h2>

            <div class="box">


                {{-- HALAMAN 1 – PENGERTIAN GEMA --}}

                <section id="page-intro" class="subpage materi">

                    <header class="materi-header">
                        <h2>Pengertian Gema</h2>
                    </header>

                    <figure class="materi-gambar">
                        <img src="{{ asset('images/gambar-gema.png') }}" alt="Ilustrasi terjadinya gema"
                            style="width: 500px; height: 260px;">
                        <figcaption>Ilustrasi bunyi pantul yang menyebabkan gema</figcaption>
                    </figure>

                    <div class="materi-deskripsi">
                        <p>
                            <strong>Gema</strong> adalah bunyi pantul yang terdengar kembali
                            <strong>setelah bunyi asli selesai terdengar</strong>.
                            Gema terjadi ketika gelombang bunyi mengenai permukaan keras,
                            lalu dipantulkan kembali ke telinga pendengar dengan jeda waktu tertentu.
                        </p>

                        <p>
                            Agar gema dapat terdengar jelas, bunyi pantul harus sampai ke telinga
                            minimal <strong>0,1 detik</strong> setelah bunyi asli.
                            Jika jeda waktunya terlalu singkat, bunyi pantul tidak terdengar sebagai gema.
                        </p>
                    </div>

                    <div class="materi-dua-kolom">
                        <div class="kolom">
                            <h3>Ciri-Ciri Gema</h3>
                            <ul>
                                <li>Bunyi terdengar dua kali atau lebih</li>
                                <li>Bunyi pantul terdengar terpisah dari bunyi asli</li>
                                <li>Terjadi di tempat yang luas dan memiliki bidang pantul keras</li>
                            </ul>
                        </div>

                        <div class="kolom">
                            <h3>Syarat Terjadinya Gema</h3>
                            <ul>
                                <li>Terdapat bidang pemantul seperti dinding, tebing, atau gunung</li>
                                <li>Jarak sumber bunyi ke bidang pantul cukup jauh</li>
                                <li>Bunyi merambat melalui suatu medium, biasanya udara</li>
                            </ul>
                        </div>
                    </div>

                </section>


                {{-- HALAMAN 2 – GEMA & GAUNG --}}
                <section id="page-gema" class="subpage materi" style="display:none;">

                    <header class="materi-header">
                        <h2>Gema dan Gaung</h2>
                    </header>

                    <div class="latihan-tabs-wrapper">

                        <!-- TAB HEADER -->
                        <div class="latihan-tabs-header">
                            <button class="latihan-tab-btn latihan-tab-active" data-target="gema-materi">
                                Materi
                            </button>
                            <button class="latihan-tab-btn" data-target="gema-latihan1">
                                Latihan 1
                            </button>
                            <button class="latihan-tab-btn" data-target="gema-latihan2">
                                Latihan 2
                            </button>
                        </div>

                        <!-- ================= MATERI ================= -->
                        <div id="gema-materi" class="latihan-tab-page latihan-tab-page-active">

                            <!-- ================= PENGANTAR ================= -->
                            <p>
                                Ketika bunyi mengenai permukaan keras seperti dinding,
                                tebing, atau gunung, bunyi tersebut akan dipantulkan kembali.
                                Bunyi pantul inilah yang menyebabkan kita dapat mendengar
                                <b>gema</b> atau <b>gaung</b>.
                            </p>

                            <div class="box-diff">
                                <b>Gema</b> terdengar jelas karena bunyi pantul datang
                                setelah bunyi asli selesai.<br>
                                <b>Gaung</b> terjadi ketika bunyi pantul datang hampir
                                bersamaan dengan bunyi asli sehingga bunyi terdengar tidak jelas.
                            </div>

                            <!-- ================= PERBEDAAN ================= -->
                            <div class="materi-dua-kolom" style="margin-top:16px;">

                                <div class="kolom">
                                    <h3>Gema</h3>
                                    <ul>
                                        <li>Bunyi terdengar ulang dengan jelas</li>
                                        <li>Ada jeda waktu dengan bunyi asli</li>
                                        <li>Terjadi di tempat terbuka</li>
                                        <li>Contoh: gua, tebing</li>
                                    </ul>
                                </div>

                                <div class="kolom">
                                    <h3>Gaung</h3>
                                    <ul>
                                        <li>Bunyi bercampur dengan bunyi asli</li>
                                        <li>Tidak ada jeda waktu jelas</li>
                                        <li>Terjadi di ruangan besar</li>
                                        <li>Contoh: aula, gedung kosong</li>
                                    </ul>
                                </div>

                            </div>

                            <!-- ================= KONSEP FISIKA ================= -->
                            <div class="box-diff" style="margin-top:18px;">
                                Bunyi pantul dapat digunakan untuk menentukan jarak suatu benda.
                                Karena bunyi menempuh perjalanan pergi dan kembali,
                                maka jarak dihitung dengan rumus:
                                <br><br>
                                <b>s = v × t / 2</b>
                                <br><br>
                                Keterangan:<br>
                                s = jarak (meter)<br>
                                v = cepat rambat bunyi (m/s)<br>
                                t = waktu bunyi pergi dan kembali (detik)
                            </div>

                            <!-- ================= SIMULASI ================= -->
                            <div class="interaktif-box" style="margin-top:20px;">
                                <h4>Simulasi Gema (Interaktif)</h4>

                                <p>
                                    Aktifkan mikrofon lalu berbicaralah.
                                    Nyalakan gema untuk merasakan perbedaan bunyi asli
                                    dan bunyi pantul seperti di dalam gua.
                                </p>

                                <button class="next-btn" id="btn-mic">Aktifkan Mikrofon</button>
                                <button class="next-btn" id="btn-echo">Gema OFF</button>

                                <canvas id="waveCanvas" width="500" height="150"
                                    style="margin-top:12px; background:#ffffff; border-radius:8px;">
                                </canvas>

                                <p style="font-size:0.8rem; text-align:center; margin-top:6px;">
                                    Visualisasi gelombang bunyi dari suara kamu
                                </p>
                            </div>

                        </div>

                        <!-- ================= LATIHAN 1 ================= -->
                        <div id="gema-latihan1" class="latihan-tab-page">

                            <div class="box-diff">
                                <p><b>Latihan 1 – Jarak Tebing</b></p>

                                <p>
                                    Seorang siswa mendengar gema setelah <b>2 detik</b>.
                                    Jika cepat rambat bunyi <b>340 m/s</b>,
                                    tentukan jarak siswa ke tebing.
                                </p>

                                <hr>

                                <h4>Diketahui</h4>
                                t = <input type="number" id="l1-t"> detik<br><br>
                                v = <input type="number" id="l1-v"> m/s<br><br>
                                <p id="l1-feedback" style="margin-top:10px;"></p>


                                <hr>

                                <h4>Ditanya</h4>
                                <p><b>Jarak ke tebing (s)</b></p>

                                <hr>

                                <h4>Jawaban</h4>
                                s = <input type="number" id="l1-answer"> meter<br><br>

                                <button class="next-btn" id="l1-check-answer">Cek Jawaban</button>

                            </div>

                        </div>

                        <!-- ================= LATIHAN 2 ================= -->
                        <div id="gema-latihan2" class="latihan-tab-page">

                            <div class="box-diff">
                                <p><b>Latihan 2 – SONAR</b></p>

                                <p>
                                    Bunyi pantul diterima kembali setelah <b>4 detik</b>.
                                    Jika cepat rambat bunyi di air <b>1500 m/s</b>,
                                    tentukan kedalaman laut.
                                </p>

                                <hr>

                                <h4>Diketahui</h4>
                                t = <input type="number" id="l2-t"> detik<br><br>
                                v = <input type="number" id="l2-v"> m/s<br><br>
                                <p id="l2-feedback" style="margin-top:10px;"></p>


                                <hr>

                                <h4>Ditanya</h4>
                                <p><b>Kedalaman laut (s)</b></p>

                                <hr>

                                <h4>Jawaban</h4>
                                s = <input type="number" id="l2-answer"> meter<br><br>

                                <button class="next-btn" id="l2-check-answer">Cek Jawaban</button>

                            </div>

                        </div>
                        <div style="margin-top:20px; text-align:center;">

                            <button id="gema-download-btn" class="next-btn" style="display:none;">
                                📄 Download Hasil Jawaban (PDF)
                            </button>

                            <br>
                            <p style="margin-top:10px; font-size:14px; color:#64748b;">
                                Setelah download, klik kumpulkan untuk upload jawaban.
                            </p>

                            <br>

                            <form id="gema-upload-form" action="{{ url('/pengumpulan-gelombang') }}" method="POST"
                                enctype="multipart/form-data" style="display:none;">
                                @csrf
                                <input type="hidden" name="latihan_code" value="L23">
                                <input type="file" name="file" accept="application/pdf" required>
                                <button type="submit">Upload Jawaban</button>
                            </form>

                        </div>

                    </div>
                </section>



                {{-- HALAMAN 3 – RESONANSI --}}

                <section id="page-resonansi" class="subpage materi" style="display:none;">

                    <header class="materi-header">
                        <h2>Percobaan Resonansi Bunyi</h2>
                    </header>

                    <div class="box-diff" style="margin-top:18px;">

                        <h3>Apa Itu Resonansi Bunyi?</h3>

                        <p>
                            <strong>Resonansi bunyi</strong> adalah peristiwa ikut bergetarnya suatu benda
                            karena menerima getaran dari sumber bunyi yang memiliki frekuensi sama atau hampir sama.
                        </p>

                        <p>
                            Ketika frekuensi sumber bunyi sesuai dengan frekuensi alami suatu benda,
                            getaran benda tersebut akan menjadi lebih kuat sehingga bunyi terdengar
                            lebih nyaring.
                        </p>

                        <p>
                            Dalam kehidupan sehari-hari, resonansi dapat terjadi pada gelas,
                            senar gitar, garpu tala, maupun kolom udara di dalam pipa.
                        </p>

                        <div class="note-box" style="margin-top:12px;">
                            Resonansi menyebabkan amplitudo getaran menjadi lebih besar sehingga
                            bunyi terdengar lebih jelas dan kuat.
                        </div>

                    </div>

                    <p>
                        Video berikut menunjukkan percobaan resonansi bunyi menggunakan gelas.
                        Perhatikan dengan seksama agar kamu dapat mengerjakan lembar kerja setelah video selesai.
                    </p>

                    <div style="text-align:center; margin-top:20px;">
                        <div id="player"></div>
                    </div>

                    <!-- Navigasi Video -->
                    <div style="margin-top:15px; text-align:center;">

                        <button class="next-btn" onclick="gotoVideo(0)">
                            Pendahuluan
                        </button>

                        <button class="next-btn" onclick="gotoVideo(4)">
                            Konsep Dasar
                        </button>

                        <button class="next-btn" onclick="gotoVideo(65)">
                            Alat dan Bahan
                        </button>

                        <button class="next-btn" onclick="gotoVideo(157)">
                            Percobaan ke-1
                        </button>

                        <button class="next-btn" onclick="gotoVideo(189)">
                            Percobaan ke-2
                        </button>


                        <button class="next-btn" id="btn-lks" onclick="openLKS()" disabled>
                            🔒 Kerjakan LKS
                        </button>
                    </div>

                </section>


                {{-- HALAMAN 4 – APLIKASI BUNYI --}}

                <section id="page-aplikasi" class="subpage materi" style="display:none;">

                    <header class="materi-header">
                        <h2>Aplikasi Bunyi dalam Kehidupan</h2>
                    </header>

                    <p>
                        Bunyi tidak hanya dapat didengar, tetapi juga dapat dimanfaatkan
                        dalam berbagai bidang kehidupan. Pemanfaatan bunyi umumnya
                        menggunakan prinsip <strong>pemantulan gelombang bunyi</strong>
                        dan <strong>perambatan bunyi</strong>.
                    </p>

                    <h3>SONAR</h3>
                    <p>
                        <strong>SONAR</strong> (<i>Sound Navigation and Ranging</i>) adalah
                        teknologi yang memanfaatkan bunyi pantul untuk mengetahui
                        jarak, posisi, dan bentuk benda di dalam air.
                    </p>

                    <p>
                        SONAR bekerja dengan cara memancarkan gelombang bunyi ke dalam air.
                        Gelombang tersebut akan dipantulkan kembali ketika mengenai suatu benda,
                        lalu diterima oleh alat penerima.
                    </p>

                    <ul>
                        <li>Mengukur kedalaman laut</li>
                        <li>Mendeteksi keberadaan ikan</li>
                        <li>Membantu navigasi kapal selam</li>
                    </ul>

                    <div class="box-diff">
                        <strong>Prinsip kerja SONAR:</strong><br>
                        Bunyi dipancarkan → mengenai benda → dipantulkan → diterima kembali
                    </div>

                    <h3 style="margin-top:18px;">USG</h3>
                    <p>
                        <strong>USG</strong> (<i>Ultrasonografi</i>) adalah teknologi medis
                        yang menggunakan bunyi ultrasonik untuk melihat kondisi
                        organ dalam tubuh manusia.
                    </p>

                    <p>
                        Bunyi ultrasonik memiliki frekuensi sangat tinggi sehingga
                        tidak dapat didengar oleh telinga manusia, tetapi aman
                        digunakan dalam dunia medis.
                    </p>

                    <ul>
                        <li>Pemeriksaan kehamilan</li>
                        <li>Pemeriksaan organ dalam tubuh</li>
                        <li>Mendeteksi kelainan jaringan</li>
                        <li>Aman karena tidak menggunakan radiasi</li>
                    </ul>

                    <div class="note-box">
                        USG memanfaatkan bunyi pantul dari jaringan tubuh
                        untuk membentuk gambar organ dalam.
                    </div>

                    <figure class="materi-gambar" style="margin-top:22px; text-align:center;">
                        <img src="{{ asset('images/sonar_usg_placeholder.png') }}"
                            alt="Ilustrasi pemanfaatan bunyi pada SONAR dan USG"
                            style="max-width:520px; width:100%; height:auto;">
                        <figcaption class="caption">
                            Pemanfaatan bunyi pantul dalam teknologi SONAR dan USG
                        </figcaption>
                    </figure>

                </section>


                {{-- HALAMAN 5 – EFEK DOPPLER --}}

                <section id="page-doppler" class="subpage materi" style="display:none;">

                    <header class="materi-header">
                        <h2>Efek Doppler</h2>
                    </header>

                    <p>
                        <strong>Efek Doppler</strong> adalah peristiwa berubahnya frekuensi
                        bunyi yang terdengar akibat adanya gerak relatif antara
                        <strong>sumber bunyi</strong> dan <strong>pendengar</strong>.
                    </p>

                    <p>
                        Perubahan frekuensi ini menyebabkan bunyi yang terdengar
                        menjadi berbeda meskipun sumber bunyinya sama.
                    </p>

                    <div class="note-box">
                        Efek Doppler menyebabkan bunyi terdengar
                        <strong>lebih tinggi</strong> saat sumber bunyi mendekat dan
                        <strong>lebih rendah</strong> saat sumber bunyi menjauh.
                    </div>

                    <h3>Bagaimana Efek Doppler Terjadi?</h3>
                    <p>
                        Ketika sumber bunyi mendekati pendengar, gelombang bunyi
                        menjadi lebih rapat sehingga frekuensinya meningkat.
                        Sebaliknya, ketika sumber bunyi menjauh, gelombang bunyi
                        menjadi lebih renggang sehingga frekuensinya menurun.
                    </p>

                    <h3>Contoh Efek Doppler dalam Kehidupan Sehari-hari</h3>
                    <ul>
                        <li>Sirene ambulans atau mobil pemadam kebakaran yang melintas</li>
                        <li>Kereta api yang lewat di dekat peron</li>
                        <li>Sepeda motor yang melaju melewati pendengar</li>
                    </ul>

                    <div class="box-diff">
                        Contoh perubahan bunyi:<br>
                        Sirene mendekat → bunyi lebih tinggi<br>
                        Sirene menjauh → bunyi lebih rendah
                    </div>

                    <figure class="materi-gambar" style="margin-top:22px; text-align:center;">
                        <img src="{{ asset('images/doppler.png') }}" alt="Ilustrasi efek Doppler"
                            style="max-width:500px; width:100%; height:auto;">
                        <figcaption class="caption">
                            Perubahan frekuensi bunyi akibat gerak sumber bunyi
                        </figcaption>
                    </figure>

                </section>


            </div>

            {{-- NAVIGASI INTERNAL --}}

            <div class="inner-navigation" style="margin-top:12px; display:flex; gap:6px; flex-wrap:wrap;">

                <button id="inner-prev" class="next-btn">Previous</button>

                <button class="next-btn inner-nav-btn" data-target="page-intro">1</button>
                <button class="next-btn inner-nav-btn" data-target="page-gema">2</button>
                <button class="next-btn inner-nav-btn" data-target="page-resonansi">3</button>
                <button class="next-btn inner-nav-btn" data-target="page-aplikasi">4</button>
                <button class="next-btn inner-nav-btn" data-target="page-doppler">5</button>

                <button id="inner-next" class="next-btn">Next</button>

            </div>

            <button class="next-btn" onclick="location.href='{{ url('sumber_kar_bunyi') }}'">
                ← Materi Sebelumnya
            </button>

            <button class="next-btn" onclick="location.href='{{ url('kuis_bunyi') }}'">
                Mulai Kuis →
            </button>

        </main>
    </div>
    <div id="lksModal" class="modal-lks">

        <div class="modal-lks-content">

            <div id="area-pdf">

                <h2>LEMBAR KERJA SISWA</h2>

                <center>
                    <div class="identitas">
                        Nama: {{ auth()->user()->name }} <br>
                        NISN: {{ auth()->user()->username ?? '-' }} <br>
                        Kelas: {{ auth()->user()->kelas ?? '-' }}
                    </div>
                </center>

                <div class="petunjuk-lks">

                    <h3>Petunjuk Pengerjaan</h3>

                    <ol>
                        <li>Amati video percobaan resonansi bunyi dengan seksama.</li>
                        <li>Pilih jawaban yang paling sesuai berdasarkan hasil pengamatan.</li>
                        <li>Jawab seluruh soal sebelum menekan tombol cek jawaban.</li>
                        <li>Tuliskan kesimpulan berdasarkan hasil percobaan.</li>
                        <li>Download PDF lalu upload hasil jawaban.</li>
                    </ol>

                </div>

                <h3 style="text-align:center;">Tabel Pengamatan</h3>

                <table class="tabel-lks">
                    <tr>
                        <th>Percobaan</th>
                        <th>Kondisi</th>
                        <th>Bunyi yang Dihasilkan</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Jari menggosok bibir gelas tanpa dibasahi</td>
                        <td>
                            <select id="jawab1">
                                <option value="">--pilih jawaban--</option>
                                <option>Tidak Menghasilkan Bunyi</option>
                                <option>Bunyi Lemah</option>
                                <option>Bunyi Nyaring</option>
                                <option>Nada Lebih Rendah</option>
                                <option>Bunyi Singkat</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>Jari dibasahi lalu digosok perlahan pada bibir gelas</td>
                        <td>
                            <select id="jawab2">
                                <option value="">--pilih jawaban--</option>
                                <option>Tidak Menghasilkan Bunyi</option>
                                <option>Bunyi Lemah</option>
                                <option>Bunyi Nyaring</option>
                                <option>Nada Lebih Rendah</option>
                                <option>Bunyi Singkat</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>3</td>
                        <td>Jari dibasahi tetapi digosok terlalu cepat</td>
                        <td>
                            <select id="jawab3">
                                <option value="">--pilih jawaban--</option>
                                <option>Tidak Menghasilkan Bunyi</option>
                                <option>Bunyi Lemah</option>
                                <option>Bunyi Nyaring</option>
                                <option>Nada Lebih Rendah</option>
                                <option>Bunyi Singkat</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>4</td>
                        <td>Air di dalam gelas ditambah sehingga nada bunyi berubah lebih rendah</td>
                        <td>
                            <select id="jawab4">
                                <option value="">--pilih jawaban--</option>
                                <option>Tidak Menghasilkan Bunyi</option>
                                <option>Bunyi Lemah</option>
                                <option>Bunyi Nyaring</option>
                                <option>Nada Lebih Rendah</option>
                                <option>Bunyi Singkat</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>5</td>
                        <td>Jari terlalu kering saat menggosok bibir gelas</td>
                        <td>
                            <select id="jawab5">
                                <option value="">--pilih jawaban--</option>
                                <option>Tidak Menghasilkan Bunyi</option>
                                <option>Bunyi Lemah</option>
                                <option>Bunyi Nyaring</option>
                                <option>Nada Lebih Rendah</option>
                                <option>Bunyi Singkat</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <div class="lks-kesimpulan">

                    <h3>Kesimpulan</h3>

                    <p>
                        Tuliskan kesimpulan dari hasil pengamatan video percobaan resonansi bunyi.
                    </p>

                    <textarea id="kesimpulan-siswa" rows="5" placeholder="Tulis kesimpulan di sini..."></textarea>

                </div>

                <div class="lks-actions">

                    <div class="action-top">
                        <button class="next-btn" onclick="cekJawaban()">Cek Jawaban</button>
                    </div>

                    <div class="action-middle">
                        <button id="btn-download-lks" class="next-btn">
                            📄 Download PDF
                        </button>

                        <form action="{{ url('/pengumpulan-gelombang') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="latihan_code" value="L24">

                            <input type="file" name="file" accept="application/pdf" required>

                            <button type="submit" class="next-btn">
                                Upload Jawaban
                            </button>
                        </form>
                    </div>

                    <div class="action-bottom">
                        <button class="next-btn" onclick="closeLKS()">Tutup</button>
                    </div>

                </div>

            </div>
        </div>
@endsection
    @section('scripts')
            <script src="https://www.youtube.com/iframe_api"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    let videoSelesai = false;

                    /* =========================
                       MODAL LKS
                    ========================= */
                    const modal = document.getElementById("lksModal");

                    if (modal) {
                        modal.style.display = "none";
                    }

                    window.openLKS = function () {

                        if (!videoSelesai) {
                            alert("Selesaikan video terlebih dahulu!");
                            return;
                        }

                        if (modal) {
                            modal.style.display = "flex";
                        }

                    };


                    window.closeLKS = function () {
                        if (modal) {
                            modal.style.display = "none";
                        }
                    }


                    /* =========================
                       NAVIGASI HALAMAN
                    ========================= */
                    const pages = document.querySelectorAll(".subpage");
                    const navButtons = document.querySelectorAll(".inner-nav-btn");
                    const prevBtn = document.getElementById("inner-prev");
                    const nextBtn = document.getElementById("inner-next");

                    const order = [
                        "page-intro",
                        "page-gema",
                        "page-resonansi",
                        "page-aplikasi",
                        "page-doppler"
                    ];

                    let currentIndex = 0;

                    function showPage(id) {

                        pages.forEach(p => {
                            p.style.display = (p.id === id) ? "block" : "none";
                        });

                        navButtons.forEach(btn => {
                            const active = btn.dataset.target === id;

                            btn.style.backgroundColor = active ? "#0f766e" : "";
                            btn.style.color = active ? "#ffffff" : "";
                        });

                        currentIndex = order.indexOf(id);

                        if (prevBtn) {
                            prevBtn.disabled = currentIndex === 0;
                        }

                        if (nextBtn) {
                            nextBtn.disabled = currentIndex === order.length - 1;
                        }
                    }

                    navButtons.forEach(btn => {
                        btn.addEventListener("click", () => {
                            showPage(btn.dataset.target);
                        });
                    });

                    if (prevBtn) {
                        prevBtn.addEventListener("click", () => {
                            if (currentIndex > 0) {
                                showPage(order[currentIndex - 1]);
                            }
                        });
                    }

                    if (nextBtn) {
                        nextBtn.addEventListener("click", () => {
                            if (currentIndex < order.length - 1) {
                                showPage(order[currentIndex + 1]);
                            }
                        });
                    }

                    showPage(order[0]);


                    /* =========================
        YOUTUBE PLAYER
        ========================= */

                    let player;

                    window.onYouTubeIframeAPIReady = function () {

                        player = new YT.Player('player', {

                            width: '100%',
                            height: '500',

                            videoId: 'ICKcBdD4N9A',

                            playerVars: {
                                rel: 0,
                                modestbranding: 1
                            },

                            events: {

                                onStateChange: function (event) {

                                    if (event.data === YT.PlayerState.ENDED) {

                                        videoSelesai = true;

                                        const btnLKS = document.getElementById("btn-lks");

                                        if (btnLKS) {
                                            btnLKS.disabled = false;
                                            btnLKS.textContent = "Kerjakan LKS";
                                        }

                                        alert("Video selesai! Sekarang kamu bisa mengerjakan LKS.");
                                    }
                                }
                            }
                        });

                    };

                    window.gotoVideo = function (seconds) {

                        if (!player) return;

                        player.seekTo(seconds, true);
                        player.playVideo();

                    };


                    /* =========================
                       TAB LATIHAN
                    ========================= */

                    document.querySelectorAll(".latihan-tab-btn").forEach(btn => {

                        btn.addEventListener("click", () => {

                            const wrapper = btn.closest(".latihan-tabs-wrapper");
                            const target = btn.dataset.target;

                            wrapper.querySelectorAll(".latihan-tab-btn")
                                .forEach(b => b.classList.remove("latihan-tab-active"));

                            btn.classList.add("latihan-tab-active");

                            wrapper.querySelectorAll(".latihan-tab-page")
                                .forEach(p => p.classList.remove("latihan-tab-page-active"));

                            wrapper.querySelector("#" + target)
                                .classList.add("latihan-tab-page-active");

                        });

                    });

                    /* =========================
                       AUDIO – MIKROFON + ECHO (SCRIPT ASLI)
                    ========================= */

                    let audioContext;
                    let micStream;
                    let micSource;
                    let inputGain;

                    let delayNode;
                    let feedbackGain;
                    let echoGain;

                    let isMicOn = false;
                    let isEchoOn = false;

                    const micBtn = document.getElementById("btn-mic");
                    const echoBtn = document.getElementById("btn-echo");

                    if (micBtn) {

                        micBtn.addEventListener("click", async () => {

                            if (!isMicOn) {

                                try {

                                    micStream = await navigator.mediaDevices.getUserMedia({
                                        audio: {
                                            echoCancellation: false,
                                            noiseSuppression: false,
                                            autoGainControl: false
                                        }
                                    });

                                    audioContext = new (window.AudioContext || window.webkitAudioContext)();
                                    micSource = audioContext.createMediaStreamSource(micStream);

                                    inputGain = audioContext.createGain();
                                    inputGain.gain.value = 1.2;

                                    delayNode = audioContext.createDelay(5.0);
                                    delayNode.delayTime.value = 0.4;

                                    feedbackGain = audioContext.createGain();
                                    feedbackGain.gain.value = 0.35;

                                    echoGain = audioContext.createGain();
                                    echoGain.gain.value = 0; // echo OFF awal

                                    micSource.connect(inputGain);
                                    inputGain.connect(audioContext.destination);

                                    inputGain.connect(delayNode);
                                    delayNode.connect(feedbackGain);
                                    feedbackGain.connect(delayNode);

                                    delayNode.connect(echoGain);
                                    echoGain.connect(audioContext.destination);

                                    micBtn.textContent = "Matikan Mikrofon";
                                    echoBtn.textContent = "Gema OFF";

                                    isMicOn = true;

                                    startWaveVisual();

                                } catch (err) {

                                    alert("Mikrofon tidak dapat diakses.");

                                }

                            } else {

                                micSource.disconnect();
                                micStream.getTracks().forEach(t => t.stop());
                                audioContext.close();

                                micBtn.textContent = "Aktifkan Mikrofon";
                                echoBtn.textContent = "Gema OFF";

                                isMicOn = false;
                                isEchoOn = false;

                                stopWaveVisual();
                            }

                        });
                    }


                    if (echoBtn) {

                        echoBtn.addEventListener("click", () => {

                            if (!isMicOn) return;

                            if (!isEchoOn) {

                                echoGain.gain.value = 0.6;
                                echoBtn.textContent = "Gema ON";
                                isEchoOn = true;

                            } else {

                                echoGain.gain.value = 0;
                                echoBtn.textContent = "Gema OFF";
                                isEchoOn = false;

                            }

                        });

                    }


                    /* =========================
                       VISUAL GELOMBANG
                    ========================= */

                    const canvas = document.getElementById("waveCanvas");
                    const ctx = canvas ? canvas.getContext("2d") : null;

                    let analyser;
                    let dataArray;
                    let animationId;

                    function startWaveVisual() {

                        if (!canvas) return;

                        analyser = audioContext.createAnalyser();
                        analyser.fftSize = 2048;

                        const bufferLength = analyser.fftSize;
                        dataArray = new Uint8Array(bufferLength);

                        inputGain.connect(analyser);

                        drawWave();
                    }

                    function stopWaveVisual() {

                        if (!canvas) return;

                        cancelAnimationFrame(animationId);
                        ctx.clearRect(0, 0, canvas.width, canvas.height);
                    }

                    function drawWave() {

                        animationId = requestAnimationFrame(drawWave);

                        analyser.getByteTimeDomainData(dataArray);

                        ctx.clearRect(0, 0, canvas.width, canvas.height);

                        ctx.strokeStyle = "#e5e7eb";
                        ctx.beginPath();
                        ctx.moveTo(0, canvas.height / 2);
                        ctx.lineTo(canvas.width, canvas.height / 2);
                        ctx.stroke();

                        ctx.lineWidth = 2;
                        ctx.strokeStyle = isEchoOn ? "#dc2626" : "#2563eb";

                        ctx.beginPath();

                        const sliceWidth = canvas.width / dataArray.length;
                        let x = 0;

                        for (let i = 0; i < dataArray.length; i++) {

                            const v = dataArray[i] / 128.0;
                            const y = (v * canvas.height) / 2;

                            if (i === 0) {
                                ctx.moveTo(x, y);
                            } else {
                                ctx.lineTo(x, y);
                            }

                            x += sliceWidth;
                        }

                        ctx.lineTo(canvas.width, canvas.height / 2);
                        ctx.stroke();
                    }


                    /* =========================
                       CEK JAWABAN LKS
                    ========================= */

                    window.cekJawaban = function () {

                        let benar = 0;

                        if (document.getElementById("jawab1").value === "Tidak Menghasilkan Bunyi") {
                            benar++;
                        }

                        if (document.getElementById("jawab2").value === "Bunyi Nyaring") {
                            benar++;
                        }

                        if (document.getElementById("jawab3").value === "Bunyi Lemah") {
                            benar++;
                        }

                        if (document.getElementById("jawab4").value === "Nada Lebih Rendah") {
                            benar++;
                        }

                        if (document.getElementById("jawab5").value === "Bunyi Singkat") {
                            benar++;
                        }

                        alert("Jawaban benar: " + benar + " dari 5");
                    }

                    /* ================================
                       SISTEM HASIL GEMA (SAMA KAYAK L1.1)
                    ================================ */

                    const hasilGema = {
                        latihan1: null,
                        latihan2: null
                    };

                    const downloadBtn = document.getElementById("gema-download-btn");
                    const uploadForm = document.getElementById("gema-upload-form");

                    function cekSelesaiGema() {
                        if (hasilGema.latihan1 && hasilGema.latihan2) {
                            downloadBtn.style.display = "inline-block";
                            uploadForm.style.display = "block";
                        }
                    }


                    /* =============================
                       LATIHAN 1
                    ============================= */
                    document.getElementById("l1-check-answer")?.addEventListener("click", () => {

                        const t = document.getElementById("l1-t").value;
                        const v = document.getElementById("l1-v").value;
                        const s = parseFloat(document.getElementById("l1-answer").value);

                        const feedback = document.getElementById("l1-feedback");

                        let pesan = [];

                        if (t != 2) pesan.push("t harus 2 detik");
                        if (v != 340) pesan.push("v harus 340 m/s");

                        if (isNaN(s)) {
                            pesan.push("Isi jawaban dulu");
                        } else if (Math.abs(s - 340) > 1) {
                            pesan.push("Hasil masih salah");
                        }

                        if (pesan.length === 0) {
                            feedback.textContent = "✅ Benar! Jawaban tepat";
                            feedback.style.color = "#059669";
                        } else {
                            feedback.innerHTML = pesan.join("<br>");
                            feedback.style.color = "#dc2626";
                        }

                        hasilGema.latihan1 = {
                            judul: "Latihan 1 – Gema",
                            diketahui: `t=${t}, v=${v}`,
                            jawabanSiswa: s
                        };

                        cekSelesaiGema();
                    });

                    /* =============================
                       LATIHAN 2
                    ============================= */

                    document.getElementById("l2-check-answer")?.addEventListener("click", () => {

                        const t = document.getElementById("l2-t").value;
                        const v = document.getElementById("l2-v").value;
                        const s = parseFloat(document.getElementById("l2-answer").value);

                        const feedback = document.getElementById("l2-feedback");

                        let pesan = [];

                        if (t != 4) pesan.push("t harus 4 detik");
                        if (v != 1500) pesan.push("v harus 1500 m/s");

                        if (isNaN(s)) {
                            pesan.push("Isi jawaban dulu");
                        } else if (Math.abs(s - 3000) > 1) {
                            pesan.push("Hasil masih salah");
                        }

                        if (pesan.length === 0) {
                            feedback.textContent = "✅ Benar! Jawaban tepat";
                            feedback.style.color = "#059669";
                        } else {
                            feedback.innerHTML = pesan.join("<br>");
                            feedback.style.color = "#dc2626";
                        }

                        hasilGema.latihan2 = {
                            judul: "Latihan 2 – SONAR",
                            diketahui: `t=${t}, v=${v}`,
                            jawabanSiswa: s
                        };

                        cekSelesaiGema();
                    });
                    /* =============================
                       GENERATE PDF
                    ============================= */
                    downloadBtn?.addEventListener("click", () => {

                        const element = document.getElementById("area-pdf");

                        if (!element) {
                            alert("Area PDF tidak ditemukan!");
                            return;
                        }

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

                            pdf.save("LKS_Siswa.pdf");

                        }).catch(err => {
                            console.error(err);
                            alert("Gagal generate PDF");
                        });

                    });
                });
                /* =========================
        PDF LKS (MODAL)
        ========================= */

                const btnDownloadLKS = document.getElementById("btn-download-lks");

                btnDownloadLKS?.addEventListener("click", () => {

                    const textarea = document.getElementById("kesimpulan-siswa");

                    if (!textarea.value.trim()) {
                        alert("Isi kesimpulan dulu!");
                        return;
                    }

                    // ubah textarea jadi teks biasa sementara
                    const tempDiv = document.createElement("div");
                    tempDiv.id = "kesimpulan-cetak";
                    tempDiv.style.whiteSpace = "pre-wrap";
                    tempDiv.style.marginTop = "10px";
                    tempDiv.innerText = textarea.value;

                    textarea.style.display = "none";
                    textarea.parentNode.appendChild(tempDiv);

                    const element = document.getElementById("area-pdf");

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

                        pdf.save("LKS_Resonansi.pdf");

                        // balikin ke semula
                        textarea.style.display = "block";
                        tempDiv.remove();

                    }).catch(err => {
                        console.error(err);
                        alert("Gagal generate PDF");
                    });

                });


            </script>

            <script>
                window.addEventListener("beforeunload", function () {
                    kirimProgress("fenomena_apk_bunyi", 10);
                });
            </script>
    @endsection