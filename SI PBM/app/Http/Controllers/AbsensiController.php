<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\{Absensi, JadwalPembelajaran, Mahasiswa, Kelas, Krs};
use Illuminate\Support\Facades\DB;
 
class AbsensiController extends Controller
{
    /**
     * Menampilkan data absensi berdasarkan role yang login.
     * Dosen dapat memilih pertemuan kelas untuk input kehadiran, Mahasiswa melihat rekap absensi pribadinya,
     * dan Admin/Operator melihat laporan kehadiran seluruh kelas.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        $role = session('role');
        $dosenId = session('dosen_id');
        $nim = session('nim');
 
        if ($role === 'Dosen') {
            // Dosen melihat daftar jadwal milik kelas yang diampunya
            $jadwals = JadwalPembelajaran::whereHas('kelas', function($q) use ($dosenId) {
                $q->where('dosen_id', $dosenId);
            })->with(['kelas.matakuliah'])->get();
 
            $selectedJadwalId = $request->get('jadwal_id');
            $selectedJadwal = null;
            $mahasiswas = [];
            $absensi = [];
 
            if ($selectedJadwalId) {
                $selectedJadwal = JadwalPembelajaran::with('kelas.matakuliah')->findOrFail($selectedJadwalId);
                
                // Pastikan dosen ini adalah pengampu kelas tersebut demi keamanan data
                if ($selectedJadwal->kelas->dosen_id != $dosenId) {
                    return redirect()->route('absensi.index')->with('error', 'Akses ditolak.');
                }
 
                // Cari mahasiswa yang terdaftar di kelas/matakuliah ini via KRS
                $mahasiswas = Mahasiswa::whereIn('nim', function($q) use ($selectedJadwal) {
                    $q->select('mahasiswa_id')->from('krs')->where('matakuliah_id', $selectedJadwal->kelas->matakuliah_id);
                })->get();
 
                // Ambil data absensi yang sudah tersimpan untuk di-load di form
                $absensi = Absensi::where('jadwal_id', $selectedJadwalId)->get()->keyBy('mahasiswa_nim');
            }
 
            return view('dosen.absensi.index', compact('jadwals', 'selectedJadwal', 'mahasiswas', 'absensi'));
 
        } elseif ($role === 'Mahasiswa') {
            // Mahasiswa melihat riwayat kehadiran pribadinya sepanjang semester
            $absensi = Absensi::where('mahasiswa_nim', $nim)
                ->with(['jadwalPembelajaran.kelas.matakuliah', 'jadwalPembelajaran.kelas.dosen'])
                ->get();
 
            return view('mahasiswa.absensi.index', compact('absensi'));
        } else {
            // Admin & Operator memantau laporan presensi seluruh kelas
            $jadwals = JadwalPembelajaran::with(['kelas.matakuliah', 'kelas.dosen'])->get();
            
            $selectedJadwalId = $request->get('jadwal_id');
            $selectedJadwal = null;
            $mahasiswas = [];
            $absensi = [];
 
            if ($selectedJadwalId) {
                $selectedJadwal = JadwalPembelajaran::with('kelas.matakuliah')->findOrFail($selectedJadwalId);
                
                $mahasiswas = Mahasiswa::whereIn('nim', function($q) use ($selectedJadwal) {
                    $q->select('mahasiswa_id')->from('krs')->where('matakuliah_id', $selectedJadwal->kelas->matakuliah_id);
                })->get();
 
                $absensi = Absensi::where('jadwal_id', $selectedJadwalId)->get()->keyBy('mahasiswa_nim');
            }
 
            $viewPrefix = ($role === 'Operator') ? 'operator' : 'admin';
            return view($viewPrefix . '.absensi.index', compact('jadwals', 'selectedJadwal', 'mahasiswas', 'absensi'));
        }
    }
 
    /**
     * Menyimpan atau memperbarui data daftar hadir mahasiswa (absensi) pada suatu pertemuan kuliah.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input data absensi kelas
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal_pembelajaran,id',
            'absensi' => 'required|array',
            'absensi.*.nim' => 'required|exists:mahasiswa,nim',
            'absensi.*.status' => 'required|in:Hadir,Izin,Sakit,Alpha',
            'absensi.*.keterangan' => 'nullable|string|max:255',
        ]);
 
        $jadwalId = $request->jadwal_id;
 
        // Lakukan penyimpanan/pembaruan data presensi per mahasiswa
        foreach ($request->absensi as $mhsAbsen) {
            Absensi::updateOrCreate(
                [
                    'jadwal_id' => $jadwalId,
                    'mahasiswa_nim' => $mhsAbsen['nim']
                ],
                [
                    'status' => $mhsAbsen['status'],
                    'keterangan' => $mhsAbsen['keterangan'] ?? null
                ]
            );
        }
 
        return redirect()->route('absensi.index', ['jadwal_id' => $jadwalId])->with('success', 'Kehadiran mahasiswa berhasil disimpan!');
    }
}
