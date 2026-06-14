<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Menambahkan beberapa data anggota perpustakaan contoh.
     */
    public function run(): void
    {
        $members = [
            [
                'member_code' => 'AGT-0001',
                'name' => 'Budi Santoso',
                'gender' => 'Laki-laki',
                'phone' => '081234567890',
                'address' => 'Jl. Merdeka No. 10, Jakarta Pusat',
            ],
            [
                'member_code' => 'AGT-0002',
                'name' => 'Siti Aminah',
                'gender' => 'Perempuan',
                'phone' => '082198765432',
                'address' => 'Jl. Mawar No. 5, Bandung',
            ],
            [
                'member_code' => 'AGT-0003',
                'name' => 'Ahmad Subarjo',
                'gender' => 'Laki-laki',
                'phone' => '085711223344',
                'address' => 'Jl. Pemuda No. 12, Surabaya',
            ],
            [
                'member_code' => 'AGT-0004',
                'name' => 'Dewi Lestari',
                'gender' => 'Perempuan',
                'phone' => '089988776655',
                'address' => 'Jl. Kenanga No. 8, Yogyakarta',
            ],
        ];

        foreach ($members as $member) {
            Member::updateOrCreate(
                ['member_code' => $member['member_code']],
                $member
            );
        }
    }
}
