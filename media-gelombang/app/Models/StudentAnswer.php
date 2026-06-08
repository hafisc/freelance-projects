<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAnswer extends Model
{
    protected $fillable = [
        'attempt_id',
        'question_id',
        'selected_answer',
        'is_correct'
    ];

    public function attempt()
    {
        return $this->belongsTo(QuizAttempt::class, 'attempt_id');
    }

    // 🔥 TAMBAHKAN INI
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}