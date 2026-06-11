<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Mahasiswa;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard admin.
     */
    public function index()
    {
        // Menghitung total mahasiswa terdaftar
        $totalMahasiswa = Mahasiswa::count();

        // Menghitung total jurusan terdaftar
        $totalJurusan = Jurusan::count();

        // Mengambil 5 mahasiswa terbaru beserta informasi jurusannya
        $mahasiswaTerbaru = Mahasiswa::with('jurusan')
            ->latest()
            ->limit(5)
            ->get();

        // Mengirimkan data statistik ke view dashboard
        return view('dashboard.index', compact('totalMahasiswa', 'totalJurusan', 'mahasiswaTerbaru'));
    }
}
