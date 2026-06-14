<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class MahasiswaController extends Controller
{
    /**
     * Menampilkan daftar semua mahasiswa.
     */
    public function index()
    {
        // Ambil mahasiswa beserta relasi user
        $mahasiswa = Mahasiswa::with('user')->latest()->paginate(10);
        return view('admin.mahasiswa.index', compact('mahasiswa'));
    }

    /**
     * Menampilkan form untuk membuat mahasiswa baru.
     */
    public function create()
    {
        return view('admin.mahasiswa.create');
    }

    /**
     * Menyimpan data mahasiswa baru beserta akun user-nya.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nim' => 'required|string|unique:mahasiswa,nim|max:20',
            'nama' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'prodi' => 'required|string|max:100',
            'angkatan' => 'required|numeric|min:2000|max:2100',
            'no_hp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
            'email' => 'required|email|unique:users,email|max:100',
            'password' => 'required|string|min:6',
        ], [
            'nim.required' => 'NIM wajib diisi.',
            'nim.unique' => 'NIM sudah terdaftar.',
            'nama.required' => 'Nama mahasiswa wajib diisi.',
            'email.required' => 'Email untuk login wajib diisi.',
            'email.unique' => 'Email sudah digunakan oleh user lain.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Menggunakan DB Transaction untuk memastikan integritas data
        DB::beginTransaction();
        try {
            // 1. Dapatkan role Mahasiswa
            $mahasiswaRole = Role::where('name', 'Mahasiswa')->first();
            $roleId = $mahasiswaRole ? $mahasiswaRole->id : 3;

            // 2. Buat user login
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $roleId,
                'status' => 'aktif',
            ]);

            // 3. Buat profil mahasiswa
            Mahasiswa::create([
                'user_id' => $user->id,
                'nim' => $request->nim,
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'prodi' => $request->prodi,
                'angkatan' => $request->angkatan,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);

            DB::commit();
            return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menampilkan detail mahasiswa (alihkan ke index).
     */
    public function show(string $id)
    {
        return redirect()->route('mahasiswa.index');
    }

    /**
     * Menampilkan form edit mahasiswa.
     */
    public function edit(string $id)
    {
        $mahasiswa = Mahasiswa::with('user')->findOrFail($id);
        return view('admin.mahasiswa.edit', compact('mahasiswa'));
    }

    /**
     * Memperbarui data mahasiswa di database.
     */
    public function update(Request $request, string $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $user = $mahasiswa->user;

        // Validasi input
        $request->validate([
            'nim' => 'required|string|max:20|unique:mahasiswa,nim,' . $mahasiswa->id,
            'nama' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'prodi' => 'required|string|max:100',
            'angkatan' => 'required|numeric|min:2000|max:2100',
            'no_hp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
            'email' => 'required|email|max:100|unique:users,email,' . ($user ? $user->id : 0),
            'password' => 'nullable|string|min:6',
        ], [
            'nim.required' => 'NIM wajib diisi.',
            'nim.unique' => 'NIM sudah digunakan.',
            'nama.required' => 'Nama mahasiswa wajib diisi.',
            'email.required' => 'Email wajib diisi.',
        ]);

        DB::beginTransaction();
        try {
            // 1. Perbarui profil mahasiswa
            $mahasiswa->update([
                'nim' => $request->nim,
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'prodi' => $request->prodi,
                'angkatan' => $request->angkatan,
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
            return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menghapus data mahasiswa beserta user login-nya.
     */
    public function destroy(string $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $user = $mahasiswa->user;

        DB::beginTransaction();
        try {
            // Hapus profil mahasiswa
            $mahasiswa->delete();

            // Hapus user terkait
            if ($user) {
                $user->delete();
            }

            DB::commit();
            return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa dan akun berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('mahasiswa.index')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
