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
        Schema::create('kegiatan_belajar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_pembelajaran_id')->constrained('jadwal_pembelajaran')->onDelete('cascade');
            $table->integer('pertemuan_ke');
            $table->date('tanggal');
            $table->string('materi');
            $table->string('metode_pembelajaran');
            $table->text('tugas')->nullable();
            $table->string('status')->default('terjadwal'); // terjadwal, berlangsung, selesai
            $table->text('catatan')->nullable();
            $table->integer('kehadiran_hadir')->default(0);
            $table->integer('kehadiran_sakit')->default(0);
            $table->integer('kehadiran_izin')->default(0);
            $table->integer('kehadiran_alfa')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatan_belajar');
    }
};
