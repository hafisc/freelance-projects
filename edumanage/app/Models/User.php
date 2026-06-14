<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role_id', 'status'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

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
        ];
    }

    // Relasi ke Role (User memiliki satu role)
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Relasi ke Mahasiswa (User bisa memiliki satu data mahasiswa)
    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class, 'user_id');
    }

    // Relasi ke Dosen (User bisa memiliki satu data dosen)
    public function dosen()
    {
        return $this->hasOne(Dosen::class, 'user_id');
    }

    // Helper untuk mengecek role
    public function hasRole($role)
    {
        return $this->role && $this->role->name === $role;
    }
}
