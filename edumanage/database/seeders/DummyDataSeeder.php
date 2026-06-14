<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Mata Kuliah
        $mk1 = \App\Models\MataKuliah::create([
            'kode_mk' => 'IF-301',
            'nama_mk' => 'Pemrograman Web',
            'sks' => 3,
            'semester' => 4,
        ]);
        $mk2 = \App\Models\MataKuliah::create([
            'kode_mk' => 'IF-302',
            'nama_mk' => 'Basis Data',
            'sks' => 3,
            'semester' => 3,
        ]);
        \App\Models\MataKuliah::create([
            'kode_mk' => 'IF-303',
            'nama_mk' => 'Struktur Data',
            'sks' => 4,
            'semester' => 2,
        ]);
        \App\Models\MataKuliah::create([
            'kode_mk' => 'IF-304',
            'nama_mk' => 'Kecerdasan Buatan',
            'sks' => 3,
            'semester' => 6,
        ]);

        // 2. Buat Kelas
        $kelasA = \App\Models\Kelas::create([
            'nama_kelas' => 'IF-4A',
            'prodi' => 'Teknik Informatika',
            'angkatan' => 2022,
        ]);
        $kelasB = \App\Models\Kelas::create([
            'nama_kelas' => 'IF-4B',
            'prodi' => 'Teknik Informatika',
            'angkatan' => 2022,
        ]);

        // 3. Ambil Dosen yang sudah di-seed
        $dosen1 = \App\Models\Dosen::where('nidn', '0412345678')->first();
        $dosen2 = \App\Models\Dosen::where('nidn', '0498765432')->first();

        if ($dosen1 && $dosen2) {
            // 4. Buat Jadwal Pembelajaran
            $jadwal1 = \App\Models\JadwalPembelajaran::create([
                'kelas_id' => $kelasA->id,
                'dosen_id' => $dosen1->id,
                'mata_kuliah_id' => $mk1->id,
                'hari' => 'Senin',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '10:30:00',
                'ruangan' => 'Lab Komputer 1',
            ]);

            $jadwal2 = \App\Models\JadwalPembelajaran::create([
                'kelas_id' => $kelasA->id,
                'dosen_id' => $dosen2->id,
                'mata_kuliah_id' => $mk2->id,
                'hari' => 'Rabu',
                'jam_mulai' => '10:00:00',
                'jam_selesai' => '12:30:00',
                'ruangan' => 'Ruang Teori 3',
            ]);

            \App\Models\JadwalPembelajaran::create([
                'kelas_id' => $kelasB->id,
                'dosen_id' => $dosen1->id,
                'mata_kuliah_id' => $mk1->id,
                'hari' => 'Selasa',
                'jam_mulai' => '13:00:00',
                'jam_selesai' => '15:30:00',
                'ruangan' => 'Lab Komputer 1',
            ]);

            // 5. Buat Kegiatan Belajar (Transaksi)
            \App\Models\KegiatanBelajar::create([
                'jadwal_pembelajaran_id' => $jadwal1->id,
                'pertemuan_ke' => 1,
                'tanggal' => '2026-06-08',
                'materi' => 'Pengenalan HTML dan CSS Modern',
                'metode_pembelajaran' => 'Ceramah dan Praktik',
                'tugas' => null,
                'status' => 'selesai',
                'catatan' => 'Semua mahasiswa hadir dan mencoba setup environment.',
                'kehadiran_hadir' => 28,
                'kehadiran_sakit' => 1,
                'kehadiran_izin' => 1,
                'kehadiran_alfa' => 0,
            ]);

            \App\Models\KegiatanBelajar::create([
                'jadwal_pembelajaran_id' => $jadwal1->id,
                'pertemuan_ke' => 2,
                'tanggal' => '2026-06-15',
                'materi' => 'Dasar Javascript dan DOM Manipulation',
                'metode_pembelajaran' => 'Praktik Langsung',
                'tugas' => 'Buat kalkulator interaktif sederhana dengan Javascript',
                'status' => 'terjadwal',
                'catatan' => null,
                'kehadiran_hadir' => 0,
                'kehadiran_sakit' => 0,
                'kehadiran_izin' => 0,
                'kehadiran_alfa' => 0,
            ]);

            \App\Models\KegiatanBelajar::create([
                'jadwal_pembelajaran_id' => $jadwal2->id,
                'pertemuan_ke' => 1,
                'tanggal' => '2026-06-10',
                'materi' => 'ERD dan Relasi Tabel',
                'metode_pembelajaran' => 'Ceramah dan Diskusi',
                'tugas' => null,
                'status' => 'selesai',
                'catatan' => 'Diskusi kelompok berjalan aktif.',
                'kehadiran_hadir' => 25,
                'kehadiran_sakit' => 2,
                'kehadiran_izin' => 3,
                'kehadiran_alfa' => 0,
            ]);
        }
    }
}
