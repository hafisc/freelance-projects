<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->string('nim')->primary(); 
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('agama');
            $table->text('alamat');
            $table->string('no_telepon');
            $table->string('email')->unique();
            $table->string('asal_sekolah');
            $table->string('prodi');
            $table->string('fakultas');
            $table->year('tahun_masuk');
            $table->string('nama_wali');
            $table->enum('status_mahasiswa', ['Aktif', 'Cuti', 'Lulus']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};