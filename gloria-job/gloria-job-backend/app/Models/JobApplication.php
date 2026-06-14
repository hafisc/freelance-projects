<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id', 'job_id', 'full_name', 'email', 'phone', 'address', 'note', 'status', 'admin_note'])]
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
}
