<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use Illuminate\Database\Seeder;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat data jurusan contoh untuk sistem
        $jurusans = [
            [
                'nama_jurusan' => 'Teknik Informatika',
                'keterangan' => 'Fokus pada pengembangan perangkat lunak, jaringan, komputasi, dan kecerdasan buatan.',
            ],
            [
                'nama_jurusan' => 'Sistem Informasi',
                'keterangan' => 'Menggabungkan ilmu komputer dengan bisnis dan manajemen untuk merancang sistem yang efisien.',
            ],
            [
                'nama_jurusan' => 'Desain Komunikasi Visual',
                'keterangan' => 'Mempelajari konsep desain grafis, ilustrasi, media digital, dan komunikasi kreatif.',
            ],
            [
                'nama_jurusan' => 'Manajemen Informatika',
                'keterangan' => 'Program diploma yang berfokus pada manajemen data, administrasi sistem, dan dukungan IT.',
            ],
        ];

        foreach ($jurusans as $jurusan) {
            Jurusan::updateOrCreate(
                ['nama_jurusan' => $jurusan['nama_jurusan']],
                $jurusan
            );
        }
    }
}
