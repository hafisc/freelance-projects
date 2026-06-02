<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('book_code')->unique(); // Kode buku unik (BK001)
            $table->string('title'); // Judul buku
            $table->string('author')->nullable(); // Penulis
            $table->string('publisher')->nullable(); // Penerbit
            $table->integer('publication_year')->nullable(); // Tahun Terbit
            $table->string('category')->nullable(); // Kategori buku
            $table->integer('stock')->default(0); // Stok buku (default 0)
            $table->text('description')->nullable(); // Deskripsi buku
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
