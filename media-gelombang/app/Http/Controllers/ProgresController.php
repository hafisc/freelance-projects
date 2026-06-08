<?php

use App\Models\User;
use App\Models\GelombangSubmission;
use App\Models\QuizAttempt;

class ProgresController extends Controller
{
    public function index()
    {
        $students = User::where('role','siswa')->get();

        foreach ($students as $s) {

            $latihan = GelombangSubmission::where('user_id',$s->id)
                        ->pluck('latihan_code')
                        ->toArray();

            $s->L11 = in_array('L11',$latihan) ? 100 : 0;
            $s->L12 = in_array('L12',$latihan) ? 100 : 0;
            $s->L21 = in_array('L21',$latihan) ? 100 : 0;
            $s->L22 = in_array('L22',$latihan) ? 100 : 0;

            $quiz = QuizAttempt::where('user_id',$s->id)
                    ->pluck('quiz_id')
                    ->toArray();

            $s->K1 = in_array(1,$quiz) ? 100 : 0;
            $s->K2 = in_array(2,$quiz) ? 100 : 0;
            $s->K3 = in_array(3,$quiz) ? 100 : 0;
            $s->evaluasi = in_array(4,$quiz) ? 100 : 0;
        }

        return view('guru.progres',compact('students'));
    }
}