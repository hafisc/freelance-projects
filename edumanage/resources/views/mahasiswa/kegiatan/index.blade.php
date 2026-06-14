@extends('layouts.mahasiswa')

@section('title', 'Jurnal Perkuliahan')

@section('content')
<div class="content-header">
    <div class="content-title">Jurnal Kegiatan Belajar Kelas</div>
</div>

<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <div class="card-title">Jurnal Perkuliahan Kelas Anda (Kelas: {{ $kelas->nama_kelas ?? 'Belum terdaftar' }})</div>
        @if(isset($kelas))
            <span class="text-muted" style="font-size: 13px;">{{ $kelas->prodi }} - Angkatan {{ $kelas->angkatan }}</span>
        @endif
    </div>
    
    <div class="card-body">
        @if(!isset($kelas))
            <p class="text-danger text-center py-4">Kelas Anda belum dikonfigurasi. Hubungi admin.</p>
        @elseif($kegiatan->isEmpty())
            <p class="text-muted text-center py-4">Belum ada jurnal kegiatan pembelajaran terdaftar untuk kelas Anda saat ini.</p>
        @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Tanggal</th>
                            <th>Mata Kuliah</th>
                            <th>Dosen Pengampu</th>
                            <th style="width: 100px; text-align: center;">Pertemuan</th>
                            <th>Materi Pembelajaran</th>
                            <th>Status</th>
                            <th style="width: 120px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kegiatan as $kg)
                            <tr>
                                <td>{{ ($kegiatan->currentPage() - 1) * $kegiatan->perPage() + $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($kg->tanggal)->format('d-m-Y') }}</td>
                                <td><strong>{{ $kg->jadwalPembelajaran->mataKuliah->nama_mk }}</strong></td>
                                <td>{{ $kg->jadwalPembelajaran->dosen->nama }}</td>
                                <td class="text-center"><strong>Ke-{{ $kg->pertemuan_ke }}</strong></td>
                                <td>{{ Str::limit($kg->materi, 35) }}</td>
                                <td>
                                    @if($kg->status === 'selesai')
                                        <span class="badge badge-success">Selesai</span>
                                    @elseif($kg->status === 'berlangsung')
                                        <span class="badge badge-warning">Berlangsung</span>
                                    @else
                                        <span class="badge badge-primary">Terjadwal</span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <a href="{{ route('kegiatan-belajar.show', $kg->id) }}" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($kegiatan->hasPages())
                <div class="pagination-wrapper">
                    {{ $kegiatan->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
