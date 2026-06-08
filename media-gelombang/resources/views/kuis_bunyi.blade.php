@extends('layouts.app')

@section('title', 'Kuis Materi Bunyi')

@section('style')
  <link rel="stylesheet" href="{{ asset('css/quiz.css') }}">
@endsection

@section('content')

  <div class="quiz-page">

    {{-- MODAL ATURAN --}}
    <div class="modal-overlay" id="startModal" style="display:flex;">
      <div class="modal">
        <h3>Aturan & Petunjuk Kuis</h3>

        <ul style="text-align:left; margin-top:10px;">
          <li>Jumlah soal: <b>10</b></li>
          <li>Waktu pengerjaan: <b>10 menit</b></li>
          <li>Pilih jawaban yang paling tepat.</li>
          <li>Soal dapat dipindah lewat tombol angka.</li>

          <li>
            Warna navigasi:
            <ul>
              <li>Abu-abu: belum dijawab</li>
              <li>Biru: sedang aktif</li>
              <li>Hijau: sudah dijawab</li>
            </ul>
          </li>

          <li>Klik <b>Selesaikan Kuis</b> jika sudah selesai.</li>
        </ul>

        <button class="btn-finish" id="startQuizBtn">Mulai Kuis</button>
      </div>
    </div>

    {{-- CONTAINER QUIZ --}}
    <div class="quiz-container" id="quizWrapper" style="display:none;">

      {{-- AREA SOAL --}}
      <main class="quiz-main">

        <h1>Kuis Pemahaman Materi Bunyi</h1>

        <div class="quiz-header">
          <h2>Kuis 2: Bunyi</h2>

          <div class="timer">
            ⏳ <span id="timer">10:00</span>
          </div>
        </div>

        {{-- SOAL --}}
        <div class="question-box">
          <div class="question-text" id="questionText"></div>
          <ul class="options-list" id="optionsList"></ul>
        </div>

        {{-- NAVIGASI --}}
        <div class="quiz-actions">
          <button class="btn-nav" id="prevBtn">← Sebelumnya</button>
          <button class="btn-nav" id="nextBtn">Berikutnya →</button>
        </div>

      </main>

      {{-- SIDEBAR --}}
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

        <div class="modal-icon" id="resultIcon">🎉</div>

        <h3 id="resultTitle">Hasil</h3>

        <p id="resultMessage"></p>

        <button class="btn-finish" id="resultOkBtn">OK</button>

      </div>
    </div>

    <div class="modal-overlay" id="confirmModal">

      <div class="modal">

        <div class="modal-icon">
          ⚠️
        </div>

        <h3 id="confirmTitle">
          Konfirmasi
        </h3>

        <p id="confirmMessage"></p>

        <div style="margin-top:20px; display:flex; gap:10px; justify-content:center;">

          <button class="btn-nav" id="cancelFinishBtn">
            Cek Kembali
          </button>

          <button class="btn-finish" id="confirmFinishBtn">
            Yakin
          </button>

        </div>

      </div>

    </div>

  </div>

@endsection

@section('scripts')
  <script>

    const NEXT_PAGE = "{{ url('pengantar_cahaya') }}";
    const REVIEW_PAGE = "{{ url('konsep_perambatan_bunyi') }}";

    const questions = @json($questions);
    const QUIZ_ID = {{ $quiz_id }};

    let currentIndex = 0;
    let userAnswers = Array(questions.length).fill(null);
    let raguRagu = Array(questions.length).fill(false);
    let startTime = null;
    let quizFinished = false;


    const navSoal = document.getElementById("navSoal");
    const qText = document.getElementById("questionText");
    const optionsList = document.getElementById("optionsList");
    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");
    const finishBtn = document.getElementById("finishBtn");

    const startModal = document.getElementById("startModal");
    const startBtn = document.getElementById("startQuizBtn");
    const quizWrapper = document.getElementById("quizWrapper");

    const modal = document.getElementById("resultModal");
    const resultIcon = document.getElementById("resultIcon");
    const resultTitle = document.getElementById("resultTitle");
    const resultMessage = document.getElementById("resultMessage");
    const resultOkBtn = document.getElementById("resultOkBtn");

    const confirmModal = document.getElementById("confirmModal");
    const confirmTitle = document.getElementById("confirmTitle");
    const confirmMessage = document.getElementById("confirmMessage");
    const confirmFinishBtn = document.getElementById("confirmFinishBtn");
    const cancelFinishBtn = document.getElementById("cancelFinishBtn");

    const raguBtn = document.getElementById("raguBtn");

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

    let timeLeft = 600;
    const timerText = document.getElementById("timer");
    let timerInterval;

    function startTimer() {

      timerInterval = setInterval(() => {

        const m = Math.floor(timeLeft / 60);
        const s = timeLeft % 60;

        timerText.textContent = `${m}:${s.toString().padStart(2, "0")}`;

        if (timeLeft <= 0) {
          clearInterval(timerInterval);
          finishQuiz(true);
        }

        timeLeft--;

      }, 1000);

    }

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


    function loadQuestion() {

      const q = questions[currentIndex];

      qText.textContent = q.q;

      optionsList.innerHTML = "";

      q.options.forEach((opt, i) => {

        const li = document.createElement("li");

        li.innerHTML = `
                      <label>
                        <input type="radio" name="soal" value="${i}" ${userAnswers[currentIndex] === i ? "checked" : ""}>
                        <span>${opt}</span>
                      </label>
                    `;

        optionsList.appendChild(li);

      });

      renderNav();

      updateRaguButton();

    }

    document.addEventListener("change", e => {

      if (e.target.name === "soal") {

        userAnswers[currentIndex] = Number(e.target.value);
        raguRagu[currentIndex] = false;

        renderNav();
        updateRaguButton();

      }

    });


    nextBtn.onclick = () => {
      if (currentIndex < questions.length - 1) {
        currentIndex++;
        loadQuestion();
      }
    };

    prevBtn.onclick = () => {
      if (currentIndex > 0) {
        currentIndex--;
        loadQuestion();
      }
    };

    window.onload = () => {
      startModal.style.display = "flex";
      quizWrapper.style.display = "none";
    };

    startBtn.onclick = () => {
      startModal.style.display = "none";
      quizWrapper.style.display = "flex";
      startTime = Date.now();
      startTimer();
      loadQuestion();
    };

    async function finishQuiz(force = false) {

      if (quizFinished) return;
      quizFinished = true;

      if (!force && userAnswers.includes(null)) {
        checkBeforeFinish();
        return;
      }

      clearInterval(timerInterval);

      const endTime = Date.now();
      const duration = Math.floor((endTime - startTime) / 1000);

      let benar = 0;

      questions.forEach((q, i) => {
        if (+userAnswers[i] === +q.answer) {
          benar++;
        }
      });

      const nilaiPersen = Math.round((benar / questions.length) * 100);
      const tuntas = nilaiPersen >= 70;

      if (tuntas) {

        resultIcon.textContent = "🎉";
        resultTitle.textContent = "Tuntas!";
        resultMessage.innerHTML = `Nilai kamu: <b>${nilaiPersen}</b><br>Kamu boleh lanjut.`;

        resultOkBtn.textContent = "Lanjut Materi";
        resultOkBtn.onclick = () => window.location.href = NEXT_PAGE;

      } else {

        resultIcon.textContent = "📚";
        resultTitle.textContent = "Belum Tuntas";
        resultMessage.innerHTML = `Nilai kamu: <b>${nilaiPersen}</b><br>Pelajari ulang materi Bunyi.`;

        resultOkBtn.textContent = "Kembali Belajar";
        resultOkBtn.onclick = () => window.location.href = REVIEW_PAGE;

      }

      modal.style.display = "flex";

      await fetch('/simpan-progress', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
          halaman: "kuis_bunyi",
          urutan: 11,
          duration: duration
        })
      });

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

    function checkBeforeFinish() {

      const unanswered = userAnswers.includes(null);

      if (unanswered) {

        confirmTitle.textContent = "Soal Belum Lengkap";

        confirmMessage.innerHTML =
          "Masih ada soal yang belum dijawab.<br>Silakan periksa kembali sebelum menyelesaikan kuis.";

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

    confirmFinishBtn.onclick = () => {

      confirmModal.style.display = "none";
      finishQuiz();

    };

    cancelFinishBtn.onclick = () => {

      confirmModal.style.display = "none";

    };

    finishBtn.onclick = checkBeforeFinish;

  </script>

@endsection