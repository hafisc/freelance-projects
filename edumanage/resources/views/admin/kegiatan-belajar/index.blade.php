@extends('layouts.admin')

@section('title', 'Kegiatan Belajar')

@section('content')
<div class="content-header">
    <div class="content-title">Kelola Kegiatan Belajar</div>
    <a href="{{ route('kegiatan-belajar.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Kegiatan
    </a>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Daftar Jurnal Kegiatan Belajar Mengajar</div>
    </div>
    
    <div class="card-body">
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
                        <th style="width: 220px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kegiatan as $kg)
                        <tr>
                            <td>{{ ($kegiatan->currentPage() - 1) * $kegiatan->perPage() + $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($kg->tanggal)->format('d-m-Y') }}</td>
                            <td><span class="badge badge-success">{{ $kg->jadwalPembelajaran->kelas->nama_kelas }}</span></td>
                            <td><strong>{{ $kg->jadwalPembelajaran->mataKuliah->nama_mk }}</strong></td>
                            <td>{{ $kg->jadwalPembelajaran->dosen->nama }}</td>
                            <td class="text-center"><strong>Ke-{{ $kg->pertemuan_ke }}</strong></td>
                            <td>{{ Str::limit($kg->materi, 30) }}</td>
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
                                    <a href="{{ route('kegiatan-belajar.edit', $kg->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('kegiatan-belajar.destroy', $kg->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jurnal kegiatan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-muted text-center py-4">Belum ada jurnal kegiatan pembelajaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($kegiatan->hasPages())
            <div class="pagination-wrapper">
                {{ $kegiatan->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
