<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'email', 'phone', 'address', 'website', 'description', 'logo', 'industry', 'pic_name', 'pic_phone'])]
class Company extends Model
{
    use HasFactory;

    // Relasi ke daftar lowongan kerja milik perusahaan ini
    public function jobs()
    {
        return $this->hasMany(Job::class, 'company_id');
    }

    // Relasi ke semua lamaran yang masuk untuk lowongan perusahaan ini
    public function applications()
    {
        return $this->hasManyThrough(JobApplication::class, Job::class, 'company_id', 'job_id');
    }

    // Mendapatkan URL logo perusahaan
    public function getLogoUrlAttribute()
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }
}
