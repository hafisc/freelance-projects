<?php
 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kegiatan_belajar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_id')->constrained('jadwal_pembelajaran')->onDelete('cascade');
            $table->enum('jenis', ['Pertemuan', 'Materi', 'Tugas', 'Absensi'])->default('Pertemuan');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('file_materi')->nullable();
            $table->dateTime('deadline')->nullable();
            $table->timestamps();
        });
    }
 
    public function down(): void
    {
        Schema::dropIfExists('kegiatan_belajar');
    }
};
