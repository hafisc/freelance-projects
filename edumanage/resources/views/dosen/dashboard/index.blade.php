@extends('layouts.dosen')

@section('title', 'Dashboard Dosen')

@section('content')
<div class="content-header">
    <div class="content-title">Dashboard Dosen</div>
</div>

<!-- Profil Dosen & Statistik Grid -->
<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px; margin-bottom: 32px;">
    <!-- Profil Card -->
    <div class="card" style="margin-bottom: 0;">
        <div class="card-header">
            <div class="card-title"><i class="fas fa-id-card"></i> Profil Dosen</div>
        </div>
        <div class="card-body">
            @if(isset($dosen))
                <div style="text-align: center; margin-bottom: 20px;">
                    <div style="width: 80px; height: 80px; border-radius: 50%; background-color: rgba(37, 99, 235, 0.1); color: var(--primary); display: inline-flex; align-items: center; justify-content: center; border: 2px solid var(--border); overflow: hidden; padding: 0;">
                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ urlencode($dosen->nama) }}" alt="Avatar Dosen" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <h3 style="font-size: 16px; font-weight: 700; margin-top: 12px; color: var(--text);">{{ $dosen->nama }}</h3>
                    <p class="text-muted" style="font-size: 13px;">NIDN: {{ $dosen->nidn }}</p>
                </div>
                <div style="border-top: 1px solid var(--border); padding-top: 16px; font-size: 13px; display: flex; flex-direction: column; gap: 10px;">
                    <div><strong>Jenis Kelamin:</strong><br><span class="text-muted">{{ $dosen->jenis_kelamin }}</span></div>
                    <div><strong>Nomor Handphone:</strong><br><span class="text-muted">{{ $dosen->no_hp ?? '-' }}</span></div>
                    <div><strong>Alamat:</strong><br><span class="text-muted">{{ $dosen->alamat ?? '-' }}</span></div>
                </div>
            @else
                <p class="text-danger">Profil Anda belum diisi. Hubungi admin.</p>
            @endif
        </div>
    </div>

    <!-- Statistik & Kegiatan Terbaru -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        <!-- Stat Grid Inner -->
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;">
            <div class="stat-card">
                <div class="stat-info">
                    <h3>Jadwal Mengajar</h3>
                    <p>{{ $stats['total_jadwal'] }}</p>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
            
            <div class="stat-card warning">
                <div class="stat-info">
                    <h3>Kegiatan Belajar</h3>
                    <p>{{ $stats['total_kegiatan'] }}</p>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-clipboard-list"></i>
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

        <!-- Jadwal Mengajar Card -->
        <div class="card" style="margin-bottom: 0; flex: 1;">
            <div class="card-header">
                <div class="card-title"><i class="fas fa-calendar-day"></i> Jadwal Mengajar Hari Ini & Mendatang</div>
                <a href="{{ route('dosen.jadwal') }}" class="btn btn-secondary btn-sm">Lihat Semua</a>
            </div>
            <div class="card-body">
                @if($jadwals->isEmpty())
                    <p class="text-muted text-center py-4">Tidak ada jadwal mengajar yang terdaftar.</p>
                @else
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Hari</th>
                                    <th>Waktu</th>
                                    <th>Kelas</th>
                                    <th>Mata Kuliah</th>
                                    <th>Ruangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jadwals as $jadwal)
                                    <tr>
                                        <td><strong>{{ $jadwal->hari }}</strong></td>
                                        <td>{{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}</td>
                                        <td><strong>{{ $jadwal->kelas->nama_kelas }}</strong></td>
                                        <td>{{ $jadwal->mataKuliah->nama_mk }}</td>
                                        <td><span class="badge badge-primary">{{ $jadwal->ruangan }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Kegiatan Pembelajaran Dosen -->
<div class="card">
    <div class="card-header">
        <div class="card-title"><i class="fas fa-tasks"></i> Aktivitas Pembelajaran Terbaru</div>
        <a href="{{ route('dosen.kegiatan') }}" class="btn btn-primary btn-sm">Kelola Kegiatan</a>
    </div>
    <div class="card-body">
        @if($latestKegiatan->isEmpty())
            <p class="text-muted text-center py-4">Belum ada kegiatan pembelajaran yang tercatat.</p>
        @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Pertemuan Ke</th>
                            <th>Tanggal</th>
                            <th>Kelas</th>
                            <th>Mata Kuliah</th>
                            <th>Materi</th>
                            <th>Metode</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($latestKegiatan as $kegiatan)
                            <tr>
                                <td class="text-center"><strong>{{ $kegiatan->pertemuan_ke }}</strong></td>
                                <td>{{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d-m-Y') }}</td>
                                <td><strong>{{ $kegiatan->jadwalPembelajaran->kelas->nama_kelas }}</strong></td>
                                <td>{{ $kegiatan->jadwalPembelajaran->mataKuliah->nama_mk }}</td>
                                <td>{{ Str::limit($kegiatan->materi, 40) }}</td>
                                <td>{{ $kegiatan->metode_pembelajaran }}</td>
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
