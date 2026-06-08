<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'kelas' => null,
            'tahun' => null,
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Guru',
            'username' => 'guru',
            'kelas' => null,
            'tahun' => null,
            'email' => 'guru@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'guru'
        ]);

        User::create([
            'name' => 'Siswa Demo',
            'username' => 'siswa',
            'kelas' => 'XI IPA',
            'tahun' => '2026',
            'email' => 'siswa@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'murid'
        ]);
    }
}