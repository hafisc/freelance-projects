<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Krs extends Model
{
    use HasFactory;
    protected $table = 'krs';
    protected $fillable = ['mahasiswa_id', 'dosen_id', 'matakuliah_id', 'semester'];

    public function mahasiswa() {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'nim');
    }
    public function dosen() {
        return $this->belongsTo(Dosen::class, 'dosen_id', 'id');
    }
    public function matakuliah() {
        return $this->belongsTo(Matakuliah::class, 'matakuliah_id', 'id');
    }
}