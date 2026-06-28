<?php
 
namespace App\Http\Controllers;
 
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
 
class MahasiswaController extends Controller
{
    /**
     * Menampilkan daftar semua mahasiswa.
     * Mengarahkan ke view admin atau operator berdasarkan role user yang aktif.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $mahasiswa = Mahasiswa::all();
        $viewPrefix = (session('role') === 'Operator') ? 'operator' : 'admin';
        return view($viewPrefix . '.mahasiswa.index', compact('mahasiswa'));
    }
 
    /**
     * Menampilkan formulir pendaftaran mahasiswa baru.
     * Mengarahkan ke view admin/operator berdasarkan role user yang aktif.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $viewPrefix = (session('role') === 'Operator') ? 'operator' : 'admin';
        return view($viewPrefix . '.mahasiswa.create'); 
    }
 
    /**
     * Menyimpan data mahasiswa baru dan membuat akun login terkait secara otomatis.
     * NIM digunakan sebagai password default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input data utama mahasiswa
        $request->validate([
            'nim' => 'required|unique:mahasiswa,nim|numeric',
            'nama' => 'required|string|max:255',
            'prodi' => 'required|string',
            'tahun_masuk' => 'required|integer|digits:4',
        ]);
 
        $data = $request->only(['nim', 'nama', 'prodi', 'tahun_masuk']);
 
        // Mengisi kolom default pendukung karena tabel bersifat NOT NULL
        $data['tempat_lahir'] = '-';
        $data['tanggal_lahir'] = '2000-01-01';
        $data['jenis_kelamin'] = 'Laki-laki';
        $data['agama'] = '-';
        $data['no_telepon'] = '0';
        $data['email'] = $request->nim . '@sipbm.ac.id';
        $data['asal_sekolah'] = '-';
        $data['nama_wali'] = '-';
        $data['fakultas'] = '-';
        $data['status_mahasiswa'] = 'Aktif';
        $data['alamat'] = '-';
 
        // Simpan data mahasiswa ke database
        Mahasiswa::create($data);
 
        // Buat akun user otomatis agar mahasiswa bisa langsung login
        User::create([
            'name' => $request->nama,
            'email' => $request->nim . '@sipbm.ac.id',
            'password' => Hash::make($request->nim), // Password default = NIM
            'role' => 'Mahasiswa',
            'nim' => $request->nim,
        ]);
 
        return redirect()->route('data-mahasiswa')->with('success', 'Mahasiswa berhasil ditambahkan dan akun dibuat!');
    }
 
    /**
     * Menampilkan form edit profil mahasiswa berdasarkan NIM.
     *
     * @param  string  $nim
     * @return \Illuminate\View\View
     */
    public function edit($nim)
    {
        $mahasiswa = Mahasiswa::findOrFail($nim);
        $viewPrefix = (session('role') === 'Operator') ? 'operator' : 'admin';
        return view($viewPrefix . '.mahasiswa.edit', compact('mahasiswa'));
    }
 
    /**
     * Memperbarui data profil mahasiswa beserta akun login miliknya.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $nim
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $nim)
    {
        $mahasiswa = Mahasiswa::findOrFail($nim);
        
        $request->validate([
            'nim' => 'required|numeric|unique:mahasiswa,nim,' . $nim . ',nim',
            'nama' => 'required|string|max:255',
            'prodi' => 'required|string',
            'tahun_masuk' => 'required|integer|digits:4',
        ]);
 
        // Perbarui data mahasiswa
        $mahasiswa->update($request->only(['nim', 'nama', 'prodi', 'tahun_masuk']));
 
        // Perbarui data pada user account
        User::where('nim', $nim)->update([
            'name' => $request->nama,
            'nim' => $request->nim,
            'email' => $request->nim . '@sipbm.ac.id',
        ]);
 
        return redirect()->route('data-mahasiswa')->with('success', 'Data mahasiswa berhasil diperbarui!');
    }
 
    /**
     * Menghapus data mahasiswa beserta akun login terkait.
     *
     * @param  string  $nim
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($nim)
    {
        // Hapus akun login terlebih dahulu agar tidak menjadi yatim/orphan
        User::where('nim', $nim)->delete();
        Mahasiswa::findOrFail($nim)->delete();
 
        return redirect()->route('data-mahasiswa')->with('success', 'Data mahasiswa berhasil dihapus!');
    }
}
