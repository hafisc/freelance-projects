@extends('layouts.admin')

@section('title', 'Jadwal Pembelajaran')

@section('content')
<div class="content-header">
    <div class="content-title">Kelola Jadwal Pembelajaran</div>
    <a href="{{ route('jadwal-pembelajaran.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Jadwal
    </a>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Daftar Jadwal Kuliah</div>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>Hari</th>
                        <th>Waktu</th>
                        <th>Kelas</th>
                        <th>Mata Kuliah</th>
                        <th>Dosen Pengampu</th>
                        <th>Ruangan</th>
                        <th style="width: 180px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwal as $jd)
                        <tr>
                            <td>{{ ($jadwal->currentPage() - 1) * $jadwal->perPage() + $loop->iteration }}</td>
                            <td><strong>{{ $jd->hari }}</strong></td>
                            <td>{{ substr($jd->jam_mulai, 0, 5) }} - {{ substr($jd->jam_selesai, 0, 5) }}</td>
                            <td><span class="badge badge-success">{{ $jd->kelas->nama_kelas }}</span></td>
                            <td><strong>{{ $jd->mataKuliah->nama_mk }}</strong> ({{ $jd->mataKuliah->kode_mk }})</td>
                            <td>{{ $jd->dosen->nama }}</td>
                            <td><span class="badge badge-primary">{{ $jd->ruangan }}</span></td>
                            <td style="text-align: center;">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('jadwal-pembelajaran.edit', $jd->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    
                                    <form action="{{ route('jadwal-pembelajaran.destroy', $jd->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini? Semua kegiatan belajar terkait akan ikut terhapus.')">
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
                            <td colspan="8" class="text-muted text-center py-4">Belum ada data jadwal pembelajaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($jadwal->hasPages())
            <div class="pagination-wrapper">
                {{ $jadwal->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
