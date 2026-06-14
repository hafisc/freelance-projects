<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KegiatanBelajar extends Model
{
    protected $table = 'kegiatan_belajar';

    protected $fillable = [
        'jadwal_pembelajaran_id', 'pertemuan_ke', 'tanggal', 'materi', 'metode_pembelajaran', 'tugas', 'status', 'catatan',
        'kehadiran_hadir', 'kehadiran_sakit', 'kehadiran_izin', 'kehadiran_alfa'
    ];

    // Relasi ke Jadwal Pembelajaran (Kegiatan terikat ke satu Jadwal)
    public function jadwalPembelajaran()
    {
        return $this->belongsTo(JadwalPembelajaran::class, 'jadwal_pembelajaran_id');
    }
}
