<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mengambil semua jurusan yang tersedia
        $ti = Jurusan::where('nama_jurusan', 'Teknik Informatika')->first();
        $si = Jurusan::where('nama_jurusan', 'Sistem Informasi')->first();
        $dkv = Jurusan::where('nama_jurusan', 'Desain Komunikasi Visual')->first();

        // Membuat data mahasiswa contoh
        $mahasiswas = [
            [
                'nim' => '2301010001',
                'nama' => 'Ahmad Fauzi',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2004-03-12',
                'alamat' => 'Jl. Merdeka No. 12, Jakarta',
                'no_hp' => '081234567890',
                'jurusan_id' => $ti->id,
            ],
            [
                'nim' => '2301010002',
                'nama' => 'Budi Santoso',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2003-08-25',
                'alamat' => 'Jl. Mawar Indah No. 45, Bandung',
                'no_hp' => '082345678901',
                'jurusan_id' => $ti->id,
            ],
            [
                'nim' => '2302010001',
                'nama' => 'Citra Lestari',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2004-11-05',
                'alamat' => 'Jl. Sudirman No. 88, Surabaya',
                'no_hp' => '083456789012',
                'jurusan_id' => $si->id,
            ],
            [
                'nim' => '2302010002',
                'nama' => 'Dewi Sartika',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2004-05-18',
                'alamat' => 'Jl. Melati Raya No. 7, Yogyakarta',
                'no_hp' => '084567890123',
                'jurusan_id' => $si->id,
            ],
            [
                'nim' => '2303010001',
                'nama' => 'Eko Prasetyo',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2003-01-30',
                'alamat' => 'Jl. Diponegoro No. 15, Semarang',
                'no_hp' => '085678901234',
                'jurusan_id' => $dkv->id,
            ],
        ];

        foreach ($mahasiswas as $mahasiswa) {
            Mahasiswa::updateOrCreate(
                ['nim' => $mahasiswa['nim']],
                $mahasiswa
            );
        }
    }
}
