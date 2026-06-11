<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jurusan extends Model
{
    // Menentukan kolom yang dapat diisi secara massal
    protected $fillable = [
        'nama_jurusan',
        'keterangan',
    ];

    /**
     * Relasi One-to-Many ke model Mahasiswa.
     * Satu jurusan dapat memiliki banyak mahasiswa.
     */
    public function mahasiswas(): HasMany
    {
        return $this->hasMany(Mahasiswa::class, 'jurusan_id');
    }
}
