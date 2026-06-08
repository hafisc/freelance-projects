@extends('layouts.guru')

@section('title', 'Data Nilai Siswa')

@section('style')
    <style>
        .soal-grid {
            display: grid;
            grid-template-columns: repeat(10, 40px);
            gap: 8px;
            justify-content: center;
            overflow: visible;
        }

        .detail-modal table {
            overflow: visible;
        }

        .soal-box {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
        }

        .soal-box.correct {
            background: #22c55e;
        }

        .soal-box.wrong {
            background: #ef4444;
        }

        .detail-modal table {
            width: 100%;
            table-layout: fixed;
        }

        .detail-modal table {
            width: 100%;
            border-collapse: collapse;
        }

        .detail-modal th,
        .detail-modal td {
            text-align: center;
            vertical-align: middle;
            padding: 10px;
            overflow: visible;
        }

        .detail-modal th:nth-child(5),
        .detail-modal td:nth-child(5) {
            width: 420px;
        }

        .soal-grid {
            display: grid;
            grid-template-columns: repeat(10, 34px);
            gap: 6px;
            justify-content: center;
        }

        .soal-box {
            width: 34px;
            height: 34px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 600;
            color: white;
        }

        .detail-modal {
            width: 95%;
            max-width: 1200px;
            overflow: visible !important;
        }

        .detail-modal tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        .detail-modal td:nth-child(6) {
            white-space: nowrap;
            font-size: 13px;
        }

        .kkm-box {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .kkm-box input {
            width: 80px;
        }

        .soal-box {
            position: relative;
            cursor: pointer;
            overflow: visible;
        }

        .tooltip-jawaban {
            position: absolute;
            top: 50%;
            left: 110%;
            transform: translateY(-50%);
            background: #1e293b;
            color: white;
            padding: 10px 12px;
            border-radius: 6px;
            font-size: 12px;
            width: 320px;
            max-width: 320px;
            line-height: 1.4;
            text-align: left;
            display: none;
            z-index: 9999;
            opacity: 0;
            transition: opacity .2s ease;
            white-space: normal;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .tooltip-jawaban b {
            color: #38bdf8;
        }

        .soal-box:hover .tooltip-jawaban {
            display: block;
            opacity: 1;
        }

        @media (min-width: 769px) {
            .table-wrapper {
                overflow: visible !important;
            }
        }
    </style>
@endsection

@section('guru-content')


    {{-- CONTENT --}}
    <main class="guru-content">

        {{-- @if(session('success'))
        <script>
            alert("{{ session('success') }}");
        </script>
        @endif --}}

        <h1>Data Nilai Siswa</h1>

        <div class="kkm-box">

            <form method="POST" action="{{ route('guru.updateKKM') }}" class="kkm-form">
                @csrf

                <input type="hidden" name="quiz_id" id="quizIdInput" value="1">

                <label id="kkmLabel" style="font-size:13px;font-weight:600;">
                    KKM Kuis Gelombang
                </label>

                <input type="number" id="kkmInput" name="kkm" min="0" max="100" required
                    value="{{ $quizzes->first()->kkm ?? 70 }}">

                <button type="button" class="btn" onclick="confirmKKM()">
                    Update KKM
                </button>

            </form>

        </div>
        {{-- FILTER KUIS --}}
        <div class="quiz-filter-wrapper">

            <div class="quiz-filter">
                <button class="quiz-btn active" onclick="showQuiz(1, this)">Kuis Gelombang</button>
                <button class="quiz-btn" onclick="showQuiz(2, this)">Kuis Bunyi</button>
                <button class="quiz-btn" onclick="showQuiz(3, this)">Kuis Cahaya</button>
                <button class="quiz-btn" onclick="showQuiz(4, this)">Evaluasi</button>
            </div>

            <div class="export-dropdown">
                <button class="btn-export-main" onclick="toggleExportMenu()">
                    Export ▼
                </button>

                <div class="export-menu" id="exportMenu">
                    <a href="/export-nilai">Semua Data</a>
                    <a href="/export-nilai?mode=best">Nilai Tertinggi</a>
                    <hr>
                    <a href="/export-nilai?quiz_id=1">Kuis Gelombang</a>
                    <a href="/export-nilai?quiz_id=2">Kuis Bunyi</a>
                    <a href="/export-nilai?quiz_id=3">Kuis Cahaya</a>
                    <hr>
                    <a href="/export-nilai?quiz_id=1&mode=best">
                        Gelombang (Nilai Tertinggi)
                    </a>
                </div>
            </div>

        </div>


        {{-- TABEL --}}
        <div class="table-wrapper">

            <table id="tabelNilai" class="display">
                <thead>
                    <tr>
                        <th>Nama Siswa</th>
                        <th>Kuis</th>
                        <th>Nilai Tertinggi</th>
                        <th>Status</th>
                        <th>Percobaan</th>
                        <th>Detail</th>
                    </tr>
                </thead>

                @foreach([1, 2, 3, 4] as $quizId)
                    <tbody class="quiz-group" id="quiz-{{ $quizId }}" style="{{ $quizId != 1 ? 'display:none;' : '' }}">

                        @foreach($nilai as $index => $n)
                            @if($n->quiz_id == $quizId)
                                <tr>
                                    <td>{{ optional($n->user)->name ?? '-' }}</td>
                                    <td>{{ $n->quiz->title }}</td>
                                    <td><b>{{ $n->score }}</b></td>

                                    <td>
                                        @if($n->score >= $n->quiz->kkm)
                                            <span class="status-tuntas">Tuntas</span>
                                        @else
                                            <span class="status-belum"><b>Belum Tuntas</b></span>
                                        @endif
                                    </td>

                                    <td>{{ $n->total_attempt }}</td>

                                    <td>
                                        <button class="btn" onclick='openDetail(@json($n->detail))'>
                                            Detail
                                        </button>

                                    </td>
                                </tr>
                            @endif
                        @endforeach

                    </tbody>
                @endforeach

            </table>

            {{-- MODAL DETAIL --}}
            <div id="detailModal" class="modal-overlay" style="display:none;">
                <div class="modal detail-modal">

                    <h3>Detail Percobaan</h3>

                    <button class="btn-delete-all" id="dropAllBtn">
                        Drop Semua
                    </button>

                    <table>
                        <thead>
                            <tr>
                                <th>Percobaan</th>
                                <th>Nilai</th>
                                <th>Benar</th>
                                <th>Waktu</th>
                                <th>Soal</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="detailContent">
                            {{-- diisi JS --}}
                        </tbody>
                    </table>

                    <br>
                    <button class="btn" onclick="closeDetail()">Tutup</button>

                </div>
            </div>

            <!-- UNIVERSAL ALERT MODAL -->
            <div id="actionModal" class="modal-overlay" style="display:none;">
                <div class="modal alert-box" id="actionBox">

                    <div id="actionIcon" class="alert-icon">✔</div>

                    <h3 id="actionTitle">Berhasil</h3>
                    <p id="actionMessage"></p>

                    <div id="actionButtons"></div>

                </div>
            </div>



        </div>

    </main>


@endsection
@section('scripts')
    <script>

        let currentUser = null;
        let currentQuiz = null;

        window.showQuiz = function (id, el) {

            document.querySelectorAll('.quiz-group')
                .forEach(g => g.style.display = 'none');

            document.getElementById('quiz-' + id)
                .style.display = 'table-row-group';

            document.querySelectorAll('.quiz-btn')
                .forEach(btn => btn.classList.remove('active'));

            el.classList.add('active');

            // update hidden quiz_id
            document.getElementById('quizIdInput').value = id;

            // update KKM value
            if (kkmData[id] !== undefined) {
                document.getElementById('kkmInput').value = kkmData[id];
            }

            const labelMap = {
                1: "KKM Kuis Gelombang",
                2: "KKM Kuis Bunyi",
                3: "KKM Kuis Cahaya",
                4: "KKM Evaluasi"
            };

            document.getElementById('kkmLabel').innerText = labelMap[id];

        }



    </script>
    <script>
        window.openDetail = function (details) {

            const tbody = document.getElementById('detailContent');
            tbody.innerHTML = '';

            if (!details.length) return;

            // 🔥 SIMPAN USER & QUIZ GLOBAL
            currentUser = details[0].user_id;
            currentQuiz = details[0].quiz_id;

            details.forEach((d, index) => {

                const durasi = d.duration ?? 0;
                const menit = Math.floor(durasi / 60);
                const detik = durasi % 60;

                const answers = d.answers || [];

                console.log("DETAIL", d);
                console.log("ANSWERS", answers);

                answers.forEach((a, i) => {
                    console.log(
                        "Soal", i + 1,
                        "answer =", a.answer,
                        "correct =", a.correct_answer,
                        "is_correct =", a.is_correct,
                        "type =", typeof a.is_correct
                    );
                });

                // hitung jumlah benar
                const benar = answers.filter(
                    a => Number(a.is_correct) === 1
                ).length;

                let soalHtml = `<div class="soal-grid">`;

                answers.forEach((a, i) => {

                    const soal = a.question ?? '-';

                    const A = a.option_a ?? '-';
                    const B = a.option_b ?? '-';
                    const C = a.option_c ?? '-';
                    const D = a.option_d ?? '-';
                    const E = a.option_e ?? '-';

                    const jawaban = optionToLetter(a.answer);
                    const kunci = optionToLetter(a.correct_answer);

                    soalHtml += `
                    <div class="soal-box ${Number(a.is_correct) === 1 ? 'correct' : 'wrong'}">
                        ${i + 1}

                <div class="tooltip-jawaban">

                <b>Soal ${i + 1}</b><br>
                ${soal}<br><br>

                A. ${A}<br>
                B. ${B}<br>
                C. ${C}<br>
                D. ${D}<br>
                E. ${E}<br><br>

                <b>Jawaban siswa :</b> ${jawaban}<br>
                <b>Kunci :</b> ${kunci}

                </div>

                    </div>
                `;
                });

                soalHtml += `</div>`;

                tbody.innerHTML += `
                                            <tr>
                                                <td>${index + 1}</td>
                                                <td>${d.score}</td>
                                                <td><b>${benar}</b></td>
                                                <td>${menit}m ${detik}s</td>
                                                <td>${soalHtml}</td>
                                                <td>${new Date(d.created_at).toLocaleString('id-ID')}</td>
                                                <td>
                                                    <button class="btn-delete" onclick="deleteAttempt(${d.id})">
                                                        X
                                                    </button>
                                                </td>
                                            </tr>
                                        `;
            });

            document.getElementById('detailModal').style.display = 'flex';
        }

        document.getElementById('dropAllBtn').onclick = function () {

            if (!currentUser || !currentQuiz) return;

            deleteAll(currentUser, currentQuiz);
        };

        window.closeDetail = function () {
            document.getElementById('detailModal').style.display = 'none';
        }

        window.deleteAttempt = function (id) {

            showModal(
                'warning',
                'Konfirmasi Hapus',
                'Apakah yakin ingin menghapus percobaan ini?',
                `
                                            <button class="btn-delete" onclick="processDeleteAttempt(${id})">
                                                Ya, Hapus
                                            </button>
                                            <button class="btn" onclick="closeActionModal()">Batal</button>
                                            `
            );
        }

        function processDeleteAttempt(id) {

            fetch(`/nilai/${id}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    "Accept": "application/json"
                }
            })
                .then(() => {
                    showModal(
                        'danger',
                        'Berhasil Dihapus',
                        'Data percobaan berhasil dihapus.',
                        `<button class="btn" onclick="location.reload()">OK</button>`
                    );
                });
        }

        window.deleteAll = function (user, quiz) {

            showModal(
                'warning',
                'Konfirmasi Hapus Semua',
                'Apakah yakin ingin menghapus SEMUA percobaan siswa ini?',
                `
                                            <button class="btn-delete" onclick="processDeleteAll(${user}, ${quiz})">
                                                Ya, Hapus Semua
                                            </button>
                                            <button class="btn" onclick="closeActionModal()">Batal</button>
                                             `
            );
        }

        function processDeleteAll(user, quiz) {

            fetch(`/nilai/${user}/${quiz}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                }
            })
                .then(() => {
                    showModal(
                        'danger',
                        'Semua Data Dihapus',
                        'Semua percobaan berhasil dihapus.',
                        `<button class="btn" onclick="location.reload()">OK</button>`
                    );
                });
        }

        window.toggleExportMenu = function () {
            const menu = document.getElementById('exportMenu');
            menu.style.display =
                menu.style.display === 'block' ? 'none' : 'block';
        }

        // klik luar = tutup dropdown
        document.addEventListener('click', function (e) {
            if (!e.target.closest('.export-dropdown')) {
                document.getElementById('exportMenu').style.display = 'none';
            }
        });

    </script>

    <script>
        const kkmData = {
            @foreach($quizzes as $quiz)
                {{ $quiz->id }}: {{ $quiz->kkm }},
            @endforeach
                                                              };

        function showModal(type, title, message, buttonsHtml) {

            const icon = document.getElementById('actionIcon');
            const box = document.getElementById('actionBox');

            if (type === 'success') {
                icon.innerHTML = "✔";
                icon.className = "alert-icon success-icon";
            }

            if (type === 'warning') {
                icon.innerHTML = "⚠";
                icon.className = "alert-icon warning-icon";
            }

            if (type === 'danger') {
                icon.innerHTML = "✖";
                icon.className = "alert-icon danger-icon";
            }

            document.getElementById('actionTitle').innerText = title;
            document.getElementById('actionMessage').innerHTML = message;
            document.getElementById('actionButtons').innerHTML = buttonsHtml;

            document.getElementById('actionModal').style.display = 'flex';
        }

        function closeActionModal() {
            document.getElementById('actionModal').style.display = 'none';
        }

        function confirmKKM() {

            showModal(
                'warning',
                'Konfirmasi Perubahan',
                'Apakah yakin ingin mengubah nilai KKM?',
                `
                                            <button class="btn" onclick="submitKKM()">Ya, Update</button>
                                            <button class="btn-delete" onclick="closeActionModal()">Batal</button>
                                            `
            );
        }

        function submitKKM() {
            document.querySelector('.kkm-form').submit();
        }
    </script>
    <script>
        $(document).ready(function () {

            $('#tabelNilai').DataTable({
                pageLength: 10,
                lengthMenu: [10, 25, 50],
                order: [[2, 'desc']], // sort berdasarkan nilai tertinggi

                language: {
                    search: "Cari siswa:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    paginate: {
                        next: "Next",
                        previous: "Prev"
                    }
                }

            });

        });

        function optionToLetter(index) {
            const map = ['A', 'B', 'C', 'D', 'E'];
            return map[index] ?? '-';
        }
    </script>
@endsection