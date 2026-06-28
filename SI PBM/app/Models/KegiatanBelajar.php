<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class KegiatanBelajar extends Model
{
    use HasFactory;
 
    protected $table = 'kegiatan_belajar';
 
    protected $fillable = [
        'jadwal_id',
        'jenis',
        'judul',
        'deskripsi',
        'file_materi',
        'deadline'
    ];
 
    public function jadwalPembelajaran()
    {
        return $this->belongsTo(JadwalPembelajaran::class, 'jadwal_id', 'id');
    }
}
