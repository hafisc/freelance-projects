@extends('layouts.kaprodi')

@section('title', 'Monitoring Kegiatan')

@section('content')
<div class="content-header">
    <div class="content-title">Monitoring Kegiatan Pembelajaran</div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Jurnal Kegiatan Belajar Mengajar Global</div>
    </div>
    
    <div class="card-body">
        @if($kegiatan->isEmpty())
            <p class="text-muted text-center py-4">Belum ada jurnal perkuliahan yang tercatat.</p>
        @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Tanggal</th>
                            <th>Kelas</th>
                            <th>Mata Kuliah</th>
                            <th>Dosen</th>
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
                                <td><span class="badge badge-success">{{ $kg->jadwalPembelajaran->kelas->nama_kelas }}</span></td>
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
