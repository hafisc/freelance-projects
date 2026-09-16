<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'company_name', 'company_id', 'location', 'qualification', 'description', 'deadline', 'status', 'job_type', 'category', 'experience', 'salary_min', 'salary_max', 'salary_category'])]
class Job extends Model
{
    use HasFactory;

    // Relasi ke lamaran pekerjaan yang masuk untuk lowongan ini
    public function applications()
    {
        return $this->hasMany(JobApplication::class, 'job_id');
    }

    // Relasi ke perusahaan pemilik lowongan
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    // Accessor untuk menampilkan informasi gaji yang terformat
    public function getSalaryDisplayAttribute()
    {
        if ($this->salary_category === 'Negosiasi' || (!$this->salary_min && !$this->salary_max)) {
            return $this->salary_category ?? 'Negosiasi';
        }

        if ($this->salary_min && $this->salary_max) {
            return 'Rp ' . number_format($this->salary_min, 0, ',', '.') . ' - Rp ' . number_format($this->salary_max, 0, ',', '.');
        }

        if ($this->salary_min) {
            return '≥ Rp ' . number_format($this->salary_min, 0, ',', '.');
        }

        return '≤ Rp ' . number_format($this->salary_max, 0, ',', '.');
    }

    // Accessor untuk mendapatkan nama perusahaan dari relasi atau fallback ke company_name lama
    public function getCompanyDisplayNameAttribute()
    {
        return $this->company?->name ?? $this->company_name ?? 'PT. Gloria Jasa Mandiri';
    }

    // Appended attributes untuk serialisasi JSON
    protected $appends = ['salary_display', 'company_display_name'];
}
