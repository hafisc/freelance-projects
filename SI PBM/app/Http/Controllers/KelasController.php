<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\{Kelas, Matakuliah, Dosen};
 
class KelasController extends Controller
{
    /**
     * Menampilkan daftar semua kelas akademik yang terdaftar.
     * Mengarahkan ke view admin atau operator berdasarkan role user yang aktif.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $kelas = Kelas::with(['matakuliah', 'dosen'])->get();
        $matakuliahs = Matakuliah::all();
        $dosens = Dosen::all();
        $viewPrefix = (session('role') === 'Operator') ? 'operator' : 'admin';
        return view($viewPrefix . '.kelas.index', compact('kelas', 'matakuliahs', 'dosens'));
    }
 
    /**
     * Menyimpan data kelas akademik baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input data kelas
        $request->validate([
            'kode_kelas' => 'required|string|unique:kelas,kode_kelas',
            'nama_kelas' => 'required|string',
            'matakuliah_id' => 'required|exists:matakuliah,id',
            'dosen_id' => 'required|exists:dosen,id',
            'semester' => 'required|integer',
            'tahun_ajaran' => 'required|string',
            'hari' => 'required|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'ruangan' => 'required|string',
            'kapasitas' => 'required|integer',
        ]);
 
        // Simpan data kelas ke database
        Kelas::create($request->all());
 
        return redirect()->route('kelas.index')->with('success', 'Kelas baru berhasil ditambahkan!');
    }
 
    /**
     * Memperbarui data kelas akademik berdasarkan ID.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);
 
        // Validasi data kelas baru
        $request->validate([
            'kode_kelas' => 'required|string|unique:kelas,kode_kelas,' . $id,
            'nama_kelas' => 'required|string',
            'matakuliah_id' => 'required|exists:matakuliah,id',
            'dosen_id' => 'required|exists:dosen,id',
            'semester' => 'required|integer',
            'tahun_ajaran' => 'required|string',
            'hari' => 'required|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'ruangan' => 'required|string',
            'kapasitas' => 'required|integer',
        ]);
 
        // Perbarui data kelas
        $kelas->update($request->all());
 
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diperbarui!');
    }
 
    /**
     * Menghapus data kelas akademik berdasarkan ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Kelas::findOrFail($id)->delete();
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus!');
    }
}
