<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPembelajaran extends Model
{
    protected $table = 'jadwal_pembelajaran';

    protected $fillable = [
        'kelas_id', 'dosen_id', 'mata_kuliah_id', 'hari', 'jam_mulai', 'jam_selesai', 'ruangan'
    ];

    // Relasi ke Kelas (Jadwal terikat ke satu Kelas)
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    // Relasi ke Dosen (Jadwal diajar oleh satu Dosen)
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    // Relasi ke Mata Kuliah (Jadwal memiliki satu Mata Kuliah)
    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'mata_kuliah_id');
    }

    // Relasi ke Kegiatan Belajar (Satu jadwal memiliki banyak kegiatan belajar/pertemuan)
    public function kegiatan()
    {
        return $this->hasMany(KegiatanBelajar::class, 'jadwal_pembelajaran_id');
    }
}
