<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Mahasiswa extends Model
{
    use HasFactory;
 
    protected $table = 'mahasiswa';
    protected $primaryKey = 'nim';
    public $incrementing = false;
    protected $keyType = 'string';
 
    protected $fillable = [
        'nim', 
        'nama', 
        'tempat_lahir', 
        'tanggal_lahir', 
        'jenis_kelamin', 
        'agama', 
        'no_telepon', 
        'email', 
        'asal_sekolah', 
        'nama_wali', 
        'fakultas', 
        'prodi', 
        'tahun_masuk', 
        'status_mahasiswa', 
        'alamat'
    ];
 
    public function user()
    {
        return $this->hasOne(User::class, 'nim', 'nim');
    }
 
    public function krs()
    {
        return $this->hasMany(Krs::class, 'mahasiswa_id', 'nim');
    }
 
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'mahasiswa_nim', 'nim');
    }
}
