<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Dosen extends Model
{
    use HasFactory;
 
    protected $table = 'dosen';
 
    protected $fillable = [
        'nidn', 
        'nama_dosen', 
        'keahlian',
        'email',
        'no_hp'
    ];
 
    public function user()
    {
        return $this->hasOne(User::class, 'dosen_id', 'id');
    }
 
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'dosen_id', 'id');
    }
}
