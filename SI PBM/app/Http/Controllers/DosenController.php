<?php
 
namespace App\Http\Controllers;
 
use App\Models\Dosen; 
use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
 
class DosenController extends Controller
{
    /**
     * Menampilkan daftar semua dosen pengampu.
     * Mengarahkan ke view admin atau operator berdasarkan role user yang aktif.
     *
     * @return \Illuminate\View\View
     */
    public function index() {
        $dosens = Dosen::all();
        $viewPrefix = (session('role') === 'Operator') ? 'operator' : 'admin';
        return view($viewPrefix . '.dosen.index', compact('dosens'));
    }
 
    /**
     * Menyimpan data dosen baru ke database dan membuat akun login terkait secara otomatis.
     * NIDN digunakan sebagai password default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) {
        // Validasi input data dosen
        $request->validate([
            'nidn' => 'required|unique:dosen,nidn',
            'nama_dosen' => 'required',
            'keahlian' => 'required',
            'email' => 'required|email|unique:dosen,email',
            'no_hp' => 'nullable',
        ]);
 
        // Simpan data dosen ke database
        $dosen = Dosen::create($request->all());
 
        // Buat akun user otomatis agar Dosen bisa login ke portal
        User::create([
            'name' => $request->nama_dosen,
            'email' => $request->email,
            'password' => Hash::make($request->nidn), // Password default NIDN
            'role' => 'Dosen',
            'dosen_id' => $dosen->id,
        ]);
 
        return redirect()->route('dosen.index')->with('success', 'Data Dosen berhasil ditambahkan!');
    }
 
    /**
     * Memperbarui data profil dosen beserta akun login miliknya.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id) {
        $dosen = Dosen::findOrFail($id);
 
        // Validasi data dosen dengan pengecualian ID saat ini untuk nilai unik
        $request->validate([
            'nidn' => 'required|unique:dosen,nidn,' . $id,
            'nama_dosen' => 'required',
            'keahlian' => 'required',
            'email' => 'required|email|unique:dosen,email,' . $id,
            'no_hp' => 'nullable',
        ]);
 
        // Perbarui data dosen
        $dosen->update($request->all());
 
        // Perbarui data user terkait (Nama dan Email)
        User::where('dosen_id', $id)->update([
            'name' => $request->nama_dosen,
            'email' => $request->email,
        ]);
 
        return redirect()->route('dosen.index')->with('success', 'Data Dosen berhasil diperbarui!');
    }
 
    /**
     * Menghapus data dosen beserta akun login terkait.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id) {
        // Hapus user terkait dahulu untuk menjaga integritas data
        User::where('dosen_id', $id)->delete();
        Dosen::findOrFail($id)->delete();
 
        return redirect()->route('dosen.index')->with('success', 'Data Dosen berhasil dihapus!');
    }
}
