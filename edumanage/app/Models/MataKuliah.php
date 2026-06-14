<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    protected $table = 'mata_kuliah';

    protected $fillable = ['kode_mk', 'nama_mk', 'sks', 'semester'];

    // Relasi ke Jadwal Pembelajaran (Satu matakuliah bisa terjadwal di banyak kelas)
    public function jadwal()
    {
        return $this->hasMany(JadwalPembelajaran::class, 'mata_kuliah_id');
    }
}
