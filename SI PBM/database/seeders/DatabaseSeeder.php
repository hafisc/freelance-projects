<?php
 
namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
 
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Hak Akses
        DB::table('hak_akses')->insert([
            [
                'nama_role' => 'Admin',
                'level_akses' => '1',
                'deskripsi' => 'Super Administrator dengan hak akses penuh ke seluruh sistem.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_role' => 'Operator',
                'level_akses' => '2',
                'deskripsi' => 'Staf Akademik dengan hak akses pengelolaan data master.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_role' => 'Dosen',
                'level_akses' => '3',
                'deskripsi' => 'Tenaga Pendidik dengan hak akses mengajar dan menilai.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_role' => 'Mahasiswa',
                'level_akses' => '4',
                'deskripsi' => 'Peserta Didik dengan hak akses melihat jadwal dan materi.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
 
        // 2. Seed Dosen
        $dosenId = DB::table('dosen')->insertGetId([
            'nidn' => '111111',
            'nama_dosen' => 'Dr. Budi Santoso',
            'keahlian' => 'Rekayasa Perangkat Lunak',
            'email' => 'dosen@sipbm.ac.id',
            'no_hp' => '081234567890',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
 
        // 3. Seed Mahasiswa
        DB::table('mahasiswa')->insert([
            [
                'nim' => '2024002',
                'nama' => 'Ahmad Hidayat',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2002-05-12',
                'jenis_kelamin' => 'Laki-laki',
                'agama' => 'Islam',
                'alamat' => 'Jl. Merdeka No. 10',
                'no_telepon' => '08987654321',
                'email' => 'ahmad@sipbm.ac.id',
                'asal_sekolah' => 'SMA 1 Jakarta',
                'prodi' => 'Teknik Informatika',
                'fakultas' => 'Ilmu Komputer',
                'tahun_masuk' => 2024,
                'nama_wali' => 'Budi',
                'status_mahasiswa' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nim' => '2024004',
                'nama' => 'Siti Aminah',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2003-08-20',
                'jenis_kelamin' => 'Perempuan',
                'agama' => 'Islam',
                'alamat' => 'Jl. Dago No. 45',
                'no_telepon' => '08123456788',
                'email' => 'siti@sipbm.ac.id',
                'asal_sekolah' => 'SMA 3 Bandung',
                'prodi' => 'Teknik Informatika',
                'fakultas' => 'Ilmu Komputer',
                'tahun_masuk' => 2024,
                'nama_wali' => 'Hasan',
                'status_mahasiswa' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
 
        // 4. Seed Users
        DB::table('users')->insert([
            // Admin
            [
                'name' => 'Admin SI-PBM',
                'email' => 'admin@sipbm.ac.id',
                'password' => Hash::make('admin123'),
                'role' => 'Admin',
                'nim' => null,
                'dosen_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Operator
            [
                'name' => 'Operator SI-PBM',
                'email' => 'operator@sipbm.ac.id',
                'password' => Hash::make('operator123'),
                'role' => 'Operator',
                'nim' => null,
                'dosen_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Dosen
            [
                'name' => 'Dr. Budi Santoso',
                'email' => 'dosen@sipbm.ac.id',
                'password' => Hash::make('dosen123'),
                'role' => 'Dosen',
                'nim' => null,
                'dosen_id' => $dosenId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Mahasiswa 1
            [
                'name' => 'Ahmad Hidayat',
                'email' => '2024002@sipbm.ac.id',
                'password' => Hash::make('2024002'),
                'role' => 'Mahasiswa',
                'nim' => '2024002',
                'dosen_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Mahasiswa 2
            [
                'name' => 'Siti Aminah',
                'email' => '2024004@sipbm.ac.id',
                'password' => Hash::make('2024004'),
                'role' => 'Mahasiswa',
                'nim' => '2024004',
                'dosen_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
 
        // 5. Seed Mata Kuliah
        $mkId1 = DB::table('matakuliah')->insertGetId([
            'kode_mk' => 'IF101',
            'nama_mk' => 'Dasar Pemrograman',
            'sks' => 3,
            'semester' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $mkId2 = DB::table('matakuliah')->insertGetId([
            'kode_mk' => 'IF202',
            'nama_mk' => 'Basis Data',
            'sks' => 4,
            'semester' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
 
        // 6. Seed Kelas
        $kelasId1 = DB::table('kelas')->insertGetId([
            'kode_kelas' => 'K-IF101-A',
            'nama_kelas' => 'Dasar Pemrograman - Kelas A',
            'matakuliah_id' => $mkId1,
            'dosen_id' => $dosenId,
            'semester' => 1,
            'tahun_ajaran' => '2025/2026',
            'hari' => 'Senin',
            'jam_mulai' => '08:00:00',
            'jam_selesai' => '10:30:00',
            'ruangan' => 'Lab Komputer 1',
            'kapasitas' => 30,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
 
        $kelasId2 = DB::table('kelas')->insertGetId([
            'kode_kelas' => 'K-IF202-B',
            'nama_kelas' => 'Basis Data - Kelas B',
            'matakuliah_id' => $mkId2,
            'dosen_id' => $dosenId,
            'semester' => 3,
            'tahun_ajaran' => '2025/2026',
            'hari' => 'Rabu',
            'jam_mulai' => '13:00:00',
            'jam_selesai' => '16:20:00',
            'ruangan' => 'Lab Komputer 2',
            'kapasitas' => 40,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
 
        // 7. Seed KRS
        DB::table('krs')->insert([
            [
                'mahasiswa_id' => '2024002',
                'matakuliah_id' => $mkId1,
                'dosen_id' => $dosenId,
                'semester' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mahasiswa_id' => '2024002',
                'matakuliah_id' => $mkId2,
                'dosen_id' => $dosenId,
                'semester' => '3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mahasiswa_id' => '2024004',
                'matakuliah_id' => $mkId1,
                'dosen_id' => $dosenId,
                'semester' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
 
        // 8. Seed Jadwal Pembelajaran
        $jadwalId1 = DB::table('jadwal_pembelajaran')->insertGetId([
            'kelas_id' => $kelasId1,
            'pertemuan_ke' => 1,
            'tanggal' => '2026-06-22',
            'jam_mulai' => '08:00:00',
            'jam_selesai' => '10:30:00',
            'ruangan' => 'Lab Komputer 1',
            'topik_materi' => 'Pengenalan PHP & Web Server',
            'status' => 'Selesai',
            'catatan' => 'Siswa sangat antusias.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
 
        $jadwalId2 = DB::table('jadwal_pembelajaran')->insertGetId([
            'kelas_id' => $kelasId1,
            'pertemuan_ke' => 2,
            'tanggal' => '2026-06-29',
            'jam_mulai' => '08:00:00',
            'jam_selesai' => '10:30:00',
            'ruangan' => 'Lab Komputer 1',
            'topik_materi' => 'Variabel, Operator dan Struktur Kontrol',
            'status' => 'Terjadwal',
            'catatan' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
 
        // 9. Seed Kegiatan Belajar
        DB::table('kegiatan_belajar')->insert([
            [
                'jadwal_id' => $jadwalId1,
                'jenis' => 'Materi',
                'judul' => 'Materi 1: Pengenalan PHP',
                'deskripsi' => 'Pengenalan syntax dasar PHP, instalasi XAMPP, dan running script pertama.',
                'file_materi' => 'slide_pengenalan_php.pdf',
                'deadline' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jadwal_id' => $jadwalId1,
                'jenis' => 'Tugas',
                'judul' => 'Tugas 1: Hello World & Kalkulator Sederhana',
                'deskripsi' => 'Buat script PHP kalkulator sederhana yang menerima input dua angka.',
                'file_materi' => null,
                'deadline' => '2026-06-26 23:59:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
 
        // 10. Seed Absensi
        DB::table('absensi')->insert([
            [
                'jadwal_id' => $jadwalId1,
                'mahasiswa_nim' => '2024002',
                'status' => 'Hadir',
                'keterangan' => 'Hadir tepat waktu',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jadwal_id' => $jadwalId1,
                'mahasiswa_nim' => '2024004',
                'status' => 'Izin',
                'keterangan' => 'Sakit demam',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
