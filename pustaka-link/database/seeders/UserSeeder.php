<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Menambahkan akun default Admin/Petugas tunggal untuk PustakaLink.
     */
    public function run(): void
    {
        // Akun Utama Admin/Petugas
        User::updateOrCreate(
            ['email' => 'admin@pustakalink.com'],
            [
                'name' => 'Admin/Petugas',
                'password' => Hash::make('password'),
                'role' => 'admin', // Menggunakan role admin sebagai role dasar sistem
            ]
        );
    }
}
