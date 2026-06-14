<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Dosen;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DosenController extends Controller
{
    /**
     * Menampilkan daftar semua dosen.
     */
    public function index()
    {
        // Ambil dosen beserta relasi user
        $dosen = Dosen::with('user')->latest()->paginate(10);
        return view('admin.dosen.index', compact('dosen'));
    }

    /**
     * Menampilkan form untuk membuat dosen baru.
     */
    public function create()
    {
        return view('admin.dosen.create');
    }

    /**
     * Menyimpan data dosen baru beserta akun user-nya.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nidn' => 'required|string|unique:dosen,nidn|max:20',
            'nama' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_hp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
            'email' => 'required|email|unique:users,email|max:100',
            'password' => 'required|string|min:6',
        ], [
            'nidn.required' => 'NIDN wajib diisi.',
            'nidn.unique' => 'NIDN sudah terdaftar.',
            'nama.required' => 'Nama dosen wajib diisi.',
            'email.required' => 'Email untuk login wajib diisi.',
            'email.unique' => 'Email sudah digunakan oleh user lain.',
            'password.required' => 'Password wajib diisi.',
        ]);

        DB::beginTransaction();
        try {
            // 1. Dapatkan role Dosen
            $dosenRole = Role::where('name', 'Dosen')->first();
            $roleId = $dosenRole ? $dosenRole->id : 2;

            // 2. Buat user login
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $roleId,
                'status' => 'aktif',
            ]);

            // 3. Buat profil dosen
            Dosen::create([
                'user_id' => $user->id,
                'nidn' => $request->nidn,
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);

            DB::commit();
            return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menampilkan detail dosen (alihkan ke index).
     */
    public function show(string $id)
    {
        return redirect()->route('dosen.index');
    }

    /**
     * Menampilkan form edit dosen.
     */
    public function edit(string $id)
    {
        $dosen = Dosen::with('user')->findOrFail($id);
        return view('admin.dosen.edit', compact('dosen'));
    }

    /**
     * Memperbarui data dosen di database.
     */
    public function update(Request $request, string $id)
    {
        $dosen = Dosen::findOrFail($id);
        $user = $dosen->user;

        // Validasi input
        $request->validate([
            'nidn' => 'required|string|max:20|unique:dosen,nidn,' . $dosen->id,
            'nama' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_hp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
            'email' => 'required|email|max:100|unique:users,email,' . ($user ? $user->id : 0),
            'password' => 'nullable|string|min:6',
        ], [
            'nidn.required' => 'NIDN wajib diisi.',
            'nidn.unique' => 'NIDN sudah digunakan.',
            'nama.required' => 'Nama dosen wajib diisi.',
            'email.required' => 'Email wajib diisi.',
        ]);

        DB::beginTransaction();
        try {
            // 1. Perbarui profil dosen
            $dosen->update([
                'nidn' => $request->nidn,
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);

            // 2. Perbarui data user
            if ($user) {
                $userData = [
                    'name' => $request->nama,
                    'email' => $request->email,
                ];

                if ($request->filled('password')) {
                    $userData['password'] = Hash::make($request->password);
                }

                $user->update($userData);
            }

            DB::commit();
            return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menghapus data dosen beserta user login-nya.
     */
    public function destroy(string $id)
    {
        $dosen = Dosen::findOrFail($id);
        $user = $dosen->user;

        DB::beginTransaction();
        try {
            // Hapus profil dosen
            $dosen->delete();

            // Hapus user terkait
            if ($user) {
                $user->delete();
            }

            DB::commit();
            return redirect()->route('dosen.index')->with('success', 'Data dosen dan akun berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('dosen.index')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
