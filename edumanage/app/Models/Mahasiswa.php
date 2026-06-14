<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';

    protected $fillable = [
        'user_id', 'nim', 'nama', 'jenis_kelamin', 'prodi', 'angkatan', 'no_hp', 'alamat'
    ];

    // Relasi ke User (Mahasiswa terikat ke satu User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
