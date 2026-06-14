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
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->onDelete('restrict'); // Terhubung ke anggota
            $table->date('borrow_date'); // Tanggal pinjam
            $table->date('due_date'); // Tanggal jatuh tempo
            $table->date('return_date')->nullable(); // Tanggal pengembalian (null jika belum dikembalikan)
            $table->string('status')->default('borrowed'); // Status: borrowed / returned
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};
