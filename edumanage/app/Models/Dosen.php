<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $table = 'dosen';

    protected $fillable = [
        'user_id', 'nidn', 'nama', 'jenis_kelamin', 'no_hp', 'alamat'
    ];

    // Relasi ke User (Dosen terikat ke satu User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Jadwal Pembelajaran (Dosen mengajar banyak jadwal)
    public function jadwal()
    {
        return $this->hasMany(JadwalPembelajaran::class, 'dosen_id');
    }
}
