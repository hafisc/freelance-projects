<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Role;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\MataKuliah;
use App\Models\Kelas;
use App\Models\JadwalPembelajaran;
use App\Models\KegiatanBelajar;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard sesuai dengan role user yang sedang login.
     */
    public function index()
    {
        $user = auth()->user();
        $roleName = $user->role->name;

        // Logika render berdasarkan Role
        if ($roleName === 'Admin') {
            // Mengambil statistik global untuk Admin
            $stats = [
                'total_users' => User::count(),
                'total_mahasiswa' => Mahasiswa::count(),
                'total_dosen' => Dosen::count(),
                'total_mata_kuliah' => MataKuliah::count(),
                'total_kelas' => Kelas::count(),
                'total_jadwal' => JadwalPembelajaran::count(),
                'total_kegiatan' => KegiatanBelajar::count(),
            ];

            // Mengambil kegiatan belajar terbaru beserta jadwalnya
            $latestKegiatan = KegiatanBelajar::with('jadwalPembelajaran.mataKuliah', 'jadwalPembelajaran.kelas')
                ->latest()
                ->take(5)
                ->get();

            return view('admin.dashboard.index', compact('stats', 'latestKegiatan'));
            
        } elseif ($roleName === 'Dosen') {
            // Cari data dosen terkait user yang login
            $dosen = $user->dosen;
            
            if (!$dosen) {
                return view('dosen.dashboard.index')->with('error', 'Profil dosen Anda belum diset oleh admin.');
            }

            // Ambil jadwal mengajar dosen
            $jadwals = JadwalPembelajaran::with('kelas', 'mataKuliah')
                ->where('dosen_id', $dosen->id)
                ->get();

            $jadwalIds = $jadwals->pluck('id');

            // Hitung total jam mengajar / SKS, total kegiatan belajar, dsb
            $stats = [
                'total_jadwal' => $jadwals->count(),
                'total_kegiatan' => KegiatanBelajar::whereIn('jadwal_pembelajaran_id', $jadwalIds)->count(),
                'total_kegiatan_selesai' => KegiatanBelajar::whereIn('jadwal_pembelajaran_id', $jadwalIds)
                    ->where('status', 'selesai')
                    ->count(),
            ];

            $latestKegiatan = KegiatanBelajar::with('jadwalPembelajaran.mataKuliah', 'jadwalPembelajaran.kelas')
                ->whereIn('jadwal_pembelajaran_id', $jadwalIds)
                ->latest()
                ->take(5)
                ->get();

            return view('dosen.dashboard.index', compact('dosen', 'stats', 'jadwals', 'latestKegiatan'));
            
        } elseif ($roleName === 'Mahasiswa') {
            // Cari data mahasiswa terkait user yang login
            $mahasiswa = $user->mahasiswa;

            if (!$mahasiswa) {
                return view('mahasiswa.dashboard.index')->with('error', 'Profil mahasiswa Anda belum diset oleh admin.');
            }

            // Temukan kelas mahasiswa berdasarkan prodi dan angkatan yang sama
            $kelas = Kelas::where('prodi', $mahasiswa->prodi)
                ->where('angkatan', $mahasiswa->angkatan)
                ->first();

            $jadwals = collect();
            $stats = [
                'total_jadwal' => 0,
                'total_kegiatan' => 0,
                'total_kegiatan_selesai' => 0,
            ];
            $latestKegiatan = collect();

            if ($kelas) {
                // Ambil jadwal kelas mahasiswa
                $jadwals = JadwalPembelajaran::with('dosen', 'mataKuliah')
                    ->where('kelas_id', $kelas->id)
                    ->get();

                $jadwalIds = $jadwals->pluck('id');

                $stats = [
                    'total_jadwal' => $jadwals->count(),
                    'total_kegiatan' => KegiatanBelajar::whereIn('jadwal_pembelajaran_id', $jadwalIds)->count(),
                    'total_kegiatan_selesai' => KegiatanBelajar::whereIn('jadwal_pembelajaran_id', $jadwalIds)
                        ->where('status', 'selesai')
                        ->count(),
                ];

                $latestKegiatan = KegiatanBelajar::with('jadwalPembelajaran.mataKuliah', 'jadwalPembelajaran.dosen')
                    ->whereIn('jadwal_pembelajaran_id', $jadwalIds)
                    ->latest()
                    ->take(5)
                    ->get();
            }

            return view('mahasiswa.dashboard.index', compact('mahasiswa', 'kelas', 'stats', 'jadwals', 'latestKegiatan'));
            
        } elseif ($roleName === 'Kaprodi') {
            // Kaprodi melihat monitoring global program studi
            $stats = [
                'total_dosen' => Dosen::count(),
                'total_mahasiswa' => Mahasiswa::count(),
                'total_kelas' => Kelas::count(),
                'total_jadwal' => JadwalPembelajaran::count(),
                'total_kegiatan' => KegiatanBelajar::count(),
                'total_kegiatan_selesai' => KegiatanBelajar::where('status', 'selesai')->count(),
            ];

            // Tampilkan kegiatan belajar yang berlangsung/belum selesai untuk monitoring
            $kegiatanMonitoring = KegiatanBelajar::with('jadwalPembelajaran.kelas', 'jadwalPembelajaran.mataKuliah', 'jadwalPembelajaran.dosen')
                ->latest()
                ->take(10)
                ->get();

            return view('kaprodi.dashboard.index', compact('stats', 'kegiatanMonitoring'));
        }

        // Default redirect login jika role tidak dikenali
        auth()->logout();
        return redirect()->route('login')->with('error', 'Role Anda tidak valid.');
    }
}
