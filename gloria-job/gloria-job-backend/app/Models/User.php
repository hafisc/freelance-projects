<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable(['name', 'email', 'phone', 'password', 'address', 'cv', 'summary', 'skills', 'education', 'experience'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    // Relasi ke data lamaran pekerjaan milik user
    public function applications()
    {
        return $this->hasMany(JobApplication::class, 'user_id');
    }

    // Relasi ke daftar notifikasi milik user
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }


    // Property appends untuk menyertakan attribute dynamic ke serialisasi JSON
    protected $appends = ['cv_url', 'cv_filename'];

    // Mendapatkan URL lengkap berkas CV di storage
    public function getCvUrlAttribute()
    {
        return $this->cv ? asset('storage/'.$this->cv) : null;
    }

    // Mendapatkan nama berkas CV
    public function getCvFilenameAttribute()
    {
        return $this->cv ? basename($this->cv) : null;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'skills' => 'array',
            'education' => 'array',
            'experience' => 'array',
        ];
    }
}
