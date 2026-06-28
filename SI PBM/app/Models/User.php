<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
 
class User extends Authenticatable
{
    use HasFactory, Notifiable;
 
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nim',
        'dosen_id'
    ];
 
    protected $hidden = [
        'password',
        'remember_token',
    ];
 
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
 
    // Relations
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
 
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id', 'id');
    }
 
    // Role Helpers
    public function isAdmin()
    {
        return $this->role === 'Admin';
    }
 
    public function isOperator()
    {
        return $this->role === 'Operator';
    }
 
    public function isDosen()
    {
        return $this->role === 'Dosen';
    }
 
    public function isMahasiswa()
    {
        return $this->role === 'Mahasiswa';
    }
}
