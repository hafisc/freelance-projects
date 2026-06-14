<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna diotorisasi untuk membuat permintaan ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi untuk menyimpan data buku baru.
     */
    public function rules(): array
    {
        return [
            'book_code' => ['required', 'string', 'max:50', 'unique:books,book_code'],
            'title' => ['required', 'string', 'max:255'],
            'author' => ['nullable', 'string', 'max:255'],
            'publisher' => ['nullable', 'string', 'max:255'],
            'publication_year' => ['nullable', 'integer', 'min:1000', 'max:' . date('Y')],
            'category' => ['nullable', 'string', 'max:100'],
            'stock' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
        ];
    }

    /**
     * Kustomisasi pesan kesalahan validasi.
     */
    public function messages(): array
    {
        return [
            'book_code.required' => 'Kode buku wajib diisi.',
            'book_code.unique' => 'Kode buku sudah terdaftar di sistem.',
            'title.required' => 'Judul buku wajib diisi.',
            'stock.required' => 'Jumlah stok buku wajib diisi.',
            'stock.integer' => 'Stok buku harus berupa angka.',
            'stock.min' => 'Stok buku minimal bernilai 0.',
            'publication_year.integer' => 'Tahun terbit harus berupa angka.',
            'publication_year.min' => 'Tahun terbit tidak valid.',
            'publication_year.max' => 'Tahun terbit tidak boleh melebihi tahun sekarang.',
        ];
    }
}
