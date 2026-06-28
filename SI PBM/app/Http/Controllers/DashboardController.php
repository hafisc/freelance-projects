<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\{Mahasiswa, Dosen, Matakuliah, Kelas, JadwalPembelajaran, User, Krs};
use Illuminate\Support\Facades\DB;
 
class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard utama untuk role Admin.
     * Mengambil data statistik umum sistem (User, Mahasiswa, Dosen, Kelas, dan Jadwal hari ini).
     *
     * @return \Illuminate\View\View
     */
    public function admin()
    {
        $stats = [
            'users' => User::count(),
            'mahasiswa' => Mahasiswa::count(),
            'dosen' => Dosen::count(),
            'kelas' => Kelas::count(),
            'jadwal_hari_ini' => JadwalPembelajaran::whereDate('tanggal', today())->count(),
        ];
 
        return view('admin.dashboard.index', compact('stats'));
    }
 
    /**
     * Menampilkan dashboard utama untuk role Operator.
     * Mengambil data statistik data master akademik (Mahasiswa, Dosen, Matakuliah, dan Kelas).
     *
     * @return \Illuminate\View\View
     */
    public function operator()
    {
        $stats = [
            'mahasiswa' => Mahasiswa::count(),
            'dosen' => Dosen::count(),
            'matakuliah' => Matakuliah::count(),
            'kelas' => Kelas::count(),
        ];
 
        return view('operator.dashboard.index', compact('stats'));
    }
 
    /**
     * Menampilkan dashboard utama untuk role Dosen.
     * Mengambil statistik kelas yang diampu, jumlah mahasiswa didik unik, dan jadwal tatap muka hari ini.
     *
     * @return \Illuminate\View\View
     */
    public function dosen()
    {
        $dosenId = session('dosen_id');
        $kelasCount = Kelas::where('dosen_id', $dosenId)->count();
        
        $mahasiswaCount = Krs::where('dosen_id', $dosenId)
            ->distinct('mahasiswa_id')
            ->count('mahasiswa_id');
 
        $jadwalHariIni = JadwalPembelajaran::whereHas('kelas', function($q) use ($dosenId) {
                $q->where('dosen_id', $dosenId);
            })
            ->whereDate('tanggal', today())
            ->with(['kelas.matakuliah'])
            ->get();
 
        $stats = [
            'kelas' => $kelasCount,
            'mahasiswa' => $mahasiswaCount,
            'jadwal_hari_ini' => $jadwalHariIni
        ];
 
        return view('dosen.dashboard.index', compact('stats'));
    }
 
    /**
     * Menampilkan dashboard utama untuk role Mahasiswa.
     * Mengambil jadwal kuliah hari ini dan daftar tugas aktif yang belum dikumpulkan.
     *
     * @return \Illuminate\View\View
     */
    public function mahasiswa()
    {
        $nim = session('nim');
        
        // Ambil kelas yang diikuti mahasiswa lewat KRS
        $kelasIds = Kelas::whereIn('matakuliah_id', function($q) use ($nim) {
                $q->select('matakuliah_id')->from('krs')->where('mahasiswa_id', $nim);
            })->pluck('id');
 
        $jadwalHariIni = JadwalPembelajaran::whereIn('kelas_id', $kelasIds)
            ->whereDate('tanggal', today())
            ->with(['kelas.matakuliah', 'kelas.dosen'])
            ->get();
 
        $tugasPending = DB::table('kegiatan_belajar')
            ->join('jadwal_pembelajaran', 'kegiatan_belajar.jadwal_id', '=', 'jadwal_pembelajaran.id')
            ->whereIn('jadwal_pembelajaran.kelas_id', $kelasIds)
            ->where('kegiatan_belajar.jenis', 'Tugas')
            ->where('kegiatan_belajar.deadline', '>=', now())
            ->select('kegiatan_belajar.*', 'jadwal_pembelajaran.tanggal')
            ->get();
 
        $stats = [
            'jadwal_hari_ini' => $jadwalHariIni,
            'tugas_pending' => $tugasPending,
        ];
 
        return view('mahasiswa.dashboard.index', compact('stats'));
    }
}
