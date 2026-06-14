<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Member;
use App\Models\Book;
use App\Http\Requests\StoreBorrowingRequest;
use App\Services\BorrowingService;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    protected $borrowingService;

    /**
     * Injeksi dependensi BorrowingService ke controller.
     */
    public function __construct(BorrowingService $borrowingService)
    {
        $this->borrowingService = $borrowingService;
    }

    /**
     * Menampilkan daftar transaksi peminjaman yang AKTIF (status: borrowed).
     * Mendukung pencarian berdasarkan nama anggota atau judul buku.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $borrowings = Borrowing::with(['member', 'borrowingDetails.book'])
            ->where('status', 'borrowed')
            ->when($search, function ($query, $search) {
                return $query->whereHas('member', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhereHas('borrowingDetails.book', function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%");
                });
            })
            ->orderBy('due_date', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('borrowings.index', compact('borrowings', 'search'));
    }

    /**
     * Menampilkan RIWAYAT LENGKAP seluruh transaksi peminjaman (borrowed & returned).
     */
    public function history(Request $request)
    {
        $search = $request->input('search');

        $borrowings = Borrowing::with(['member', 'borrowingDetails.book'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('member', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhereHas('borrowingDetails.book', function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('borrowings.history', compact('borrowings', 'search'));
    }

    /**
     * Menampilkan form untuk mencatat peminjaman baru.
     * Hanya menyertakan buku yang memiliki stok > 0.
     */
    public function create()
    {
        $members = Member::orderBy('name', 'asc')->get();
        
        // Hanya buku dengan stok minimal 1 yang boleh dipinjam
        $books = Book::where('stock', '>', 0)->orderBy('title', 'asc')->get();

        return view('borrowings.create', compact('members', 'books'));
    }

    /**
     * Menyimpan transaksi peminjaman baru ke database.
     * Menggunakan validasi StoreBorrowingRequest dan memanggil logic di BorrowingService.
     */
    public function store(StoreBorrowingRequest $request)
    {
        $borrowing = $this->borrowingService->createBorrowing($request->validated());

        return redirect()->route('borrowings.index')
            ->with('toast_success', 'Transaksi peminjaman buku berhasil dicatat.');
    }

    /**
     * Menampilkan rincian detail transaksi peminjaman.
     */
    public function show(Borrowing $borrowing)
    {
        $borrowing->load(['member', 'borrowingDetails.book']);
        
        return view('borrowings.show', compact('borrowing'));
    }

    /**
     * Memproses pengembalian buku dari status borrowed menjadi returned.
     * Memanggil logic di BorrowingService untuk menambah kembali stok buku.
     */
    public function returnBook(Borrowing $borrowing)
    {
        if ($borrowing->status === 'returned') {
            return redirect()->back()
                ->with('toast_error', 'Transaksi ini sudah selesai dikembalikan sebelumnya.');
        }

        $this->borrowingService->returnBook($borrowing);

        return redirect()->route('borrowings.index')
            ->with('toast_success', 'Buku telah berhasil dikembalikan, stok buku diperbarui.');
    }
}
