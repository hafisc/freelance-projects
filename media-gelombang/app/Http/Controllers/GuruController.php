<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Exports\NilaiExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Quiz;
use App\Models\GelombangSubmission;
use App\Models\QuizAttempt;

class GuruController extends Controller
{

    public function exportNilai(Request $request)
    {
        $quiz_id = $request->quiz_id;
        $mode = $request->mode ?? 'all';

        return Excel::download(
            new NilaiExport($quiz_id, $mode, 70),
            'data_nilai.xlsx'
        );
    }


    public function deleteAttempt($id)
    {
        $attempt = \App\Models\QuizAttempt::find($id);

        if (!$attempt) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        // Hapus relasi dulu kalau ada
        $attempt->answers()->delete(); // kalau ada relasi answers

        $attempt->delete();

        return response()->json(['success' => true]);
    }
    public function deleteAll($user, $quiz)
    {
        $attempts = \App\Models\QuizAttempt::where('user_id', $user)
            ->where('quiz_id', $quiz)
            ->get();

        foreach ($attempts as $attempt) {
            $attempt->answers()->delete(); // kalau ada relasi
            $attempt->delete();
        }

        return response()->json(['success' => true]);
    }

    public function nilai()
    {
        $attempts = \App\Models\QuizAttempt::with([
            'user',
            'quiz',
            'answers.question'
        ])->get();

        $grouped = $attempts
            ->groupBy(function ($item) {
                return $item->user_id . '-' . $item->quiz_id;
            });

        $nilai = collect();

        foreach ($grouped as $group) {

            $first = $group->first();

            $nilai->push((object) [
                'user_id' => $first->user_id,
                'quiz_id' => $first->quiz_id,
                'user' => $first->user,
                'quiz' => $first->quiz,
                'score' => $group->max('score'),
                'total_attempt' => $group->count(),
                'detail' => $group->sortBy('created_at')->values()->map(function ($attempt) {

                    return [
                        'id' => $attempt->id,
                        'quiz_id' => $attempt->quiz_id,
                        'user_id' => $attempt->user_id,
                        'score' => $attempt->score,
                        'duration' => $attempt->duration,
                        'created_at' => $attempt->created_at,

                        'answers' => $attempt->answers->map(function ($a) {

                            return [
                                'question' => $a->question->question,

                                'option_a' => $a->question->option_a,
                                'option_b' => $a->question->option_b,
                                'option_c' => $a->question->option_c,
                                'option_d' => $a->question->option_d,
                                'option_e' => $a->question->option_e,

                                'answer' => $a->selected_answer,
                                'correct_answer' => $a->question->answer,

                                'is_correct' => $a->is_correct
                            ];
                        })
                    ];
                })
            ]);
        }

        $quizzes = \App\Models\Quiz::all();

        return view('guru.nilai', compact('nilai', 'quizzes'));
    }

    public function siswa()
    {
        $siswa = User::where('role', 'murid')->get();

        return view('guru.siswa', compact('siswa'));
    }

    public function storeSiswa(Request $request)
    {
        $request->validate([
            'username' => 'required|numeric|digits_between:5,15|unique:users,username',
            'name' => 'required',
            'email' => 'required|email',
            'kelas' => 'required',
            'tahun' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'kelas' => $request->kelas,
            'tahun' => $request->tahun,
            'role' => 'murid'
        ]);
        return back()->with('success', 'Siswa berhasil ditambahkan');
    }

    public function updateSiswa(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'kelas' => 'required',
            'tahun' => 'required',
            'password' => 'nullable|min:6'
        ]);

        $user = User::findOrFail($id);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'kelas' => $request->kelas,
            'tahun' => $request->tahun,
        ];

        // Kalau password diisi → update
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Data siswa berhasil diperbarui');
    }
    public function deleteSiswa($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'Siswa berhasil dihapus');
    }

    public function updateKKM(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'kkm' => 'required|integer|min:0|max:100'
        ]);

        \DB::table('quizzes')
            ->where('id', $request->quiz_id)
            ->update([
                'kkm' => $request->kkm
            ]);

        return back()->with('success', 'KKM berhasil diperbarui!');
    }
    public function progres()
    {
        $students = User::where('role', 'murid')->get();

        foreach ($students as $s) {

            // =========================
            // LATIHAN
            // =========================
            $latihan = GelombangSubmission::where('user_id', $s->id)
                ->pluck('latihan_code')
                ->toArray();

            $s->L11 = in_array('L11', $latihan);
            $s->L12 = in_array('L12', $latihan);
            $s->L21 = in_array('L21', $latihan);
            $s->L22 = in_array('L22', $latihan);
            $s->L23 = in_array('L23', $latihan);
            $s->L24 = in_array('L24', $latihan);
            $s->L31 = in_array('L31', $latihan);
            
            // =========================
            // QUIZ
            // =========================
            $quiz = QuizAttempt::where('user_id', $s->id)
                ->pluck('quiz_id')
                ->toArray();

            $s->K1 = in_array(1, $quiz);
            $s->K2 = in_array(2, $quiz);
            $s->K3 = in_array(3, $quiz);
            $s->evaluasi = in_array(4, $quiz);

            // =========================
            // FILE PDF TERBARU
            // =========================
            $s->submissions = GelombangSubmission::where('user_id', $s->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('guru.progres', compact('students'));
    }
}
