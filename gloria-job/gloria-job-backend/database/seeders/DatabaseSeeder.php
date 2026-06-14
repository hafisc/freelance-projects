<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Jalankan Seeder Akun (User & Admin) dan Lowongan Kerja
        $this->call([
            UserSeeder::class,
            AdminSeeder::class,
            JobSeeder::class,
        ]);

        // 4. Buat Notifikasi Dummy Awal untuk User Fulan (user@gloria.com)
        $userFulan = User::where('email', 'user@gloria.com')->first();
        if ($userFulan) {
            \App\Models\Notification::create([
                'user_id' => $userFulan->id,
                'title' => 'Selamat Datang di Gloria Job! 🎉',
                'message' => 'Terima kasih telah bergabung dengan Gloria Job. Silakan lengkapi profil dan unggah CV Anda untuk melamar pekerjaan impian Anda.',
                'is_read' => false,
            ]);

            \App\Models\Notification::create([
                'user_id' => $userFulan->id,
                'title' => 'Tips Sukses Melamar Kerja 💡',
                'message' => 'Pastikan CV yang Anda unggah sudah dalam format PDF terbaru dan isi data diri dengan lengkap untuk memikat hati admin.',
                'is_read' => true,
            ]);
        }
    }
}

