<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\{JadwalPembelajaran, Kelas};
 
class JadwalController extends Controller
{
    /**
     * Menampilkan daftar jadwal pertemuan kuliah.
     * Dosen hanya melihat kelasnya, Mahasiswa melihat kelas yang diambil, dan Admin/Operator melihat semua kelas.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $role = session('role');
        $dosenId = session('dosen_id');
        $nim = session('nim');
 
        if ($role === 'Dosen') {
            // Ambil jadwal khusus kelas yang diampu dosen yang sedang login
            $jadwals = JadwalPembelajaran::whereHas('kelas', function($q) use ($dosenId) {
                $q->where('dosen_id', $dosenId);
            })->with(['kelas.matakuliah', 'kelas.dosen'])->get();
 
            $kelas = Kelas::where('dosen_id', $dosenId)->get();
            return view('dosen.jadwal.index', compact('jadwals', 'kelas'));
        } elseif ($role === 'Mahasiswa') {
            // Ambil jadwal kelas yang terdaftar dalam KRS milik mahasiswa
            $kelasIds = Kelas::whereIn('matakuliah_id', function($q) use ($nim) {
                $q->select('matakuliah_id')->from('krs')->where('mahasiswa_id', $nim);
            })->pluck('id');
 
            $jadwals = JadwalPembelajaran::whereIn('kelas_id', $kelasIds)
                ->with(['kelas.matakuliah', 'kelas.dosen'])
                ->get();
 
            return view('mahasiswa.jadwal.index', compact('jadwals'));
        } else {
            // Admin dan Operator melihat seluruh data jadwal pembelajaran
            $jadwals = JadwalPembelajaran::with(['kelas.matakuliah', 'kelas.dosen'])->get();
            $kelas = Kelas::all();
            $viewPrefix = ($role === 'Operator') ? 'operator' : 'admin';
            return view($viewPrefix . '.jadwal.index', compact('jadwals', 'kelas'));
        }
    }
 
    /**
     * Menyimpan jadwal pertemuan baru ke database.
     * Melakukan pengecekan kepemilikan kelas jika diinput oleh Dosen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input data jadwal baru
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'pertemuan_ke' => 'required|integer',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'ruangan' => 'required|string',
            'topik_materi' => 'nullable|string',
            'status' => 'required|in:Terjadwal,Berlangsung,Selesai,Dibatalkan',
            'catatan' => 'nullable|string',
        ]);
 
        // Proteksi otorisasi jika penginput adalah Dosen
        if (session('role') === 'Dosen') {
            $kelas = Kelas::findOrFail($request->kelas_id);
            if ($kelas->dosen_id != session('dosen_id')) {
                return back()->with('error', 'Akses ditolak: Anda bukan dosen kelas ini.');
            }
        }
 
        // Simpan jadwal baru
        JadwalPembelajaran::create($request->all());
 
        return redirect()->route('jadwal.index')->with('success', 'Jadwal pembelajaran berhasil ditambahkan!');
    }
 
    /**
     * Memperbarui data jadwal pertemuan berdasarkan ID.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $jadwal = JadwalPembelajaran::findOrFail($id);
 
        // Validasi input data pembaruan jadwal
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'pertemuan_ke' => 'required|integer',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'ruangan' => 'required|string',
            'topik_materi' => 'nullable|string',
            'status' => 'required|in:Terjadwal,Berlangsung,Selesai,Dibatalkan',
            'catatan' => 'nullable|string',
        ]);
 
        // Proteksi otorisasi jika pengubah adalah Dosen
        if (session('role') === 'Dosen') {
            if ($jadwal->kelas->dosen_id != session('dosen_id')) {
                return back()->with('error', 'Akses ditolak: Anda bukan dosen kelas ini.');
            }
        }
 
        // Perbarui data jadwal
        $jadwal->update($request->all());
 
        return redirect()->route('jadwal.index')->with('success', 'Jadwal pembelajaran berhasil diperbarui!');
    }
 
    /**
     * Menghapus data jadwal pertemuan berdasarkan ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $jadwal = JadwalPembelajaran::findOrFail($id);
 
        // Proteksi otorisasi jika penghapus adalah Dosen
        if (session('role') === 'Dosen') {
            if ($jadwal->kelas->dosen_id != session('dosen_id')) {
                return back()->with('error', 'Akses ditolak: Anda bukan dosen kelas ini.');
            }
        }
 
        // Hapus data jadwal
        $jadwal->delete();
 
        return redirect()->route('jadwal.index')->with('success', 'Jadwal pembelajaran berhasil dihapus!');
    }
}
