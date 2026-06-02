<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Temukan user default test@example.com
        $user = User::where('email', 'prince@gmail.com')->first();

        if (!$user) {
            $user = User::create([
                'name' => 'Prince',
                'email' => 'prince@gmail.com',
                'password' => bcrypt('password12'),
            ]);
        }

        // Hapus tugas lama milik user ini agar bersih
        Task::where('user_id', $user->id)->delete();

        // Buat data tugas tiruan yang realistis
        $tasks = [
            [
                'user_id' => $user->id,
                'title' => 'Tugas Matematika Diskrit',
                'description' => 'Mengerjakan latihan soal bab 3 nomor 1-10 tentang graf dan pohon.',
                'category' => 'Kuliah',
                'status' => 'belum_dikerjakan',
                'priority' => 'tinggi',
                'deadline' => Carbon::now()->addDays(2)->toDateString(), // 2 hari lagi (Pengingat Notifikasi)
            ],
            [
                'user_id' => $user->id,
                'title' => 'Laporan Keuangan Bulanan',
                'description' => 'Menyusun laporan arus kas dan laba rugi untuk bulan Mei.',
                'category' => 'Kerja',
                'status' => 'sedang_dikerjakan',
                'priority' => 'tinggi',
                'deadline' => Carbon::now()->addDay()->toDateString(), // Besok (Pengingat Notifikasi)
            ],
            [
                'user_id' => $user->id,
                'title' => 'Belanja Kebutuhan Bulanan',
                'description' => 'Membeli kebutuhan dapur, sabun, dan kopi di supermarket terdekat.',
                'category' => 'Pribadi',
                'status' => 'selesai',
                'priority' => 'rendah',
                'deadline' => Carbon::now()->subDay()->toDateString(), // Kemarin (Selesai, tidak masuk pengingat)
            ],
            [
                'user_id' => $user->id,
                'title' => 'Rapat Koordinasi Organisasi',
                'description' => 'Menghadiri rapat koordinasi persiapan event seminar teknologi melalui Zoom.',
                'category' => 'Organisasi',
                'status' => 'belum_dikerjakan',
                'priority' => 'sedang',
                'deadline' => Carbon::now()->toDateString(), // Hari Ini (Pengingat Notifikasi)
            ],
            [
                'user_id' => $user->id,
                'title' => 'Belajar Framework Laravel',
                'description' => 'Mempelajari konsep middleware, routing, blade template, dan Eloquent ORM.',
                'category' => 'Kuliah',
                'status' => 'sedang_dikerjakan',
                'priority' => 'sedang',
                'deadline' => Carbon::now()->addDays(3)->toDateString(), // 3 hari lagi (Pengingat Notifikasi)
            ],
            [
                'user_id' => $user->id,
                'title' => 'Olahraga Sore (Jogging)',
                'description' => 'Lari santai 5 km di taman kota untuk menjaga kesehatan kardiovaskular.',
                'category' => 'Pribadi',
                'status' => 'selesai',
                'priority' => 'rendah',
                'deadline' => Carbon::now()->toDateString(), // Hari Ini (Selesai, tidak masuk pengingat)
            ],
            [
                'user_id' => $user->id,
                'title' => 'Review Desain UI TaskMate',
                'description' => 'Memeriksa kerapian layout form, keselarasan ikon kustom, dan responsivitas mobile.',
                'category' => 'Kerja',
                'status' => 'belum_dikerjakan',
                'priority' => 'tinggi',
                'deadline' => Carbon::now()->addDays(5)->toDateString(), // 5 hari lagi
            ]
        ];

        foreach ($tasks as $taskData) {
            Task::create($taskData);
        }
    }
}
