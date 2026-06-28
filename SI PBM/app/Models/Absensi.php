<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Absensi extends Model
{
    use HasFactory;
 
    protected $table = 'absensi';
 
    protected $fillable = [
        'jadwal_id',
        'mahasiswa_nim',
        'status',
        'keterangan'
    ];
 
    public function jadwalPembelajaran()
    {
        return $this->belongsTo(JadwalPembelajaran::class, 'jadwal_id', 'id');
    }
 
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_nim', 'nim');
    }
}
