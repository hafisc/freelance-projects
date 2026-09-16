<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id', 'job_id', 'full_name', 'email', 'phone', 'address', 'note', 'status', 'admin_note', 'cv_path', 'cv_shared_at'])]
class JobApplication extends Model
{
    use HasFactory;

    // Relasi ke User yang melamar
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Job lowongan kerja yang dilamar
    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    // Mendapatkan URL berkas CV snapshot
    public function getCvSnapshotUrlAttribute()
    {
        return $this->cv_path ? asset('storage/' . $this->cv_path) : null;
    }

    // Cast untuk tipe data kolom
    protected function casts(): array
    {
        return [
            'cv_shared_at' => 'datetime',
        ];
    }
}
