<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mahasiswa extends Model
{
    // Menentukan kolom yang dapat diisi secara massal
    protected $fillable = [
        'nim',
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'no_hp',
        'jurusan_id',
    ];

    /**
     * Relasi Many-to-One ke model Jurusan.
     * Satu mahasiswa hanya terdaftar pada satu jurusan.
     */
    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }
}
