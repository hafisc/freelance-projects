@extends('layouts.kaprodi')

@section('title', 'Dashboard Monitoring Kaprodi')

@section('content')
<div class="content-header">
    <div class="content-title">Dashboard Kaprodi</div>
</div>

<!-- Statistik Grid -->
<div class="dashboard-grid">
    <div class="stat-card">
        <div class="stat-info">
            <h3>Dosen Prodi</h3>
            <p>{{ $stats['total_dosen'] }}</p>
        </div>
        <div class="stat-icon">
            <i class="fas fa-chalkboard-teacher"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <h3>Mahasiswa Aktif</h3>
            <p>{{ $stats['total_mahasiswa'] }}</p>
        </div>
        <div class="stat-icon">
            <i class="fas fa-user-graduate"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <h3>Kelas Terdaftar</h3>
            <p>{{ $stats['total_kelas'] }}</p>
        </div>
        <div class="stat-icon" style="background-color: rgba(14, 165, 233, 0.1); color: #0EA5E9;">
            <i class="fas fa-school"></i>
        </div>
    </div>
</div>

<div class="dashboard-grid" style="grid-template-columns: repeat(3, 1fr);">
    <div class="stat-card">
        <div class="stat-info">
            <h3>Jadwal Pembelajaran</h3>
            <p>{{ $stats['total_jadwal'] }}</p>
        </div>
        <div class="stat-icon" style="background-color: rgba(139, 92, 246, 0.1); color: #8B5CF6;">
            <i class="fas fa-calendar-alt"></i>
        </div>
    </div>

    <div class="stat-card warning">
        <div class="stat-info">
            <h3>Total Pertemuan</h3>
            <p>{{ $stats['total_kegiatan'] }}</p>
        </div>
        <div class="stat-icon">
            <i class="fas fa-tasks"></i>
        </div>
    </div>

    <div class="stat-card success">
        <div class="stat-info">
            <h3>Selesai Terlaksana</h3>
            <p>{{ $stats['total_kegiatan_selesai'] }}</p>
        </div>
        <div class="stat-icon">
            <i class="fas fa-check-double"></i>
        </div>
    </div>
</div>

<!-- Monitoring Table -->
<div class="card">
    <div class="card-header">
        <div class="card-title"><i class="fas fa-desktop"></i> Monitoring Kegiatan Belajar Mengajar Terbaru</div>
        <a href="{{ route('kaprodi.kegiatan') }}" class="btn btn-primary btn-sm">Monitoring Lengkap</a>
    </div>
    <div class="card-body">
        @if($kegiatanMonitoring->isEmpty())
            <p class="text-muted text-center py-4">Belum ada kegiatan belajar mengajar yang terlaksana.</p>
        @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kelas</th>
                            <th>Mata Kuliah</th>
                            <th>Dosen</th>
                            <th>Pertemuan Ke</th>
                            <th>Materi</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kegiatanMonitoring as $kegiatan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d-m-Y') }}</td>
                                <td><strong>{{ $kegiatan->jadwalPembelajaran->kelas->nama_kelas }}</strong></td>
                                <td>{{ $kegiatan->jadwalPembelajaran->mataKuliah->nama_mk }}</td>
                                <td>{{ $kegiatan->jadwalPembelajaran->dosen->nama }}</td>
                                <td class="text-center"><strong>{{ $kegiatan->pertemuan_ke }}</strong></td>
                                <td>{{ Str::limit($kegiatan->materi, 35) }}</td>
                                <td>
                                    @if($kegiatan->status === 'selesai')
                                        <span class="badge badge-success">Selesai</span>
                                    @elseif($kegiatan->status === 'berlangsung')
                                        <span class="badge badge-warning">Berlangsung</span>
                                    @else
                                        <span class="badge badge-primary">Terjadwal</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
