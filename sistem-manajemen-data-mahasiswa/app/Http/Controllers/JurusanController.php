<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Http\Requests\StoreJurusanRequest;
use App\Http\Requests\UpdateJurusanRequest;

class JurusanController extends Controller
{
    /**
     * Menampilkan daftar jurusan dengan pagination.
     */
    public function index()
    {
        // Mengambil data jurusan terbaru dengan batasan 5 data per halaman
        $jurusans = Jurusan::latest()->paginate(5);

        return view('jurusan.index', compact('jurusans'));
    }

    /**
     * Menampilkan form untuk menambah jurusan baru.
     */
    public function create()
    {
        return view('jurusan.create');
    }

    /**
     * Menyimpan data jurusan baru ke database.
     */
    public function store(StoreJurusanRequest $request)
    {
        // Data yang dikirim otomatis tervalidasi oleh StoreJurusanRequest
        $validatedData = $request->validated();

        // Menyimpan data jurusan baru ke database
        Jurusan::create($validatedData);

        // Mengarahkan kembali ke halaman index dengan pesan sukses
        return redirect()->route('jurusan.index')
            ->with('success', 'Data jurusan berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail jurusan beserta mahasiswa di dalamnya.
     */
    public function show(Jurusan $jurusan)
    {
        // Memuat relasi mahasiswa yang terdaftar di jurusan ini
        $jurusan->load('mahasiswas');

        return view('jurusan.show', compact('jurusan'));
    }

    /**
     * Menampilkan form untuk mengedit data jurusan.
     */
    public function edit(Jurusan $jurusan)
    {
        return view('jurusan.edit', compact('jurusan'));
    }

    /**
     * Memperbarui data jurusan di database.
     */
    public function update(UpdateJurusanRequest $request, Jurusan $jurusan)
    {
        // Data tervalidasi secara otomatis oleh UpdateJurusanRequest
        $validatedData = $request->validated();

        // Mengubah data jurusan yang ada
        $jurusan->update($validatedData);

        // Mengarahkan kembali ke halaman daftar jurusan dengan pesan sukses
        return redirect()->route('jurusan.index')
            ->with('success', 'Data jurusan berhasil diperbarui.');
    }

    /**
     * Menghapus data jurusan dari database.
     */
    public function destroy(Jurusan $jurusan)
    {
        // Menghapus data jurusan terpilih (mahasiswa di dalamnya akan terhapus otomatis karena cascade)
        $jurusan->delete();

        // Mengarahkan kembali ke halaman index dengan pesan sukses
        return redirect()->route('jurusan.index')
            ->with('success', 'Data jurusan berhasil dihapus.');
    }
}
