<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard utama perpustakaan.
     * Mengambil statistik ringkas dan daftar peminjaman sirkulasi terbaru.
     */
    public function index()
    {
        // 1. Ambil data statistik ringkas
        $totalBooks = Book::count();
        $totalMembers = Member::count();
        $activeBorrowings = Borrowing::where('status', 'borrowed')->count();
        $availableBooks = Book::sum('stock');

        // 2. Ambil 5 transaksi peminjaman terbaru
        $latestBorrowings = Borrowing::with(['member', 'borrowingDetails.book'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'totalBooks', 
            'totalMembers', 
            'activeBorrowings', 
            'availableBooks', 
            'latestBorrowings'
        ));
    }
}
