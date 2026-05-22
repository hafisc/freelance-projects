<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJurusanRequest extends FormRequest
{
    /**
     * Menentukan apakah pengguna diizinkan untuk membuat request ini.
     */
    public function authorize(): bool
    {
        // Izinkan semua admin yang terautentikasi untuk menyimpan data
        return true;
    }

    /**
     * Mendapatkan aturan validasi yang berlaku untuk request ini.
     */
    public function rules(): array
    {
        return [
            'nama_jurusan' => ['required', 'string', 'max:100', 'unique:jurusans,nama_jurusan'],
            'keterangan' => ['nullable', 'string'],
        ];
    }

    /**
     * Kustomisasi pesan validasi kesalahan dalam bahasa Indonesia.
     */
    public function messages(): array
    {
        return [
            'nama_jurusan.required' => 'Nama jurusan wajib diisi.',
            'nama_jurusan.string' => 'Nama jurusan harus berupa teks.',
            'nama_jurusan.max' => 'Nama jurusan maksimal 100 karakter.',
            'nama_jurusan.unique' => 'Nama jurusan sudah terdaftar di sistem.',
            'keterangan.string' => 'Keterangan harus berupa teks.',
        ];
    }
}
