<?php

namespace App\Exports;

use App\Models\Nilai;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NilaiExport implements FromCollection, WithHeadings
{
    protected $quiz_id;
    protected $mode;
    protected $kkm;

    public function __construct($quiz_id = null, $mode = 'all', $kkm = 70)
    {
        $this->quiz_id = $quiz_id;
        $this->mode = $mode;
        $this->kkm = $kkm;
    }

    public function collection()
    {
        $query = Nilai::with(['user','quiz']);

        // FILTER KUIS
        if ($this->quiz_id) {
            $query->where('quiz_id', $this->quiz_id);
        }

        $data = $query->get();

        // MODE NILAI TERTINGGI
        if ($this->mode == 'best') {
            $data = $data->groupBy(function($n){
                return $n->user_id.'-'.$n->quiz_id;
            })->map(function($group){
                return $group->sortByDesc('score')->first();
            });
        }

        return $data->map(function ($n) {

            $durasi = $n->duration ?? 0;
            $menit = floor($durasi / 60);
            $detik = $durasi % 60;

            return [
                'Nama Siswa' => $n->user->name,
                'Kuis' => $n->quiz->title,
                'Nilai' => $n->score,
                'Status' => $n->score >= $this->kkm ? 'Tuntas' : 'Belum',
                'Benar' => $n->benar,
                'Total Soal' => $n->total_soal,
                'Durasi' => $menit.'m '.$detik.'s',
                'Tanggal' => $n->created_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Siswa',
            'Kuis',
            'Nilai',
            'Status',
            'Benar',
            'Total Soal',
            'Durasi',
            'Tanggal'
        ];
    }
}
