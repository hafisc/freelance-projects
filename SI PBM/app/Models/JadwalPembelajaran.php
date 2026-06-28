<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class JadwalPembelajaran extends Model
{
    use HasFactory;
 
    protected $table = 'jadwal_pembelajaran';
 
    protected $fillable = [
        'kelas_id',
        'pertemuan_ke',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'ruangan',
        'topik_materi',
        'status',
        'catatan'
    ];
 
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }
 
    public function kegiatanBelajar()
    {
        return $this->hasMany(KegiatanBelajar::class, 'jadwal_id', 'id');
    }
 
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'jadwal_id', 'id');
    }
}
