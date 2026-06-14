<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BorrowingDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'borrowing_id',
        'book_id',
        'quantity',
    ];

    /**
     * Relasi ke model Borrowing (Transaksi Peminjaman).
     * Setiap detail dimiliki oleh satu transaksi peminjaman.
     */
    public function borrowing(): BelongsTo
    {
        return $this->belongsTo(Borrowing::class);
    }

    /**
     * Relasi ke model Book (Buku).
     * Setiap detail buku yang dipinjam mengacu ke satu buku.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
