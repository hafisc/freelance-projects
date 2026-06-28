<?php
 
namespace App\Http\Controllers;
 
use App\Models\Matakuliah;
use Illuminate\Http\Request;
 
class MatakuliahController extends Controller
{
    /**
     * Menampilkan daftar semua mata kuliah.
     * Mengarahkan ke view admin atau operator berdasarkan role user yang aktif.
     *
     * @return \Illuminate\View\View
     */
    public function index() {
        $matakuliahs = Matakuliah::all();
        $viewPrefix = (session('role') === 'Operator') ? 'operator' : 'admin';
        return view($viewPrefix . '.matakuliah.index', compact('matakuliahs'));
    }
 
    /**
     * Menyimpan data mata kuliah baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) {
        // Validasi input data mata kuliah
        $request->validate([
            'kode_mk' => 'required|unique:matakuliah,kode_mk',
            'nama_mk' => 'required',
            'sks' => 'required|numeric',
            'semester' => 'required|numeric'
        ]);
 
        // Simpan data mata kuliah baru
        Matakuliah::create($request->all());
        return redirect()->route('matakuliah.index')->with('success', 'Mata Kuliah disimpan!');
    }
 
    /**
     * Memperbarui data mata kuliah berdasarkan ID.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id) {
        // Validasi input pembaruan data mata kuliah
        $request->validate([
            'kode_mk' => 'required|unique:matakuliah,kode_mk,' . $id,
            'nama_mk' => 'required',
            'sks' => 'required|numeric',
            'semester' => 'required|numeric'
        ]);
 
        // Temukan dan perbarui data mata kuliah
        Matakuliah::findOrFail($id)->update($request->all());
        return redirect()->route('matakuliah.index')->with('success', 'Mata Kuliah diupdate!');
    }
 
    /**
     * Menghapus data mata kuliah berdasarkan ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id) {
        Matakuliah::findOrFail($id)->delete();
        return redirect()->route('matakuliah.index')->with('success', 'Mata Kuliah dihapus!');
    }
}
