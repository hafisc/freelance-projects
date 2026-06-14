<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = ['nama_kelas', 'prodi', 'angkatan'];

    // Relasi ke Jadwal Pembelajaran (Satu kelas memiliki banyak jadwal)
    public function jadwal()
    {
        return $this->hasMany(JadwalPembelajaran::class, 'kelas_id');
    }
}
