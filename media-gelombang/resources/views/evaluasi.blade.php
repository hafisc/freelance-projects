@extends('layouts.app')

@section('title', 'Evaluasi Akhir Materi')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/quiz.css') }}">
@endsection

@section('content')

    <div class="quiz-page">

        {{-- MODAL ATURAN --}}
        <div class="modal-overlay" id="startModal" style="display:flex;">
            <div class="modal">

                <h3>Aturan & Petunjuk Evaluasi</h3>

                <ul style="text-align:left;margin-top:10px;">
                    <li>Jumlah soal: <b>{{ count($questions) }}</b></li>
                    <li>Waktu pengerjaan: <b>{{ ceil(count($questions) / 2) }} menit</b></li>
                    <li>Pilih jawaban yang paling tepat.</li>
                    <li>Semua soal wajib dijawab.</li>
                    <li>Batas kelulusan (KKM): <b>{{ $kkm }}</b></li>
                </ul>

                <button class="btn-finish" id="startQuizBtn">
                    Mulai Evaluasi
                </button>

            </div>
        </div>


        {{-- CONTAINER QUIZ --}}
        <div class="quiz-container" id="quizWrapper" style="display:none;">

            {{-- AREA SOAL --}}
            <main class="quiz-main">

                <h1>Evaluasi Akhir</h1>

                <div class="quiz-header">

                    <h2>Evaluasi Akhir</h2>

                    <div class="timer">
                        ⏳ <span id="timer">00:00</span>
                    </div>

                </div>


                {{-- SOAL --}}
                <div class="question-box">

                    <div class="question-text" id="questionText"></div>

                    <ul class="options-list" id="optionsList"></ul>

                </div>


                {{-- NAVIGASI --}}
                <div class="quiz-actions">

                    <button class="btn-nav" id="prevBtn">
                        ← Sebelumnya
                    </button>

                    <button class="btn-nav" id="nextBtn">
                        Berikutnya →
                    </button>

                </div>

            </main>


            <aside class="quiz-sidebar">

                <h3>Navigasi Soal</h3>

                <div class="nav-soal" id="navSoal"></div>

                <button class="btn-ragu" id="raguBtn">
                    Tandai Ragu
                </button>

                <div class="legend-vertical">
                    <br>
                    <div>
                        <span class="legend-dot legend-notyet"></span>
                        Belum dijawab
                    </div>

                    <div>
                        <span class="legend-dot legend-current"></span>
                        Sedang aktif
                    </div>

                    <div>
                        <span class="legend-dot legend-answered"></span>
                        Sudah dijawab
                    </div>

                    <div>
                        <span class="legend-dot legend-doubt"></span>
                        Ragu-ragu
                    </div><br>

                    <button class="btn-finish sidebar-finish" id="finishBtn">
                        Selesaikan Kuis
                    </button>
                </div>

            </aside>
        </div>


        {{-- MODAL HASIL --}}
        <div class="modal-overlay" id="resultModal">

            <div class="modal">

                <div id="resultIcon" style="font-size:40px;">🎉</div>

                <h3 id="resultTitle"></h3>

                <p id="resultMessage"></p>

                <button class="btn-finish" id="resultOkBtn">
                    OK
                </button>

            </div>

        </div>

        <div class="modal-overlay" id="confirmModal">

            <div class="modal">

                <div class="modal-icon">⚠️</div>

                <h3 id="confirmTitle">Konfirmasi</h3>

                <p id="confirmMessage"></p>

                <div style="margin-top:20px;display:flex;gap:10px;justify-content:center;">

                    <button class="btn-nav" id="cancelFinishBtn">
                        Cek Kembali
                    </button>

                    <button class="btn-finish" id="confirmFinishBtn">
                        Ya, Selesaikan
                    </button>

                </div>

            </div>

        </div>

    </div>

@endsection

@section('scripts')
    <script>

        const questions = @json($questions);
        const QUIZ_ID = {{ $quiz_id }};
        const KKM = {{ $kkm }};

        let currentIndex = 0;
        let userAnswers = Array(questions.length).fill(null);
        let raguRagu = Array(questions.length).fill(false);
        let startTime = null;
        let quizFinished = false;

        let timeLeft = {{ count($questions) * 30 }};
        const timerText = document.getElementById("timer");
        let timerInterval;

        function startTimer() {

            timerInterval = setInterval(() => {

                const m = Math.floor(timeLeft / 60);
                const s = timeLeft % 60;

                timerText.textContent =
                    `${m}:${s.toString().padStart(2, "0")}`;

                if (timeLeft <= 0) {
                    clearInterval(timerInterval);
                    finishQuiz(true);
                }

                timeLeft--;

            }, 1000);

        }

        /* =========================
           ELEMENT
        ========================= */
        const raguBtn = document.getElementById("raguBtn");

        const navSoal = document.getElementById("navSoal");
        const qText = document.getElementById("questionText");
        const optionsList = document.getElementById("optionsList");

        const confirmModal = document.getElementById("confirmModal");
        const confirmTitle = document.getElementById("confirmTitle");
        const confirmMessage = document.getElementById("confirmMessage");
        const confirmFinishBtn = document.getElementById("confirmFinishBtn");
        const cancelFinishBtn = document.getElementById("cancelFinishBtn");


        raguBtn.onclick = () => {

            raguRagu[currentIndex] = !raguRagu[currentIndex];

            renderNav();
            updateRaguButton();

        };

        function updateRaguButton() {

            if (raguRagu[currentIndex]) {
                raguBtn.textContent = "Batalkan Ragu";
            } else {
                raguBtn.textContent = "Tandai Ragu";
            }

        }
        /* =========================
           NAVIGASI SOAL
        ========================= */

        function renderNav() {

            navSoal.innerHTML = "";

            questions.forEach((_, i) => {

                const btn = document.createElement("button");

                btn.classList.add("nav-btn");

                if (i === currentIndex) {

                    btn.classList.add("nav-current");

                } else if (raguRagu[i]) {

                    btn.classList.add("nav-doubt");

                } else if (userAnswers[i] !== null) {

                    btn.classList.add("nav-answered");

                } else {

                    btn.classList.add("nav-notyet");

                }

                btn.textContent = i + 1;

                btn.onclick = () => {
                    currentIndex = i;
                    loadQuestion();
                };

                navSoal.appendChild(btn);

            });

        }

        /* =========================
           LOAD SOAL
        ========================= */

        function loadQuestion() {

            const q = questions[currentIndex];

            qText.textContent = q.q;

            optionsList.innerHTML = "";

            q.options.forEach((opt, i) => {

                const li = document.createElement("li");

                li.innerHTML = `
                                <label>
                                    <input type="radio" name="soal" value="${i}"
                                    ${userAnswers[currentIndex] === i ? "checked" : ""}>
                                    <span>${opt}</span>
                                </label>
                            `;

                optionsList.appendChild(li);

            });

            renderNav();
            updateRaguButton();

        }

        /* =========================
           SIMPAN JAWABAN
        ========================= */

        document.addEventListener("change", e => {

            if (e.target.name === "soal") {

                userAnswers[currentIndex] = Number(e.target.value);
                raguRagu[currentIndex] = false;

                renderNav();
                updateRaguButton();

            }

        });

        /* =========================
           NEXT / PREV
        ========================= */

        document.getElementById("nextBtn").onclick = () => {

            if (currentIndex < questions.length - 1) {
                currentIndex++;
                loadQuestion();
            }

        };

        document.getElementById("prevBtn").onclick = () => {

            if (currentIndex > 0) {
                currentIndex--;
                loadQuestion();
            }

        };

        /* =========================
           START
        ========================= */

        const startModal = document.getElementById("startModal");
        const quizWrapper = document.getElementById("quizWrapper");

        document.getElementById("startQuizBtn").onclick = () => {

            startModal.style.display = "none";
            quizWrapper.style.display = "flex";

            startTime = Date.now();

            startTimer();
            loadQuestion();

        };

        /* =========================
           FINISH
        ========================= */

        function checkBeforeFinish() {

            const raguList = [];

            raguRagu.forEach((r, i) => {
                if (r) raguList.push(i + 1);
            });

            if (raguList.length > 0) {

                confirmTitle.textContent = "Masih Ada Soal Ragu";

                confirmMessage.innerHTML =
                    `Soal nomor <b>${raguList.join(", ")}</b> masih ditandai ragu.<br>
                    Silakan cek kembali sebelum menyelesaikan evaluasi.`;

                confirmFinishBtn.style.display = "none";
                cancelFinishBtn.textContent = "OK";

                confirmModal.style.display = "flex";
                return;
            }

            const unanswered = userAnswers.includes(null);

            if (unanswered) {

                confirmTitle.textContent = "Soal Belum Lengkap";

                confirmMessage.innerHTML =
                    "Masih ada soal yang belum dijawab.<br>Silakan periksa kembali.";

                confirmFinishBtn.style.display = "none";
                cancelFinishBtn.textContent = "OK";

                confirmModal.style.display = "flex";
                return;
            }

            if (timeLeft > 0) {

                confirmTitle.textContent = "Yakin Menyelesaikan?";

                confirmMessage.innerHTML =
                    "Waktu masih tersisa.<br>Anda masih memiliki waktu untuk mengecek kembali jawaban.";

                confirmFinishBtn.style.display = "inline-block";
                cancelFinishBtn.textContent = "Cek Kembali";

                confirmModal.style.display = "flex";

            } else {

                finishQuiz();

            }
        }
        function finishQuiz(force = false) {

            if (!force && userAnswers.includes(null)) {
                alert("Masih ada soal yang belum dijawab.");
                return;
            }

            if (quizFinished) return;
            quizFinished = true;

            clearInterval(timerInterval);

            const endTime = Date.now();
            const duration = Math.floor((endTime - startTime) / 1000);

      let benar = 0;

      questions.forEach((q, i) => {
        if (+userAnswers[i] === +q.answer) {
          benar++;
        }
      });

            let salahPerTopik = {};

            questions.forEach((q, i) => {

                const topik = q.sub_topik || "gelombang";

                if (userAnswers[i] !== q.answer) {

                    if (!salahPerTopik[topik]) {
                        salahPerTopik[topik] = 0;
                    }

                    salahPerTopik[topik]++;
                }

            });

            let topikTerlemah = null;
            let maxSalah = 0;

            for (const topik in salahPerTopik) {

                if (salahPerTopik[topik] > maxSalah) {
                    maxSalah = salahPerTopik[topik];
                    topikTerlemah = topik;
                }

            }

            const nilaiPersen =
                Math.round((benar / questions.length) * 100);

            const tuntas = nilaiPersen >= KKM;

            const modal = document.getElementById("resultModal");
            const resultIcon = document.getElementById("resultIcon");
            const resultTitle = document.getElementById("resultTitle");
            const resultMessage = document.getElementById("resultMessage");

            const resultOkBtn = document.getElementById("resultOkBtn");

            const redirectMap = {
                gelombang: "/definisi_gelombang",
                bunyi: "/pengantar_bunyi",
                cahaya: "/pengantar_cahaya"
            };

            if (tuntas) {

                resultTitle.textContent = "Tuntas!";
                resultMessage.innerHTML =
                    `Nilai kamu: <b>${nilaiPersen}</b>`;

                resultOkBtn.onclick = () => {
                    window.location.href = "/dashboard";
                };

            } else {

                resultTitle.textContent = "Belum Tuntas";

                resultMessage.innerHTML =
                    `Nilai kamu: <b>${nilaiPersen}</b><br>
                                                     KKM: ${KKM}<br><br>
                                                     Kamu bisa meningkatkan kembali pemahaman kamu pada materi <b>${topikTerlemah}</b>.`;

                resultOkBtn.onclick = () => {

                    if (topikTerlemah && redirectMap[topikTerlemah]) {
                        window.location.href = redirectMap[topikTerlemah];
                    } else {
                        window.location.href = "/materi";
                    }

                };

            }

            modal.style.display = "flex";

            fetch("/simpan-nilai", {

                method: "POST",

                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },

                body: JSON.stringify({

                    quiz_id: QUIZ_ID,
                    answers: userAnswers,
                    questions: questions,
                    score: benar,
                    total_soal: questions.length,
                    benar: benar,
                    duration: duration

                })

            });

        }

        document.getElementById("finishBtn").onclick = checkBeforeFinish;

        confirmFinishBtn.onclick = () => {

            confirmModal.style.display = "none";
            finishQuiz();

        };

        cancelFinishBtn.onclick = () => {

            confirmModal.style.display = "none";

        };


    </script>

      <script>
    window.addEventListener("beforeunload", function () {
      kirimProgress("evaluasi", 17);
    });
  </script>
@endsection