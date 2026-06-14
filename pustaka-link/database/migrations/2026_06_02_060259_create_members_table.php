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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('member_code')->unique(); // Kode anggota unik (misal: AGT001)
            $table->string('name'); // Nama anggota
            $table->string('gender')->nullable(); // Jenis kelamin (Laki-laki / Perempuan)
            $table->string('phone')->nullable(); // Nomor telepon
            $table->text('address')->nullable(); // Alamat tinggal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
