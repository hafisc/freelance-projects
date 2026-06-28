<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\{KegiatanBelajar, JadwalPembelajaran};
use Illuminate\Support\Facades\File;
 
class KegiatanBelajarController extends Controller
{
    /**
     * Menampilkan katalog materi, tugas, dan kegiatan belajar mengajar.
     * Dosen hanya melihat kelasnya, Mahasiswa melihat materi kelasnya, dan Admin/Operator melihat semua.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $role = session('role');
        $dosenId = session('dosen_id');
        $nim = session('nim');
 
        if ($role === 'Dosen') {
            // Ambil kegiatan khusus kelas milik dosen yang aktif
            $kegiatans = KegiatanBelajar::whereHas('jadwalPembelajaran.kelas', function($q) use ($dosenId) {
                $q->where('dosen_id', $dosenId);
            })->with(['jadwalPembelajaran.kelas.matakuliah'])->get();
 
            $jadwals = JadwalPembelajaran::whereHas('kelas', function($q) use ($dosenId) {
                $q->where('dosen_id', $dosenId);
            })->with(['kelas.matakuliah'])->get();
 
            return view('dosen.kegiatan.index', compact('kegiatans', 'jadwals'));
        } elseif ($role === 'Mahasiswa') {
            // Ambil kegiatan khusus kelas yang diikuti mahasiswa lewat KRS
            $kegiatans = KegiatanBelajar::whereHas('jadwalPembelajaran.kelas.matakuliah', function($q) use ($nim) {
                $q->whereIn('id', function($sub) use ($nim) {
                    $sub->select('matakuliah_id')->from('krs')->where('mahasiswa_id', $nim);
                });
            })->with(['jadwalPembelajaran.kelas.matakuliah', 'jadwalPembelajaran.kelas.dosen'])->get();
 
            return view('mahasiswa.kegiatan.index', compact('kegiatans'));
        } else {
            // Admin & Operator melihat semua materi dan tugas perkuliahan
            $kegiatans = KegiatanBelajar::with(['jadwalPembelajaran.kelas.matakuliah'])->get();
            $jadwals = JadwalPembelajaran::with(['kelas.matakuliah'])->get();
            $viewPrefix = ($role === 'Operator') ? 'operator' : 'admin';
            return view($viewPrefix . '.kegiatan.index', compact('kegiatans', 'jadwals'));
        }
    }
 
    /**
     * Menyimpan data kegiatan PBM baru ke database beserta file materi/tugas yang diunggah.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input materi atau tugas
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal_pembelajaran,id',
            'jenis' => 'required|in:Pertemuan,Materi,Tugas,Absensi',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file_materi' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip,png,jpg,jpeg|max:10240',
            'deadline' => 'required_if:jenis,Tugas|nullable|date',
        ]);
 
        $data = $request->except('file_materi');
 
        // Proses unggah file lampiran jika ada
        if ($request->hasFile('file_materi')) {
            $file = $request->file('file_materi');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Simpan langsung di folder public/uploads/kegiatan agar mudah diunduh
            $destinationPath = public_path('uploads/kegiatan');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }
            $file->move($destinationPath, $filename);
            $data['file_materi'] = 'uploads/kegiatan/' . $filename;
        }
 
        // Simpan data kegiatan belajar
        KegiatanBelajar::create($data);
 
        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan proses belajar berhasil ditambahkan!');
    }
 
    /**
     * Memperbarui data kegiatan PBM dan menangani penggantian file lama.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $kegiatan = KegiatanBelajar::findOrFail($id);
 
        // Validasi input data pembaruan
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal_pembelajaran,id',
            'jenis' => 'required|in:Pertemuan,Materi,Tugas,Absensi',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file_materi' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip,png,jpg,jpeg|max:10240',
            'deadline' => 'required_if:jenis,Tugas|nullable|date',
        ]);
 
        $data = $request->except('file_materi');
 
        // Proses penggantian file lampiran jika ada file baru yang diunggah
        if ($request->hasFile('file_materi')) {
            // Hapus file fisik lama agar penyimpanan tidak membengkak
            if ($kegiatan->file_materi && File::exists(public_path($kegiatan->file_materi))) {
                File::delete(public_path($kegiatan->file_materi));
            }
 
            $file = $request->file('file_materi');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('uploads/kegiatan');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }
            $file->move($destinationPath, $filename);
            $data['file_materi'] = 'uploads/kegiatan/' . $filename;
        }
 
        // Perbarui data kegiatan belajar
        $kegiatan->update($data);
 
        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan proses belajar berhasil diperbarui!');
    }
 
    /**
     * Menghapus data kegiatan PBM beserta file fisik lampiran dari server.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $kegiatan = KegiatanBelajar::findOrFail($id);
 
        // Hapus file fisik lampiran dari server
        if ($kegiatan->file_materi && File::exists(public_path($kegiatan->file_materi))) {
            File::delete(public_path($kegiatan->file_materi));
        }
 
        // Hapus data dari database
        $kegiatan->delete();
 
        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan proses belajar berhasil dihapus!');
    }
}
