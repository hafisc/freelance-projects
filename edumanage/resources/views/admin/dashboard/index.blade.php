@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="content-header">
    <div class="content-title">Dashboard Admin</div>
</div>

<!-- Statistik Grid -->
<div class="dashboard-grid">
    <div class="stat-card">
        <div class="stat-info">
            <h3>Total User</h3>
            <p>{{ $stats['total_users'] }}</p>
        </div>
        <div class="stat-icon">
            <i class="fas fa-users"></i>
        </div>
    </div>

    <div class="stat-card success">
        <div class="stat-info">
            <h3>Dosen</h3>
            <p>{{ $stats['total_dosen'] }}</p>
        </div>
        <div class="stat-icon">
            <i class="fas fa-chalkboard-teacher"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <h3>Mahasiswa</h3>
            <p>{{ $stats['total_mahasiswa'] }}</p>
        </div>
        <div class="stat-icon">
            <i class="fas fa-user-graduate"></i>
        </div>
    </div>

    <div class="stat-card warning">
        <div class="stat-info">
            <h3>Mata Kuliah</h3>
            <p>{{ $stats['total_mata_kuliah'] }}</p>
        </div>
        <div class="stat-icon">
            <i class="fas fa-book"></i>
        </div>
    </div>
</div>

<div class="dashboard-grid" style="grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));">
    <div class="stat-card">
        <div class="stat-info">
            <h3>Total Kelas</h3>
            <p>{{ $stats['total_kelas'] }}</p>
        </div>
        <div class="stat-icon" style="background-color: rgba(14, 165, 233, 0.1); color: #0EA5E9;">
            <i class="fas fa-school"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <h3>Jadwal Belajar</h3>
            <p>{{ $stats['total_jadwal'] }}</p>
        </div>
        <div class="stat-icon" style="background-color: rgba(139, 92, 246, 0.1); color: #8B5CF6;">
            <i class="fas fa-calendar-alt"></i>
        </div>
    </div>

    <div class="stat-card success">
        <div class="stat-info">
            <h3>Pertemuan Kegiatan</h3>
            <p>{{ $stats['total_kegiatan'] }}</p>
        </div>
        <div class="stat-icon">
            <i class="fas fa-tasks"></i>
        </div>
    </div>
</div>

<!-- Kegiatan Terbaru -->
<div class="card">
    <div class="card-header">
        <div class="card-title"><i class="fas fa-clock"></i> Kegiatan Pembelajaran Terbaru</div>
        <a href="{{ route('kegiatan-belajar.index') }}" class="btn btn-primary btn-sm">Lihat Semua</a>
    </div>
    <div class="card-body">
        @if($latestKegiatan->isEmpty())
            <p class="text-muted text-center py-4">Belum ada kegiatan belajar yang tercatat saat ini.</p>
        @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kelas</th>
                            <th>Mata Kuliah</th>
                            <th>Pertemuan Ke</th>
                            <th>Materi</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($latestKegiatan as $kegiatan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d-m-Y') }}</td>
                                <td><strong>{{ $kegiatan->jadwalPembelajaran->kelas->nama_kelas }}</strong></td>
                                <td>{{ $kegiatan->jadwalPembelajaran->mataKuliah->nama_mk }}</td>
                                <td class="text-center">{{ $kegiatan->pertemuan_ke }}</td>
                                <td>{{ Str::limit($kegiatan->materi, 40) }}</td>
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
