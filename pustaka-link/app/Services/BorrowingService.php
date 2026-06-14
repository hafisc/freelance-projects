<?php

namespace App\Services;

use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\Book;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BorrowingService
{
    /**
     * Memproses transaksi peminjaman buku baru.
     * Fungsi ini membungkus database transaction untuk menjamin data tersimpan utuh.
     * Otomatis menghitung jatuh tempo 7 hari dari borrow_date dan mengurangi stok buku.
     */
    public function createBorrowing(array $data): Borrowing
    {
        return DB::transaction(function () use ($data) {
            // 1. Hitung tanggal jatuh tempo otomatis (7 hari dari borrow_date)
            $borrowDate = Carbon::parse($data['borrow_date']);
            $dueDate = $borrowDate->copy()->addDays(7)->toDateString();

            // 2. Simpan transaksi utama peminjaman
            $borrowing = Borrowing::create([
                'member_id' => $data['member_id'],
                'borrow_date' => $data['borrow_date'],
                'due_date' => $dueDate,
                'status' => 'borrowed',
                'notes' => $data['notes'] ?? null,
            ]);

            // 3. Simpan detail peminjaman buku
            BorrowingDetail::create([
                'borrowing_id' => $borrowing->id,
                'book_id' => $data['book_id'],
                'quantity' => 1, // Dibatasi 1 buku per transaksi untuk demonstrasi
            ]);

            // 4. Kurangi stok buku fisik di perpustakaan
            $book = Book::findOrFail($data['book_id']);
            $book->decrement('stock', 1);

            return $borrowing;
        });
    }

    /**
     * Memproses pengembalian buku.
     * Mengubah status peminjaman menjadi 'returned', mengisi return_date hari ini,
     * serta mengembalikan stok buku fisik ke database.
     */
    public function returnBook(Borrowing $borrowing): Borrowing
    {
        return DB::transaction(function () use ($borrowing) {
            // Jika sudah dikembalikan sebelumnya, abaikan untuk mencegah double stock increment
            if ($borrowing->status === 'returned') {
                return $borrowing;
            }

            // 1. Ubah status transaksi & isi tanggal pengembalian hari ini
            $borrowing->update([
                'status' => 'returned',
                'return_date' => Carbon::now()->toDateString(),
            ]);

            // 2. Tambah kembali stok buku fisik yang dipinjam
            foreach ($borrowing->borrowingDetails as $detail) {
                $book = $detail->book;
                $book->increment('stock', $detail->quantity);
            }

            return $borrowing;
        });
    }
}
