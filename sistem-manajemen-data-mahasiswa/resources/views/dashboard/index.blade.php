@extends('layouts.app')

@yield('title', 'Dashboard')

@section('content')
<div class="row">
    <!-- Card Total Mahasiswa -->
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm custom-card h-100">
            <div class="card-body d-flex align-items-center justify-content-between p-4">
                <div>
                    <h6 class="text-muted text-uppercase mb-2" style="font-size: 0.85rem; letter-spacing: 1px;">Total Mahasiswa</h6>
                    <h2 class="display-5 font-weight-bold mb-0 text-navy">{{ $totalMahasiswa }}</h2>
                </div>
                <div class="bg-primary-subtle text-primary rounded p-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                        <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Total Jurusan -->
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm custom-card h-100">
            <div class="card-body d-flex align-items-center justify-content-between p-4">
                <div>
                    <h6 class="text-muted text-uppercase mb-2" style="font-size: 0.85rem; letter-spacing: 1px;">Total Jurusan</h6>
                    <h2 class="display-5 font-weight-bold mb-0 text-navy">{{ $totalJurusan }}</h2>
                </div>
                <div class="bg-info-subtle text-info rounded p-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-journal-bookmark-fill" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M6 1h6v7a.5.5 0 0 1-.757.429L9 7.083 6.757 8.43A.5.5 0 0 1 6 8z"/>
                        <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2"/>
                        <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Deskripsi Aplikasi -->
<div class="card border-0 shadow-sm custom-card mb-4">
    <div class="card-body p-4">
        <h5 class="text-navy font-weight-bold mb-3">Selamat Datang di Sistem Manajemen Data Mahasiswa</h5>
        <p class="mb-0 text-secondary" style="line-height: 1.6;">
            Aplikasi ini dirancang untuk memudahkan Admin dalam mengelola data akademik di lingkungan kampus. Anda dapat menggunakan menu di sebelah kiri untuk menambah, mengubah, melihat, atau menghapus data mahasiswa dan data jurusan secara mudah dan cepat. Sistem ini dibuat sebagai alat bantu operasional administrasi akademik yang sederhana dan andal.
        </p>
    </div>
</div>

<!-- Mahasiswa Terbaru -->
<div class="card border-0 shadow-sm custom-card">
    <div class="custom-card-header d-flex justify-content-between align-items-center">
        <span>5 Mahasiswa Terbaru yang Terdaftar</span>
        <a href="{{ route('mahasiswa.index') }}" class="btn btn-navy btn-sm">Lihat Semua Mahasiswa</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-custom mb-0">
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama Lengkap</th>
                    <th>Jenis Kelamin</th>
                    <th>Jurusan</th>
                    <th>Tanggal Terdaftar</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mahasiswaTerbaru as $mhs)
                    <tr>
                        <td><strong>{{ $mhs->nim }}</strong></td>
                        <td>{{ $mhs->nama }}</td>
                        <td>
                            @if($mhs->jenis_kelamin == 'L')
                                Laki-laki
                            @else
                                Perempuan
                            @endif
                        </td>
                        <td>{{ $mhs->jurusan->nama_jurusan }}</td>
                        <td>{{ $mhs->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                Belum ada data mahasiswa yang terdaftar di sistem.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
