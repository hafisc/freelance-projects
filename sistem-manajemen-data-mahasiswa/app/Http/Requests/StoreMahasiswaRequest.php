<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMahasiswaRequest extends FormRequest
{
    /**
     * Menentukan apakah pengguna diizinkan untuk membuat request ini.
     */
    public function authorize(): bool
    {
        // Izinkan admin terautentikasi untuk menyimpan data
        return true;
    }

    /**
     * Mendapatkan aturan validasi yang berlaku untuk request ini.
     */
    public function rules(): array
    {
        return [
            'nim' => ['required', 'string', 'max:20', 'unique:mahasiswas,nim'],
            'nama' => ['required', 'string', 'max:100'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tanggal_lahir' => ['required', 'date'],
            'alamat' => ['required', 'string'],
            'no_hp' => ['required', 'string', 'max:20'],
            'jurusan_id' => ['required', 'exists:jurusans,id'],
        ];
    }

    /**
     * Kustomisasi pesan validasi kesalahan dalam bahasa Indonesia.
     */
    public function messages(): array
    {
        return [
            'nim.required' => 'NIM wajib diisi.',
            'nim.string' => 'NIM harus berupa teks/angka.',
            'nim.max' => 'NIM maksimal 20 karakter.',
            'nim.unique' => 'NIM sudah terdaftar di sistem.',
            'nama.required' => 'Nama lengkap wajib diisi.',
            'nama.string' => 'Nama lengkap harus berupa teks.',
            'nama.max' => 'Nama lengkap maksimal 100 karakter.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin yang dipilih tidak valid.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid.',
            'alamat.required' => 'Alamat lengkap wajib diisi.',
            'alamat.string' => 'Alamat harus berupa teks.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.string' => 'Nomor HP harus berupa teks/angka.',
            'no_hp.max' => 'Nomor HP maksimal 20 karakter.',
            'jurusan_id.required' => 'Jurusan wajib dipilih.',
            'jurusan_id.exists' => 'Jurusan yang dipilih tidak terdaftar di sistem.',
        ];
    }
}
