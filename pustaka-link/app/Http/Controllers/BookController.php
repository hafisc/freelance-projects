<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Menampilkan daftar koleksi buku perpustakaan.
     * Mendukung fitur pencarian judul, penulis, penerbit, kategori, atau kode buku.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $books = Book::when($search, function ($query, $search) {
            return $query->where('title', 'like', "%{$search}%")
                         ->orWhere('author', 'like', "%{$search}%")
                         ->orWhere('book_code', 'like', "%{$search}%")
                         ->orWhere('category', 'like', "%{$search}%");
        })
        ->orderBy('book_code', 'asc')
        ->paginate(10)
        ->withQueryString();

        return view('books.index', compact('books', 'search'));
    }

    /**
     * Menampilkan form tambah buku baru.
     */
    public function create()
    {
        // Generate otomatis book code rekomendasi jika diinginkan
        $lastBook = Book::orderBy('id', 'desc')->first();
        $nextCode = 'BK-0001';
        if ($lastBook) {
            $lastNum = (int) substr($lastBook->book_code, 3);
            $nextCode = 'BK-' . sprintf('%04d', $lastNum + 1);
        }

        return view('books.create', compact('nextCode'));
    }

    /**
     * Menyimpan data buku baru ke database.
     * Menggunakan StoreBookRequest untuk validasi data.
     */
    public function store(StoreBookRequest $request)
    {
        Book::create($request->validated());

        return redirect()->route('books.index')
            ->with('toast_success', 'Data buku baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail buku beserta informasi siapa saja yang pernah meminjam.
     */
    public function show(Book $book)
    {
        // Load data peminjaman detail beserta transaksi peminjaman utama dan anggotanya
        $book->load(['borrowingDetails' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }, 'borrowingDetails.borrowing.member']);

        return view('books.show', compact('book'));
    }

    /**
     * Menampilkan form untuk mengedit informasi buku.
     */
    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    /**
     * Memperbarui data buku di database.
     * Menggunakan UpdateBookRequest untuk validasi data.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        $book->update($request->validated());

        return redirect()->route('books.index')
            ->with('toast_success', 'Data buku berhasil diperbarui.');
    }

    /**
     * Menghapus data buku dari database.
     * Mencegah penghapusan jika buku tersebut terikat dengan transaksi peminjaman.
     */
    public function destroy(Book $book)
    {
        // Cek jika buku masih ada di riwayat detail transaksi peminjaman
        if ($book->borrowingDetails()->exists()) {
            return redirect()->route('books.index')
                ->with('toast_error', 'Gagal menghapus! Buku ini masih terikat dengan transaksi peminjaman.');
        }

        $book->delete();

        return redirect()->route('books.index')
            ->with('toast_success', 'Data buku berhasil dihapus.');
    }
}
