<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Kelas extends Model
{
    use HasFactory;
 
    protected $table = 'kelas';
 
    protected $fillable = [
        'kode_kelas',
        'nama_kelas',
        'matakuliah_id',
        'dosen_id',
        'semester',
        'tahun_ajaran',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'ruangan',
        'kapasitas'
    ];
 
    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class, 'matakuliah_id', 'id');
    }
 
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id', 'id');
    }
 
    public function jadwalPembelajaran()
    {
        return $this->hasMany(JadwalPembelajaran::class, 'kelas_id', 'id');
    }
}
