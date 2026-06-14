<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'company_name', 'location', 'qualification', 'description', 'deadline', 'status', 'job_type', 'category', 'experience'])]
class Job extends Model
{
    use HasFactory;

    // Relasi ke lamaran pekerjaan yang masuk untuk lowongan ini
    public function applications()
    {
        return $this->hasMany(JobApplication::class, 'job_id');
    }
}
