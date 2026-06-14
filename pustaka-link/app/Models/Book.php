<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_code',
        'title',
        'author',
        'publisher',
        'publication_year',
        'category',
        'stock',
        'description',
    ];

    /**
     * Relasi ke model BorrowingDetail.
     * Satu buku dapat dipinjam dalam banyak detail transaksi peminjaman.
     */
    public function borrowingDetails(): HasMany
    {
        return $this->hasMany(BorrowingDetail::class);
    }
}
