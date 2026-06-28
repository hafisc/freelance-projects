<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\{User, Mahasiswa, Dosen};
use Illuminate\Support\Facades\Hash;
 
class UserController extends Controller
{
    /**
     * Menampilkan daftar semua user sistem beserta relasi Mahasiswa/Dosen.
     * Juga mengirim daftar mahasiswa dan dosen yang belum memiliki akun untuk form penambahan.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::with(['mahasiswa', 'dosen'])->get();
        $mahasiswas = Mahasiswa::whereDoesntHave('user')->get();
        $dosens = Dosen::whereDoesntHave('user')->get();
 
        return view('admin.users.index', compact('users', 'mahasiswas', 'dosens'));
    }
 
    /**
     * Menyimpan user login baru ke database.
     * Melakukan sinkronisasi data nama jika role adalah Mahasiswa atau Dosen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input data pengguna baru
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:Admin,Operator,Dosen,Mahasiswa',
            'nim' => 'required_if:role,Mahasiswa|nullable|exists:mahasiswa,nim',
            'dosen_id' => 'required_if:role,Dosen|nullable|exists:dosen,id',
        ]);
 
        $data = $request->only(['name', 'email', 'role']);
        $data['password'] = Hash::make($request->password);
 
        // Sinkronisasi data nama sesuai relasi Mahasiswa / Dosen
        if ($request->role === 'Mahasiswa') {
            $data['nim'] = $request->nim;
            $mhs = Mahasiswa::findOrFail($request->nim);
            $data['name'] = $mhs->nama;
        } elseif ($request->role === 'Dosen') {
            $data['dosen_id'] = $request->dosen_id;
            $dsn = Dosen::findOrFail($request->dosen_id);
            $data['name'] = $dsn->nama_dosen;
        }
 
        // Simpan data user
        User::create($data);
 
        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan!');
    }
 
    /**
     * Memperbarui data user login yang ada.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
 
        // Validasi input data pembaruan user
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:Admin,Operator,Dosen,Mahasiswa',
            'nim' => 'required_if:role,Mahasiswa|nullable|exists:mahasiswa,nim',
            'dosen_id' => 'required_if:role,Dosen|nullable|exists:dosen,id',
        ]);
 
        $data = $request->only(['name', 'email', 'role']);
        
        // Perbarui password jika kolom diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
 
        // Bersihkan atau perbarui relasi role
        if ($request->role === 'Mahasiswa') {
            $data['nim'] = $request->nim;
            $data['dosen_id'] = null;
            $mhs = Mahasiswa::findOrFail($request->nim);
            $data['name'] = $mhs->nama;
        } elseif ($request->role === 'Dosen') {
            $data['dosen_id'] = $request->dosen_id;
            $data['nim'] = null;
            $dsn = Dosen::findOrFail($request->dosen_id);
            $data['name'] = $dsn->nama_dosen;
        } else {
            $data['nim'] = null;
            $data['dosen_id'] = null;
        }
 
        $user->update($data);
 
        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui!');
    }
 
    /**
     * Menghapus user login berdasarkan ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus!');
    }
}
