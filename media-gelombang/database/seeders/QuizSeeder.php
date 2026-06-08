<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('quizzes')->insert([
            [
                'id' => 1,
                'title' => 'Kuis Gelombang',
                'slug' => 'kuis-gelombang'
            ],
            [
                'id' => 2,
                'title' => 'Kuis Bunyi',
                'slug' => 'kuis-bunyi'
            ],
            [
                'id' => 3,
                'title' => 'Kuis Cahaya',
                'slug' => 'kuis-cahaya'
            ],
            [
                'id' => 4,
                'title' => 'Evaluasi',
                'slug' => 'evaluasi'
            ],
        ]);
    }
}
