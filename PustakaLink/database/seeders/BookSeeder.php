<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Menambahkan beberapa data buku perpustakaan contoh.
     */
    public function run(): void
    {
        $books = [
            [
                'book_code' => 'BK-0001',
                'title' => 'Dasar Pemrograman Java',
                'author' => 'Abdul Kadir',
                'publisher' => 'Andi Publisher',
                'publication_year' => 2020,
                'category' => 'Pemrograman',
                'stock' => 10,
                'description' => 'Buku panduan lengkap untuk mempelajari dasar-dasar pemrograman Java.',
            ],
            [
                'book_code' => 'BK-0002',
                'title' => 'Belajar Laravel 11 untuk Pemula',
                'author' => 'Rian Ardiansyah',
                'publisher' => 'Pustaka Coding',
                'publication_year' => 2024,
                'category' => 'Pemrograman',
                'stock' => 5,
                'description' => 'Panduan praktis membangun aplikasi web modern menggunakan Laravel 11.',
            ],
            [
                'book_code' => 'BK-0003',
                'title' => 'Struktur Data & Algoritma',
                'author' => 'Suarga',
                'publisher' => 'Andi Publisher',
                'publication_year' => 2019,
                'category' => 'Pemrograman',
                'stock' => 3,
                'description' => 'Mempelajari konsep struktur data dan implementasi algoritma dasar.',
            ],
            [
                'book_code' => 'BK-0004',
                'title' => 'Sejarah Dunia yang Disembunyikan',
                'author' => 'Jonathan Black',
                'publisher' => 'Alvabet',
                'publication_year' => 2015,
                'category' => 'Sejarah',
                'stock' => 4,
                'description' => 'Menelusuri sejarah alternatif dunia dari berbagai mitologi dan sekte rahasia.',
            ],
            [
                'book_code' => 'BK-0005',
                'title' => 'Fisika Dasar Edisi Ketiga',
                'author' => 'Halliday & Resnick',
                'publisher' => 'Erlangga',
                'publication_year' => 2018,
                'category' => 'Sains',
                'stock' => 8,
                'description' => 'Buku teks standar perkuliahan fisika dasar teknik dan sains.',
            ],
        ];

        foreach ($books as $book) {
            Book::updateOrCreate(
                ['book_code' => $book['book_code']],
                $book
            );
        }
    }
}
