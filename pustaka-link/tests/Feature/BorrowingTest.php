<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Member;
use App\Models\Book;
use App\Models\Borrowing;
use Carbon\Carbon;

class BorrowingTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $member;
    protected $book;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Buat user petugas
        $this->user = User::create([
            'name' => 'Petugas Sirkulasi',
            'email' => 'sirkulasi@pustakalink.com',
            'password' => bcrypt('password'),
            'role' => 'petugas',
        ]);

        // 2. Buat anggota contoh
        $this->member = Member::create([
            'member_code' => 'AGT-8888',
            'name' => 'Anggota Sirkulasi',
            'gender' => 'Laki-laki',
        ]);

        // 3. Buat buku contoh dengan stok awal = 5
        $this->book = Book::create([
            'book_code' => 'BK-8888',
            'title' => 'Buku Sirkulasi PHPUnit',
            'stock' => 5,
        ]);
    }

    /**
     * Uji apakah petugas dapat membuat transaksi peminjaman buku,
     * serta memverifikasi bahwa:
     * 1. Status awal adalah 'borrowed'.
     * 2. Jatuh tempo otomatis 7 hari dari tanggal pinjam.
     * 3. Stok buku berkurang 1.
     */
    public function test_petugas_can_create_borrowing_transaction(): void
    {
        $borrowDate = '2026-06-02';
        $expectedDueDate = '2026-06-09'; // +7 hari otomatis

        $borrowingData = [
            'member_id' => $this->member->id,
            'book_id' => $this->book->id,
            'borrow_date' => $borrowDate,
            'notes' => 'Catatan pinjam testing',
        ];

        // Jalankan POST request simpan peminjaman
        $response = $this->actingAs($this->user)
            ->post(route('borrowings.store'), $borrowingData);

        $response->assertRedirect(route('borrowings.index'));

        // Cek data peminjaman tersimpan di database menggunakan asersi objek Eloquent
        $borrowing = Borrowing::first();
        $this->assertNotNull($borrowing);
        $this->assertEquals($this->member->id, $borrowing->member_id);
        $this->assertEquals($borrowDate, $borrowing->borrow_date->toDateString());
        $this->assertEquals($expectedDueDate, $borrowing->due_date->toDateString());
        $this->assertEquals('borrowed', $borrowing->status);

        // Cek stok buku berkurang menjadi 4
        $this->book->refresh();
        $this->assertEquals(4, $this->book->stock);
    }

    /**
     * Uji apakah proses pengembalian buku berfungsi dengan baik,
     * serta memverifikasi bahwa:
     * 1. Status berubah menjadi 'returned'.
     * 2. Tanggal kembali tercatat hari ini.
     * 3. Stok buku bertambah kembali utuh.
     */
    public function test_petugas_can_process_book_return(): void
    {
        // 1. Catat peminjaman awal terlebih dahulu
        $borrowDate = '2026-06-02';
        $dueDate = '2026-06-09';
        
        $borrowing = Borrowing::create([
            'member_id' => $this->member->id,
            'borrow_date' => $borrowDate,
            'due_date' => $dueDate,
            'status' => 'borrowed',
        ]);

        // Detail peminjaman
        $borrowing->borrowingDetails()->create([
            'book_id' => $this->book->id,
            'quantity' => 1,
        ]);

        // Kurangi stok manual agar seimbang dengan peminjaman
        $this->book->decrement('stock', 1);
        $this->assertEquals(4, $this->book->stock);

        // 2. Jalankan PATCH request untuk mengembalikan buku
        $response = $this->actingAs($this->user)
            ->patch(route('borrowings.return', $borrowing->id));

        $response->assertRedirect(route('borrowings.index'));

        // Cek status berubah menjadi returned dan return_date hari ini
        $borrowing->refresh();
        $this->assertEquals('returned', $borrowing->status);
        $this->assertEquals(Carbon::now()->toDateString(), $borrowing->return_date->toDateString());

        // Cek stok buku bertambah kembali menjadi 5
        $this->book->refresh();
        $this->assertEquals(5, $this->book->stock);
    }
}
