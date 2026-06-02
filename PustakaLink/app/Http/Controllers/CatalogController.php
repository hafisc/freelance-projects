<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    /**
     * Menampilkan katalog buku untuk pengunjung / petugas.
     * Dilengkapi fitur pencarian dan filter kategori secara dinamis.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');

        // Ambil semua kategori unik dari database untuk filter dropdown
        $categories = Book::whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->pluck('category')
            ->toArray();

        $books = Book::when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('author', 'like', "%{$search}%")
                      ->orWhere('book_code', 'like', "%{$search}%");
                });
            })
            ->when($category, function ($query, $category) {
                return $query->where('category', $category);
            })
            ->orderBy('title', 'asc')
            ->paginate(12)
            ->withQueryString();

        return view('catalog.index', compact('books', 'categories', 'search', 'category'));
    }
}
