<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    // Fungsi ini digunakan untuk menjalankan database seeding untuk data user
    public function run(): void
    {
        // Buat User / Pencari Kerja Default dengan profil lengkap
        User::updateOrCreate(
            ['email' => 'user@gloria.com'],
            [
                'name' => 'Fulan',
                'phone' => '081234567890',
                'password' => Hash::make('password'),
                'address' => 'Jl. Raya Darmo No. 45, Surabaya, Jawa Timur 60256',
                'cv' => 'cv/dummy_cv.pdf',
                'summary' => 'Fresh graduate Teknik Informatika dengan keahlian khusus di bidang pengembangan aplikasi mobile menggunakan Flutter dan integrasi RESTful API dengan backend Laravel. Memiliki semangat belajar yang tinggi dan siap bekerja dalam tim.',
                'skills' => ['Flutter', 'Dart', 'Laravel', 'PHP', 'MySQL', 'RESTful API', 'Git', 'UI/UX Design'],
                'education' => [
                    [
                        'school' => 'Universitas Airlangga',
                        'degree' => 'S1',
                        'period' => '2020 - 2024',
                        'major' => 'Teknik Informatika',
                    ],
                    [
                        'school' => 'SMAN 1 Surabaya',
                        'degree' => 'SMA',
                        'period' => '2017 - 2020',
                        'major' => 'MIPA',
                    ]
                ],
                'experience' => [
                    [
                        'company' => 'PT. Gloria Jasa Mandiri',
                        'role' => 'Flutter Developer Intern',
                        'period' => '2023 - 2024',
                        'description' => 'Mengembangkan antarmuka aplikasi mobile Gloria Job menggunakan Flutter dan mengintegrasikannya dengan RESTful API Laravel.',
                    ],
                    [
                        'company' => 'Freelance',
                        'role' => 'UI/UX Designer',
                        'period' => '2021 - 2023',
                        'description' => 'Mendesain mockup antarmuka pengguna untuk berbagai aplikasi web dan mobile menggunakan Figma sesuai kebutuhan klien.',
                    ]
                ],
            ]
        );
    }
}
