<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Admin
        $admin = \App\Models\User::create([
            'role_id' => 1, // Admin
            'name' => 'Admin Sistem',
            'email' => 'admin@edumanage.test',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'status' => 'aktif',
        ]);

        // 2. Dosen
        $dosenUser = \App\Models\User::create([
            'role_id' => 2, // Dosen
            'name' => 'Admin Dosen',
            'email' => 'dosen@edumanage.test',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'status' => 'aktif',
        ]);
        \App\Models\Dosen::create([
            'user_id' => $dosenUser->id,
            'nidn' => '0412345678',
            'nama' => 'Admin Dosen',
            'jenis_kelamin' => 'Laki-laki',
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Pendidikan No. 12',
        ]);

        // 3. Mahasiswa
        $mahasiswaUser = \App\Models\User::create([
            'role_id' => 3, // Mahasiswa
            'name' => 'Admin Mahasiswa',
            'email' => 'mahasiswa@edumanage.test',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'status' => 'aktif',
        ]);
        \App\Models\Mahasiswa::create([
            'user_id' => $mahasiswaUser->id,
            'nim' => '2201010001',
            'nama' => 'Admin Mahasiswa',
            'jenis_kelamin' => 'Laki-laki',
            'prodi' => 'Teknik Informatika',
            'angkatan' => 2022,
            'no_hp' => '089876543210',
            'alamat' => 'Jl. Mahasiswa No. 5',
        ]);

        // 4. Kaprodi
        $kaprodiUser = \App\Models\User::create([
            'role_id' => 4, // Kaprodi
            'name' => 'Admin Kaprodi',
            'email' => 'kaprodi@edumanage.test',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'status' => 'aktif',
        ]);
        \App\Models\Dosen::create([
            'user_id' => $kaprodiUser->id,
            'nidn' => '0498765432',
            'nama' => 'Admin Kaprodi',
            'jenis_kelamin' => 'Perempuan',
            'no_hp' => '081122334455',
            'alamat' => 'Jl. Dekan No. 2',
        ]);
    }
}
