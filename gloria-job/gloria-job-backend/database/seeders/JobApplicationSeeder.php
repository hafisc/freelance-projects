<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class JobApplicationSeeder extends Seeder
{
    // Fungsi ini digunakan untuk mengisi database dengan data dummy lamaran masuk dari pelamar
    public function run(): void
    {
        // Bersihkan data lamaran sebelumnya untuk menghindari duplikasi
        Schema::disableForeignKeyConstraints();
        JobApplication::truncate();
        Schema::enableForeignKeyConstraints();

        // Ambil semua data lowongan
        $jobs = Job::all();

        if ($jobs->isEmpty()) {
            $this->command->warn('Tidak ada data lowongan. Jalankan JobSeeder terlebih dahulu.');
            return;
        }

        // Data dummy pelamar — buat user terlebih dahulu agar user_id tidak null
        $applicantData = [
            [
                'name'    => 'Fulan',
                'email'   => 'user@gloria.com',
                'phone'   => '081234567890',
                'address' => 'Jl. Raya Darmo No. 45, Surabaya, Jawa Timur 60256',
                'note'    => 'Saya sangat tertarik dengan posisi ini dan yakin bisa berkontribusi dengan baik.',
            ],
            [
                'name'    => 'Siti Rahmawati',
                'email'   => 'siti.rahmawati@gmail.com',
                'phone'   => '082345678901',
                'address' => 'Jl. Kebon Jeruk No. 12, Jakarta Barat, DKI Jakarta 11530',
                'note'    => 'Saya memiliki pengalaman 2 tahun di bidang yang relevan.',
            ],
            [
                'name'    => 'Budi Santoso',
                'email'   => 'budi.santoso@yahoo.com',
                'phone'   => '083456789012',
                'address' => 'Jl. Merdeka No. 88, Bekasi Utara, Jawa Barat 17141',
                'note'    => null,
            ],
            [
                'name'    => 'Dewi Lestari',
                'email'   => 'dewi.lestari@outlook.com',
                'phone'   => '084567890123',
                'address' => 'Jl. Pahlawan No. 7, Tangerang Selatan, Banten 15310',
                'note'    => 'Fresh graduate berprestasi, IPK 3.78, siap berkembang.',
            ],
            [
                'name'    => 'Ahmad Fauzi',
                'email'   => 'ahmad.fauzi@gmail.com',
                'phone'   => '085678901234',
                'address' => 'Jl. Diponegoro No. 55, Malang, Jawa Timur 65111',
                'note'    => 'Berpengalaman 3 tahun dan siap bergabung dalam 2 minggu.',
            ],
            [
                'name'    => 'Rina Agustina',
                'email'   => 'rina.agustina@gmail.com',
                'phone'   => '086789012345',
                'address' => 'Jl. Sudirman Blok C No. 3, Surabaya, Jawa Timur 60271',
                'note'    => null,
            ],
            [
                'name'    => 'Hendra Wijaya',
                'email'   => 'hendra.wijaya@hotmail.com',
                'phone'   => '087890123456',
                'address' => 'Jl. Gatot Subroto No. 22, Jakarta Selatan, DKI Jakarta 12950',
                'note'    => 'Saya memiliki sertifikasi resmi yang relevan.',
            ],
            [
                'name'    => 'Nurul Hidayah',
                'email'   => 'nurul.hidayah@gmail.com',
                'phone'   => '088901234567',
                'address' => 'Jl. Kaliurang Km 10 No. 4, Yogyakarta 55581',
                'note'    => 'Sangat termotivasi dan mampu bekerja di bawah tekanan.',
            ],
            [
                'name'    => 'Rizky Pratama',
                'email'   => 'rizky.pratama@gmail.com',
                'phone'   => '089012345678',
                'address' => 'Jl. Ahmad Yani No. 99, Bandung, Jawa Barat 40282',
                'note'    => 'Pernah magang 6 bulan di perusahaan bidang sejenis.',
            ],
            [
                'name'    => 'Maya Indraswari',
                'email'   => 'maya.indraswari@gmail.com',
                'phone'   => '081123456780',
                'address' => 'Jl. Imam Bonjol No. 17, Semarang, Jawa Tengah 50131',
                'note'    => null,
            ],
        ];

        // Buat atau ambil user untuk setiap pelamar
        $applicants = [];
        foreach ($applicantData as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name'     => $data['name'],
                    'phone'    => $data['phone'],
                    'password' => Hash::make('password'),
                    'address'  => $data['address'],
                ]
            );

            $applicants[] = array_merge($data, ['user_id' => $user->id]);
        }

        // Status lamaran untuk variasi data
        $statuses = ['Menunggu', 'Menunggu', 'Diproses', 'Diterima', 'Ditolak'];

        // Catatan admin berdasarkan status
        $adminNotes = [
            'Diterima' => 'Selamat! Anda diterima. Mohon hadir ke kantor pada hari Senin pukul 08.00 WIB untuk onboarding.',
            'Ditolak'  => 'Mohon maaf, kualifikasi Anda belum sesuai dengan kebutuhan kami saat ini. Kami akan simpan data Anda untuk kesempatan berikutnya.',
            'Diproses' => 'Lamaran Anda sedang kami tinjau lebih lanjut. Kami akan menghubungi Anda dalam 3-5 hari kerja.',
        ];

        // Buat lamaran dummy — setiap pelamar mendaftar ke 1-3 lowongan berbeda secara acak
        $jobIds = $jobs->pluck('id')->toArray();
        $usedCombinations = [];

        foreach ($applicants as $applicant) {
            // Ambil 1 sampai 3 job secara acak (tanpa duplikasi kombinasi user+job)
            $numApplications = rand(1, 3);
            shuffle($jobIds);
            $selectedJobs = array_slice($jobIds, 0, $numApplications);

            foreach ($selectedJobs as $jobId) {
                $key = $applicant['email'] . '-' . $jobId;
                if (isset($usedCombinations[$key])) {
                    continue;
                }
                $usedCombinations[$key] = true;

                $status = $statuses[array_rand($statuses)];
                $adminNote = $adminNotes[$status] ?? null;

                // Buat tanggal melamar acak dalam 30 hari terakhir
                $timestamp = now()->subDays(rand(0, 30))->subHours(rand(0, 23));

                JobApplication::create([
                    'user_id'    => $applicant['user_id'],
                    'job_id'     => $jobId,
                    'full_name'  => $applicant['name'],
                    'email'      => $applicant['email'],
                    'phone'      => $applicant['phone'],
                    'address'    => $applicant['address'],
                    'note'       => $applicant['note'],
                    'status'     => $status,
                    'admin_note' => $adminNote,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ]);
            }
        }
    }
}
