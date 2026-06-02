<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Book;

class StoreBorrowingRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna diotorisasi untuk membuat permintaan ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi untuk transaksi peminjaman baru.
     */
    public function rules(): array
    {
        return [
            'member_id' => ['required', 'exists:members,id'],
            'book_id' => [
                'required', 
                'exists:books,id',
                function ($attribute, $value, $fail) {
                    $book = Book::find($value);
                    if ($book && $book->stock <= 0) {
                        $fail('Buku "' . $book->title . '" tidak dapat dipinjam karena stok habis.');
                    }
                }
            ],
            'borrow_date' => ['required', 'date', 'date_format:Y-m-d'],
            'notes' => ['nullable', 'string'],
        ];
    }

    /**
     * Kustomisasi pesan kesalahan validasi.
     */
    public function messages(): array
    {
        return [
            'member_id.required' => 'Anggota perpustakaan wajib dipilih.',
            'member_id.exists' => 'Anggota yang dipilih tidak terdaftar.',
            'book_id.required' => 'Buku yang akan dipinjam wajib dipilih.',
            'book_id.exists' => 'Buku yang dipilih tidak terdaftar.',
            'borrow_date.required' => 'Tanggal pinjam wajib diisi.',
            'borrow_date.date' => 'Format tanggal pinjam tidak valid.',
            'borrow_date.date_format' => 'Format tanggal pinjam harus YYYY-MM-DD.',
        ];
    }
}
