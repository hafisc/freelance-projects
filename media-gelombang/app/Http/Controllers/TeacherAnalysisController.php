<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TeacherAnalysisController extends Controller
{
    public function index($quiz_id)
    {
        $analysis = DB::table('student_answers as sa')
            ->join('quiz_attempts as qa', 'sa.attempt_id', '=', 'qa.id')
            ->join('questions as q', 'sa.question_id', '=', 'q.id')
            ->where('q.quiz_id', $quiz_id)
            ->whereIn('qa.id', function ($query) use ($quiz_id) {
                $query->select(DB::raw('MIN(id)'))
                    ->from('quiz_attempts')
                    ->where('quiz_id', $quiz_id)
                    ->groupBy('user_id');
            })
            ->select(
                'q.id',
                'q.question',
                'q.option_a',
                'q.option_b',
                'q.option_c',
                'q.option_d',
                'q.option_e',
                'q.answer',
                DB::raw('COUNT(sa.id) as total'),
                DB::raw('SUM(sa.is_correct) as correct')
            )
            ->groupBy(
                'q.id',
                'q.question',
                'q.option_a',
                'q.option_b',
                'q.option_c',
                'q.option_d',
                'q.option_e',
                'q.answer'
            )
            ->get()
            ->map(function ($item) {

                $wrong = $item->total - $item->correct;
                $percentage = ($item->total > 0)
                    ? round(($item->correct / $item->total) * 100)
                    : 0;

                if ($percentage > 70) {
                    $category = 'Mudah';
                } elseif ($percentage >= 30) {
                    $category = 'Sedang';
                } else {
                    $category = 'Sulit';
                }

                $item->wrong = $wrong;
                $item->percentage = $percentage;
                $item->category = $category;

                return $item;
            });

        return view('guru.analysis', compact('analysis'));
    }

    public function updateQuestion(Request $request, $id)
    {
        $request->validate([
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'option_e' => 'required|string',
            'answer' => 'required|in:A,B,C,D,E',
        ]);

        DB::table('questions')
            ->where('id', $id)
            ->update([
                'question' => $request->question,
                'option_a' => $request->option_a,
                'option_b' => $request->option_b,
                'option_c' => $request->option_c,
                'option_d' => $request->option_d,
                'option_e' => $request->option_e,
                'answer' => [
                    'A' => 0,
                    'B' => 1,
                    'C' => 2,
                    'D' => 3,
                    'E' => 4
                ][$request->answer],
                'updated_at' => now()
            ]);

        return back()->with('success', 'Soal berhasil diperbarui!');
    }
}