<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MataKuliah;

class MataKuliahController extends Controller
{
    /**
     * Menampilkan daftar mata kuliah.
     */
    public function index()
    {
        $mataKuliah = MataKuliah::latest()->paginate(10);
        return view('admin.mata-kuliah.index', compact('mataKuliah'));
    }

    /**
     * Menampilkan form untuk membuat mata kuliah baru.
     */
    public function create()
    {
        return view('admin.mata-kuliah.create');
    }

    /**
     * Menyimpan data mata kuliah baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_mk' => 'required|string|max:20|unique:mata_kuliah,kode_mk',
            'nama_mk' => 'required|string|max:100',
            'sks' => 'required|numeric|min:1|max:6',
            'semester' => 'required|numeric|min:1|max:8',
        ], [
            'kode_mk.required' => 'Kode mata kuliah wajib diisi.',
            'kode_mk.unique' => 'Kode mata kuliah sudah digunakan.',
            'nama_mk.required' => 'Nama mata kuliah wajib diisi.',
            'sks.required' => 'SKS wajib diisi.',
            'sks.numeric' => 'SKS harus berupa angka.',
            'semester.required' => 'Semester wajib diisi.',
        ]);

        MataKuliah::create($request->all());

        return redirect()->route('mata-kuliah.index')->with('success', 'Data mata kuliah berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail mata kuliah (alihkan ke index).
     */
    public function show(string $id)
    {
        return redirect()->route('mata-kuliah.index');
    }

    /**
     * Menampilkan form edit mata kuliah.
     */
    public function edit(string $id)
    {
        $mataKuliah = MataKuliah::findOrFail($id);
        return view('admin.mata-kuliah.edit', compact('mataKuliah'));
    }

    /**
     * Memperbarui data mata kuliah di database.
     */
    public function update(Request $request, string $id)
    {
        $mataKuliah = MataKuliah::findOrFail($id);

        $request->validate([
            'kode_mk' => 'required|string|max:20|unique:mata_kuliah,kode_mk,' . $mataKuliah->id,
            'nama_mk' => 'required|string|max:100',
            'sks' => 'required|numeric|min:1|max:6',
            'semester' => 'required|numeric|min:1|max:8',
        ], [
            'kode_mk.required' => 'Kode mata kuliah wajib diisi.',
            'kode_mk.unique' => 'Kode mata kuliah sudah digunakan.',
            'nama_mk.required' => 'Nama mata kuliah wajib diisi.',
            'sks.required' => 'SKS wajib diisi.',
            'sks.numeric' => 'SKS harus berupa angka.',
        ]);

        $mataKuliah->update($request->all());

        return redirect()->route('mata-kuliah.index')->with('success', 'Data mata kuliah berhasil diperbarui.');
    }

    /**
     * Menghapus data mata kuliah dari database.
     */
    public function destroy(string $id)
    {
        $mataKuliah = MataKuliah::findOrFail($id);
        $mataKuliah->delete();

        return redirect()->route('mata-kuliah.index')->with('success', 'Data mata kuliah berhasil dihapus.');
    }
}
