<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Book;

class BookTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat user petugas tiruan untuk autentikasi testing
        $this->user = User::create([
            'name' => 'Petugas Test',
            'email' => 'petugastest@pustakalink.com',
            'password' => bcrypt('password'),
            'role' => 'petugas',
        ]);
    }

    /**
     * Uji apakah petugas dapat melihat daftar buku.
     */
    public function test_petugas_can_view_book_index(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('books.index'));

        $response->assertStatus(200);
        $response->assertViewHas('books');
    }

    /**
     * Uji apakah petugas dapat menambah buku baru dengan data valid.
     */
    public function test_petugas_can_create_book(): void
    {
        $bookData = [
            'book_code' => 'BK-9999',
            'title' => 'Buku Test PHPUnit',
            'author' => 'Author Test',
            'publisher' => 'Publisher Test',
            'publication_year' => 2024,
            'category' => 'Pemrograman',
            'stock' => 10,
            'description' => 'Buku deskripsi test',
        ];

        $response = $this->actingAs($this->user)
            ->post(route('books.store'), $bookData);

        $response->assertRedirect(route('books.index'));
        $this->assertDatabaseHas('books', [
            'book_code' => 'BK-9999',
            'title' => 'Buku Test PHPUnit',
        ]);
    }

    /**
     * Uji apakah petugas dapat mengubah informasi buku.
     */
    public function test_petugas_can_update_book(): void
    {
        $book = Book::create([
            'book_code' => 'BK-0101',
            'title' => 'Buku Sebelum Diubah',
            'author' => 'Penulis',
            'publisher' => 'Penerbit',
            'publication_year' => 2020,
            'category' => 'Sains',
            'stock' => 5,
        ]);

        $updatedData = [
            'book_code' => 'BK-0101',
            'title' => 'Buku Sesudah Diubah',
            'author' => 'Penulis Baru',
            'publisher' => 'Penerbit Baru',
            'publication_year' => 2022,
            'category' => 'Sains',
            'stock' => 8,
        ];

        $response = $this->actingAs($this->user)
            ->put(route('books.update', $book->id), $updatedData);

        $response->assertRedirect(route('books.index'));
        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => 'Buku Sesudah Diubah',
            'stock' => 8,
        ]);
    }

    /**
     * Uji apakah petugas dapat menghapus buku.
     */
    public function test_petugas_can_delete_book(): void
    {
        $book = Book::create([
            'book_code' => 'BK-0202',
            'title' => 'Buku Untuk Dihapus',
            'author' => 'Penulis',
            'stock' => 2,
        ]);

        $response = $this->actingAs($this->user)
            ->delete(route('books.destroy', $book->id));

        $response->assertRedirect(route('books.index'));
        $this->assertDatabaseMissing('books', [
            'id' => $book->id,
        ]);
    }
}
