<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\{Krs, Mahasiswa, Dosen, Matakuliah};
 
class KrsController extends Controller
{
    /**
     * Menampilkan daftar semua data plotting KRS.
     * Mengarahkan ke view admin atau operator berdasarkan role user yang aktif.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $krs = Krs::with(['mahasiswa', 'dosen', 'matakuliah'])->get();
        $mahasiswas = Mahasiswa::all();
        $dosens = Dosen::all();
        $matakuliahs = Matakuliah::all();
        
        $viewPrefix = (session('role') === 'Operator') ? 'operator' : 'admin';
        return view($viewPrefix . '.krs.index', compact('krs', 'mahasiswas', 'dosens', 'matakuliahs'));
    }
 
    /**
     * Menyimpan data plotting KRS baru mahasiswa ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input data plotting KRS
        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswa,nim',
            'matakuliah_id' => 'required|exists:matakuliah,id',
            'dosen_id' => 'required|exists:dosen,id',
            'semester' => 'required'
        ]);
 
        // Simpan data plotting KRS
        Krs::create($request->all());
        return redirect()->route('krs.index')->with('success', 'Data berhasil ditambah!');
    }
 
    /**
     * Menghapus data plotting KRS berdasarkan ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Krs::findOrFail($id)->delete();
        return redirect()->route('krs.index')->with('success', 'Data berhasil dihapus!');
    }
}
