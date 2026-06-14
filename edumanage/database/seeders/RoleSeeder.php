<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'Admin', 'description' => 'Administrator dengan akses penuh'],
            ['name' => 'Dosen', 'description' => 'Dosen pengajar'],
            ['name' => 'Mahasiswa', 'description' => 'Mahasiswa aktif'],
            ['name' => 'Kaprodi', 'description' => 'Kepala Program Studi'],
        ];

        foreach ($roles as $role) {
            \App\Models\Role::create($role);
        }
    }
}
