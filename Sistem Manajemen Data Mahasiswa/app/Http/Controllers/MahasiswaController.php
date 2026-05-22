<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Jurusan;
use App\Http\Requests\StoreMahasiswaRequest;
use App\Http\Requests\UpdateMahasiswaRequest;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Menampilkan daftar mahasiswa beserta fitur pencarian dan pagination.
     */
    public function index(Request $request)
    {
        // Mengambil input query pencarian
        $search = $request->input('search');

        // Query dasar mahasiswa dengan memuat relasi jurusan
        $query = Mahasiswa::with('jurusan');

        // Jika terdapat query pencarian, filter data berdasarkan NIM atau Nama
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nim', 'like', '%' . $search . '%')
                  ->orWhere('nama', 'like', '%' . $search . '%');
            });
        }

        // Ambil data dengan batasan 5 data per halaman, tetap mempertahankan parameter pencarian pada URL
        $mahasiswas = $query->latest()->paginate(5)->withQueryString();

        return view('mahasiswa.index', compact('mahasiswas', 'search'));
    }

    /**
     * Menampilkan form untuk menambah mahasiswa baru.
     */
    public function create()
    {
        // Mengambil seluruh data jurusan untuk pilihan dropdown
        $jurusans = Jurusan::orderBy('nama_jurusan', 'asc')->get();

        return view('mahasiswa.create', compact('jurusans'));
    }

    /**
     * Menyimpan data mahasiswa baru ke database.
     */
    public function store(StoreMahasiswaRequest $request)
    {
        // Data tervalidasi secara otomatis oleh StoreMahasiswaRequest
        $validatedData = $request->validated();

        // Menyimpan data mahasiswa baru
        Mahasiswa::create($validatedData);

        // Mengarahkan kembali ke daftar mahasiswa dengan pesan sukses
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail lengkap seorang mahasiswa.
     */
    public function show(Mahasiswa $mahasiswa)
    {
        // Memuat relasi jurusan mahasiswa
        $mahasiswa->load('jurusan');

        return view('mahasiswa.show', compact('mahasiswa'));
    }

    /**
     * Menampilkan form untuk mengedit data mahasiswa.
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        // Mengambil seluruh data jurusan untuk pilihan dropdown
        $jurusans = Jurusan::orderBy('nama_jurusan', 'asc')->get();

        return view('mahasiswa.edit', compact('mahasiswa', 'jurusans'));
    }

    /**
     * Memperbarui data mahasiswa di database.
     */
    public function update(UpdateMahasiswaRequest $request, Mahasiswa $mahasiswa)
    {
        // Data tervalidasi secara otomatis oleh UpdateMahasiswaRequest
        $validatedData = $request->validated();

        // Mengubah data mahasiswa
        $mahasiswa->update($validatedData);

        // Mengarahkan kembali ke daftar mahasiswa dengan pesan sukses
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    /**
     * Menghapus data mahasiswa dari database.
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        // Menghapus data mahasiswa terpilih
        $mahasiswa->delete();

        // Mengarahkan kembali ke daftar mahasiswa dengan pesan sukses
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil dihapus.');
    }
}
