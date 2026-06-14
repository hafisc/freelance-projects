@extends('layouts.dosen')

@section('title', 'Jurnal Mengajar')

@section('content')
<div class="content-header">
    <div class="content-title">Jurnal Kegiatan Mengajar</div>
    <a href="{{ route('dosen.kegiatan.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Isi Jurnal Baru
    </a>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Daftar Jurnal Pembelajaran Anda (Dosen: {{ $dosen->nama }})</div>
    </div>
    
    <div class="card-body">
        @if($kegiatan->isEmpty())
            <p class="text-muted text-center py-4">Belum ada jurnal perkuliahan yang Anda isi saat ini.</p>
        @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Tanggal</th>
                            <th>Kelas</th>
                            <th>Mata Kuliah</th>
                            <th style="width: 100px; text-align: center;">Pertemuan</th>
                            <th>Materi Pembelajaran</th>
                            <th>Metode</th>
                            <th>Status</th>
                            <th style="width: 220px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kegiatan as $kg)
                            <tr>
                                <td>{{ ($kegiatan->currentPage() - 1) * $kegiatan->perPage() + $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($kg->tanggal)->format('d-m-Y') }}</td>
                                <td><span class="badge badge-success">{{ $kg->jadwalPembelajaran->kelas->nama_kelas }}</span></td>
                                <td><strong>{{ $kg->jadwalPembelajaran->mataKuliah->nama_mk }}</strong></td>
                                <td class="text-center"><strong>Ke-{{ $kg->pertemuan_ke }}</strong></td>
                                <td>{{ Str::limit($kg->materi, 30) }}</td>
                                <td>{{ $kg->metode_pembelajaran }}</td>
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
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('kegiatan-belajar.show', $kg->id) }}" class="btn btn-secondary btn-sm" title="Detail Kegiatan">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                        <a href="{{ route('dosen.kegiatan.edit', $kg->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </div>
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
