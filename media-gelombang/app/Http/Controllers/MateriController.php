<?php

namespace App\Http\Controllers;

use View;
use App\Models\Nilai;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\QuizAttempt;
use App\Models\StudentAnswer;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProgress;

class MateriController extends Controller
{

    private function viewMateri($viewName)
    {
        return view($viewName);
    }

    /* ==================== GELOMBANG ==================== */

    public function pengantarGelombang()
    {
        return $this->viewMateri('pengantar_gelombang');
    }

    public function definisiGelombang()
    {
        return $this->viewMateri('definisi_gelombang');
    }

    public function jenisGelombang()
    {
        return $this->viewMateri('jenis_gelombang');
    }

    public function bedafaseGelombang()
    {
        return $this->viewMateri('beda_fase_gelombang');
    }

    public function prinsipGelombang()
    {
        return $this->viewMateri('prinsip_gelombang');
    }


    /* ==================== BUNYI ==================== */

    public function pengantarBunyi()
    {
        return $this->viewMateri('pengantar_bunyi');
    }

    public function konsepPerambatanBunyi()
    {
        return $this->viewMateri('konsep_perambatan_bunyi');
    }

    public function sumberKarBunyi()
    {
        return $this->viewMateri('sumber_kar_bunyi');
    }

    public function fenomenaApkBunyi()
    {
        return $this->viewMateri('fenomena_apk_bunyi');
    }


    /* ==================== CAHAYA ==================== */

    public function pengantarCahaya()
    {
        return $this->viewMateri('pengantar_cahaya');
    }

    public function sifatCahaya()
    {
        return $this->viewMateri('sifat_cahaya');
    }

    public function spektrumCahaya()
    {
        return $this->viewMateri('spektrum_cahaya');
    }

    public function fenomenaApkCahaya()
    {
        return $this->viewMateri('fenomena_apk_cahaya');
    }

    public function kuisGelombang()
    {
        $questions = Question::where('quiz_id', 1)
            ->orderBy('id', 'asc')
            ->limit(10)
            ->get()
            ->map(function ($q) {
                return [
                    'id' => $q->id, // ✅ PENTING
                    'q' => $q->question,
                    'options' => [
                        $q->option_a,
                        $q->option_b,
                        $q->option_c,
                        $q->option_d,
                        $q->option_e
                    ],
                    'answer' => $q->answer
                ];
            });

        return view('kuis_gelombang', [
            'questions' => $questions,
            'quiz_id' => 1
        ]);
    }
    public function kuisBunyi()
    {
        $questions = Question::where('quiz_id', 2)
            ->orderBy('id', 'asc') // ✅ urut tetap
            ->limit(10)            // ✅ hanya 10 soal
            ->get()
            ->map(function ($q) {
                return [
                    'id' => $q->id, // ✅ penting untuk analisis
                    'q' => $q->question,
                    'options' => [
                        $q->option_a,
                        $q->option_b,
                        $q->option_c,
                        $q->option_d,
                        $q->option_e
                    ],
                    'answer' => $q->answer
                ];
            });

        return view('kuis_bunyi', [
            'questions' => $questions,
            'quiz_id' => 2
        ]);
    }

    public function kuisCahaya()
    {
        $questions = Question::where('quiz_id', 3)
            ->orderBy('id', 'asc')
            ->limit(10)
            ->get()
            ->map(function ($q) {
                return [
                    'id' => $q->id,
                    'q' => $q->question,
                    'options' => [
                        $q->option_a,
                        $q->option_b,
                        $q->option_c,
                        $q->option_d,
                        $q->option_e
                    ],
                    'answer' => $q->answer
                ];
            });

        return view('kuis_cahaya', [
            'questions' => $questions,
            'quiz_id' => 3
        ]);
    }

    public function evaluasi()
    {
        $quizId = 4; // id evaluasi (sesuaikan dengan database)

        $questions = Question::where('quiz_id', $quizId)
            ->orderBy('id', 'asc')
            ->limit(20) // evaluasi 20 soal
            ->get()
            ->map(function ($q) {
                return [
                    'id' => $q->id,
                    'q' => $q->question,
                    'options' => [
                        $q->option_a,
                        $q->option_b,
                        $q->option_c,
                        $q->option_d,
                        $q->option_e
                    ],
                    'answer' => $q->answer,
                    'sub_topik' => $q->sub_topik
                ];
            });

        // ambil KKM dari tabel quizzes
        $quiz = \App\Models\Quiz::find($quizId);

        return view('evaluasi', [
            'questions' => $questions,
            'quiz_id' => $quizId,
            'kkm' => $quiz->kkm
        ]);
    }




    public function simpanNilai(Request $request)
    {
        $totalSoal = $request->total_soal;
        $benar = $request->benar;

        // 🔥 HITUNG PERSENTASE
        $score = round(($benar / $totalSoal) * 100);

        // Simpan ke tabel nilai (kalau masih dipakai)
        Nilai::create([
            'user_id' => auth()->id(),
            'quiz_id' => $request->quiz_id,
            'score' => $score,
            'total_soal' => $totalSoal,
            'benar' => $benar,
            'duration' => $request->duration
        ]);

        // Simpan attempt
        $attempt = QuizAttempt::create([
            'quiz_id' => $request->quiz_id,
            'user_id' => auth()->id(),
            'score' => $score,
            'duration' => $request->duration
        ]);

        $answers = $request->answers;
        $questions = $request->questions;

        foreach ($questions as $index => $q) {

            $selected = $answers[$index] ?? null;
            $isCorrect = ($selected == $q['answer']);

            StudentAnswer::create([
                'attempt_id' => $attempt->id,
                'question_id' => $q['id'],
                'selected_answer' => $selected,
                'is_correct' => $isCorrect
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function simpanProgress(Request $request)
    {
        UserProgress::create([
            'user_id' => auth()->id(),
            'halaman' => $request->halaman,
            'urutan' => $request->urutan,
            'duration' => $request->duration
        ]);

        return response()->json(['success' => true]);
    }

}
